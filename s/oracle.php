<?
class oracle{

	var $user;
	var $pass;
	var $dbase;
	var $conn;
	var $kpp;

function oracle(){

	global $DOCUMENT_ROOT;
	include("$DOCUMENT_ROOT/s/config.php");
	$this->user=$dbusername;
	$this->pass=$dbpassword;
	$this->dbase=$dbname;
	$this->dbname=$dbname;
	$this->kpp=$kpp;
}

function error($text=""){
	echo OCIError();
	exit;

}

function init(){

	global $DOCUMENT_ROOT, $ADODB_SESSION_DRIVER, $ADODB_SESSION_CONNECT, $ADODB_SESSION_USER, $ADODB_SESSION_PWD, $ADODB_SESSION_DB, $ADODB_CACHE_DIR;

	$dbase=$this->dbase;
	$user=$this->user;
	$pass=$this->pass;

	//USING ADODB SESSION HANDLER
	$ADODB_SESSION_DRIVER	="oci8";    
	$ADODB_SESSION_CONNECT	="";    
	$ADODB_SESSION_USER		=$user;   
	$ADODB_SESSION_PWD		=$pass;    
	$ADODB_SESSION_DB		=$dbase;    
	$ADODB_CACHE_DIR		= "$DOCUMENT_ROOT/tmp/";

	include_once ("$DOCUMENT_ROOT/classes/adodb/adodb.inc.php");
	include_once ("$DOCUMENT_ROOT/classes/adodb/adodb-session-clob.php");

	session_start();

	$conn = OCILogon($user,$pass,$dbase);
	if(!$conn){

		$this->error("connection not establish");
	}

	$this->conn=$conn;
	return true;
}


function list_category($category_id=''){

	$sql="select * from tbl_category order by category asc";
	$stmt=OCIParse($this->conn,$sql);
	OCIExecute($stmt,OCI_DEFAULT);
	while(OCIFetchInto($stmt,&$arr,OCI_ASSOC+OCI_RETURN_NULLS)){
		$id	= $arr[ID];
		$category = $arr[CATEGORY];
		if($id == $category_id) $selected="selected";

		echo"<option value=$id $selected>$category\n";
		unset($selected);
	}
}

function auth($var){
	//	global $login_name;
	$msg="<h1> Anda tidak mempunyai otorisasi untuk melihat halaman ini !<BR><a href=/>Silahkan login dahulu</a></h1>";

	if(!$var[login_name]){
		echo $msg;die();


	}else{

		$sql="select password from tbl_user where login='".$var[login_name]."'";
		$stmt=OCIParse($this->conn,$sql);
		OCIExecute($stmt,OCI_DEFAULT);
		OCIFetch($stmt);
		if(OCIResult($stmt,'PASSWORD') == "$var[login_pass]"){
			return;
		}else{
			echo $msg;die();
		}
	}

}

function authmenu($var){
	//	global $login_name;
	$msg="<h1> Anda tidak mempunyai otorisasi untuk melihat halaman ini !<BR><a href=/>Silahkan login dahulu</a></h1>";

	if(!$var[login_name]){
		return false;


	}else{

		$sql="select password from tbl_user where login='".$var[login_name]."'";
		$stmt=OCIParse($this->conn,$sql);
		OCIExecute($stmt,OCI_DEFAULT);
		OCIFetch($stmt);
		if(OCIResult($stmt,'PASSWORD') == "$var[login_pass]"){
			return true;
		}else{
			return false;
		}
	}

}

function auth_admin($var){
	//	global $login_name;
	$msg="<h2> Anda tidak mempunyai otorisasi untuk melihat halaman ini !<BR><a href=/>Silahkan login dahulu</a></h2>";
	$msg1="<h2> Anda tidak mempunyai hak akses untuk melakukan tindakan pada halaman ini.<BR> Silahkan kontak administrator untuk informasi
		lanjut</h2>";

	if(!$var[login_name]){
		echo $msg;die();
	}else{

		$sql="select password from tbl_user where login='".$var[login_name]."'";
		$stmt=OCIParse($this->conn,$sql);
		OCIExecute($stmt,OCI_DEFAULT);
		OCIFetch($stmt);
		if(OCIResult($stmt,'PASSWORD') != "$var[login_pass]"){
			die($msg);
		}
		if(!preg_match("/$var[grup_name]/i",$var[access])){
	        	die($msg1);
		}
	}

}

function check_user_access($id){
	global $db;
	global $login_name;


	$msg = "<h2>Anda tidak diperbolehkan melakukan modifikasi data user lain.</h2>";
	$author_id=$this->convert_value(array("table"=>"tbl_article","cs"=>"AUTHOR_ID","cd"=>"id","vd"=>$id));
	$login_id=$this->convert_value(array("table"=>"tbl_user","cs"=>"id","cd"=>"login","vd"=>$login_name));
	#echo"<h1>$login_name;author_id:$author_id;login_id:$login_id;id:$id</h1>";
	if($author_id != $login_id) die($msg);
}

function paging($var){

        global $PHP_SELF;
        $link;

        if(!empty($var[order])) $order=ttime;
        $num    = $var[num];
        $page   = $var[page];
        $total  = $var[total];
        $category_id=$var[category_id];
        $show_total=$var[show_total];
	$link	=$var[link];

        $start  = ($page*$num)-$num;
        $word   = $var[word];
        $nomor  = $var[nomor];

        $paging=10; # jumlah link paging yang ditampilkan

        #jumlah link paging yang ditampilkan
        $paging=10;

        $bold= ($page == '0')?"1":$page;

        if($page <=0) $page=1;
        if($page != 1){
                echo"<a  href=$link&page=0>awal</a> | <a  href=$link&page=".($page-1).">&laquo;</a> ";
        }else{
                echo"awal | &laquo; ";
        }

        #jika halamannya bukan kelipatan 10 kita mulai dari kelipatan 10 paling kecil

        if(($page % $num == '0') && $page != '0') echo"<B>$page</B> ";

#       if(($page % $num) != '0'){

                if($page <10)                   $page = substr($page/10,0,0) ;
                if($page <100 && $page >= 10)   $page = substr($page/10,0,1)."0" ;
                if($page >=100 && $page < 1000) $page = substr($page/10,0,2)."0" ;
                if($page >=1000)                $page = substr($page/10,0,3)."0" ;
#       }
        for($pn=$page+1;$pn <= ($paging+$page) ;$pn++){

                if($pn == $bold){
                        echo"<B>$pn</b>&nbsp";
                }else{
                        echo "<a  href=\"$link&page=$pn\">$pn</a>&nbsp";
                }

#                if($pn > sprintf("%.0f\n",($total/$num)+0.5)-1)$pn=($paging+$page) ;
                if($pn >= sprintf("%.0f\n",ceil($total/$num))) $pn=($paging+$page+1) ;
        }

        if($pn >= $total/$num){
                echo" >> | ";
        }else{
                echo" <a  href=\"$link&page=".substr($pn,0,4)."\"  title=selanjutnya> &raquo;</a> |   ";
        }
        echo"<a  href=\"$link&page=".ceil($total/$num)."\">terakhir </a> ";
	if($var[show_total]) echo" - Total ".ceil($total/$num)." halaman";

}

function list_thpj($a1thpj_curr=""){
	global $db;
	$sql="select tahun A1THPJ from TBTAHUN order by tahun desc";
	$stmt=OCIParse($db->conn,$sql);
	OCIExecute($stmt,OCI_DEFAULT);
	while(OCIFetchInto($stmt,&$arr,OCI_ASSOC+OCI_RETURN_NULLS)){
		$a1thpj=$arr[A1THPJ];
		if($a1thpj == $a1thpj_curr) $selected='selected';
		echo"<option $selected>$a1thpj ";
		unset($selected);
	}
	OCIFreeStatement($stmt);

}

function count($var){
	global $db;
	global $mfnpwp;
	global $mfreg;

	$cond=$var[cond];
	if($var[profil] == '1'){
		$cond_profil=" and mfnpwp='$mfnpwp' and mfreg='$mfreg'";
	}
	$sql="select count(1) as X from $var[table] $cond "; #$cond_profil";
#	echo $sql."<P>";
	if($var[print_query]=='1') echo $sql."<P>";
	$stmt=OCIParse($db->conn,$sql);
	@OCIExecute($stmt,OCI_DEFAULT);
	@OCIFetch($stmt);
	$result= @OCIResult($stmt,'X');
	OCIFreeStatement($stmt);
	return number_format($result);
}

function count_sum($var,$option){
	global $db;
	$sql=$var[sql];
	if($var[print_query]=='1') echo $sql."<P>";
	$stmt=OCIParse($db->conn,$sql);
	OCIExecute($stmt,OCI_DEFAULT);
	OCIFetch($stmt);
	$X= OCIResult($stmt,'X');
	$Y= OCIResult($stmt,'Y');
	if($option=="X"){
		return $X;
	}else{
		return $Y;
	}
	OCIFreeStatement($stmt);
}
function sum($var){
	global $db;
	$cond=$var[cond];

	if($var[union]=='1'){
		$sql="select sum($var[field]) as X from $var[table1] union select sum($var[field]) as X from $var[table2] $cond";
	}elseif(!empty($var[sum])){
		$sql="select $var[sum] as X from $var[table] $cond";
	}else{
		$sql="select sum($var[field]) as X from $var[table] $cond";
	}

	//echo "SQL : $sql";

	if($var[print_query]=='1') echo $sql."<P>";
	$stmt=OCIParse($db->conn,$sql);
	OCIExecute($stmt,OCI_DEFAULT);# or die("<font color=red>SQL FAILED:$sql");
	OCIFetch($stmt);
	$result= OCIResult($stmt,'X');
	if($result < 1) $result =0;
	OCIFreeStatement($stmt);
	return $result;
}

function select($sql){
	global $db;
	$stmt=OCIParse($this->conn,$sql);
#	echo $sql;
	OCIExecute($stmt,OCI_DEFAULT) ;#or die("<font color=red>SQL FAILED:$sql");
	return $stmt;
}

function convert_value($var){
	global $db;
	$table	= $var[table];
	$cs	= strtoupper($var[cs]);
	$cd	= $var[cd];
	$vd	= $var[vd];
	$sql	= "select $cs from $table where $cd='$vd'";
	if($var[print_query]=="1") echo "$sql";
//	echo $sql;
	$stmt=@OCIParse($this->conn,$sql);
	@OCIExecute($stmt,OCI_DEFAULT);
	@OCIFetch($stmt);
	$result= @OCIResult($stmt,$cs);
	@OCIFreeStatement($stmt);
	return $result;
}

function check_length($var) {
	global $template;

	foreach ($var as $length=>$string) {
		if ( strlen($string) > $length ) {
			?>
			<table width=100% border=0 cellspacing=0 cellpadding=0>
			<tr> 
			<td align=left bgcolor=<?=$template->color5?> valign=top width=5><img src=/i/lc_top.gif width=4 height=4></td>
			<td width=100% bgcolor=<?=$template->color5?> style=padding-left:10px><img src=/i/icon_jadwal.gif> <b>Edit Data <?=$Pn?></b>
			</td>
			<td width=5 bgcolor=<?=$template->color5?> valign=top align=right><img src=/i/rc_top.gif width=4 height=4></td>
			</tr>
			<tr height=420>
			<td colspan=3 align=center bgcolor=<?=$template->color2?>>
			Nilai <b><?=$string?></b> melewati batas <b><?=$length?></b> karakter<br>
			<a href=javascript:history.go(-1)>kembali</a>
			</td>
			</tr>
			</table>
			<?
			exit();
		}
	}
}

function check_klu($var) {
	global $db, $template;

	$strSQL		= "SELECT count(1) as num FROM jenis_klu WHERE kd_klu='".$var['kd_klu']."'";
	$stmt 		=	@OCIParse($db->conn,$strSQL);
	OCIExecute($stmt,OCI_DEFAULT);
	OCIFetchInto($stmt,&$arr,OCI_ASSOC+OCI_RETURN_NULLS);

	if ($arr['NUM']<1) {
			?>
			<table width=100% border=0 cellspacing=0 cellpadding=0>
			<tr> 
			<td align=left bgcolor=<?=$template->color5?> valign=top width=5><img src=/i/lc_top.gif width=4 height=4></td>
			<td width=100% bgcolor=<?=$template->color5?> style=padding-left:10px><img src=/i/icon_jadwal.gif> <b>Edit Data <?=$Pn?></b>
			</td>
			<td width=5 bgcolor=<?=$template->color5?> valign=top align=right><img src=/i/rc_top.gif width=4 height=4></td>
			</tr>
			<tr height=420>
			<td colspan=3 align=center bgcolor=<?=$template->color2?>>
			Nilai Kode KLU salah.
			<a href=javascript:history.go(-1)>kembali</a>
			</td>
			</tr>
			</table>
			<?
			exit();
	}
}

}

?>