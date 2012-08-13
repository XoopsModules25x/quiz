<?php
// Module Info

// The name of this module
define("_MI_XQUIZ_NAME","XQuiz");

// A brief description of this module
define("_MI_XQUIZ_DESC","For sending forms");

define("_MI_XQUIZ_NONE", 'None');

// admin/menu.php
define("_MI_XQUIZ_ADMENU0","Index");
define("_MI_XQUIZ_ADMENU1","Create");
define("_MI_XQUIZ_ADMENU2","Export");
define("_MI_XQUIZ_ADMENU3","Form Permissions");
define("_MI_XQUIZ_ADMENU4","Modify");
define("_MI_XQUIZ_ADMENU5","Blocks and groups");
define("_MI_XQUIZ_ADMENU6","Menu");
define("_MI_XQUIZ_ADMENU7","Consult");
define("_MI_XQUIZ_ADMENU8","Answers");
define("_MI_XQUIZ_ADMENU9","Responses");
define("_MI_XQUIZ_ADMENU10","Graphs");
define("_MI_XQUIZ_ADMENU11","Users");
define("_MI_XQUIZ_ADMENU12","Element Permissions");
define("_MI_XQUIZ_ADMENU13","Dashboard");
define("_MI_XQUIZ_ADMENU14",'About App');

//	preferences
define("_MI_XQUIZ_TEXT_WIDTH","Default width of text boxes");
define("_MI_XQUIZ_TEXT_MAX","Default maximum length of text boxes");
define("_MI_XQUIZ_TAREA_ROWS","Default rows of text areas");
define("_MI_XQUIZ_TAREA_COLS","Default columns of text areas");
define("_MI_XQUIZ_FILE_WEIGHT","Default weight of join files (in Ko)");
define("_MI_XQUIZ_DELIMETER","Delimeter for check boxes and radio buttons");
define("_MI_XQUIZ_DELIMETER_SPACE","White space");
define("_MI_XQUIZ_DELIMETER_BR","Line break");
define("_MI_XQUIZ_SEND_METHOD","Send method");
define("_MI_XQUIZ_SEND_METHOD_DESC","Note: Form submitted by anonymous users cannot be sent by using private message.");
define("_MI_XQUIZ_SEND_METHOD_MAIL","Email");
define("_MI_XQUIZ_SEND_METHOD_PM","Private message");
define("_MI_XQUIZ_SEND_GROUP","Send to group");
define("_MI_XQUIZ_SEND_ADMIN","Send to site admin only");
define("_MI_XQUIZ_SEND_ADMIN_DESC","Settings of \"Send to group\" will be ignored");
define('_MI_XQUIZ_HTACCESS','Mod-Rewrite SEO with .htaccess');
define('_MI_XQUIZ_HTACCESS_DESC','See /docs for .htaccess to add to your XOOPS ROOT PATH');
define('_MI_XQUIZ_BASEURL','Mod-rewrite SEO Base URL');
define('_MI_XQUIZ_BASEURL_DESC','Do not change this unless you have altered you .htaccess for it.');
define('_MI_XQUIZ_ENDOFURL','Mod-rewrite SEO end of URL');
define('_MI_XQUIZ_ENDOFURL_DESC','End of URL for standard HTML Files with SEO .htaccess enabled.');
define('_MI_XQUIZ_EDITOR','Editor to Use');
define('_MI_XQUIZ_EDITOR_DESC','This is the editor that will be used');
define('_MI_XQUIZ_SUPPORTTAGS','Support Tagging');
define('_MI_XQUIZ_SUPPORTTAGS_DESC','Support Tag (2.3 or later)<br/><a href="http://sourceforge.net/projects/xoops/files/XOOPS%20Module%20Repository/XOOPS%20tag%202.30%20RC/">Download Tag Module</a>');
define('_MI_XQUIZ_CONSUMER_KEY','Twitter Application Consumer Key');
define('_MI_XQUIZ_CONSUMER_KEY_DESC','To get a <em>consumer key</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
define('_MI_XQUIZ_CONSUMER_SECRET','Twitter Application Consumer Secret');
define('_MI_XQUIZ_CONSUMER_SECRET_DESC','To get a <em>consumer secret</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
define('_MI_XQUIZ_REQUEST_URL','Twitter Application Request URL');
define('_MI_XQUIZ_REQUEST_URL_DESC','To get a <em>request url</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
define('_MI_XQUIZ_AUTHORISE_URL','Twitter Application Authorise URL');
define('_MI_XQUIZ_AUTHORISE_URL_DESC','To get a <em>authorise url</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
define('_MI_XQUIZ_AUTHENTICATE_URL','Twitter Authentication URL');
define('_MI_XQUIZ_AUTHENTICATE_URL_DESC','To get a <em>authentication url</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
define('_MI_XQUIZ_ACCESS_TOKEN_URL','Twitter Application Access Token URL');
define('_MI_XQUIZ_ACCESS_TOKEN_URL_DESC','To get a <em>access token url</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
define('_MI_XQUIZ_CALLBACK_URL','Twitter Application Callback URL');
define('_MI_XQUIZ_CALLBACK_URL_DESC','Do not change this unless you are certain you know the setting, this is also the setting for the twitter application call back URL.');
define('_MI_XQUIZ_ACCESS_TOKEN','Twitter Application Root Access Token');
define('_MI_XQUIZ_ACCESS_TOKEN_DESC','To get a <em>access token</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
define('_MI_XQUIZ_ACCESS_TOKEN_SECRET','Twitter Application Root Access Token Secret');
define('_MI_XQUIZ_ACCESS_TOKEN_SECRET_DESC','To get a <em>access token secret</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');

// The name of this module
define("_MI_XQUIZMENU_NAME","MyMenu");

// A brief description of this module
define("_MI_XQUIZMENU_DESC","Displays an individually configurable menu in a block");

// Names of blocks for this module (Not all module has blocks)
define("_MI_XQUIZMENU_BNAME","Form");

// Version
define("_MI_VERSION","1.05");

// Beta
define('_MI_WARNING_BETA',"This module comes as is, without any guarantees whatsoever. 
This module is BETA, meaning it is still under active development. This release is meant for
<b>testing purposes only</b> and we <b>strongly</b> recommend that you do not use it on a live 
website or in a production environment.");

// RC
define('_MI_WARNING_RC',"This module comes as is, without any guarantees whatsoever. This module 
is a Release Candidate and should not be used on a production web site. The module is still under 
active development and its use is under your own responsibility, which means the author is not responsible.");

// Final
define('_MI_WARNING_FINAL',"This module comes as is, without any guarantees whatsoever. Although this 
module is not beta, it is still under active development. This release can be used in a live website 
or a production environment, but its use is under your own responsibility, which means the author 
is not responsible.");

define('_MI_XQUIZ_AUTHOR_INFO',"Developers");
define('_MI_XQUIZ_DEVELOPER_LEAD',"Lead developer(s)");
define('_MI_XQUIZ_DEVELOPER_CONTRIBUTOR',"Contributor(s)");
define('_MI_XQUIZ_DEVELOPER_WEBSITE',"Website");
define('_MI_XQUIZ_DEVELOPER_EMAIL',"Email");
define('_MI_XQUIZ_DEVELOPER_CREDITS',"Special thanks");
define('_MI_XQUIZ_DEMO_SITE',"Frxoops Demo Site");
define('_MI_XQUIZ_MODULE_INFO',"Module Developpment Informations");
define('_MI_XQUIZ_MODULE_STATUS',"Status");
define('_MI_XQUIZ_MODULE_RELEASE_DATE',"Release date");
define('_MI_XQUIZ_MODULE_DEMO',"Demo Site");
define('_MI_XQUIZ_MODULE_SUPPORT',"Official support site");
define('_MI_XQUIZ_MODULE_BUG',"Report a bug for this module");
define('_MI_XQUIZ_MODULE_FEATURE',"Suggest a new feature for this module");
define('_MI_XQUIZ_MODULE_DISCLAIMER',"Disclaimer");
define('_MI_XQUIZ_AUTHOR_WORD',"The Author's Word");
define('_MI_XQUIZ_VERSION_HISTORY',"Version History");
?>