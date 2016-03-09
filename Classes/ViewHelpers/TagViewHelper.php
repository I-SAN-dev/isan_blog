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
 * This ViewHelper returns the tags of a page
 *
 * = Examples =
 *
 * <code title="Return blog post tags">
 * <f:for each="{blog:tag}" as="tag">
 *  ...
 * </f:for>
 * </code>
 * <output>
 * Loop over every tag of the given blogpost
 * </output>
 *
 *
 */
class TagViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
    * @var Isan\IsanBlog\Domain\Repository\TagRepository
    * @inject
    */
    protected $tagRepository;

    /**
     * Returns the tags of a page
     *
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     * @return array
     */
    public function render()
    {
        return $this->tagRepository->findByPage($GLOBALS['TSFE']->id)->toArray();
    }
}
