<?php

// The name of this module
define('_MI_XQUIZ_NAME', 'XQuiz');
define('_MI_XQUIZ_DESC', 'A quiz module to generate multi-option quizzes');

define('_MI_XQUIZ_INDEX', 'Home');
define('_MI_XQUIZ_MENU_01', 'Admin');
define('_MI_XQUIZ_QUIZS', 'Quizzes');
define('_MI_XQUIZ_QUESTIONS', 'Questions');
define('_MI_XQUIZ_STATISTICS', 'Statistics');
define('_MI_XQUIZ_MENU_ABOUT', 'About');
define('_MI_XQUIZ_PROFILE', 'My Score');
define('_MI_XQUIZ_SEE_SCORE', 'Users are able to see score after quiz take part');
define('_MI_MD_XQUIZ_PERMISSIONS', 'Permissions');
define('_MI_XQUIZ_CATEGORY', 'Category');
define('_MI_XQUIZ_CATEGORY_TITLE', 'Title');
define('_MI_XQUIZ_LATESTQUIZ', 'Latest Quiz');
define('_MI_XQUIZ_LATESTQUIZ_ACTIVE', 'Latest Active Quiz');
define('_MI_XQUIZ_MODADMIN', 'Moderate section');
define('_MI_XQUIZ_LIST_NUM', 'Maximum number of quizzes shown in the moderate section per page ');
define('_MI_QUEST_LIST_NUM', 'Maximum number of questions shown in the moderate section per page ');
define('_MI_CATEGORY_LIST_NUM', 'Maximum number of categories shown in the moderate section per page ');
define('_MI_QUEST_USER_LIST_NUM', 'Maximum number of users shown in the stats management section per page');
define('_MI_XQUIZ_USER_LIST_NUM', 'Maximum number of questions shown in the user section per page');
define('_MI_XQUIZ_SEE_STAT', 'Quest users can see the results and stats of quiz');
define('_MI_XQUIZ_PROFILE_SCORE', 'Users are able to see score after quiz take part in profile');
define(
    '_MI_XQUIZ_PROFILE_SCORE_DESC',
    'With this option chosen each user can see his results after quiz take part in profile,
		otherwize results are shown at the end of each quiz'
);
define('_MI_XQUIZ_DATEFORMAT', "Date's format");
define('_MI_XQUIZ_DATEFORMAT_DESC', "Please refer to the Php documentation (http://php.net/manual/en/function.date.php) for more information on how to select the format. Note, if you don't type anything then the default date's format will be used");
define('_MI_XQUIZ_MAIL_SCORE', 'User score email for user.');
define('_MI_XQUIZ_MAIL_SCORE_DESC', 'With this option chosen user score email for user after tries quiz.');
define('_MI_XQUIZ_EDITORS', 'Default Editor');
define('_MI_XQUIZ_UPLOADFILESIZE', 'MAX File-size Upload (KB) 1048576 = 1 Meg');
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

//Config
define('_MI_XQUIZ_EDITOR_ADMIN', 'Editor: Admin');
define('_MI_XQUIZ_EDITOR_ADMIN_DESC', 'Select the Editor to use by the Admin');
define('_MI_XQUIZ_EDITOR_USER', 'Editor: User');
define('_MI_XQUIZ_EDITOR_USER_DESC', 'Select the Editor to use by the User');

//Help
define('_MI_XQUIZ_DIRNAME', basename(dirname(__DIR__, 2)));
define('_MI_XQUIZ_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_MI_XQUIZ_BACK_2_ADMIN', 'Back to Administration of ');
define('_MI_XQUIZ_OVERVIEW', 'Overview');

//define('_MI_XQUIZ_HELP_DIR', __DIR__);

//help multi-page
define('_MI_XQUIZ_DISCLAIMER', 'Disclaimer');
define('_MI_XQUIZ_LICENSE', 'License');
define('_MI_XQUIZ_SUPPORT', 'Support');
define('_MI_XQUIZ_VIEW_SEARCH', 'Search');
