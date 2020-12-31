<div class="breadcrumb">
    <a href="index.php" title="<{$module_name|default:''}>">
                        <{$smarty.const._MD_XQUIZ_MODULENAME}>&nbsp;&raquo;&nbsp;
<{*	<{$smarty.const._MD_XQUIZ_CATEGORIES}>*}>
    </a>
</div>

<{if $showQuiz|default:0 == 0}>
<{*	<{if $Parent >= 0}>	<{/if}>*}>
	<{if $categoryNum != 0}>
	<h5><{$smarty.const._MD_XQUIZ_CATEGORIES}></h5>
	
	<div class=" container-fluid">
    <div class="row">
        <div class="col">
            <{foreach item=category from=$listCategory}>
                <div class="card" style="width:100%">
                    <{if $category.imgurl != 'blank.png'}>
                        <a href="<{$xoops_url}>/modules/xquiz/index.php?cid=<{$category.cid}>">
                            <img class="card-img-top" src="<{$xoops_url}>/uploads/xquiz/category/<{$category.imgurl}>" style="width:100%;">
                        </a>
                    <{/if}>
                    <div class="card-body">
                        <h4 class="card-title"><a href="<{$xoops_url}>/modules/xquiz/index.php?cid=<{$category.cid}>"><{$category.title}></a></h4>
                        <p class="card-text"><{$category.description}></p>
                        <{*                        <a href="#" class="btn btn-primary">See Profile</a>*}>
                    </div>
                </div>
            <{/foreach}>
        </div>
    </div>
</div>


<{/if}>

<{if $quizNum != 0}>
    <br>
    <h4><{$smarty.const._MD_XQUIZ_QUIZS}></h4>
    <{$smarty.now|date_format:"%A, %B %e, %Y %I:%M %p"}>
    <table width='100%' class="table table-striped">
        <tr>

            <th>
                <{$smarty.const._MD_XQUIZ_NAME}>
            </th>
            <th>
                <{$smarty.const._MD_XQUIZ_STATUS}>
            </th>
            <th>
                <{$smarty.const._MD_XQUIZ_ACTION}>
            </th>
        </tr>
        <{foreach item=quiz from=$listQuiz}>
            <{if $quiz.status==1}>
                <tr>

                    <td>
                        <{$quiz.name}> <br>
                        <small>
                            <strong><{$smarty.const._MD_XQUIZ_STARTDATE}>: </strong> <{$quiz.bdate}><br>
                            <strong><{$smarty.const._MD_XQUIZ_ENDDATE}>: </strong><{$quiz.edate}><br>
                            <strong><{$smarty.const._MD_XQUIZ_QUEST_TOTAL}>: </strong><{$quiz.totalquestion}><br>
                        </small>
                    </td>
                    <td>
                        <{if $quiz.active==1}>
                            <img src="<{$xoops_url}>/modules/xquiz/assets/images/on.png">
                            &nbsp;<{$smarty.const._MD_XQUIZ_RUNNING}>
                        <{else}>
                            <img src="<{$xoops_url}>/modules/xquiz/assets/images/off.png">
                            &nbsp;<{$smarty.const._MD_XQUIZ_EXPIRED}><{/if}>
                    </td>
                    <td>
                        <{if $quiz.active==1}>
                            <a href="<{$xoops_url}>/modules/xquiz/index.php?act=v&q=<{$quiz.id}>">
                                <{$smarty.const._MD_XQUIZ_TAKEQUIZ}>
                            </a>
                        <{else}>

                        <{/if}>
                        <{if $quiz.viewstat==1}>
                            <a href="<{$xoops_url}>/modules/xquiz/index.php?act=s&q=<{$quiz.id}>">

                                <{$smarty.const._MD_XQUIZ_VIEW_STAT}>
                            </a>
                        <{/if}>
                    </td>

                </tr>
            <{/if}>
        <{/foreach}>
    </table>
    <br>
<{/if}>
<{/if}>

<{if $showQuiz|default:0 == 2}>
    <div class="alert alert-info">
        <h5><a href="<{$xoops_url}>/modules/xquiz/index.php?cid=<{$quizCategoryId}>"><{$quizCategory}></a> :: <{$quizName}></h5>
        <{$quizDescription}>
    </div>
    <table class='table table table-striped table-hover'>
        <thead>
        <tr>
            <th>
                <{$smarty.const._MD_XQUIZ_USER}>
            </th>
            <th>
                <{$smarty.const._MD_XQUIZ_SCORE}>
            </th>
            <th>
                <{$smarty.const._MD_XQUIZ_DATETAKEN}>
            </th>
        </tr>
        </thead>
        <{foreach item=quizStat from=$quizStat}>
            <tr>
                <td>
                    <a href="<{$xoops_url}>/userinfo.php?uid=<{$quizStat.userid}>" target="_blank.php">
                        <{$quizStat.name}> (<{$quizStat.uname}>)
                    </a>
                </td>
                <td>
                    <{$quizStat.score}>
                </td>
                <td>
                    <{$quizStat.date}>
                </td>
            </tr>
        <{/foreach}>
    </table>
    <br>
    <{$commentsnav}> <{$lang_notice}>
    <{if $comment_mode == "flat"}>
        <{include file="db:system_comments_flat.html"}>
    <{elseif $comment_mode == "thread"}>
        <{include file="db:system_comments_thread.html"}>
    <{elseif $comment_mode == "nest"}>
        <{include file="db:system_comments_nest.html"}>
    <{/if}>
<{/if}>

<{if $showQuiz|default:0 == 1}>
    <{if $emptyList != 1}>
        <div class="alert alert-info">
            <h5><a href="<{$xoops_url}>/modules/xquiz/index.php?cid=<{$quizCategoryId}>"><{$quizCategory}></a> :: <{$quizName}></h5>
            <{$quizDescription}>
        </div>
        <{$listquestfrom.javascript}>
        <form name="<{$listquestfrom.name}>" action="<{$listquestfrom.action}>" method="<{$listquestfrom.method}>"
                <{$listquestfrom.extra}>>
            <br>
            <table class="table table-striped outer" cellspacing="1" align="center">
                <{*  start of form elements loop *}>
                <{foreach item=element from=$listquestfrom.elements}>
                    <{if $element.hidden !== true}>
                        <tr>
                            <td><{$element.caption}></td>
                        </tr>
                        <tr>
                            <td><{$element.body}></td>
                        </tr>
                    <{else}>
                        <{$element.body}>
                    <{/if}>
                <{/foreach}>
                <{* end of form elements loop*}>
            </table>
        </form>
    <{else}>
        <table align="center" cellspacing="0" class="outer">
            <tr>
                <td>
                    <{$smarty.const._MD_XQUIZ_QUEST_EMPTY}>
                </td>
            </tr>
        </table>
    <{/if}>
    <{$commentsnav}> <{$lang_notice}>
    <{if $comment_mode == "flat"}>
        <{include file="db:system_comments_flat.html"}>
    <{elseif $comment_mode == "thread"}>
        <{include file="db:system_comments_thread.html"}>
    <{elseif $comment_mode == "nest"}>
        <{include file="db:system_comments_nest.html"}>
    <{/if}>
<{/if}>
<{if $showQuiz|default:0 == 3}>
    <table class='table table table-striped table-hover'>
        <tr>
            <th>
                <{$smarty.const._MD_XQUIZ_NAME}>
            </th>
            <th>
                <{$smarty.const._MD_XQUIZ_DATETAKEN}>
            </th>
            <th>
                <{$smarty.const._MD_XQUIZ_SCORE}>
            </th>
            <th>
                <{$smarty.const._MD_XQUIZ_DETAIL}>
            </th>
        </tr>
        <{foreach item=quizProfile from=$quizProfile}>
            <{if !$quizProfile.active OR $quizProfileConfig}>
                <tr>
                    <td>
                        <a href="<{$xoops_url}>/modules/xquiz/index.php?act=v&q=<{$quizProfile.id}>">
                            <{$quizProfile.name}>
                        </a>
                    </td>
                    <td>
                        <{$quizProfile.date}>
                    </td>
                    <td>
                        <{$quizProfile.score}>
                    </td>
                    <td>
                        <a href="<{$xoops_url}>/modules/xquiz/index.php?act=p&qi=<{$quizProfile.id}>">
                            <img src="<{$xoops_url}>/modules/xquiz/assets/images/detail.gif">
                        </a>
                    </td>
                </tr>
            <{/if}>
        <{/foreach}>
    </table>
    <br>
<{/if}>
<{if $showQuiz|default:0 == 4}>
    <table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
        <{foreach item=questProfile from=$questProfile}>
            <tr>
                <td>
                    <br>
                    <{$questProfile.qnumber}>-<{$questProfile.question}>
                </td>
            </tr>
            <tr>
                <th>
                    <{$smarty.const._MD_XQUIZ_QUEST_SCORE}>
                </th>
                <th>
                    <{$smarty.const._MD_XQUIZ_USER_ANSWER}>
                </th>
                <th>
                    <{$smarty.const._MD_XQUIZ_QUEST_ANSWER}>
                </th>
                <th>
                    <{$smarty.const._MD_XQUIZ_STATUS}>
                </th>
            </tr>
            <tr>
                <td>
                    <{$questProfile.score}>
                </td>
                <td>
                    <{$questProfile.userAns}>
                </td>
                <td>
                    <{$questProfile.answer}>
                </td>
                <td>
                    <{if $questProfile.userAns == $questProfile.answer}>
                        <img src="<{$xoops_url}>/modules/xquiz/assets/images/valid.png">
                    <{else}>
                        <img src="<{$xoops_url}>/modules/xquiz/assets/images/invalid.png">
                    <{/if}>

                </td>
            </tr>
        <{/foreach}>
    </table>
    <br>
<{/if}>

<br>
<{include file='db:system_notification_select.html'}>
