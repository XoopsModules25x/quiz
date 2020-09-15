<table  cellspacing='1' cellpadding='3' border='0' class='outer'>
	<{foreach item=quiz from=$block}>
		<{if $quiz.status==1}>
			<tr class="<{cycle values="even,odd"}>">
				<{if $quiz.active==1}>
					<td>
						<a href="<{$xoops_url}>/modules/xquiz/?act=v&q=<{$quiz.id}>">
							<{$quiz.name}>
						</a>
					</td>
					<td>
						<a href="<{$xoops_url}>/modules/xquiz/?act=v&q=<{$quiz.id}>">
							<{$smarty.const._MB_XQUIZ_ACTIVE}>
						</a>	
					</td>
					<{else}>
					<td>
						<a href="<{$xoops_url}>/modules/xquiz/?act=s&q=<{$quiz.id}>">
							<{$quiz.name}>
						</a>
					</td>
					<td>
						<a href="<{$xoops_url}>/modules/xquiz/?act=s&q=<{$quiz.id}>">
							<{$smarty.const._MB_XQUIZ_UNACTIVE}>
						</a>	
					</td>
				<{/if}>	
			</tr>
		<{/if}>	
	<{/foreach}>
</table>