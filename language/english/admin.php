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

//index
define('_AM_XQUIZ_INDEX_INFO', 'Index');
define('_AM_XQUIZ_INDEX_CATEGORIES', 'There are %s categories in our database');
define('_AM_XQUIZ_INDEX_QUIZS', 'There are %s quizs in our database');

// Add icons
define('_AM_XQUIZ_ADD_XQUIZ', 'Add Quiz List');
define('_AM_XQUIZ_ADD_CATEGORY', 'Add Quiz Category');

// Category page
define('_AM_XQUIZ_CATEGORY_ID', 'Id');
define('_AM_XQUIZ_CATEGORY_TITLE', 'Title');
define('_AM_XQUIZ_CATEGORY_ACTION', 'Action');
define('_AM_XQUIZ_CATEGORY_FORM', 'Add new Quiz Category');
define('_AM_XQUIZ_CATEGORY_XQUIZ', 'Quiz');
define('_AM_XQUIZ_CATEGORY_EMPTY', 'Error: There are no quiz category created yet. Before you can create a new quiz list, you must create a quiz category first.');
define('_AM_XQUIZ_CATEGORY_DELETECONFIRM', "Are you sure you want to delete <span class='bold red'>%s</span></b> category and <b>ALL</b> of its Quiz Lists? This action is not reversible !!");

// Quiz page
define('_AM_XQUIZ_QUIZ_ID', 'Id');
define('_AM_XQUIZ_QUIZ_ORDER', 'Order');
define('_AM_XQUIZ_QUIZ_TITLE', 'Quiz Title');
define('_AM_XQUIZ_QUIZ_IMG', 'Image');
define('_AM_XQUIZ_QUIZ_CATEGORY', 'Quiz Category');
define('_AM_XQUIZ_QUIZ_ACTION', 'Action');
define('_AM_XQUIZ_QUIZ_FORM', 'Add new quiz');
define('_AM_XQUIZ_QUIZ_DESCRIPTION', 'Description');
define('_AM_XQUIZ_QUIZ_TOTALQUESTION', 'Total Question');
define('_AM_XQUIZ_QUIZ_ACTIVE', 'Active');
define('_AM_XQUIZ_QUIZ_STATUS', 'Status');
define('_AM_XQUIZ_QUIZ_FORMUPLOAD', 'Select your image');
define('_AM_XQUIZ_QUIZ_LANGUAGECODE', 'Language Code');
define('_AM_XQUIZ_QUIZ_STARTDATE', 'Start Date');
define('_AM_XQUIZ_QUIZ_ENDDATE', 'End Date');
define('_AM_XQUIZ_TARGET', 'Open Link in');
define('_AM_XQUIZ_TARGET_0', 'Same Window');
define('_AM_XQUIZ_TARGET_1', 'New Window');
define('_AM_XQUIZ_UPCOMING', 'Upcoming');
define('_AM_XQUIZ_EXPIRED', 'Expired');
define('_AM_XQUIZ_RUNNING', 'Running');
define('_AM_XQUIZ_INACTIVE', 'Inactive');

// Msg
define('_AM_XQUIZ_MSG_EDIT_ERROR', 'Error in edit');
define('_AM_XQUIZ_MSG_DELETE', 'Are you sure you want delete this quiz/category');
define('_AM_XQUIZ_MSG_NOTINFO', 'Not select');
define('_AM_XQUIZ_MSG_ERROR', 'Error');
define('_AM_XQUIZ_MSG_WAIT', 'Please wait');
define('_AM_XQUIZ_MSG_INSERTSUCCESS', 'Added Successfully');
define('_AM_XQUIZ_MSG_EDITSUCCESS', 'Updated Successfully');
define('_AM_XQUIZ_MSG_DELETESUCCESS', 'Deleted Successfully');

define('_MD_PREFERENCES', 'Features');
define('_MD_UPDATE', 'Update');
define('_XQUIZ_INDEX', 'Dashboard');
define('_XQUIZ_QUIZS', 'Quizzes');
define('_XQUIZ_QUESTIONS', 'Questions');
define('_XQUIZ_STATISTICS', 'Statistics');
define('_XQUIZ_PREFERENCE', 'Preferences');
define('_XQUIZ_UPDATE', 'Update');
define('_AM_XQUIZ_MODADMIN', 'Moderate');
define('_AM_XQUIZ_QUIZS_SELECT', 'Choose a quiz title');
define('_XQUIZ_NAME', 'Quiz title');
define('_XQUIZ_DESC', 'Quiz details');
define('_XQUIZ_BDATE', 'Date of beginning');
define('_XQUIZ_EDATE', 'Date of ending');
define('_XQUIZ_WEIGHT', 'Quiz priority');
define('_XQUIZ_SUBMIT', 'Submit');
define('_XQUIZ_ADDQUIZFORM', 'New quiz` form');
define('_XQUIZ_UNAME', 'User');
define('_XQUIZ_ACTIVE', 'Active');
define('_XQUIZ_UNACTIVE', 'Inactive');
define('_XQUIZ_STATUS', 'Status');
define('_XQUIZ_QUEST_NUM', 'Number of questions');
define('_XQUIZ_ACTION', 'Action');
define('_XQUIZ_DEL', 'Delete a quiz');
define('_XQUIZ_STAT', 'Quiz stats');
define('_XQUIZ_QUEST_ADD', 'Add a question');
define('_XQUIZ_NEXT', 'Next');
define('_XQUIZ_PREV', 'Previous');
define('_AM_XQUIZ_NEW', 'Quizzes`s form');
define('_AM_QUEST_FORM', 'Questions`s form');
define('_XQUIZ_DELQUIZFORM', 'Delete quiz form');
define('_AM_XQUIZ_DELETE', 'Delete a quiz');
define('_XQUIZ_DELETE_CAPTION', 'Are you sure you want to delete this quiz?');
define('_XQUIZ_SUBMIT_NO', 'No');
define('_QUEST_NAME', 'Question');
define('_QUEST_NUM', 'Question`s number');
define('_QUEST_SCORE', 'Question`s score');
define('_QUEST_CORRECT', 'Correct option');
define('_AM_QUEST_NEW', 'Create new question');
define('_AM_QUEST_GO', 'Preview');
define('_AM_QUESTION_GO', 'View questions');
define('_AM_INDEX', 'Index');
define('_AM_INDEX_ADD_QUEST', 'You can only add questions to a quiz that has not yet been started.');
define('_AM_INDEX_USER_QUIZ', 'The quiz that has not yet been started cannot be viewed by the users.');
define('_AM_INDEX_USER_EX', 'Users can only try the tests that are not yet finished');
define('_AM_XQUIZ_SEL', 'Options');
define('_XQUIZ_ADD_QUESTION_FORM', 'New question`s form');

define('_QUEST_NUMBER', 'Qustion`s number');
define('_QUEST_DESC', 'Question`s text');
//define('_QUEST_ANS1','Option 1');
//define('_QUEST_ANS2','Option 2');
//define('_QUEST_ANS3','Option 3');
//define('_QUEST_ANS4','Option 4');
//define('_QUEST_ANSWER','Correct option');
define('_XQUIZ_DELQUESTFORM', 'Deleting a question`s form');

define('_XQUIZ_USER', 'User');
define('_XQUIZ_USER_NAME', 'User name');
define('_XQUIZ_SCORE', 'Score');
define('_XQUIZ_DATE', 'Quiz date');
define('_QUEST_NUMBER_ERROR', 'Submitted data error');
define('_QUEST_SECURITY_ERROR', 'Error in submitted data,please try again');
define('_QUEST_SET_ERROR', 'Error in execution order');
define('_QUEST_DATABASE', 'Database connection error');
define('_QUEST_EXIST', 'A question with such title already exists in the database');
define('_QUEST_VALID_BDATE', 'Beginning date is not valid');
define('_QUEST_BDATE', 'Beginning date must be before the ending date');
define('_QUEST_VALID_EDATE', 'Ending date is not valid');
define('_QUEST_EDATE', 'Ending date must be later than the beginning date');
define('_XQUIZ_EXIST', 'A quiz with such name already exists in the database');
define('_XQUIZ_ADD', 'Quiz added successfully');
define('_XQUIZ_EDIT', 'Quiz edited successfully');
define('_XQUIZ_DELETE', 'Quiz deleted successfully');
define('_XQUIZ_RETURN', 'Return to main page');
define('_QUEST_ADD_RULE', 'You can only add questions to the quizzes that have not begun or ended');
define('_QUEST_ADD', 'Question added successfully');
define('_QUEST_EDIT', 'Question edited successfully.');
define('_QUEST_DELETE', 'Question deleted successfully');
define('_AM_NEW_QUIZ', 'Create new quiz');
define('_AM_NEW_QUEST', 'Add new question');
define('_AM_NO_QUIZ', 'There are no quizzes in the database');
define('_XQUIZ_PERMISSIONS', 'Permissions');
define('_XQUIZ_PERM_FORM_TITLE', 'Permission form for categories.');
define('_XQUIZ_PERM_FORM_DESC', 'Select categories that each group is allowed to view.');
////////////////////////////////////////////////////////////////////////////////////////////////////////
define('_XQUIZ_CATEGORIES', 'Categories');
define('_AM_NEW_CATEGORY', 'Add a new category');
define('_CATEGORY_TITLE', 'Title');
define('_CATEGORY_WEIGHT', 'Weight');
define('_AM_CATEGORY_NEW', 'Categories form');
define('_USER_ANSWER', 'user answer');
define('_USER_ANSWER_DETAIL', 'user answer details');
define('_CATEGORY_PARENT', 'Parent');
define('_CATEGORY_DESC', 'Description');
define('_XQUIZ_DELCATEGORY_FORM', 'Delete Category form');
define('_AM_CATEGORYIMG', 'Category Image');
define('_AM_IMGNAEXLOC', 'Image name + extension located in %S');
define('_AM_CATEGORY_PICTURE', 'Upload picture');
define('_AM_UPLOAD_WARNING', '<B>Warning, do not forget to give write permissions to the following folder: %s</B>');
define('_AM_VIEWFORM', 'View Permissions');
define('_AM_UPLOAD_ERROR', 'Erroe in file uploading!');
define('_ADD_CATEGORY', 'Category added successfully.');
define('_EDIT_CATEGORY', 'Category edited successfully.');
define('_DELETE_CATEGORY', 'Category deleted successfully.');
define('_XQUIZ_CATEGORY', 'Category');
define('_XQUIZ_NO_CATEGORY', 'There are no categories in the database.Please add new category.');
define('_XQUIZ_CATEGORY_SELECT', 'Select category.');
define('_XQUIZ_NOTIFY', 'Notify');
define('_XQUIZ_VERSION_TITLE', 'Version Info');
define('_XQUIZ_VERSION', 'You are running version %s of %s module');
define('_XOOPS_VERSION', 'Your '.((defined('ICMS_VERSION_NAME') && ICMS_VERSION_NAME)?'ImpressCMS':'Xoops').' version is : %s');
define('_PHP_VERSION', 'Your php version : %s');
define('_MYSQL_VERSION', 'Your mysql version : %s');
define('_XQUIZ_CSV_EXPORT', 'CSV export');
define('_XQUIZ_OPEN_CSV_ERR', 'Can not open file file,check upload directory permision.');
define('_XQUIZ_CSV_DOWNLOAD', 'Download CSV file.');

//define('_XQUIZ_','');
define('_XQUIZ_DELET_ANS', 'Delete');
define('_XQUIZ_ANSWER_TEXT', 'Answer text');
define('_XQUIZ_ANSWERS_LABEL', 'Answers');
define('_XQUIZ_ADD_ANSWER', 'Add new answer');
define('_QUEST_ANSWER', 'Correct?');
define('_XQUIZ_ANSWER_TYPE_MC', 'Multi Choice');
define('_XQUIZ_ANSWER_TYPE_CM', 'Choose One or More');
define('_XQUIZ_ANSWER_TYPE_FB', 'Fill in the Blank(s)');
define('_XQUIZ_ANSWER_TYPE', 'Answer Type');

