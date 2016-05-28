<?php
namespace Isan\IsanBlog\ViewHelpers;

    /*                                                                        *
     * This script is part of the TYPO3 project - inspiring people to share!  *
     *                                                                        *
     * TYPO3 is free software; you can redistribute it and/or modify it under *
     * the terms of the GNU General Public License version 2 as published by  *
     * the Free Software Foundation.                                          *
     *                                                                        *
     * This script is distributed in the hope that it will be useful, but     *
     * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
     * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
     * Public License for more details.                                       *
     *                                                                        */
/**
 * This ViewHelper returns all categories of a given file.
 *
 * = Examples =
 *
 * <code title="Return page categories">
 * <f:for each="{blog:categories}" as="value">
 *  ...
 * </f:for>
 * </code>
 * <output>
 * Loop over every category of the given page
 * </output>
 *
 *
 */
class CategoriesViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * @var \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository;

    /**
     * Returns the categories of the page
     *
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     * @return array
     */
    public function render()
    {
        $query = $this->categoryRepository->createQuery();

        $query->statement("
            SELECT DISTINCT *
            FROM sys_category
            INNER JOIN sys_category_record_mm ON sys_category_record_mm.uid_local=sys_category.uid
            WHERE sys_category_record_mm.tablenames = 'pages'
            AND sys_category_record_mm.uid_foreign = ".$GLOBALS['TSFE']->id."
            AND sys_category.hidden = 0
            AND sys_category.deleted = 0
            GROUP BY sys_category.uid
            ORDER BY sys_category.sorting ASC
        ");

        $result = $query->execute();
        return $result->toArray();
    }
}
