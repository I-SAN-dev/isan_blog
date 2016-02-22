<?php

if (!isset($GLOBALS['TCA']['pages']['ctrl']['type'])) {
	if (file_exists($GLOBALS['TCA']['pages']['ctrl']['dynamicConfigFile'])) {
		require_once($GLOBALS['TCA']['pages']['ctrl']['dynamicConfigFile']);
	}
	// no type field defined, so we define it here. This will only happen the first time the extension is installed!!
	$GLOBALS['TCA']['pages']['ctrl']['type'] = 'tx_extbase_type';
	$tempColumnstx_isanblog_pages = array();
	$tempColumnstx_isanblog_pages[$GLOBALS['TCA']['pages']['ctrl']['type']] = array(
		'exclude' => 1,
		'label'   => 'LLL:EXT:isan_blog/Resources/Private/Language/locallang_db.xlf:tx_isanblog.tx_extbase_type',
		'config' => array(
			'type' => 'select',
			'renderType' => 'selectSingle',
			'items' => array(
				array('BlogPost','Tx_IsanBlog_BlogPost')
			),
			'default' => 'Tx_IsanBlog_BlogPost',
			'size' => 1,
			'maxitems' => 1,
		)
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $tempColumnstx_isanblog_pages, 1);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'pages',
	$GLOBALS['TCA']['pages']['ctrl']['type'],
	'',
	'after:' . $GLOBALS['TCA']['pages']['ctrl']['label']
);

$tmp_isan_blog_columns = array(

	'author' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:isan_blog/Resources/Private/Language/locallang_db.xlf:tx_isanblog_domain_model_blogpost.author',
		'config' => array(
			'type' => 'select',
			'renderType' => 'selectMultipleSideBySide',
			'foreign_table' => 'tx_isanblog_domain_model_author',
			'MM' => 'tx_isanblog_blogpost_author_mm',
			'size' => 10,
			'autoSizeMax' => 30,
			'maxitems' => 9999,
			'multiple' => 0,
			'wizards' => array(
				'_PADDING' => 1,
				'_VERTICAL' => 1,
				'edit' => array(
					'module' => array(
						'name' => 'wizard_edit',
					),
					'type' => 'popup',
					'title' => 'Edit',
					'icon' => 'edit2.gif',
					'popup_onlyOpenIfSelected' => 1,
					'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
					),
				'add' => Array(
					'module' => array(
						'name' => 'wizard_add',
					),
					'type' => 'script',
					'title' => 'Create new',
					'icon' => 'add.gif',
					'params' => array(
						'table' => 'tx_isanblog_domain_model_author',
						'pid' => '###CURRENT_PID###',
						'setValue' => 'prepend'
					),
				),
			),
		),
	),
	'tags' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:isan_blog/Resources/Private/Language/locallang_db.xlf:tx_isanblog_domain_model_blogpost.tags',
		'config' => array(
			'type' => 'select',
			'renderType' => 'selectMultipleSideBySide',
			'foreign_table' => 'tx_isanblog_domain_model_tag',
			'MM' => 'tx_isanblog_blogpost_tag_mm',
			'size' => 10,
			'autoSizeMax' => 30,
			'maxitems' => 9999,
			'multiple' => 0,
			'wizards' => array(
				'_PADDING' => 1,
				'_VERTICAL' => 1,
				'edit' => array(
					'module' => array(
						'name' => 'wizard_edit',
					),
					'type' => 'popup',
					'title' => 'Edit',
					'icon' => 'edit2.gif',
					'popup_onlyOpenIfSelected' => 1,
					'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
					),
				'add' => Array(
					'module' => array(
						'name' => 'wizard_add',
					),
					'type' => 'script',
					'title' => 'Create new',
					'icon' => 'add.gif',
					'params' => array(
						'table' => 'tx_isanblog_domain_model_tag',
						'pid' => '###CURRENT_PID###',
						'setValue' => 'prepend'
					),
				),
			),
		),
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages',$tmp_isan_blog_columns);


// Add Page Type Icon
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

		// Add icon for new page type:
		\TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule(
			$GLOBALS['TCA']['pages'],
			[
				'ctrl' => [
					'typeicon_classes' => [
						$blogDoktype => 'apps-pagetree-blog',
					],
				],
			]
		);
	},
	'isan_blog',
	'pages'
);


/* inherit and extend the show items from the parent class */
$blogDoktype = 116;
if(isset($GLOBALS['TCA']['pages']['types']['1']['showitem'])) {
	$GLOBALS['TCA']['pages']['types'][$blogDoktype]['showitem'] = $GLOBALS['TCA']['pages']['types']['1']['showitem'];
} elseif(is_array($GLOBALS['TCA']['pages']['types'])) {
	// use first entry in types array
	$pages_type_definition = reset($GLOBALS['TCA']['pages']['types']);
	$GLOBALS['TCA']['pages']['types'][$blogDoktype]['showitem'] = $pages_type_definition['showitem'];
} else {
	$GLOBALS['TCA']['pages']['types'][$blogDoktype]['showitem'] = '';
}
$GLOBALS['TCA']['pages']['types'][$blogDoktype]['showitem'] .= ',--div--;LLL:EXT:isan_blog/Resources/Private/Language/locallang_db.xlf:tx_isanblog_domain_model_blogpost,';
$GLOBALS['TCA']['pages']['types'][$blogDoktype]['showitem'] .= 'author, tags';

$GLOBALS['TCA']['pages']['columns'][$GLOBALS['TCA']['pages']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:isan_blog/Resources/Private/Language/locallang_db.xlf:pages.tx_extbase_type.Tx_IsanBlog_BlogPost','Tx_IsanBlog_BlogPost');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
	'',
	'EXT:/Resources/Private/Language/locallang_csh_.xlf'
);