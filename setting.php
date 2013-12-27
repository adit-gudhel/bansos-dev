<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
$t->basicheader();

echo "<script type='text/javascript' src='/js/gaji.js'></script>";

$t->title('Setting &raquo; Theme');

$cfg_reff_table="tbl_setting";
echo"<BR>";
if($act=="do_add"){

    if($error){
		echo"<B>ERROR: </B>
		<ul>$error</ul><P>
		<B>&laquo;</B> <a href=# onClick=javascript:history.back(-1)>Kembali</a>";

	}else{
		/*===================================================================
		CHECK KONDISI
		====================================================================*/
		$_c_primary_key=preg_replace("#,#","|",$primary_key);
		
		$sql="select path from tbl_setting";
		$act= ($f->check_exist_value($sql)==true)?"do_update":"do_add";	
        

		foreach($HTTP_POST_VARS as $key=>$val){

			if($act=='do_add' && !preg_match("/^(act|change_file|file|svc_id)$/i",$key)){				
				$columns .="$key,";
				if(eregi("tgl|tanggal",$key)){
					$values .="to_date('$val','dd/mm/yyyy'),";	
				}else{
					$values .="'$val',";
				}				

			}elseif($act=='do_update' && !preg_match("/^(act|change_file|file|$_c_primary_key)$/i",$key)){
				if(eregi("tgl|tanggal",$key)){
					$list .="$key=to_date('$val','dd/mm/yyyy'),";	
				}else{
					$list .="$key='$val',";					
				}
			}

		}
		$columns = preg_replace("/,$/","",$columns);
		$values	 = preg_replace("/,$/","",$values);
		$list	 = preg_replace("/,$/","",$list);
		$cond_primary_key = $f->primary_key($primary_key);
		
		echo"<P>";

		if($act=="do_update"){ 
         	$sql="select path from $cfg_reff_table ";
         	$result=$f->get_last_record($sql);
         	$path_old=$result['path'];
         	
			$array=array(
				"dir"=>"/i/payroll",
				"act"=>"do_update",
				"input_name"=>"file",
				"path_old"=>"$path_old",
				"change_file"=>"$change_file",
				"extension"=>"gif|jpg|jpeg"				
			);
			$filename=$f->upload_file($array);
            
            if($change_file=='3'){
				$list .=",path=''";
			}elseif($change_file=='2'){
				$list .=",path='$filename'";
	         }

	        $sql="update $cfg_reff_table set $list";
#			echo"$sql<HR>";
	        $result=$db->Execute("$sql");
			if (!$result){
				print $db->ErrorMsg();
				die($sql);
			}
            
			
			$f->insert_log("UPDATE $title. $primary_key: ".($$primary_key),addslashes($sql));
			$f->result_message("Data telah di update<P>
			<a href=$PHP_SELF>&larr; Kembali</a>");
		}else{
			$array=array(
					"dir"=>"/i/payroll",
					"act"=>"do_add",
					"input_name"=>"file",
					"extension"=>"doc|docx|jpg|jpeg|pdf"
				);
			if(!empty($HTTP_POST_FILES['file']['name'])) $filename=$f->upload_file($array);	
			if(!empty($filename)){
				$columns .=",path";
				$values .=",'$filename'";
			}
			$sql_insert	="insert into $cfg_reff_table ($columns) values ($values)";
			$result=$db->Execute($sql_insert);
			if (!$result){
				print $db->ErrorMsg();
				die($sql_insert);
			}	
			$f->result_message("Data telah direkam
			<P><a href=$PHP_SELF>&larr; Kembali</a>");
			//$f->insert_log("INSERT $title. $primary_key ".($$primary_key));
		}
	}



}else{


	$result = $f->get_last_record("select * from tbl_setting");
	foreach($result as $key=>$val) $$key=$val;
	echo"
	<script type=text/javascript src=/js/jscolor/jscolor.js></script>
	<body>
	<form method=post enctype=multipart/form-data name=form1 id=form1>
	<input type=hidden name=act value=do_add>
	<table style=width:80%; align=center border=0 class=index>
	<tr>
		<th colspan=2>Setting Theme</th>
	</tr>
    <tr>
      <td>Header color</td>
      <td><input class=color value='$header_color' name=header_color></td>
    </tr>
    <tr>
      <td>Tab color</td>
      <td><input class=color value='$tab_color' name=tab_color></td>
    </tr>
    <tr>
      <td>Page color</td>
      <td><input class=color value='$page_color' name=page_color></td>
    </tr>
    <tr>
      <td valign=top>Logo</td>
      <td valign=top>";
		echo $f->input_image("file","$path","upload dalam format GIF/JPG");
#        <input type=file name=fupload id=fupload /><p><img alt=Logo src=../logo/$path width=150 height=33 style='padding-left:5px; padding-top:5px; padding-bottom:2px;'>
      echo"</td>
    </tr>
    <tr>
      <td colspan=2 align=center>
        <input type=button onClick=history.back(-1); value='&larr; Kembali'>
		<input type=submit value='Simpan &rarr;' class=buttonhi>
      </td>
    </tr>
  </table>
</form>
";
}

$t->basicfooter();
?>