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
class XquizForms_id extends XoopsObject
{
	
    function XquizForms_id($id_form = null)
    {
        $this->initVar('id_form', XOBJ_DTYPE_INT, null, false);
		$this->initVar('title', XOBJ_DTYPE_TXTBOX, null, false, 128);
        $this->initVar('desc_form', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('admin', XOBJ_DTYPE_TXTBOX, null, false, 5);
		$this->initVar('groupe', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('email', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('expe', XOBJ_DTYPE_TXTBOX, null, false, 5);
		$this->initVar('url', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('help', XOBJ_DTYPE_OTHER, null, false);
		$this->initVar('send', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('msend', XOBJ_DTYPE_TXTBOX, null, false, 5);
		$this->initVar('msub', XOBJ_DTYPE_TXTBOX, null, false, 5);
		$this->initVar('mip', XOBJ_DTYPE_TXTBOX, null, false, 5);
		$this->initVar('mnav', XOBJ_DTYPE_TXTBOX, null, false, 5);
		$this->initVar('cod', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('save', XOBJ_DTYPE_TXTBOX, null, false, 5);
		$this->initVar('onlyone', XOBJ_DTYPE_TXTBOX, null, false, 5);
		$this->initVar('image', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('nbjours', XOBJ_DTYPE_TXTBOX, null, false, 10);
		$this->initVar('afftit', XOBJ_DTYPE_TXTBOX, null, false, 5);
		$this->initVar('affimg', XOBJ_DTYPE_TXTBOX, null, false, 5);
		$this->initVar('ordre', XOBJ_DTYPE_TXTBOX, null, false, 50);
		$this->initVar('qcm', XOBJ_DTYPE_TXTBOX, null, false, 5);
		$this->initVar('affres', XOBJ_DTYPE_TXTBOX, null, false, 5);
		$this->initVar('affrep', XOBJ_DTYPE_TXTBOX, null, false, 5);
		$this->initVar('tag', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);
	}
	
	function getURL() {
		if ($GLOBALS['xoopsModuleConfig']['htaccess']==true) {
			if ($this->getVar('qcm')!='0'&&strlen($this->getVar('qcm'))>0) {
				return XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/'.urlencode(str_replace(array(' ', '_'), '-', $this->getVar('title'))).'/'.$this->getVar('id_form').','.$this->getVar('qcm').$GLOBALS['xoopsModuleConfig']['endofurl'];
			} else {
				return XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/'.urlencode(str_replace(array(' ', '_'), '-', $this->getVar('title'))).'/'.$this->getVar('id_form').',0'.$GLOBALS['xoopsModuleConfig']['endofurl'];
			}
		} else {
			if ($this->getVar('qcm')!='0'&&strlen($this->getVar('qcm'))>0) {
				return XOOPS_URL . "/modules/" . $GLOBALS['xoopsModule']->getVar('dirname') . "/xquiz.php?id=" . $this->getVar('id_form').'&qcm='.$this->getVar('qcm');
			} else {
				return XOOPS_URL . "/modules/" . $GLOBALS['xoopsModule']->getVar('dirname') . "/xquiz.php?id=" . $this->getVar('id_form').'&qcm=0';
			}
		}
	}
	
	function getForm($querystring, $url) {
		xoops_loadLanguage('forms','xquiz');
		extract($this->toArray());
		
		$sql="SELECT groupid,name FROM ".$GLOBALS['xoopsDB']->prefix("groups");
		$res = $GLOBALS['xoopsDB']->query( $sql );
		if ( $res ) {
		$tab[$m] = 0;
		$tab2[$m] = "";
		$m++;
		  while ( $row = $GLOBALS['xoopsDB']->fetchArray($res)) {
		    $tab[$m] = $row['groupid'];
		    $tab2[$m] = $row['name'];
		    $m++;
		  }
		}
		
		if ($id_form != '') {
			$title_form = new XoopsFormElementTray(_FRM_XQUIZ_TITLE,'');
			$title_form->addElement(new XoopsFormText('','newtitle2',30,255,$title));
			if ($afftit == '1') {
				$titaff = new XoopsFormCheckBox("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"._FRM_XQUIZ_DISPLAY,'afftit',1);
				$titaff->addOption(1,' ');
			} else {
				$titaff = new XoopsFormCheckBox("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"._FRM_XQUIZ_DISPLAY,'afftit');
				$titaff->addOption(1,' ');
			}
				$title_form->addElement($titaff);
			
				$form = new XoopsThemeForm(_FRM_XQUIZ_MOD.' '.$title,'update',$url,'post'); 
				$form -> addElement($title_form);
	
		} else {
	
			$title_form = new XoopsFormElementTray(_FRM_XQUIZ_TITLE,'');
			$title_form->addElement(new XoopsFormText('','newtitle',30,255,""));
			$titaff = new XoopsFormCheckBox("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"._FRM_XQUIZ_DISPLAY,'afftit');
			$titaff->addOption(1,' ');
			$title_form->addElement($titaff);
			
			$form = new XoopsThemeForm(_FRM_XQUIZ_CREAT,'create',$url,'post'); 
			$form -> addElement($title_form);
		}
	
		$image = new XoopsFormElementTray(_FRM_XQUIZ_IMAGE,'');
	
		$images_array = XoopsLists :: getImgListAsArray( XOOPS_ROOT_PATH . "/uploads/xquiz/imgform" ); 
		if ($id_form != '') {
			$imgsel = new XoopsFormSelect('', "image", $image);
		} else {
			$imgsel = new XoopsFormSelect('', "image");
		}
		$imgsel->addOptionArray($images_array);
		$image->addElement($imgsel);
	
		if ($id_form != '' && $affimg == '1') {
			$imgaff = new XoopsFormCheckBox("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"._FRM_XQUIZ_DISPLAY,'affimg',1);
			$imgaff->addOption(1,' ');
		} else {
			$imgaff = new XoopsFormCheckBox("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"._FRM_XQUIZ_DISPLAY,'affimg');
			$imgaff->addOption(1,' ');
		}
		
		$image->addElement($imgaff);
	
		if ($id_form != '') {
		  $ordre_form = new XoopsFormRadio(_FRM_XQUIZ_ORDER,'ordre',$ordre);
		} else {
		  $ordre_form = new XoopsFormRadio(_FRM_XQUIZ_ORDER,'ordre','tit');
		}
	  	$ordre_form -> addOption('tit',_FRM_XQUIZ_DTIT);
	  	$ordre_form -> addOption('img',_FRM_XQUIZ_DIMG);
		$email_form = new XoopsFormText(_FRM_XQUIZ_EMAIL,'email',30,255,$email);
		$select_forms_group_perm = new XoopsFormSelectGroup(_FRM_XQUIZ_GROUP, 'groupe', true, $tab2[$i], 4, false);
	
		for($i=0;$i<$m;$i++) {
			if($id_form != '' && $tab[$i]==$groupe){
				$select_forms_group_perm = new XoopsFormSelectGroup(_FRM_XQUIZ_GROUP, 'groupe', true, $groupe, 4, false);
			}
		}
		
		$select_forms_group_perm->addOption(' ',_FRM_XQUIZ_NO_GROUP);
		
		if ($id_form != '' && $admin == '1') {
			$admin_form = new XoopsFormCheckBox(_FRM_XQUIZ_ADMIN, 'admin',1);
			$admin_form -> addOption(1,' ');
		} else {
			$admin_form = new XoopsFormCheckBox(_FRM_XQUIZ_ADMIN, 'admin');
			$admin_form -> addOption(1,' ');
		}
		
		if ($id_form != '' && $expe == '1') {
			$expe_form = new XoopsFormCheckBox(_FRM_XQUIZ_EXPE, 'expe',1);
			$expe_form -> addOption(1,' ');
		} else {
			$expe_form = new XoopsFormCheckBox(_FRM_XQUIZ_EXPE, 'expe');
			$expe_form -> addOption(1,' ');
		}
		
		if ($id_form == '') {
			$url = XOOPS_URL;
		}
		
		$url_form = new XoopsFormText(_FRM_XQUIZ_URL,'url',70,255,$url);
		
		$help = str_replace ("<br />", "\r\n", $help);
		$help_form = new XoopsFormTextArea(_FRM_XQUIZ_HELP,'help',$help,5,50);
		
		if ($id_form == '') {
			$send = _BUTTON_SEND;
		}
		$send_form = new XoopsFormText(_FRM_XQUIZ_SEND,'send',30,255,$send);
		$mail_form = new XoopsFormElementTray(_FRM_XQUIZ_ELESEND,'');
		
		if ($id_form != '' && $msub == '1') {
			$msub_form = new XoopsFormCheckBox(_FRM_XQUIZ_TABELE_SUB,'msub',1);
			$msub_form -> addOption(1,' ');
		} else {
			$msub_form = new XoopsFormCheckBox(_FRM_XQUIZ_TABELE_SUB, 'msub');
			$msub_form -> addOption(1,' ');
		}
		
		if ($id_form != '' && $mip == '1') {
			$mip_form = new XoopsFormCheckBox('<br />'._FRM_XQUIZ_TABELE_IP,'mip',1);
			$mip_form -> addOption(1,' ');
		} else {
			$mip_form = new XoopsFormCheckBox('<br />'._FRM_XQUIZ_TABELE_IP, 'mip');
			$mip_form -> addOption(1,' ');
		}
		
		if ($id_form != '' && $mnav == '1') {
			$mnav_form = new XoopsFormCheckBox('<br />'._FRM_XQUIZ_TABELE_NAV,'mnav',1);
			$mnav_form -> addOption(1,' ');
		} else {
			$mnav_form = new XoopsFormCheckBox('<br />'._FRM_XQUIZ_TABELE_NAV, 'mnav');
			$mnav_form -> addOption(1,' ');
		}
		
		$mail_form->addElement($msub_form);
		$mail_form->addElement($mip_form);
		$mail_form->addElement($mnav_form);
		if ($id_form != '') {
			$cod_form = new XoopsFormSelect(_FRM_XQUIZ_COD,'cod',$cod,1,false);
		} else {
			$cod_form = new XoopsFormSelect(_FRM_XQUIZ_COD,'cod','ISO-8859-1',1,false);
		}
		$codes = array("ISO-8859-1"=>"ISO-8859-1","ISO-8859-15"=>"ISO-8859-15","UTF-8"=>"UTF-8","cp866"=>"cp866","cp1251"=>"cp1251","cp1252"=>"cp1252","KOI8-R"=>"KOI8-R","BIG5"=>"BIG5","GB2312"=>"GB2312","BIG5-HKSCS"=>"BIG5-HKSCS","Shift_JIS"=>"Shift_JIS","EUC-JP"=>"EUC-JP");
		$cod_form->addOptionArray($codes);
			
		if ($id_form != '' && $save == '1') {
			$save_form = new XoopsFormCheckBox(_FRM_XQUIZ_SAVE_SEND,'save',1);
			$save_form -> addOption(1,' ');
		} else {
			$save_form = new XoopsFormCheckBox(_FRM_XQUIZ_SAVE_SEND, 'save');
			$save_form -> addOption(1,' ');
		}
		
		$oo_form = new XoopsFormElementTray(_FRM_XQUIZ_ONLYONE_SEND,'');
		
		if ($id_form != '' && $onlyone == '1') {
			$onlyone_form = new XoopsFormCheckBox('','onlyone',1);
			$onlyone_form -> addOption(1,' ');
		} else {
			$onlyone_form = new XoopsFormCheckBox('', 'onlyone');
			$onlyone_form -> addOption(1,' ');
		}
		
		$nbjours_form = new XoopsFormText('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','nbjours',5,10,$nbjours);
		$textdays_form = new XoopsFormLabel('',_FRM_XQUIZ_NBDAYS);
			
		$oo_form->addElement($onlyone_form);
		$oo_form->addElement($nbjours_form);
		$oo_form->addElement($textdays_form);
		
		if ($id_form != '' && $qcm == '1') {
			$qcm_form = new XoopsFormCheckBox(_FRM_XQUIZ_QCM, 'qcm',1);
			$qcm_form -> addOption(1,' ');
		} else {
			$qcm_form = new XoopsFormCheckBox(_FRM_XQUIZ_QCM, 'qcm');
			$qcm_form -> addOption(1,' ');
		}
		
		if ($id_form != '' && $affres == '1') {
			$affres_form = new XoopsFormCheckBox(_FRM_XQUIZ_AFFRES, 'affres',1);
			$affres_form -> addOption(1,' ');
		} else {
			$affres_form = new XoopsFormCheckBox(_FRM_XQUIZ_AFFRES, 'affres');
			$affres_form -> addOption(1,' ');
		}
			
		if ($id_form != '' && $affrep == '1') {
			$affrep_form = new XoopsFormCheckBox(_FRM_XQUIZ_AFFREP, 'affrep',1);
			$affrep_form -> addOption(1,' ');
		} else {
			$affrep_form = new XoopsFormCheckBox(_FRM_XQUIZ_AFFREP, 'affrep');
			$affrep_form -> addOption(1,' ');
		}	
		
		$affre_form = new XoopsFormElementTray(_FRM_XQUIZ_AFFRE,'');
		$affre_form -> addElement($affres_form);
		$affre_form -> addElement($affrep_form);
			
		$submit = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');

		$desc_forms_form = new XoopsFormElementTray(_FRM_XQUIZ_DESC,'');
		$desc_forms_form->addElement(new XoopsFormText('','desc_form',30,255,$desc_form));
		
		$form -> addElement($desc_forms_form);
		
		if ($GLOBALS['xoopsModuleConfig']['tag']) {
			$itemid = $this->isNew() ? 0 : $this->getVar("id_form");
			$form->addElement(new XoopsFormTag("tag", 35, 255, $itemid, $catid = 0));
		}
		
		$form -> addElement($image);
		$form -> addElement($ordre_form);
		$form -> addElement($qcm_form);
		$form -> addElement($affre_form);
		$form -> addElement($email_form);
		$form -> addElement($select_forms_group_perm);
		$form -> addElement($admin_form);
		$form -> addElement($expe_form);
		$form -> addElement($url_form);
		$form -> addElement($help_form);
		$form -> addElement($send_form);
		$form -> addElement($mail_form);
		$form -> addElement($cod_form);
		$form -> addElement($save_form);
		$form -> addElement($oo_form);
		$form -> addElement($submit);
		
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
class XquizForms_idHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, 'forms_id', 'XquizForms_id', "id_form", "title");
    }
    
    function getForm($querystring, $url) {
    	$object = $this->create();
    	return $object->getForm($querystring, $url);
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