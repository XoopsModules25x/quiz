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
 * @param $queryarray
 * @param $andor
 * @param $limit
 * @param $offset
 * @param $userid
 * @return array
 */
function quiz_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;
    $sql = 'SELECT id,name,description,bdate FROM ' . $xoopsDB->prefix('xquiz_quizzes') . '';
    if (is_array($queryarray) && $count = count($queryarray)) {
        $sql .= " WHERE bdate < NOW() AND((name LIKE '$queryarray[0]' OR description LIKE
               '$queryarray[0]')";
        for ($i = 1; $i < $count; ++$i) {
            $sql .= " $andor ";
            $sql .= "(name LIKE '$queryarray[$i]' OR description LIKE
                               '$queryarray[$i]')";
        }
        $sql .= ') ';
    }
    $sql   .= 'ORDER BY id DESC';
    $query = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('xquiz_quizzes') . ' WHERE id>0');
    [$numrows] = $xoopsDB->fetchRow($query);

    $result = $xoopsDB->query($sql, $limit, $offset);
    $ret    = [];
    $i      = 0;
    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $ret[$i]['image'] = 'assets/images/search.png';
        $ret[$i]['link']  = 'index.php?act=v&q=' . ($myrow['id']);
        $ret[$i]['title'] = $myrow['name'];
        $ret[$i]['time']  = $myrow['bdate'];
        $ret[$i]['uid']   = '';
        $i++;
    }
    return $ret;
}
