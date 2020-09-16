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
class xquiz_quiz extends \XoopsObject
{
    public function __construct()
    {
        parent::__construct();

        $this->initVar('quiz_id', XOBJ_DTYPE_INT);

        $this->initVar('quiz_title', XOBJ_DTYPE_TXTBOX);

        $this->initVar('quiz_description', XOBJ_DTYPE_TXTAREA, '');

        $this->initVar('quiz_category', XOBJ_DTYPE_INT);

        $this->initVar('quiz_status', XOBJ_DTYPE_INT, '1');

        $this->initVar('quiz_create', XOBJ_DTYPE_INT);

        $this->initVar('quiz_uid', XOBJ_DTYPE_INT);

        $this->initVar('quiz_order', XOBJ_DTYPE_INT);

        $this->initVar('quiz_img', XOBJ_DTYPE_TXTBOX);

        $this->initVar('quiz_type', XOBJ_DTYPE_TXTBOX);

        $this->initVar('quiz_startdate', XOBJ_DTYPE_TIMESTAMP);

        $this->initVar('quiz_enddate', XOBJ_DTYPE_TIMESTAMP);

        $this->initVar('dohtml', XOBJ_DTYPE_INT, 1);

        $this->initVar('dobr', XOBJ_DTYPE_INT, 1);

        $this->db = $GLOBALS['xoopsDB'];

        $this->table = $this->db->prefix('xquiz_quiz');
    }

    public function getQuizForm()
    {
        $form = new XoopsThemeForm(_AM_XQUIZ_QUIZ_FORM, 'quiz', 'backend.php', 'post');

        $form->setExtra('enctype="multipart/form-data"');

        if ($this->isNew()) {
            $form->addElement(new XoopsFormHidden('op', 'addquiz'));

            $form->addElement(new XoopsFormHidden('quiz_uid', $GLOBALS['xoopsUser']->getVar('uid')));
        } else {
            $form->addElement(new XoopsFormHidden('op', 'editquiz'));
        }

        $form->addElement(new XoopsFormHidden('quiz_id', $this->getVar('quiz_id', 'e')));

        $form->addElement(new XoopsFormHidden('quiz_type', 'xquiz'));

        // Category

        $category_handler = xoops_getModuleHandler('category', 'xquiz');

        $criteria = new CriteriaCompo();

        $categories = $category_handler->getObjects($criteria);

        $category_sel = new XoopsFormSelect(_AM_XQUIZ_QUIZ_CATEGORY, 'quiz_category', $this->getVar('quiz_category'));

        $i = 1;

        foreach (array_keys($categories) as $i) {
            $category_sel->addOption($categories[$i]->getVar('category_id'), $categories[$i]->getVar('category_title'));
        }

        $form->addElement($category_sel);

        $form->addElement(new XoopsFormText(_AM_XQUIZ_QUIZ_TITLE, 'quiz_title', 50, 255, $this->getVar('quiz_title', 'e')), true);

		   // Image

        $quiz_img = $this->getVar('quiz_img') ?: 'blank.gif';

        $imgdir = '/uploads/xquiz/image/';

        $fileseltray_quiz_img = new XoopsFormElementTray(_AM_XQUIZ_QUIZ_IMG, '<br />');

        $fileseltray_quiz_img->addElement(new XoopsFormLabel('', "<img style='max-width: 500px; max-height: 500px;' src='" . XOOPS_URL . $imgdir . $quiz_img . "' name='image_quiz' id='image_quiz' alt='' />"));

        if ($this->isNew()) {
            $fileseltray_quiz_img->addElement(new XoopsFormFile(_AM_XQUIZ_QUIZ_FORMUPLOAD, 'quiz_img', xoops_getModuleOption('img_size', 'xquiz')), true);
        }

        $form->addElement($fileseltray_quiz_img);

        $form->addElement(new XoopsFormTextArea(_AM_XQUIZ_QUIZ_DESCRIPTION, 'quiz_description', $this->getVar('quiz_description', 'e'), 5, 80));

        $form->addElement(new XoopsFormRadioYN(_AM_XQUIZ_QUIZ_STATUS, 'quiz_status', $this->getVar('quiz_status', 'e')), true);

		$form->addElement(new XoopsFormText(_AM_XQUIZ_QUIZ_ORDER, 'quiz_order', 3, 3, $this->getVar('quiz_order', 'e')));

        $form->addElement(new XoopsFormDateTime(_AM_XQUIZ_QUIZ_STARTDATE, 'quiz_startdate', '', strtotime($this->getVar('quiz_startdate'))), true);

        $form->addElement(new XoopsFormDateTime(_AM_XQUIZ_QUIZ_ENDDATE, 'quiz_enddate', '', strtotime($this->getVar('quiz_enddate'))), true);

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
 * Class xquizQuizHandler
 */
class xquizQuizHandler extends \XoopsPersistableObjectHandler
{
    /**
     * xquizQuizHandler constructor.
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'xquiz_quiz', 'xquiz_quiz', 'quiz_id', 'quiz_title');
    }

    /**
     * @return int
     */
    public function setquizorder()
    {
        $criteria = new CriteriaCompo();

        $criteria->setSort('quiz_order');

        $criteria->setOrder('DESC');

        $criteria->setLimit(1);

        $last = $this->getObjects($criteria);

        $order = 1;

        foreach ($last as $quiz) {
            $order = $quiz->getVar('quiz_order') + 1;
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

        if ($uploader_img->fetchMedia('quiz_img')) {
            $uploader_img->setPrefix('xquiz_');

            $uploader_img->fetchMedia('quiz_img');

            if (!$uploader_img->upload()) {
                redirect_header('quiz.php?op=new_quiz', 1, $uploader_img->getErrors());

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
    public function quizSAdminList($info)
    {
        $ret = [];

        $criteria = new CriteriaCompo();

        if ($info['category']) {
            $criteria->add(new Criteria('quiz_category', $info['category']));
        }

        $criteria->add(new Criteria('quiz_type', $info['type']));

        $criteria->setSort($info['quiz_sort']);

        $criteria->setOrder($info['quiz_order']);

        $criteria->setLimit($info['quiz_limit']);

        $criteria->setStart($info['quiz_start']);

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

                $tab['imgurl'] = XOOPS_URL . '/uploads/xquiz/image/' . $root->getVar('quiz_img');

                $tab['categorytitle'] = $list[$root->getVar('quiz_category')]['category_title'];

                $ret[] = $tab;
            }
        }

        return $ret;
    }

    /**
     * @param null $info
     * @return int
     */
    public function quizCount($info = null)
    {
        $criteria = new CriteriaCompo();

        //$criteria->add ( new Criteria ( 'quiz_type', $info ['type'] ) );

        return $this->getCount($criteria);
    }

    /**
     * @param $info
     * @return array
     */
    public function quizBlockList($info)
    {
        $ret = [];

        $criteria = new CriteriaCompo();

        $criteria->add(new Criteria('quiz_category', $info['category']));

        //$criteria->add ( new Criteria ( 'quiz_type', $info ['type'] ) );

        $criteria->add(new Criteria('quiz_status', '1'));

        $criteria->setSort('quiz_order');

        $criteria->setOrder('ASC');

        $obj = $this->getObjects($criteria, false);

        if ($obj) {
            foreach ($obj as $root) {
                $tab = [];

                $tab = $root->toArray();

                $tab['imgurl'] = XOOPS_URL . '/uploads/xquiz/image/' . $root->getVar('quiz_img');

                $ret[] = $tab;
            }
        }

        return $ret;
    }
}
