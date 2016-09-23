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
use Isan\IsanBlog\Domain\Model\Author;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Metaseo\Metaseo\Connector;

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
        $authors = $this->authorRepository->findByPage($GLOBALS['TSFE']->id)->toArray();

        // meta tag integration with metaseo
        if (class_exists('Metaseo\Metaseo\Connector')) {
            try {
                if (count($authors) > 0) {
                    /** @var Connector $metaseoConnector */
                    $metaseoConnector = GeneralUtility::makeInstance(Connector::class);
                    $names = [];
                    /** @var Author $author */
                    foreach ($authors as $author) {
                        $names[] = $author->getName();
                    }
                    $metaseoConnector->setMetaTag('author', implode($names, ', '));
                }
            } catch (\Exception $e) {
                // Bad style, but this happens if some third party thingy is messed up. We don't care.
            }
        }

        return $authors;
    }
}
