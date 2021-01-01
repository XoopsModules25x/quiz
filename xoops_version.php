<?php

/**
 * ****************************************************************************
 * xquiz - MODULE FOR XOOPS
 * Copyright (c) Mojtaba Jamali of persian xoops project (http://www.irxoops.org/)
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright          XOOPS Project (https://xoops.org)
 * @license            http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package            xquiz
 * @author             Mojtaba Jamali(jamali.mojtaba@gmail.com)
 * @version            $Id$
 *
 * Version : $Id:
 * ****************************************************************************
 */
$moduleDirName      = basename(__DIR__);
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

// ------------------- Informations -------------------
$modversion = [
    'version'             => 2.00,
    'module_status'       => 'Alpha 1',
    'release_date'        => '2021/01/01',
    'name'                => _MI_XQUIZ_NAME,
    'description'         => _MI_XQUIZ_DESC,
    'official'            => 0,
    //1 indicates official XOOPS module supported by XOOPS Dev Team, 0 means 3rd party supported
    'author'              => 'Mojtaba Jamali, Mamba, Lio MJ',
    'credits'             => 'XOOPS Development Team',
    'author_mail'         => 'jamali.mojtaba@gmail.com',
    'author_website_url'  => 'https://xoops.org',
    'author_website_name' => 'XOOPS',
    'license'             => 'GPL 2.0 or later',
    'license_url'         => 'www.gnu.org/licenses/gpl-2.0.html/',
    //    'help'                => 'page=help',
    // ------------------- Folders & Files -------------------
    'release_info'        => 'Changelog',
    'release_file'        => XOOPS_URL . "/modules/$moduleDirName/docs/changelog.txt",
    'manual'              => 'link to manual file',
    'manual_file'         => XOOPS_URL . "/modules/$moduleDirName/docs/install.txt",
    // images
    'image'               => 'assets/images/logoModule.png',
    'iconsmall'           => 'assets/images/iconsmall.png',
    'iconbig'             => 'assets/images/iconbig.png',
    'dirname'             => $moduleDirName,
    // Local path icons
    'modicons16'          => 'assets/images/icons/16',
    'modicons32'          => 'assets/images/icons/32',
    'demo_site_url'       => 'https://xoops.org',
    'demo_site_name'      => 'XOOPS Demo Site',
    'support_url'         => 'https://xoops.org/modules/newbb/viewforum.php?forum=28/',
    'support_name'        => 'Support Forum',
    'submit_bug'          => 'https://github.com/XoopsModules25x/' . $moduleDirName . '/issues',
    'module_website_url'  => 'www.xoops.org',
    'module_website_name' => 'XOOPS Project',
    // ------------------- Min Requirements -------------------
    'min_php'             => '7.2',
    'min_xoops'           => '2.5.10',
    'min_admin'           => '1.2',
    'min_db'              => ['mysql' => '5.5'],
    // ------------------- Admin Menu -------------------
    'system_menu'         => 1,
    'hasAdmin'            => 1,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    // ------------------- Main Menu -------------------
    'hasMain'             => 1,
//    'sub'                 => [
//        [
//            'name' => _MI_XQUIZ_VIEW_SEARCH,
//            'url'  => 'index.php',
//        ],
//    ],

    // ------------------- Install/Update -------------------
    'onInstall'           => 'include/oninstall.php',
    //    'onUpdate'            => 'include/onupdate.php',
    //  'onUninstall'         => 'include/onuninstall.php',
    // -------------------  PayPal ---------------------------
    'paypal'              => [
        'business'      => 'xoopsfoundation@gmail.com',
        'item_name'     => 'Donation : ' . _MI_XQUIZ_NAME,
        'amount'        => 0,
        'currency_code' => 'USD',
    ],
    // ------------------- Search ---------------------------
    'hasSearch'           => 1,
    'search'              => [
        'file' => 'include/search.inc.php',
        'func' => 'quiz_search',
    ],
    // ------------------- Comments -------------------------
    'hasComments'         => 1,
    'comments'            => [
        'pageName' => 'index.php',
        'itemName' => 'q',
        //        'callbackFile' => 'include/comment_functions.php',
        //        'callback'     => [
        //            'approve' => 'picture_comments_approve',
        //            'update'  => 'picture_comments_update',
        //        ],
    ],
    // ------------------- Mysql -----------------------------
    'sqlfile'             => ['mysql' => 'sql/mysql.sql'],
    // ------------------- Tables ----------------------------
    'tables'              => [
        $moduleDirName . '_' . 'quizzes',
        $moduleDirName . '_' . 'categories',
        $moduleDirName . '_' . 'score',
        $moduleDirName . '_' . 'questions',
        $moduleDirName . '_' . 'answers',
        $moduleDirName . '_' . 'quizquestion',
        $moduleDirName . '_' . 'useranswers',
    ],
];

global $xoopsUser;
if (!empty($xoopsUser)) {
    $modversion['sub'][1]['name'] = _MI_XQUIZ_PROFILE;
    $modversion['sub'][1]['url']  = 'index.php?act=p';
}

// ------------------- Help files ------------------- //
$modversion['help']        = 'page=help';
$modversion['helpsection'] = [
    ['name' => _MI_XQUIZ_OVERVIEW, 'link' => 'page=help'],
    ['name' => _MI_XQUIZ_DISCLAIMER, 'link' => 'page=disclaimer'],
    ['name' => _MI_XQUIZ_LICENSE, 'link' => 'page=license'],
    ['name' => _MI_XQUIZ_SUPPORT, 'link' => 'page=support'],
];

// Templates
$modversion['templates'] = [
    ['file' => 'xquiz_index.tpl', 'description' => ''],
];

// ------------------- Config Options ------------------- //
/* Select the number of news items to display on top page
*/

//number of quiz per page in admin page
$modversion['config'][] = [
    'name'        => 'quizList',
    'title'       => '_MI_XQUIZ_LIST_NUM',
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 5,
    'options'     => ['5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30],
];

//number of question per page in admin page
$modversion['config'][] = [
    'name'        => 'questionList',
    'title'       => '_MI_QUEST_LIST_NUM',
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 5,
    'options'     => ['5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30],
];

//number of question per page in user page
$modversion['config'][] = [
    'name'        => 'userList',
    'title'       => '_MI_QUEST_USER_LIST_NUM',
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 5,
    'options'     => ['5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30],
];

//number of quiz per page in user page
$modversion['config'][] = [
    'name'        => 'quizUserList',
    'title'       => '_MI_XQUIZ_USER_LIST_NUM',
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 5,
    'options'     => ['5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30],
];

//number of category per page in admin page
$modversion['config'][] = [
    'name'        => 'categoryList',
    'title'       => '_MI_CATEGORY_LIST_NUM',
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 5,
    'options'     => ['5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30],
];

//MAX Filesize Upload in kilo bytes
$modversion['config'][] = [
    'name'        => 'maxuploadsize',
    'title'       => '_MI_XQUIZ_UPLOADFILESIZE',
    'description' => '_MI_XQUIZ_UPLOADFILESIZE_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 1048576,
];

//Format of the date to use in the module, if you don't specify anything then the default date's format will be used
$modversion['config'][] = [
    'name'        => 'dateformat',
    'title'       => '_MI_XQUIZ_DATEFORMAT',
    'description' => '_MI_XQUIZ_DATEFORMAT_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => 'j F Y g:i a',
];

//user can see quiz score after quiz
$modversion['config'][] = [
    'name'        => 'seeScore',
    'title'       => '_MI_XQUIZ_SEE_SCORE',
    'description' => '_MI_XQUIZ_SEE_SCORE_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

//just user can see quiz statistics
$modversion['config'][] = [
    'name'        => 'seeStat',
    'title'       => '_MI_XQUIZ_SEE_STAT',
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

//mail user score after quiz take part
$modversion['config'][] = [
    'name'        => 'mailScore',
    'title'       => '_MI_XQUIZ_MAIL_SCORE',
    'description' => '_MI_XQUIZ_MAIL_SCORE_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

//user can see score in profile befor quiz end date
$modversion['config'][] = [
    'name'        => 'seeScoreProfile',
    'title'       => '_MI_XQUIZ_PROFILE_SCORE',
    'description' => '_MI_XQUIZ_PROFILE_SCORE_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

// default admin editor
xoops_load('XoopsEditorHandler');
$editorHandler = \XoopsEditorHandler::getInstance();
$editorList    = array_flip($editorHandler->getList());

//user can select wysiwyg editor
//$modversion['config'][] = [
//    'name'        => 'use_wysiwyg',
//    'title'       => '_MI_XQUIZ_EDITORS',
//    'description' => '',
//    'formtype'    => 'select',
//    'valuetype'   => 'text',
//    'default'     => 'dhtmltextarea',
//    'options'     => $editorList,
//];

$modversion['config'][] = [
    'name'        => 'editorAdmin',
    'title'       => '_MI_XQUIZ_EDITOR_ADMIN',
    'description' => '_MI_XQUIZ_EDITOR_ADMIN_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtmltextarea',
    'options'     => $editorList,
];

$modversion['config'][] = [
    'name'        => 'editorUser',
    'title'       => '_MI_XQUIZ_EDITOR_USER',
    'description' => '_MI_XQUIZ_EDITOR_USER_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtmltextarea',
    'options'     => $editorList,
];

/**
 * Make Sample button visible?
 */
$modversion['config'][] = [
    'name'        => 'displaySampleButton',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

/**
 * Show Developer Tools?
 */
$modversion['config'][] = [
    'name'        => 'displayDeveloperTools',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

// ------------------- Blocks ------------------- //
//recent quiz
$modversion['blocks'][] = [
    'file'        => 'quiz_quizs.php',
    'name'        => _MI_XQUIZ_LATESTQUIZ,
    'description' => _MI_XQUIZ_LATESTQUIZ,
    'show_func'   => 'quiz_listQuizs',
    'template'    => 'xquiz_block_quizs.tpl',
    'edit_func'   => 'quiz_listQuizs_edit',
    'options'     => '5',
];

//recent active quiz
$modversion['blocks'][] = [
    'file'        => 'quiz_actives.php',
    'name'        => _MI_XQUIZ_LATESTQUIZ_ACTIVE,
    'description' => _MI_XQUIZ_LATESTQUIZ_ACTIVE,
    'show_func'   => 'quiz_listActiveQuizs',
    'template'    => 'xquiz_block_actives.tpl',
    'edit_func'   => 'quiz_listActiveQuizs_edit',
    'options'     => '5',
];

// ------------------- Notification ----------------------
$modversion['hasNotification']             = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'quiz_notify_iteminfo';

$modversion['notification']['category'][] = [
    'name'           => 'global',
    'title'          => _MI_XQUIZ_GLOBAL_NOTIFY,
    'description'    => _MI_XQUIZ_GLOBAL_NOTIFYDSC,
    'subscribe_from' => 'index.php',
];

$modversion['notification']['category'][] = [
    'name'           => 'quiz',
    'title'          => _MI_XQUIZ_STORY_NOTIFY,
    'description'    => _MI_XQUIZ_STORY_NOTIFYDSC,
    'subscribe_from' => 'index.php',
    'item_name'      => 'q',
    'allow_bookmark' => 1,
];

$modversion['notification']['category'][] = [
    'name'           => 'category',
    'title'          => _MI_XQUIZ_CATEGORY_NOTIFY,
    'description'    => _MI_XQUIZ_CATEGORY_NOTIFYDSC,
    'subscribe_from' => 'index.php',
    'item_name'      => 'cid',
    'allow_bookmark' => 1,
];

$modversion['notification']['event'][] = [
    'name'          => 'new_category',
    'category'      => 'global',
    'title'         => _MI_XQUIZ_GLOBAL_NEWCATEGORY_NOTIFY,
    'caption'       => _MI_XQUIZ_GLOBAL_NEWCATEGORY_NOTIFYCAP,
    'description'   => _MI_XQUIZ_GLOBAL_NEWCATEGORY_NOTIFYDSC,
    'mail_template' => 'global_newcategory_notify',
    'mail_subject'  => _MI_XQUIZ_GLOBAL_NEWCATEGORY_NOTIFYSBJ,
];

$modversion['notification']['event'][] = [
    'name'          => 'quiz_submit',
    'category'      => 'global',
    'admin_only'    => 1,
    'title'         => _MI_XQUIZ_GLOBAL_STORYSUBMIT_NOTIFY,
    'caption'       => _MI_XQUIZ_GLOBAL_STORYSUBMIT_NOTIFYCAP,
    'description'   => _MI_XQUIZ_GLOBAL_STORYSUBMIT_NOTIFYDSC,
    'mail_template' => 'global_quizsubmit_notify',
    'mail_subject'  => _MI_XQUIZ_GLOBAL_STORYSUBMIT_NOTIFYSBJ,
];

$modversion['notification']['event'][] = [
    'name'          => 'new_quiz',
    'category'      => 'category',
    'title'         => _MI_XQUIZ_CATEGORY_STORYPOSTED_NOTIFY,
    'caption'       => _MI_XQUIZ_CATEGORY_STORYPOSTED_NOTIFYCAP,
    'description'   => _MI_XQUIZ_CATEGORY_STORYPOSTED_NOTIFYDSC,
    'mail_template' => 'global_newquiz_notify',
    'mail_subject'  => _MI_XQUIZ_CATEGORY_STORYPOSTED_NOTIFYSBJ,
];

$modversion['notification']['event'][] = [
    'name'          => 'approve',
    'category'      => 'quiz',
    'invisible'     => 1,
    'title'         => _MI_XQUIZ_STORY_APPROVE_NOTIFY,
    'caption'       => _MI_XQUIZ_STORY_APPROVE_NOTIFYCAP,
    'description'   => _MI_XQUIZ_STORY_APPROVE_NOTIFYDSC,
    'mail_template' => 'story_approve_notify',
    'mail_subject'  => _MI_XQUIZ_STORY_APPROVE_NOTIFYSBJ,
];
