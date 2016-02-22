<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Isan.' . $_EXTKEY,
	'Blog',
	'Blog Liste und Detail'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Isan.' . $_EXTKEY,
	'Author',
	'Author Overview'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'I-SAN Blog');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_isanblog_domain_model_author', 'EXT:isan_blog/Resources/Private/Language/locallang_csh_tx_isanblog_domain_model_author.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_isanblog_domain_model_author');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_isanblog_domain_model_tag', 'EXT:isan_blog/Resources/Private/Language/locallang_csh_tx_isanblog_domain_model_tag.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_isanblog_domain_model_tag');


// Add page type
call_user_func(
	function ($extKey) {
		$blogDoktype = 116;

		// Add new page type:
		$GLOBALS['PAGES_TYPES'][$blogDoktype] = [
			'type' => 'web',
			'allowedTables' => '*',
		];

		// Provide icon for page tree, list view, ... :
		\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class)
			->registerIcon(
				'apps-pagetree-blog',
				TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
				[
					'source' => 'EXT:' . $extKey . '/ext_icon.gif',
				]
			);

		// Allow backend users to drag and drop the new page type:
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig(
			'options.pageTree.doktypesToShowInNewPageDragArea := addToList(' . $blogDoktype . ')'
		);
	},
	$_EXTKEY
);