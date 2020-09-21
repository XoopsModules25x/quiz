<?php

namespace XoopsModules\Xquiz;

/**
 * Class Answer
 * @package XoopsModules\Xquiz
 */
class Answer
{
    /**
     *
     */
    private $aid;
    private $questId;
    private $is_correct;
    private $answer;

    /**
     * @return int
     */
    public function getAid()
    {
        return $this->aid;
    }

    /**
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @return bool
     */
    public function getIs_correct()
    {
        return $this->is_correct;
    }

    /**
     * @return int
     */
    public function getQuestId()
    {
        return $this->questId;
    }

    /**
     * @param string $aid
     */
    public function setAid($aid)
    {
        $this->aid = (int)$aid;
    }

    /**
     * @param string $answer
     */
    public function setAnswer($answer)
    {
        //$this->answer = $xoopsDB->escape($answer);
        $this->answer = $answer;
    }

    /**
     * @param bool $is_correct
     */
    public function setIs_correct($is_correct)
    {
        $this->is_correct = (int)$is_correct;
    }

    /**
     * @param int $questId
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
    /**
     * @return bool
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
     * @return bool
     */
    /**
     * @param $questionId
     * @return bool
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
