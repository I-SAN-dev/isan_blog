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
     * @return mixed
     */
    public function findAllPaginated($page = 0, $perPage = 10)
    {
        $query = $this->createQuery();
        $query->statement("
            SELECT DISTINCT *
            FROM pages
        ");

        return $query->execute();
    }

    /**
     * Find by multiple categories, seperated string.
     *
     * @param string String containing category ids
     * @return \Crea\CreaPersonsdir\Domain\Model\Person
     */
    public function findByCategories($uids) {
        if(is_string($uids) && strlen($uids) > 0)
        {
            $query = $this->createQuery();
            $query->statement("
                SELECT DISTINCT *
                FROM tx_creapersonsdir_domain_model_person
                INNER JOIN sys_category_record_mm ON tx_creapersonsdir_domain_model_person.uid=sys_category_record_mm.uid_foreign
                WHERE sys_category_record_mm.tablenames = 'tx_creapersonsdir_domain_model_person'
                AND sys_category_record_mm.uid_local IN (".$uids.")
                AND tx_creapersonsdir_domain_model_person.hidden = 0
                AND tx_creapersonsdir_domain_model_person.deleted = 0
                GROUP BY tx_creapersonsdir_domain_model_person.uid
                ORDER BY tx_creapersonsdir_domain_model_person.sorting ASC
            ");
            return $query->execute();
        }
        else
        {
            return NULL;
        }
    }
}