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
$modversion['name'] = _MI_XQUIZ_NAME;
$modversion['version'] = 1.05;
$modversion['description'] = _MI_XQUIZ_DESC;
$modversion['author'] = "Wishcraft";
$modversion['credits'] = "<a href=mailto:simon@chronolabs.coop>wishcraft</a>";
$modversion['help'] = "";
$modversion['license'] = "<a href='../docs/license.txt' target='_blank'>GPL see LICENSE</a>";
$modversion['official'] = 0;
$modversion['image'] = "images/xquiz_slogo.png";
$modversion['dirname'] = "xquiz";

//$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

if (!is_dir(XOOPS_ROOT_PATH.DS."uploads".DS.$modversion['dirname']))
{
	$uploadpath=XOOPS_ROOT_PATH.DS."uploads".DS.$modversion['dirname'];
	@mkdir($uploadpath,0777);
}
if (!is_dir(XOOPS_ROOT_PATH.DS."uploads".DS.$modversion['dirname'].DS."imgform"))
{
	$uploadpath=XOOPS_ROOT_PATH.DS."uploads".DS.$modversion['dirname'].DS."imgform";
	@mkdir($uploadpath,0777);
}

// Tables created by sql file (without prefix!)
$i=0;
$modversion['tables'][$i++] = "forms";
$modversion['tables'][$i++] = "forms_answers";
$modversion['tables'][$i++] = "forms_form";
$modversion['tables'][$i++] = "forms_id";
$modversion['tables'][$i++] = "forms_menu";
$modversion['tables'][$i++] = "forms_oauth";
$modversion['tables'][$i++] = "forms_responses";
$modversion['tables'][$i++] = "forms_users";

//Installation Scripts
$modversion['onInstall'] = "include/install.php";

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

$modversion['support_site_url'] = "http://www.chronolabs.coop";
$modversion['support_site_name'] = "Chronolabs Co-op";
$modversion['developer_lead'] = "Wishcraft";
$modversion['credits_about'] = "Wishcraft";
$modversion['credits_site'] = "http://www.chronolabs.coop";
$modversion['status_version'] = "Final";
$modversion['status'] = "Final";
$modversion['warning'] = _MI_WARNING_FINAL;

// Menu -- content in main menu block
$modversion['hasMain'] = 1;

// Templates
$i=0;
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_index.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_answer.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_questionair.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_cpanel_default_consult.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_cpanel_default_elements.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_cpanel_default_export.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_cpanel_default_index.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_cpanel_default_modinfo.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_cpanel_edit_mailindex.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_cpanel_edit_modify_menu.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_cpanel_forms_consult.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_cpanel_index_modify_menu.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_cpanel_item_consult.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_cpanel_permission_elements.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_cpanel_permission_modform.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_cpanel_forms_answers_list.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_cpanel_edit_forms_users.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_cpanel_forms_users_list.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_cpanel_forms_responses_list.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_cpanel_edit_forms_responses.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'xquiz_cpanel_default_statistics.html';
$modversion['templates'][$i]['description'] = '';
//	Module Configs
$i=0;

$i++;
$modversion['config'][$i]['name'] = 't_width';
$modversion['config'][$i]['title'] = '_MI_XQUIZ_TEXT_WIDTH';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '30';

$i++;
$modversion['config'][$i]['name'] = 't_max';
$modversion['config'][$i]['title'] = '_MI_XQUIZ_TEXT_MAX';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '255';

$i++;
$modversion['config'][$i]['name'] = 'ta_rows';
$modversion['config'][$i]['title'] = '_MI_XQUIZ_TAREA_ROWS';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '5';

$i++;
$modversion['config'][$i]['name'] = 'ta_cols';
$modversion['config'][$i]['title'] = '_MI_XQUIZ_TAREA_COLS';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '35';

$i++;
$modversion['config'][$i]['name'] = 'file_weight';
$modversion['config'][$i]['title'] = '_MI_XQUIZ_FILE_WEIGHT';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '200';

$i++;
$modversion['config'][$i]['name'] = 'delimeter';
$modversion['config'][$i]['title'] = '_MI_XQUIZ_DELIMETER';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'space';
$modversion['config'][$i]['options'] = array(_MI_XQUIZ_DELIMETER_SPACE=>'space', _MI_XQUIZ_DELIMETER_BR=>'br');

$i++;
$modversion['config'][$i]['name'] = 'htaccess';
$modversion['config'][$i]['title'] = "_MI_XQUIZ_HTACCESS";
$modversion['config'][$i]['description'] = "_MI_XQUIZ_HTACCESS_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = false;

$i++;
$modversion['config'][$i]['name'] = 'baseurl';
$modversion['config'][$i]['title'] = "_MI_XQUIZ_BASEURL";
$modversion['config'][$i]['description'] = "_MI_XQUIZ_BASEURL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'questionair';

$i++;
$modversion['config'][$i]['name'] = 'endofurl';
$modversion['config'][$i]['title'] = "_MI_XQUIZ_ENDOFURL";
$modversion['config'][$i]['description'] = "_MI_XQUIZ_ENDOFURL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '.html';

xoops_load('XoopsEditorHandler');
$editor_handler = XoopsEditorHandler::getInstance();
foreach ($editor_handler->getList(false) as $id => $val)
	$options[$val] = $id;
$i++;	
$modversion['config'][$i]['name'] = 'editor';
$modversion['config'][$i]['title'] = "_MI_XQUIZ_EDITOR";
$modversion['config'][$i]['description'] = "_MI_XQUIZ_EDITOR_DESC";
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'tinymce';
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'tags';
$modversion['config'][$i]['title'] = "_MI_XQUIZ_SUPPORTTAGS";
$modversion['config'][$i]['description'] = "_MI_XQUIZ_SUPPORTTAGS_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'consumer_key';
$modversion['config'][$i]['title'] = "_MI_XQUIZ_CONSUMER_KEY";
$modversion['config'][$i]['description'] = "_MI_XQUIZ_CONSUMER_KEY_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'consumer_secret';
$modversion['config'][$i]['title'] = "_MI_XQUIZ_CONSUMER_SECRET";
$modversion['config'][$i]['description'] = "_MI_XQUIZ_CONSUMER_SECRET_DESC";
$modversion['config'][$i]['formtype'] = 'password';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'request_url';
$modversion['config'][$i]['title'] = "_MI_XQUIZ_REQUEST_URL";
$modversion['config'][$i]['description'] = "_MI_XQUIZ_REQUEST_URL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'https://api.twitter.com/oauth/request_token';

$i++;
$modversion['config'][$i]['name'] = 'authorise_url';
$modversion['config'][$i]['title'] = "_MI_XQUIZ_AUTHORISE_URL";
$modversion['config'][$i]['description'] = "_MI_XQUIZ_AUTHORISE_URL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'https://api.twitter.com/oauth/authorize';

$i++;
$modversion['config'][$i]['name'] = 'access_token_url';
$modversion['config'][$i]['title'] = "_MI_XQUIZ_ACCESS_TOKEN_URL";
$modversion['config'][$i]['description'] = "_MI_XQUIZ_ACCESS_TOKEN_URL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'https://api.twitter.com/oauth/access_token';

$i++;
$modversion['config'][$i]['name'] = 'authenticate_url';
$modversion['config'][$i]['title'] = "_MI_XQUIZ_AUTHENTICATE_URL";
$modversion['config'][$i]['description'] = "_MI_XQUIZ_AUTHENTICATE_URL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'https://api.twitter.com/oauth/authenticate';

$i++;
$modversion['config'][$i]['name'] = 'callback_url';
$modversion['config'][$i]['title'] = "_MI_XQUIZ_CALLBACK_URL";
$modversion['config'][$i]['description'] = "_MI_XQUIZ_CALLBACK_URL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = XOOPS_URL.'/modules/xquiz/callback/';

$i++;
$modversion['config'][$i]['name'] = 'access_token';
$modversion['config'][$i]['title'] = "_MI_XQUIZ_ACCESS_TOKEN";
$modversion['config'][$i]['description'] = "_MI_XQUIZ_ACCESS_TOKEN_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'access_token_secret';
$modversion['config'][$i]['title'] = "_MI_XQUIZ_ACCESS_TOKEN_SECRET";
$modversion['config'][$i]['description'] = "_MI_XQUIZ_ACCESS_TOKEN_SECRET_DESC";
$modversion['config'][$i]['formtype'] = 'password';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

//bloc
$i=0;
$i++;
$modversion['blocks'][$i]['file'] = "xquiz_menu.php";
$modversion['blocks'][$i]['name'] = "List the questionairs";
$modversion['blocks'][$i]['description'] = "Liste the questionairs";
$modversion['blocks'][$i]['show_func'] = "xquiz_menu_show";
$modversion['blocks'][$i]['template'] = "xquiz_menu.html";

$i++;
$modversion['blocks'][$i]['file'] = "xquiz_qcm_menu.php";
$modversion['blocks'][$i]['name'] = "List the QCM";
$modversion['blocks'][$i]['description'] = "List the QCM";
$modversion['blocks'][$i]['show_func'] = "xquiz_qcm_menu_show";
$modversion['blocks'][$i]['template'] = "xquiz_qcm_menu.html";

$i++;
$modversion['blocks'][$i]['file'] = "xquiz_block_tag.php";
$modversion['blocks'][$i]['name'] = "XQuiz Tag Cloud";
$modversion['blocks'][$i]['description'] = "Show tag cloud";
$modversion['blocks'][$i]['show_func'] = "xquiz_tag_block_cloud_show";
$modversion['blocks'][$i]['edit_func'] = "xquiz_tag_block_cloud_edit";
$modversion['blocks'][$i]['options'] = "100|0|150|80";
$modversion['blocks'][$i]['template'] = "xquiz_tag_block_cloud.html";

$i++;
$modversion['blocks'][$i]['file'] = "xquiz_block_tag.php";
$modversion['blocks'][$i]['name'] = "XQuiz Top Tags";
$modversion['blocks'][$i]['description'] = "Show top tags";
$modversion['blocks'][$i]['show_func'] = "xquiz_tag_block_top_show";
$modversion['blocks'][$i]['edit_func'] = "xquiz_tag_block_top_edit";
$modversion['blocks'][$i]['options'] = "50|30|c";
$modversion['blocks'][$i]['template'] = "xquiz_tag_block_top.html";

?>