<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Isan.' . $_EXTKEY,
	'Blog',
	array(
		'BlogPost' => 'list',
		
	),
	// non-cacheable actions
	array(
		'BlogPost' => 'list',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Isan.' . $_EXTKEY,
	'Author',
	array(
		'Author' => 'list, show',
		
	),
	// non-cacheable actions
	array(
		'BlogPost' => '',
		'Author' => '',
		
	)
);

// RealUrl autoconf
if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('realurl')) {
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['isan_blog'] =
		'Isan\\IsanBlog\\Hooks\\RealUrlAutoConfiguration->addIsanBlogConfig';
}

// Prevent cHash Errors
// due to the whole lot possible param combinations for our filters, realurls cached chashes often fail.
// If so, simply load the page withput using a cache.
$TYPO3_CONF_VARS['FE']['pageNotFoundOnCHashError'] = 0;