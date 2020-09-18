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
include("../../../mainfile.php");
include '../../../include/cp_header.php';
include_once XOOPS_ROOT_PATH."/kernel/module.php";
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
include_once XOOPS_ROOT_PATH.'/modules/xquiz/include/functions.php';
include_once XOOPS_ROOT_PATH.'/modules/xquiz/class/question.php';
include_once XOOPS_ROOT_PATH.'/modules/xquiz/class/questions.php';
include_once XOOPS_ROOT_PATH.'/modules/xquiz/class/quiz.php';
include_once XOOPS_ROOT_PATH.'/modules/xquiz/class/category.php';
include_once XOOPS_ROOT_PATH.'/modules/xquiz/class/menu.class.php';
include_once XOOPS_ROOT_PATH.'/class/xoopsform/grouppermform.php';
include_once XOOPS_ROOT_PATH.'/class/uploader.php';
include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
 

$module_id = $xoopsModule->getVar('mid');
if (is_object($xoopsUser)) {
    $xoopsModule = XoopsModule::getByDirname("xquiz");
   if (!$xoopsUser->isAdmin($xoopsModule->mid())) {
        redirect_header(XOOPS_URL."/", 1, _NOPERM);
    }
} else {
    redirect_header(XOOPS_URL."/", 1, _NOPERM);
}
    $module_handler = xoops_gethandler('module');
    $module =$module_handler->getByDirname("xquiz");
    $config_handler = xoops_gethandler('config');
    $moduleConfig =$config_handler->getConfigsByCat(0, $module->getVar('mid'));
function QuizzadminMenu($currentoption = 0, $breadcrumb = '')
{
    /* Nice button styles */
    include "style".((defined('_ADM_USE_RTL') && _ADM_USE_RTL)?"_rtl":"").".css";
    global $xoopsDB, $xoopsModule, $xoopsConfig, $xoopsModuleConfig;
    $tblCol = [];
    $tblCol[0]=$tblCol[1]=$tblCol[2]=$tblCol[3]=$tblCol[4]=$tblCol[5]=$tblCol[6]=$tblCol[7]='';
    
    $tblCol[$currentoption] = 'current';

    echo "<div id='buttontop'>";
    echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
    echo "<td style='font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;'></td>
			&nbsp;&nbsp;<a href=\"../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod="
            .$xoopsModule ->getVar('mid')."&amp;&confcat_id=1\"><span>"._AM_XQUIZ_PREFERENCE."</span></a> | 
			<a href=\"../../system/admin.php?fct=modulesadmin&op=update&module=xquiz
			&amp;&confcat_id=1\"><span>"._AM_XQUIZ_UPDATE."</span></a> | <a href=\"../../system/admin.php?fct=modulesadmin&op=uninstall&module=xquiz\">"._AM_XQUIZ_UNINSTALL."</a> | <a href='../../xquiz/'>"._AM_XQUIZ_GOTOMODULE."</a> </td><td style='text-align: right;'><strong>"._AM_XQUIZ_MODULENAME."</strong> : "._AM_XQUIZ_HOME."</td>";
    echo "</tr></table>";
    echo "</div>";

    echo "<div id='buttonbar'>";
    echo "<ul>";
    echo "<li id='".$tblCol[0]."'><a href=\"index.php\"><span>"._AM_XQUIZ_INDEX."</span></a></li>";
    echo "<li id='".$tblCol[5]."'><a href=\"index.php?op=Category\"><span>"._AM_XQUIZ_CATEGORIES."</span></a></li>";
    echo "<li id='".$tblCol[1]."'><a href=\"index.php?op=Quiz\"><span>"._AM_XQUIZ_QUIZS."</span></a></li>";
    echo "<li id='".$tblCol[2]."'><a href=\"index.php?op=Quest\"><span>"._AM_XQUIZ_QUESTIONS." 1</span></a></li>";
    echo "<li id='".$tblCol[6]."'><a href=\"index.php?op=Question\"><span>"._AM_XQUIZ_QUESTIONS." 2</span></a></li>";
    echo "<li id='".$tblCol[3]."'><a href=\"index.php?op=Statistics\"><span>"._AM_XQUIZ_STATISTICS."</span></a></li>";  
	echo "<li id='".$tblCol[4]."'><a href=\"index.php?op=Permission\"><span>"._AM_MD_XQUIZ_PERMISSIONS."</span></a></li>";
    echo "<li id='".$tblCol[7]."'><a href=\"../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod="
        .$xoopsModule ->getVar('mid')."&amp;&confcat_id=1\"><span>"._AM_XQUIZ_PREFERENCE."</span></a></li>";
    
    echo "</ul></div>";
    echo "<br style='clear:both;' />";
}
