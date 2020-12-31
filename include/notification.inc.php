<?php

/**
 * ****************************************************************************
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
 * @copyright          XOOPS Project (https://xoops.org)
 * @license            http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package            xquiz
 * @author             Mojtaba Jamali(jamali.mojtaba@gmail.com)
 * @version            $Id$
 *
 * Version : $Id:
 * ****************************************************************************
 */

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

/**
 * @param $category
 * @param $item_id
 * @return null
 */
function quiz_notify_iteminfo($category, $item_id)
{
    if ('global' == $category) {
        $item['name'] = '';
        $item['url']  = '';
        return $item;
    }

    global $xoopsDB;

    if ('quiz' == $category) {
        // Assume we have a valid quiz id
        $sql    = 'SELECT name FROM ' . $xoopsDB->prefix('xquiz_quizzes') . ' WHERE id = ' . (int)$item_id;
        $result = $xoopsDB->query($sql);
        if ($result) {
            $result_array = $xoopsDB->fetchArray($result);
            $item['name'] = $result_array['name'];
            $item['url']  = XOOPS_URL . '/modules/xquiz/index.php?act=v&q=' . (int)$item_id;
            return $item;
        } else {
            return null;
        }
    }

    if ('category' == $category) {
        $sql    = 'SELECT name FROM ' . $xoopsDB->prefix('xquiz_quizzes') . ' WHERE cid = ' . (int)$item_id;
        $result = $xoopsDB->query($sql);
        if ($result) {
            $result_array = $xoopsDB->fetchArray($result);
            $item['name'] = $result_array['cid'];
            $item['url']  = XOOPS_URL . '/modules/xquiz/index.php?cid=' . (int)$item_id;
            return $item;
        } else {
            return null;
        }
    }
}
