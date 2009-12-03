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
class Quiz
{
	private $id,$name,$description,$bdate,$edate
			,$btime,$etime,$weight,$myts,$categoryId;
	
	/**
	 * quiz class constructor
	 *
	 */
	function __construct()
	{
		$this->myts = myTextSanitizer::getInstance();
	}
	#region set and get $id
	/**
	 * set id class variable
	 *
	 * @param int $id
	 */
	public function set_id($id)
	{
		if (!is_numeric($id))
			throw new Exception('id '._QUEST_NUMBER_ERROR);
		$this->id = $id;
	}
	/**
	 * get id class variable
	 *
	 * @return quizId
	 */
	public function get_id()
	{
		if (!isset($this->id))
			throw new Exception('id '._QUEST_SET_ERROR);
		return $this->id;
	}
	#endregion
	#region set and get $name
	/**
	 * set name class variable
	 *
	 * @param string $name
	 */
	public function set_name($name)
	{
		$this->name = $this->myts->addslashes($name);
	}
	/**
	 * get name class variable
	 *
	 * @return quizName
	 */
	public function get_name()
	{
		if (!isset($this->name))
			throw new Exception('name '._QUEST_SET_ERROR);
		return $this->name;
	}
	#endregion
	#region set and get $description
	/**
	 * set description class variable
	 *
	 * @param string $description
	 */
	public function set_description($description)
	{
		$this->description = $this->myts->addslashes($description);
	}
	/**
	 * get description of quiz
	 *
	 * @return quiz description
	 */
	public function get_description()
	{
		if (!isset($this->description))
			throw new Exception('description '._QUEST_SET_ERROR);
		return $this->description;
	}
	#endregion
	#region set and get $btime
	/**
	 * set begin date of quiz
	 *
	 * @param string $btime
	 */
	public function set_btime($btime)
	{		
		$this->btime = $this->myts->addslashes($btime);
	}
	/**
	 * get quiz begin date
	 *
	 * @return $this->btime
	 */
	public function get_btime()
	{
		if (!isset($this->btime))
			throw new Exception('btime '._QUEST_SET_ERROR);
		return $this->btime;
	}
	#endregion
	#region set and get $etime
	/**
	 * set end date of quiz
	 *
	 * @param string $etime
	 */
	public function set_etime($etime)
	{		
		$this->etime = $this->myts->addslashes($etime);
	}
	/**
	 * get end date of quiz
	 *
	 * @return $this->etime
	 */
	public function get_etime()
	{
		if (!isset($this->etime))
			throw new Exception('etime '._QUEST_SET_ERROR);
		return $this->etime;
	}
	#endregion
	#region set and get $bdate
	/**
	 * set begin date of quiz
	 *
	 * @param string $bdate
	 */
	public function set_bdate($bdate)
	{
		if (!ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $bdate))
			throw new Exception(_QUEST_VALID_BDATE);
			
		if ( (isset($this->edate)) && 
			(strtotime($this->edate)+$this->etime <= strtotime($bdate)+$this->btime ) )
			throw new Exception(_QUEST_EDATE);
			
		$t = strtotime($this->myts->addslashes($bdate)) + $this->btime;	
		$this->bdate = date("Y-m-d G:i:s",$t);
	}
	/**
	 * get quiz begin date
	 *
	 * @return $this->bdate
	 */
	public function get_bdate()
	{
		if (!isset($this->bdate))
			throw new Exception('bdate '._QUEST_SET_ERROR);
		return $this->bdate;
	}
	#endregion
	#region set and get $edate
	/**
	 * set end date of quiz
	 *
	 * @param string $edate
	 */
	public function set_edate($edate)
	{
		if (!ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $edate))
			throw new Exception(_QUEST_VALID_EDATE);
			
		if ( (isset($this->bdate) ) && 
			(strtotime($this->bdate)+$this->btime >= strtotime($edate)+$this->etime ) )
			throw new Exception(_QUEST_BDATE);

		$t = strtotime($this->myts->addslashes($edate)) + $this->etime;	
		$this->edate = date("Y-m-d G:i:s",$t);
	}
	/**
	 * get end date of quiz
	 *
	 * @return $this->edate
	 */
	public function get_edate()
	{
		if (!isset($this->edate))
			throw new Exception('edate '._QUEST_SET_ERROR);
		return $this->edate;
	}
	#endregion
	#region set and get $weight
	/**
	 * set weight of quiz
	 *
	 * @param int $weight
	 */
	public function set_weight($weight)
	{
		if (!is_numeric($weight))
			throw new Exception('weight '._QUEST_NUMBER_ERROR);
		$this->weight = $weight;
	}
	/**
	 * get weight of quiz
	 *
	 * @return $this->weight
	 */
	public function get_weight()
	{
		if (!isset($this->weight))
			throw new Exception('weight '._QUEST_SET_ERROR);
		return $this->weight;
	}
	#endregion
	#region set and get $id
	/**
	 * set Category of quiz
	 *
	 * @param int $cid
	 */
	public function set_cid($cid)
	{
		if (!is_numeric($cid))
			throw new Exception('cid '._QUEST_NUMBER_ERROR);
		$this->categoryId = $cid;
	}
	/**
	 * get category of quiz
	 *
	 * @return cid
	 */
	public function get_cid()
	{
		if (!isset($this->categoryId))
			throw new Exception('cid '._QUEST_SET_ERROR);
		return $this->categoryId;
	}
	#endregion
	
	/**
	 * add new quiz into database
	 * with class variable
	 */
	public function addQuiz()
	{
		global $xoopsDB;
		$query = "Insert into ".$xoopsDB->prefix("quiz")."(id ,name ,description ,bdate ,edate ,weight ,cid)
				VALUES (NULL , '$this->name', '$this->description', '$this->bdate', '$this->edate', '$this->weight', '$this->categoryId');";
		$res = $xoopsDB->query($query);
		
		if(!$res)
			throw new Exception(_QUEST_DATABASE);
	}
	
	/**
	 * delete quiz from database
	 *
	 */
	public function deleteQuiz()
	{
		global $xoopsDB;

		$query = "DELETE FROM ".$xoopsDB->prefix("quiz")." WHERE  
					  id = '$this->id' ";
		$res = $xoopsDB->query($query);
		xoops_comment_delete($xoopsModule->getVar('mid'), $this->id); 
		
		if(!$res)
			throw new Exception(_QUEST_DATABASE);
			
		$query = "DELETE FROM ".$xoopsDB->prefix("question")." WHERE  
					  qid = '$this->id' ";
		if(!$res)
			throw new Exception(_QUEST_DATABASE);
	}
	
	/**
	 * edit quiz in database
	 * with class vriable
	 */
	public function editQuiz()
	{
		global $xoopsDB;
		$query = "UPDATE ".$xoopsDB->prefix("quiz")." SET 
					  name = '$this->name'
					 ,description = '$this->description'
					 ,bdate = '$this->bdate'
					 ,edate = '$this->edate'
					 ,weight = '$this->weight'
					 ,cid = '$this->categoryId'
					 WHERE id = '$this->id' ";
		$res = $xoopsDB->query($query);
		
		if(!$res)
			throw new Exception(_QUEST_DATABASE);
	}
	
	public function checkExistQuiz()
	{
		global $xoopsDB;	
		$query = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("quiz")." WHERE name LIKE '$this->name'");
			$res = $xoopsDB->getRowsNum($query);

			if($res > 0)
				return true;
			else 
				return false;
	}
	
	public static function retriveQuiz($qId)
	{
		global $xoopsDB;
		$query =$xoopsDB->query("SELECT * FROM ". $xoopsDB->prefix('quiz') ." WHERE id = '$qId'");
		$myrow = $xoopsDB->fetchArray($query);
		return $myrow;		
	}
	
	public static function QuizForm($op = "add" ,$eId = 0)
	{	
		global $xoopsDB,$xoopsModuleConfig;
		//check for category existance
		$xt = new Category($xoopsDB->prefix('quiz_cat'), 'cid', 'pid');
		if (!$xt->getChildTreeArray(0))
					throw new Exception(_QUIZ_NO_CATEGORY);
		$addQuiz_form = new XoopsThemeForm(_AM_QUIZ_NEW, "addquizfrom", 
						XOOPS_URL.'/modules/quiz/admin/backend.php','post',true);
		
		if ($op == "edit")
		{
			$quiz = Quiz::retriveQuiz($eId);
			$quiz_id_v = $quiz['id']; 
			$quiz_name_v = $quiz['name'];
			$quiz_category_id = $quiz['cid'];
			$quiz_desc_v = $quiz['description'];
			$quiz_bdate_v = strtotime($quiz['bdate']);
			$quiz_edate_v = strtotime($quiz['edate']);
			$quiz_weight_v = $quiz['weight'];
			$quiz_id = new XoopsFormHidden("quizId",$quiz_id_v);
			$addQuiz_form->addElement($quiz_id);
			$submit_button = new XoopsFormButton("", "editQuizSubmit", _QUIZ_SUBMIT, "submit");
		}
		elseif ($op == "add")
		{
			$quiz_name_v = "";
			$quiz_category_id = 0;
			$quiz_desc_v = "";
			$quiz_bdate_v = time()+(3600*24*2);
			$quiz_edate_v = time()+(3600*24*16);
			$quiz_weight_v = 0;
			$submit_button = new XoopsFormButton("", "addQuizSubmit", _QUIZ_SUBMIT, "submit");
		} 
		$quiz_name = new XoopsFormText(_QUIZ_NAME, "quizName", 50, 100, $quiz_name_v);
		ob_start();
		$xt->makeMySelBox("title", "cid ASC", $quiz_category_id,0 ,'quizCategory');
		$quiz_category = new XoopsFormLabel(_QUIZ_CATEGORY, ob_get_contents());
		ob_end_clean();
		$quiz_begin_date = new XoopsFormDateTime(_QUIZ_BDATE, "quizBDate",15,$quiz_bdate_v);
		$quiz_end_date = new XoopsFormDateTime(_QUIZ_EDATE, "quizEDate",15,$quiz_edate_v);
		$quiz_weight = new XoopsFormText(_QUIZ_WEIGHT, "quizWeight", 5, 3, $quiz_weight_v);
		$quiz_token = new XoopsFormHidden("XOOPS_TOKEN_REQUEST",$GLOBALS['xoopsSecurity']->createToken());
	
		$options_tray = new XoopsFormElementTray( _QUIZ_DESC, '<br />' );
		if ( class_exists( 'XoopsFormEditor' ) ) {
			$options['name'] = 'quizDesc';
			$options['value'] = $quiz_desc_v;
			$options['rows'] = 25;
			$options['cols'] = '100%';
			$options['width'] = '100%';
			$options['height'] = '600px';
			$contents_contents = new XoopsFormEditor( '', $xoopsModuleConfig['use_wysiwyg'], $options, $nohtml = false, $onfailure = 'textarea' );
			$options_tray->addElement( $contents_contents );
		} else {
			$contents_contents = new XoopsFormDhtmlTextArea( '', 'quizDesc', $quiz_desc_v );
			$options_tray->addElement( $contents_contents );
		}
		
		$addQuiz_form->addElement($quiz_name, true);
		$addQuiz_form->addElement($quiz_category, true);
		$addQuiz_form->addElement($options_tray, true);
		$addQuiz_form->addElement($quiz_begin_date,true);
		$addQuiz_form->addElement($quiz_end_date,true);
		$addQuiz_form->addElement($quiz_weight, true);
		$addQuiz_form->addElement($quiz_token, true);
		$addQuiz_form->addElement($submit_button);
		
		quiz_collapsableBar('newquiz', 'topnewquiz');
		echo "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewquiz' name='topnewquiz' src='" .
				 	XOOPS_URL . "/modules/quiz/images/close12.gif' alt='' />
				 	</a>&nbsp;"._AM_QUIZ_NEW."</h4><br/>
						<div id='newquiz' style='text-align: center;'>";
		$addQuiz_form->display();
		echo "</div>";	
	}
	
	public static function showQuizs($start ,$limit ,$categoryId = -1)
	{
		global $xoopsDB;
		$xt = new Category($xoopsDB->prefix('quiz_cat'), 'cid', 'pid');
		ob_start();
		$xt->makeMySelBox("title","cid" ,0 ,1 ,'Id','',1);
		$select = ob_get_contents();
		ob_end_clean();
		
		$nume = self::quiz_numQuizLoader();
		
		$listQuiz = self::quiz_listQuizLoader($start,$limit,$categoryId);
		quiz_collapsableBar('newsub', 'topnewsubicon');
		$temp = "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewsubicon' name='topnewsubicon' src='" .
				 XOOPS_URL . "/modules/quiz/images/close12.gif' alt='' />
				 </a>&nbsp;"._QUIZ_QUIZS."</h4><br/>
					<div id='newsub' style='text-align: center;'>
					<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
						<tr class='odd'>
							<td>
							<form method='get' action='index.php'>
							<input type='hidden' name='op' value='Quiz'>
							<input type='hidden' name='act' value='add'>
							<img src= \"".XOOPS_URL."/modules/quiz/images/new.png \" >
							<input type='submit' value='"._AM_NEW_QUIZ."'>
							</form>
							</td>
							<td>
							<form method='get' action='index.php'\">
								<input type='hidden' name='op' value='Quiz'>
								<lable>"._QUIZ_CATEGORY_SELECT."
				 				$select
								</lable>
								<input type='submit' value='"._AM_QUEST_GO."'>
							</form>
							</td>
						</tr>
					</table>
					<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
					<tr class='bg3'>
						<td>
							"._QUIZ_NAME."
						</td>
						<td>
							"._QUIZ_CATEGORY."
						</td>
						<td>
							"._QUIZ_QUEST_NUM."
						</td>
						<td>
							"._QUIZ_BDATE."
						</td>
						<td>
							"._QUIZ_EDATE."
						</td>
						<td>
							"._QUIZ_WEIGHT."
						</td>
						<td>
							"._QUIZ_ACTION."
						</td>
					</tr>";
				 
		$class = 'even';
		$onImage = "<img src= \"".XOOPS_URL."/modules/quiz/images/on.png \" >";
		$offImage = "<img src= \"".XOOPS_URL."/modules/quiz/images/off.png \" >";
		$delImage = "<img src= \"".XOOPS_URL."/modules/quiz/images/delete.gif \" title="._QUIZ_DEL." alt='' >";
		$editImage = "<img src= \"".XOOPS_URL."/modules/quiz/images/edit.gif \" title="._QUIZ_EDIT." alt='' >";
		$statImage = "<img src= \"".XOOPS_URL."/modules/quiz/images/stat.gif \" title="._QUIZ_STAT." alt='' >";
		$addImage = "<img src= \"".XOOPS_URL."/modules/quiz/images/add.png \" title="._QUIZ_QUEST_ADD." alt='' >";
		$exportImage = "<img src= \"".XOOPS_URL."/modules/quiz/images/export.png \" title="._QUIZ_CSV_EXPORT." alt='' >";
		
		foreach ($listQuiz as $key)
		{
			$status = ($key['status']) ? $onImage:$offImage;
			$active = ($key['active']) ? $onImage:$offImage;
			//$statEdit = (!$key['active']) ? $statImage:$editImage;
			$questLink = ((!$key['status'])&&($key['active']))?
					"<a href=\"".XOOPS_URL."/modules/quiz/admin/index.php?op=Quest&act=add&Id="
						.$key['id']."\">".$addImage." ".$key['question']."
					</a>":$key['question'];
			$category = Category::retriveCategory($key['cid']);
			$quizCategory = "<a href=\"".XOOPS_URL."/modules/quiz/index.php?cid="
						.$category['cid']."\">".$category['title']."</a>";
									
			$class = ($class == 'even') ? 'odd' : 'even';
			
			$temp = $temp."
			<tr class='".$class."'>
				<td>
					<a href=\"".XOOPS_URL."/modules/quiz/index.php?act=v&q=".$key['id']."\">".$key['name']."</a>
				</td>
				<td>
					".$quizCategory."
				</td>
				<td>
					".$questLink."
				</td>
				<td>
				"
				.$status . "  " 
				.$key['bdate'].
				"
				</td>
				<td>
				"
				.$active . "  "
				.$key['edate']."
				</td>
				<td>
				"
				.$key['weight']."
				</td>
				<td>
				<a href=\"".XOOPS_URL."/modules/quiz/admin/index.php?op=Quiz&act=del&Id=".$key['id']."\">
				".
				$delImage
				."
				</a>
				<a href=\"".XOOPS_URL."/modules/quiz/admin/index.php?op=Quiz&act=edit&Id=".$key['id']."\">
				".
				$editImage
				."
				</a>
				<a href=\"".XOOPS_URL."/modules/quiz/admin/index.php?op=Stat&Id=".$key['id']."\">
				".
				$statImage
				."
				</a>
				<a href=\"".XOOPS_URL."/modules/quiz/admin/index.php?op=Stat&Id=".$key['id']."&exp=on\">
				".
				$exportImage
				."
				</a>
				</td>
				</tr>";
		}
		
		$temp = $temp."</table></div>";
		echo $temp;	
		$nav  = new XoopsPageNav($nume ,$limit ,$start ,'start',"op=Quiz" );
		echo "<div align='center'>".$nav->renderImageNav().'</div><br />';		
	}
	
	public static function confirmForm($id)
	{
	$delQuiz_form = new XoopsThemeForm(_QUIZ_DELQUIZFORM, "delquizfrom", 
					XOOPS_URL.'/modules/quiz/admin/backend.php','post',true);
	$quiz_id = new XoopsFormHidden("quizId",$id);
	$quiz_confirm = new XoopsFormRadioYN(_QUIZ_DELETE_CAPTION,"delConfirm",0);
	$submit_button = new XoopsFormButton("", "delQuizSubmit", _QUIZ_SUBMIT, "submit");
	$quiz_token = new XoopsFormHidden("XOOPS_TOKEN_REQUEST",$GLOBALS['xoopsSecurity']->createToken());
	
	$delQuiz_form->addElement($quiz_id);
	$delQuiz_form->addElement($quiz_token, true);
	$delQuiz_form->addElement($quiz_confirm,true);
	$delQuiz_form->addElement($submit_button);
	
	quiz_collapsableBar('newquiz', 'topnewquiz');
	echo "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewquiz' name='topnewquiz' src='" .
				 XOOPS_URL . "/modules/quiz/images/close12.gif' alt='' />
				 </a>&nbsp;".DELQUIZFORM."</h4><br/>
					<div id='newquiz' style='text-align: center;'>";
	$delQuiz_form->display();
	echo "</div>";
	}
	
	public static function quiz_numQuizLoader()
	{
		global $xoopsDB;
		$result = $xoopsDB->query(" SELECT * FROM " . $xoopsDB->prefix('quiz') );
		return $xoopsDB->getRowsNum($result);
	}

	public static function quiz_listQuizLoader($eu ,$limit ,$categoryId = -1 )
	{
		global $xoopsDB,$xoopsModuleConfig;
		$dateformat = $xoopsModuleConfig['dateformat'];
		$listQuiz = array();
		$q=1;
		$query = ' SELECT * FROM ' . $xoopsDB->prefix('quiz');
		if ($categoryId >= 0 )
			$query .=' WHERE cid = '.$categoryId ;
		$query .= ' LIMIT '.$eu.' , '.$limit;
			
		
		$query = $xoopsDB->query($query);
		while($myrow = $xoopsDB->fetchArray($query) )
		{
			$listQuiz[$q]['id'] = $myrow['id'];
			$listQuiz[$q]['name'] = $myrow['name'];
			$listQuiz[$q]['description'] = $myrow['description'];
			$listQuiz[$q]['cid'] = $myrow['cid'];
			$listQuiz[$q]['bdate'] = formatTimestamp(strtotime($myrow['bdate']),$dateformat);
			$listQuiz[$q]['edate'] = formatTimestamp(strtotime($myrow['edate']),$dateformat);	
			$listQuiz[$q]['weight'] = $myrow['weight'];
			$listQuiz[$q]['question'] = question::question_numQuestionLoader($myrow['id']);
			
			$today = strtotime(date("Y-m-d"));
			if (strtotime($myrow['bdate']) <= $today) 
				$listQuiz[$q]['status'] = true;
			else
				$listQuiz[$q]['status'] = false;
			
			if (strtotime($myrow['edate']) >= $today) 
				$listQuiz[$q]['active'] = true;
			else	
				$listQuiz[$q]['active'] = false;
			$q++;
		}
		return $listQuiz;
	}
	
	public static function allQuizs()
	{
		global $xoopsDB;
		$listQuiz = array();
		$q=1;
		$query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('quiz').' ORDER BY id DESC');
		while($myrow = $xoopsDB->fetchArray($query) )
		{
			$listQuiz[$q]['id'] = $myrow['id'];
			$listQuiz[$q]['name'] = $myrow['name'];
			$q++;
		}
		return $listQuiz;
	}
	public static function quiz_listQuizArray()
	{
		global $xoopsDB;
		$listQuiz = array();
		$query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('quiz').' ORDER BY \'bdate\' ASC');
		while($myrow = $xoopsDB->fetchArray($query) )
			$listQuiz[$myrow['id']] = $myrow['name'];
		return $listQuiz;
	}	
	
	public static function quiz_checkActiveQuiz($id)
	{
		global $xoopsDB;
		$query = $xoopsDB->query(' SELECT bdate FROM ' . $xoopsDB->prefix('quiz').' WHERE id = '.$id);
		$myrow = $xoopsDB->fetchArray($query) ;
			$today = strtotime(date("Y-m-d"));
			if(strtotime($myrow['bdate']) <= $today)
				return true;
			else
				return false;
	}
	
	public static function quiz_checkExpireQuiz($id)
	{
		global $xoopsDB;
		$query = $xoopsDB->query(' SELECT edate FROM ' . $xoopsDB->prefix('quiz').' WHERE id = '.$id);
		$myrow = $xoopsDB->fetchArray($query) ;
			$today = strtotime(date("Y-m-d"));
			if(strtotime($myrow['edate']) >= $today)
				return true;
			else	
				return false;
	}
	public static function quiz_quizName($id)
	{
		global $xoopsDB;
		$query = $xoopsDB->query(' SELECT name,cid,description FROM '
			 . $xoopsDB->prefix('quiz').' WHERE id = '.$id);
		$myrow = $xoopsDB->fetchArray($query) ;
		$category = Category::retriveCategory($myrow['cid']);
		$arr = array('name'=>$myrow['name'],'description'=>$myrow['description']
				,'cid'=>$myrow['cid'],'category'=>$category['title']);
		return $arr;
	}
	public static function quiz_quizCategory($id)
	{
		global $xoopsDB;
		$query = $xoopsDB->query(' SELECT cid FROM ' . $xoopsDB->prefix('quiz').' WHERE id = '.$id);
		$myrow = $xoopsDB->fetchArray($query) ;
		return $myrow['cid'];
	}
	
	public static function quiz_checkExistQuiz($id)
	{
		global $xoopsDB;	
		$query = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("quiz")." WHERE id = '$id'");
		$res = $xoopsDB->getRowsNum($query);
		if($res > 0)
			return true;
		else 
			return false;
	}

}
?>