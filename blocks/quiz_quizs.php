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
use XoopsModules\Xquiz\{
    Files,
    Helper,
    Quiz,
    Question
};

/**
 * @param $options
 * @return array
 */
function quiz_listQuizs($options)
{
    $block = [];
    $block = Quiz::quiz_listQuizLoader(0, $options[0]);
    return $block;
}

/**
 * @param $options
 * @return string
 */
function quiz_listQuizs_edit($options)
{
    $form = _MB_XQUIZ_OPTION . ": <input type='text' size='9' name='options[0]' value='$options[0]'>";
    $form .= '';
    return $form;
}
