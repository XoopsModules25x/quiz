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
if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}

require_once($GLOBALS['xoops']->path('/modules/xquiz/include/twitteroauth.php'));
require_once($GLOBALS['xoops']->path('/modules/xquiz/include/functions.php'));

class XquizForms_oauth extends XoopsObject
{

	var $_connection = null;
	var $_handler = null;
	
    function XquizForms_oauth($fid = null)
    {
        $this->initVar('oid', XOBJ_DTYPE_INT, null, false);     
		$this->initVar('mode', XOBJ_DTYPE_ENUM, 'valid', false, false, false, array('valid','invalid','expired','disabled','other'));
        $this->initVar('consumer_key', XOBJ_DTYPE_TXTBOX, CONSUMER_KEY, true, 255);
        $this->initVar('consumer_secret', XOBJ_DTYPE_TXTBOX, CONSUMER_SECRET, true, 255);   
        $this->initVar('oauth_token', XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('oauth_token_secret', XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('ip', XOBJ_DTYPE_TXTBOX, null, true, 64);
        $this->initVar('netbios', XOBJ_DTYPE_TXTBOX, null, true, 255);        
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);
		$this->initVar('actioned', XOBJ_DTYPE_INT, null, false);		
		$this->initVar('tweeted', XOBJ_DTYPE_INT, null, false);
		$this->initVar('mentions', XOBJ_DTYPE_INT, null, false);
		$this->initVar('friends', XOBJ_DTYPE_INT, null, false);
		$this->initVar('tweets', XOBJ_DTYPE_INT, null, false);
		$this->initVar('calls', XOBJ_DTYPE_INT, null, false);
		$this->initVar('remaining_hits', XOBJ_DTYPE_INT, null, false);
		$this->initVar('hourly_limit', XOBJ_DTYPE_INT, null, false);
		$this->initVar('api_resets', XOBJ_DTYPE_INT, null, false);
		$this->initVar('reset', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, null, false);		
	}

	function setHandler($handler)
	{
		$this->_handler = $handler;
	}
	
	function getConnection($for_tweet=false)
	{
		if (!is_a($this->_connection, 'TwitterOAuth'))
			$this->_connection = new TwitterOAuth($this->getVar('consumer_key'), $this->getVar('consumer_secret'), $this->getVar('oauth_token'), $this->getVar('oauth_token_secret'));
		@$this->validateCredentials($for_tweet);
		@$this->getRateLimits($for_tweet);
		return $this->_connection;
	}
	
	function createFollow($mixed, $type='user_id', $for_tweet=false) {
		if (!is_a($this->_connection, 'TwitterOAuth'))
			@$this->getConnection($for_tweet);

		if (is_a($this->_connection, 'TwitterOAuth')&&$this->getVar('calls')<$this->getVar('hourly_limit')) {
			$follow = xquiz_object2array($this->_connection->post('friendships/create', array( $type=>$mixed, 'follow' => 'true')));
			switch ($this->_connection->http_code) {
		  		case 200:
		    		$this->setVar('calls', $this->getVar('calls')+1);
		    		if (is_a($this->_handler, 'XquizForms_oauthHandler'))
		    			@$this->_handler->insert($this, true);
		  			return $follow; 
		    		break;
		  		default:
		    		return false;
		    		break;
			}
		} else 
			return false;
			
	}
	
	function sendTweet($tweet, $url, $for_tweet=false) {
		if (!is_a($this->_connection, 'TwitterOAuth'))
			@$this->getConnection($for_tweet);

		if (is_a($this->_connection, 'TwitterOAuth')&&$this->getVar('calls')<$this->getVar('hourly_limit')) {
			$tweet = xquiz_object2array($this->_connection->post('statuses/update', 	array(	'status'=>substr($tweet,0, (!empty($url)?126:140)).' '.$url,
																									'wrap_links' => 'true' 
																							)));
			switch ($this->_connection->http_code) {
		  		case 200:
		    		$this->setVar('tweeted', time());
		    		$this->setVar('tweets', $this->getVar('tweets')+1);
		    		$this->setVar('calls', $this->getVar('calls')+1);
		    		if (is_a($this->_handler, 'XquizForms_oauthHandler'))
		    			@$this->_handler->insert($this, true);
		  			return $tweet['id_str']; 
		    		break;
		  		default:
		    		return false;
		    		break;
			}
		} else 
			return false;	
	}
	
	function getRateLimits($for_tweet=false) {
		if (!is_a($this->_connection, 'TwitterOAuth'))
			@$this->getConnection($for_tweet);

		if (is_a($this->_connection, 'TwitterOAuth')) {
			$limits = xquiz_object2array($this->_connection->get('account/rate_limit_status', 	array()));
			switch ($this->_connection->http_code) {
		  		case 200:
		  			if ($this->getVar('api_resets') <> $limits['reset_time_in_seconds']) {
		  				$this->setVar('reset', time());
		  				$this->setVar('calls', 0);
		  			}
		    		$this->setVar('remaining_hits', $limits['remaining_hits']);
		    		$this->setVar('hourly_limit', $limits['hourly_limit']);
		    		$this->setVar('api_resets', $limits['reset_time_in_seconds']);
		    		if (is_a($this->_handler, 'XquizForms_oauthHandler'))
		    			@$this->_handler->insert($this, true);
		  			return $limits; 
		    		break;
		  		default:
		    		return false;
		    		break;
			}
		} else 
			return false;
	}

	function validateCredentials($for_tweet=false) {
		if (!is_a($this->_connection, 'TwitterOAuth'))
			@$this->getConnection($for_tweet);

		if (is_a($this->_connection, 'TwitterOAuth')&&$this->getVar('calls')<$this->getVar('hourly_limit')) {
			$user = xquiz_object2array($this->_connection->get('account/verify_credentials', 	array(	'include_entities' => 'true'	)));
			switch ($this->_connection->http_code) {
		  		case 200:
		    		$this->setVar('calls', $this->getVar('calls')+1);
		  			$this->setVar('mode', 'valid');
		  			$this->setVar('username', $user['screen_name']);
	    			if (is_a($this->_handler, 'XquizForms_oauthHandler'))
	    				@$this->_handler->insert($this, true);
	    			return $user;
		     		break;
		  		default:
		  			$this->setVar('mode', 'invalid');
	    			if (is_a($this->_handler, 'XquizForms_oauthHandler'))
	    				@$this->_handler->insert($this, true);
		  			return false;
		  			break;
			}
		} else 
			return false;
	}
	
	function getUser($mixed = '', $type='user_id', $for_tweet=false) {
		if (!is_a($this->_connection, 'TwitterOAuth'))
			@$this->getConnection($for_tweet);

		if (is_a($this->_connection, 'TwitterOAuth')&&$this->getVar('calls')<$this->getVar('hourly_limit')) {
			$user = xquiz_object2array($this->_connection->get('users/show', 	array(	$type=>$mixed, 'include_entities' => 'true'	)));
			switch ($this->_connection->http_code) {
		  		case 200:
		    		$this->setVar('calls', $this->getVar('calls')+1);
	    			if (is_a($this->_handler, 'XquizForms_oauthHandler'))
	    				@$this->_handler->insert($this, true);
	    			return $user;
		     		break;
		  		default:
		  			return false;
		  			break;
			}
		} else 
			return false;
	}
	
	function getUsers($mixed = '', $type='user_id', $for_tweet=false) {
		if (!is_a($this->_connection, 'TwitterOAuth'))
			@$this->getConnection($for_tweet);

		if (is_array($mixed)) {
			$c=1;
			foreach($mixed as $key => $value) {
				$i++;
				$ret[$c] .= $value.(sizeof($mixed)!=$key||$i<100?',':'');		
				if ($i=100) {
					$i=0;
					$c++;
				}
			}
		} else {
			$c=1;
			$mixed = explode(',',$mixed);
			foreach($mixed as $key => $value) {
				$i++;
				$ret[$c] .= $value.(sizeof($mixed)!=$key||$i<100?',':'');		
				if ($i=100) {
					$i=0;
					$c++;
				}
			}
		}		
		
		foreach($ret as $key => $mixed) {
			if (is_a($this->_connection, 'TwitterOAuth')&&$this->getVar('calls')<$this->getVar('hourly_limit')) {
				$users[$key] = xquiz_object2array($this->_connection->get('users/lookup', 	array(	$type=>$mixed	)));
				switch ($this->_connection->http_code) {
			  		case 200:
			    		$this->setVar('calls', $this->getVar('calls')+1);
		    			if (is_a($this->_handler, 'XquizForms_oauthHandler'))
		    				@$this->_handler->insert($this, true);
		    			foreach($users[$key] as $user) {
		    				$output[($type=='screen_name'?$user['screen_name']:$user['id'])] = $user; 
		    			}
			     		break;
				}
			} else 
				return $output;
		}
		return $output;
	}

	function getFriends($mixed, $type='user_id', $for_tweet=false) {
		if (!is_a($this->_connection, 'TwitterOAuth'))
			@$this->getConnection($for_tweet);

		$ids = array();
		if (is_a($this->_connection, 'TwitterOAuth')) {
			$cursor = -1;
			while($cursor>$friends['next_cursor']&&$this->getVar('calls')<$this->getVar('hourly_limit')) {
				$friends = xquiz_object2array($this->_connection->get('friends/ids', 	array($type=>$mixed, 'cursor'=>$cursor)));
				switch ($this->_connection->http_code) {
			  		case 200:
			  			$this->setVar('calls', $this->getVar('calls')+1);
		    			if (is_a($this->_handler, 'XquizForms_oauthHandler'))
		    				@$this->_handler->insert($this, true);
		    			if ($friends['next_cursor']>$cursor)
		    				$cursor = $friends['next_cursor']; 
			  			$ids = array_merge($ids, $friends['ids']); 
			    		break;
			  		default:
			  			$friends['next_cursor']=-1;
			    		$cursor=0;
			    		break;
				}
			}
		} else 
			return $ids;
		return $ids;
	}

	function getMentions($for_tweet=false) {
		if (!is_a($this->_connection, 'TwitterOAuth'))
			@$this->getConnection($for_tweet);

		$mentions = array();
		if (is_a($this->_connection, 'TwitterOAuth')) {
			$page = 1;
			while($page!=0&&$this->getVar('calls')<$this->getVar('hourly_limit')) {
				$mention = xquiz_object2array($this->_connection->get('statuses/mentions', 	array('count'=>200, 'include_entities '=>'true', 'contributor_details'=>'true')));
				if (empty($mention))	
					$page = 0;
				switch ($this->_connection->http_code) {
			  		case 200:
			  			$this->setVar('calls', $this->getVar('calls')+1);
		    			if (is_a($this->_handler, 'XquizForms_oauthHandler'))
		    				@$this->_handler->insert($this, true);
		    			if ($page!=0)
							$page++; 
			  			$mentions = array_merge($mentions, $mention); 
			    		break;
			  		default:
			    		$page=0;
			    		break;
				}
			}
		} else 
			return $mentions;
		return $mentions;
	}
	
	
	function getTrend($type='', $for_tweet=false)
	{
		if (!is_a($this->_connection, 'TwitterOAuth'))
			$this->getConnection($for_tweet);
			
		if (is_a($this->_connection, 'TwitterOAuth')&&$this->getVar('calls')<$this->getVar('hourly_limit')) {
			$trends = xquiz_object2array($this->_connection->get('trends'.(!empty($type)?'/'.$type:''), array()));
			switch ($this->_connection->http_code) {
		  		case 200:
		  			$this->setVar('calls', $this->getVar('calls')+1);
	    			if (is_a($this->_handler, 'XquizForms_oauthHandler'))
	    				@$this->_handler->insert($this, true);
		    		return $trends; 
		    		break;
		  		default:
		    		return array();
		    		break;
			}
		} else 
			return array();
	}

	function toArray() {
		$ret = parent::toArray();
		$ele = array();
		$ele['id'] = new XoopsFormsHidden('id['.$ret['oid'].']', $this->getVar('oid'));
		$ele['type'] = new XQuizFormsSelectOAuthMode('', $ret['oid'].'[mode]', $this->getVar('mode'));
		if ($ret['uid']>0) {
			$member_handler=xoops_gethandler('member');
			$user = $member_handler->getUser($ret['uid']);
			$ele['uid'] = new XoopsFormsLabel('', '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$ret['uid'].'">'.$user->getVar('uname').'</a>');
		} else {
			$ele['uid'] = new XoopsFormsLabel('', _MI_XQUIZ_ANONYMOUS);
		}
		if ($ret['created']>0) {
			$ele['created'] = new XoopsFormsLabel('', date(_DATESTRING, $ret['created']));
		} else {
			$ele['created'] = new XoopsFormsLabel('', '');
		}
		if ($ret['actioned']>0) {
			$ele['actioned'] = new XoopsFormsLabel('', date(_DATESTRING, $ret['actioned']));
		} else {
			$ele['actioned'] = new XoopsFormsLabel('', '');
		}
		if ($ret['updated']>0) {
			$ele['updated'] = new XoopsFormsLabel('', date(_DATESTRING, $ret['updated']));
		} else {
			$ele['updated'] = new XoopsFormsLabel('', '');
		}
		if ($ret['tweeted']>0) {
			$ele['tweeted'] = new XoopsFormsLabel('', date(_DATESTRING, $ret['tweeted']));
		} else {
			$ele['tweeted'] = new XoopsFormsLabel('', '');
		}
		foreach($ele as $key => $obj) {
			$ret['form'][$key] = $ele[$key]->render(); 
		}
		return $ret;
	}
	
	function runInsertPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/xquiz/plugins/'.$this->getVar('mode').'.php'));
		
		switch ($this->getVar('mode')) {
			case 'valid':
			case 'invalid':
			case 'expired':
			case 'disabled':
			case 'other':
				$func = ucfirst($this->getVar('mode')).'InsertHook';
				break;
			default:
				return false;
				break;
		}
		
		if (function_exists($func))  {
			return @$func($this);
		}
		return $this->getVar('oid');
	}
	
	function runGetPlugin($for_tweet=false) {
		
		include_once($GLOBALS['xoops']->path('/modules/xquiz/plugins/'.$this->getVar('mode').'.php'));
		
		switch ($this->getVar('mode')) {
			case 'valid':
			case 'invalid':
			case 'expired':
			case 'disabled':
			case 'other':
				$func = ucfirst($this->getVar('mode')).'GetHook';
				break;
			default:
				return false;
				break;
		}
		
		if (function_exists($func))  {
			return @$func($this, $for_tweet);
		}
		return $this;
	}
}


class XquizForms_oauthHandler extends XoopsPersistableObjectHandler
{
	var $_connection = NULL;
	var $_user = array();
	var $_root_oauth = NULL;
	
    function __construct(&$db) 
    {
        parent::__construct($db, "forms_oauth", 'XquizForms_oauth', "oid", "username");

        xoops_load('xoopscache');
		if (!class_exists('XoopsCache')) {
			// XOOPS 2.4 Compliance
			xoops_load('cache');
			if (!class_exists('XoopsCache')) {
				include_once XOOPS_ROOT_PATH.'/class/cache/xoopscache.php';
			}
		}
		
		$this->_user = xquiz_getuser_id();
    }
	
    function insert($obj, $force=true) {
    	
    	if ($obj->isNew()) {
    		$obj->setVar('created', time());
    		if (is_object($GLOBALS['xoopsUser']))
    			$obj->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
    	} else {
    		$obj->setVar('updated', time());
    	}
    	
    	$run_plugin = false;
    	if ($obj->vars['mode']['changed']==true) {	
			$obj->setVar('actioned', time());
			$run_plugin = true;
		}
     	
    	if ($run_plugin == true) {
    		$id = parent::insert($obj, $force);
    		$obj = parent::get($id);
    		if (is_object($obj)) {
	    		$ret = $obj->runInsertPlugin();
	    		return ($ret!=0)?$ret:$id;
    		} else {
    			return $id;
    		}
    	} else {
    		return parent::insert($obj, $force);
    	}
    }
   
    function get($id, $fields = '*', $for_tweet=false) {
    	$obj = parent::get($id, $fields);
    	if (is_object($obj)) {
    		$obj->setHandler($this);
    		return @$obj->runGetPlugin($for_tweet);
    	}
    }
    
    function getObjects($criteria, $id_as_key=false, $as_object=true, $for_tweet=false) {
	   	$objs = parent::getObjects($criteria, $id_as_key, $as_object);
    	foreach($objs as $id => $obj) {
    		if (is_object($obj)) {
    			$objs[$id]->setHandler($this);
    			$objs[$id] = @$obj->runGetPlugin($for_tweet);
    		}
    	}
    	return $objs;
    }
    
    function getRootOauth($for_tweet=false) {
    	if (!empty($GLOBALS['xoopsModuleConfig']['consumer_key'])&&!empty($GLOBALS['xoopsModuleConfig']['consumer_secret'])&&
    		!empty($GLOBALS['xoopsModuleConfig']['access_token'])&&!empty($GLOBALS['xoopsModuleConfig']['access_token_secret'])) {
	    	
    		$criteria = new CriteriaCompo(new Criteria('consumer_key', $GLOBALS['xoopsModuleConfig']['consumer_key']));
	    	$criteria->add(new Criteria('consumer_secret', $GLOBALS['xoopsModuleConfig']['consumer_secret']));
	    	$criteria->add(new Criteria('oauth_token', $GLOBALS['xoopsModuleConfig']['access_token']));
	    	$criteria->add(new Criteria('oauth_token_secret', $GLOBALS['xoopsModuleConfig']['access_token_secret']));
	    		    	
	    	if (parent::getCount($criteria)>0){
	    		$oauths = parent::getObjects($criteria, false);
	    		if (is_object($oauths[0])) {
	    			$oauths[0]->setHandler($this);
    				return @$oauths[0]->runGetPlugin($for_tweet);
	    		} 
	    	}

			$oauth = parent::create();
			$oauth->setVar('uid', $this->_user['uid']);
			$oauth->setVar('ip', $this->_user['ip']);
			$oauth->setVar('netbios', $this->_user['netbios']);
			$oauth->setVar('oauth_token', $GLOBALS['xoopsModuleConfig']['access_token']);
			$oauth->setVar('oauth_token_secret', $GLOBALS['xoopsModuleConfig']['access_token_secret']);
			$oauth->setVar('consumer_key', $GLOBALS['xoopsModuleConfig']['consumer_key']);
			$oauth->setVar('consumer_secret', $GLOBALS['xoopsModuleConfig']['consumer_secret']);
			$oauth->setVar('username', $GLOBALS['xoopsModuleConfig']['root_tweeter']);
			$oauth->setVar('mode', 'valid');
			return $this->get($this->insert($oauth, true));
    	}
    }
    
    function getFilterCriteria($filter) {
    	$parts = explode('|', $filter);
    	$criteria = new CriteriaCompo();
    	foreach($parts as $part) {
    		$var = explode(',', $part);
    		if (!empty($var[1])&&!is_numeric($var[0])) {
    			$object = $this->create();
    			if (		$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_TXTBOX || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_TXTAREA) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', '%'.$var[1].'%', (isset($var[2])?$var[2]:'LIKE')));
    			} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_INT || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_DECIMAL || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_FLOAT ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', $var[1], (isset($var[2])?$var[2]:'=')));			
				} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_ENUM ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', $var[1], (isset($var[2])?$var[2]:'=')));    				
				} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_ARRAY ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', '%"'.$var[1].'";%', (isset($var[2])?$var[2]:'LIKE')));    				
				}
    		} elseif (!empty($var[1])&&is_numeric($var[0])) {
    			$criteria->add(new Criteria($var[0], $var[1]));
    		}
    	}
    	return $criteria;
    }
       
    function getFilterForms($filter, $field, $sort='created') {
    	$ele = tweetbomb_getFilterElement($filter, $field, $sort);
    	if (is_object($ele))
    		return $ele->render();
    	else 
    		return '&nbsp;';
    }

    function getRootConnection($for_tweet=false)
	{
		if (!is_a($this->_root_oauth, 'XquizForms_oauth'))
			$this->_root_oauth = $this->getRootOauth($for_tweet);
		if (is_object($this->_root_oauth)) {
			return $this->_connection = $this->_root_oauth->getConnection($for_tweet);
		}
		return false;
	}

	function getTrend($type='', $for_tweet=false)
	{
		if (!is_a($this->_connection, 'TwitterOAuth'))
			$this->getRootConnection($for_tweet);
		return $this->_root_oauth->getTrend($type, $for_tweet);
	}
	
    function getTempAuthentication()
    {
	    $this->_connection = new TwitterOAuth($GLOBALS['xoopsModuleConfig']['consumer_key'], $GLOBALS['xoopsModuleConfig']['consumer_secret']);
	 
		/* Get temporary credentials. */
		$request_token = $this->_connection->getRequestToken($GLOBALS['xoopsModuleConfig']['callback_url']);
		
		/* Save temporary credentials to file cache. */
		XoopsCache::write('xquiz_tmp_cred_'.$this->_user['uid'].'_'.$this->_user['md5'], $request_token);
		 
		/* If last connection failed don't display authorization link. */
		switch ($this->_connection->http_code) {
		  case 200:
		    /* Build authorize URL and redirect user to Twitter. */
		    $url = $this->_connection->getAuthorizeURL($request_token['oauth_token']);
		    header('Location: ' . $url); 
		    break;
		  default:
		    /* Show notification if something went wrong. */
		  	xoops_loadLanguage('errors', 'xquiz');
		    require_once($GLOBALS['xoops']->path('/header.php'));
		    xoops_error(_ERR_XQUIZ_COULDNT_CONNECT, _ERR_XQUIZ_COULDNT_CONNECT_TITLE);
		    require_once($GLOBALS['xoops']->path('/footer.php'));
		    XoopsCache::delete('xquiz_tmp_cred_'.$this->_user['uid'].'_'.$this->_user['md5']);
		    exit(0);
		}
    }
    
    function getAuthentication($input) {
    	
    	if ($request_token=XoopsCache::read('xquiz_tmp_cred_'.$this->_user['uid'].'_'.$this->_user['md5']))
    	{
	    	/* If the oauth_token is old redirect to the connect page. */
			if (isset($input['oauth_token']) && $request_token['oauth_token'] !== $input['oauth_token']) {
				xoops_loadLanguage('errors', 'xquiz');
				redirect_header(XOOPS_URL.'/modules/xquiz/', 10, _ERR_XQUIZ_TOKEN_OLDTOKEN);
				exit(0);
			}
			
			/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
			$this->_connection = new TwitterOAuth($GLOBALS['xoopsModuleConfig']['consumer_key'], $GLOBALS['xoopsModuleConfig']['consumer_secret'], $request_token['oauth_token'], $request_token['oauth_token_secret']);
			
			/* Request access tokens from twitter */
			$access_token = $this->_connection->getAccessToken($input['oauth_verifier']);
			
			/* Remove no longer needed request tokens */
			XoopsCache::delete('xquiz_tmp_cred_'.$this->_user['uid'].'_'.$this->_user['md5']);
			
			/* If HTTP response is 200 continue otherwise send to connect page to retry */
			if (200 == $this->_connection->http_code) {
				$oauth = parent::create();
				$oauth->setVar('uid', $this->_user['uid']);
				$oauth->setVar('ip', $this->_user['ip']);
				$oauth->setVar('netbios', $this->_user['netbios']);
				$oauth->setVar('oauth_token', $access_token->key);
				$oauth->setVar('oauth_token_secret', $access_token->secret);
				$oauth->setVar('consumer_key', $GLOBALS['xoopsModuleConfig']['consumer_key']);
				$oauth->setVar('consumer_secret', $GLOBALS['xoopsModuleConfig']['consumer_secret']);
				$oauth->setVar('mode', 'valid');
			  	/* The user has been verified and the access tokens can be saved for future use */
				$oid = $this->insert($oauth, true);
				redirect_header(XOOPS_URL.'/modules/xquiz/?oid='.$oid, 10, _ERR_XQUIZ_CHOOSEYOUR_TRAIL);
			} else {
			  	/* Show notification if something went wrong. */
			  	xoops_loadLanguage('errors', 'xquiz');
			    require_once($GLOBALS['xoops']->path('/header.php'));
			    xoops_error(_ERR_XQUIZ_COULDNT_CONNECT, _ERR_XQUIZ_COULDNT_CONNECT_TITLE);
			    require_once($GLOBALS['xoops']->path('/footer.php'));
			}
    	} else {
		  	xoops_loadLanguage('errors', 'xquiz');
		    require_once($GLOBALS['xoops']->path('/header.php'));
		    xoops_error(_ERR_XQUIZ_CACHE_EMPTY, _ERR_XQUIZ_CACHE_EMPTY_TITLE);
		    require_once($GLOBALS['xoops']->path('/footer.php'));
    	}
    	exit(0);
    }
}
?>