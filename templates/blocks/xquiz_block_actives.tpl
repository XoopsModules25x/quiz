<table  cellspacing='1' cellpadding='3' border='0' class='outer'>
	<{foreach item=quiz from=$block}>
		<{if $quiz.status==1 && $quiz.active==1}>
			<tr class="<{cycle values="even,odd"}>">
				<td>
					<a href="<{$xoops_url}>/modules/xquiz/quiz.php?act=v&q=<{$quiz.id}>">
						<{$quiz.name}>
					</a>
				</td>
			</tr>
		<{/if}>	
	<{/foreach}>
</table>