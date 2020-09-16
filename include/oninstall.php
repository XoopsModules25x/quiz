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
function xoops_module_install_xquiz()
{
    $dir = XOOPS_ROOT_PATH . '/uploads/xquiz';

    if (!is_dir($dir)) {
        mkdir($dir, 0777);

        chmod($dir, 0777);
    }

    $dir = XOOPS_ROOT_PATH . '/uploads/xquiz/image';



    if (!is_dir($dir)) {
        mkdir($dir, 0777);

        chmod($dir, 0777);
    }
	
	$dir = XOOPS_ROOT_PATH . '/uploads/xquiz/category';


    if (!is_dir($dir)) {
        mkdir($dir, 0777);

        chmod($dir, 0777);
    }
}
