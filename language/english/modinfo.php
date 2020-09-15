<?php
/**
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
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         xquiz
 * @author 			Mojtaba Jamali(jamali.mojtaba@gmail.com)
 * @version         $Id: $
 */

// module info
define('_MI_XQUIZ_TITLE', 'xQuiz');
define('_MI_XQUIZ_DESC', 'Make Quiz');

// menu
define('_AM_XQUIZ_HOME', 'Home');
define('_AM_XQUIZ_CATEGORY', 'Quiz Category');
define('_AM_XQUIZ_XQUIZ', 'Quiz Lists');

// block
define('_MI_XQUIZ_NIVOSLIDER', 'Nivo Slider Quiz');
define('_MI_XQUIZ_SLICKSLIDER', 'Slick Slider Quiz');

// preferences
define('_MI_XQUIZ_CONFCAT_IMAGE', '<b>:: Quiz List Upload Preferences ::</b>');
define('_MI_XQUIZ_CONFCAT_IMAGE_DSC', '');
define('_MI_XQUIZ_IMAGE_MIME', 'Mimetypes');
define('_MI_XQUIZ_IMAGE_MIME_DESC', 'Select mimetypes for upload');
define('_MI_XQUIZ_IMAGE_SIZE', 'Max size');
define('_MI_XQUIZ_IMAGE_SIZE_DESC', 'Set Max image size');
define('_MI_XQUIZ_IMAGE_MAXWIDTH', 'Max width');
define('_MI_XQUIZ_IMAGE_MAXWIDTH_DESC', 'Set max image widht');
define('_MI_XQUIZ_IMAGE_MAXHEIGHT', 'Max height');
define('_MI_XQUIZ_IMAGE_MAXHEIGHT_DESC', 'Set max image height');


define('_AM_XQUIZ_LIST_NUM', 'Maximum number of quizzes shown in the moderate section per page ');
define('_AM_QUEST_LIST_NUM', 'Maximum number of questions shown in the moderate section per page ');
define('_AM_CATEGORY_LIST_NUM', 'Maximum number of categories shown in the moderate section per page ');
define('_AM_QUEST_USER_LIST_NUM', 'Maximum number of users shown in the stats management section per page');
define('_AM_XQUIZ_USER_LIST_NUM', 'Maximum number of questions shown in the user section per page');
define('_AM_XQUIZ_QUIZS', 'Quizzes');
define('_AM_XQUIZ_QUESTIONS', 'Questions');
define('_AM_XQUIZ_STATISTICS', 'Statistics');
define('_AM_XQUIZ_INDEX', 'Main page');
define('_AM_XQUIZ_SEE_SCORE', 'Users are able to see score after quiz take part');
define('_AM_XQUIZ_PERMISSIONS', 'Permissions');
define('_AM_XQUIZ_CATEGORY', 'Category');
define('_AM_XQUIZ_SEE_SCORE_DESC', 'By chosing this option each user can see his results after quiz take part,
		otherwize results are shown at the end of each quiz');
define('_AM_XQUIZ_ANONYMOUS', 'Only registered users can try the quizzes');
define('_AM_XQUIZ_SEE_STAT', 'Quest users can see the results and stats of quiz');
define('_AM_XQUIZ_PROFILE_SCORE', 'Users are able to see score after quiz take part in profile');
define('_AM_XQUIZ_PROFILE_SCORE_DESC', 'With this option chosen each user can see his results after quiz take part in profile,
		otherwize results are shown at the end of each quiz');


define('_MI_UPLOADFILESIZE', 'MAX File-size Upload (KB) 1048576 = 1 Meg');
define('_AM_XQUIZ_PROFILE', 'My Score');
define('_AM_XQUIZ_DATEFORMAT', "Date's format");
define('_AM_XQUIZ_DATEFORMAT_DESC', "Please refer to the Php documentation (http://php.net/manual/en/function.date.php) for more information on how to select the format. Note, if you don't type anything then the default date's format will be used");
//text for notification

define('_MI_XQUIZ_GLOBAL_NOTIFY', 'Global');
define('_MI_XQUIZ_GLOBAL_NOTIFYDSC', 'Global QUIZ notification options.');

define('_MI_XQUIZ_STORY_NOTIFY', 'Quiz');
define('_MI_XQUIZ_STORY_NOTIFYDSC', 'Notification options that applies to the current quiz.');

define('_MI_XQUIZ_GLOBAL_NEWCATEGORY_NOTIFY', 'New category');
define('_MI_XQUIZ_GLOBAL_NEWCATEGORY_NOTIFYCAP', 'Notify me when a new category is created.');
define('_MI_XQUIZ_GLOBAL_NEWCATEGORY_NOTIFYDSC', 'Receive notification when a new category is created.');
define('_MI_XQUIZ_GLOBAL_NEWCATEGORY_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New quiz category');

define('_MI_XQUIZ_GLOBAL_STORYSUBMIT_NOTIFY', 'New quiz Submitted');
define('_MI_XQUIZ_GLOBAL_STORYSUBMIT_NOTIFYCAP', 'Notify me when any new quiz is submitted (awaiting approval).');
define('_MI_XQUIZ_GLOBAL_STORYSUBMIT_NOTIFYDSC', 'Receive notification when any new quiz is submitted (awaiting approval).');
define('_MI_XQUIZ_GLOBAL_STORYSUBMIT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New quiz submitted');

define('_MI_XQUIZ_STORY_APPROVE_NOTIFY', 'quiz activated');
define('_MI_XQUIZ_STORY_APPROVE_NOTIFYCAP', 'Notify me when this quiz is activated.');
define('_MI_XQUIZ_STORY_APPROVE_NOTIFYDSC', 'Receive notification when this quiz is activated.');
define('_MI_XQUIZ_STORY_APPROVE_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : quiz activated');

define('_MI_XQUIZ_CATEGORY_NOTIFY', 'Category');
define('_MI_XQUIZ_CATEGORY_NOTIFYDSC', 'Notification options that apply to the current category');

define('_MI_XQUIZ_CATEGORY_STORYPOSTED_NOTIFY', 'New quiz Submitted');
define('_MI_XQUIZ_CATEGORY_STORYPOSTED_NOTIFYCAP', 'Notify me when any new quiz is submitted to this category.');
define('_MI_XQUIZ_CATEGORY_STORYPOSTED_NOTIFYDSC', 'Receive notification when any new quiz is submitted to this category.');
define('_MI_XQUIZ_CATEGORY_STORYPOSTED_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New quiz');
define('_AM_XQUIZ_MAIL_SCORE', 'User score email for user.');
define('_AM_XQUIZ_MAIL_SCORE_DESC', 'With this option chosen user score email for user after tries quiz.');
//////////////////////////////////////////////////////////
define('_AM_XQUIZ_EDITORS', 'default editor');

