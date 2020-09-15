<{includeq file="$xoops_rootpath/modules/xquiz/templates/admin/xquiz_header.tpl"}>
<table id="xo-category-sort" class="outer" cellspacing="1" width="100%">
    <thead>
    <th><{$smarty.const._AM_XQUIZ_CATEGORY_ID}></th>
    <th><{$smarty.const._AM_XQUIZ_CATEGORY_TITLE}></th>
    <th><{$smarty.const._AM_XQUIZ_CATEGORY_ACTION}></th>
    </thead>
    <tbody class="xo-category">
    <{foreach item=category from=$categories}>
    <tr class="odd" id="mod_<{$category.category_id}>">
        <td class="width5 txtcenter"><img src="../assets/images/puce.png" alt=""/><{$category.category_id}></td>
        <td class="txtcenter width35 bold">
	        <{$category.category_title}>
        </td>
        <td class="txtcenter width10 xo-actions">
            <a href="category.php?op=edit_category&amp;category_id=<{$category.category_id}>"><img class="tooltip" src="<{xoAdminIcons edit.png}>" alt="<{$smarty.const._EDIT}>" title="<{$smarty.const._EDIT}>"/></a>
            <a href="category.php?op=delete_category&amp;category_id=<{$category.category_id}>"><img class="tooltip" src="<{xoAdminIcons delete.png}>" alt="<{$smarty.const._DELETE}>" title="<{$smarty.const._DELETE}>"/></a>
        </td>
    </tr>
    <{/foreach}>
    </tbody>
</table>