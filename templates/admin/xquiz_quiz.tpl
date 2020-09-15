<{includeq file="$xoops_rootpath/modules/xquiz/templates/admin/xquiz_header.tpl"}>
<table id="xo-item-sort" class="outer" cellspacing="1" width="100%">
    <thead>
    <th><{$smarty.const._AM_XQUIZ_ITEM_ID}></th>
    <th><{$smarty.const._AM_XQUIZ_ITEM_IMG}></th>
    <th><{$smarty.const._AM_XQUIZ_ITEM_TITLE}></th>
	<th><{$smarty.const._AM_XQUIZ_ITEM_CAPTION}></th>
	<th><{$smarty.const._AM_XQUIZ_ITEM_LINK}></th>
	<th><{$smarty.const._AM_XQUIZ_ITEM_CATEGORY}></th>
	<th><{$smarty.const._AM_XQUIZ_ITEM_ORDER}></th>
    <th><{$smarty.const._AM_XQUIZ_ITEM_ACTIVE}></th>
	<th><{$smarty.const._AM_XQUIZ_ITEM_STARTDATE}></th>
	<th><{$smarty.const._AM_XQUIZ_ITEM_ENDDATE}></th>
	<th><{$smarty.const._AM_XQUIZ_ITEM_STATUS}></th>
	<th><{$smarty.const._AM_XQUIZ_ITEM_LANGUAGECODE}></th>
    <th><{$smarty.const._AM_XQUIZ_ITEM_ACTION}></th>
    </thead>
    <tbody class="xo-item">
    <{foreach item=item from=$items}>
    <tr class="odd" id="mod_<{$item.item_id}>">
        <td class="width5 txtcenter"><img src="../assets/images/puce.png" alt=""/><{$item.item_id}></td>
                <td class="txtcenter bold">
		        <img style="max-width: 100px; max-height: 100px;" src="<{$item.imgurl}>" alt="<{$item.item_title}>" />
        </td>
		<td class="txtcenter bold">
	        <{$item.item_title}>
        </td>
		<td class="txtcenter bold">
			<{if $item.item_caption}>
            <{$item.item_caption}>       
			<{else}>-<{/if}>
        </td>
		<td class="txtcenter bold">
			<{if $item.item_link}>
            <a href="<{$item.item_link}> "><{$item.item_link}></a>       
			<{else}>-<{/if}>
			<{if $item.item_linktarget==1}>*<{/if}>
        </td>
        <td class="txtcenter bold">
	        <a title="<{$item.categorytitle}>" href="quiz.php?category=<{$item.item_category}>"><{$item.categorytitle}></a>
        </td>
		<td class="width5 txtcenter"><img src="../assets/images/puce.png" alt=""/><{$item.item_order}></td>
        <td class="txtcenter width5 bold">
            <img class="cursorpointer" id="item_status<{$item.item_id}>" onclick="item_setStatus( { op: 'item_status', item_id: <{$item.item_id}> }, 'item_status<{$item.item_id}>', 'backend.php' )" src="<{if $item.item_status}>../assets/images/ok.png<{else}>../assets/images/cancel.png<{/if}>" alt=""/>
        </td>
		<td class="txtcenter width5 bold">
	        <{$item.item_startdate}>
        </td> 
		<td class="txtcenter width5 bold">
	        <{$item.item_enddate}>
        </td>
		<td class="txtcenter width5 bold">
		
		<{if $item.item_status==0}>
			<{$smarty.const._AM_XQUIZ_INACTIVE}>
		<{else}>
	        <{if $item.item_startdate|date_format:"%Y/%m/%d %H:%M:%S" <= $smarty.now|date_format:"%Y/%m/%d %H:%M:%S" AND $smarty.now|date_format:"%Y/%m/%d %H:%M:%S" <= $item.item_enddate|date_format:"%Y/%m/%d %H:%M:%S" }>
						<strong><{$smarty.const._AM_XQUIZ_RUNNING}></strong>
						<{else}>
						<strong><span style="color:red"><{$smarty.const._AM_XQUIZ_EXPIRED}></span></strong>
            <{/if}>		
        <{/if}>		
        
		</td>
		<td class="txtcenter width5 bold">
	        <{if $item.item_languagecode}>
            <{$item.item_languagecode}>        
			<{else}>-<{/if}>
		</td> 		
        <td class="txtcenter width10 xo-actions">
            <img class="tooltip" onclick="display_dialog(<{$item.item_id}>, true, true, 'slide', 'slide', 400, 700);" src="<{xoAdminIcons display.png}>" alt="<{$smarty.const._PREVIEW}>" title="<{$smarty.const._PREVIEW}>" />
            <a href="quiz.php?op=edit_item&amp;item_id=<{$item.item_id}>"><img class="tooltip" src="<{xoAdminIcons edit.png}>" alt="<{$smarty.const._EDIT}>" title="<{$smarty.const._EDIT}>"/></a>
            <a href="quiz.php?op=delete_item&amp;item_id=<{$item.item_id}>"><img class="tooltip" src="<{xoAdminIcons delete.png}>" alt="<{$smarty.const._DELETE}>" title="<{$smarty.const._DELETE}>"/></a>
        </td>
    </tr>
    <{/foreach}>
    </tbody>
</table>

<{foreach item=item from=$items}>
	<div id="dialog<{$item.item_id}>" title="<{$item.item_title}>" style='display:none;'>
	<div class="marg5 pad5 ui-state-default ui-corner-all">
		<{$smarty.const._AM_XQUIZ_ITEM_CATEGORY}> : <span class="bold"><a href="quiz.php?category=<{$item.item_category}>"><{$item.categorytitle}></a></span>
	</div>
	<div class="marg5 pad5 ui-state-highlight ui-corner-all">
	   <div class="pad5"><span class="bold"><{$smarty.const._AM_XQUIZ_ITEM_TITLE}> : <{$item.item_title}></span><br><img class="ui-state-highlight left" width="300" src="<{$item.imgurl}>" alt="<{$item.item_title}>" /></div>
	   <{if $item.item_caption}>
		<div class="pad5"><span class="bold"><{$smarty.const._AM_XQUIZ_ITEM_CAPTION}> : </span><{$item.item_caption}></div>
	   <{/if}>
		<div class="clear"></div>
   </div>
	</div>
<{/foreach}>

<div class="pagenav"><{$item_pagenav}></div>