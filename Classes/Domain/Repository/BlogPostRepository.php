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
     * Finds Blog Posts paginated
     * @param int $page
     * @param int $perPage
     * @param string $additionalWhere
     * @param string $additionalFrom
     * @return mixed
     */
    public function findAllPaginated($page = 0, $perPage = 10, $additionalWhere = '', $additionalFrom = '')
    {
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
            ORDER BY
              CASE WHEN pages.starttime = 0 THEN pages.crdate ELSE pages.starttime END DESC
            LIMIT " . $perPage . "
            OFFSET " . $page*$perPage . "
        ");

        $results = $query->execute()->toArray();

        // attach images
        $fileRepository = $this->objectManager->get('TYPO3\CMS\Core\Resource\FileRepository');
        foreach ($results as &$result) {
            //var_dump($result);

            $result->setImages($fileRepository->findByRelation('pages', 'media', $result->getUid()));
        }

        return $results;
    }
}