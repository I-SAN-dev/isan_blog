<?php
// Also add the new doktype to the page language overlays type selector (so that translations can inherit the same type)
call_user_func(
    function ($extKey, $table) {
        $extRelPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($extKey);
        $customPageIcon = $extRelPath . 'ext_icon.gif';
        $blogDoktype = 116;

        // Add new page type as possible select item:
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
            $table,
            'doktype',
            [
                'BlogPost',
                $blogDoktype,
                $customPageIcon
            ],
            '1',
            'after'
        );
    },
    'isan_blog',
    'pages_language_overlay'
);