<?php

include_once("admin_header.php");
$myts = &MyTextSanitizer::getInstance();

global $xoopsModule;

xoops_cp_header();

$module_handler = &xoops_gethandler('module');
$versioninfo = &$module_handler->get($xoopsModule->getVar('mid'));

// show the menu
forms_adminMenu(0, _AM_XQUIZ_INDEX);

// Left headings...
echo "<img src='" . XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/" . $versioninfo->getInfo('image') . "' alt='' hspace='0' vspace='0' align='left' style='margin-right: 10px;'/></a>";
echo "<div style='margin-top: 10px; color: #33538e; margin-bottom: 4px; font-size: 18px; line-height: 18px; font-weight: bold; display: block;'>" . $versioninfo->getInfo('name') . " version " . $versioninfo->getInfo('version') . " (" . $versioninfo->getInfo('status_version') . ")</div>";
if ($versioninfo->getInfo('author_realname') != '') {
    $author_name = $versioninfo->getInfo('author') . " (" . $versioninfo->getInfo('author_realname') . ")";
} else {
    $author_name = $versioninfo->getInfo('author');
}

// license information
echo "<div style = 'line-height: 16px; font-weight: bold; display: block;'>" . _AM_XQUIZ_BY . " " . $author_name;
echo "</div>";
echo "<div style = 'line-height: 16px; display: block;'>" . $versioninfo->getInfo('license') . "</div>\n";

// Developers Information
echo "<br /><table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
echo "<tr>";
echo "<td colspan='2' class='bg3' align='left'><b>" . _MI_XQUIZ_AUTHOR_INFO . "</b></td>";
echo "</tr>";

// Lead developer
If ($versioninfo->getInfo('developer_lead') != '') {
    echo "<tr>";
    echo "<td class='head' width = '150px' align='left'>" . _MI_XQUIZ_DEVELOPER_LEAD . "</td>";
    echo "<td class='even' align='left'>" . $versioninfo->getInfo('developer_lead') . "</td>";
    echo "</tr>";
}
// dev. contributors
If ($versioninfo->getInfo('developer_contributor') != '') {
    echo "<tr>";
    echo "<td class='head' width = '150px' align='left'>" . _MI_XQUIZ_DEVELOPER_CONTRIBUTOR . "</td>";
    echo "<td class='even' align='left'>" . $versioninfo->getInfo('developer_contributor') . "</td>";
    echo "</tr>";
} 
// developer website
If ($versioninfo->getInfo('developer_website_url') != '') {
    echo "<tr>";
    echo "<td class='head' width = '150px' align='left'>" . _MI_XQUIZ_DEVELOPER_WEBSITE . "</td>";
    echo "<td class='even' align='left'><a href='" . $versioninfo->getInfo('developer_website_url') . "' target='blank'>" . $versioninfo->getInfo('developer_website_name') . "</a></td>";
    echo "</tr>";
}
// developer email
If ($versioninfo->getInfo('developer_email') != '') {
    echo "<tr>";
    echo "<td class='head' width = '150px' align='left'>" . _MI_XQUIZ_DEVELOPER_EMAIL . "</td>";
    echo "<td class='even' align='left'><a href='mailto:" . $versioninfo->getInfo('developer_email') . "'>" . $versioninfo->getInfo('developer_email') . "</a></td>";
    echo "</tr>";
}


		echo "</table>";
		echo "<br />\n";
		// Module Developpment information
		echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
		echo "<tr>";
		echo "<td colspan='2' class='bg3' align='left'><b>" . _MI_XQUIZ_MODULE_INFO . "</b></td>";
		echo "</tr>";

// release informations
If ($versioninfo->getInfo('date') != '') {
    echo "<tr>";
    echo "<td class='head' width = '200' align='left'>" . _MI_XQUIZ_MODULE_RELEASE_DATE . "</td>";
    echo "<td class='even' align='left'>" . $versioninfo->getInfo('date') . "</td>";
    echo "</tr>";
}

// module status
If ($versioninfo->getInfo('status') != '') {
    echo "<tr>";
    echo "<td class='head' width = '200' align='left'>" . _MI_XQUIZ_MODULE_STATUS . "</td>";
    echo "<td class='even' align='left'>" . $versioninfo->getInfo('status') . "</td>";
    echo "</tr>";
}

// url for the support
If ($versioninfo->getInfo('support_site_url') != '') {
    echo "<tr>";
    echo "<td class='head' align='left'>" . _MI_XQUIZ_MODULE_SUPPORT . "</td>";
    echo "<td class='even' align='left'><a href='" . $versioninfo->getInfo('support_site_url') . "' target='blank'>" . $versioninfo->getInfo('support_site_name') . "</a></td>";
    echo "</tr>";
}

// general credits
If ($versioninfo->getInfo('credits_about') != '') {
    echo "<tr>";
    echo "<td class='head' align='left'>" . _MI_XQUIZ_DEVELOPER_CREDITS . "</td>";
    echo "<td class='even' align='left'><a href='" . $versioninfo->getInfo('credits_site') . "' target='blank'>" . $versioninfo->getInfo('credits_about') . "</a></td>";
    echo "</tr>";
}

// bug tracker
If ($versioninfo->getInfo('submit_bug') != '') {
    echo "<tr>";
    echo "<td class='head' align='left'>" . _MI_XQUIZ_MODULE_BUG . "</td>";
    echo "<td class='even' align='left'><a href='" . $versioninfo->getInfo('submit_bug') . "' target='blank'> "._AM_XQUIZ_SUBMIT_BUG."</a></td>";
    echo "</tr>";
}

// new feature submission
If ($versioninfo->getInfo('submit_feature') != '') {
    echo "<tr>";
    echo "<td class='head' align='left'>" . _MI_XQUIZ_MODULE_FEATURE . "</td>";
    echo "<td class='even' align='left'><a href='" . $versioninfo->getInfo('submit_feature') . "' target='blank'>"._AM_XQUIZ_SUGGEST."</a></td>";
    echo "</tr>";
}

echo "</table>";

// Warning - Disclaimer
If ($versioninfo->getInfo('warning') != '') {
    echo "<br />\n";
    echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
    echo "<tr>";
    echo "<td class='bg3' align='left'><b>" . _MI_XQUIZ_MODULE_DISCLAIMER . "</b></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td class='even' align='left'>" . $versioninfo->getInfo('warning') . "</td>";
    echo "</tr>";

    echo "</table>";
}
// Author's note
If ($versioninfo->getInfo('author_word') != '') {
    echo "<br />\n";
    echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
    echo "<tr>";
    echo "<td class='bg3' align='left'><b>" . _MI_XQUIZ_AUTHOR_WORD . "</b></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td class='even' align='left'>" . $versioninfo->getInfo('author_word') . "</td>";
    echo "</tr>";

    echo "</table>";
}

// Version History
If ($versioninfo->getInfo('version_history') != '') {
    echo "<br />\n";
    echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
    echo "<tr>";
    echo "<td class='bg3' align='left'><b>" . _MI_XQUIZ_VERSION_HISTORY . "</b></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td class='even' align='left'>" . $versioninfo->getInfo('version_history') . "</td>";
    echo "</tr>";

    echo "</table>";
}

echo "<br />";
xoops_cp_footer();

?>