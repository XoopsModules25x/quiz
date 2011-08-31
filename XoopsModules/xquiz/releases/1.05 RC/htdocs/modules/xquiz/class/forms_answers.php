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
class XquizForms_answers extends XoopsObject
{
	
    function XquizForms_answers($id = null)
    {
        $this->initVar('id_score', XOBJ_DTYPE_INT, null, false);
        $this->initVar('id_form', XOBJ_DTYPE_INT, null, false);
        $this->initVar('minimum', XOBJ_DTYPE_INT, null, false);
        $this->initVar('maximum', XOBJ_DTYPE_INT, null, false);
		$this->initVar('html', XOBJ_DTYPE_OTHER, null, false);
		$this->initVar('title', XOBJ_DTYPE_TXTBOX, null, false, 255);
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
    
	function getURL() {
		if ($GLOBALS['xoopsModuleConfig']['htaccess']==true) {
			return XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/answer,'.md5($this->getVar('id_score').XOOPS_LICENSE_KEY.xoops_getenv('REMOTE_ADDR')).$GLOBALS['xoopsModuleConfig']['endofurl'];
		} else {
			return XOOPS_URL.'/modules/xquiz/index.php?answer='.md5($this->getVar('id_score').XOOPS_LICENSE_KEY.xoops_getenv('REMOTE_ADDR'));
		}
	}
	
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array(), $const = '_MI_XQUIZ_FORM_ANSWERS') {
    
        include_once($GLOBALS['xoops']->path('/modules/xquiz/include/xquiz.objects.php'));
        
    	xoops_loadLanguage('forms', 'xquiz');
    	
        $frmobj['required'][] = 'title';
        
        if (!empty($index))
    		$id = $index . '['. $this->getVar('id_score') . ']';
    	else 
    		$id = $this->getVar('id_score');
    		
    	if ($render==true||$captions==true) {
    		if (defined($const)&&defined($const.'_LABEL')&&defined($const.'_LABEL_DESC')) {
		    	$frmobj[$cursor]['label'] = new XoopsFormLabel('<font style="font-size:1.25em;">'.constant($const).'</font>', '<font style="font-size:1.25em;">'.sprintf(constant($const.'_LABEL'), constant($const)).'</font>');
		    	$frmobj[$cursor]['label']->setDescription(constant($const.'_LABEL_DESC'));
     		}   	    	

     		$frmobj[$cursor]['id_form'] = new XQuizFormSelectForm(_FRM_XQUIZ_FORMS_ANSWERS_ID_FORM, $id.'[id_form]', $this->getVar('id_form'), 1, false, true);
     		$frmobj[$cursor]['id_form']->setDescription(_FRM_XQUIZ_FORMS_ANSWERS_ID_FORM_DESC);
     		$frmobj[$cursor]['minimum'] = new XoopsFormText(_FRM_XQUIZ_FORMS_ANSWERS_MINIMUM, $id.'[minimum]', 10, 15, $this->getVar('minimum'));
	    	$frmobj[$cursor]['minimum']->setDescription(_FRM_XQUIZ_FORMS_ANSWERS_MINIMUM_DESC);
	    	$frmobj[$cursor]['maximum'] = new XoopsFormText(_FRM_XQUIZ_FORMS_ANSWERS_MAXIMUM, $id.'[maximum]', 10, 15, $this->getVar('maximum'));
	    	$frmobj[$cursor]['maximum']->setDescription(_FRM_XQUIZ_FORMS_ANSWERS_MAXIMUM_DESC);
	    	$frmobj[$cursor]['title'] = new XoopsFormText(_FRM_XQUIZ_FORMS_ANSWERS_TITLE, $id.'[title]', 35, 128, $this->getVar('title'));
	    	$frmobj[$cursor]['title']->setDescription(_FRM_XQUIZ_FORMS_ANSWERS_TITLE_DESC);
	    	
			$html_configs = array();
			$html_configs['name'] = $id.'[html]';
			$html_configs['value'] = $this->getVar('html');
			$html_configs['rows'] = 35;
			$html_configs['cols'] = 60;
			$html_configs['width'] = "100%";
			$html_configs['height'] = "400px";
			$html_configs['editor'] = $GLOBALS['xoopsModuleConfig']['editor'];
			$frmobj[$cursor]['html'] = new XoopsFormEditor(_FRM_XQUIZ_FORMS_ANSWERS_HTML, $html_configs['name'], $html_configs);
			$frmobj[$cursor]['html']->setDescription(_FRM_XQUIZ_FORMS_ANSWERS_HTML_DESC);
			
			
		    if (!empty($index))		    
	    		$frmobj[$cursor]['id_score'] = new XoopsFormHidden($index.'[id]['.$this->getVar('id_score').']', 'forms_answers');
	    	else 
	    		$frmobj[$cursor]['id_score'] = new XoopsFormHidden('id['.$this->getVar('id_score').']', 'forms_answers');
	    		
	    	if ($render==false)
	    		return $frmobj;
	    		
	    	if ($_REQUEST['fct']=='forms_answers') {	
	    		$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    		$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'forms_answers');
	    	}
    	} else {
	    	
	    	
     		$frmobj[$cursor]['id_form'] = new XQuizFormSelectForm('', $id.'[id_form]', $this->getVar('id_form'), 1, false, true);
     		$frmobj[$cursor]['minimum'] = new XoopsFormText('', $id.'[minimum]', 10, 15, $this->getVar('minimum'));
	    	$frmobj[$cursor]['maximum'] = new XoopsFormText('', $id.'[maximum]', 10, 15, $this->getVar('maximum'));
	    	$frmobj[$cursor]['title'] = new XoopsFormText('', $id.'[title]', 35, 128, $this->getVar('title'));
	    		    	
			$html_configs = array();
			$html_configs['name'] = $id.'[html]';
			$html_configs['value'] = $this->getVar('html');
			$html_configs['rows'] = 35;
			$html_configs['cols'] = 60;
			$html_configs['width'] = "100%";
			$html_configs['height'] = "400px";
			$html_configs['editor'] = $GLOBALS['xoopsModuleConfig']['editor'];
			$frmobj[$cursor]['html'] = new XoopsFormEditor(_FRM_XQUIZ_ANSWERS_HTML, $html_configs['name'], $html_configs);
					    
			if (!empty($index))		    
	    		$frmobj[$cursor]['id_score'] = new XoopsFormHidden($index.'[id]['.$this->getVar('id_score').']', 'forms_answers');
	    	else 
	    		$frmobj[$cursor]['id_score'] = new XoopsFormHidden('id['.$this->getVar('id_score').']', 'forms_answers');
	    	
	    	return $frmobj;
    	}
    	
    	$frmobj['submit']['submit'] = new XoopsFormButton('', _SUBMIT, 'submit', _SUBMIT);
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_FRM_XQUIZ_NEW_ANSWER, 'forms_answers', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_FRM_XQUIZ_EDIT_ANSWER, 'forms_answers', $_SERVER['PHP_SELF'], 'post');
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
}


/**
* XOOPS policies handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Simon Roberts <simon@chronolabs.coop>
* @package kernel
*/
class XquizForms_answersHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, 'forms_responses', 'XquizForms_answers', "id_score", "title");
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
    
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array(), $const = '_MI_XQUIZ_FORM_ANSWERS') {
    	$object = $this->create();
    	return $object->getForm($querystring, $captions, $render, $index, $cursor, $frmobj, $const);
    }
}

?>