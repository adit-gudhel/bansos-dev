<?
ob_start();
include_once ("$DOCUMENT_ROOT/s/config.php");

if(!empty($_SESSION[$sessionCookie])) header('Location:home.php');

if ($act == "logout")  {
	
	$strSQL		= "DELETE from tbl_session WHERE session_id='".$$sessionCookie."' ";
	$result		= $db->Execute($strSQL);
	if (!$result) print $db->ErrorMsg();
	$f->insert_log("Logout");

	session_start();
	session_destroy();
	header("Location: index.php");

	
}

#include("nav.php");

echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>$site_title</title>

<script type=\"text/javascript\" src=\"jquery-1.8.2.min.js\"></script>
<script type=\"text/javascript\">
$(document).ready(function() {

	$().ajaxStart(function() {
		$('#loading').show();
		$('#result').hide();
	}).ajaxStop(function() {
		$('#loading').hide();
		$('#result').fadeIn('slow');
	});

	$('#f1').submit(function() {
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serialize(),
			success: function(data) {
				$('#result').html(data);
			}
		})
		return false;
	});
})
</script>
<style type=\"text/css\">
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
td { padding: 0px; }
#result { background-color: #F0FFED; border: 1px solid #215800; padding: 10px; width: 340px; margin-bottom: 20px; }
</style>
</head>
<body bgcolor=#EBEBEB>
";
$f->tab();
echo"<br>
<style type=text/css>
body{
	margin-left:0px;margin-top:0px;
	font-family:arial;
}
.ui-form{
	background-color:#FFFFFF;
	width:280px;
	padding:2em;
	border:1px solid #c0c0c0;
    background-color:#CCC;
    behavior: url(/PIE.htc);
    border-radius: 15px;
    moz-border-radius:1em 1em 1em 1em;
    -webkit-border-radius: 1em 1em 1em 1em;
    -moz-box-shadow: 3px 3px 5px 6px #000;
    -webkit-box-shadow: 0px 0px 0px 6px #000;
    box-shadow: 6px 8px 9px 1px #999;
}
label{display:block;color:#666;padding:6px 0 3px 0;font-size:10pt;text-align:left;}
input[type=text],select,password,input.text{
	width:100%;margin:0 0 10px 0;color:#3f3f3f;padding:3px;font-size:16px
}
.largefield label{font-size:1.0em}.ui-form 
.largefield input{font-size:1.0em}.ui-form 
span{font-weight:normal;color:#777777}
form table{width:100%}div.ui-form ul{padding:0px}
div.ui-form ul,ul.ui-form{list-style:none;}
ul.ui-form .ui-form-inline li{padding-left:0}
.ui-form label.overlabel{color:#999999;margin-left:8px;margin-top:0;font-size:14px}
.ui-form li.checkbox{overflow:hidden;*zoom:1;padding-top:16px;padding-bottom:16px}
.uiButton{
	font-size:1.0em;
	background:url(/i/loginbutton.png) no-repeat;
	border:0px;
	width:80px;
	height:36px;
	cursor:pointer;
}
.fieldleft{
	text-align:left;
}
.gradient-line{
    background: #ffffff; /* Old browsers */
    /* IE9 SVG, needs conditional override of 'filter' to 'none' */
    background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIxMDAlIiB5Mj0iMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2ZmZmZmZiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNhYWNiZWQiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
    background: -moz-linear-gradient(left,  #ffffff 0%, #aacbed 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, right top, color-stop(0%,#ffffff), color-stop(100%,#aacbed)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(left,  #ffffff 0%,#aacbed 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(left,  #ffffff 0%,#aacbed 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(left,  #ffffff 0%,#aacbed 100%); /* IE10+ */
    background: linear-gradient(to right,  #ffffff 0%,#aacbed 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#aacbed',GradientType=1 ); /* IE6-8 */
}
#reg_label a {
    font-weight:normal;
    color:#999999
}
</style>
<center>
	<div class='wrapper ui-login' style='padding-top:60px;'>
		<div class='ui-form'>
        	<div id='loading' style='display:none;'><img src='/i/loading2.gif' alt='loading...' /></div>
            <div id='result' style='display:none;width:260px;'></div>
        	<form class='new_user_session' id='f1' method='post' action='proses_login.php'>
            	<input type='hidden' name='act' value='login' />
            	<ul>
              		<li class='largefield'>
                		<label for='user_session_Email'><span style='font-family:Trebuchet MS'>Username</span></label>
                		<input class='easyui-validatebox' required='true' id='user_session_username' name='username' size='30' type='text'/>
              		</li>
              		<li class='largefield'>
                		<label for='user_session_Password'><span style='font-family:Trebuchet MS'>Password</span></label>
                		<input class='text easyui-validatebox' required='true' id='user_session_password' name='passwd' size='30' type='password'/>
              		</li>
              		<li class=fieldleft><br>
                		<input class='uiButton' id='user_session_submit' name='commit' value='' type='submit' />
               		</li>
              	</ul>
        	</form>
      	</div>
    </div>
</center>
</body>
</html>";

#include("footer.php");

ob_end_flush();
exit;
?>
