<?php

namespace Isan\IsanBlog\Hooks;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;


/**
 * AutoConfiguration-Hook for RealURL
 *
 * @package TYPO3
 * @subpackage isan_blog
 */
class RealUrlAutoConfiguration {

    /**
     * Generates additional RealURL configuration and merges it with provided configuration
     *
     * @param       array $params Default configuration
     * @return      array Updated configuration
     */
    public function addIsanBlogConfig($params) {

        return array_merge_recursive($params['config'], array(
                'postVarSets' => array(
                    '_DEFAULT' => array(
                        'removeUnnecessary' => array(
                            array(
                                'GETvar' => 'tx_isanblog_blog[action]',
                                'noMatch' => 'bypass',
                            ),
                            array(
                                'GETvar' => 'tx_isanblog_blog[controller]',
                                'noMatch' => 'bypass',
                            ),
                            array(
                                'GETvar' => 'tx_isanblog_author[action]',
                                'noMatch' => 'bypass',
                            ),
                            array(
                                'GETvar' => 'tx_isanblog_author[controller]',
                                'noMatch' => 'bypass',
                            ),
                        ),
                        'author' => array(
                            array(
                                'GETvar' => 'tx_isanblog_blog[author]',
                                'lookUpTable' => array(
                                    'table' => 'tx_isanblog_domain_model_author',
                                    'id_field' => 'uid',
                                    'alias_field' => "name",
                                    'useUniqueCache' => 1,
                                    'useUniqueCache_conf' => array(
                                        'strtolower' => 1,
                                        'spaceCharacter' => '-',
                                    ),
                                ),
                            ),
                        ),
                        'page' => array(
                            array(
                                'GETvar' => 'tx_isanblog_blog[@widget_0][currentPage]',
                            ),
                        ),
                    )
                )
            )
        );
    }
}