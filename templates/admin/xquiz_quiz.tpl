<{includeq file="$xoops_rootpath/modules/xquiz/templates/admin/xquiz_header.tpl"}>
<table id="xo-quiz-sort" class="outer" cellspacing="1" width="100%">
    <thead>
    <th><{$smarty.const._AM_XQUIZ_QUIZ_ID}></th>
    <th><{$smarty.const._AM_XQUIZ_QUIZ_IMG}></th>
	<th><{$smarty.const._AM_XQUIZ_QUIZ_TITLE}></th>
	<th><{$smarty.const._AM_XQUIZ_QUIZ_TOTALQUESTION}></th>
	<th><{$smarty.const._AM_XQUIZ_QUIZ_CATEGORY}></th>
	<th><{$smarty.const._AM_XQUIZ_QUIZ_ORDER}></th>
    <th><{$smarty.const._AM_XQUIZ_QUIZ_ACTIVE}></th>
	<th><{$smarty.const._AM_XQUIZ_QUIZ_STARTDATE}></th>
	<th><{$smarty.const._AM_XQUIZ_QUIZ_ENDDATE}></th>
	<th><{$smarty.const._AM_XQUIZ_QUIZ_STATUS}></th>
    <th><{$smarty.const._AM_XQUIZ_QUIZ_ACTION}></th>
    </thead>
    <tbody class="xo-quiz">
    <{foreach item=quiz from=$quizs}>
    <tr class="odd" id="mod_<{$quiz.quiz_id}>">
        <td class="width5 txtcenter"><img src="../assets/images/puce.png" alt=""/><{$quiz.quiz_id}></td>
                <td class="txtcenter ">
		        <img style="max-width: 100px; max-height: 100px;" src="<{$quiz.imgurl}>" alt="<{$quiz.quiz_title}>" />
        </td>
		<td class="txtcenter">
	        <strong><{$quiz.quiz_title}></strong>
			<{if $quiz.quiz_description}><br><{$quiz.quiz_description}> <{/if}>
        </td>
		<td class="txtcenter ">
			<{if $quiz.quiz_totalquestion}>
            <a href="<{$quiz.quiz_totalquestion}> "><{$quiz.quiz_totalquestion}></a>       
			<{else}>0<{/if}>
        </td>
        <td class="txtcenter ">
	        <a title="<{$quiz.categorytitle}>" href="quiz.php?category=<{$quiz.quiz_category}>"><{$quiz.categorytitle}></a>
        </td>
		<td class="width5 txtcenter"><img src="../assets/images/puce.png" alt=""/><{$quiz.quiz_order}></td>
        <td class="txtcenter width5 ">
            <img class="cursorpointer" id="quiz_status<{$quiz.quiz_id}>" onclick="quiz_setStatus( { op: 'quiz_status', quiz_id: <{$quiz.quiz_id}> }, 'quiz_status<{$quiz.quiz_id}>', 'backend.php' )" src="<{if $quiz.quiz_status}>../assets/images/ok.png<{else}>../assets/images/cancel.png<{/if}>" alt=""/>
        </td>
		<td class="txtcenter width5 ">
	        <{$quiz.quiz_startdate}>
        </td> 
		<td class="txtcenter width5 ">
	        <{$quiz.quiz_enddate}>
        </td>
		<td class="txtcenter width5 ">
		
		<{if $quiz.quiz_status==0}>
			<{$smarty.const._AM_XQUIZ_INACTIVE}>
		<{else}>
	        <{if $quiz.quiz_startdate|date_format:"%Y/%m/%d %H:%M:%S" <= $smarty.now|date_format:"%Y/%m/%d %H:%M:%S" AND $smarty.now|date_format:"%Y/%m/%d %H:%M:%S" <= $quiz.quiz_enddate|date_format:"%Y/%m/%d %H:%M:%S" }>
						<strong><{$smarty.const._AM_XQUIZ_RUNNING}></strong>
						<{else}>
						<strong><span style="color:red"><{$smarty.const._AM_XQUIZ_EXPIRED}></span></strong>
            <{/if}>		
        <{/if}>		
        
		</td>	
        <td class="txtcenter width10 xo-actions">
            <img class="tooltip" onclick="display_dialog(<{$quiz.quiz_id}>, true, true, 'slide', 'slide', 400, 700);" src="<{xoAdminIcons display.png}>" alt="<{$smarty.const._PREVIEW}>" title="<{$smarty.const._PREVIEW}>" />
            <a href="quiz.php?op=edit_quiz&amp;quiz_id=<{$quiz.quiz_id}>"><img class="tooltip" src="<{xoAdminIcons edit.png}>" alt="<{$smarty.const._EDIT}>" title="<{$smarty.const._EDIT}>"/></a>
            <a href="quiz.php?op=delete_quiz&amp;quiz_id=<{$quiz.quiz_id}>"><img class="tooltip" src="<{xoAdminIcons delete.png}>" alt="<{$smarty.const._DELETE}>" title="<{$smarty.const._DELETE}>"/></a>
        </td>
    </tr>
    <{/foreach}>
    </tbody>
</table>

<{foreach item=quiz from=$quizs}>
	<div id="dialog<{$quiz.quiz_id}>" title="<{$quiz.quiz_title}>" style='display:none;'>
	<div class="marg5 pad5 ui-state-default ui-corner-all">
		<{$smarty.const._AM_XQUIZ_QUIZ_CATEGORY}> : <span class=""><a href="quiz.php?category=<{$quiz.quiz_category}>"><{$quiz.categorytitle}></a></span>
	</div>
	<div class="marg5 pad5 ui-state-highlight ui-corner-all">
	   <div class="pad5"><{$smarty.const._AM_XQUIZ_QUIZ_TITLE}> : <{$quiz.quiz_title}><br><img class="ui-state-highlight left" width="300" src="<{$quiz.imgurl}>" alt="<{$quiz.quiz_title}>" /></div>
	   <{if $quiz.quiz_description}>
		<div class="pad5"><br /><{$quiz.quiz_description}></div>
	   <{/if}>
		<div class="clear"></div>
   </div>
	</div>
<{/foreach}>

<div class="pagenav"><{$quiz_pagenav}></div>