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
if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}
@define('_GLOBAL_LEFT', 1 == @_ADM_USE_RTL ? 'right' : 'left') ;
@define('_GLOBAL_RIGHT', 1 == @_ADM_USE_RTL ? 'left' : 'right') ;
include_once XOOPS_ROOT_PATH.'/modules/xquiz/class/question.php';

function findUserScore($userId, $id)
{
    global $xoopsDB;
    $query =$xoopsDB->query("SELECT * FROM ". $xoopsDB->prefix('xquiz_score')
        ." WHERE id = $id AND userid = '$userId'");
        
    $res = $xoopsDB->getRowsNum($query);
    if ($res > 0) {
        return true;
    } else {
        return false;
    }
}


    #region load number of user score per id from database
    function numUserScore($qId)
    {
        global $xoopsDB;
        $result = $xoopsDB->query("SELECT * FROM " . $xoopsDB->prefix('xquiz_score')." WHERE id = $qId");
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
	iconClose.src = '../assets/images/close12.gif';
	var iconOpen = new Image();
	iconOpen.src = '../assets/images/open12.gif';

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
								<input type='hidden' name='op' value='Statistics'>
								
								<lable>"._AM_XQUIZ_QUIZS_SELECT."
									<select name='Id'>";
        foreach ($list as $key) {
            echo "<option value='".$key['id']."'>".$key['name']."</option>";
        }

            
        echo "						</select>
								</lable>
								<lable>
								"._AM_XQUIZ_CSV_EXPORT."
								</lable>
								<input type='checkbox' name='exp'>
								<input type='submit' value='"._AM_XQUIZ_QUEST_GO."'>
							</form>
							</td>
							
					</table>
				</div>";
    }
    #endregion
    #endregion
    function userQuestLoader($quizId, $uid)
    {
        global $xoopsDB;
        $list = [];
        $query = "SELECT * FROM ". $xoopsDB->prefix('xquiz_useranswers') ." 
			NATURAL JOIN ". $xoopsDB->prefix('xquiz_questionsx') ." 
			WHERE userId = $uid AND quizId=$quizId AND questId=id";
        $query =$xoopsDB->query($query);
        $q = 0;
        while ($myrow = $xoopsDB->fetchArray($query)) {
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
    function showUserQuest($quizId, $uid)
    {
        global $member_handler;
        $list = userQuestLoader($quizId, $uid);
        
        $quiz = Quiz::retriveQuiz($quizId);
        $thisUser =& $member_handler->getUser($uid);
        $userImage = "<img src= \"".XOOPS_URL."/modules/xquiz/assets/images/user.png \" alt='' >";
        $quizImage = "<img src= \"".XOOPS_URL."/modules/xquiz/assets/images/quizz.png \" alt='' >";

        quiz_collapsableBar('newsub', 'topnewsubicon');
        $temp = "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewsubicon' name='topnewsubicon' src='" .
                 XOOPS_URL . "/modules/xquiz/assets/images/close12.gif' alt='' />
				 </a>&nbsp;"._MD_XQUIZ_USER_ANSWER_DETAIL."</h4><br/>
					<div id='newsub' style='text-align: center;'>
					<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
						<tr class='odd'>
							<td>
							<a href=\"".XOOPS_URL."/modules/xquiz/admin/index.php?op=Statistics&Id=".$quiz['id']."\">".$quizImage.$quiz['name']."</a>
							<a href='".XOOPS_URL."/userinfo.php?uid=".$uid."'>".$userImage.$thisUser->getVar('uname')."</a>
							</td>
						</tr>
					</table>
					
					<table width='100%' cellspacing='1' cellpadding='1' border='0' class='outer'>
					<tr class='bg3'>
						<th>
							"._AM_XQUIZ_QUEST_NAME."
						</th>
						<th>
							"._AM_XQUIZ_QUEST_CORRECT."
						</th>
						<th>
							"._MD_XQUIZ_QUEST_SCORE."
						</th>
						<th>
							"._MD_XQUIZ_USER_ANSWER."
						</th>
						<th>
							"._AM_XQUIZ_STATUS."
						</th>
					</tr>";
                 
        $class = 'even';
        $delImage = "<img src= \"".XOOPS_URL."/modules/xquiz/assets/images/delete.gif \" title="._AM_XQUIZ_DEL." alt='' >";
        $validImage = "<img src= \"".XOOPS_URL."/modules/xquiz/assets/images/valid.png \" alt='' >";
        $invalidImage = "<img src= \"".XOOPS_URL."/modules/xquiz/assets/images/invalid.png \" alt='' >";
        $ts = MyTextSanitizer::getInstance();
        foreach ($list as $key) {
            $correct = ($key['answer'] == $key['userAns'])? $validImage:$invalidImage ;
            $class = ('even' == $class) ? 'odd' : 'even';
            $temp = $temp."
			<tr class='".$class."'>
				<td>
				".$key['qnumber']."-".$ts->previewTarea($key['question'], 1, 1, 1, 1, 1)."
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
        $list = [];
        $query = "SELECT * FROM ". $xoopsDB->prefix('xquiz_score') ." 
			NATURAL JOIN ". $xoopsDB->prefix('xquiz_quizzes') ." 
			WHERE userid = $uid";
        $query =$xoopsDB->query($query);
        $q = 0;
        while ($myrow = $xoopsDB->fetchArray($query)) {
            $list[$q]['id'] = $myrow['id'];
            $list[$q]['name'] = $myrow['name'];
            $list[$q]['score'] = $myrow['score'];
            $list[$q]['date'] = formatTimestamp(strtotime($myrow['date']), $dateformat);
            $list[$q]['edate'] = formatTimestamp(strtotime($myrow['edate']), $dateformat);
            
            $today = strtotime(date("Y-m-d"));
            if (strtotime($myrow['edate']) >= $today) {
                $list[$q]['active'] = true;
            } else {
                $list[$q]['active'] = false;
            }
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
    function sendEmail($user, $score, $qid)
    {
        global $xoopsConfig,$xoopsDB,$xoopsModuleConfig;
        $dateformat = $xoopsModuleConfig['dateformat'];
        
        if (!is_object($user)) {
            $user =& $GLOBALS["xoopsUser"];
        }
        $msg = sprintf(_MD_XQUIZ_EMAIL_DESC, $user->getVar("uname"));
        $msg .= "\n\n";
        $msg .= formatTimestamp(time(), $dateformat);
        $msg .= "\n";
        $msg .= _MD_XQUIZ_EMAIL_MESSAGE . ":\n";
        $msg .= _MD_XQUIZ_FINAL_SCORE." = ".$score."\n";
        $msg .=  _MD_XQUIZ_SCORE_PROFILE. ": ". XOOPS_URL . "/modules/xquiz/index.php?act=p&q=".$qid."\n";
        $msg .= $xoopsConfig['sitename'] . ": ". XOOPS_URL . "\n";
        $system_mailer = (defined('ICMS_VERSION_NAME') && ICMS_VERSION_NAME)?getMailer():xoops_getMailer();
        $xoopsMailer =&$system_mailer;
        $xoopsMailer->useMail();
        $xoopsMailer->setToEmails($user->getVar("email"));
        $xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
        $xoopsMailer->setFromName($xoopsConfig['sitename']);
        $xoopsMailer->setSubject(_MD_XQUIZ_EMAIL_SUBJECT);
        $xoopsMailer->setBody($msg);
        return $xoopsMailer->send();
    }
       
?>
