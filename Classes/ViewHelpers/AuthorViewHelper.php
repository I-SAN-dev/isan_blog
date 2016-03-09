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
 * This ViewHelper returns authors of a page
 *
 * = Examples =
 *
 * <code title="Return blog post authors">
 * <f:for each="{blog:author}" as="author">
 *  ...
 * </f:for>
 * </code>
 * <output>
 * Loop over every author of the given blogpost
 * </output>
 *
 *
 */
class AuthorViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
    * @var Isan\IsanBlog\Domain\Repository\AuthorRepository
    * @inject
    */
    protected $authorRepository;

    /**
     * Returns the author(s) of a page
     *
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     * @return array
     */
    public function render()
    {
        return $this->authorRepository->findByPage($GLOBALS['TSFE']->id)->toArray();
    }
}
