<?php
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Configuration file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.0, 2003-03-27
// ================================================

// directory where spaw files are located

global $_COOKIE;

$spaw_dir = '/components/spaw/';

// base url for images
$spaw_base_url = "http://$HTTP_HOST";

if (!ereg('/$', $HTTP_SERVER_VARS['DOCUMENT_ROOT']))
  $spaw_root = $HTTP_SERVER_VARS['DOCUMENT_ROOT'].$spaw_dir;
else
  $spaw_root = $HTTP_SERVER_VARS['DOCUMENT_ROOT'].substr($spaw_dir,1,strlen($spaw_dir)-1);
  

$spaw_default_toolbars = 'default';
$spaw_default_theme = 'default';
$spaw_default_lang = 'en';
$spaw_default_css_stylesheet = $spaw_dir.'wysiwyg.css';

// add javascript inline or via separate file
$spaw_inline_js = false;

// use active toolbar (reflecting current style) or static
$spaw_active_toolbar = true;

// default dropdown content
$spaw_dropdown_data['style']['default'] = 'Normal';

$spaw_dropdown_data['table_style']['default'] = 'Normal';

$spaw_dropdown_data['td_style']['default'] = 'Normal';

$spaw_dropdown_data['font']['Arial'] = 'Arial';
$spaw_dropdown_data['font']['Courier'] = 'Courier';
$spaw_dropdown_data['font']['Tahoma'] = 'Tahoma';
$spaw_dropdown_data['font']['Times New Roman'] = 'Times';
$spaw_dropdown_data['font']['Verdana'] = 'Verdana';

$spaw_dropdown_data['fontsize']['1'] = '1';
$spaw_dropdown_data['fontsize']['2'] = '2';
$spaw_dropdown_data['fontsize']['3'] = '3';
$spaw_dropdown_data['fontsize']['4'] = '4';
$spaw_dropdown_data['fontsize']['5'] = '5';
$spaw_dropdown_data['fontsize']['6'] = '6';

$spaw_dropdown_data['paragraph']['Normal'] = 'Normal';
$spaw_dropdown_data['paragraph']['Heading 1'] = 'Heading 1';
$spaw_dropdown_data['paragraph']['Heading 2'] = 'Heading 2';
$spaw_dropdown_data['paragraph']['Heading 3'] = 'Heading 3';
$spaw_dropdown_data['paragraph']['Heading 4'] = 'Heading 4';
$spaw_dropdown_data['paragraph']['Heading 5'] = 'Heading 5';
$spaw_dropdown_data['paragraph']['Heading 6'] = 'Heading 6';

// image library related config

// allowed extentions for uploaded image files
$spaw_valid_imgs = array('gif', 'jpg', 'jpeg', 'png');

// allow upload in image library
$spaw_upload_allowed = true;

// allow delete in image library
$spaw_img_delete_allowed = true;

// image libraries
if ($active_article) $default_dir = $active_article;
else $default_dir = "temp";

if (!is_dir($DOCUMENT_ROOT."/i/art/".$default_dir)) mkdir ($DOCUMENT_ROOT."/i/art/".$default_dir);

$spaw_imglibs = array(
  array(
    'value'   => '/i/art/'.$default_dir.'/',
    'text'    => '/i/art/'.$default_dir.'/',
  ),
);
//print_r($spaw_imglibs);
// file to include in img_library.php (useful for setting $spaw_imglibs dynamically
// $spaw_imglib_include = '';

// allowed hyperlink targets
$spaw_a_targets['_self'] = 'Self';
$spaw_a_targets['_blank'] = 'Blank';
$spaw_a_targets['_top'] = 'Top';
$spaw_a_targets['_parent'] = 'Parent';

// image popup script url
$spaw_img_popup_url = $spaw_dir.'img_popup.php';

// internal link script url
$spaw_internal_link_script = 'url to your internal link selection script';

// disables style related controls in dialogs when css class is selected
$spaw_disable_style_controls = true;

?>
