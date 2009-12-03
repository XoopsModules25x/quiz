<?php
class answer {
	
	/**
	 * 
	 */
	private $aid, $questId, $is_correct, $answer;
	
	/**
	 * @return Integer
	 */
	public function getAid() {
		return $this->aid;
	}
	
	/**
	 * @return String
	 */
	public function getAnswer() {
		return $this->answer;
	}
	
	/**
	 * @return Boolean
	 */
	public function getIs_correct() {
		return $this->is_correct;
	}
	
	/**
	 * @return Integer
	 */
	public function getQuestId() {
		return $this->questId;
	}
	
	/**
	 * @param String $aid
	 */
	public function setAid($aid) {
		$this->aid = intval ( $aid );
	}
	
	/**
	 * @param String $answer
	 */
	public function setAnswer($answer) {
		$this->answer = mysql_real_escape_string ( $answer );
	}
	
	/**
	 * @param Boolean $is_correct
	 */
	public function setIs_correct($is_correct) {
		$this->is_correct = intval ( $is_correct );
	}
	
	/**
	 * @param Integer $questId
	 */
	public function setQuestId($questId) {
		$this->questId = intval ( $questId );
	}
	function __construct() {
		
	//TODO - Insert your code here
	}
	
	/**
	 * 
	 */
	function __destruct() {
		
	//TODO - Insert your code here
	}
	
	/*
	 * TODO - add new answer to database
	 * @Return Boolean $res
	 */
	public function addAnswer() {
		global $xoopsDB;
		$query = "Insert into " . $xoopsDB->prefix ( "quiz_answers" ) . "(question_id ,is_correct ,answer)
				VALUES ('$this->questId', '$this->is_correct', '$this->answer');";
		$res = $xoopsDB->query ( $query );
		
		if (! $res)
			return FALSE;
		else
			return TRUE;
	
	}
	/*
	 * TODO - delete qustion's answers
	 * @param $questionId
	 * @return Boolean
	 */
	public static function deleteAnswers($questionId) {
		global $xoopsDB;
		$questionId = mysql_real_escape_string($questionId);
		$query = "DELETE FROM " . $xoopsDB->prefix ( "quiz_answers" ) . " WHERE  
					  question_id = '$questionId' ";
		$res = $xoopsDB->query ( $query );
		if (! $res)
			return FALSE;
		else
			return TRUE;
	
	}
}

?>