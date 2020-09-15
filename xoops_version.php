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
 * @copyright   	XOOPS Project (https://xoops.org)
 * @license			http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xquiz
 * @author 			Mojtaba Jamali(jamali.mojtaba@gmail.com)
 * @version      	$Id$
 *
 * Version : $Id:
 * ****************************************************************************
 */
$moduleDirName = basename(__DIR__);
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

$modversion = [
    // Main setting
    'version' => 2.01,
    'module_status' => 'Alpha 1',
    'release_date' => '2020/11/20',
    'name' => _MI_XQUIZ_TITLE,
    'description' => _MI_XQUIZ_DESC,
    'version' => 2.0,
    'author' => 'Mojtaba Jamali, Mamba, Lio MJ',
    'credits' => 'XOOPS, Mojtaba Jamali (jamali.mojtaba@gmail.com)',
    'license' => 'GNU GPL 2.0',
    'license_url' => 'www.gnu.org/licenses/gpl-2.0.html/',
    'image' => 'assets/images/logo.png',
    'dirname' => $moduleDirName,
    'module_website_url' => 'https://www.xoops.org/',
    'module_website_name' => 'XOOPS Project',
    'help' => 'help',
    // Admin things
    'system_menu' => 1,
    'hasAdmin' => 1,
    'adminindex' => 'admin/index.php',
    'adminmenu' => 'admin/menu.php',
    // Modules scripts
    'onInstall' => 'include/install.php',
    // ------------------- Min Requirements -------------------
    'min_php' => '7.1',
    'min_xoops' => '2.5.10',
    'min_admin' => '1.2',
    'min_db' => [
        'mysql' => '5.5',
    ],
    // ------------------- Mysql -----------------------------
    'sqlfile' => ['mysql' => 'sql/mysql.sql'],
    // ------------------- Tables ----------------------------
    'tables' => [
        $moduleDirName . '_' . 'item',
        $moduleDirName . '_' . 'category',
    ],
];

$modversion['hasMain'] = 1;
 global $xoopsUser;
 if (!empty($xoopsUser)) {
     $modversion['sub'][1]['name'] = _AM_XQUIZ_PROFILE;
     $modversion['sub'][1]['url'] = "index.php?act=p";
 }

//Comments
$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'q';
$modversion['comments']['pageName'] = 'index.php';

//Search
$modversion['hasSearch'] = 1;
 $modversion['search']['file'] = "include/search.inc.php";
 $modversion['search']['func'] = "quiz_search";


$modversion['templates'] = [
    ['file' => 'admin/xquiz_category.tpl', 'description' => ''],
    ['file' => 'admin/xquiz_header.tpl', 'description' => ''],
    ['file' => 'admin/xquiz_footer.tpl', 'description' => ''],
    ['file' => 'admin/xquiz_quiz.tpl', 'description' => ''],
    ['file' => 'blocks/xquiz_item.tpl', 'description' => ''],
    ['file' => 'blocks/xquiz_nivoslider.tpl', 'description' => ''],
    ['file' => 'blocks/xquiz_slickslider.tpl', 'description' => ''],
];

// Templates
$modversion['templates'][1]['file'] = 'xquiz_index.tpl';
$modversion['templates'][1]['description'] = '';

////////////////////////////////////////////////////////////
// Blocks
//recent quiz
$modversion['blocks'][1]['file'] = "quiz_quizs.php";
$modversion['blocks'][1]['name'] = _MB_XQUIZ_LATESTQUIZ;
$modversion['blocks'][1]['description'] = _MB_XQUIZ_LATESTQUIZ;
$modversion['blocks'][1]['show_func'] = "quiz_listQuizs";
$modversion['blocks'][1]['template'] = 'xquiz_block_quizs.tpl';
$modversion['blocks'][1]['edit_func'] = "quiz_listQuizs_edit";
$modversion['blocks'][1]['options'] = '5';
//recent active quiz
$modversion['blocks'][2]['file'] = "quiz_actives.php";
$modversion['blocks'][2]['name'] = _MB_XQUIZ_LATESTQUIZ_ACTIVE;
$modversion['blocks'][2]['description'] = _MB_XQUIZ_LATESTQUIZ_ACTIVE;
$modversion['blocks'][2]['show_func'] = "quiz_listActiveQuizs";
$modversion['blocks'][2]['template'] = 'xquiz_block_actives.tpl';
$modversion['blocks'][2]['edit_func'] = "quiz_listActiveQuizs_edit";
$modversion['blocks'][2]['options'] = '5';

// Notification
$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'quiz_notify_iteminfo';

$modversion['notification']['category'][1]['name'] = 'global';
$modversion['notification']['category'][1]['title'] = _MI_XQUIZ_GLOBAL_NOTIFY;
$modversion['notification']['category'][1]['description'] = _MI_XQUIZ_GLOBAL_NOTIFYDSC;
$modversion['notification']['category'][1]['subscribe_from'] = 'index.php';

$modversion['notification']['category'][2]['name'] = 'quiz';
$modversion['notification']['category'][2]['title'] = _MI_XQUIZ_STORY_NOTIFY;
$modversion['notification']['category'][2]['description'] = _MI_XQUIZ_STORY_NOTIFYDSC;
$modversion['notification']['category'][2]['subscribe_from'] = 'index.php';
$modversion['notification']['category'][2]['item_name'] = 'q';
$modversion['notification']['category'][2]['allow_bookmark'] = 1;

$modversion['notification']['category'][3]['name'] = 'category';
$modversion['notification']['category'][3]['title'] = _MI_XQUIZ_CATEGORY_NOTIFY;
$modversion['notification']['category'][3]['description'] = _MI_XQUIZ_CATEGORY_NOTIFYDSC;
$modversion['notification']['category'][3]['subscribe_from'] = 'index.php';
$modversion['notification']['category'][3]['item_name'] = 'cid';
$modversion['notification']['category'][3]['allow_bookmark'] = 1;

$modversion['notification']['event'][1]['name'] = 'new_category';
$modversion['notification']['event'][1]['category'] = 'global';
$modversion['notification']['event'][1]['title'] = _MI_XQUIZ_GLOBAL_NEWCATEGORY_NOTIFY;
$modversion['notification']['event'][1]['caption'] = _MI_XQUIZ_GLOBAL_NEWCATEGORY_NOTIFYCAP;
$modversion['notification']['event'][1]['description'] = _MI_XQUIZ_GLOBAL_NEWCATEGORY_NOTIFYDSC;
$modversion['notification']['event'][1]['mail_template'] = 'global_newcategory_notify';
$modversion['notification']['event'][1]['mail_subject'] = _MI_XQUIZ_GLOBAL_NEWCATEGORY_NOTIFYSBJ;

$modversion['notification']['event'][2]['name'] = 'quiz_submit';
$modversion['notification']['event'][2]['category'] = 'global';
$modversion['notification']['event'][2]['admin_only'] = 1;
$modversion['notification']['event'][2]['title'] = _MI_XQUIZ_GLOBAL_STORYSUBMIT_NOTIFY;
$modversion['notification']['event'][2]['caption'] = _MI_XQUIZ_GLOBAL_STORYSUBMIT_NOTIFYCAP;
$modversion['notification']['event'][2]['description'] = _MI_XQUIZ_GLOBAL_STORYSUBMIT_NOTIFYDSC;
$modversion['notification']['event'][2]['mail_template'] = 'global_quizsubmit_notify';
$modversion['notification']['event'][2]['mail_subject'] = _MI_XQUIZ_GLOBAL_STORYSUBMIT_NOTIFYSBJ;

$modversion['notification']['event'][3]['name'] = 'new_quiz';
$modversion['notification']['event'][3]['category'] = 'category';
$modversion['notification']['event'][3]['title'] = _MI_XQUIZ_CATEGORY_STORYPOSTED_NOTIFY;
$modversion['notification']['event'][3]['caption'] = _MI_XQUIZ_CATEGORY_STORYPOSTED_NOTIFYCAP;
$modversion['notification']['event'][3]['description'] = _MI_XQUIZ_CATEGORY_STORYPOSTED_NOTIFYDSC;
$modversion['notification']['event'][3]['mail_template'] = 'global_newquiz_notify';
$modversion['notification']['event'][3]['mail_subject'] = _MI_XQUIZ_CATEGORY_STORYPOSTED_NOTIFYSBJ;

$modversion['notification']['event'][4]['name'] = 'approve';
$modversion['notification']['event'][4]['category'] = 'quiz';
$modversion['notification']['event'][4]['invisible'] = 1;
$modversion['notification']['event'][4]['title'] = _MI_XQUIZ_STORY_APPROVE_NOTIFY;
$modversion['notification']['event'][4]['caption'] = _MI_XQUIZ_STORY_APPROVE_NOTIFYCAP;
$modversion['notification']['event'][4]['description'] = _MI_XQUIZ_STORY_APPROVE_NOTIFYDSC;
$modversion['notification']['event'][4]['mail_template'] = 'story_approve_notify';
$modversion['notification']['event'][4]['mail_subject'] = _MI_XQUIZ_STORY_APPROVE_NOTIFYSBJ;


// ------------------- Config Options -----------------------------//
$modversion['config'][] = [
    'name' => 'xquiz_configs',
    'title' => '_MI_XQUIZ_CONFCAT_IMAGE',
    'description' => '_MI_XQUIZ_CONFCAT_IMAGE_DSC',
    'formtype' => 'line_break',
    'valuetype' => 'textbox',
    'default' => 'odd',
    'category' => 'group_header',
];

// conf
$modversion['config'][] = [
    'name' => 'img_mime',
    'title' => '_MI_XQUIZ_IMAGE_MIME',
    'description' => '_MI_XQUIZ_IMAGE_MIME_DESC',
    'formtype' => 'select_multi',
    'valuetype' => 'array',
    'default' => ['image/gif', 'image/jpeg', 'image/png'],
    'options' => [
        'bmp' => 'image/bmp',
        'gif' => 'image/gif',
        'jpeg' => 'image/pjpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'jpe' => 'image/jpeg',
        'png' => 'image/png',
    ],
];

$modversion['config'][] = [
    'name' => 'img_size',
    'title' => '_MI_XQUIZ_IMAGE_SIZE',
    'description' => '_MI_XQUIZ_IMAGE_SIZE_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => '5242880',
];

$modversion['config'][] = [
    'name' => 'img_maxwidth',
    'title' => '_MI_XQUIZ_IMAGE_MAXWIDTH',
    'description' => '_MI_XQUIZ_IMAGE_MAXWIDTH_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => '1200',
];

$modversion['config'][] = [
    'name' => 'img_maxheight',
    'title' => '_MI_XQUIZ_IMAGE_MAXHEIGHT',
    'description' => '_MI_XQUIZ_IMAGE_MAXHEIGHT_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => '1200',
];

/* Select the number of news items to display on top page
 */
 //number of quiz per page in admin page
 $i=1;
$modversion['config'][$i]['name'] = 'quizList';
$modversion['config'][$i]['title'] = '_AM_XQUIZ_LIST_NUM';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;
$modversion['config'][$i]['options'] = ['5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30];
//number of question per page in admin page
$i++;
$modversion['config'][$i]['name'] = 'questionList';
$modversion['config'][$i]['title'] = '_AM_QUEST_LIST_NUM';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;
$modversion['config'][$i]['options'] = ['5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30];
//number of question per page in user page
$i++;
$modversion['config'][$i]['name'] = 'userList';
$modversion['config'][$i]['title'] = '_AM_QUEST_USER_LIST_NUM';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;
$modversion['config'][$i]['options'] = ['5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30];
//number of quiz per page in user page
$i++;
$modversion['config'][$i]['name'] = 'quizUserList';
$modversion['config'][$i]['title'] = '_AM_XQUIZ_USER_LIST_NUM';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;
$modversion['config'][$i]['options'] = ['5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30];

 //number of category per page in admin page
 $i++;
$modversion['config'][$i]['name'] = 'categoryList';
$modversion['config'][$i]['title'] = '_AM_CATEGORY_LIST_NUM';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;
$modversion['config'][$i]['options'] = ['5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30];
 //MAX Filesize Upload in kilo bytes
 $i++;
$modversion['config'][$i]['name'] = 'maxuploadsize';
$modversion['config'][$i]['title'] = '_MI_UPLOADFILESIZE';
$modversion['config'][$i]['description'] = '_MI_UPLOADFILESIZE_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1048576;
//Format of the date to use in the module, if you don't specify anything then the default date's format will be used
$i++;
$modversion['config'][$i]['name'] = 'dateformat';
$modversion['config'][$i]['title'] = '_AM_XQUIZ_DATEFORMAT';
$modversion['config'][$i]['description'] = '_AM_XQUIZ_DATEFORMAT_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = "j F Y g:i a";

//user can see quiz score after quiz
$i++;
$modversion['config'][$i]['name'] = 'seeScore';
$modversion['config'][$i]['title'] = '_AM_XQUIZ_SEE_SCORE';
$modversion['config'][$i]['description'] = '_AM_XQUIZ_SEE_SCORE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
//just user can see quiz statistics
$i++;
$modversion['config'][$i]['name'] = 'seeStat';
$modversion['config'][$i]['title'] = '_AM_XQUIZ_SEE_STAT';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
//mail user score after quiz take part
$i++;
$modversion['config'][$i]['name'] = 'mailScore';
$modversion['config'][$i]['title'] = '_AM_XQUIZ_MAIL_SCORE';
$modversion['config'][$i]['description'] = '_AM_XQUIZ_MAIL_SCORE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
//user can see score in profile befor quiz end date
$i++;
$modversion['config'][$i]['name'] = 'seeScoreProfile';
$modversion['config'][$i]['title'] = '_AM_XQUIZ_PROFILE_SCORE';
$modversion['config'][$i]['description'] = '_AM_XQUIZ_PROFILE_SCORE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
//user can select wysiwyg editor
$i++;
$modversion['config'][$i]['name'] = 'use_wysiwyg';
$modversion['config'][$i]['title'] = '_AM_XQUIZ_EDITORS';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'dhtmltextarea';
$modversion['config'][$i]['options'] = [
    'Plain Editor'  => 'textarea', 'XoopsEditor' => 'dhtmltextarea'
    , 'Tiny Editor' => 'tinymce', 'FCK Editor' => 'fckeditor', 'Koivi Editor' => 'koivi'
];
