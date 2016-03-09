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
 * This ViewHelper returns the createdate, or if set, the publish date of a page
 *
 * = Examples =
 *
 * <code title="Return file categories">
 * <blog:date format="d.m.Y H:i" />
 * </code>
 * <output>
 * Loop over every category of the given file
 * </output>
 *
 *
 */
class DateViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * Returns the blog date/time
     *
     * @param string $format
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     * @return string
     */
    public function render($format)
    {
        $time = $GLOBALS['TSFE']->page['crdate'];
        $starttime = $GLOBALS['TSFE']->page['starttime'];

        if($starttime && $starttime != '') {
            $time = $starttime;
        }

        return date($format, $time);
    }
}
