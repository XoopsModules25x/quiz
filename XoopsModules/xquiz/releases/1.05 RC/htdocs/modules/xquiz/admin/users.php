<?php
	
	include("admin_header.php");
			
	xoops_cp_header();
	
	$op = isset($_REQUEST['op'])?$_REQUEST['op']:"list";
	$fct = isset($_REQUEST['fct'])?$_REQUEST['fct']:"forms_users";
	$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
	$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
	$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
	$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
	$filter = !empty($_REQUEST['filter'])?''.$_REQUEST['filter'].'':'1,1';
		
	switch($op) {
	case 'savelist':
	case 'save':
		xoops_loadLanguage('admin', 'xquiz');
		foreach($_POST['id'] as $id => $handler) {		
			
			$object_handler =& xoops_getmodulehandler($handler, 'xquiz');
			
			if ($id!=0)
				$object = $object_handler->get($id);
			else 
				$object = $object_handler->create();
				
			if (is_object($object)) {

				$object->setVars($_POST[$id]);
				
				$obj_id = $object_handler->insert($object, true);
				$object = $object_handler->get($obj_id);
			}
		}
		$url = $_SERVER["PHP_SELF"].'?op=list&fct='.$fct.'&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter;
		redirect_header($url, 10, _AM_MSG_XQUIZ_ITEMWASSAVEDOKEY);
		exit(0);
		break;
	case 'export':

		$forms_users_handler =& xoops_getmodulehandler($fct, 'xquiz');
		$criteria = $forms_users_handler->getFilterCriteria($filter);
		$criteria->setSort('`'.$sort.'`');
		$criteria->setOrder($order);

		if ($forms_users_handler->getCount($criteria)>0) {
			$users = $forms_users_handler->getObjects($criteria);
			$req[0][0] = _AM_XQUIZ_EXPORT_ID_FORM;
			$req[0][1] = _AM_XQUIZ_EXPORT_ID_FORM_TITLE;
			$req[0][2] = _AM_XQUIZ_EXPORT_QUESTIONS;
			$req[0][3] = _AM_XQUIZ_EXPORT_TOTALANSWERS;
			$req[0][4] = _AM_XQUIZ_EXPORT_TOTALSCORE;
			$req[0][5] = _AM_XQUIZ_EXPORT_USER;
			$req[0][6] = _AM_XQUIZ_EXPORT_NAME;
			$req[0][7] = _AM_XQUIZ_EXPORT_EMAIL;
			$req[0][8] = _AM_XQUIZ_EXPORT_TWITTER;
			$req[0][9] = _AM_XQUIZ_EXPORT_FACEBOOK;
			$req[0][10] = _AM_XQUIZ_EXPORT_YEAR;
			$req[0][11] = _AM_XQUIZ_EXPORT_MONTH;
			$req[0][12] = _AM_XQUIZ_EXPORT_DAY;
			$req[0][13] = _AM_XQUIZ_EXPORT_HOURS;
			$req[0][14] = _AM_XQUIZ_EXPORT_MINUTES;
			$req[0][15] = _AM_XQUIZ_EXPORT_SECONDS;
			if ($users) {
				foreach ($users as $user_id => $user) {
						$forms_id = $forms_id_handler->get($user->getVar("id_form"));
						$req[$user_id][0] = $user->getVar("id_form");
			       		$req[$user_id][1] = $forms_id->getVar("title");
			       		$req[$user_id][2] = $user->getVar("questions");
			       		$req[$user_id][3] = $user->getVar("answers");
			       		$req[$user_id][4] = $user->getVar("score");
			       		if ($user->getVar("uid")==0) {
			       			$req[$user_id][5] = $GLOBALS['xoopsConfig']['anonymous'];
			       		} else {
			       			$user = $user_handler->get($user->getVar("uid"));
			       			$req[$user_id][5] = $user->getVar('name');
			       			if (empty($req[$user_id][5]))
			       			 	$req[$user_id][5] = $user->getVar('uname');
			       			else 
			       				$req[$user_id][5] .= ' ('.$user->getVar('uname').')';
			       		}
			       		$req[$user_id][6] = $user->getVar("name");
			       		$req[$user_id][7] = $user->getVar("email");
			       		$req[$user_id][8] = $user->getVar("twitter");
			       		$req[$user_id][9] = $user->getVar("facebook");
			       		$req[$user_id][10] = date('Y', $user->getVar("created"));
			       		$req[$user_id][11] = date('m', $user->getVar("created"));
			       		$req[$user_id][12] = date('d', $user->getVar("created"));
			       		$req[$user_id][13] = date('H', $user->getVar("created"));
			       		$req[$user_id][14] = date('i', $user->getVar("created"));
			       		$req[$user_id][15] = date('s', $user->getVar("created"));
		          	}
			}
			
			if (!is_dir(XOOPS_ROOT_PATH.DS."uploads".DS.$GLOBALS['xoopsModule']->getVar('dirname').DS)) {
				foreach(explode(DS, XOOPS_ROOT_PATH.DS."uploads".DS.$GLOBALS['xoopsModule']->getVar('dirname')) as $folder) {
					$path .= DS.$folder;
					mkdir($path, 0777);
				}
			}
			
			if ($fp = fopen (XOOPS_ROOT_PATH."/uploads/".$GLOBALS['xoopsModule']->getVar('dirname')."/users_".md5($filter).".csv", "w")) {
				foreach ($req as $ele_id => $v) {
					foreach($v as $i=>$value){
						if (!is_numeric($value))
							$msg .= '"'.$value.'"';
						else 
							$msg .= ''.$value.'';
						if ($i<sizeof($v))
							$msg.=',';
						else 
							$msg.="\n";
					}
				}
		
				fwrite ($fp, $msg);
				fclose ($fp);
				
			}
		
			header('Content-Disposition: attachment; filename="users_'.md5($filter).'.csv"');
			header("Content-Type: text/comma-separated-values");
			readfile(XOOPS_ROOT_PATH.'/uploads/'.$GLOBALS['xoopsModule']->getVar('dirname').'/users_'.md5($filter).'.csv');
		
			exit(0);
		}

		break;
	case 'delete':
		xoops_loadLanguage('admin', 'xquiz');		
		if (!isset($_POST['confirmed'])) {
			xoops_confirm(array('id'=>$_GET['id'], 'op'=>'delete', 'fct'=>$fct, 'start'=>$start, 'limit'=>$limit, 'order'=>$order, 'sort'=>$sort, 'filter'=>$filter, 'confirm'=>true), $_SERVER['PHP_SELF'], _AM_MSG_XQUIZ_DELETEITEM, _SUBMIT);
		} else {
			$object_handler =& xoops_getmodulehandler($fct, 'xquiz');
			$object = $object_handler->get($_POST['id']);
			if (is_object($object)) {
				$object_handler->delete($object);
			}
			$url = $_SERVER["PHP_SELF"].'?op=list&fct='.$fct.'&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter;
			redirect_header($url, 10, _AM_MSG_XQUIZ_ITEMWASDELETED);
			exit(0);
		}
		break;

	case 'edit':
		xoops_loadLanguage('admin', 'xquiz');
		
		forms_adminMenu(8);
		
		include_once $GLOBALS['xoops']->path( "/class/template.php" );
		$GLOBALS['xquizTpl'] = new XoopsTpl();

		$GLOBALS['xquizTpl']->assign('php_self', $_SERVER['PHP_SELF']);
		
		$object_handler =& xoops_getmodulehandler($fct, 'xquiz');
		$object = $object_handler->get($_GET['id']);
		if (is_object($object)) {
			$GLOBALS['xquizTpl']->assign('form', $object->getForm($_SERVER['QUERY_STRING']));
		}

		$GLOBALS['xquizTpl']->display('db:xquiz_cpanel_edit_forms_users.html');
		break;		
	
	default:
	case 'list':
		switch ($fct) {
			default:
			case 'forms_users':
				
				xoops_loadLanguage('admin', 'xquiz');
				forms_adminMenu(8);
			
				$GLOBALS['xquizTpl'] = new XoopsTpl();
				
				$forms_users_handler =& xoops_getmodulehandler('forms_users', 'xquiz');
					
				$criteria = $forms_users_handler->getFilterCriteria($filter);
				$ttl = $forms_users_handler->getCount($criteria);
				
				$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
				$GLOBALS['xquizTpl']->assign('pagenav', $pagenav->renderNav());

				$GLOBALS['xquizTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xquizTpl']->assign('limit', $limit);
				$GLOBALS['xquizTpl']->assign('start', $start);
				$GLOBALS['xquizTpl']->assign('order', $order);
				$GLOBALS['xquizTpl']->assign('sort', $sort);
				$GLOBALS['xquizTpl']->assign('filter', $filter);
				
				foreach (array(	'id_user','id_form','uid','name','email','twitter','facebook', 'score', 'questions', 'answers', 'created', 'updated') as $id => $key) {
					$GLOBALS['xquizTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&fct='.$fct.'&filter='.$filter.'">'.(defined('_AM_XQUIZ_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_XQUIZ_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_XQUIZ_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					$GLOBALS['xquizTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $forms_users_handler->getFilterForm($filter, $key, $sort, $fct));
				}
					
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				$criteria->setSort('`'.$sort.'`');
				$criteria->setOrder($order);
					
				$forms_userss = $forms_users_handler->getObjects($criteria, true);
				foreach($forms_userss as $id => $forms_users) {
					$GLOBALS['xquizTpl']->append('forms_users', $forms_users->toArray());
				}
							
				$GLOBALS['xquizTpl']->assign('form', $forms_users_handler->getForm($_SERVER['QUERY_STRING'], true, true, '', 'base', array()));
				
				$GLOBALS['xquizTpl']->display('db:xquiz_cpanel_forms_users_list.html');
				break;		
			
		}																				
		break;
		
	}
	
	xoops_cp_footer();
?>