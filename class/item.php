<?php
/**
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
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         xquiz
 * @author 			Mojtaba Jamali(jamali.mojtaba@gmail.com)
 * @version         $Id: $
 */
class xquiz_item extends \XoopsObject
{
    public function __construct()
    {
        parent::__construct();

        $this->initVar('item_id', XOBJ_DTYPE_INT);

        $this->initVar('item_title', XOBJ_DTYPE_TXTBOX);

        $this->initVar('item_caption', XOBJ_DTYPE_TXTAREA, '');

        $this->initVar('item_category', XOBJ_DTYPE_INT);

        $this->initVar('item_link', XOBJ_DTYPE_TXTBOX);

        $this->initVar('item_linktarget', XOBJ_DTYPE_INT);

        $this->initVar('item_status', XOBJ_DTYPE_INT, '1');

        $this->initVar('item_create', XOBJ_DTYPE_INT);

        $this->initVar('item_uid', XOBJ_DTYPE_INT);

        $this->initVar('item_order', XOBJ_DTYPE_INT);

        $this->initVar('item_img', XOBJ_DTYPE_TXTBOX);

        $this->initVar('item_type', XOBJ_DTYPE_TXTBOX);

        $this->initVar('item_languagecode', XOBJ_DTYPE_TXTBOX);

        $this->initVar('item_startdate', XOBJ_DTYPE_TIMESTAMP);

        $this->initVar('item_enddate', XOBJ_DTYPE_TIMESTAMP);

        $this->initVar('dohtml', XOBJ_DTYPE_INT, 1);

        $this->initVar('dobr', XOBJ_DTYPE_INT, 1);

        $this->db = $GLOBALS['xoopsDB'];

        $this->table = $this->db->prefix('xquiz_item');
    }

    public function getQuizForm()
    {
        $form = new XoopsThemeForm(_AM_XQUIZ_ITEM_FORM, 'item', 'backend.php', 'post');

        $form->setExtra('enctype="multipart/form-data"');

        if ($this->isNew()) {
            $form->addElement(new XoopsFormHidden('op', 'additem'));

            $form->addElement(new XoopsFormHidden('item_uid', $GLOBALS['xoopsUser']->getVar('uid')));
        } else {
            $form->addElement(new XoopsFormHidden('op', 'edititem'));
        }

        $form->addElement(new XoopsFormHidden('item_id', $this->getVar('item_id', 'e')));

        $form->addElement(new XoopsFormHidden('item_type', 'xquiz'));

        // Category

        $category_handler = xoops_getModuleHandler('category', 'xquiz');

        $criteria = new CriteriaCompo();

        $categories = $category_handler->getObjects($criteria);

        $category_sel = new XoopsFormSelect(_AM_XQUIZ_ITEM_CATEGORY, 'item_category', $this->getVar('item_category'));

        $i = 1;

        foreach (array_keys($categories) as $i) {
            $category_sel->addOption($categories[$i]->getVar('category_id'), $categories[$i]->getVar('category_title'));
        }

        $form->addElement($category_sel);

        $form->addElement(new XoopsFormText(_AM_XQUIZ_ITEM_TITLE, 'item_title', 50, 255, $this->getVar('item_title', 'e')), true);

        // Image

        $item_img = $this->getVar('item_img') ?: 'blank.gif';

        $imgdir = '/uploads/xquiz/image/';

        $fileseltray_item_img = new XoopsFormElementTray(_AM_XQUIZ_ITEM_IMG, '<br />');

        $fileseltray_item_img->addElement(new XoopsFormLabel('', "<img style='max-width: 500px; max-height: 500px;' src='" . XOOPS_URL . $imgdir . $item_img . "' name='image_item' id='image_item' alt='' />"));

        if ($this->isNew()) {
            $fileseltray_item_img->addElement(new XoopsFormFile(_AM_XQUIZ_ITEM_FORMUPLOAD, 'item_img', xoops_getModuleOption('img_size', 'xquiz')), true);
        }

        $form->addElement($fileseltray_item_img);

        $form->addElement(new XoopsFormTextArea(_AM_XQUIZ_ITEM_CAPTION, 'item_caption', $this->getVar('item_caption', 'e'), 5, 80));

        $form->addElement(new XoopsFormText(_AM_XQUIZ_ITEM_LINK, 'item_link', 50, 255, $this->getVar('item_link', 'e')));

        $link_select = new XoopsFormSelect(_AM_XQUIZ_TARGET, 'item_linktarget', $this->getVar('item_linktarget', 'e'));

        $link_select->addOptionArray([0 => _AM_XQUIZ_TARGET_0, 1 => _AM_XQUIZ_TARGET_1]);

        $form->addElement($link_select);

        $form->addElement(new XoopsFormRadioYN(_AM_XQUIZ_ITEM_STATUS, 'item_status', $this->getVar('item_status', 'e')), true);

		$form->addElement(new XoopsFormText(_AM_XQUIZ_ITEM_ORDER, 'item_order', 3, 3, $this->getVar('item_order', 'e')));

        //if (xoops_isActiveModule('xlanguage')) {

        $form->addElement(new XoopsFormText(_AM_XQUIZ_ITEM_LANGUAGECODE, 'item_languagecode', 2, 2, $this->getVar('item_languagecode', 'e')));

        //}

        $form->addElement(new XoopsFormDateTime(_AM_XQUIZ_ITEM_STARTDATE, 'item_startdate', '', strtotime($this->getVar('item_startdate'))), true);

        $form->addElement(new XoopsFormDateTime(_AM_XQUIZ_ITEM_ENDDATE, 'item_enddate', '', strtotime($this->getVar('item_enddate'))), true);

        // Button

        $button_tray = new XoopsFormElementTray('', '');

        $submit_btn = new XoopsFormButton('', 'post', _SUBMIT, 'submit');

        $button_tray->addElement($submit_btn);

        $cancel_btn = new XoopsFormButton('', 'cancel', _CANCEL, 'cancel');

        $cancel_btn->setExtra('onclick="javascript:history.go(-1);"');

        $button_tray->addElement($cancel_btn);

        $form->addElement($button_tray);

        $form->display();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $ret = [];

        $vars = $this->getVars();

        foreach (array_keys($vars) as $i) {
            $ret[$i] = $this->getVar($i);
        }

        return $ret;
    }
}

/**
 * Class xquizItemHandler
 */
class xquizItemHandler extends \XoopsPersistableObjectHandler
{
    /**
     * xquizItemHandler constructor.
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'xquiz_item', 'xquiz_item', 'item_id', 'item_title');
    }

    /**
     * @return int
     */
    public function setitemorder()
    {
        $criteria = new CriteriaCompo();

        $criteria->setSort('item_order');

        $criteria->setOrder('DESC');

        $criteria->setLimit(1);

        $last = $this->getObjects($criteria);

        $order = 1;

        foreach ($last as $item) {
            $order = $item->getVar('item_order') + 1;
        }

        return $order;
    }

    /**
     * @param $image
     * @return string
     */
    public function uploadimg($image)
    {
        include_once XOOPS_ROOT_PATH . '/class/uploader.php';

        $uploader_img = new XoopsMediaUploader(
            XOOPS_ROOT_PATH . '/uploads/xquiz/image/',
            xoops_getModuleOption('img_mime', 'xquiz'),
            xoops_getModuleOption('img_size', 'xquiz'),
            xoops_getModuleOption('img_maxwidth', 'xquiz'),
            xoops_getModuleOption('img_maxheight', 'xquiz')
        );

        if ($uploader_img->fetchMedia('item_img')) {
            $uploader_img->setPrefix('xquiz_');

            $uploader_img->fetchMedia('item_img');

            if (!$uploader_img->upload()) {
                redirect_header('quiz.php?op=new_item', 1, $uploader_img->getErrors());

                xoops_cp_footer();

                exit();
            }

            return $uploader_img->getSavedFileName();
        }

        if (isset($image)) {
            return $image;
        }

        return '';
    }

    /**
     * @param $info
     * @return array
     */
    public function itemSAdminList($info)
    {
        $ret = [];

        $criteria = new CriteriaCompo();

        if ($info['category']) {
            $criteria->add(new Criteria('item_category', $info['category']));
        }

        $criteria->add(new Criteria('item_type', $info['type']));

        $criteria->setSort($info['item_sort']);

        $criteria->setOrder($info['item_order']);

        $criteria->setLimit($info['item_limit']);

        $criteria->setStart($info['item_start']);

        $obj = $this->getObjects($criteria, false);

        if ($obj) {
            foreach ($obj as $root) {
                $tab = [];

                $tab = $root->toArray();

                if (is_array($info['allcategories'])) {
                    foreach (array_keys($info['allcategories']) as $i) {
                        $list[$i]['category_title'] = $info['allcategories'][$i]->getVar('category_title');

                        $list[$i]['category_id'] = $info['allcategories'][$i]->getVar('category_id');
                    }
                }

                $tab['imgurl'] = XOOPS_URL . '/uploads/xquiz/image/' . $root->getVar('item_img');

                $tab['categorytitle'] = $list[$root->getVar('item_category')]['category_title'];

                $ret[] = $tab;
            }
        }

        return $ret;
    }

    /**
     * @param null $info
     * @return int
     */
    public function itemCount($info = null)
    {
        $criteria = new CriteriaCompo();

        //$criteria->add ( new Criteria ( 'item_type', $info ['type'] ) );

        return $this->getCount($criteria);
    }

    /**
     * @param $info
     * @return array
     */
    public function itemBlockList($info)
    {
        $ret = [];

        $criteria = new CriteriaCompo();

        $criteria->add(new Criteria('item_category', $info['category']));

        //$criteria->add ( new Criteria ( 'item_type', $info ['type'] ) );

        $criteria->add(new Criteria('item_status', '1'));

        $criteria->setSort('item_order');

        $criteria->setOrder('ASC');

        $obj = $this->getObjects($criteria, false);

        if ($obj) {
            foreach ($obj as $root) {
                $tab = [];

                $tab = $root->toArray();

                $tab['imgurl'] = XOOPS_URL . '/uploads/xquiz/image/' . $root->getVar('item_img');

                $ret[] = $tab;
            }
        }

        return $ret;
    }
}
