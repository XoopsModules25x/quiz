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
class XquizForms_menu extends XoopsObject
{
	
    function XquizForms_menu($id = null)
    {
        $this->initVar('menuid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('position', XOBJ_DTYPE_INT, null, false);
        $this->initVar('indent', XOBJ_DTYPE_INT, null, false);
		$this->initVar('itemname', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('margintop', XOBJ_DTYPE_TXTBOX, null, false, 12);
		$this->initVar('marginbottom', XOBJ_DTYPE_TXTBOX, null, false, 12);
		$this->initVar('itemurl', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('bold', XOBJ_DTYPE_INT, null, false);
		$this->initVar('status', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);
	}
	
	function getForms() {
    
        include_once($GLOBALS['xoops']->path('/modules/xquiz/include/xquiz.objects.php'));
        
    	xoops_loadLanguage('forms', 'xshop');
    	
	    $frmobj['itemname'] = new XoopsFormsText(_FRM_XQUIZ_FORM_MENU_IDENT, 'itemname', 35, 128, $this->getVar('itemname'));
	    $frmobj['itemname']->setDescription(_FRM_XQUIZ_FORM_MENU_IDENT_DESC);
	    $frmobj['itemurl'] = new XoopsFormsText(_FRM_XQUIZ_FORM_MENU_IDENT, 'itemurl', 35, 255, $this->getVar('itemurl'));
	    $frmobj['itemurl']->setDescription(_FRM_XQUIZ_FORM_MENU_IDENT_DESC);
     	$frmobj['position'] = new XoopsFormsText(_FRM_XQUIZ_FORM_MENU_POSITION, 'position', 10, 15, $this->getVar('position'));
	    $frmobj['position']->setDescription(_FRM_XQUIZ_FORM_MENU_POSITION_DESC);
	    $frmobj['margintop'] = new XoopsFormsText(_FRM_XQUIZ_FORM_MENU_MARGINTOP, 'margintop', 10, 12, $this->getVar('margintop'));
	    $frmobj['margintop']->setDescription(_FRM_XQUIZ_FORM_MENU_MARGINTOP_DESC);
	    $frmobj['marginbottom'] = new XoopsFormsText(_FRM_XQUIZ_FORM_MENU_MARGINBOTTOM, 'marginbottom', 10, 12, $this->getVar('marginbottom'));
	    $frmobj['marginbottom']->setDescription(_FRM_XQUIZ_FORM_MENU_MARGINBOTTOM_DESC);
	    $frmobj['indent'] = new XoopsFormsText(_FRM_XQUIZ_FORM_MENU_IDENT, 'indent', 10, 15, $this->getVar('indent'));
	    $frmobj['indent']->setDescription(_FRM_XQUIZ_FORM_MENU_IDENT_DESC);
	    $frmobj['bold'] = new XoopsFormsRadioYN(_FRM_XQUIZ_FORM_MENU_IDENT, 'bold', $this->getVar('bold'));
	    $frmobj['bold']->setDescription(_FRM_XQUIZ_FORM_MENU_IDENT_DESC);
	    $frmobj['status'] = new XoopsFormsRadioYN(_FRM_XQUIZ_FORM_MENU_STATUS, 'status', $this->getVar('status'));
	    $frmobj['status']->setDescription(_FRM_XQUIZ_FORM_MENU_STATUS_DESC);
	    
    	
    	$frmobj['submit'] = new XoopsFormsButton('', _SUBMIT, 'submit', _SUBMIT);
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForms(_FRM_XQUIZ_NEW_MENU, 'forms_menu', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForms(_FRM_XQUIZ_EDIT_MENU, 'forms_menu', $_SERVER['PHP_SELF'], 'post');
    	}
   	
    	foreach($frmobj as $key => $value) {
    		$form->addElement($frmobj[$key], false);
		}
    	
    	$form->addElement(new XoopsFormsHidden('sort', $_REQUEST['sort']), false);
    	$form->addElement(new XoopsFormsHidden('order', $_REQUEST['order']), false);
    	$form->addElement(new XoopsFormsHidden('start', $_REQUEST['start']), false);
    	$form->addElement(new XoopsFormsHidden('limit', $_REQUEST['limit']), false);
    	$form->addElement(new XoopsFormsHidden('filter', $_REQUEST['filter']), false);
    	
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
class XquizForms_menuHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, 'forms_menu', 'XquizForms_menu', "menuid", "itemname");
    }

    function getIndex($limit=0, $start=0) {
    	include_once('forms_id.php');
    	
    	$sql = "SELECT f.* , m.* FROM " . $xoopsDB->prefix("forms_id") . " f LEFT JOIN " . $xoopsDB->prefix("forms_menu") . " m on f.id_form = m.menuid WHERE m.status =1 ORDER BY m.position";
    	
    	$result = $this->db->query($sql, $limit, $start);

		if( !$result ){
			return false;
		}
		while( $myrow = $this->db->fetchArray($result) ){
			$elements = array();
			$elements['form'] = new XquizForms_id();
			$elements['form']->assignVars($myrow);
			$elements['menu'] = new XquizForms_menu();
			$elements['menu']->assignVars($myrow);
			if( !$id_as_key ){
				$ret[] =& $elements;
			}else{
				$ret[$myrow['ele_id']] =& $elements;
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
		return parent::insert($object, $force);
	}
}

?>