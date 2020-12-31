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

use Xmf\Module\Admin;
use Xmf\Request;
use Xmf\Yaml;
use XoopsModules\Xquiz;
use XoopsModules\Xquiz\Common;

require __DIR__ . '/admin_header.php';
xoops_cp_header();
$adminObject = Admin::getInstance();
////count "total Question"
///** @var \XoopsPersistableObjectHandler $questionHandler */
//$totalQuestion = $questionHandler->getCount();
////count "total Quiz"
///** @var \XoopsPersistableObjectHandler $quizHandler */
//$totalQuiz = $quizHandler->getCount();
////count "total Cat"
///** @var \XoopsPersistableObjectHandler $catHandler */
//$totalCat = $catHandler->getCount();
////count "total Quiz_users"
///** @var \XoopsPersistableObjectHandler $quiz_usersHandler */
//$totalQuiz_users = $quiz_usersHandler->getCount();
////count "total Question_user"
///** @var \XoopsPersistableObjectHandler $question_userHandler */
//$totalQuestion_user = $question_userHandler->getCount();
////count "total Questions"
///** @var \XoopsPersistableObjectHandler $questionsHandler */
//$totalQuestions = $questionsHandler->getCount();
////count "total Answers"
///** @var \XoopsPersistableObjectHandler $answersHandler */
//$totalAnswers = $answersHandler->getCount();
//// InfoBox Statistics
//$adminObject->addInfoBox(AM_QUIZ_STATISTICS);
//
//// InfoBox question
//$adminObject->addInfoBoxLine(sprintf(AM_QUIZ_THEREARE_QUESTION, $totalQuestion));
//
//// InfoBox quiz
//$adminObject->addInfoBoxLine(sprintf(AM_QUIZ_THEREARE_QUIZ, $totalQuiz));
//
//// InfoBox cat
//$adminObject->addInfoBoxLine(sprintf(AM_QUIZ_THEREARE_CATEGORY, $totalCat));
//
//// InfoBox quiz_users
//$adminObject->addInfoBoxLine(sprintf(AM_QUIZ_THEREARE_USERS, $totalQuiz_users));
//
//// InfoBox question_user
//$adminObject->addInfoBoxLine(sprintf(AM_QUIZ_THEREARE_QUESTIONUSER, $totalQuestion_user));
//
//// InfoBox questions
//$adminObject->addInfoBoxLine(sprintf(AM_QUIZ_THEREARE_QUESTIONS, $totalQuestions));
//
//// InfoBox answers
//$adminObject->addInfoBoxLine(sprintf(AM_QUIZ_THEREARE_ANSWERS, $totalAnswers));

//------ check Upload Folders ---------------
$adminObject->addConfigBoxLine('');
$redirectFile = $_SERVER['SCRIPT_NAME'];

$configurator  = new Common\Configurator();
$uploadFolders = $configurator->uploadFolders;

foreach (array_keys($uploadFolders) as $i) {
    $adminObject->addConfigBoxLine(Common\DirectoryChecker::getDirectoryStatus($uploadFolders[$i], 0777, $redirectFile));
}


// Render Index
$adminObject->displayNavigation(basename(__FILE__));

//check for latest release
//$newRelease = $utility->checkVerModule($helper);
//if (!empty($newRelease)) {
//    $adminObject->addItemButton($newRelease[0], $newRelease[1], 'download', 'style="color : Red"');
//}


//------------- Test Data ----------------------------

if ($helper->getConfig('displaySampleButton')) {
    $yamlFile            = dirname(__DIR__) . '/config/admin.yml';
    $config              = loadAdminConfig($yamlFile);
    $displaySampleButton = $config['displaySampleButton'];

    if (1 == $displaySampleButton) {
        xoops_loadLanguage('admin/modulesadmin', 'system');
        require_once dirname(__DIR__) . '/testdata/index.php';

        $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'ADD_SAMPLEDATA'), $helper->url( 'testdata/index.php?op=load'), 'add');
        $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA'), $helper->url( 'testdata/index.php?op=save'), 'add');
        //    $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA'), $helper->url( 'testdata/index.php?op=exportschema'), 'add');
        $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'HIDE_SAMPLEDATA_BUTTONS'), '?op=hide_buttons', 'delete');
    } else {
        $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLEDATA_BUTTONS'), '?op=show_buttons', 'add');
        $displaySampleButton = $config['displaySampleButton'];
    }
    $adminObject->displayButton('left', '');
    ;
}

//------------- End Test Data ----------------------------

$adminObject->displayIndex();

/**
 * @param $yamlFile
 * @return array|bool
 */
function loadAdminConfig($yamlFile)
{
    $config = Yaml::readWrapped($yamlFile); // work with phpmyadmin YAML dumps
    return $config;
}

/**
 * @param $yamlFile
 */
function hideButtons($yamlFile)
{
    $app = [];
    $app['displaySampleButton'] = 0;
    Yaml::save($app, $yamlFile);
    redirect_header('index.php', 0, '');
}

/**
 * @param $yamlFile
 */
function showButtons($yamlFile)
{
    $app = [];
    $app['displaySampleButton'] = 1;
    Yaml::save($app, $yamlFile);
    redirect_header('index.php', 0, '');
}

$op = Request::getString('op', 0, 'GET');

switch ($op) {
    case 'hide_buttons':
        hideButtons($yamlFile);
        break;
    case 'show_buttons':
        showButtons($yamlFile);
        break;
}

echo $utility::getServerStats();

//codeDump(__FILE__);
require __DIR__ . '/admin_footer.php';
