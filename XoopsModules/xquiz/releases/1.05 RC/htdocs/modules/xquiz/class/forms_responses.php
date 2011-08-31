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
class XquizForms_responses extends XoopsObject
{
	
    function XquizForms_responses($id = null)
    {
        $this->initVar('id_answer', XOBJ_DTYPE_INT, null, false);
        $this->initVar('id_form', XOBJ_DTYPE_INT, null, false);
        $this->initVar('id_ele', XOBJ_DTYPE_INT, null, false);
        $this->initVar('id_user', XOBJ_DTYPE_INT, null, false);
		$this->initVar('value_ele', XOBJ_DTYPE_ARRAY, null, false);
		$this->initVar('value_score', XOBJ_DTYPE_INT, null, false);
		$this->initVar('value_answers', XOBJ_DTYPE_INT, null, false);
		$this->initVar('response', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);
	}
	   
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array(), $const = '_MI_XQUIZ_FORM_RESPONSES') {
    
        include_once($GLOBALS['xoops']->path('/modules/xquiz/include/xquiz.objects.php'));
        
    	xoops_loadLanguage('forms', 'xquiz');
    	
        $frmobj['required'][] = 'title';
        
        if (!empty($index))
    		$id = $index . '['. $this->getVar('id_answer') . ']';
    	else 
    		$id = $this->getVar('id_answer');
    		
    	if ($render==true||$captions==true) {
    		if (defined($const)&&defined($const.'_LABEL')&&defined($const.'_LABEL_DESC')) {
		    	$frmobj[$cursor]['label'] = new XoopsFormLabel('<font style="font-size:1.25em;">'.constant($const).'</font>', '<font style="font-size:1.25em;">'.sprintf(constant($const.'_LABEL'), constant($const)).'</font>');
		    	$frmobj[$cursor]['label']->setDescription(constant($const.'_LABEL_DESC'));
     		}   	    	

     		$frmobj[$cursor]['id_form'] = new XQuizFormSelectForm(_FRM_XQUIZ_FORM_RESPONSES_FORM_ID, $id.'[id_form]', $this->getVar('id_form'));
     		$frmobj[$cursor]['id_form']->setDescription(_FRM_XQUIZ_FORM_RESPONSES_FORM_ID_DESC);
     		$frmobj[$cursor]['id_ele'] = new XQuizFormSelectElement(_FRM_XQUIZ_FORM_RESPONSES_ID_ELE, $id.'[id_ele]', $this->getVar('id_ele'));
	    	$frmobj[$cursor]['id_ele']->setDescription(_FRM_XQUIZ_FORM_RESPONSES_ID_ELE_DESC);
     		$frmobj[$cursor]['id_user'] = new XQuizFormSelectUsers(_FRM_XQUIZ_FORM_RESPONSES_ID_USER, $id.'[id_user]', $this->getVar('id_user'));
	    	$frmobj[$cursor]['id_user']->setDescription(_FRM_XQUIZ_FORM_RESPONSES_ID_USER_DESC);

	    	$frmobj[$cursor]['value_ele'] = new XoopsFormTextArea(_FRM_XQUIZ_FORM_RESPONSES_VALUE_ELE, implode('|',$this->getVar('value_ele')));
	    	$frmobj[$cursor]['value_ele']->setDescription(_FRM_XQUIZ_FORM_RESPONSES_VALUE_ELE_DESC);
	    	$frmobj[$cursor]['value_score'] = new XoopsFormText(_FRM_XQUIZ_FORM_RESPONSES_VALUE_SCORE, 10, 15, $this->getVar('value_score'));
	    	$frmobj[$cursor]['value_score']->setDescription(_FRM_XQUIZ_FORM_RESPONSES_VALUE_SCORE_DESC);
	    	$frmobj[$cursor]['value_answers'] = new XoopsFormText(_FRM_XQUIZ_FORM_RESPONSES_VALUE_ANSWERS, 10, 15, $this->getVar('value_answers'));
	    	$frmobj[$cursor]['value_answers']->setDescription(_FRM_XQUIZ_FORM_RESPONSES_VALUE_ANSWERS_DESC);
	    	
	    	if ($this->getVar('response')!=0) {
	    		$frmobj[$cursor]['response'] = new XoopsFormLabel(_FRM_XQUIZ_FORM_RESPONSES_RESPONSE, date(_DATESTRING,$this->getVar('response')));
	    		$frmobj[$cursor]['response']->setDescription(_FRM_XQUIZ_FORM_RESPONSES_RESPONSE_DESC);
	    	}
	    	
    		if ($this->getVar('created')!=0) {
	    		$frmobj[$cursor]['created'] = new XoopsFormLabel(_FRM_XQUIZ_FORM_RESPONSES_CREATED, date(_DATESTRING,$this->getVar('created')));
	    		$frmobj[$cursor]['created']->setDescription(_FRM_XQUIZ_FORM_RESPONSES_CREATED_DESC);
	    	}
	    	
    		if ($this->getVar('updated')!=0) {
	    		$frmobj[$cursor]['updated'] = new XoopsFormLabel(_FRM_XQUIZ_FORM_RESPONSES_UPDATED, date(_DATESTRING,$this->getVar('updated')));
	    		$frmobj[$cursor]['updated']->setDescription(_FRM_XQUIZ_FORM_RESPONSES_UPDATED_DESC);
	    	}
						
		    if (!empty($index))		    
	    		$frmobj[$cursor]['id_answer'] = new XoopsFormHidden($index.'[id]['.$this->getVar('id_answer').']', 'forms_responses');
	    	else 
	    		$frmobj[$cursor]['id_answer'] = new XoopsFormHidden('id['.$this->getVar('id_answer').']', 'forms_responses');
	    		
	    	if ($render==false)
	    		return $frmobj;
	    		
	    	if ($_REQUEST['fct']=='forms_responses') {	
	    		$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    		$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'forms_responses');
	    	}
    	} else {
	    	
			$frmobj[$cursor]['id_form'] = new XQuizFormSelectForm('', $id.'[id_form]', $this->getVar('id_form'));
     		$frmobj[$cursor]['id_ele'] = new XQuizFormSelectElement('', $id.'[id_ele]', $this->getVar('id_ele'));
     		$frmobj[$cursor]['id_user'] = new XQuizFormSelectUsers('', $id.'[id_user]', $this->getVar('id_user'));
	    	$frmobj[$cursor]['value_ele'] = new XoopsFormLabel('', implode('<br/>', $this->getVar('value_ele')));
	    	$frmobj[$cursor]['value_score'] = new XoopsFormLabel('', $this->getVar('value_score'));
	    	$frmobj[$cursor]['value_answers'] = new XoopsFormLabel('', $this->getVar('value_answers'));
	    	
	    	if ($this->getVar('response')!=0) {
	    		$frmobj[$cursor]['response'] = new XoopsFormLabel('', date(_DATESTRING,$this->getVar('response')));
	    	}
    		if ($this->getVar('created')!=0) {
	    		$frmobj[$cursor]['created'] = new XoopsFormLabel('', date(_DATESTRING,$this->getVar('created')));
	    	}
	    	
    		if ($this->getVar('updated')!=0) {
	    		$frmobj[$cursor]['updated'] = new XoopsFormLabel('', date(_DATESTRING,$this->getVar('updated')));
	    	}
	    	    		    							    
			if (!empty($index))		    
	    		$frmobj[$cursor]['id_answer'] = new XoopsFormHidden($index.'[id]['.$this->getVar('id_answer').']', 'forms_responses');
	    	else 
	    		$frmobj[$cursor]['id_answer'] = new XoopsFormHidden('id['.$this->getVar('id_answer').']', 'forms_responses');
	    	
	    	return $frmobj;
    	}
    	
    	$frmobj['submit']['submit'] = new XoopsFormButton('', _SUBMIT, 'submit', _SUBMIT);
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_FRM_XQUIZ_NEW_RESPONSE, 'forms_responses', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_FRM_XQUIZ_EDIT_RESPONSE, 'forms_responses', $_SERVER['PHP_SELF'], 'post');
    	}
   	
    	foreach($frmobj as $key => $value) {
    		if ($key!='required') {
   	 			foreach($value as $field => $valueb) {
		    		if (!in_array($field, $frmobj['required'])) {
		    			$form->addElement($frmobj[$key][$field], false);
		    		} else {
		    			$form->addElement($frmobj[$key][$field], true);
		    		}
    			}
    		}
    	}
    	
    	$form->addElement(new XoopsFormHidden('sort', $_REQUEST['sort']), false);
    	$form->addElement(new XoopsFormHidden('order', $_REQUEST['order']), false);
    	$form->addElement(new XoopsFormHidden('start', $_REQUEST['start']), false);
    	$form->addElement(new XoopsFormHidden('limit', $_REQUEST['limit']), false);
    	$form->addElement(new XoopsFormHidden('filter', $_REQUEST['filter']), false);
    	
    	return $form->render();	
    	
    }
    
    function toArray() {
    	$ret = parent::toArray();
		$frms = $this->getForm($_SERVER['QUERY_STRING'], false, false, '', 'base', array());
    	foreach($frms as $key => $value) {
    		if ($key!='required') {
   	 			foreach($value as $field => $valueb) {
	    		    $ret['forms'][$key][$field] = $frms[$key][$field]->render();
    			}
    		}
    	}
    	foreach($ret as $key => $value) {
    		if (is_array($value)) {
    			foreach($value as $keyb => $valueb) {
    				if (is_array($valueb)) {
    					foreach($valueb as $keyc => $valuec) {
    						$ret[$key.'_'.$keyb.'_'.$keyc] = $valuec;
    						unset($ret[$key][$keyb][$keyc]);
    					}
    				} else {
    					$ret[$key.'_'.$keyb] = $valueb;
    					unset($ret[$key][$keyb]);
    				}
    			}
    			unset($ret[$key]);
    		} else {
    			if (defined($value)) {
    				$ret[$key] = ucfirst(constant($value));
    			}
    		}
    	}
    	return $ret;
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
class XquizForms_responsesHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, 'forms_answers', 'XquizForms_responses', "id_answer", "value_score");
    }
    
 	function getFilterCriteria($filter) {
    	$parts = explode('|', $filter);
    	$criteria = new CriteriaCompo();
    	foreach($parts as $part) {
    		$var = explode(',', $part);
    		if (!empty($var[1])&&!is_numeric($var[0])) {
    			$object = $this->create();
    			if (		$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_TXTBOX || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_TXTAREA) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', '%'.$var[1].'%', (isset($var[2])?$var[2]:'LIKE')));
    			} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_INT || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_DECIMAL || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_FLOAT ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', $var[1], (isset($var[2])?$var[2]:'=')));			
				} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_ENUM ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', $var[1], (isset($var[2])?$var[2]:'=')));    				
				} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_ARRAY ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', '%"'.$var[1].'";%', (isset($var[2])?$var[2]:'LIKE')));    				
				}
    			$criteria->add(new Criteria("'".$var[0]."'", $var[1]));
    		}
    	}
    	return $criteria;
    }
        
	function getFilterForm($filter, $field, $sort='created', $fct = '') {
    	$ele = xquiz_getFilterElement($filter, $field, $sort, $fct);
    	if (is_object($ele))
    		return $ele->render();
    	else 
    		return '&nbsp;';
    }
    
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array(), $const = '_MI_XQUIZ_FORM_RESPONSES') {
    	$object = $this->create();
    	return $object->getForm($querystring, $captions, $render, $index, $cursor, $frmobj, $const);
    }    
    
	function insert($object, $force=true) {
		if ($object->isNew()) {
			$object->setVar('created', time());
		} else {
			$object->setVar('updated', time());
		}
		return parent::insert($object, $force);
	}
}

?>