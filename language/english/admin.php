<?php

define('_AM_XQUIZ_MODULENAME', 'xQuiz');

define('_AM_XQUIZ_QUIZS', 'Quizzes');
define('_AM_XQUIZ_QUESTIONS', 'Questions');
define('_AM_XQUIZ_STATISTICS', 'Statistics');
define('_AM_XQUIZ_INDEX', 'Home');
define('_AM_XQUIZ_SEE_SCORE', 'Users are able to see score after quiz take part');
define('_AM_MD_XQUIZ_PERMISSIONS', 'Permissions');
define('_AM_XQUIZ_CATEGORY', 'Category');
define('_AM_XQUIZ_CATEGORY_TITLE', 'Title');
define(
    '_AM_XQUIZ_SEE_SCORE_DESC',
    'By chosing this option each user can see his results after quiz take part,
		otherwize results are shown at the end of each quiz'
);
define('_AM_XQUIZ_ANONYMOUS', 'Only registered users can try the quizzes');
define('_AM_XQUIZ_DATEFORMAT', "Date's format");
define('_AM_XQUIZ_DATEFORMAT_DESC', "Please refer to the Php documentation (http://php.net/manual/en/function.date.php) for more information on how to select the format. Note, if you don't type anything then the default date's format will be used");
define('_AM_XQUIZ_UPLOADFILESIZE', 'MAX File-size Upload (KB) 1048576 = 1 Meg');
define('_AM_XQUIZ_UPLOADEDIMG', 'Uploaded Image');
define('_AM_XQUIZ_IMGNAEXLOC', 'Image name + extension located in %S');
define('_AM_XQUIZ_PREFERENCE', 'Preferences');
define('_AM_XQUIZ_UPDATE', 'Update');
define('_AM_XQUIZ_UNINSTALL', 'Uninstall');
define('_AM_XQUIZ_GOTOMODULE', 'Go To Module');
define('_AM_XQUIZ_HOME', 'Home');
define('_AM_XQUIZ_MODADMIN', 'Moderate');
define('_AM_XQUIZ_QUIZS_SELECT', 'Choose a quiz title');
define('_AM_XQUIZ_NEW', 'Quizzes`s form');
define('_AM_QUEST_FORM', 'Questions`s form');
define('_AM_XQUIZ_DELETE', 'Delete a quiz');
define('_AM_XQUIZ_DELQUIZFORM', 'Delete quiz form');
define('_AM_XQUIZ_SEL', 'Options');
define('_AM_XQUIZ_NEW_CATEGORY', 'Add a new category');
define('_AM_XQUIZ_CATEGORY_WEIGHT', 'Weight');
define('_AM_XQUIZ_CATEGORY_PARENT', 'Parent');
define('_AM_XQUIZ_CATEGORY_DESC', 'Description');
define('_AM_XQUIZ_ADD_CATEGORY', 'Category added successfully.');
define('_AM_XQUIZ_EDIT_CATEGORY', 'Category edited successfully.');
define('_AM_XQUIZ_DELETE_CATEGORY', 'Category deleted successfully.');
define('_AM_XQUIZ_ACTION', 'Action');
define('_AM_XQUIZ_QUEST_NEW', 'Create new question');
define('_AM_XQUIZ_QUEST_TOTAL', 'Total Question');
define('_AM_XQUIZ_QUEST_GO', 'Preview');
define('_AM_XQUIZ_QUESTION_GO', 'View questions');
define('_AM_XQUIZ_INDEX_ADD_QUEST', 'You can only add questions to a quiz that has not yet been started.');
define('_AM_XQUIZ_INDEX_USER_QUIZ', 'The quiz that has not yet been started cannot be viewed by the users.');
define('_AM_XQUIZ_INDEX_USER_EX', 'Users can only try the tests that are not yet finished');
define('_AM_XQUIZ_NEW_QUIZ', 'Create new quiz');
define('_AM_XQUIZ_NEW_QUEST', 'Add new question');
define('_AM_XQUIZ_NO_QUIZ', 'There are no quizzes in the database');
define('_AM_XQUIZ_CATEGORY_NEW', 'Categories form');
define('_AM_XQUIZ_CATEGORYIMG', 'Category Image');
define('_AM_XQUIZ_CATEGORY_PICTURE', 'Upload picture');
define('_AM_XQUIZ_UPLOAD_WARNING', '<B>Warning, do not forget to give write permissions to the following folder: %s</B>');
define('_AM_XQUIZ_VIEWFORM', 'View Permissions');
define('_AM_XQUIZ_UPLOAD_ERROR', 'Error in file uploading!');
define('_AM_XQUIZ_QUEST_SET_ERROR', 'Error in execution order');
define('_AM_XQUIZ_QUEST_DATABASE', 'Database connection error');
define('_AM_XQUIZ_QUEST_NUMBER_ERROR', 'Submitted data error');
define('_AM_XQUIZ_QUEST_EXIST', 'A question with such title already exists in the database');
define('_AM_XQUIZ_QUEST_VALID_BDATE', 'Beginning date is not valid');
define('_AM_XQUIZ_QUEST_BDATE', 'Beginning date must be before the ending date');
define('_AM_XQUIZ_QUEST_VALID_EDATE', 'Ending date is not valid');
define('_AM_XQUIZ_QUEST_EDATE', 'Ending date must be later than the beginning date');
define('_AM_XQUIZ_QUEST_ADD_RULE', 'You can only add questions to the quizzes that have not begun or ended');
define('_AM_XQUIZ_QUEST_ADD', 'Question added successfully');
define('_AM_XQUIZ_QUEST_SECURITY_ERROR', 'Error in submitted data,please try again');
define('_AM_XQUIZ_QUEST_EDIT', 'Question edited successfully.');
define('_AM_XQUIZ_QUEST_DELETE', 'Question deleted successfully');
define('_AM_XQUIZ_QUEST_NAME', 'Question');
define('_AM_XQUIZ_QUEST_NUM', 'Question Number');
define('_AM_XQUIZ_QUEST_CORRECT', 'Correct option');
define('_AM_XQUIZ_NAME', 'Quiz title');
define('_AM_XQUIZ_DESC', 'Quiz details');
define('_AM_XQUIZ_BDATE', 'Date of beginning');
define('_AM_XQUIZ_EDATE', 'Date of ending');
define('_AM_XQUIZ_WEIGHT', 'Quiz Order');
define('_AM_XQUIZ_SUBMIT', 'Submit');
define('_AM_XQUIZ_ADDQUIZFORM', 'New quiz` form');
define('_AM_XQUIZ_UNAME', 'User');
define('_AM_XQUIZ_ACTIVE', 'Active');
define('_AM_XQUIZ_UNACTIVE', 'Inactive');
define('_AM_XQUIZ_STATUS', 'Status');
define('_AM_XQUIZ_DEL', 'Delete a quiz');
define('_AM_XQUIZ_STAT', 'Quiz stats');
define('_AM_XQUIZ_NEXT', 'Next');
define('_AM_XQUIZ_PREV', 'Previous');
define('_AM_XQUIZ_DELETE_CAPTION', 'Are you sure you want to delete this quiz?');
define('_AM_XQUIZ_SUBMIT_NO', 'No');
define('_AM_XQUIZ_ADD_QUESTION_FORM', 'New question`s form');
define('_AM_XQUIZ_DELQUESTFORM', 'Deleting a question`s form');
define('_AM_XQUIZ_USER', 'User');
define('_AM_XQUIZ_USER_NAME', 'User name');
define('_AM_XQUIZ_SCORE', 'Score');
define('_AM_XQUIZ_DATE', 'Quiz date');
define('_AM_XQUIZ_EXIST', 'A quiz with such name already exists in the database');
define('_AM_XQUIZ_ADD', 'Quiz added successfully');
define('_AM_XQUIZ_EDIT', 'Quiz edited successfully');
define('_AM_XQUIZ_RETURN', 'Return to main page');
define('_AM_XQUIZ_CATEGORIES', 'Categories');
define('_AM_XQUIZ_PERM_FORM_TITLE', 'Permission form for categories.');
define('_AM_XQUIZ_PERM_FORM_DESC', 'Select categories that each group is allowed to view.');
define('_AM_XQUIZ_NO_CATEGORY', 'There are no categories in the database.Please add new category.');
define('_AM_XQUIZ_CATEGORY_SELECT', 'Select category.');
define('_AM_XQUIZ_NOTIFY', 'Notification');
define('_AM_XQUIZ_VERSION_TITLE', 'Version Info');
define('_AM_XQUIZ_VERSION', 'You are running version %s of %s module');
define('_AM_XQUIZ_DELCATEGORY_FORM', 'Delete Category form');
define('_AM_XQUIZ_CSV_EXPORT', 'CSV export');
define('_AM_XQUIZ_OPEN_CSV_ERR', 'Can not open file file,check upload directory permision.');
define('_AM_XQUIZ_CSV_DOWNLOAD', 'Download CSV file.');
define('_AM_XQUIZ_DELET_ANS', 'Delete');
define('_AM_XQUIZ_ANSWER_TEXT', 'Answer text');
define('_AM_XQUIZ_ANSWERS_LABEL', 'Answers');
define('_AM_XQUIZ_ADD_ANSWER', 'Add new answer');
define('_AM_XQUIZ_ANSWER_TYPE_MC', 'Multi Choice');
define('_AM_XQUIZ_ANSWER_TYPE_CM', 'Choose One or More');
define('_AM_XQUIZ_ANSWER_TYPE_FB', 'Fill in the Blank(s)');
define('_AM_XQUIZ_ANSWER_TYPE', 'Answer Type');
define('_AM_XQUIZ_QUEST_ANS1', 'Option 1');
define('_AM_XQUIZ_QUEST_ANS2', 'Option 2');
define('_AM_XQUIZ_QUEST_ANS3', 'Option 3');
define('_AM_XQUIZ_QUEST_ANS4', 'Option 4');
define('_AM_XQUIZ_QUEST_ANSWER', 'Correct Answer');
define('_AM_XQUIZ_QUEST_DESC', 'Questions text');
define('_AM_XQUIZ_QUEST_SCORE', 'Questions score');
define('_AM_XQUIZ_UPCOMING', 'Upcoming');
define('_AM_XQUIZ_RUNNING', 'Running');
define('_AM_XQUIZ_EXPIRED', 'Expired');
define('_AM_XQUIZ_STARTDATE', 'Start Date');
define('_AM_XQUIZ_ENDDATE', 'End Date');
define('_AM_XQUIZ_TAKEQUIZ', 'Take Quiz');
define('_AM_XQUIZ_DATETAKEN', 'Date Taken');

//Index
define('AM_QUIZ_STATISTICS', 'Quiz statistics');
define('AM_QUIZ_THEREARE_QUESTION', "There are <span class='bold'>%s</span> Question in the database");
define('AM_QUIZ_THEREARE_QUIZ', "There are <span class='bold'>%s</span> Quiz in the database");
define('AM_QUIZ_THEREARE_CATEGORY', "There are <span class='bold'>%s</span> Category in the database");
define('AM_QUIZ_THEREARE_USERS', "There are <span class='bold'>%s</span> Users in the database");
define('AM_QUIZ_THEREARE_QUESTIONUSER', "There are <span class='bold'>%s</span> QuestionUser in the database");
define('AM_QUIZ_THEREARE_QUESTIONS', "There are <span class='bold'>%s</span> Questions in the database");
define('AM_QUIZ_THEREARE_ANSWERS', "There are <span class='bold'>%s</span> Answers in the database");
