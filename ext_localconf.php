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
