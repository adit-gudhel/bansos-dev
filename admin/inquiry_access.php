<?
ob_start();
include("$DOCUMENT_ROOT/s/config.php");
$f->checkaccess();
$t->basicheader();
$t->title('Setting &raquo; Inquiry Access');

$debug="0";
if(!$start) 	$start='0';
if(!$order)	$order='access_name';
if(!$sort) 	$sort='desc';
if(!$page) 	$page='0';
if(!$num)	$num='10';
$start=($page-1)*$num;
if($start < 0) $start='0';
$advance_search = 0;


if($act=='delete'){

	$f->checkaccess("delete");

	$sql="delete from tbl_inquiry_access where access_name='$access_name'";
	$result=$db->Execute($sql);
	if(!$result) print $db->ErrorMsg();
	header("Location: $HTTP_REFERER");
	ob_end_flush();
	exit;	

}elseif($act=='do_add' || $act=='do_update'){

	if ($act == "do_update") $f->checkaccess("edit");
	else if ($act == "do_add") $f->checkaccess("add");
	
	#echo"<PRE>";
	#print_r($_POST);
	$result=$db->Execute("delete from tbl_inquiry_access where access_name='$access_name'");
	if(!$result) print $db->ErrorMsg();

	foreach($_POST as $key=>$val){
		unset($sql);
		unset($inquiry_access);
		if(!eregi("access_name|id|act",$key)){


			if(is_array($val)){
				
				foreach($val as $key1=>$val1){
					$inquiry_access .="$val1|";
				}
				$inquiry_access=preg_replace("/\|$/","",$inquiry_access);
			}


		}
		if(!empty($inquiry_access)){
			$sql ="insert into tbl_inquiry_access (access_name,inquiry_name,inquiry_access) values ('$access_name','$key','$inquiry_access')";
			$result=$db->Execute($sql); 
			if(!$result){
				 print $db->ErrorMsg();
				echo"<h1>$sql</h1>";
			}
		}
	}

	echo"
	Inquiry Access has been added/modified<P>
	<a href=$PHP_SELF>Return to index page</a>
	";


}elseif($act=='add' || $act=='update'){

	$_act=(!empty($id))?"do_update":"do_add";
	$access_name	=rawurldecode($access_name);

	if ($_act == "do_update") $f->checkaccess("edit");
	else if ($_act == "do_add") $f->checkaccess("add");

	$result=$db->Execute("select * from tbl_inquiry_access where access_name='$access_name'");
	$row=$result->FetchRow();
	if ($result->RecordCount()>0){
		foreach($row as $key=>$val){
			$key=strtolower($key);
			$$key=$val;
		}
	}

	echo"
	<form method=post name=f1>
	<input type=hidden name=act value=$_act>
	<input type=hidden name=id value=$id>
	<table class=index>
	<tr>
		<td bgcolor=ebebeb colspan=2><ximg src=../i/arrow.gif>&nbsp;<B><font color=>Access Name<BR>
		</td>
	</tr>
	<tr>	
		<td>Inquiry Access Name</b></td>
		<td><input type=text name=access_name value='$access_name' size=50 ".($act=='update'?"readonly":"")."></td>
	</tr>
	<tr>	
		<td width=200 valign=top>Access Level</b></td>
		<td valign=top>
		<table width=100%>";
		

		$access_array=array(
			"BK"		=>array("Yes"), 
			"OPD"		=>array("Yes"), 
			"TAPD"		=>array("Yes"),
			"BPKAD"		=>array("Yes")
		);


		foreach($access_array as $key => $val){
			$key_name=preg_replace("/[\s]+/","",$key);

			unset($read_access);
			unset($write_access);
			unset($delete_access);
			unset($row1);
			
			echo"
			<tr>
				<td>$key</td>
				<td>";


				$result=$db->Execute("select INQUIRY_ACCESS from tbl_inquiry_access where access_name='$access_name' and inquiry_name ='$key_name'");
				$row=$result->FetchRow();
				$inquiry_access=$row[INQUIRY_ACCESS];

				foreach($access_array[$key] as $key1){
					echo"<input type=checkbox name=\"".$key_name."[]\" value=\"$key1\" ";
					if(!empty($inquiry_access) && eregi("$inquiry_access",$key1)) echo" checked style=background-color:FFDD00;";
					echo">$key1 ";					
				}	

			echo"</td>
			</tr>
			";
		}

		echo"

		</table>
		</td>
	</tr>

	<tr>
		<td width=200>&nbsp;</td><td>
		<input type=button value='&laquo; Back' onClick=history.back(-1);>
		<input type=submit value=".(($act=='add')?"Add":"Update")." class=buttonhi></td>
	</tr>
	</table>
	</form>
	Note :<BR>
	<small><sup>(*)</sup>Required Information</small>
	";	
}else{

	if(!empty($query)){
		$query	= urldecode($query);
		$query	= strtolower(trim($query));
		$rel 	= !empty($cond)?"and":"where";
		$cond  .=" $rel category like '%$query%'";
	}

	$total = $f->count_total("tbl_inquiry_access group by access_name","$cond");

	$f->standard_buttons();	
	$f->search_box($query);
	$f->paging(array("link"=>$PHP_SELF."?order=$order&sort=$sort&type=$type&act=","page"=>$page,"total"=>$total,"num"=>"10","show_total"=>1));


	$sql="select access_name from tbl_inquiry_access $cond group by access_name order by $order $sort";
	$result=$db->SelectLimit("$sql","$num","$start");

	$_sort=($sort=='desc')?"asc":"desc";
	
	echo"
	<table class=index>
	<tr class=bgTitleTr>

		<th class=white width=5  valign=top><B>No</th>
		<th class=white  valign=top>Inquiry Access</th>
		 <th class=white  valign=top>Function</th>
	</tr>
	";
	while($val=$result->FetchRow()){
		$i++;
		$bgcolor= ($i%2)?"#FFDDDD":"FFFFFF";
		#echo"<pre>";
		#print_r($val);

		foreach($val as $key1 => $val1){
			$key1=strtolower($key1);
			$$key1=$val1;
		}
		echo"
		<tr bgcolor=$bgcolor>
			<td valign=top>".($i+$start)."</td>
			<td valign=top>$access_name</td>
			
			<td  valign=top>";
				echo"
				<a href=$PHP_SELF?act=update&access_name=".rawurlencode($access_name)."><img src=/images/button_edit.gif border=0></a><br><br>
				<a href=$PHP_SELF?act=delete&access_name=".rawurlencode($access_name)." onClick=\"javascript:return confirm('Are you sure to delete this record?');return false;\"><img src=../images/button_delete.gif border=0></a>";
			echo"</td>
		</tr>
		";
		
		unset($_status,$tp);
	}
	echo"
	</table>
	";
	$f->paging(array("link"=>$PHP_SELF."?order=$order&sort=$sort&status=$status&outlet_id=$outlet_id&outlet_query=$outlet_query&dealer_query=$dealer_query&act=","page"=>$page,"total"=>$total,"num"=>"10","show_total"=>1));

}
$t->basicfooter();
?>