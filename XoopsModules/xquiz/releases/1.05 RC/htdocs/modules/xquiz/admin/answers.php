<?php
	
	include("admin_header.php");
			
	xoops_cp_header();
	
	$op = isset($_REQUEST['op'])?$_REQUEST['op']:"list";
	$fct = isset($_REQUEST['fct'])?$_REQUEST['fct']:"forms_answers";
	$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
	$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
	$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'ASC';
	$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'title';
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
		
		forms_adminMenu(7);
		
		include_once $GLOBALS['xoops']->path( "/class/template.php" );
		$GLOBALS['xquizTpl'] = new XoopsTpl();

		$GLOBALS['xquizTpl']->assign('php_self', $_SERVER['PHP_SELF']);
		
		$object_handler =& xoops_getmodulehandler($fct, 'xquiz');
		$object = $object_handler->get($_GET['id']);
		if (is_object($object)) {
			$GLOBALS['xquizTpl']->assign('form', $object->getForm($_SERVER['QUERY_STRING']));
		}

		$GLOBALS['xquizTpl']->display('db:xquiz_cpanel_edit_forms_answers.html');
		break;		
	
	default:
	case 'lists':
		switch ($fct) {
			default:
			case 'forms_answers':
				xoops_loadLanguage('admin', 'xquiz');
				forms_adminMenu(7);
			
				$GLOBALS['xquizTpl'] = new XoopsTpl();
				
				$forms_answers_handler =& xoops_getmodulehandler('forms_answers', 'xquiz');
					
				$criteria = $forms_answers_handler->getFilterCriteria($filter);
				$ttl = $forms_answers_handler->getCount($criteria);
				
				$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
				$GLOBALS['xquizTpl']->assign('pagenav', $pagenav->renderNav());

				$GLOBALS['xquizTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xquizTpl']->assign('limit', $limit);
				$GLOBALS['xquizTpl']->assign('start', $start);
				$GLOBALS['xquizTpl']->assign('order', $order);
				$GLOBALS['xquizTpl']->assign('sort', $sort);
				$GLOBALS['xquizTpl']->assign('filter', $filter);
				
				foreach (array(	'id_score','id_form','minimum','maximum','html','title') as $id => $key) {
					$GLOBALS['xquizTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&fct='.$fct.'&filter='.$filter.'">'.(defined('_AM_XQUIZ_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_XQUIZ_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_XQUIZ_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					$GLOBALS['xquizTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $forms_answers_handler->getFilterForm($filter, $key, $sort, $fct));
				}
					
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				$criteria->setSort('`'.$sort.'`');
				$criteria->setOrder($order);
					
				$forms_answerss = $forms_answers_handler->getObjects($criteria, true);
				foreach($forms_answerss as $id => $forms_answers) {
					$GLOBALS['xquizTpl']->append('forms_answers', $forms_answers->toArray());
				}
							
				$GLOBALS['xquizTpl']->assign('form', $forms_answers_handler->getForm($_SERVER['QUERY_STRING'], true, true, '', 'base', array()));
						
				$GLOBALS['xquizTpl']->display('db:xquiz_cpanel_forms_answers_list.html');
				break;		
			
		}																				
		break;
		
	}
	
	xoops_cp_footer();
?>