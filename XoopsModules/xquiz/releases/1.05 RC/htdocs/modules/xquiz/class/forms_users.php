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
class XquizForms_users extends XoopsObject
{
	
    function XquizForms_users($id = null)
    {
        $this->initVar('id_user', XOBJ_DTYPE_INT, null, false);
        $this->initVar('id_form', XOBJ_DTYPE_INT, null, false);
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 128);
        $this->initVar('email', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('twitter', XOBJ_DTYPE_TXTBOX, null, false, 64);
		$this->initVar('facebook', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('score', XOBJ_DTYPE_INT, null, false);
		$this->initVar('questions', XOBJ_DTYPE_INT, null, false);
		$this->initVar('followed', XOBJ_DTYPE_INT, null, false);
		$this->initVar('answers', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);
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
    
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array(), $const = '_MI_XQUIZ_FORM_USERS') {
    
        include_once($GLOBALS['xoops']->path('/modules/xquiz/include/xquiz.objects.php'));
        
    	xoops_loadLanguage('forms', 'xquiz');
    	
        $frmobj['required'][] = 'title';
        
        if (!empty($index))
    		$id = $index . '['. $this->getVar('id_user') . ']';
    	else 
    		$id = $this->getVar('id_user');
    		
    	if ($render==true||$captions==true) {
    		if (defined($const)&&defined($const.'_LABEL')&&defined($const.'_LABEL_DESC')) {
		    	$frmobj[$cursor]['label'] = new XoopsFormLabel('<font style="font-size:1.25em;">'.constant($const).'</font>', '<font style="font-size:1.25em;">'.sprintf(constant($const.'_LABEL'), constant($const)).'</font>');
		    	$frmobj[$cursor]['label']->setDescription(constant($const.'_LABEL_DESC'));
     		}   	    	

     		$frmobj[$cursor]['id_form'] = new XQuizFormSelectForm(_FRM_XQUIZ_FORM_USERS_FORM_ID, $id.'[id_form]', $this->getVar('id_form'));
     		$frmobj[$cursor]['id_form']->setDescription(_FRM_XQUIZ_FORM_USERS_FORM_ID_DESC);
     		$frmobj[$cursor]['uid'] = new XoopsFormSelectUser(_FRM_XQUIZ_FORM_USERS_UID, $id.'[uid]', true, $this->getVar('uid'));
	    	$frmobj[$cursor]['uid']->setDescription(_FRM_XQUIZ_FORM_USERS_UID_DESC);
	    	$frmobj[$cursor]['name'] = new XoopsFormText(_FRM_XQUIZ_FORM_USERS_NAME, $id.'[name]', 25, 128, $this->getVar('name'));
	    	$frmobj[$cursor]['name']->setDescription(_FRM_XQUIZ_FORM_USERS_NAME_DESC);
	    	$frmobj[$cursor]['email'] = new XoopsFormText(_FRM_XQUIZ_FORM_USERS_EMAIL, $id.'[email]', 35, 255, $this->getVar('email'));
	    	$frmobj[$cursor]['email']->setDescription(_FRM_XQUIZ_FORM_USERS_EMAIL_DESC);
	    	$frmobj[$cursor]['twitter'] = new XoopsFormText(_FRM_XQUIZ_FORM_USERS_TWITTER, $id.'[twitter]', 25, 64, $this->getVar('twitter'));
	    	$frmobj[$cursor]['twitter']->setDescription(_FRM_XQUIZ_FORM_USERS_TWITTER_DESC);
	    	$frmobj[$cursor]['facebook'] = new XoopsFormText(_FRM_XQUIZ_FORM_USERS_FACEBOOK, $id.'[facebook]', 35, 255, $this->getVar('facebook'));
	    	$frmobj[$cursor]['facebook']->setDescription(_FRM_XQUIZ_FORM_USERS_FACEBOOK_DESC);
	    	$frmobj[$cursor]['score'] = new XoopsFormText(_FRM_XQUIZ_FORM_USERS_SCORE, $id.'[score]', 10, 20, $this->getVar('score'));
	    	$frmobj[$cursor]['score']->setDescription(_FRM_XQUIZ_FORM_USERS_SCORE_DESC);
	    	$frmobj[$cursor]['questions'] = new XoopsFormText(_FRM_XQUIZ_FORM_USERS_QUESTIONS, $id.'[questions]', 10, 20, $this->getVar('questions'));
	    	$frmobj[$cursor]['questions']->setDescription(_FRM_XQUIZ_FORM_USERS_QUESTIONS_DESC);
	    	$frmobj[$cursor]['answers'] = new XoopsFormText(_FRM_XQUIZ_FORM_USERS_ANSWERS, $id.'[answers]', 10, 20, $this->getVar('answers'));
	    	$frmobj[$cursor]['answers']->setDescription(_FRM_XQUIZ_FORM_USERS_ANSWERS_DESC);
	    	if ($this->getVar('created')!=0) {
	    		$frmobj[$cursor]['created'] = new XoopsFormLabel(_FRM_XQUIZ_FORM_USERS_CREATED, date(_DATESTRING,$this->getVar('created')));
	    		$frmobj[$cursor]['created']->setDescription(_FRM_XQUIZ_FORM_USERS_CREATED_DESC);
	    	}
	    	if ($this->getVar('updated')!=0) {
		    	$frmobj[$cursor]['updated'] = new XoopsFormLabel(_FRM_XQUIZ_FORM_USERS_UPDATED, date(_DATESTRING,$this->getVar('updated')));
		    	$frmobj[$cursor]['updated']->setDescription(_FRM_XQUIZ_FORM_USERS_UPDATED_DESC);
	    	}
						
		    if (!empty($index))		    
	    		$frmobj[$cursor]['id_user'] = new XoopsFormHidden($index.'[id]['.$this->getVar('id_user').']', 'forms_users');
	    	else 
	    		$frmobj[$cursor]['id_user'] = new XoopsFormHidden('id['.$this->getVar('id_user').']', 'forms_users');
	    		
	    	if ($render==false)
	    		return $frmobj;
	    		
	    	if ($_REQUEST['fct']=='forms_users') {	
	    		$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    		$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'forms_users');
	    	}
    	} else {
	    	
     		$frmobj[$cursor]['id_form'] = new XQuizFormSelectForm('', $id.'[id_form]', $this->getVar('id_form'));
     		$frmobj[$cursor]['uid'] = new XoopsFormSelectUser('', $id.'[uid]', true, $this->getVar('uid'));
	    	$frmobj[$cursor]['name'] = new XoopsFormText('', $id.'[name]', 25, 128, $this->getVar('name'));
	    	$frmobj[$cursor]['email'] = new XoopsFormText('', $id.'[email]', 35, 255, $this->getVar('email'));
	    	$frmobj[$cursor]['twitter'] = new XoopsFormText('', $id.'[twitter]', 25, 64, $this->getVar('twitter'));
	    	$frmobj[$cursor]['facebook'] = new XoopsFormText('', $id.'[facebook]', 35, 255, $this->getVar('facebook'));
	    	$frmobj[$cursor]['score'] = new XoopsFormText('', $id.'[score]', 10, 20, $this->getVar('score'));
	    	$frmobj[$cursor]['questions'] = new XoopsFormText('', $id.'[questions]', 10, 20, $this->getVar('questions'));
	    	$frmobj[$cursor]['answers'] = new XoopsFormText('', $id.'[answers]', 10, 20, $this->getVar('answers'));
	    	if ($this->getVar('created')!=0) {
	    		$frmobj[$cursor]['created'] = new XoopsFormLabel('', date(_DATESTRING,$this->getVar('created')));
	    	}
	    	if ($this->getVar('updated')!=0) {
		    	$frmobj[$cursor]['updated'] = new XoopsFormLabel('', date(_DATESTRING,$this->getVar('updated')));
		    }
    							    
			if (!empty($index))		    
	    		$frmobj[$cursor]['id_user'] = new XoopsFormHidden($index.'[id]['.$this->getVar('id_user').']', 'forms_users');
	    	else 
	    		$frmobj[$cursor]['id_user'] = new XoopsFormHidden('id['.$this->getVar('id_user').']', 'forms_users');
	    	
	    	return $frmobj;
    	}
    	
    	$frmobj['submit']['submit'] = new XoopsFormButton('', _SUBMIT, 'submit', _SUBMIT);
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_FRM_XQUIZ_NEW_USER, 'forms_users', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_FRM_XQUIZ_EDIT_USER, 'forms_users', $_SERVER['PHP_SELF'], 'post');
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
class XquizForms_usersHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, 'forms_users', 'XquizForms_users', "id_user", "name");
    }
    
    function insert($object, $force=true) {
    	
    	if ($object->isNew()) {
    		$object->setVar('created', time());
    		if (is_object($GLOBALS['xoopsUser']))
    			$object->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
    	} else {
    		$object->setVar('updated', time());
    	}
    	
    	if (strlen($object->getVar('twitter'))>0&&$object->getVar('followed')==0) {
    		$forms_oauth_handler = xoops_getmodulehandler('forms_oauth', 'xquiz');
			$oauth = $forms_oauth_handler->getRootOauth(true);
			if (is_a($oauth, 'XquizForms_oauth')) {
				$oauth->createFollow($object->getVar('twitter'), 'screen_name');
				$object->setVar('followed', true);
			}
    	}
    	
    	return parent::insert($object, $force);
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
    
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array(), $const = '_MI_XQUIZ_FORM_USERS') {
    	$object = $this->create();
    	return $object->getForm($querystring, $captions, $render, $index, $cursor, $frmobj, $const);
    }
}

?>