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
include("admin_header.php");

if(!isset($_POST['id'])){
	$id = isset ($_GET['id']) ? $_GET['id'] : '0';
}else {
	$id = $_POST['id'];
}

if(!isset($_POST['status'])){
	$status = isset ($_GET['status']) ? $_GET['status'] : '0';
}else {
	$status = $_POST['status'];
}

if(!isset($_POST['url'])){
	$url = isset ($_GET['url']) ? $_GET['url'] : '0';
}else {
	$url = $_POST['url'];
}

if ($status==1) {$status=0;}
else {$status=1;}

$forms_menu = $forms_menu_handler->get($id);
if (is_object($forms_menu)) {
	$forms_menu->setVar('status', $status);
	$forms_menu_handler->insert($forms_menu, true);
}

header("Location: $url");
?>
