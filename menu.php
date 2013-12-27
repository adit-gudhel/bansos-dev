<HTML>
<HEAD>
<title>Untitled Document</title>
<meta http-equiv=Content-Type content=text/html; charset=iso-8859-1>
<link href=prototipe.css rel=stylesheet type=text/css>
<link rel="StyleSheet" href="/dtree.css" type="text/css" />
<script type="text/javascript" src="/dtree.js"></script>

<xase target=main></HEAD>
<body>
<table width=95% border=0 align=center cellpadding=1 cellspacing=1 class=tablegrid>
<!--<tr>
	<td align=middle valign=top zgcolor=orange style=color:white;><img src=/i/menu.jpg></td>
</tr>-->
<tr>
	<td align=middle valign=top xlass=tdganjil>
	<table width=100% border=0 cellspacing=3 cellpadding=1>
	<tr valign=top>
		<td width=100%>
<?
#include("s/config.php");
$f->checkaccess();
$maintable="tbl_menu";

	echo"
	<div class=\"dtree\">	
	<script type=\"text/javascript\">
	<!--
	d = new dTree('d');
	d.add(0,-1,'HOME','/home.php','Home','');
	";


	$sql="select * from $maintable order by bobot";
	$result=$db->Execute($sql);
	while($row=$result->FetchRow()){
	
		foreach($row as $key => $val){
			$key=strtolower($key);
			$$key=$val;
			//echo $key." = ".$val."<br>";
		}

		$sql="select read_priv from tbl_functionaccess where name='$login_access' and menu_id='$nomorurut'";
		#echo"$sql";
		$resultcheck=$db->Execute($sql);
		if(!$resultcheck) print $db->ErrorMsg();
		$rowcheck=$resultcheck->FetchRow();
		
		$fua_read=$rowcheck['read_priv'];
		
		if($fua_read=='1'){

			if($nomorurut=='27'){ //daftar pekerjaan
				$jumlah=$f->count_total("wf_opkasus","where jnk_jeniskasuskode='ks-556' and
	                        idk_identifikasikode='ks-556-0' and kso_usersekarang='$login_nip' and kso_statuskasus='OPEN'");
				$jumlah="($jumlah)";
			}elseif($nomorurut=='43'){ //proggress-penanganan

				if($login_organisasi=='KWL'){ #TAMPILKAN DATA KANWIL & KPP!
		
					$sql="select ATK_ATTRIBUETNAMA,ATK_LOKASIDATA from wf_kasusattribute where jnk_jeniskasuskode='ks-556' and
        				       atk_attribuetnama in ('knm_kantorkode')";
        				$result_dynamic=$db->Execute($sql);
					if(!$result_dynamic) print $db->ErrorMsg();
					$row_dynamic	= $result_dynamic->FetchRow();
					$atk_lokasidata = $row_dynamic[atk_lokasidata];

					$cond .=" and kso_kasusnomor in (select kso_kasusnomor from wf_opkasusattribute where $atk_lokasidata in
					 (select knm_kantorkode from wf_kantormaster where knm_kantorkode='$login_kantor' or knm_parentkantor='$login_kantor'))";

				}elseif($login_organisasi=='KPP'){ #TAMPILKAN DATA KPP-NYA SAJA!
		
					$sql="select ATK_ATTRIBUETNAMA,ATK_LOKASIDATA from wf_kasusattribute where jnk_jeniskasuskode='ks-556' and
        			       atk_attribuetnama in ('knm_kantorkode')";
        				$result_dynamic=$db->Execute($sql);
					if(!$result_dynamic) print $db->ErrorMsg();
					$row_dynamic	= $result_dynamic->FetchRow();
					$atk_lokasidata = $row_dynamic[atk_lokasidata];
	
					$cond .=" and kso_kasusnomor in (select kso_kasusnomor from wf_opkasusattribute where $atk_lokasidata in
					 (select knm_kantorkode from wf_kantormaster where knm_kantorkode='$login_kantor') )";

				}

				$jumlah=$f->count_total("wf_opkasus","where jnk_jeniskasuskode='ks-556' and
	                        idk_identifikasikode='ks-556-0' $cond");
				$jumlah="($jumlah)";
			}elseif($nomorurut=='44'){ //knowledge-base
				$jumlah=$f->count_total("wf_lhp_knowledgebase","");
				$jumlah="($jumlah)";
			}elseif($nomorurut=='41'){
				$jumlah=$f->count_total("wf_opkasus","where jnk_jeniskasuskode='ks-557' and
				idk_identifikasikode='ks-557-0'");
				$jumlah="($jumlah)";
			}elseif($nomorurut=='25'){
				$jumlah=$f->count_total("wf_opkasus","where jnk_jeniskasuskode='ks-557' and
				idk_identifikasikode='ks-557-0' and kso_usersekarang='$login_nip'");
				$jumlah="($jumlah)";

			}			

			echo"d.add('$nomorurut','$referensi','$judul $jumlah','$url','$keterangan','$target','$image');\n";
			unset($jumlah);
		}

	}
	echo"
	document.write(d);
	//-->
	</script>
		<p><a href=\"javascript: d.openAll();\">open all</a> | 
		<a href=\"javascript: d.closeAll();\">close all</a><!-- | 
		<a href=menu.php>Refresh</a>--></p>
	</div>
	";
?>

		</td>
		</tr>
	</table>
	</td>
</tr>
</table>
</body>
</HTML>
