<?php

namespace XoopsModules\Xquiz;

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
 * @copyright          XOOPS Project (https://xoops.org)
 * @license            http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package            xquiz
 * @author             Mojtaba Jamali(jamali.mojtaba@gmail.com)
 * @version            $Id$
 *
 * Version : $Id:
 * ****************************************************************************
 */
require_once XOOPS_ROOT_PATH . '/class/xoopstree.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';

/**
 * Class Category
 * @package XoopsModules\Xquiz
 */
class Category extends \XoopsTree
{
    /** @var string table with parent-child structure */
    public $table;
    /** @var string name of unique id for records in table $table */
    public $id;
    /** @var string name of parent id used in table $table */
    public $pid;
    /** @var string specifies the order of query results */
    public $order;
    /** @var string name of a field in table $table which will be used when  selection box and paths are generated */
    public $title;
    /** @var object an instance of the database object */
    public $db;

    /** constructor of class XoopsTree
     * Sets the names of table, unique id, and parent id
     * @param string $table_name Name of table containing the parent-child structure
     * @param string $id_name    Name of the unique id field in the table
     * @param Name   $pid_name   of the parent id field in the table
     */
    public function __construct($table_name, $id_name, $pid_name)
    {
        //$this->db = XoopsDatabaseFactory::getDatabaseConnection();
        $this->db    = \XoopsDatabaseFactory::getDatabaseConnection();
        $this->table = $table_name;
        $this->id    = $id_name;
        $this->pid   = $pid_name;
    }

    /** Returns an array of first child objects for a given id($sel_id)
     * @param int    $sel_id
     * @param string $order Sort field for the list
     * @return array $arr
     */

    /** Returns an array of ALL parent ids for a given id($sel_id)
     * @param int    $sel_id
     * @param string $order
     * @param array  $idarray
     * @return array $idarray
     */
    public function getAllParentId($sel_id, $order = '', $idarray = [])
    {
        $sel_id = (int)$sel_id;
        $sql    = 'SELECT ' . $this->pid . ' FROM ' . $this->table . ' WHERE ' . $this->id . '="' . $sel_id . '"';
        if ('' != $order) {
            $sql .= ' ORDER BY ' . $order;
        }
        $result = $this->db->query($sql);
        [$r_id] = $this->db->fetchRow($result);
        if (0 == $r_id) {
            return $idarray;
        }
        $idarray[] = $r_id;
        $idarray   = $this->getAllParentId($r_id, $order, $idarray);
        return $idarray;
    }

    /** Makes a nicely ordered selection box
     * @param string $title     Field containing the items to display in the list
     * @param string $order     Sort order of the options
     * @param int    $preset_id is used to specify a preselected item
     * @param int    $none      set to 1 to add an option with value 0
     * @param string $sel_name  Name of the select element
     * @param string $onchange  Action to take when the selection is changed
     * @param int    $se
     */
    public function makeMySelBox($title, $order = '', $preset_id = 0, $none = 0, $sel_name = '', $onchange = '', $se = 0)
    {
        if ('' == $sel_name) {
            $sel_name = $this->id;
        }
        echo "<select name='" . $sel_name . "'";
        if ('' != $onchange) {
            echo " onchange='" . $onchange . "'";
        }
        echo ">\n";
        $sql = 'SELECT ' . $this->id . ', ' . $title . ' FROM ' . $this->table . ' WHERE ' . $this->pid . "='0'";
        if ('' != $order) {
            $sql .= " ORDER BY $order";
        }
        $result = $this->db->query($sql);
        if ($none) {
            $val = (0 == $se) ? 0 : -1;
            echo "<option value='$val'>----------</option>\n";
        }
        while (list($catid, $name) = $this->db->fetchRow($result)) {
            $sel = '';
            if ($catid == $preset_id) {
                $sel = " selected='selected'";
            }
            echo "<option value='$catid'$sel>$name</option>\n";
            $sel = '';
            $arr = $this->getChildTreeArray($catid, $order);
            foreach ($arr as $option) {
                $option['prefix'] = str_replace('.', '--', $option['prefix']);
                $catpath          = $option['prefix'] . '&nbsp;' . $option[$title];
                if ($option[$this->id] == $preset_id) {
                    $sel = " selected='selected'";
                }
                echo "<option value='" . $option[$this->id] . "'$sel>$catpath</option>\n";
                $sel = '';
            }
        }
        echo "</select>\n";
    }

    /**
     * @param int    $sel_id
     * @param string $order
     * @param array  $parray
     * @return array $parray
     */
    public function getAllChild($sel_id = 0, $order = '', $parray = [])
    {
        $sel_id = (int)$sel_id;
        $sql    = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->pid . '="' . $sel_id . '"';
        if ('' != $order) {
            $sql .= ' ORDER BY ' . $order;
        }
        $result = $this->db->query($sql);
        $count  = $this->db->getRowsNum($result);
        if (0 == $count) {
            return $parray;
        }
        while (false !== ($row = $this->db->fetchArray($result))) {
            $parray[] = $row;
            $parray   = $this->getAllChild($row[$this->id], $order, $parray);
        }
        return $parray;
    }

    /**
     * @param int    $sel_id
     * @param string $order
     * @param array  $parray
     * @param string $r_prefix
     * @return array $parray
     */
    public function getChildTreeArray($sel_id = 0, $order = '', $parray = [], $r_prefix = '')
    {
        $sel_id = (int)$sel_id;
        $sql    = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->pid . '="' . $sel_id . '"';
        if ('' != $order) {
            $sql .= ' ORDER BY ' . $order;
        }
        $result = $this->db->query($sql);
        $count  = $this->db->getRowsNum($result);
        if (0 == $count) {
            return $parray;
        }
        while (false !== ($row = $this->db->fetchArray($result))) {
            $row['prefix'] = $r_prefix . '.';
            $parray[]      = $row;
            $parray        = $this->getChildTreeArray($row[$this->id], $order, $parray, $row['prefix']);
        }
        return $parray;
    }

    /**
     * @param     $eu
     * @param     $limit
     * @param int $order
     * @return array
     */
    public function getList($eu, $limit, $order = 0)
    {
        $listCategory = [];
        $q            = 1;
        $query        = ' SELECT * FROM ' . $this->table;
        if ('' != $order) {
            $query .= ' ORDER BY ' . $order;
        }
        $query .= ' LIMIT ' . $eu . ' , ' . $limit;

        $query = $this->db->query($query);
        while (false !== ($myrow = $this->db->fetchArray($query))) {
            $listCategory[$q]['cid']         = $myrow['cid'];
            $listCategory[$q]['pid']         = $myrow['pid'];
            $listCategory[$q]['title']       = $myrow['title'];
            $listCategory[$q]['imgurl']      = $myrow['imgurl'];
            $listCategory[$q]['weight']      = $myrow['weight'];
            $listCategory[$q]['description'] = $myrow['description'];
            $q++;
        }
        return $listCategory;
    }

    /**
     * @return int
     */
    public function getNumberList()
    {
        $query = ' SELECT * FROM ' . $this->table;
        $query = $this->db->query($query);
        $myrow = $this->db->fetchArray($query);
        return count($myrow);;
    }

    /**
     * @param $cid
     * @return array
     */
    public function getCategory($cid)
    {
        $sel_id = (int)$cid;
        $arr    = [];
        $sql    = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->id . '=' . $sel_id . '';
        $result = $this->db->query($sql);
        $count  = $this->db->getRowsNum($result);
        if (0 == $count) {
            return $arr;
        }
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            $arr[] = $myrow;
        }
        return $arr;
    }

    /**
     * @param $sel_id
     * @return mixed
     */
    public function categoryPid($sel_id)
    {
        global $xoopsDB;
        $sql    = 'SELECT pid FROM ' . $this->table . ' WHERE ' . $this->id . '=' . $sel_id . '';
        $result = $this->db->query($sql);
        $myrow  = $xoopsDB->fetchArray($result);
        return $myrow['pid'];
    }

    // retrieve Category from database

    /**
     * @param $eId
     * @return array|false
     */
    public static function retrieveCategory($eId)
    {
        global $xoopsDB;
        $query = $xoopsDB->query('SELECT cid,title FROM ' . $xoopsDB->prefix('xquiz_categories') . " WHERE cid = '$eId'");
        $myrow = $xoopsDB->fetchArray($query);
        return $myrow;
    }

    // retrieve permited category from database
    /**
     * @param int    $sel_id
     * @param string $order
     * @param array  $parray
     * @param string $r_prefix
     * @return array|mixed
     */
    public function getPermChildArray($sel_id = 0, $order = '', $parray = [], $r_prefix = '')
    {
        global $xoopsUser, $module_id;
        $myts   = \MyTextSanitizer::getInstance();
        $sel_id = (int)$sel_id;
        $sql    = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->pid . '="' . $sel_id . '"';
        if ('' != $order) {
            $sql .= ' ORDER BY ' . $order;
        }
        $result = $this->db->query($sql);
        $count  = $this->db->getRowsNum($result);
        if (0 == $count) {
            return $parray;
        }
        $perm_name = 'quiz_view';
        if ($xoopsUser) {
            $groups = $xoopsUser->getGroups();
        } else {
            $groups = XOOPS_GROUP_ANONYMOUS;
        }
        $grouppermHandler = xoops_getHandler('groupperm');

        while (false !== ($row = $this->db->fetchArray($result))) {
            $row['prefix'] = $r_prefix . '.';
            if (!$grouppermHandler->checkRight($perm_name, $row['cid'], $groups, $module_id)) {
                continue;
            }
            $row['description'] = $myts->previewTarea($row['description'], 1, 1, 1, 1, 1);
            $parray[]           = $row;
        }
        return $parray;
    }



    /**
     * @param $title
     * @param $pid
     * @param $desc
     * @param $imgurl
     * @param $weight
     * @return int
     * @throws \Exception
     */
    public static function addCategory($title, $pid, $desc, $imgurl, $weight)
    {
        global $xoopsDB;
        $query = 'Insert into ' . $xoopsDB->prefix('xquiz_categories') . "(cid ,pid ,title ,description ,imgurl ,weight)
				VALUES (NULL , '$pid', '$title', '$desc', '$imgurl', '$weight');";
        $res   = $xoopsDB->query($query);

        if (!$res) {
            throw new \Exception(_AM_XQUIZ_QUEST_DATABASE);
        }

        return $xoopsDB->getInsertId();
    }

    /**
     * @param $cid
     * @param $title
     * @param $pid
     * @param $desc
     * @param $imgurl
     * @param $weight
     * @throws \Exception
     */
    public static function editCategory($cid, $title, $pid, $desc, $imgurl, $weight)
    {
        global $xoopsDB;
        $query = 'UPDATE ' . $xoopsDB->prefix('xquiz_categories') . " SET 
					  pid = '$pid'
					 ,title = '$title'
					 ,description = '$desc'
					 ,imgurl = '$imgurl'
					 ,weight = '$weight'
					 WHERE cid = '$cid' ";

        $res = $xoopsDB->query($query);

        if (!$res) {
            throw new \Exception(_AM_XQUIZ_QUEST_DATABASE);
        }
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public static function deleteCategory($id)
    {
        global $xoopsDB;
        $xt   = new Category($xoopsDB->prefix('xquiz_categories'), 'cid', 'pid');
        $list = $xt->getAllChildId($id);

        global $module_id;
        $perm_name = 'quiz_view';
        $query     = 'DELETE FROM ' . $xoopsDB->prefix('xquiz_categories') . " WHERE  
					  cid = '$id' ";
        $res       = $xoopsDB->query($query);
        xoops_groupperm_deletebymoditem($module_id, $perm_name, $id);
        if (!$res) {
            throw new \Exception(_AM_XQUIZ_QUEST_DATABASE);
        }
        //delet quiz of category
        $query = 'DELETE FROM ' . $xoopsDB->prefix('xquiz_quizzes') . " WHERE  
					  cid = '$id' ";
        $res   = $xoopsDB->query($query);
        xoops_groupperm_deletebymoditem($module_id, $perm_name, $id);
        if (!$res) {
            throw new \Exception(_AM_XQUIZ_QUEST_DATABASE);
        }

        //Delete subcategories and subquizs
        foreach ($list as $cid) {
            $perm_name = 'quiz_view';
            $query     = 'DELETE FROM ' . $xoopsDB->prefix('xquiz_categories') . " WHERE  
						cid = '$cid' ";
            $res       = $xoopsDB->query($query);
            xoops_groupperm_deletebymoditem($module_id, $perm_name, $cid);
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function category_permissionForm()
    {
        global $module_id, $xoopsDB;
        $xt = new Category($xoopsDB->prefix('xquiz_categories'), 'cid', 'pid');
        if (!$xt->getChildTreeArray(0)) {
            throw new \Exception(_AM_XQUIZ_NO_CATEGORY);
        }
        $listCategory  = $xt->getChildTreeArray(0, 'title');
        $title_of_form = _AM_XQUIZ_PERM_FORM_TITLE;
        $perm_name     = 'quiz_view';
        $perm_desc     = _AM_XQUIZ_PERM_FORM_DESC;
        $form          = new \XoopsGroupPermForm($title_of_form, $module_id, $perm_name, $perm_desc);

        foreach ($listCategory as $key) {
            $form->addItem($key['cid'], $key['title'], $key['pid']);
        }
        echo $form->render();
    }

    /**
     * @param $cid
     * @return bool
     */
    public static function checkExistCategory($cid)
    {
        global $xoopsDB;
        $query = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('xquiz_categories') . " WHERE cid='$cid'");
        $res   = $xoopsDB->getRowsNum($query);

        if ($res > 0) {
            return true;
        } else {
            return false;
        }
    }
}

