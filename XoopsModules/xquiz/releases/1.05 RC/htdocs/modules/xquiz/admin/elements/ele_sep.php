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

if( !preg_match("/elements.php/", $_SERVER['PHP_SELF']) ){
	exit("Access Denied");
}

$options = array();
$opt_count = 0;

$rows = !empty($value[0]) ? $value[1] : $xoopsModuleConfig['ta_rows'];
$cols = !empty($value[0]) ? $value[2] : $xoopsModuleConfig['ta_cols'];
$rows = new XoopsFormText (_AM_XQUIZ_ELE_ROWS, 'ele_value[1]', 3, 3, $rows);
$cols = new XoopsFormText (_AM_XQUIZ_ELE_COLS, 'ele_value[2]', 3, 3, $cols);
$type = new XoopsFormCheckBox (_AM_XQUIZ_ELE_TYPE, 'option', null);
$type->addOption ('centre', ' '._AM_XQUIZ_ELE_CTRE.'<br />');
$type->addOption ('souligne', ' '._AM_XQUIZ_ELE_SOUL.'<br />');
$type->addOption ('italique', ' '._AM_XQUIZ_ELE_ITALIQ.'<br />');
$type->addOption ('gras', ' '._AM_XQUIZ_ELE_BOLD.'<br />');
$default = new XoopsFormTextArea(_AM_XQUIZ_ELE_DEFAULT, 'ele_value[0]', $value[0], 5, 35);

/* color picker : for a next release
	$select_color = "\n<select name='couleur'  onchange='xoopsGetElementById(\"NewsColorSelect\").style.backgroundColor = \"#\" + this.options[this.selectedIndex].value;'>\n<option value='000000'>"._AM_XQUIZ_ELE_COLOR."</option>\n";
	$color_values = array('000000','000033','000066','000099','0000CC','0000FF','003300','003333','003366','0033CC','0033FF','006600','006633',
							'006666','006699','0066CC','0066FF','009900','009933','009966','009999','0099CC','0099FF','00CC00','00CC33','00CC66','00CC99',
							'00CCCC','00CCFF','00FF00','00FF33','00FF66','00FF99','00FFCC','00FFFF','330000','330033','330066','330099','3300CC','3300FF',
							'333300','333333','333366','333399','3333CC','3333FF','336600','336633','336666','336699','3366CC','3366FF','339900','339933',
							'339966','339999','3399CC','3399FF','33CC00','33CC33','33CC66','33CC99','33CCCC','33CCFF','33FF00','33FF33','33FF66','33FF99',
							'33FFCC','33FFFF','660000','660033','660066','660099','6600CC','6600FF','663300','663333','663366','663399','6633CC','6633FF',
							'666600','666633','666666','666699','6666CC','6666FF','669900','669933','669966','669999','6699CC','6699FF','66CC00','66CC33',
							'66CC66','66CC99','66CCCC','66CCFF','66FF00','66FF33','66FF66','66FF99','66FFCC','66FFFF','990000','990033','990066','990099',
							'9900CC','9900FF','993300','993333','993366','993399','9933CC','9933FF','996600','996633','996666','996699','9966CC','9966FF',
							'999900','999933','999966','999999','9999CC','9999FF','99CC00','99CC33','99CC66','99CC99','99CCCC','99CCFF','99FF00','99FF33',
							'99FF66','99FF99','99FFCC','99FFFF','CC0000','CC0033','CC0066','CC0099','CC00CC','CC00FF','CC3300','CC3333','CC3366','CC3399',
							'CC33CC','CC33FF','CC6600','CC6633','CC6666','CC6699','CC66CC','CC66FF','CC9900','CC9933','CC9966','CC9999','CC99CC','CC99FF',
							'CCCC00','CCCC33','CCCC66','CCCC99','CCCCCC','CCCCFF','CCFF00','CCFF33','CCFF66','CCFF99','CCFFCC','CCFFFF','FF0000','FF0033',
							'FF0066','FF0099','FF00CC','FF00FF','FF3300','FF3333','FF3366','FF3399','FF33CC','FF33FF','FF6600','FF6633','FF6666','FF6699',
							'FF66CC','FF66FF','FF9900','FF9933','FF9966','FF9999','FF99CC','FF99FF','FFCC00','FFCC33','FFCC66','FFCC99','FFCCCC','FFCCFF',
							'FFFF00','FFFF33','FFFF66','FFFF99','FFFFCC','FFFFFF');

	foreach($color_values as $color_value) {
		if($topic_color == $color_value) {
			$selected = " selected='selected'";
		} else {
			$selected = '';
		}
		$select_color .= "<option".$selected." value='".$color_value."' style='background-color:#".$color_value.";color:#".$color_value.";'>#".$color_value."</option>\n";
	}

	$select_color .= "</select>&nbsp;\n<span id='NewsColorSelect'>&nbsp;&nbsp;&nbsp;&nbsp;</span>";
*/

$tab = array ("Noir"=>"#000000", "Marron"=>"#97694F", "Bleu"=>"#7093DB", "Rouge"=>"#e00000", "Vert"=>"#00FF00", "Rose"=>"#FF80C0", "Jaune"=>"#ffff00", "Blanc"=>"#ffffff");
$couleur = new XoopsFormSelect (_AM_XQUIZ_ELE_CLR, 'couleur', null, 5, false);
foreach ($tab as $cle=>$tab) {
	$couleur->addOption($tab, $cle);
}


$form->addElement($rows, 1);
$form->addElement($cols, 1);
$form->addElement($default);
$form->addElement($type);
$form->addElement($couleur);
//$form->addElement( new XoopsFormLabel( _AM_XQUIZ_ELE_CLR, $select_color) );
?>