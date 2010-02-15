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
include 'admin_header.php';
xoops_cp_header ();
try {
	$option = (isset ( $_GET ['op'] )) ? $_GET ['op'] : '';
	$action = (isset ( $_GET ['act'] )) ? $_GET ['act'] : '';
	$answerType = (isset ( $_GET ['type'] )) ? htmlentities ( strtoupper ( $_GET ['type'] ) ) : '';
	
	if (isset ( $_GET ['Id'] )) {
		if (! is_numeric ( $_GET ['Id'] ))
			throw new Exception ( "id must be a number." );
		$id = $_GET ['Id'];
	}
	
	if (isset ( $_GET ['qId'] )) {
		if (! is_numeric ( $_GET ['qId'] ))
			throw new Exception ( "qid must be a number." );
		$qid = $_GET ['qId'];
	}
	
	if (isset ( $_GET ['start'] )) {
		if (! is_numeric ( $_GET ['start'] ))
			throw new Exception ( "start must be a number." );
		$start = $_GET ['start'];
	} else
		$start = 0;
	global $xoopsModuleConfig;
	$limitQuiz = $xoopsModuleConfig ['quizList']; // No of records to be shown per page.
	$limitQuest = $xoopsModuleConfig ['questionList']; // No of records to be shown per page.
	$limitUser = $xoopsModuleConfig ['userList']; // No of records to be shown per page.
	$limitCategory = $xoopsModuleConfig ['categoryList'];
	$dateformat = $xoopsModuleConfig ['dateformat'];
	
	switch ($option) {
		case 'Quiz' :
			QuizzadminMenu ( 1, _QUIZ_QUIZS );
			switch ($action) {
				case 'add' :
					Quiz::QuizForm ( 'add' );
					break;
				
				case 'edit' :
					if (isset ( $_GET ['Id'] ))
						Quiz::QuizForm ( 'edit', $id );
					else
						Quiz::showQuizs ( $start, $limitQuiz );
					break;
				
				case 'del' :
					if (isset ( $_GET ['Id'] ))
						Quiz::confirmForm ( $id );
					else
						Quiz::showQuizs ( $start, $limitQuiz );
					break;
				
				default :
					$cid = - 1;
					if (isset ( $_GET ['Id'] ))
						$cid = $id;
					Quiz::showQuizs ( $start, $limitQuiz, $cid );
			}
			break;
		
		case 'Quest' :
			if (Quiz::quiz_numQuizLoader () == 0)
				throw new Exception ( _AM_NO_QUIZ );
			QuizzadminMenu ( 2, _QUIZ_QUIZS );
			switch ($action) {
				case 'add' :
					if (! Quiz::quiz_checkExpireQuiz ( $id ))
						throw new Exception ( _QUEST_ADD_RULE );
					if (Quiz::quiz_checkActiveQuiz ( $id ))
						throw new Exception ( _QUEST_ADD_RULE );
					
					Question::showQuizSelectForm ();
					if (isset ( $id ))
						Question::QuestForm ( $id );
					break;
				
				case 'edit' :
					Question::showQuizSelectForm ();
					if ((isset ( $id )) && (isset ( $qid )))
						Question::QuestForm ( $qid, 'edit', $id );
					break;
				
				case 'del' :
					Question::showQuizSelectForm ();
					if (isset ( $id ))
						Question::confirmForm ( $id );
					break;
				
				default :
					Question::showQuizSelectForm ();
					if (isset ( $id ))
						Question::showQuestions ( $start, $limitQuest, $id );
			}
			break;
		
		case 'Stat' :
			if (Quiz::quiz_numQuizLoader () == 0)
				throw new Exception ( _AM_NO_QUIZ );
			QuizzadminMenu ( 3, _QUIZ_QUIZS );
			statQuizsSelectForm ();
			////////////////////////////////////////////////////////////////
			if (isset ( $_GET ['uid'] ) && is_numeric ( $_GET ['uid'] ) && isset ( $id )) {
				$uid = $_GET ['uid'];
				$arr = showUserQuest ( $id, $uid );
				break;
			}
			/////////////////////////////////////////////////////////////////
			if (isset ( $id )) {
				$qname = Quiz::quiz_quizName ( $id );
				$nume = numUserScore ( $id );
				////////////////////////////////////////
				$listQuiz = array ();
				$q = 1;
				$eu = ($start - 0);
				$query = $xoopsDB->query ( ' SELECT * FROM ' . $xoopsDB->prefix ( 'quiz_users' ) . ' WHERE id = ' . $id . ' ORDER BY score DESC LIMIT ' . $eu . ' , ' . $limitUser );
				while ( $myrow = $xoopsDB->fetchArray ( $query ) ) {
					$listQuiz [$q] ['id'] = $myrow ['id'];
					$listQuiz [$q] ['userid'] = $myrow ['userid'];
					$thisUser = & $member_handler->getUser ( $myrow ['userid'] );
					$listQuiz [$q] ['uname'] = $thisUser->getVar ( 'uname' );
					$listQuiz [$q] ['name'] = $thisUser->getVar ( 'name' );
					$listQuiz [$q] ['score'] = $myrow ['score'];
					$listQuiz [$q] ['date'] = formatTimestamp ( strtotime ( $myrow ['date'] ), $dateformat );
					$q ++;
				}
				////////////////////////////////////////
				if (isset ( $_GET ['exp'] ) && $_GET ['exp'] == 'on') {
					$exportQuiz = array ();
					$query = $xoopsDB->query ( ' SELECT * FROM ' . $xoopsDB->prefix ( 'quiz_users' ) . ' WHERE id = ' . $id );
					$q = 1;
					while ( $myrow = $xoopsDB->fetchArray ( $query ) ) {
						$exportQuiz [$q] ['id'] = $myrow ['id'];
						$exportQuiz [$q] ['userid'] = $myrow ['userid'];
						$thisUser = & $member_handler->getUser ( $myrow ['userid'] );
						$exportQuiz [$q] ['uname'] = $thisUser->getVar ( 'uname' );
						$exportQuiz [$q] ['name'] = $thisUser->getVar ( 'name' );
						$exportQuiz [$q] ['score'] = $myrow ['score'];
						$exportQuiz [$q] ['date'] = formatTimestamp ( strtotime ( $myrow ['date'] ), $dateformat );
						$q ++;
					}
					$fp = fopen ( '../../../uploads/quiz.csv', 'w+b' ) or redirect_header ( XOOPS_URL . '/modules/quiz/admin/index.php?op=Stat', 3, '_QUIZ_OPEN_CSV_ERR' );
					$msg = _QUIZ_USER . ',' . _QUIZ_USER_NAME . ',' . _QUIZ_DATE . ',' . _QUIZ_SCORE . '
';
					foreach ( $exportQuiz as $key ) {
						$msg .= $key ['uname'] . ',' . $key ['name'] . ',' . $key ['date'] . ',' . $key ['score'] . '
';
					}
					#region for csv utf-8 language support
					$msg = html_entity_decode ( $msg, ENT_NOQUOTES, 'utf-8' );
					$msg = chr ( 255 ) . chr ( 254 ) . iconv ( "UTF-8", "UTF-16LE", $msg );
					#end region
					fwrite ( $fp, $msg ) or redirect_header ( XOOPS_URL . '/modules/quiz/admin/index.php?op=Stat', 3, '_QUIZ_OPEN_CSV_ERR' );
					;
					fclose ( $fp );
					echo "
						<div id='newsel' style='text-align: center;'>
						<table width='100%' cellspacing='0' cellpadding='3' border='0' class='outer'>
						<tr class='even'>
							<td width='40%'>
							</td>
							<td width='3%'>
								<img src='" . XOOPS_URL . "/modules/quiz/images/xls.gif' />
							</td>
							<td>
								<a href='" . XOOPS_URL . "/uploads/quiz.csv'>
									" . _QUIZ_CSV_DOWNLOAD . "
								</a>
							</td>
							<td width='40%'>
							</td>
						</tr>	
						</table>
						</div>";
				}
				///////////////////////////////////////
				quiz_collapsableBar ( 'newsub', 'topnewsubicon' );
				$temp = "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewsubicon' name='topnewsubicon' src='" . XOOPS_URL . "/modules/quiz/images/close12.gif' alt='' />
				 	</a>&nbsp;" . _QUIZ_STATISTICS . "</h4><br/>
						<div id='newsub' style='text-align: center;'>
						<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
						<tr class='bg3'>
							<th>
								" . _QUIZ_USER . "
							</th>
							<th>
								" . _QUIZ_USER_NAME . "
							</th>
							<th>
								" . _QUIZ_SCORE . "
							</th>
							<th>
								" . _QUIZ_DATE . "
							</th>
							<th>
								" . _QUIZ_DESC . "
							</th>
						</tr>";
				
				$class = 'even';
				$detImage = "<img src= \"" . XOOPS_URL . "/modules/quiz/images/detail.gif \" >";
				
				foreach ( $listQuiz as $key ) {
					$class = ($class == 'even') ? 'odd' : 'even';
					
					$temp = $temp . "
						<tr class='" . $class . "'>
							<td>
								<a href=\"" . XOOPS_URL . "/userinfo.php?uid=" . $key ['userid'] . "\">" . $key ['uname'] . "</a>
							</td>
							<td>
								" . $key ['name'] . "
							</td>
							<td>
							" . $key ['score'] . "
							</td>
							<td>
							" . $key ['date'] . "
							</td>
							<td>
							<a href=\"" . XOOPS_URL . "/modules/quiz/admin/index.php?op=Stat&Id=" . $key ['id'] . "&uid=" . $key ['userid'] . "\">" . $detImage . "</a>
							</td>
						</tr>";
				}
				$temp = $temp . "</table></div>";
				echo $temp;
				
				$nav = new XoopsPageNav ( $nume, $limitUser, $start, 'start', "op=Stat&Id=$id" );
				echo "<div align='center'>" . $nav->renderImageNav () . '</div><br />';
			}
			
			//	///////////////////////////////////////////////////////////////
			break;
		
		case 'Perm' :
			$xt = new Category ( $xoopsDB->prefix ( 'quiz_cat' ), 'cid', 'pid' );
			if (! $xt->getChildTreeArray ( 0 ))
				throw new Exception ( _QUIZ_NO_CATEGORY );
			QuizzadminMenu ( 4, _QUIZ_PERMISSIONS );
			Category::category_permissionForm ();
			break;
		
		case 'Cate' :
			QuizzadminMenu ( 5, _QUIZ_CATEGORIES );
			switch ($action) {
				case 'add' :
					CategoryForm ( 'add' );
					break;
				
				case 'edit' :
					if (isset ( $_GET ['Id'] ))
						CategoryForm ( 'edit', $id );
					else
						showCategories ( $start, $limitCategory );
					break;
				
				case 'del' :
					if (isset ( $_GET ['Id'] ))
						confirmForm ( $id );
					else
						showCategories ( $start, $limitCategory );
					break;
				
				default :
					showCategories ( $start, $limitCategory );
			}
			
			break;
		
		//////////////////////////////////////////////////////////////////////////////
		

		case 'Qst' :
			if (Quiz::quiz_numQuizLoader () == 0)
				throw new Exception ( _AM_NO_QUIZ );
			QuizzadminMenu ( 6, _QUIZ_QUIZS );
			switch ($action) {
				case 'add' :
					if (! Quiz::quiz_checkExpireQuiz ( $id ))
						throw new Exception ( _QUEST_ADD_RULE );
					if (Quiz::quiz_checkActiveQuiz ( $id ))
						throw new Exception ( _QUEST_ADD_RULE );
					
					questions::showQuizSelectForm ();
					if (isset ( $id ))
						questions::QuestAddForm ( $id, $answerType );
					break;
				
				case 'edit' :
					questions::showQuizSelectForm ();
					if (isset ( $id ))
					{
						$questionObj = new questions ( );
						$questionObj->QuestEditForm($id);
					}
					break;
				
				case 'del' :
					questions::showQuizSelectForm ();
					if (isset ( $id ))
						questions::confirmForm($id);
					break;
				
				default :
					questions::showQuizSelectForm ();
					if (isset ( $id ))
						questions::showQuestions ( $start, $limitQuest, $id );
			}
			break;
		
		//////////////////////////////////////////////////////////////////////////////////
		

		default :
			QuizzadminMenu ( 0, _QUIZ_INDEX );
			$menu = new QuizMenu ( );
			$menu->addItem ( 'Categories', 'index.php?op=Cate', '../images/menus/categories.png', _QUIZ_CATEGORIES );
			$menu->addItem ( 'Permissions', 'index.php?op=Perm', '../images/menus/permmision.png', _QUIZ_PERMISSIONS );
			$menu->addItem ( 'Quizzes', 'index.php?op=Quiz', '../images/menus/quizzes.png', _QUIZ_QUIZS );
			$menu->addItem ( 'Questions', 'index.php?op=Quest', '../images/menus/questions.png', _QUIZ_QUESTIONS );
			$menu->addItem ( 'Statistics', 'index.php?op=Stat', '../images/menus/statistic.png', _QUIZ_STATISTICS );
			$menu->addItem ( 'Preference', '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar ( 'mid' ) . '&amp;&confcat_id=1', '../images/menus/config.png', _QUIZ_PREFERENCE );
			
			if (! class_exists ( 'XoopsTpl' )) {
				include_once XOOPS_ROOT_PATH . '/class/template.php';
			}
			if (isset ( $xoopsTpl )) {
				$tpl = & $xoopsTpl;
			} else {
				$tpl = new XoopsTpl ( );
			}
			$tpl->assign ( 'menu_css', $menu->getCSS () );
			$tpl->assign ( 'menu', $menu->render () );
			$tpl->assign ( 'quiz_version', sprintf ( _QUIZ_VERSION, $xoopsModule->getInfo ( 'version' ) . '(' . $xoopsModule->getInfo ( 'status' ) . ')', $xoopsModule->getInfo ( 'name' ) ) );
			$tpl->assign ( 'xoops_version', sprintf ( _XOOPS_VERSION, XOOPS_VERSION ) );
			$tpl->assign ( 'php_version', sprintf ( _PHP_VERSION, phpversion () ) );
			$tpl->assign ( 'mysql_version', sprintf ( _MYSQL_VERSION, mysql_get_server_info () ) );
			echo $tpl->fetch ( XOOPS_ROOT_PATH . '/modules/quiz/admin/tpls/qz_index.html' );
			break;
	}
} catch ( Exception $e ) {
	redirect_header ( 'index.php', 3, $e->getMessage () );
	exit ();
}

xoops_cp_footer ();
?>