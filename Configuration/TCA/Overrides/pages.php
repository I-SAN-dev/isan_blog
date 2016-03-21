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
			'size' => 3,
			'autoSizeMax' => 30,
			'maxitems' => 9999,
			'multiple' => 1,
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
			'multiple' => 1,
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
	'crdate'  => array (
		'exclude' => 1,
		'label' => 'Creation date',
		'config' => Array (
			'type' => 'none',
			'format' => 'date',
			'eval' => 'date',
		)
	)
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

//--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.standard;standard,
//					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.title;title, doktype,
//				--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.access,
//					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.visibility;visibility,
//					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.access;access,
//				--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.metadata,
//					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.abstract;abstract,
//					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.metatags;metatags,
//					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.editorial;editorial,
//				--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.appearance,
//					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.layout;layout, tx_themes_icon,
//					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.replace;replace,
//				--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.behaviour,
//					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.links;links,
//					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.caching;caching,
//					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.language;language,
//					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.miscellaneous;miscellaneous,
//					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.module;module,
//				--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.resources,
//					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.media;media,
//					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.config;config,
//				--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.extended, --div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category, categories


// $GLOBALS['TCA']['pages']['types'][$blogDoktype]['showitem'] .= ',--div--;LLL:EXT:isan_blog/Resources/Private/Language/locallang_db.xlf:tx_isanblog_domain_model_blogpost,';
// $GLOBALS['TCA']['pages']['types'][$blogDoktype]['showitem'] .= 'author, tags';


$GLOBALS['TCA']['pages']['types'][$blogDoktype]['showitem'] = '
--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.standard;standard,
					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.title;title, author,
					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.abstract;abstract,
				--div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category, categories, tags,
				--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.metadata,
					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.metatags;metatags,
				--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.resources,
					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.media;media,
				--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.appearance,
					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.layout;layout,
					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.replace;replace,
				--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.access,
					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.visibility;visibility,
					--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.access;access,
				--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.extended,
';


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
	'',
	'EXT:/Resources/Private/Language/locallang_csh_.xlf'
);