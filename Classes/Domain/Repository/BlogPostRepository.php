<?php
namespace Isan\IsanBlog\Domain\Repository;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Sebastian Antosch <s.antosch@i-san.de>, I-SAN.de Webdesign & Hosting GbR
 *           Christian Baur <c.baur@i-san.de>, I-SAN.de Webdesign & Hosting GbR
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * The repository for BlogPosts
 */
class BlogPostRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * Finds Blog Posts
     * @param string $additionalWhere
     * @param string $additionalFrom
     * @param int $limit
     * @return mixed
     */
    public function findAll($additionalWhere = '', $additionalFrom = '', $limit = 0)
    {
        $limit = $limit > 0 ? 'LIMIT ' . intval($limit) : '';

        $query = $this->createQuery();
        $query->statement("
            SELECT DISTINCT *
            FROM pages " . $additionalFrom . "
            WHERE pages.doktype = 116
            AND pages.hidden = 0
            AND pages.deleted = 0
            AND pages.starttime < " . time() . "
            AND (pages.endtime = 0 OR pages.endtime > " . time() . ")
            " . $additionalWhere . "
            GROUP BY pages.uid
            ORDER BY
              CASE WHEN pages.starttime = 0 THEN pages.crdate ELSE pages.starttime END DESC
            " . $limit . "
        ");

        $results = $query->execute()->toArray();

        // attach images
        $fileRepository = $this->objectManager->get('TYPO3\CMS\Core\Resource\FileRepository');
        foreach ($results as &$result) {
            $result->setImages($fileRepository->findByRelation('pages', 'media', $result->getUid()));
        }

        return $results;
    }

    /**
     * Finds BlogPosts filtered
     * @param \Isan\IsanBlog\Domain\Model\Author $author
     * @param \Isan\IsanBlog\Domain\Model\Tag $tag
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category
     * @param int $limit
     * @return mixed
     */
    public function findAllFiltered($author = NULL, $tag = NULL, $category = NULL, $limit = 0)
    {
        $from = "";
        $where = "";

        // Only show special author
        if($author) {
            $from = $from . "
                INNER JOIN tx_isanblog_blogpost_author_mm ON pages.uid=tx_isanblog_blogpost_author_mm.uid_local
            ";
            $where = $where . "
                AND tx_isanblog_blogpost_author_mm.uid_foreign = " . $author->getUid() . "
            ";
        }

        // Only show special category
        if($category) {
            $from = $from . "
                INNER JOIN sys_category_record_mm ON pages.uid=sys_category_record_mm.uid_foreign
            ";
            $where = $where . "
                AND sys_category_record_mm.tablenames = 'pages'
                AND sys_category_record_mm.uid_local = " . $category->getUid() . "
            ";
        }

        // Only show special tag
        if($tag) {
            $from = $from . "
                INNER JOIN tx_isanblog_blogpost_tag_mm ON pages.uid=tx_isanblog_blogpost_tag_mm.uid_local
            ";
            $where = $where . "
                AND tx_isanblog_blogpost_tag_mm.uid_foreign = " . $tag->getUid() . "
            ";
        }

        return $this->findAll($where, $from, $limit);
    }

    /**
     * Returns all blog posts that belong to one of the given categories
     * @param string $categories
     * @param int $limit
     * @return mixed
     */
    public function findByCategories($categories, $limit = 0)
    {
        $from =     "INNER JOIN sys_category_record_mm ON pages.uid=sys_category_record_mm.uid_foreign";
        $where =    "AND sys_category_record_mm.tablenames = 'pages'
                     AND sys_category_record_mm.uid_local IN (" . $categories . ")";

        return $this->findAll($where, $from ,$limit);
    }

    /**
     * Returns all blog posts that are tagged with given tags
     * @param string $tags
     * @param int $limit
     * @return mixed
     */
    public function findByTags($tags, $limit = 0)
    {
        $from =     "INNER JOIN tx_isanblog_blogpost_tag_mm ON pages.uid=tx_isanblog_blogpost_tag_mm.uid_local";
        $where =    "AND tx_isanblog_blogpost_tag_mm.uid_foreign IN (" . $tags . ")";

        return $this->findAll($where, $from ,$limit);
    }

    /**
     * Returns all blog posts that are written by given authors
     * @param string $authors
     * @param int $limit
     * @return mixed
     */
    public function findByAuthors($authors, $limit = 0)
    {
        $from =     "INNER JOIN tx_isanblog_blogpost_author_mm ON pages.uid=tx_isanblog_blogpost_author_mm.uid_local";
        $where =    "AND tx_isanblog_blogpost_author_mm.uid_foreign IN (" . $authors . ")";

        return $this->findAll($where, $from ,$limit);
    }
}