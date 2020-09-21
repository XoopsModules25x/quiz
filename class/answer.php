<?php

class answer
{
    /**
     *
     */
    private $aid;
    private $questId;
    private $is_correct;
    private $answer;

    /**
     * @return Integer
     */
    public function getAid()
    {
        return $this->aid;
    }

    /**
     * @return String
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @return Boolean
     */
    public function getIs_correct()
    {
        return $this->is_correct;
    }

    /**
     * @return Integer
     */
    public function getQuestId()
    {
        return $this->questId;
    }

    /**
     * @param String $aid
     */
    public function setAid($aid)
    {
        $this->aid = (int)$aid;
    }

    /**
     * @param String $answer
     */
    public function setAnswer($answer)
    {
        //$this->answer = $xoopsDB->escape($answer);
        $this->answer = $answer;
    }

    /**
     * @param Boolean $is_correct
     */
    public function setIs_correct($is_correct)
    {
        $this->is_correct = (int)$is_correct;
    }

    /**
     * @param Integer $questId
     */
    public function setQuestId($questId)
    {
        $this->questId = (int)$questId;
    }

    public function __construct()
    {
        //TODO - Insert your code here
    }

    /**
     *
     */
    public function __destruct()
    {
        //TODO - Insert your code here
    }

    /*
     * TODO - add new answer to database
     * @Return Boolean $res
     */
    public function addAnswer()
    {
        if ('' == $this->is_correct) {
            $this->is_correct = '0';
        }
        global $xoopsDB;
        $query = 'INSERT into ' . $xoopsDB->prefix('xquiz_answers') . "(question_id ,is_correct ,answer)
				VALUES ('$this->questId', '$this->is_correct', '$this->answer');";
        $res   = $xoopsDB->query($query);

        if (!$res) {
            return false;
        } else {
            return true;
        }
    }

    /*
     * TODO - delete question's answers
     * @param $questionId
     * @return Boolean
     */
    public static function deleteAnswers($questionId)
    {
        global $xoopsDB;
        $questionId = $xoopsDB->escape($questionId);
        $query      = 'DELETE FROM ' . $xoopsDB->prefix('xquiz_answers') . " WHERE  
					  question_id = '$questionId' ";
        $res        = $xoopsDB->query($query);
        if (!$res) {
            return false;
        } else {
            return true;
        }
    }
}
