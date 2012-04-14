<?php
include_once 'answer.php';
class questions {
	
	/**
	 * 
	 */
	
	private $id, $qid, $qnumber, $type, $question, $score, $answers;
	public static $qTypes = array ('MC' => _QUIZ_ANSWER_TYPE_MC, 'CM' => _QUIZ_ANSWER_TYPE_CM, 'FB' => _QUIZ_ANSWER_TYPE_FB );
	
	/**
	 * @return String
	 */
	public function getAnswers() {
		return $this->answers;
	}
	
	/**
	 * @return Integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return Integer
	 */
	public function getQid() {
		return $this->qid;
	}
	
	/**
	 * @return Integer
	 */
	public function getQnumber() {
		return $this->qnumber;
	}
	
	/**
	 * @return String
	 */
	public function getQuestion() {
		return $this->question;
	}
	
	/**
	 * @return Integer
	 */
	public function getScore() {
		return $this->score;
	}
	
	/**
	 * @return String
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * @param String $answers
	 */
	public function setAnswers() {
	}
	
	/**
	 * @param Integer $id
	 */
	public function setId($id) {
		$this->id = intval ( $id );
	}
	
	/**
	 * @param Integer $qid
	 */
	public function setQid($qid) {
		$this->qid = intval ( $qid );
	}
	
	/**
	 * @param Integer $qnumber
	 */
	public function setQnumber($qnumber) {
		$this->qnumber = intval ( $qnumber );
	}
	
	/**
	 * @param String $question
	 */
	public function setQuestion($question) {
		$this->question = mysql_real_escape_string ( $question );
	}
	
	/**
	 * @param Integer $score
	 */
	public function setScore($score) {
		$this->score = intval ( $score );
	}
	
	/**
	 * @param String $type
	 */
	public function setType($type) {
		$this->type = mysql_real_escape_string ( $type );
	}
	function __construct() {
		//TODO - Insert your code here
		$this->answers = array ();
	}
	
	/**
	 * 
	 */
	function __destruct() {
		
	//TODO - Insert your code here
	}
	
	/*
	 * List question from database
	 * @param Integer $eu
	 * @param Integer $qid
	 * @param Integer $limit
	 * @return array
	 * @TODO List questions from database for specific quiz
	 */
	public static function questions_list($eu, $limit, $qid) {
		global $xoopsDB;
		$listQuiz = array ();
		$q = 1;
		$query = $xoopsDB->query ( ' SELECT * FROM ' . $xoopsDB->prefix ( 'quiz_questions' ) . ' WHERE quiz_id = ' . $qid . ' LIMIT ' . $eu . ' , ' . $limit );
		while ( $myrow = $xoopsDB->fetchArray ( $query ) ) {
			$listQuiz [$q] ['id'] = $myrow ['question_id'];
			$listQuiz [$q] ['qid'] = $myrow ['quiz_id'];
			$listQuiz [$q] ['question'] = $myrow ['question'];
			$listQuiz [$q] ['qnumber'] = $myrow ['qnumber'];
			$listQuiz [$q] ['score'] = $myrow ['score'];
			$listQuiz [$q] ['type'] = $myrow ['question_type'];
			$q ++;
		}
		return $listQuiz;
	}
	/*
	 * Number of all question 
	 * @param Integer $qid
	 * @return Integer
	 * @TODO Number of questions in database
	 */
	public static function questions_numOfQuestions($qId) {
		global $xoopsDB;
		$result = $xoopsDB->query ( "SELECT * FROM " . $xoopsDB->prefix ( 'quiz_questions' ) . " WHERE quiz_id = $qId" );
		return $xoopsDB->getRowsNum ( $result );
	}
	
	/*
	 * show questions list
	 * @param Integer $start
	 * @param Integer $qid
	 * @param Integer $limit
	 * @return array
	 * @TODO show questions list
	 */
	public static function showQuestions($start, $limit, $qid) {
		$nume = self::questions_numOfQuestions ( $qid );
		$listQuestion = array ();
		$listQuestion = self::questions_list ( $start, $limit, $qid );
		
		quiz_collapsableBar ( 'newsub', 'topnewsubicon' );
		$temp = "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewsubicon' name='topnewsubicon' src='" . XOOPS_URL . "/modules/quiz/images/close12.gif' alt='' />
				 </a>&nbsp;" . _QUIZ_QUESTIONS . "</h4><br/>
					<div id='newsub' style='text-align: center;'>
					<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
					<tr class='bg3'>
						<th>
							" . _QUEST_NUM . "
						</th>
						<th>
							" . _QUEST_SCORE . "
						</th>
						<th>
							" . _QUIZ_ANSWER_TYPE . "
						</th>
						<th>
							" . _QUIZ_ACTION . "
						</th>
					</tr>";
		
		$class = 'even';
		
		$delImage = "<img src= \"" . XOOPS_URL . "/modules/quiz/images/delete.gif \" title=" . _QUIZ_DEL . " alt='' >";
		$editImage = "<img src= \"" . XOOPS_URL . "/modules/quiz/images/edit.gif \" title=" . _QUIZ_EDIT . " alt='' >";
		//$ts = & MyTextSanitizer::getInstance ();
		foreach ( $listQuestion as $key ) {
			$class = ($class == 'even') ? 'odd' : 'even';
			
			$temp = $temp . "
			<tr class='" . $class . "'>
				<td>
					" . $key ['qnumber'] . "
				</td>
				<td>
				" . $key ['score'] . "
				</td>
				<td>
				" . self::$qTypes [$key ['type']] . "
				</td>
				<td>
				<a href=\"" . XOOPS_URL . "/modules/quiz/admin/index.php?op=Qst&act=del&Id=" . $key ['id'] . "\">
				" . $delImage . "
				</a>
				<a href=\"" . XOOPS_URL . "/modules/quiz/admin/index.php?op=Qst&act=edit&Id=" . $key ['id'] . "&qId=" . $key ['qid'] . "\">
				" . $editImage . "
				</a>
				</td>
				</tr>";
		}
		
		$temp = $temp . "</table></div>";
		echo $temp;
		$nav = new XoopsPageNav ( $nume, $limit, $start, 'start', "op=Qst&Id=$qid" );
		echo "<div align='center'>" . $nav->renderImageNav () . '</div><br />';
	
	}
	/*
	 * @TODO add question form
	 * @para Integer $quizId
	 * @para String $type
 	 * @return String
 	 */
	public static function QuestAddForm($qId, $type = 'MC') {
		$addQuest_form = new XoopsThemeForm ( _AM_QUEST_FORM, "addquestfrom", XOOPS_URL . '/modules/quiz/admin/backend.php', 'post', true );
		
		$question_qid_v = $qId;
		$question_question_v = '';
		$question_number_v = questions::questionNumber ( $qId ) + 1;
		
		$submit_button = new XoopsFormButton ( "", "addQstSubmit", _QUIZ_SUBMIT, "submit" );
		$quest_list_array_v = Quiz::quiz_listQuizArray ();
		$quiz_name = new XoopsFormSelect ( _QUIZ_NAME, "quizId", $question_qid_v );
		$quiz_name->addOptionArray ( $quest_list_array_v );
		$question_number = new XoopsFormText ( _QUEST_NUMBER, "questionNumber", 15, 5, $question_number_v );
		$question_score = new XoopsFormText ( _QUEST_SCORE, "questionScore", 15, 5 );
		global $xoopsModuleConfig;
		$options_tray = new XoopsFormElementTray ( _QUEST_DESC, '<br />' );
		if (class_exists ( 'XoopsFormEditor' )) {
			$options ['name'] = 'questionDesc';
			$options ['value'] = $question_question_v;
			$options ['rows'] = 15;
			$options ['cols'] = '100%';
			$options ['width'] = '100%';
			$options ['height'] = '400px';
			$contents_contents = new XoopsFormEditor ( '', $xoopsModuleConfig ['use_wysiwyg'], $options );
			$options_tray->addElement ( $contents_contents );
		} else {
			$contents_contents = new XoopsFormDhtmlTextArea ( _QUEST_DESC, "questionDesc", $question_question_v );
			$options_tray->addElement ( $contents_contents );
		}
		switch ($type) {
			case 'CM' :
				$cor_val = 'checkbox';
				$thead = "<th>" . _QUEST_ANSWER . "</th>";
				break;
			case 'FB' :
				$cor_val = 'blank';
				break;
			default :
				$cor_val = 'radio';
				$thead = "<th>" . _QUEST_ANSWER . "</th>";
		}
		ob_start ();
		$addImage = "<img src= \"" . XOOPS_URL . "/modules/quiz/images/Add_Ans.png \" title=" . _QUIZ_ADD_ANSWER . ">";
		echo "<script type='text/javascript' src='" . XOOPS_URL . "/modules/quiz/js/table.js'></script>
			<table width='100%' cellspacing='1' cellpadding='3' border='0' id='tblQuiz' >
				<thead>
					<tr>
						<th colspan='5'>
						$addImage
						<input type='button' value='" . _QUIZ_ADD_ANSWER . "' onclick='xquiz_addRowToTable(null,\"$cor_val\");' />
						</th>
					</tr>
					<tr>
						<th>#</th>
						$thead
						<th>" . _QUIZ_ANSWER_TEXT . "</th>
						<th>" . _QUIZ_DELET_ANS . "</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>";
		
		$ansFormTable = new XoopsFormLabel ( _QUIZ_ANSWERS_LABEL, ob_get_contents () );
		ob_end_clean ();
		
		$question_type = new XoopsFormHidden ( "type", $type );
		$question_token = new XoopsFormHidden ( "XOOPS_TOKEN_REQUEST", $GLOBALS ['xoopsSecurity']->createToken () );
		
		$addQuest_form->addElement ( $quiz_name, true );
		$addQuest_form->addElement ( $question_number, true );
		$addQuest_form->addElement ( $question_score, true );
		$addQuest_form->addElement ( $options_tray );
		$addQuest_form->addElement ( $ansFormTable );
		$addQuest_form->addElement ( $question_token, true );
		$addQuest_form->addElement ( $question_type, true );
		$addQuest_form->addElement ( $submit_button, true );
		
		quiz_collapsableBar ( 'newquiz', 'topnewquiz' );
		echo "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewquiz' name='topnewquiz' src='" . XOOPS_URL . "/modules/quiz/images/close12.gif' alt='' />
				 	</a>&nbsp;" . _AM_QUEST_NEW . "</h4><br/>
						<div id='newquiz' style='text-align: center;'>";
		$addQuest_form->display ();
		echo "</div>";
	}
	
	/*
	 * @TODO edit question form
	 * @para Integer $questId
 	 * @return String
 	 */
	public function QuestEditForm($questId) {
		$editQuest_form = new XoopsThemeForm ( _AM_QUEST_FORM, "editquestfrom", XOOPS_URL . '/modules/quiz/admin/backend.php', 'post', true );
		
		$this->retriveQuestion ( $questId );
		////////////////////temp
		$question_id = new XoopsFormHidden ( "questionId", $this->getId () );
		////////
		$question_number = new XoopsFormText ( _QUEST_NUMBER, "questionNumber", 15, 5, $this->getQnumber () );
		
		$submit_button = new XoopsFormButton ( "", "editQstSubmit", _QUIZ_SUBMIT, "submit" );
		
		$quest_list_array_v = Quiz::quiz_listQuizArray ();
		$quiz_name = new XoopsFormSelect ( _QUIZ_NAME, "quizId", $this->getQid () );
		$quiz_name->addOptionArray ( $quest_list_array_v );
		$question_score = new XoopsFormText ( _QUEST_SCORE, "questionScore", 15, 5, $this->getScore () );
		global $xoopsModuleConfig;
		$options_tray = new XoopsFormElementTray ( _QUEST_DESC, '<br />' );
		if (class_exists ( 'XoopsFormEditor' )) {
			$options ['name'] = 'questionDesc';
			$options ['value'] = $this->getQuestion ();
			$options ['rows'] = 15;
			$options ['cols'] = '100%';
			$options ['width'] = '100%';
			$options ['height'] = '400px';
			$contents_contents = new XoopsFormEditor ( '', $xoopsModuleConfig ['use_wysiwyg'], $options );
			$options_tray->addElement ( $contents_contents );
		} else {
			$contents_contents = new XoopsFormDhtmlTextArea ( _QUEST_DESC, "questionDesc", $this->getQuestion () );
			$options_tray->addElement ( $contents_contents );
		}
		$strAdd = "";
		$addImage = "<img src= \"" . XOOPS_URL . "/modules/quiz/images/Add_Ans.png \" title=" . _QUIZ_ADD_ANSWER . ">";
		$delImage = "<img src= \"" . XOOPS_URL . "/modules/quiz/images/delete.png \" onclick = 'xquiz_deleteCurrentRow(this)' title=" . _QUIZ_DELET_ANS . ">";
		switch ($this->type) {
			case 'CM' :
				$cor_val = 'checkbox';
				$thead = "<th>" . _QUEST_ANSWER . "</th>";
				$i = 1;
				foreach ( $this->answers as $answer ) {
					$check = '';
					if ($answer->getIs_correct () == 1)
						$check = " checked='checked'";
					$strAdd .= "
					<tr class='classy" . $i % 2 . "'>
						<td>$i</td>
						<td>
							<input type='checkbox' name='corrects[$i]' $check/>
						</td>
						<td>
							<input type='text' name='answers[$i]' size='40' value='" . $answer->getAnswer () . "'/>
						</td>
						<td>
							" . $delImage . "
						</td>
					</tr>";
					$i ++;
				}
				
				break;
			case 'FB' :
				$cor_val = 'blank';
				$thead = '';
				$i = 1;
				foreach ( $this->answers as $answer ) {
					$strAdd .= "
					<tr class='classy" . $i % 2 . "'>
						<td>$i</td>
						<td>
							<input type='text' name='answers[$i]' size='40' value='" . $answer->getAnswer () . "'/>
						</td>
						<td>
							" . $delImage . "
						</td>
					</tr>";
					$i ++;
				}
				break;
			default :
				$cor_val = 'radio';
				$thead = "<th>" . _QUEST_ANSWER . "</th>";
				$i = 1;
				foreach ( $this->answers as $answer ) {
					$check = '';
					if ($answer->getIs_correct () == 1)
						$check = " checked='checked'";
					$strAdd .= "
					<tr class='classy" . $i % 2 . "'>
						<td>$i</td>
						<td>
							<input type='radio' name='corrects' value='$i' $check/>
						</td>
						<td>
							<input type='text' name='answers[$i]' size='40' value='" . $answer->getAnswer () . "'/>
						</td>
						<td>
							" . $delImage . "
						</td>
					</tr>";
					$i ++;
				}
		}
		ob_start ();
		echo "<script type='text/javascript' src='" . XOOPS_URL . "/modules/quiz/js/table.js'></script>
			<table width='100%' cellspacing='1' cellpadding='3' border='0' id='tblQuiz' >
				<thead>
					<tr>
						<th colspan='5'>
						$addImage
						<input type='button' value='" . _QUIZ_ADD_ANSWER . "' onclick='xquiz_addRowToTable(null,\"$cor_val\");' />
						</th>
					</tr>
					<tr>
						<th>#</th>
						$thead
						<th>" . _QUIZ_ANSWER_TEXT . "</th>
						<th>" . _QUIZ_DELET_ANS . "</th>
					</tr>
				</thead>
				<tbody>
				$strAdd
				</tbody>
			</table>";
		
		$ansFormTable = new XoopsFormLabel ( _QUIZ_ANSWERS_LABEL, ob_get_contents () );
		ob_end_clean ();
		
		$question_type = new XoopsFormHidden ( "type", $this->getType () );
		$question_token = new XoopsFormHidden ( "XOOPS_TOKEN_REQUEST", $GLOBALS ['xoopsSecurity']->createToken () );
		
		$editQuest_form->addElement ( $question_id );
		$editQuest_form->addElement ( $quiz_name, true );
		$editQuest_form->addElement ( $question_number, true );
		$editQuest_form->addElement ( $question_score, true );
		$editQuest_form->addElement ( $options_tray );
		$editQuest_form->addElement ( $ansFormTable );
		$editQuest_form->addElement ( $question_token, true );
		$editQuest_form->addElement ( $question_type, true );
		$editQuest_form->addElement ( $submit_button, true );
		
		quiz_collapsableBar ( 'newquiz', 'topnewquiz' );
		echo "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewquiz' name='topnewquiz' src='" . XOOPS_URL . "/modules/quiz/images/close12.gif' alt='' />
				 	</a>&nbsp;" . _AM_QUEST_NEW . "</h4><br/>
						<div id='newquiz' style='text-align: center;'>";
		$editQuest_form->display ();
		echo "</div>";
	}
	
	/*
	 * show form for select quiz to show questions
	 * @return String
	 */
	public static function showQuizSelectForm() {
		$list = Quiz::allQuizs ();
		
		echo "<div id='newsel' style='text-align: center;'>
					<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
						<tr class='odd'>
							<td>
							<form method='get' action='index.php' onchange=\"MM_jumpMenu('parent',this,0)\">
								<input type='hidden' name='op' value='Qst'>
								<lable>" . _AM_QUIZ_QUIZS_SELECT . "
									<select name='Id'>";
		foreach ( $list as $key )
			echo "<option value='" . $key ['id'] . "'>" . $key ['name'] . "</option>";
		
		echo "						</select>
								</lable>
								<input type='submit' value='" . _AM_QUESTION_GO . "'>
							</form>
							</td>
							<td>
							<form method='get' action='index.php'>
							<input type='hidden' name='op' value='Qst'>
							<input type='hidden' name='act' value='add'>
							<lable>" . _AM_QUIZ_QUIZS_SELECT . "
									<select name='Id'>";
		foreach ( $list as $key )
			echo "<option value='" . $key ['id'] . "'>" . $key ['name'] . "</option>";
		
		echo "						</select>
							</lable>
							<lable>" . _QUIZ_ANSWER_TYPE . "
									<select name='type'>";
		foreach ( self::$qTypes as $key => $value )
			echo "<option value='$key'>$value</option>";
		
		echo "						</select>
							</lable>
								
							<input type='submit' value='" . _AM_NEW_QUEST . "'>
							</form>
							</td>							
						</tr>
					</table>
				</div>";
	}
	/*
 * TODO add new question to database
 * @param array $answers
 * @param array $corrects
 * @return void
 * 
 */
	public function addQuestion($ans, $is_cor) {
		
		global $xoopsDB;
		$query = "Insert into " . $xoopsDB->prefix ( "quiz_questions" ) . "
				(quiz_id,question_type,question,qnumber,score)
				VALUES ( '$this->qid', '$this->type', '$this->question','$this->qnumber',
				'$this->score');";
		
		$res = $xoopsDB->query ( $query );
		$this->id = $xoopsDB->getInsertId ();
		for($i = 1; $i <= count ( $ans ); $i ++) {
			$answerObj = new answer ( );
			$answerObj->setAnswer ( $ans [$i] );
			if ((! empty ( $is_cor [$i] )) && ($this->type == 'CM'))
				$answerObj->setIs_correct ( 1 );
			elseif (($i == $is_cor) && ($this->type == 'MC'))
				$answerObj->setIs_correct ( 1 );
			$answerObj->setQuestId ( $this->id );
			$answerObj->addAnswer ();
			array_push ( $this->answers, $answerObj );
		}
		
		if (! $res)
			throw new Exception ( _QUEST_DATABASE );
	}
	
	/*
	 * @TODO retrive number of question into database
	 * @param integer @quizid
	 * @return $integer number of question
	 */
	public static function questionNumber($quizId) {
		global $xoopsDB;
		$query = $xoopsDB->query ( "SELECT COUNT(quiz_id) AS CID FROM " . $xoopsDB->prefix ( "quiz_questions" ) . " WHERE quiz_id = '$quizId'" );
		$myrow = $xoopsDB->fetchArray ( $query );
		return $myrow ['CID'];
	}
	/*
	 * @TODO retrive question from database with question Id and set to object attribute
	 * @param Integer $questionId
	 * @return void 
	 */
	public function retriveQuestion($questId) {
		global $xoopsDB;
		$this->id = $questId;
		$query = $xoopsDB->query ( "SELECT * FROM " . $xoopsDB->prefix ( 'quiz_questions' ) . " WHERE question_id = '$this->id'" );
		$myrow = $xoopsDB->fetchArray ( $query );
		$this->qid = $myrow ['quiz_id'];
		$this->qnumber = $myrow ['qnumber'];
		$this->score = $myrow ['score'];
		$this->type = $myrow ['question_type'];
		$this->question = $myrow ['question'];
		$query = $xoopsDB->query ( "SELECT * FROM " . $xoopsDB->prefix ( 'quiz_answers' ) . " WHERE question_id = '$this->id'" );
		
		while ( $myrow = $xoopsDB->fetchArray ( $query ) ) {
			$answerObj = new answer ( );
			$answerObj->setAnswer ( $myrow ['answer'] );
			$answerObj->setAid ( $myrow ['answer_id'] );
			$answerObj->setIs_correct ( $myrow ['is_correct'] );
			$answerObj->setQuestId ( $myrow ['question_id'] );
			array_push ( $this->answers, $answerObj );
		}
	}
	/*
	 * @TODO edit Question
	 * @param array $answers
	 * @param array $corrects
	 * @return void
	 */
	public function editQuestion($ans, $is_cor) {
		global $xoopsDB;
		$query = "UPDATE " . $xoopsDB->prefix ( "quiz_questions" ) . " SET 
					  quiz_id = '$this->qid'
					 ,question = '$this->question'
					 ,qnumber = '$this->qnumber'
					 ,score = '$this->score'
					 WHERE question_id = '$this->id' ";
		$res = $xoopsDB->query ( $query );
		
		answer::deleteAnswers ( $this->getId () );
		for($i = 1; $i <= count ( $ans ); $i ++) {
			$answerObj = new answer ( );
			$answerObj->setAnswer ( $ans [$i] );
			if ((! empty ( $is_cor [$i] )) && ($this->type == 'CM'))
				$answerObj->setIs_correct ( 1 );
			elseif (($i == $is_cor) && ($this->type == 'MC'))
				$answerObj->setIs_correct ( 1 );
			$answerObj->setQuestId ( $this->id );
			$answerObj->addAnswer ();
			array_push ( $this->answers, $answerObj );
		}
		if (! $res)
			throw new Exception ( _QUEST_DATABASE );
	}
	/*
	 * @TODO delete Question and all question's answers from database
	 * @return void
	 */
	public function deleteQuestion() {
		global $xoopsDB;
		$query = "DELETE FROM " . $xoopsDB->prefix ( "quiz_questions" ) . " WHERE  
					  question_id = '$this->id' ";
		$res = $xoopsDB->query ( $query );
		answer::deleteAnswers ( $this->id );
		if (! $res)
			throw new Exception ( _QUEST_DATABASE );
	}
	/*
	 * @TODO Show delete confirm form
	 * @param Integer $id
	 * @return void
	 */
	public static function confirmForm($id) {
		$delQuest_form = new XoopsThemeForm ( _QUIZ_DELQUESTFORM, "delqstfrom", XOOPS_URL . '/modules/quiz/admin/backend.php', 'post', true );
		$quest_id = new XoopsFormHidden ( "questId", $id );
		$quest_confirm = new XoopsFormRadioYN ( _QUIZ_DELETE_CAPTION, "delConfirm", 0 );
		$submit_button = new XoopsFormButton ( "", "delQstSubmit", _QUIZ_SUBMIT, "submit" );
		$quest_token = new XoopsFormHidden ( "XOOPS_TOKEN_REQUEST", $GLOBALS ['xoopsSecurity']->createToken () );
		
		$delQuest_form->addElement ( $quest_id );
		$delQuest_form->addElement ( $quest_token, true );
		$delQuest_form->addElement ( $quest_confirm, true );
		$delQuest_form->addElement ( $submit_button );
		
		quiz_collapsableBar ( 'newquiz', 'topnewquiz' );
		echo "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewquiz' name='topnewquiz' src='" . XOOPS_URL . "/modules/quiz/images/close12.gif' alt='' />
				 	</a>&nbsp;" . _AM_QUIZ_DELETE . "</h4><br/>
						<div id='newquiz' style='text-align: center;'>";
		$delQuest_form->display ();
		echo "</div>";
	}
	
	/*
	 * @TODO List Questions of specefic quiz
	 * @param Integer $quizId
	 * @return array $listQuestions
	 */
public static function listQuestLoader($qId)
	{
		global $xoopsDB;
		$listQuest = array();
		$q=1;		
		$query = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix('quiz_questions')." WHERE quiz_id = $qId");
		while($myrow = $xoopsDB->fetchArray($query) )
			{
				$listQuest[$q]['question_id'] = $myrow['question_id'];
				$listQuest[$q]['question_type'] = $myrow['question_type'];
				$listQuest[$q]['question'] = $myrow['question'];
				$listQuest[$q]['qnumber'] = $myrow['qnumber'];
				$listQuest[$q]['score'] = $myrow['score'];
				$qry = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix('quiz_answers')." WHERE question_id = ".$myrow['question_id']);
				if($xoopsDB->getRowsNum($qry) != 0)
				{
					$listQuest[$q]['answer'] = array();
					$t = 1;
					while($ansRow = $xoopsDB->fetchArray($qry) )
					{
						$listQuest[$q]['answer'][$t]['answer_id'] = $ansRow['answer_id'];
						$listQuest[$q]['answer'][$t]['answer'] = $ansRow['answer'];
						$listQuest[$q]['answer'][$t]['is_correct'] = $ansRow['is_correct'];
						$t++;
					}
				}
				$q++;
			}
		return $listQuest;
	}
}

?>