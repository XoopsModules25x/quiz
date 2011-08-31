<?php

/**
 * Questionair forms with export and plugin set (based on formulaire)
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Chronolabs Co-Op http://www.chronolabs.coop/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xquiz
 * @since           1.0.5
 * @author          Simon Roberts <simon@chronolabs.coop>
 */
if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}
/**
 * Class for Blue Room XQuiz
 * @author Simon Roberts <simon@chrononlabs.coop>
 * @copyright copyright (c) 2009-2003 XOOPS.org
 * @package kernel
 */
class XquizForms_form extends XoopsObject
{
	
    function XquizForms_form($id = null)
    {
        $this->initVar('id_forms_form', XOBJ_DTYPE_INT, null, false);
    	$this->initVar('id_form', XOBJ_DTYPE_INT, null, false);
		$this->initVar('id_req', XOBJ_DTYPE_INT, null, false);
		$this->initVar('ele_id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('ele_type', XOBJ_DTYPE_ENUM, 'text', false, false, false, array('twitter','facebook','name','email','text','textarea','areamodif','select','checkbox','mail','mailunique','radio','yn','date','sep','upload'));
		$this->initVar('ele_value', XOBJ_DTYPE_ARRAY, null, false);
		$this->initVar('date', XOBJ_DTYPE_TXTBOX, null, false, 10);
		$this->initVar('uid', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('ip', XOBJ_DTYPE_TXTBOX, null, false, 50);
		$this->initVar('time', XOBJ_DTYPE_TXTBOX, null, false, 10);
		$this->initVar('rep', XOBJ_DTYPE_ARRAY, null, false);
		$this->initVar('nbrep', XOBJ_DTYPE_INT, null, false);
		$this->initVar('nbtot', XOBJ_DTYPE_INT, null, false);
		$this->initVar('pos', XOBJ_DTYPE_INT, null, false);		
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);
		$this->initVar('actioned', XOBJ_DTYPE_INT, null, false);			
	}
	
	function runInsertPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/xquiz/plugins/'.$this->getVar('ele_type').'.php'));
		
		switch ($this->getVar('ele_type')) {
			case 'twitter':
			case 'facebook':
			case 'name':
			case 'email':
			case 'text':
			case 'textarea':
			case 'areamodif':
			case 'select':
			case 'checkbox':
			case 'mail':
			case 'mailunique':
			case 'radio':
			case 'yn':
			case 'date':
			case 'sep':
			case 'upload':
				$func = ucfirst($this->getVar('ele_type')).'FormInsertHook';
				break;
			default:
				return false;
				break;
		}
		
		if (function_exists($func))  {
			return @$func($this);
		}
		return $this->getVar('ele_id');
	}
	
	function runGetPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/xquiz/plugins/'.$this->getVar('ele_type').'.php'));
		
		switch ($this->getVar('ele_type')) {
			case 'twitter':
			case 'facebook':
			case 'name':
			case 'email':
			case 'text':
			case 'textarea':
			case 'areamodif':
			case 'select':
			case 'checkbox':
			case 'mail':
			case 'mailunique':
			case 'radio':
			case 'yn':
			case 'date':
			case 'sep':
			case 'upload':
				$func = ucfirst($this->getVar('ele_type')).'FormGetHook';
				break;
			default:
				return false;
				break;
		}
		
		if (function_exists($func))  {
			return @$func($this);
		}
		return $this;
	}
}

class XquizForms_forms_usage extends XoopsObject
{
	
    function XquizForms_forms_usage($id = null)
    {
        $this->initVar('id_req', XOBJ_DTYPE_INT, null, false);
		$this->initVar('time', XOBJ_DTYPE_TXTBOX, null, false, 10);
	}
	
}

/**
* XOOPS policies handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Simon Roberts <simon@chronolabs.coop>
* @package kernel
*/
class XquizForms_formHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, 'forms_form', 'XquizForms_form', "id_forms_forms", "ele_value");
    }
    
    function getUsage($forms_id = 0, $uid=0, $ip = '127.0.0.1', $id_as_key = false) {
    	
    	$sql=sprintf("SELECT id_req,MAX(time) as time FROM '.$this->handler->table.' WHERE '.$this->handler->table.'.id_form=".$forms_id." and '.$this->handler->table.'.uid=".$uid." and '.$this->handler->table.'.ip='".$ip."' GROUP BY time");
       	    	
    	$result = $this->db->query($sql, $limit, $start);

		if( !$result ){
			return false;
		}
		while( $myrow = $this->db->fetchArray($result) ){
			$elements = new XquizForms_forms_usage();
			$elements->assignVars($myrow);
			if( !$id_as_key ){
				$ret[] =& $elements;
			}else{
				$ret[$myrow['id_req']] =& $elements;
			}
			unset($elements);
		}
		return $ret;
    }
    
	function insert($object, $force=true) {
		if ($object->isNew()) {
			$object->setVar('created', time());
		} else {
			$object->setVar('updated', time());
		}
		
		$run_plugin = false;
    	if ($obj->vars['ele_type']['changed']==true) {	
			$obj->setVar('actioned', time());
			$run_plugin = true;
		}
     	
    	if ($run_plugin == true) {
    		$id = parent::insert($obj, $force);
    		$obj = parent::get($id);
    		if (is_object($obj)) {
	    		$ret = $obj->runInsertPlugin();
	    		return ($ret!=0)?$ret:$id;
    		} else {
    			return $id;
    		}
    	} else {
    		return parent::insert($obj, $force);
    	}
	}

	function get($id, $fields = '*') {
    	$obj = parent::get($id, $fields);
    	if (is_object($obj)) {
       		return @$obj->runGetPlugin();
    	}
    }
    
    function getObjects($criteria, $id_as_key=false, $as_object=true) {
	   	$objs = parent::getObjects($criteria, $id_as_key, $as_object);
    	foreach($objs as $id => $obj) {
    		if (is_object($obj)) {
    			$objs[$id] = @$obj->runGetPlugin();
    		}
    	}
    	return $objs;
    }
}

?>