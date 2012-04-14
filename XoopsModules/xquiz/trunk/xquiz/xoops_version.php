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
 * @copyright   	The XOOPS Project http://sourceforge.net/projects/xoops/ 
 * @license			http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xquiz
 * @author 			Mojtaba Jamali(jamali.mojtaba@gmail.com)
 * @version      	$Id$ 
 *
 * Version : $Id:
 * ****************************************************************************
 */
 $modversion['name'] = "xquiz";
 $modversion['version'] = "1.0";
 $modversion['description'] = "A quiz module to generate multi-option quizzes";
 $modversion['author'] = "Mojtaba Jamali";
 $modversion['credits'] = "jamali.mojtaba@gmail.com";
 $modversion['help'] = "help.php";
 $modversion['license'] = "GNU General Public License (GPL) see LICENSE";
 $modversion['official'] = 0;
 $modversion['iconsmall'] = "images/icon_small.png";
 $modversion['iconbig'] = "images/icon_big.png";
 $modversion['image'] = "images/quiz.png";
 $modversion['dirname'] = "quiz";
 $modversion['modname'] = 'quiz';
 $modversion['status_version'] = "1.00";
 $modversion['status'] = "Final";
 // Admin
 $modversion['hasAdmin'] = 1;
 $modversion['adminindex'] = "admin/index.php";
 $modversion['adminmenu'] = "admin/menu.php";
 // Menu
 $modversion['hasMain'] = 1;
 global $xoopsUser;
 if (!empty($xoopsUser)){
	$modversion['sub'][1]['name'] = _AM_QUIZ_PROFILE;
	$modversion['sub'][1]['url'] = "index.php?act=p";
	}
 
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][0] = "question";
$modversion['tables'][1] = "quiz";
$modversion['tables'][2] = "quiz_cat";
$modversion['tables'][3] = "quiz_users";
$modversion['tables'][4] = "question_user";
$modversion['tables'][5] = "quiz_questions";
$modversion['tables'][6] = "quiz_answers";

// Templates
$modversion['templates'][1]['file'] = 'quiz_index.html';
$modversion['templates'][1]['description'] = '';

//Search
$modversion['hasSearch'] = 1;
 $modversion['search']['file'] = "include/search.inc.php"; 
 $modversion['search']['func'] = "quiz_search";

 /* Select the number of news items to display on top page
 */
 //number of quiz per page in admin page
 $i=1;
$modversion['config'][$i]['name'] = 'quizList';
$modversion['config'][$i]['title'] = '_AM_QUIZ_LIST_NUM';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;
$modversion['config'][$i]['options'] = array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30);
//number of question per page in admin page
$i++;
$modversion['config'][$i]['name'] = 'questionList';
$modversion['config'][$i]['title'] = '_AM_QUEST_LIST_NUM';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;
$modversion['config'][$i]['options'] = array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30);
//number of question per page in user page
$i++;
$modversion['config'][$i]['name'] = 'userList';
$modversion['config'][$i]['title'] = '_AM_QUEST_USER_LIST_NUM';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;
$modversion['config'][$i]['options'] = array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30);
//number of quiz per page in user page
$i++;
$modversion['config'][$i]['name'] = 'quizUserList';
$modversion['config'][$i]['title'] = '_AM_QUIZ_USER_LIST_NUM';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;
$modversion['config'][$i]['options'] = array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30);

 //number of category per page in admin page
 $i++;
$modversion['config'][$i]['name'] = 'categoryList';
$modversion['config'][$i]['title'] = '_AM_CATEGORY_LIST_NUM';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;
$modversion['config'][$i]['options'] = array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30);
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
$modversion['config'][$i]['title'] = '_AM_QUIZ_DATEFORMAT';
$modversion['config'][$i]['description'] = '_AM_QUIZ_DATEFORMAT_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = "m";

//user can see quiz score after quiz
$i++;
$modversion['config'][$i]['name'] = 'seeScore';
$modversion['config'][$i]['title'] = '_AM_QUIZ_SEE_SCORE';
$modversion['config'][$i]['description'] = '_AM_QUIZ_SEE_SCORE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
//just user can see quiz statistics 
$i++;
$modversion['config'][$i]['name'] = 'seeStat';
$modversion['config'][$i]['title'] = '_AM_QUIZ_SEE_STAT';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
//mail user score after quiz take part
$i++;
$modversion['config'][$i]['name'] = 'mailScore';
$modversion['config'][$i]['title'] = '_AM_QUIZ_MAIL_SCORE';
$modversion['config'][$i]['description'] = '_AM_QUIZ_MAIL_SCORE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
//user can see score in profile befor quiz end date
$i++;
$modversion['config'][$i]['name'] = 'seeScoreProfile';
$modversion['config'][$i]['title'] = '_AM_QUIZ_PROFILE_SCORE';
$modversion['config'][$i]['description'] = '_AM_QUIZ_PROFILE_SCORE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
//user can select wysiwyg editor
$i++;
$modversion['config'][$i]['name'] = 'use_wysiwyg';
$modversion['config'][$i]['title'] = '_AM_QUIZ_EDITORS';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'dhtmltextarea';
$modversion['config'][$i]['options'] = array( 'Plain Editor' => 'textarea', 'XoopsEditor' => 'dhtmltextarea'
						, 'Tiny Editor' => 'tinymce', 'FCK Editor' => 'fckeditor', 'Koivi Editor' => 'koivi' );

////////////////////////////////////////////////////////////
// Blocks
//recent quiz 
$modversion['blocks'][1]['file'] = "quiz_quizs.php";
$modversion['blocks'][1]['name'] = _AM_QUIZ_QUIZS_LATES;
$modversion['blocks'][1]['description'] = _AM_QUIZ_QUIZS_LATES;
$modversion['blocks'][1]['show_func'] = "quiz_listQuizs";
$modversion['blocks'][1]['template'] = 'quiz_block_quizs.html';
$modversion['blocks'][1]['edit_func'] = "quiz_listQuizs_edit";
$modversion['blocks'][1]['options'] = '5';
//recent active quiz 
$modversion['blocks'][2]['file'] = "quiz_actives.php";
$modversion['blocks'][2]['name'] = _AM_QUIZ_QUIZS_LATES_ACTIVE;
$modversion['blocks'][2]['description'] = _AM_QUIZ_QUIZS_LATES_ACTIVE;
$modversion['blocks'][2]['show_func'] = "quiz_listActiveQuizs";
$modversion['blocks'][2]['template'] = 'quiz_block_actives.html';
$modversion['blocks'][2]['edit_func'] = "quiz_listActiveQuizs_edit";
$modversion['blocks'][2]['options'] = '5';

// Notification
$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'quiz_notify_iteminfo';

$modversion['notification']['category'][1]['name'] = 'global';
$modversion['notification']['category'][1]['title'] = _MI_QUIZ_GLOBAL_NOTIFY;
$modversion['notification']['category'][1]['description'] = _MI_QUIZ_GLOBAL_NOTIFYDSC;
$modversion['notification']['category'][1]['subscribe_from'] = 'index.php';

$modversion['notification']['category'][2]['name'] = 'quiz';
$modversion['notification']['category'][2]['title'] = _MI_QUIZ_STORY_NOTIFY;
$modversion['notification']['category'][2]['description'] = _MI_QUIZ_STORY_NOTIFYDSC;
$modversion['notification']['category'][2]['subscribe_from'] = 'index.php';
$modversion['notification']['category'][2]['item_name'] = 'q';
$modversion['notification']['category'][2]['allow_bookmark'] = 1;

$modversion['notification']['category'][3]['name'] = 'category';
$modversion['notification']['category'][3]['title'] = _MI_QUIZ_CATEGORY_NOTIFY;
$modversion['notification']['category'][3]['description'] = _MI_QUIZ_CATEGORY_NOTIFYDSC;
$modversion['notification']['category'][3]['subscribe_from'] = 'index.php';
$modversion['notification']['category'][3]['item_name'] = 'cid';
$modversion['notification']['category'][3]['allow_bookmark'] = 1;

$modversion['notification']['event'][1]['name'] = 'new_category';
$modversion['notification']['event'][1]['category'] = 'global';
$modversion['notification']['event'][1]['title'] = _MI_QUIZ_GLOBAL_NEWCATEGORY_NOTIFY;
$modversion['notification']['event'][1]['caption'] = _MI_QUIZ_GLOBAL_NEWCATEGORY_NOTIFYCAP;
$modversion['notification']['event'][1]['description'] = _MI_QUIZ_GLOBAL_NEWCATEGORY_NOTIFYDSC;
$modversion['notification']['event'][1]['mail_template'] = 'global_newcategory_notify';
$modversion['notification']['event'][1]['mail_subject'] = _MI_QUIZ_GLOBAL_NEWCATEGORY_NOTIFYSBJ;

$modversion['notification']['event'][2]['name'] = 'quiz_submit';
$modversion['notification']['event'][2]['category'] = 'global';
$modversion['notification']['event'][2]['admin_only'] = 1;
$modversion['notification']['event'][2]['title'] = _MI_QUIZ_GLOBAL_STORYSUBMIT_NOTIFY;
$modversion['notification']['event'][2]['caption'] = _MI_QUIZ_GLOBAL_STORYSUBMIT_NOTIFYCAP;
$modversion['notification']['event'][2]['description'] = _MI_QUIZ_GLOBAL_STORYSUBMIT_NOTIFYDSC;
$modversion['notification']['event'][2]['mail_template'] = 'global_quizsubmit_notify';
$modversion['notification']['event'][2]['mail_subject'] = _MI_QUIZ_GLOBAL_STORYSUBMIT_NOTIFYSBJ;

$modversion['notification']['event'][3]['name'] = 'new_quiz';
$modversion['notification']['event'][3]['category'] = 'category';
$modversion['notification']['event'][3]['title'] = _MI_QUIZ_CATEGORY_STORYPOSTED_NOTIFY;
$modversion['notification']['event'][3]['caption'] = _MI_QUIZ_CATEGORY_STORYPOSTED_NOTIFYCAP;
$modversion['notification']['event'][3]['description'] = _MI_QUIZ_CATEGORY_STORYPOSTED_NOTIFYDSC;
$modversion['notification']['event'][3]['mail_template'] = 'global_newquiz_notify';
$modversion['notification']['event'][3]['mail_subject'] = _MI_QUIZ_CATEGORY_STORYPOSTED_NOTIFYSBJ;

$modversion['notification']['event'][4]['name'] = 'approve';
$modversion['notification']['event'][4]['category'] = 'quiz';
$modversion['notification']['event'][4]['invisible'] = 1;
$modversion['notification']['event'][4]['title'] = _MI_QUIZ_STORY_APPROVE_NOTIFY;
$modversion['notification']['event'][4]['caption'] = _MI_QUIZ_STORY_APPROVE_NOTIFYCAP;
$modversion['notification']['event'][4]['description'] = _MI_QUIZ_STORY_APPROVE_NOTIFYDSC;
$modversion['notification']['event'][4]['mail_template'] = 'story_approve_notify';
$modversion['notification']['event'][4]['mail_subject'] = _MI_QUIZ_STORY_APPROVE_NOTIFYSBJ;

//Comments
$modversion['hasComments'] = 1; 
$modversion['comments']['itemName'] = 'q'; 
$modversion['comments']['pageName'] = 'index.php'; 

?>