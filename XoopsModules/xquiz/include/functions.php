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
if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}
@define( '_GLOBAL_LEFT' , @_ADM_USE_RTL == 1 ? 'right' : 'left' ) ;
@define( '_GLOBAL_RIGHT' , @_ADM_USE_RTL == 1 ? 'left' : 'right' ) ;
include_once XOOPS_ROOT_PATH.'/modules/quiz/class/question.php';

function findUserScore($userId ,$id)
{
	global $xoopsDB;
	$query =$xoopsDB->query("SELECT * FROM ". $xoopsDB->prefix('quiz_users') 
		." WHERE id = $id AND userid = '$userId'");
		
	$res = $xoopsDB->getRowsNum($query);
	if($res > 0)
		return true;
	else 
		return false;
}


	#region load number of user score per id from database
	function numUserScore($qId)
	{
		global $xoopsDB;
		$result = $xoopsDB->query("SELECT * FROM " . $xoopsDB->prefix('quiz_users')." WHERE id = $qId");
		return $xoopsDB->getRowsNum($result);
	}
	#endregion

function quiz_collapsableBar($tablename = '', $iconname = '')
{

    ?>
	<script type="text/javascript"><!--
	function goto_URL(object)
	{
		window.location.href = object.options[object.selectedIndex].value;
	}

	function toggle(id)
	{
		if (document.getElementById) { obj = document.getElementById(id); }
		if (document.all) { obj = document.all[id]; }
		if (document.layers) { obj = document.layers[id]; }
		if (obj) {
			if (obj.style.display == "none") {
				obj.style.display = "";
			} else {
				obj.style.display = "none";
			}
		}
		return false;
	}

	var iconClose = new Image();
	iconClose.src = '../images/close12.gif';
	var iconOpen = new Image();
	iconOpen.src = '../images/open12.gif';

	function toggleIcon ( iconName )
	{
		if ( document.images[iconName].src == window.iconOpen.src ) {
			document.images[iconName].src = window.iconClose.src;
		} else if ( document.images[iconName].src == window.iconClose.src ) {
			document.images[iconName].src = window.iconOpen.src;
		}
		return;
	}

	//-->
	</script>
	<?php
	echo "<h4 style=\"color: #2F5376; margin: 6px 0 0 0; \"><a href='#' onClick=\"toggle('" . $tablename . "'); toggleIcon('" . $iconname . "');\">";
}

	#region show select quiz form
	function statQuizsSelectForm()
	{
		$list = Quiz::allQuizs();

		echo  "<div id='newsel' style='text-align: center;'>
					<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
						<tr class='odd'>
							<td>
							<form method='get' action='index.php'\">
								<input type='hidden' name='op' value='Stat'>
								
								<lable>"._AM_QUIZ_QUIZS_SELECT."
									<select name='Id'>";
		foreach ($list as $key)
		 	echo "<option value='".$key['id']."'>".$key['name']."</option>";

		 	
		echo "						</select>
								</lable>
								<lable>
								"._QUIZ_CSV_EXPORT."
								</lable>
								<input type='checkbox' name='exp'>
								<input type='submit' value='"._AM_QUEST_GO."'>
							</form>
							</td>
							
					</table>
				</div>";
	}
	#endregion
	#endregion
	function userQuestLoader($quizId ,$uid)
	{
		global $xoopsDB;
		$list = array();
		$query = "SELECT * FROM ". $xoopsDB->prefix('question_user') ." 
			NATURAL JOIN ". $xoopsDB->prefix('question') ." 
			WHERE userId = $uid AND quizId=$quizId AND questId=id";
		$query =$xoopsDB->query($query);
		$q = 0;
		while($myrow = $xoopsDB->fetchArray($query) )
		{
			$list[$q]['questId'] = $myrow['questId'];
			$list[$q]['userAns'] = $myrow['userAns'];
			$list[$q]['qnumber'] = $myrow['qnumber'];
			$list[$q]['score'] = $myrow['score'];
			$list[$q]['answer'] = $myrow['answer'];
			$list[$q]['question'] = $myrow['question'];
			$q++;
		}
		return $list;
	}
	function showUserQuest($quizId ,$uid)
	{
		global $member_handler;
		$list = userQuestLoader($quizId ,$uid);
		
		$quiz = Quiz::retriveQuiz($quizId);
		$thisUser =& $member_handler->getUser($uid);
		$userImage = "<img src= \"".XOOPS_URL."/modules/quiz/images/user.png \" alt='' >";
		$quizImage = "<img src= \"".XOOPS_URL."/modules/quiz/images/quizz.png \" alt='' >";

		quiz_collapsableBar('newsub', 'topnewsubicon');
		$temp = "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewsubicon' name='topnewsubicon' src='" .
				 XOOPS_URL . "/modules/quiz/images/close12.gif' alt='' />
				 </a>&nbsp;"._USER_ANSWER_DETAIL."</h4><br/>
					<div id='newsub' style='text-align: center;'>
					<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
						<tr class='odd'>
							<td>
							<a href=\"".XOOPS_URL."/modules/quiz/admin/index.php?op=Stat&Id=".$quiz['id']."\">".$quizImage.$quiz['name']."</a>
							<a href='".XOOPS_URL."/userinfo.php?uid=".$uid."'>".$userImage.$thisUser->getVar('uname')."</a>
							</td>
						</tr>
					</table>
					
					<table width='100%' cellspacing='1' cellpadding='1' border='0' class='outer'>
					<tr class='bg3'>
						<th>
							"._QUEST_NAME."
						</th>
						<th>
							"._QUEST_CORRECT."
						</th>
						<th>
							"._QUEST_SCORE."
						</th>
						<th>
							"._USER_ANSWER."
						</th>
						<th>
							"._QUIZ_STATUS."
						</th>
					</tr>";
				 
		$class = 'even';
		$delImage = "<img src= \"".XOOPS_URL."/modules/quiz/images/delete.gif \" title="._QUIZ_DEL." alt='' >";
		$validImage = "<img src= \"".XOOPS_URL."/modules/quiz/images/valid.png \" alt='' >";
		$invalidImage = "<img src= \"".XOOPS_URL."/modules/quiz/images/invalid.png \" alt='' >";
		$ts =& MyTextSanitizer::getInstance();
		foreach ($list as $key)
		{	
			$correct = ($key['answer'] == $key['userAns'])? $validImage:$invalidImage ;
			$class = ($class == 'even') ? 'odd' : 'even';
			$temp = $temp."
			<tr class='".$class."'>
				<td>
				".$key['qnumber']."-".$ts->previewTarea($key['question'],1,1,1,1,1)."
				</td>
				<td>
				".$key['answer']."
				</td>
				<td>
				".$key['score']."
				</td>
				<td>
				".$key['userAns']."
				</td>
				<td>
				".$correct."
				</td>
				</tr>";
		}
		
		$temp = $temp."</table></div>";
		echo $temp;	
	}
	
	function userQuizzes($uid)
	{
		global $xoopsDB,$xoopsModuleConfig;
		$dateformat = $xoopsModuleConfig['dateformat'];
		$list = array();
		$query = "SELECT * FROM ". $xoopsDB->prefix('quiz_users') ." 
			NATURAL JOIN ". $xoopsDB->prefix('quiz') ." 
			WHERE userid = $uid";
		$query =$xoopsDB->query($query);
		$q = 0;
		while($myrow = $xoopsDB->fetchArray($query) )
		{
			$list[$q]['id'] = $myrow['id'];
			$list[$q]['name'] = $myrow['name'];
			$list[$q]['score'] = $myrow['score'];
			$list[$q]['date'] = formatTimestamp(strtotime($myrow['date']),$dateformat);
			$list[$q]['edate'] = formatTimestamp(strtotime($myrow['edate']),$dateformat);
			
			$today = strtotime(date("Y-m-d"));			
			if (strtotime($myrow['edate']) >= $today) 
				$list[$q]['active'] = true;
			else	
				$list[$q]['active'] = false;	
			$q++;
		}
		return $list;
	}
	
    /**
     * Send a user score to user's email
     * @param     int     $score
     * @param     object     $user
     * @param     int     $qid
     * @return     bool
     **/
    function sendEmail($user ,$score ,$qid)
    {
        global $xoopsConfig,$xoopsDB,$xoopsModuleConfig;
		$dateformat = $xoopsModuleConfig['dateformat'];
        
        if (!is_object($user)) {
            $user =& $GLOBALS["xoopsUser"];
        }
        $msg = sprintf(_QUIZ_EMAIL_DESC, $user->getVar("uname"));
        $msg .= "\n\n";
        $msg .= formatTimestamp(time(),$dateformat);
        $msg .= "\n";
        $msg .= _QUIZ_EMAIL_MESSAGE . ":\n";
        $msg .= _QUIZ_FINAL_SCORE." = ".$score."\n";
        $msg .=  _QUIZ_SCORE_PROFILE. ": ". XOOPS_URL . "/modules/quiz/index.php?act=p&q=".$qid."\n";
        $msg .= $xoopsConfig['sitename'] . ": ". XOOPS_URL . "\n";
        $system_mailer = ( defined('ICMS_VERSION_NAME') && ICMS_VERSION_NAME )?getMailer():xoops_getMailer();
        $xoopsMailer =&$system_mailer;
        $xoopsMailer->useMail();
        $xoopsMailer->setToEmails($user->getVar("email"));
        $xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
        $xoopsMailer->setFromName($xoopsConfig['sitename']);
        $xoopsMailer->setSubject(_QUIZ_EMAIL_SUBJECT);
        $xoopsMailer->setBody($msg);
        return $xoopsMailer->send();
    }
       
?>