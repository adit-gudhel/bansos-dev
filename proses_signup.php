<?
ob_start();
session_start();
include("s/config.php");
$cfg_reff_table		="tbl_client";
$pri_key		= "cli_id";
$_primary_key		=$f->primary_key($pri_key);
$prefix_primary_key = "CLI";
$key_id		=$f->generate_nomorkolom("$cfg_reff_table","$pri_key","$prefix_primary_key");
$columns 	="$pri_key,";
$values	 	="'".$key_id."',";

	foreach($_POST as $key=>$val){
		$$key=$val;
	}
	function isValidEmail($email_perusahaan){
	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email_perusahaan);
	}
	
	if (trim($_POST[nm_perusahaan]) == '') {
	$error[] = '- Kolom nama perusahaan belum terisi. Silahkan diisi.';
	}
	if (trim($_POST[domain_perusahaan]) == '') {
	$error[] = '- Kolom domain perusahaan belum terisi. Silahkan diisi.';
	}
	if (trim($_POST[email_perusahaan]) == '') {
	$error[] = '- Kolom email perusahaan belum terisi. Silahkan diisi.';
	}
	if (trim($_POST[passwd]) == '') {
	$error[] = '- Kolom password belum terisi. Silahkan diisi.';
	}
	if (trim($_POST[tlp_perusahaan]) == '') {
	$error[] = '- Kolom telpon perusahaan belum terisi. Silahkan diisi.';
	}
	if (!(isValidEmail($_POST[email_perusahaan]))) {
	$error[] = '- Format email salah. Silahkan diisi dengan format yang benar.';
	}
	
	$total_p = $f->count_total("tbl_client","where lower(nm_perusahaan)=lower('$_POST[nm_perusahaan]')");
	if($total_p > 0)$error[] = '- Nama perusahaan sudah ada yang menggunakan. Silahkan menggunakan nama yang lain.';
		
	$total_e = $f->count_total("tbl_client","where lower(email_perusahaan)=lower('$_POST[email_perusahaan]')");
	if($total_e > 0)$error[] = "- Email sudah ada yang menggunakan. Silahkan menggunakan email yang lain.";
	 
	if (isset($error)) {
		echo '<b>Error</b>: <br />'.implode('<br />', $error);
	} else {

		foreach($HTTP_POST_VARS as $key=>$val){

			if(!preg_match("/^(act|ttd_id)$/i",$key)){

				$columns .="$key,";
				if(eregi("tgl|tanggal",$key)){
					$values .="str_to_date('$val','%d/%m/%Y'),";
				}elseif(eregi("passwd",$key)){
					$values .="md5('$val'),";
				}else{
					$values .="'$val',";
				}

			}elseif($act=='do_update' && !preg_match("/^(act)$/i",$key)){
				if(eregi("tgl|tanggal",$key)){
					$list .="$key=str_to_date('$val','%d/%m/%Y'),";
				}elseif(eregi("passwd",$key)){
					$values .="md5('$val'),";
				}else{
					$list .="$key='$val',";
				}
			}

		}
		$columns .="tgl_daftar,";
		$values  .="now()";
		
		$columns = preg_replace("/,$/","",$columns);
		$values	 = preg_replace("/,$/","",$values);
		$list	 = preg_replace("/,$/","",$list);
		$cond_primary_key = $f->primary_key($primary_key);

			$sql_insert	="insert into tbl_client  ($columns) values ($values)";
			$result=$db->Execute($sql_insert);
			if (!$result){
				print $db->ErrorMsg();
				die($sql_insert);
			}
			$sql	= "select email_perusahaan as username, passwd as password, nm_perusahaan, cli_id from tbl_client where email_perusahaan='$email_perusahaan' and passwd='$passwd'"; //die($sql);
			$resultdb = $f->get_last_record($sql);
			foreach($resultdb as $key => $val) $$key = $val;
			$_SESSION["nm_perusahaan"]=$nm_perusahaan;
			$_SESSION["email_perusahaan"]=$username;
			$_SESSION["cli_id"]=$cli_id;
			//$f->redirect("1", "menu.php", "<div align=center><img src=/i/loading.gif><br><br>Please wait, Loading Profile..</div>");
			echo "
			<script language=Javascript>
				window.open('/home.php','_parent');
			</script>
			";
			$f->insert_log("INSERT $title. $primary_key ".($$primary_key));
		
	}
?>