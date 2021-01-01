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
 * @copyright         XOOPS Project (https://xoops.org)
 * @license           GNU GPL 2 (https://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package           xquiz
 * @author            Mojtaba Jamali(jamali.mojtaba@gmail.com)
 * @version           $Id: $
 */
function xoops_module_install_xquiz()
{
    $dir = XOOPS_ROOT_PATH . '/uploads/xquiz';

    if (!is_dir($dir)) {
        if (!mkdir($dir, 0777) && !is_dir($dir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
        }

        chmod($dir, 0777);
    }
    $currentemptyfile     = XOOPS_ROOT_PATH . '/uploads/index.html';
    $destinationemptyfile = XOOPS_ROOT_PATH . '/uploads/xquiz/index.html';
    copy($currentemptyfile, $destinationemptyfile);

    $dir = XOOPS_ROOT_PATH . '/uploads/xquiz/image';

    if (!is_dir($dir)) {
        if (!mkdir($dir, 0777) && !is_dir($dir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
        }

        chmod($dir, 0777);
    }

    $currentemptyfile     = XOOPS_ROOT_PATH . '/uploads/index.html';
    $destinationemptyfile = XOOPS_ROOT_PATH . '/uploads/xquiz/image/index.html';
    copy($currentemptyfile, $destinationemptyfile);

    $dir = XOOPS_ROOT_PATH . '/uploads/xquiz/category';

    if (!is_dir($dir)) {
        if (!mkdir($dir, 0777) && !is_dir($dir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
        }

        chmod($dir, 0777);
    }

    $currentemptyfile     = XOOPS_ROOT_PATH . '/uploads/index.html';
    $destinationemptyfile = XOOPS_ROOT_PATH . '/uploads/xquiz/category/index.html';
    copy($currentemptyfile, $destinationemptyfile);
    $currentblankimage     = XOOPS_ROOT_PATH . '/modules/xquiz/assets/images/blank.png';
    $destinationblankimage = XOOPS_ROOT_PATH . '/uploads/xquiz/category/blank.png';
    copy($currentblankimage, $destinationblankimage);
}
