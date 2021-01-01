<?php

namespace XoopsModules\Xquiz;

/*
 Utility Class Definition

 You may not change or alter any portion of this comment or credits of
 supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit
 authors.

 This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 *
 * @license      https://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2000-2020 &copy; XOOPS Project
 * @author       Mamba <mambax7@gmail.com>
 */

use XoopsModules\Xquiz;
use XoopsModules\Xquiz\Common;
use XoopsModules\Xquiz\Common\Configurator;
use XoopsModules\Xquiz\Constants;

/**
 * Class Utility
 */
class Utility extends Common\SysUtility
{
    //--------------- Custom module methods -----------------------------
    /**
     * @param $userId
     * @param $id
     * @return bool
     */
    public static function findUserScore($userId, $id)
    {
        global $xoopsDB;
        $query = $xoopsDB->query(
            'SELECT * FROM ' . $xoopsDB->prefix('xquiz_score') . " WHERE id = $id AND userid = '$userId'"
        );

        $res = $xoopsDB->getRowsNum($query);
        if ($res > 0) {
            return true;
        } else {
            return false;
        }
    }

//    region load number of user score per id from database

    /**
     * @param $qId
     * @return int
     */
    public static function numUserScore($qId)
    {
        global $xoopsDB;
        $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('xquiz_score') . " WHERE id = $qId");
        return $xoopsDB->getRowsNum($result);
    }

//    endregion

    /**
     * @param string $tablename
     * @param string $iconname
     */
    public static function collapsableBar($tablename = '', $iconname = '')
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

// region show select quiz form
    public static function statQuizsSelectForm()
    {
        $list = Quiz::allQuizs();

        echo "<div id='newsel' style='text-align: center;'>
					<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
						<tr class='odd'>
							<td>
							<form method='get' action='main.php'\">
								<input type='hidden' name='op' value='Statistics'>
								
								<label>" . _AM_XQUIZ_QUIZS_SELECT . "
									<select name='Id'>";
        foreach ($list as $key) {
            echo "<option value='" . $key['id'] . "'>" . $key['name'] . '</option>';
        }

        echo '						</select>
								</lable>
								<label>
								' . _AM_XQUIZ_CSV_EXPORT . "
								</lable>
								<input type='checkbox' name='exp'>
								<input type='submit' value='" . _AM_XQUIZ_QUEST_GO . "'>
							</form>
							</td>
							
					</table>
				</div>";
    }

//    endregion
//    endregion
    /**
     * @param $quizId
     * @param $uid
     * @return array
     */
    public static function userQuestLoader($quizId, $uid)
    {
        global $xoopsDB;
        $list  = [];
        $query = 'SELECT * FROM ' . $xoopsDB->prefix('xquiz_useranswers') . ' 
			NATURAL JOIN ' . $xoopsDB->prefix('xquiz_quizquestion') . " 
			WHERE userId = $uid AND quizId=$quizId AND questId=id";
        $query = $xoopsDB->query($query);
        $q     = 0;
        while (false !== ($myrow = $xoopsDB->fetchArray($query))) {
            $list[$q]['questId']  = $myrow['questId'];
            $list[$q]['userAns']  = $myrow['userAns'];
            $list[$q]['qnumber']  = $myrow['qnumber'];
            $list[$q]['score']    = $myrow['score'];
            $list[$q]['answer']   = $myrow['answer'];
            $list[$q]['question'] = $myrow['question'];
            $q++;
        }
        return $list;
    }

    /**
     * @param $quizId
     * @param $uid
     */
    public static function showUserQuest($quizId, $uid)
    {
        global $memberHandler;
        $list = userQuestLoader($quizId, $uid);

        $configurator = new Configurator();
        $icons = $configurator->icons;

        $quiz      = Quiz::retrieveQuiz($quizId);
        $thisUser  = $memberHandler->getUser($uid);
        $userImage = '<img src= "' . XOOPS_URL . "/modules/xquiz/assets/images/user.png \" alt='' >";
        $quizImage = '<img src= "' . XOOPS_URL . "/modules/xquiz/assets/images/quizz.png \" alt='' >";

        self::collapsableBar('newsub', 'topnewsubicon');
        $temp = "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewsubicon' name='topnewsubicon' src='" . XOOPS_URL . "/modules/xquiz/assets/images/close12.gif' alt=''>
				 </a>&nbsp;" . _MD_XQUIZ_USER_ANSWER_DETAIL . "</h4><br>
					<div id='newsub' style='text-align: center;'>
					<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
						<tr class='odd'>
							<td>
							<a href=\"" . XOOPS_URL . '/modules/xquiz/admin/main.php?op=Statistics&Id=' . $quiz['id'] . '">' . $quizImage . $quiz['name'] . "</a>
							<a href='" . XOOPS_URL . '/userinfo.php?uid=' . $uid . "'>" . $userImage . $thisUser->getVar('uname') . "</a>
							</td>
						</tr>
					</table>
					
					<table width='100%' cellspacing='1' cellpadding='1' border='0' class='outer'>
					<tr class='bg3'>
						<th>
							" . _AM_XQUIZ_QUEST_NAME . '
						</th>
						<th>
							' . _AM_XQUIZ_QUEST_CORRECT . '
						</th>
						<th>
							' . _AM_XQUIZ_QUEST_SCORE . '
						</th>
						<th>
							' . _AM_XQUIZ_USER_ANSWER . '
						</th>
						<th>
							' . _AM_XQUIZ_STATUS . '
						</th>
					</tr>';

        $class        = 'even';
        $delImage     = '<img src= "' . XOOPS_URL . '/modules/xquiz/assets/images/delete.png " title=' . _AM_XQUIZ_DEL . " alt='' >";
        $validImage   = '<img src= "' . XOOPS_URL . "/modules/xquiz/assets/images/valid.png \" alt='' >";
        $invalidImage = '<img src= "' . XOOPS_URL . "/modules/xquiz/assets/images/invalid.png \" alt='' >";
        $ts           = \MyTextSanitizer::getInstance();
        foreach ($list as $key) {
            $correct = ($key['answer'] == $key['userAns']) ? $validImage : $invalidImage;
            $class   = ('even' == $class) ? 'odd' : 'even';
            $temp    .= "
			<tr class='" . $class . "'>
				<td>
				" . $key['qnumber'] . '-' . $ts->previewTarea($key['question'], 1, 1, 1, 1, 1) . '
				</td>
				<td>
				' . $key['answer'] . '
				</td>
				<td>
				' . $key['score'] . '
				</td>
				<td>
				' . $key['userAns'] . '
				</td>
				<td>
				' . $correct . '
				</td>
				</tr>';
        }

        $temp .= '</table></div>';
        echo $temp;
    }

    /**
     * @param $uid
     * @return array
     */
    public static function userQuizzes($uid)
    {
        global $xoopsDB, $xoopsModuleConfig;
        $dateformat = $xoopsModuleConfig['dateformat'];
        $list       = [];
        $query      = 'SELECT * FROM ' . $xoopsDB->prefix('xquiz_score') . ' 
			NATURAL JOIN ' . $xoopsDB->prefix('xquiz_quizzes') . " 
			WHERE userid = $uid";
        $query      = $xoopsDB->query($query);
        $q          = 0;
        while (false !== ($myrow = $xoopsDB->fetchArray($query))) {
            $list[$q]['id']    = $myrow['id'];
            $list[$q]['name']  = $myrow['name'];
            $list[$q]['score'] = $myrow['score'];
            $list[$q]['date']  = formatTimestamp(strtotime($myrow['date']), $dateformat);
            $list[$q]['edate'] = formatTimestamp(strtotime($myrow['edate']), $dateformat);

            $today = strtotime(date('Y-m-d'));
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
     * @param int    $score
     * @param object $user
     * @param int    $qid
     * @return     bool
     **/
    public static function sendEmail($user, $score, $qid)
    {
        global $xoopsConfig, $xoopsDB, $xoopsModuleConfig;
        $dateformat = $xoopsModuleConfig['dateformat'];

        if (!is_object($user)) {
            $user =& $GLOBALS['xoopsUser'];
        }
        $msg           = sprintf(_MD_XQUIZ_EMAIL_DESC, $user->getVar('uname'));
        $msg           .= "\n\n";
        $msg           .= formatTimestamp(time(), $dateformat);
        $msg           .= "\n";
        $msg           .= _MD_XQUIZ_EMAIL_MESSAGE . ":\n";
        $msg           .= _MD_XQUIZ_FINAL_SCORE . ' = ' . $score . "\n";
        $msg           .= _MD_XQUIZ_SCORE_PROFILE . ': ' . XOOPS_URL . '/modules/xquiz/index.php?act=p&q=' . $qid . "\n";
        $msg           .= $xoopsConfig['sitename'] . ': ' . XOOPS_URL . "\n";
        $system_mailer = (defined('ICMS_VERSION_NAME') && ICMS_VERSION_NAME) ? getMailer() : xoops_getMailer();
        $xoopsMailer   =& $system_mailer;
        $xoopsMailer->useMail();
        $xoopsMailer->setToEmails($user->getVar('email'));
        $xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
        $xoopsMailer->setFromName($xoopsConfig['sitename']);
        $xoopsMailer->setSubject(_MD_XQUIZ_EMAIL_SUBJECT);
        $xoopsMailer->setBody($msg);
        return $xoopsMailer->send();
    }


    ///////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param $start
     * @param $limit
     */
    public static function showCategories($start, $limit)
    {

        $configurator = new Configurator();
        $icons = $configurator->icons;

        global $xoopsDB;
        $xt = new Category($xoopsDB->prefix('xquiz_categories'), 'cid', 'pid');

        $listCategory = $xt->getList($start, $limit, 'title');
        //$nume = $xt->getNumberList();
        $nume = count($listCategory);
        self::collapsableBar('newsub', 'topnewsubicon');
        $temp = "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewsubicon' name='topnewsubicon' src='" . XOOPS_URL . "/modules/xquiz/assets/images/close12.gif' alt=''>
				 </a>&nbsp;" . _AM_XQUIZ_CATEGORIES . "</h4><br>
					<div id='newsub' style='text-align:left;'>
					<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
						<tr class='odd'>
							<td>
							<form method='get' action='main.php'>
							<input type='hidden' name='op' value='Category'>
							<input type='hidden' name='act' value='add'>
							<input type='submit' value='" . _AM_XQUIZ_NEW_CATEGORY . "'>
							</form>
							</td>
						</tr>
					</table>
					<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
					<tr class='bg3'>
						<th>
							" . _AM_XQUIZ_CATEGORY_TITLE . '
						</th>
						<th>
							' . _AM_XQUIZ_CATEGORY_WEIGHT . '
						</th>
						<th>
							' . _AM_XQUIZ_ACTION . '
						</th>
					</tr>';

        $class     = 'even';
        $goImage   = '<img src= "' . XOOPS_URL . '/modules/xquiz/assets/images/cat.gif " title=' . _AM_XQUIZ_EDIT . " alt='' >";

        foreach ($listCategory as $key) {
            $class = ('even' == $class) ? 'odd' : 'even';
            $temp  .= "
			<tr class='"
                      . $class
                      . "'>
				<td>&nbsp;
				"
                      . $goImage
                      . '
					<a href="'
                      . XOOPS_URL
                      . '/modules/xquiz/index.php?cid='
                      . $key['cid']
                      . '"><img src="'
                      . XOOPS_URL
                      . '/uploads/xquiz/category/'
                      . $key['imgurl']
                      . "\" width='40px' height='40px' align='left' style='padding:5px'></a>&nbsp;<a href=\""
                      . XOOPS_URL
                      . '/modules/xquiz/index.php?cid='
                      . $key['cid']
                      . '">'
                      . $key['title']
                      . '</a><br>&nbsp;<small>'
                      . $key['description']
                      . '</small>
				</td>
				<td>
				'
                      . $key['weight']
                      . '
				</td>
				<td>
				<a href="'
                      . XOOPS_URL
                      . '/modules/xquiz/admin/main.php?op=Category&act=edit&Id='
                      . $key['cid']
                      . '">
				'
                      . $icons['edit']
                      . '
				</a>
				<a href="'
                      . XOOPS_URL
                      . '/modules/xquiz/admin/main.php?op=Category&act=del&Id='
                      . $key['cid']
                      . '">
				'
                      . $icons['delete']
                      . '
				</td>
				</tr>';
        }

        $temp .= '</table></div>';
        echo $temp;

        $nav = new \XoopsPageNav($nume, $limit, $start, 'start', 'op=Category');
        echo "<div align='center'>" . $nav->renderImageNav() . '</div><br>';
    }

    /**
     * @param string $op
     * @param int    $eId
     */
    public static function CategoryForm($op = 'add', $eId = 0)
    {
        global $xoopsDB, $xoopsModule, $xoopsModuleConfig;
        $xt               = new Category($xoopsDB->prefix('xquiz_categories'), 'cid', 'pid');
        $myts             = \MyTextSanitizer::getInstance();
        $maxuploadsize    = $xoopsModuleConfig['maxuploadsize'];
        $addCategory_form = new \XoopsThemeForm(
            _AM_XQUIZ_NEW_CATEGORY, 'addcategoryfrom', XOOPS_URL . '/modules/xquiz/admin/backend.php', 'post', true
        );
        $addCategory_form->setExtra('enctype="multipart/form-data"');
        // Permissions
        $memberHandler    = xoops_getHandler('member');
        $group_list       = $memberHandler->getGroupList();
        $grouppermHandler = xoops_getHandler('groupperm');
        $full_list        = array_keys($group_list);
        ////////////////
        if ('edit' == $op) {
            $category           = $xt->getCategory($eId);
            $category_id_v      = $eId;
            $category_title_v   = htmlspecialchars($category[0]['title'], ENT_QUOTES | ENT_HTML5);
            $category_desc_v    = htmlspecialchars($category[0]['description'], ENT_QUOTES | ENT_HTML5);
            $parent             = $xt->getAllParentId($category_id_v);
            $category_parent_id = (!empty($parent)) ? $parent[0] : 0;
            $category_weight_v  = $category[0]['weight'];
            $topicimage         = htmlspecialchars($category[0]['imgurl'], ENT_QUOTES | ENT_HTML5);

            $groups_ids                    = $grouppermHandler->getGroupIds('quiz_view', $category_id_v, $xoopsModule->getVar('mid'));
            $groups_ids                    = array_values($groups_ids);
            $groups_quiz_can_view_checkbox = new \XoopsFormCheckBox(_AM_XQUIZ_VIEWFORM, 'groups_quiz_can_view[]', $groups_ids);

            $category_id = new \XoopsFormHidden('cateId', $category_id_v);
            $addCategory_form->addElement($category_id);
            $submit_button = new \XoopsFormButton('', 'editCateSubmit', _AM_XQUIZ_SUBMIT, 'submit');
        } elseif ('add' == $op) {
            $category_title_v              = '';
            $category_desc_v               = '';
            $category_parent_id            = 0;
            $category_weight_v             = 0;
            $topicimage                    = 'blank.png';
            $groups_quiz_can_view_checkbox = new \XoopsFormCheckBox(_AM_XQUIZ_VIEWFORM, 'groups_quiz_can_view[]', $full_list);
            $submit_button                 = new \XoopsFormButton('', 'addCateSubmit', _AM_XQUIZ_SUBMIT, 'submit');
        }

        $category_title = new \XoopsFormText(_AM_XQUIZ_CATEGORY_TITLE, 'cateTitle', 50, 100, $category_title_v);
        ob_start();
        $xt->makeMySelBox('title', 'cid', $category_parent_id, 1, 'cateParent');
        $category_parent = new \XoopsFormLabel(_AM_XQUIZ_CATEGORY_PARENT, ob_get_clean());
        //$category_description = new \XoopsFormDhtmlTextArea(_AM_XQUIZ_CATEGORY_DESC, "cateDesc", $category_desc_v);

        $options_tray = new \XoopsFormElementTray(_AM_XQUIZ_CATEGORY_DESC, '<br>');
        if (class_exists('XoopsFormEditor')) {
            $options['name']   = 'cateDesc';
            $options['value']  = $category_desc_v;
            $options['rows']   = 25;
            $options['cols']   = '100%';
            $options['width']  = '100%';
            $options['height'] = '600px';
            $contents_contents = new \XoopsFormEditor('', $xoopsModuleConfig['editorUser'], $options, $nohtml = false, $onfailure = 'textarea');
            $options_tray->addElement($contents_contents);
        } else {
            $contents_contents = new \XoopsFormDhtmlTextArea('', 'cateDesc', $category_desc_v);
            $options_tray->addElement($contents_contents);
        }

        $category_weight = new \XoopsFormText(_AM_XQUIZ_CATEGORY_WEIGHT, 'cateWeight', 5, 3, $category_weight_v);
        // $category_token = new \XoopsFormHidden("XOOPS_TOKEN_REQUEST", $GLOBALS['xoopsSecurity']->createToken());

        $uploadirectory = 'uploads/' . $xoopsModule->dirname() . '/category';
        $imgtray        = new \XoopsFormElementTray(_AM_XQUIZ_CATEGORYIMG, '<br>');

        $imgpath      = sprintf(_AM_XQUIZ_UPLOADEDIMG, 'uploads/' . $xoopsModule->dirname() . '/category/');
        $imageselect  = new \XoopsFormSelect($imgpath, 'topic_imgurl', $topicimage);
        $topics_array = \XoopsLists:: getImgListAsArray(XOOPS_ROOT_PATH . '/uploads/xquiz/category/');
        foreach ($topics_array as $image) {
            $imageselect->addOption($image, $image);
        }
        $imageselect->setExtra("onchange='showImgSelected(\"image3\", \"topic_imgurl\", \"" . $uploadirectory . '", "", "' . XOOPS_URL . "\")'");
        $imgtray->addElement($imageselect, false);
        $imgtray->addElement(new \XoopsFormLabel('', "<br><img src='" . XOOPS_URL . '/' . $uploadirectory . '/' . $topicimage . "' name='image3' id='image3' alt=''>"));

        $uploadfolder = sprintf(_AM_XQUIZ_UPLOAD_WARNING, XOOPS_URL . '/uploads/' . $xoopsModule->dirname() . '/category');
        $fileseltray  = new \XoopsFormElementTray('', '<br>');
        $fileseltray->addElement(new \XoopsFormFile(_AM_XQUIZ_CATEGORY_PICTURE, 'attachedfile', $maxuploadsize), false);
        $fileseltray->addElement(new \XoopsFormLabel($uploadfolder), false);
        $imgtray->addElement($fileseltray);

        $button_tray = new \XoopsFormElementTray('', '');
        $button_tray->addElement($submit_button);

        $addCategory_form->addElement($category_title, true);
        $addCategory_form->addElement($category_parent, true);
        $addCategory_form->addElement($options_tray);
        $addCategory_form->addElement($imgtray);
        $addCategory_form->addElement($category_weight, true);
        $groups_quiz_can_view_checkbox->addOptionArray($group_list);
        $addCategory_form->addElement($groups_quiz_can_view_checkbox);
        //$addCategory_form->addElement($category_token, true);
        $addCategory_form->addElement($button_tray);

        self::collapsableBar('newquiz', 'topnewquiz');
        echo "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewquiz' name='topnewquiz' src='" . XOOPS_URL . "/modules/xquiz/assets/images/close12.gif' alt=''>
		 	</a>&nbsp;" . _AM_XQUIZ_CATEGORY_NEW . "</h4><br>
				<div id='newquiz' style='text-align: center;'>";
        $addCategory_form->display();
        echo '</div>';
    }

    // create confirm form for delete question

    /**
     * @param $id
     */
    public static function confirmForm($id)
    {
        $delCategory_form = new \XoopsThemeForm(
            _AM_XQUIZ_DELCATEGORY_FORM, 'delcategoryfrom', XOOPS_URL . '/modules/xquiz/admin/backend.php', 'post', true
        );
        $category_id      = new \XoopsFormHidden('categoryId', $id);
        $category_confirm = new \XoopsFormRadioYN(_AM_XQUIZ_DELETE_CAPTION, 'delConfirm', 0);
        $submit_button    = new \XoopsFormButton('', 'delCateSubmit', _AM_XQUIZ_SUBMIT, 'submit');
        //$category_token = new \XoopsFormHidden("XOOPS_TOKEN_REQUEST", $GLOBALS['xoopsSecurity']->createToken());

        $delCategory_form->addElement($category_id);
        //$delCategory_form->addElement($category_token, true);
        $delCategory_form->addElement($category_confirm, true);
        $delCategory_form->addElement($submit_button);

        self::collapsableBar('newquiz', 'topnewquiz');
        echo "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewquiz' name='topnewquiz' src='" . XOOPS_URL . "/modules/xquiz/assets/images/close12.gif' alt=''>
				 	</a>&nbsp;" . _AM_XQUIZ_DELETE . "</h4><br>
						<div id='newquiz' style='text-align: center;'>";
        $delCategory_form->display();
        echo '</div>';
    }
    #end region


}
