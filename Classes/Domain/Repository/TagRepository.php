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
 * The repository for Tags
 */
class TagRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * Find by given page.
     *
     * @param int $pid
     * @return Isan\IsanBlog\Domain\Model\Tag
     */
    public function findByPage($pid) {
        $query = $this->createQuery();
        $query->statement('
            SELECT DISTINCT *
            FROM tx_isanblog_domain_model_tag
            INNER JOIN tx_isanblog_blogpost_tag_mm ON tx_isanblog_domain_model_tag.uid=tx_isanblog_blogpost_tag_mm.uid_foreign
            WHERE tx_isanblog_blogpost_tag_mm.uid_local = '. $pid .'
            AND tx_isanblog_domain_model_tag.hidden = 0
            AND tx_isanblog_domain_model_tag.deleted = 0
            GROUP BY tx_isanblog_domain_model_tag.uid
            ORDER BY tx_isanblog_blogpost_tag_mm.sorting ASC
        ');
        return $query->execute();
    }
}