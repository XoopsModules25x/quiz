		<div class="breadcrumb">
                    <a href="index.php" title="<{$module_name}>">
                        <{$smarty.const._MD_XQUIZ_MODULENAME}>
						 &nbsp;&raquo;&nbsp;
                    </a>
        </div>

<{if $showQuiz == 0}>
	<{if $Parent >= 0}>
	<h5>
		<a href="<{$xoops_url}>/modules/xquiz/quiz.php?cid=<{$Parent}>">
			<img src="<{$xoops_url}>/modules/xquiz/assets/images/back.png">
			<{$smarty.const._XQUIZ_BACK}>
		</a>
	</h5>
	<{/if}>
	<{if $categoryNum != 0}>
	<br/>
	<br/>
	<h4><{$smarty.const._MD_XQUIZ_CATEGORIES}></h4>
	
	<br/>
	<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
		<tr>
			<th width='20%'>
			<{$smarty.const._CATEGORY_IMAGE}>
			</th>
			<th>
				<{$smarty.const._CATEGORY_TITLE}>
			</th>
		</tr>
		<{foreach item=category from=$listCategory}>
			<tr class="<{cycle values="even,odd"}>">
				<td>
					<a href="<{$xoops_url}>/modules/xquiz/index.php?cid=<{$category.cid}>">
						<img src="<{$xoops_url}>/uploads/xquiz/category/<{$category.imgurl}>">
					</a>
				</td>
				<td>
				<table>
					<tr>
						<td>
							<a href="<{$xoops_url}>/modules/xquiz/index.php?cid=<{$category.cid}>">
							<{$category.title}>
							</a>
						</td>
					</tr>
					<tr>
						<td>
						<{$category.description}>
						</td>
					</tr>
				</table>	
				</td>
			</tr>
		<{/foreach}>
	</table>
	<br/>
	
	<{/if}>

	<{if $quizNum != 0}>
	<br/>
	<h4><{$smarty.const._AM_XQUIZ_QUIZS}></h4>
	
	<br/>
	<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
		<tr>
			<th>
			</th>
			<th>
				<{$smarty.const._XQUIZ_NAME}>
			</th>
			<th>
				<{$smarty.const._XQUIZ_QUEST_NUM}>
			</th>
			<th>
				<{$smarty.const._XQUIZ_BDATE}>
			</th>
			<th>
				<{$smarty.const._XQUIZ_EDATE}>
			</th>
			<th>
				<{$smarty.const._XQUIZ_STATUS}>
			</th>
		</tr>
		<{foreach item=quiz from=$listQuiz}>
			<{if $quiz.status==1}>
			<tr class="<{cycle values="even,odd"}>">
				<td>
					<img src="<{$xoops_url}>/modules/xquiz/assets/images/home.png">
				</td>
				<td>
					<{$quiz.name}>
				</td>
				<td>
					<{$quiz.question}>
				</td>
				<td>
					<{$quiz.bdate}>
				</td>
				<td>
					<{$quiz.edate}>
				</td>
				<td>
					<{if $quiz.active==1}>
						<a href="<{$xoops_url}>/modules/xquiz/index.php?act=v&q=<{$quiz.id}>">
						<img src="<{$xoops_url}>/modules/xquiz/assets/images/on.png">
						<{$smarty.const._XQUIZ_GO}>
						</a>
					<{else}>
						<a href="<{$xoops_url}>/modules/xquiz/index.php?act=s&q=<{$quiz.id}>">
						<img src="<{$xoops_url}>/modules/xquiz/assets/images/off.png">
						<{$smarty.const._XQUIZ_VIEW_STAT}>
						</a>
					<{/if}>	
				</td>
			</tr>
			<{/if}>
		<{/foreach}>
	</table>
	<br/>
	
	<{/if}>
<{/if}>

<{if $showQuiz == 2}>
<br/>
<h5><a href="<{$xoops_url}>/modules/xquiz/index.php?cid=<{$quizCategoryId}>"><{$quizCategory}></a>-><{$quizName}></h5>
<br/>
<h5><{$quizDescription}></h5>
<br/>
<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
	<tr>
		<td>
		</td>
		<td>
			<{$smarty.const._XQUIZ_USER}>
		</td>
		<td>
			<{$smarty.const._XQUIZ_USER_NAME}>
		</td>
		<td>
			<{$smarty.const._XQUIZ_SCORE}>
		</td>
		<td>
			<{$smarty.const._XQUIZ_DATE}>
		</td>
	</tr>
	<{foreach item=quizStat from=$quizStat}>
		<tr class="<{cycle values="even,odd"}>">
			<td width='5%'>
				<a href="<{$xoops_url}>/userinfo.php?uid=<{$quizStat.userid}>">
				<img src="<{$xoops_url}>/modules/xquiz/assets/images/user.png">
				</a>
			</td>
			<td width='25%'>
				<a href="<{$xoops_url}>/userinfo.php?uid=<{$quizStat.userid}>">
				<{$quizStat.uname}>
				</a>
			</td>
			<td width='25%'>
				<a href="<{$xoops_url}>/userinfo.php?uid=<{$quizStat.userid}>">
				<{$quizStat.name}>
				</a>
			</td>
			<td width='5%'>
				<{$quizStat.score}>
			</td>
			<td>
				<{$quizStat.date}>
			</td>
		</tr>
	<{/foreach}>
</table>
<br/>

	<{$commentsnav}> <{$lang_notice}>
	<{if $comment_mode == "flat"}>
		<{include file="db:system_comments_flat.html"}> 
		<{elseif $comment_mode == "thread"}> 
		<{include file="db:system_comments_thread.html"}> 
		<{elseif $comment_mode == "nest"}> 
		<{include file="db:system_comments_nest.html"}> 
	<{/if}>
<{/if}>

<{if $showQuiz == 1}>
	<{if $emptyList != 1}>
		<br/>
		<h5><a href="<{$xoops_url}>/modules/xquiz/index.php?cid=<{$quizCategoryId}>"><{$quizCategory}></a>-><{$quizName}></h5>
		
		<br/>
		<h5><{$quizDescription}></h5>
		<br/>
		<{$listquestfrom.javascript}>
		<form name="<{$listquestfrom.name}>" action="<{$listquestfrom.action}>" method="<{$listquestfrom.method}>" <{$listquestfrom.extra}>>
		<br>
  		<table class="outer" cellspacing="1" align="center">
		    <!-- start of form elements loop -->
    		<{foreach item=element from=$listquestfrom.elements}>
      			<{if $element.hidden != true}>
			      <tr class="<{cycle values="even,odd"}>">
        			<td><{$element.caption}></td>
      			  </tr>	
				  <tr class="<{cycle values="even,odd"}>">
			        <td><{$element.body}></td>
      			  </tr>	
    <{else}>
      <{$element.body}>
    <{/if}>
<{/foreach}>
<!-- end of form elements loop -->
</table>
</form>
<{else}>
<table align="center" cellspacing="0" class="outer">
	<tr>
		<td>
		<{$smarty.const._QUEST_EMPTY}>
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
<{if $showQuiz == 3}>

<br/>
<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
	<tr>
		<th>
			<{$smarty.const._XQUIZ_NAME}>
		</th>
		<th>
			<{$smarty.const._XQUIZ_DATE}>
		</th>
		<th>
			<{$smarty.const._XQUIZ_SCORE}>
		</th>
		<th>
			<{$smarty.const._MD_XQUIZ_DETAIL}>
		</th>
	</tr>
	<{foreach item=quizProfile from=$quizProfile}>
		<{if !$quizProfile.active OR $quizProfileConfig}>
		<tr class="<{cycle values="even,odd"}>">
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
<br/>

<{/if}> 
<{if $showQuiz == 4}>
<br/>
	<a href="<{$xoops_url}>/modules/xquiz/index.php?act=p">
		<img src="<{$xoops_url}>/modules/xquiz/assets/images/back.png">
		<{$smarty.const._XQUIZ_BACK}>
	</a>
</h5>

<br/>
<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
	<{foreach item=questProfile from=$questProfile}>
		<tr>
			<td>
			<br/>
			<{$questProfile.qnumber}>-<{$questProfile.question}>
			</td>
		</tr>
		<tr>
			<th>
				<{$smarty.const._QUEST_SCORE}>
			</th>
			<th>
				<{$smarty.const._USER_ANSWER}>
			</th>
			<th>
				<{$smarty.const._QUEST_ANSWER}>
			</th>
			<th>
				<{$smarty.const._XQUIZ_STATUS}>
			</th>
		</tr>
		<tr class="<{cycle values="even,odd"}>">
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
<br/>

<{/if}>
<{include file='db:system_notification_select.html'}>
