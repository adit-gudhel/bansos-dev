<HTML>
	<HEAD>
		<TITLE>SPKT</TITLE>
		<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
		<link href="/prototipe.css" rel="stylesheet" type="text/css">
		
	</HEAD>
	<body leftMargin="0" topMargin="0">

<?

function title($msg){

		$msg=strtoupper($msg);
		echo"	
			<table class=bar_level1 border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td align=left class=tdjudulabu style=\"padding:5px;\">$msg</td>
				</tr>
			</table>
		";


}
function subtitle($msg){


		echo"	
			<table width=95% border=0 cellpadding=0 cellspacing=0 style=\"border:0px solid #320000;\">
				<tr>
					<td width=10 height=20 class=tdjudulcoklatkiri>&nbsp;</td>
					<td align=center class=tdjudulcoklat>$msg</td>
					<td width=10 class=tdjudulcoklatkanan>&nbsp;</td>
				</tr>
			</table>
		";


}


?>
