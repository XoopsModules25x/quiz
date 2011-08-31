<?php
/**
 * Invoice Transaction Gateway with Modular Plugin set
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
 * @package         xpayment
 * @since           1.30.0
 * @author          Simon Roberts <simon@chronolabs.coop>
 * @translation     Erol Konik <aphex@aphexthemes.com>
 * @translation     Mariane <mariane_antoun@hotmail.com>
 * @translation     Voltan <voltan@xoops.ir>
 * @translation     Ezsky <ezskyyoung@gmail.com>
 * @translation     Richardo Costa <lusopoemas@gmail.com>
 * @translation     Kris_fr <kris@frxoops.org>
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
class XquizForms extends XoopsObject
{
	
    function XquizForms($id = null)
    {
		$this->initVar('id_form', XOBJ_DTYPE_INT, null, false);
		$this->initVar('ele_id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('ele_type', XOBJ_DTYPE_ENUM, 'text', false, false, false, array('twitter','facebook','name','email','text','textarea','areamodif','select','checkbox','mail','mailunique','radio','yn','date','sep','upload'));
		$this->initVar('ele_caption', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('ele_order', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('ele_req', XOBJ_DTYPE_INT, 1, false);
		$this->initVar('ele_value', XOBJ_DTYPE_ARRAY, null, false);
		$this->initVar('ele_scores', XOBJ_DTYPE_ARRAY, null, false);
		$this->initVar('ele_display', XOBJ_DTYPE_INT, 1, false);
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
				$func = ucfirst($this->getVar('ele_type')).'InsertHook';
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
				$func = ucfirst($this->getVar('ele_type')).'GetHook';
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


/**
* XOOPS policies handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Simon Roberts <simon@chronolabs.coop>
* @package kernel
*/
class XquizFormsHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, 'forms', 'XquizForms', "ele_id", "ele_caption");
    }
    
	function &getObjects2($criteria = null, $id_form , $id_as_key = false){
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->handler->table.' WHERE id_form='.$id_form.' AND ele_display=1';

		if( isset($criteria) && is_subclass_of($criteria, 'criteriaelement') ){
		//	$sql .= ' '.$criteria->renderWhere();
			if( $criteria->getSort() != '' ){
				$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
			}
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}
		$result = $this->db->query($sql, $limit, $start);

		if( !$result ){
			return false;
		}
		while( $myrow = $this->db->fetchArray($result) ){
			$elements = new XquizForms();
			$elements->assignVars($myrow);
			if( !$id_as_key ){
				$ret[] =& $elements->runGetPlugin();
			}else{
				$ret[$myrow['ele_id']] =& $elements->runGetPlugin();
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

class XQuizFormsRenderer extends XquizFormsHandler {
	
	var $_ele;

	function XQuizFormsRenderer(&$element){
		if (is_a($element, 'XquizForms'))
			$this->_ele =& $element;
	}

	function constructElement($forms_ele_id, $admin=false, $qcm){
		
		$GLOBALS['myts'] =& MyTextSanitizer::getInstance();
		
		$id_form = $this->_ele->getVar('id_form');
		$ele_caption = $this->_ele->getVar('ele_caption', 'e');
		$ele_caption = preg_replace('/\{null\}/', '', $ele_caption);
		$ele_caption = stripslashes($ele_caption);
		$ele_value = $this->_ele->getVar('ele_value');
		$e = $this->_ele->getVar('ele_type');

		// required elements have a '*' after the text
		$req = intval( $this->_ele->getVar('ele_req'));
		if ($req) $ele_caption = $ele_caption.' *';
	
	  	$ele_caption = $GLOBALS['myts']->displayTarea($ele_caption);

		switch ($e){
			case 'twitter':
				if (isset($GLOBAL['quiz']['profiles']['twitter']['id'])) {
					$forms_oauth_handler = xoops_getmodulehandler('forms_oauth', 'xquiz');
					$oauth = $forms_oauth_handler->getRootOauth(true);
					if (is_a($oauth, 'XquizForms_oauth')) {
						$twitterid = explode('%3A', $GLOBAL['quiz']['profiles']['twitter']['id']);
						$oauth->createFollow($twitterid[1]);
						$user_details = $oauth->getUser($twitterid[1]);
						if (is_array($user_details))
							$ele_value[2] = $user_details['screen_name'];
						else 
							$ele_value[2] = '';  
					}
				}
				$forms_ele = new XoopsFormText	(
													$ele_caption,
													$forms_ele_id,
													$ele_value[0],	//	box width
													$ele_value[1],	//	max width
													$ele_value[2]	  //	default value
												);
				break;
			case 'facebook':
				if (isset($GLOBAL['quiz']['profiles']['facebook']['url'])) {
					$ele_value[2] = $GLOBAL['quiz']['profiles']['facebook']['url'];
				}
				$forms_ele = new XoopsFormText	(
													$ele_caption,
													$forms_ele_id,
													$ele_value[0],	//	box width
													$ele_value[1],	//	max width
													$ele_value[2]	  //	default value
												);
				break;
			case 'name':
			case 'email':
			case 'text':
				$ele_value[2] = eregi_replace ("’", "'", $ele_value[2]);
				$ele_value[2] = stripslashes($ele_value[2]);
       			$ele_value[2] = $GLOBALS['myts']->displayTarea($ele_value[2]);
				if( !is_object($GLOBALS['xoopsUser']) ){
					$ele_value[2] = preg_replace('/\{NAME\}/', '', $ele_value[2]);
					$ele_value[2] = preg_replace('/\{name\}/', '', $ele_value[2]);
					$ele_value[2] = preg_replace('/\{UNAME\}/', '', $ele_value[2]);
					$ele_value[2] = preg_replace('/\{uname\}/', '', $ele_value[2]);
					$ele_value[2] = preg_replace('/\{EMAIL\}/', '', $ele_value[2]);
					$ele_value[2] = preg_replace('/\{email\}/', '', $ele_value[2]);
					$ele_value[2] = preg_replace('/\{MAIL\}/', '', $ele_value[2]);
					$ele_value[2] = preg_replace('/\{mail\}/', '', $ele_value[2]);
					$ele_value[2] = preg_replace('/\{DATE\}/', '', $ele_value[2]);
				}elseif( !$admin ){
					$ele_value[2] = preg_replace('/\{NAME\}/', $GLOBALS['xoopsUser']->getVar('name', 'e'), $ele_value[2]);
					$ele_value[2] = preg_replace('/\{name\}/', $GLOBALS['xoopsUser']->getVar('name', 'e'), $ele_value[2]);
					$ele_value[2] = preg_replace('/\{UNAME\}/', $GLOBALS['xoopsUser']->getVar('uname', 'e'), $ele_value[2]);
					$ele_value[2] = preg_replace('/\{uname\}/', $GLOBALS['xoopsUser']->getVar('uname', 'e'), $ele_value[2]);
					$ele_value[2] = preg_replace('/\{MAIL\}/', $GLOBALS['xoopsUser']->getVar('email', 'e'), $ele_value[2]);
					$ele_value[2] = preg_replace('/\{mail\}/', $GLOBALS['xoopsUser']->getVar('email', 'e'), $ele_value[2]);
					$ele_value[2] = preg_replace('/\{EMAIL\}/', $GLOBALS['xoopsUser']->getVar('email', 'e'), $ele_value[2]);
					$ele_value[2] = preg_replace('/\{email\}/', $GLOBALS['xoopsUser']->getVar('email', 'e'), $ele_value[2]);
					$ele_value[2] = preg_replace('/\{DATE\}/', date("d-m-Y"), $ele_value[2]);
				}

					$forms_ele = new XoopsFormText(
					$ele_caption,
					$forms_ele_id,
					$ele_value[0],	//	box width
					$ele_value[1],	//	max width
					stripslashes($ele_value[2])	  //	default value
				);
			break;

			case 'textarea':
					$ele_value[0] = stripslashes($ele_value[0]);
        	$ele_value[0] = $GLOBALS['myts']->displayTarea($ele_value[0]);

					$forms_ele = new XoopsFormTextArea(
					$ele_caption,
					$forms_ele_id,
					$ele_value[0],	//	default value
					$ele_value[1],	//	rows
					$ele_value[2]	  //	cols
				);
			break;
			case 'areamodif':
				$ele_value[0] =  stripslashes($ele_value[0]);
       			$ele_value[0] = $GLOBALS['myts']->displayTarea($ele_value[0]);
				$forms_ele = new XoopsFormLabel(
					$ele_caption,
					$ele_value[0]
				);
			break;

			case 'select':
				$selected = array();
				$options = array();
				$opt_count = 1;

				while( $i = each($ele_value[2]) ){
					$options[$opt_count] = $GLOBALS['myts']->stripSlashesGPC($i['key']);
					if( $i['value'] > 0 ){
						$selected[] = $opt_count;
					}
				$opt_count++;
				}
				if ($qcm == '1') {
				$forms_ele = new XoopsFormSelect(
					$ele_caption,
					$forms_ele_id,
					'',
					$ele_value[0],	//	size
					$ele_value[1]	  //	multiple
				);}
				else {
				$forms_ele = new XoopsFormSelect(
					$ele_caption,
					$forms_ele_id,
					$selected,
					$ele_value[0],	//	size
					$ele_value[1]	  //	multiple
				);}
				if( $ele_value[1] ){
					$this->_ele->setVar('ele_req', 0);
				}
				$forms_ele->addOptionArray($options);
			break;

			case 'checkbox':
				$selected = array();
				$options = array();
				$opt_count = 1;
				while( $i = each($ele_value) ){
					$options[$opt_count] = $GLOBALS['myts']->stripSlashesGPC($i['key']);
					if( $i['value'] > 0 ){
						$selected[] = $opt_count;
					}
					$opt_count++;
				}
				switch($GLOBALS['xoopsModuleConfig']['delimeter']){
					case 'br':
						$forms_ele = new XoopsFormElementTray($ele_caption, '<br />');
						while( $o = each($options) ){
							if ($qcm == '1') {
							$t =& new XoopsFormCheckBox(
								'',
								$forms_ele_id.'[]'
							);}
							else {
							$t =& new XoopsFormCheckBox(
								'',
								$forms_ele_id.'[]',
								$selected
							); }
							$t->addOption($o['key'], $o['value']);
							$forms_ele->addElement($t);
						}
					break;
					default:
						if ($qcm == '1') {
						$forms_ele = new XoopsFormCheckBox(
							$ele_caption,
							$forms_ele_id
						); }
						else {
						$forms_ele = new XoopsFormCheckBox(
							$ele_caption,
							$forms_ele_id,
							$selected
						); }
						$forms_ele->addOptionArray($options);
					break;
				}
			break;

			case 'mail':
				$selected = array();
				$options = array();
				$opt_count = 1;
				while( $i = each($ele_value) ){
					$options[$opt_count] = $GLOBALS['myts']->stripSlashesGPC($i['key']);
					if( $i['value'] > 0 ){
						$selected[] = $opt_count;
					}
					$opt_count++;
				}
						$forms_ele = new XoopsFormElementTray($ele_caption, '<br />');
						while( $o = each($options) ){
							$t =& new XoopsFormCheckBox(
								'',
								$forms_ele_id.'[]',
								$selected
							);
							$o['value'] = split(" - ",$o['value']);
							$t->addOption($o['key'], $o['value'][0]);
							$forms_ele->addElement($t);
				}
			break;

			case 'mailunique':
			case 'radio':
			case 'yn':
				$selected = '';
				$options = array();
				$opt_count = 1;
				while( $i = each($ele_value) ){
					switch ($e){
						case 'radio':
							$options[$opt_count] = $GLOBALS['myts']->stripSlashesGPC($i['key']);
             				$options[$opt_count] = $GLOBALS['myts']->displayTarea($options[$opt_count]);
						break;
						case 'mailunique':
 							$options[$opt_count] = $GLOBALS['myts']->stripSlashesGPC($i['key']);
							switch ($options[$opt_count])
							{
							default:							
								$options[$opt_count] = split(" - ",$options[$opt_count]);
				             	$options[$opt_count] = $GLOBALS['myts']->displayTarea($options[$opt_count][0]);
								break;
							case "Me":
								if (is_object($GLOBALS['xoopsUser'])) {
									xoops_load('xoopsformloader');
									$forms_email = new XoopsFormText('', 'user_email', 30,255, $GLOBALS['xoopsUser']->getVar('email'));
									$options[$opt_count] = _AM_XQUIZ_FORM_YOU.$forms_email->render();
								} else {
									xoops_load('xoopsformloader');
									$forms_email = new XoopsFormText('', 'user_email', 30,255, '');
									$options[$opt_count] = _AM_XQUIZ_FORM_YOU.$forms_email->render();
								}
							}				
						break;
						case 'yn':
							$options[$opt_count] = constant($i['key']);
							$options[$opt_count] = $GLOBALS['myts']->stripSlashesGPC($options[$opt_count]);
						break;
					}
					if( $i['value'] > 0 ){
						$selected = $opt_count;
					}
					$opt_count++;
				}
				switch($GLOBALS['xoopsModuleConfig']['delimeter']){
					case 'br':
						$forms_ele = new XoopsFormElementTray($ele_caption, '<br />');
						while( $o = each($options) ){
							if ($qcm == '1') {
							$t =& new XoopsFormRadio(
								'',
								$forms_ele_id
							);}
							else {
							$t =& new XoopsFormRadio(
								'',
								$forms_ele_id,
								$selected
							);}
							$t->addOption($o['key'], $o['value']);
							$forms_ele->addElement($t);
						}
					break;
					default:
						if ($qcm == '1') {
						$forms_ele = new XoopsFormRadio(
							$ele_caption,
							$forms_ele_id
						);}
						else {
						$forms_ele = new XoopsFormRadio(
							$ele_caption,
							$forms_ele_id,
							$selected
						);}
						$forms_ele->addOptionArray($options);
					break;
				}
			break;
			case 'date':
  				$forms_ele = new XoopsFormTextDateSelect (
					$ele_caption,
					$forms_ele_id,
					15,
					strtotime($ele_value[0])
				);
			break;
			case 'sep':
				$ele_value[0]=eregi_replace('@font','',$ele_value[0]);
				$ele_value[0] = $GLOBALS['myts']->xoopsCodeDecode($ele_value[0]);
				$forms_ele = new XoopsFormLabel(
					$ele_caption,
					$ele_value[0]
				);
			break;
			case 'upload':

				$forms_ele = new XoopsFormElementTray($ele_caption,'');
				$forms_ele->addElement(new XoopsFormFile ('',$forms_ele_id,$ele_value[1]));
				$pds = $ele_value[1]/1024;
				$forms_ele->addElement(new XoopsFormLabel('&nbsp;&nbsp;&nbsp;'.$pds.' ko max.',''));

			break;
			default:
				return false;
			break;
		}
		return $forms_ele;
	}

}
?>