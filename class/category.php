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
class xquiz_category extends \XoopsObject
{
    public function __construct()
    {
        parent::__construct();

        $this->initVar('category_id', XOBJ_DTYPE_INT);

        $this->initVar('category_title', XOBJ_DTYPE_TXTBOX);

        $this->initVar('category_created', XOBJ_DTYPE_INT);

        $this->db = $GLOBALS['xoopsDB'];

        $this->table = $this->db->prefix('xquiz_category');
    }

    public function getCategoryForm()
    {
        $form = new XoopsThemeForm(_AM_XQUIZ_CATEGORY_FORM, 'category', 'backend.php', 'post');

        $form->setExtra('enctype="multipart/form-data"');

        if ($this->isNew()) {
            $form->addElement(new XoopsFormHidden('op', 'addcategory'));
        } else {
            $form->addElement(new XoopsFormHidden('op', 'editcategory'));
        }

        $form->addElement(new XoopsFormHidden('category_id', $this->getVar('category_id', 'e')));

        $form->addElement(new XoopsFormText(_AM_XQUIZ_CATEGORY_TITLE, 'category_title', 50, 255, $this->getVar('category_title', 'e')), true);

        // Submit buttons

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
 * Class xquizCategoryHandler
 */
class xquizCategoryHandler extends \XoopsPersistableObjectHandler
{
    /**
     * xquizCategoryHandler constructor.
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'xquiz_category', 'xquiz_category', 'category_id', 'category_title');
    }

    /**
     * @param $info
     * @return array
     */
    public function categoryList($info)
    {
        $ret = [];

        $criteria = new CriteriaCompo();

        $criteria->setSort($info['category_sort']);

        $criteria->setOrder($info['category_order']);

        $criteria->setLimit($info['category_limit']);

        $criteria->setStart($info['category_start']);

        $obj = $this->getObjects($criteria, false);

        if ($obj) {
            foreach ($obj as $root) {
                $tab = [];

                $tab = $root->toArray();

                $ret[] = $tab;
            }
        }

        return $ret;
    }

    /**
     * @return int
     */
    public function categoryCount()
    {
        $criteria = new CriteriaCompo();

        return $this->getCount($criteria);
    }
}
