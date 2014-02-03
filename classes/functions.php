<?

class functions {

	function functions () {
	}

	/*==============================================================*
	*
	* fmtCase() :	Function to change assoc case, eg $row[id],
	*				$row[ID]. Especially for portability againts
	*				Oracle's Upper Case
	*
	*==============================================================*/

	function fmtCase($text) {
		global $assoc_case;

		if ($assoc_case == "lower") $newtext	= strtolower($text);
		else if ($assoc_case == "upper") $newtext	= strtoupper($text);
		return $newtext;

	}

	/*==============================================================*
	*
	* checkaccess() :	Function to check every access to php page
	*
	*==============================================================*/

	function checkaccess($restriction="all")  {

		global $db, $db, $_COOKIE, $sessionCookie, $username, $login_id, $login_username, $login_access, $login_access_detail, $HTTP_HOST, $t, $login_inquiry_access, $login_opd, $login_opd_nama, $login_full_name, $login_ip, $login_last_login;
		global $PHP_SELF;
		global $form_disableedit;
		global $form_disabledelete;
		global $form_disableadd;
		global $form_disableview;

		$current_page=strtolower($PHP_SELF);
		if (!$_SESSION[$sessionCookie]) {
			header("Location: /");
			exit();
		}

		//Execute the SQL Statement (Get Username)
		$strSQL		=	"SELECT * from tbl_session ".
		"WHERE session_id='".$_SESSION[$sessionCookie]."' ";
		#die($strSQL);
		$result		= $db->Execute($strSQL);
		if (!$result) print $db->ErrorMsg();
		$row = $result->FetchRow();


		if ($result->RecordCount() < 1) {
			//header("Location: /adminroom/index.php?act=login");
			echo "<img src=/images/warning.gif> Ada pengguna lain yang menggunakan login anda atau session Anda telah expired. <a href=/index.php?act=logout target=_top>Silahkan Login kembali</a>...";
			exit();
		}

		$login_username	= $row['username'];
		$last_access    = $row['last_access'];

		//Get User Information
		$strSQL		="SELECT u.access_level, u.id as id_exist, 
					u.full_name, u.inquiry_access, u.ip, u.last_login, u.opd_kode, l.access_detail  
					from tbl_user u, tbl_level l 
					WHERE u.username='$login_username' and u.access_level=l.access_level";
		#echo $strSQL;
		$result		= $db->Execute($strSQL);

		if (!$result) print $strSQL."<p>".$db->ErrorMsg();
		$row = $result->FetchRow();

		$login_access   			= $row['access_level'];
		
		$login_inquiry_access		= $row['inquiry_access'];
		$login_access_detail		= $row['access_detail'];
		$login_full_name			= $row['full_name'];
		$login_id					= $row['id_exist'];
		$login_ip   				= $row['ip'];
		$login_last_login			= $row['last_login'];
	
		if($row['opd_kode']!==0){
			 $login_opd = $row['opd_kode'];
			 
			 $strSQL2	= "SELECT opd_nama FROM tbl_opd WHERE opd_kode='$login_opd'";
			 $result2		= $db->Execute($strSQL2);	
			 if (!$result2) print $strSQL."<p>".$db->ErrorMsg();
			 $row2 = $result2->FetchRow();
			 
			 $login_opd_nama = $row2['opd_nama'];
		}

		/*=====================================================
		AUTO LOG-OFF 15 MINUTES
		======================================================*/

		//Update last access!
		$time= explode( " ", microtime());
		$usersec= (double)$time[1];

		$diff   = $usersec-$last_access;
		$limit  = 30*60;//harusnya 15 menit, tapi sementara pasang 60 menit/1 jam dahulu, biar gak shock
		if($diff>$limit){

			session_unset();
			session_destroy();
			//header("Location: /adminroom/index.php?act=login");
			echo "Maaf status anda idle lebih dari 30 menit dan session Anda telah expired. <a href=/session.php?act=logout target=_top>Silahkan Login kembali</a>...";
			exit();

		}else{
			$sql="update tbl_session set last_access='$usersec' where username='$login_username'";
			//echo $sql;
			$result         = $db->Execute($sql);
			if (!$result) print $db->ErrorMsg();
		}

		if($restriction != 'all'){
			$_restriction=strtolower($restriction."_priv");

			$sql="select $_restriction as check_access from tbl_functionaccess where name='$login_access' and url='$PHP_SELF'";
			//die($sql);
			$result         = $db->Execute($sql);
			if (!$result) print $db->ErrorMsg();
			$row		= $result->FetchRow();

			$check_access	= $row[check_access];
			if($check_access=='1') $access_granted="1";
			

		}else{
			$access_granted="1";
		}

		//Manage buttons to show or not
		$sql="select * from tbl_functionaccess where name='$login_access' and url='$PHP_SELF'";
		$result         = $db->Execute($sql);
		if (!$result) print $db->ErrorMsg();
		$row		= $result->FetchRow();

		if (count($row)>1) {
			foreach ($row as $key=>$val) {

				if ($key=="read_priv" && !$val) $form_disableview = true;
				else if ($key=="edit_priv" && !$val) $form_disableedit = true;
				else if ($key=="delete_priv" && !$val) $form_disabledelete = true;
				else if ($key=="add_priv" && !$val) $form_disableadd = true;
			}
		} else {

			$form_disableview = true;
			$form_disableedit = true;
			$form_disabledelete = true;
			$form_disableadd = true;
		}

		if ($access_granted == 0) {
			//$t->htmlHeader();
			echo "<p>";
			$t->message("Illegal Access!","javascript:history.go(-1)");
			//$t->htmlFooter();
			exit();
		}

		$result->Close();
	}

	function checkinquiryaccess($inquiry_name="",$inquiry_access){
		global $db;
		global $login_access;
		global $login_inquiry_access;
		global $t;
		global $_COOKIE;

		//print_r($_COOKIE);

		$access_granted = 0;
		if($restriction=='all') $access_granted="1";

		$sql="select inquiry_access from tbl_inquiry_access where access_name='$login_access' and inquiry_name='$inquiry_name'";
		//echo $sql;
		$result         = $db->Execute($sql);
		if (!$result) print $db->ErrorMsg();
		$row=$result->FetchRow();
		$_inquiry_access=$row[inquiry_access];
		if(!empty($_inquiry_access) && eregi("$_inquiry_access",$inquiry_access)){
			$access_granted="1";
		}else{

		}

		if ($access_granted == 0) {
			echo"Illegal Inquiry Access!";
			exit();
		}


	}

	function getinquiryaccess($inquiry_name=""){
		global $db;
		global $login_access;
		global $login_inquiry_access;
		global $t;
		global $_COOKIE;

		//print_r($_COOKIE);

		$access_granted = 0;
		if($restriction=='all') $access_granted="1";

		$sql="select inquiry_access from tbl_inquiry_access where access_name='$login_access' and inquiry_name='$inquiry_name'";
		//echo $sql;
		$result         = $db->Execute($sql);
		if (!$result) print $db->ErrorMsg();
		$row=$result->FetchRow();
		$_inquiry_access=$row[inquiry_access];
		return $_inquiry_access;
	}


	function checkaccesswrite($restriction="all"){
		global $db;
		global $login_access;
		global $t;

		$access_granted = 0;
		if($restriction=='all') $access_granted="1";
		/*
		$sql="select write_access from tbl_access_option where access_level_id='$login_access' and privillege_name='$restriction'";
		$result         = $db->Execute($sql);
		if (!$result) print $db->ErrorMsg();
		$row=$result->FetchRow();
		$write_access=$row[WRITE_ACCESS];
		if($write_access=='1') $access_granted="1";


		if ($access_granted == 0) {
		$t->htmlHeader();
		$t->message("Illegal Access!","javascript:history.go(-1)");
		$t->htmlFooter();
		exit();
		}
		*/

	}

	function checkaccessdelete($restriction="all"){
		global $db;
		global $login_access;
		global $t;
		$access_granted = 0;
		if($restriction=='all') $access_granted="1";

		$sql="select delete_access from tbl_access_option where access_level_id='$login_access' and privillege_name='$restriction'";
		$result         = $db->Execute($sql);
		if (!$result) print $db->ErrorMsg();
		$row=$result->FetchRow();
		$delete_access=$row[DELETE_ACCESS];
		if($delete_access=='1') $access_granted="1";


		if ($access_granted == 0) {
			$t->htmlHeader();
			$t->message("Illegal Access!","javascript:history.go(-1)");
			$t->htmlFooter();
			exit();
		}


	}

	/*==============================================================*
	*
	* parseMenuList() : Function to show menu list on MenuMaker.php
	*					 menu list
	*
	*==============================================================*/

	function parseMenuList($level, $under) {

		global $db, $i, $data;

		$data .= "<ul>\n";

		++$i;
		$resultname = "result$i";

		$strSQL			= "SELECT * from tbl_menu WHERE ((lvl=$level) and (under=$under)) order by menuorder asc";
		$$resultname	= $db->Execute($strSQL);
		if (!$$resultname) print $db->ErrorMsg();

		// Display Query
		while ($row = $$resultname->FetchRow())
		{

			$id		= $row[$this->fmtCase('id')];
			$name	= $row[$this->fmtCase('name')];
			$level	= $row[$this->fmtCase('lvl')];
			$under	= $row[$this->fmtCase('under')];
			$order	= $row[$this->fmtCase('menuorder')];

			// Execute the Statement
			++$j;
			$resultname2 = "result2level$j";
			$checklevel = $level + 1;

			$strSQL			= "SELECT * from tbl_menu WHERE lvl='$checklevel' and under='$id'";
			$$resultname2	= $db->Execute($strSQL);
			if (!$$resultname2) print $db->ErrorMsg();


			$nextparse = "next parseOrganization($checklevel, $id)";

			if ($$resultname2->RecordCount() < 1) {
				$nextparse = "no organization under";
			}

			$data .= "<li><b>$name</b> ( order : $order )     [ <a href=?act=edit&id=$id>edit</a> ] [ <a href=?act=delete&id=$id>hapus</a> ]</li>\n";

			if ($$resultname2->RecordCount() > 0) {
				$this->parseMenuList($checklevel, $id);
			}

		}
		$data .= "</ul>\n";
	}


	/*==============================================================*
	*
	* parseMenu() :	Function to show menu on  left Frame
	*
	*==============================================================*/

	function parseMenu($level, $under) {

		global $db, $i, $data, $access, $departement, $lastClickMenuCookie;

		++$i;
		$resultname = "result$i";

		$strSQL			= "SELECT * from tbl_menu WHERE ((lvl='$level') and (under='$under')) order by menuorder asc";
		$$resultname	= $db->Execute($strSQL);
		if (!$$resultname) print $conn->ErrorMsg();


		// Display Query
		while ($row = $$resultname->FetchRow())
		{

			$id					= $row[$this->fmtCase('id')];
			$name				= $row[$this->fmtCase('name')];
			$level				= $row[$this->fmtCase('lvl')];
			$under				= $row[$this->fmtCase('under')];
			$link				= $row[$this->fmtCase('link')];
			$target				= $row[$this->fmtCase('target')];
			//$menu_departement	= $row[$this->fmtCase('departement')];
			$menu_access		= $row[$this->fmtCase('menuaccess')];

			//$data .= "<option value=\"$id\">";

			if ($this->checkMenuAccess($menu_access) == 1) {

				if ($under==0) unset($under);

				// Execute the Statement
				++$j;
				$resultname2 = "result2level$j";
				$checklevel = $level + 1;

				$strSQL			= "SELECT * from tbl_menu WHERE lvl='$checklevel' and under='$id'";
				$$resultname2	= $db->Execute($strSQL);
				if (!$$resultname2) print $db->ErrorMsg();

				$name = str_replace(" ", " ", $name);
				mt_srand((double)microtime()*1000000);
				$randomVal = mt_rand(1000,9999999999);

				if ($$resultname2->RecordCount() > 0) {

					$data .= "menu".$under.".addItem(\"".$name."\");\n";
					$data .= "var menu".$id." = null;\n";
					$data .= "menu".$id." = new MTMenu();\n";

				}

				else if ( !empty($link) ) {

					$data .= "menu".$under.".addItem(\"".$name."\", \"".$link."\", \"".$target."\");\n";

				}

				else {

					$data .= "menu".$under.".addItem(\"".$name."\");\n";

				}


				if (($$resultname2->RecordCount() > 0)) {
					$this->parseMenu($checklevel, $id);

					$data .= "menu".$under.".makeLastSubmenu(menu".$id.");\n";

				}

			}
		}
	}


	function parseMenuOld($level, $under) {

		global $db, $i, $data, $access, $departement;

		++$i;
		$resultname = "result$i";

		$strSQL			= "SELECT * from tbl_menu WHERE ((lvl='$level') and (under='$under')) order by menuorder asc";
		$$resultname	= $db->Execute($strSQL);
		if (!$$resultname) print $conn->ErrorMsg();

		// Display Query
		while ($row = $$resultname->FetchRow())
		{

			$id					= $row[$this->fmtCase('id')];
			$name				= $row[$this->fmtCase('name')];
			$level				= $row[$this->fmtCase('lvl')];
			$under				= $row[$this->fmtCase('under')];
			$link				= $row[$this->fmtCase('link')];
			$target				= $row[$this->fmtCase('target')];
			$menu_departement	= $row[$this->fmtCase('departement')];
			$menu_access		= $row[$this->fmtCase('menuaccess')];

			//$data .= "<option value=\"$id\">";

			if ($this->checkMenuAccess($menu_access) == 1) {

				for ($i=1; $i < $level; ++$i) {
					$data .= "<img src=i/icon_blank.gif border=0>";
				}

				// Execute the Statement
				++$j;
				$resultname2 = "result2level$j";
				$checklevel = $level + 1;

				$strSQL			= "SELECT * from tbl_menu WHERE lvl='$checklevel' and under='$id'";
				$$resultname2	= $db->Execute($strSQL);
				if (!$$resultname2) print $db->ErrorMsg();

				$name = str_replace(" ", " ", $name);
				$showname = $name;
				mt_srand((double)microtime()*1000000);
				$randomVal = mt_rand(1000,9999999999);

				if ( $this->checkExpanded($id) == 1 ) {
					$imgIcon = "<a href=?act=setColapse&setID=$id&randomVal=$randomVal><img src=i/icon_colapse.gif 	border=0></a>";
					$showname = "<a href=?act=setColapse&setID=$id&randomVal=$randomVal>".$name."</a>";
				}
				else {
					$imgIcon = "<a href=?act=setExpand&setID=$id&randomVal=$randomVal><img src=i/icon_expand.gif border=0></a>";
					$showname = "<a href=?act=setExpand&setID=$id&randomVal=$randomVal>".$name."</a>";
				}

				if ($$resultname2->RecordCount() < 1) {
					$imgIcon = "<img src=i/icon_notexpandable.gif border=0>";
					$showname = $name;
				}
				$_randomVal = (preg_match("/\?/",$link))?"&$randomVal=$randomVal":"?randomVal=$randomVal";
				if ( !empty($link) ) $showname = "<a href=".$link."$_randomVal target=".$target.">".$name."</a>";

				$data .= "$imgIcon $showname <br>\n";
				#				if (($$resultname2->RecordCount() > 0) and ($this->checkExpanded($id) == 1)) {

				$this->parseMenuOld($checklevel, $id);
				#				}
			}
		}
	}

	/*==============================================================*
	*
	* checkExpanded() : Function to check whether a menu has been
	*					 expanded or not
	*
	*==============================================================*/

	function checkExpanded($under) {

		global $expandedMenuCookie;
		$cookieData = explode("|",$expandedMenuCookie);

		for($i=0;$i<count($cookieData);$i++) {

			if ( $cookieData[$i] == $under ) $expandedChecked = 1;

		}

		return $expandedChecked;
	}


	/*==============================================================*
	*
	* checkMenuAccess() : Function to check accessible menu
	*
	*==============================================================*/

	function checkMenuAccess($menu_access) {
		global $login_name,$login_access;
		global $f;

		#$useraccess=$f->convert_value(array("table"=>"tbl_user","cs"=>"access","cd"=>"username","vd"=>$login_name));
		$useraccess=$login_access;
		if (!$menu_access){
			$menuAccessChecked= ($useraccess ==4)?"1":"0";
		}

		$Data = explode("|",$menu_access);

		for($i=0;$i<count($Data);$i++) {
			if ( trim($Data[$i]) == trim($useraccess) ) $menuAccessChecked = 1;
		}
		return $menuAccessChecked;
	}


	/*==============================================================*
	*
	* menuLadder() : Function to get menu's predecessors
	*				  eg. menu1 - menu2 - menu3 on menuMaker.php
	*
	*==============================================================*/

	function menuLadder($id) {
		global $db, $ladder, $parsetimes;
		$strSQL			= "SELECT * from tbl_menu WHERE id='$id'";

		$result			= $db->Execute($strSQL);
		if (!$result)	print $conn->ErrorMsg();

		$row	= $result->FetchRow();
		$id		= $row[$this->fmtCase('id')];
		$name	= $row[$this->fmtCase('name')];
		$level	= $row[$this->fmtCase('lvl')];
		$under	= $row[$this->fmtCase('under')];

		$level += 1;

		$ladder = $name." - ".$ladder;
		if(empty($id)) $id='2343434';
		//Check Tree Climbing
		$strSQL			= "SELECT * from tbl_menu WHERE id='$id'";
		$result			= $db->Execute($strSQL);
		if (!$result)	print $db->ErrorMsg();
		#		echo $strSQL."<BR>";
		if ($result->RecordCount() > 0) {
			$underdata = $row[$this->fmtCase('under')];

			if ($underdata > 0) {
				$this->menuLadder($underdata);
			}
		}

	}

	/*==============================================================*
	*
	* createPaging() : Function to create paging
	*
	*==============================================================*/

	function createPaging($table,$cond="",$id="") {

		global $db, $start, $num, $pageFrom, $pageNum, $query, $field;

		if (strlen($cond)) $condString= "WHERE ".$cond;

		$strSQL		= "SELECT * from $table $condString ";
		$result		= $db->Execute($strSQL);
		if (!$result) print $db->ErrorMsg();
		$totalData	= $result->RecordCount();

		$totalPage	= ceil($totalData/$num);
		$sisa		= $totalPage - $pageFrom;

		if ( $sisa < $pageNum ) $pageTo = $pageFrom + $sisa; else $pageTo = $pageFrom + $pageNum;

		if ( ($pageFrom - $pageNum) < 0 ) $pageBefore = 0; else $pageBefore = $pageFrom - $pageNum;
		if ( ($pageFrom + $pageNum) > ($totalPage - $pageNum) ) $pageNext = $totalPage - $pageNum; else $pageNext = $pageFrom + $pageNum;
		if ( $pageNext < 0 ) $pageNext = 0;

		if ( ($totalPage-$pageNum)<0 ) $pageLast = 0; else $pageLast = $totalPage-$pageNum;

		for ($i=$pageFrom; $i<$pageTo; ++$i)  {
			$page_i = $i + 1;
			$next_i = $i * $num;
			if ($next_i == $start) {
				$page .= " <a href=$PHP_SELF?act=list&start=$next_i&num=$num&pageFrom=$pageFrom&pageNum=$pageNum&id=$id&query=".rawurlencode($query)."&field=$field><b>$page_i</b></a> ";
			} else {
				$page .= " <a href=$PHP_SELF?act=list&start=$next_i&num=$num&pageFrom=$pageFrom&pageNum=$pageNum&id=$id&query=".rawurlencode($query)."&field=$field>$page_i</a> ";
			}
		}

		$final =	"<a 		href=$PHP_SELF?act=list&start=0&num=$num&pageFrom=0&pageNum=$pageNum&id=$id&query=".rawurlencode($query)."&field=$field>awal</a>".
		" | <a href=$PHP_SELF?act=list&start=".($pageBefore*$num)."&num=$num&pageFrom=$pageBefore&pageNum=$pageNum&id=$id&query=".rawurlencode($query)."&field=$field><<</a> ".
		$page.
		" <a href=$PHP_SELF?act=list&start=".($pageNext*$num)."&num=$num&pageFrom=$pageNext&pageNum=$pageNum&id=$id&query=".rawurlencode($query)."&field=$field>>></a> | ".
		"<a href=$PHP_SELF?act=list&start=".(($totalPage-1)*$num)."&num=$num&pageFrom=".$pageLast."&pageNum=$pageNum&id=$id&query=".rawurlencode($query)."&field=$field>akhir</a>";

		return $final;
	}



	/*==============================================================*
	*
	* createPagingCustom() : Function to create paging
	* Customised for Absensi
	*
	*==============================================================*/

	function createPagingCustom($table,$cond="",$nik="") {

		global $db, $start, $num, $pageFrom, $pageNum, $query, $field;

		if (strlen($cond)) $condString= "WHERE ".$cond;

		$strSQL		= "SELECT * from $table $condString ";
		$result		= $db->Execute($strSQL);
		if (!$result) print $db->ErrorMsg();
		$totalData	= $result->RecordCount();

		$totalPage	= ceil($totalData/$num);
		$sisa		= $totalPage - $pageFrom;

		if ( $sisa < $pageNum ) $pageTo = $pageFrom + $sisa; else $pageTo = $pageFrom + $pageNum;

		if ( ($pageFrom - $pageNum) < 0 ) $pageBefore = 0; else $pageBefore = $pageFrom - $pageNum;
		if ( ($pageFrom + $pageNum) > ($totalPage - $pageNum) ) $pageNext = $totalPage - $pageNum; else $pageNext = $pageFrom + $pageNum;
		if ( $pageNext < 0 ) $pageNext = 0;

		if ( ($totalPage-$pageNum)<0 ) $pageLast = 0; else $pageLast = $totalPage-$pageNum;

		for ($i=$pageFrom; $i<$pageTo; ++$i)  {
			$page_i = $i + 1;
			$next_i = $i * $num;
			if ($next_i == $start) {
				$page .= " <a href=$PHP_SELF?act=list&start=$next_i&num=$num&pageFrom=$pageFrom&pageNum=$pageNum&nik=$nik&query[]=".rawurlencode($query)."&field[]=$field><b>$page_i</b></a> ";
			} else {
				$page .= " <a href=$PHP_SELF?act=list&start=$next_i&num=$num&pageFrom=$pageFrom&pageNum=$pageNum&nik=$nik&query[]=".rawurlencode($query)."&field[]=$field>$page_i</a> ";
			}
		}

		$final =	"<a 		href=$PHP_SELF?act=list&start=0&num=$num&pageFrom=0&pageNum=$pageNum&nik=$nik&query[]=".rawurlencode($query)."&field[]=$field>awal</a>".
		" | <a href=$PHP_SELF?act=list&start=".($pageBefore*$num)."&num=$num&pageFrom=$pageBefore&pageNum=$pageNum&nik=$nik&query[]=".rawurlencode($query)."&field[]=$field><<</a> ".
		$page.
		" <a href=$PHP_SELF?act=list&start=".($pageNext*$num)."&num=$num&pageFrom=$pageNext&pageNum=$pageNum&nik=$nik&query[]=".rawurlencode($query)."&field[]=$field>>></a> | ".
		"<a href=$PHP_SELF?act=list&start=".(($totalPage-1)*$num)."&num=$num&pageFrom=".$pageLast."&pageNum=$pageNum&nik=$nik&query[]=".rawurlencode($query)."&field[]=$field>akhir</a>";

		return $final;
	}


	/*==============================================================*
	*
	* selectList() : Function to create Select Box List
	*		$name	: name of variable passed through htmlpost
	*		$table	: name of table of DB where the list is taken
	*
	*==============================================================*/
      
	function selectList($name,$table,$option_name,$value_name,$curr_id,$script="",$cond="",$empty_option=0,$empty_value="",$empty_str="") {

		global $db, $db;

		$output		 = "<select name=\"$name\" id=\"$name\" $script>\n";
		if ($empty_option) $output		.= "<option value=\"$empty_value\">$empty_str</option>\n";

		if(eregi("\|",$curr_id)){
			$curr_id_array=split("\|",$curr_id);
		}

		if(eregi("\|",$value_name)){
			$value_array=split("\|",$value_name);
			$value_query=preg_replace("#\|#",",",$value_name);
		}else{
			$value_query=$value_name;
			#echo"<h1>value: $value_query | $value_name</h1>";
		}
		$value_query=preg_replace("#,$#","",$value_query);

		$sql="select $option_name,$value_query from ".$table." $cond";
        
		$result = $db->Execute("$sql");
		if (!$result){
			echo"$sql";
			print $conn->ErrorMsg();

		}
		while ( $row = $result->FetchRow() ) {
			//echo $curr_id."|".$row[$this->fmtCase($option_name)]."<br>\n";
			if(eregi("\|",$curr_id)){
				$selected= ((in_array($row[$this->fmtCase($option_name)],$curr_id_array))?"selected ":"");
			}
			else {
				$selected= (($curr_id==$row[$this->fmtCase($option_name)])?"selected ":"");
			}
			if(eregi("\|",$value_name)){

				for($i=0;$i<count($value_array);$i++){
					$each_value=strtolower($value_array[$i]);
					$_value .= $row[$each_value]." -";
				}
				$_value=preg_replace("#-$#","",$_value);
			}else{
				$value_name=strtolower($value_name);
				$_value=$row[$value_name];
			}


			$output .= "<option value=\"".$row[$this->fmtCase($option_name)]."\" $selected>$_value</option>\n";
			unset($selected);
			unset($_value);
		}
		$result->Close();

		$output .= "</SELECT>\n";

		return $output;
	}
	function selectList2($name,$table,$option_name,$value_name1,$value_name2,$curr_id,$script="",$cond="") {

		global $db;

		$output		 = "<SELECT NAME=$name $script>\n";
		$output		.= "<option></option>\n";
		$cond=" order by $value_name2 ";
		$sql="select $value_name1,$value_name2,$option_name from ".$table." $cond";
		#echo"$sql";
		$result = $db->Execute("$sql");
		if (!$result){
			print $conn->ErrorMsg();
			echo"$sql";
		}
		while ( $row = $result->FetchRow() ) {
			$selected= (($curr_id==$row[$this->fmtCase($option_name)])?"selected":"");
			$value_name="$value_name1 - $value_name2";
			$output .= "<option value=\"".$row[$this->fmtCase($option_name)]."\" $selected>"
			.$row[$this->fmtCase("$value_name2")]." ("
			.$row[$this->fmtCase("$value_name1")]." )
			 </option>\n";
			unset($selected);
		}
		$result->Close();

		$output .= "</SELECT>\n";

		return $output;
	}
	/*==============================================================*
	*
	* selectListArray() : Function to create Select Box List
	*					   from Array
	*
	*==============================================================*/

	function selectListArray($name,$array,$curr_id,$script="",$empty_option=0) {

		$output		 = "<select name=\"$name\" id=\"$name\" $script>\n";
        if ($empty_option) $output		.= "<option></option>\n";

		foreach ($array as $key=>$val) {
			$output .= "<option value=\"".$key."\" ".
			(($curr_id == $key)?"selected":"").">".$val."</option>\n";
		}

		$output .= "</SELECT>\n";

		return $output;
	}

	/*==============================================================*
	*
	* selectCheckBox() : Function to create Check Box
	*					   from Array - Created By Hardyboyz
	*
	*==============================================================*/

	function selectCheckBox($name,$table,$option_name,$value_name,$curr_id,$script="",$cond="",$empty_option=0) {

		global $db, $db;

		if(preg_match("/\|/",$curr_id)) {
			$curr_id_array=split("\|",$curr_id);
		}

		$sql="select $option_name,$value_name from ".$table." $cond";
		#die($sql);
		$result = $db->Execute("$sql");
		if (!$result){
			echo"$sql";
			print $db->ErrorMsg();

		}
		$output = "<table >";
		while ( $row = $result->FetchRow() ) {
			#echo $curr_id."|".$row[$this->fmtCase($option_name)]."<br>\n";
			$selected = "";
			if(preg_match("/\|/",$curr_id)){
				$selected = ((preg_match("/\|".$row[$this->fmtCase($option_name)]."\|/",$curr_id))?"checked ":"");
				#echo $selected."#/|".$row[$this->fmtCase($option_name)]."|/#$curr_id<br>";
			}
			else {
				$selected = (($curr_id==$row[$this->fmtCase($option_name)])?"checked ":"");
			}

			$output .= "<tr><td valign=top><input type='checkbox' name=\"$name\" id=\"$name\" value=\"".$row[$this->fmtCase($option_name)]."\" $selected></td><td>".$row[$this->fmtCase($value_name)]."</td></tr>";
			unset($selected);
			unset($_value);
		}
		$result->Close();

		$output .= "</table>";

		return $output;
	}


	/*==============================================================*
	*
	* searchFieldArray() : Function to create Search Form
	*					   from Array
	*
	*==============================================================*/

	function searchFieldArray($option_name,$value_name) {

		global $t;

		for ($i=0; $i<count($option_name); $i++) {

			$output .= "<tr bgcolor=$t->tableColor>
						<td>".$value_name[$i]."</td>
						<td><input type=\"text\" name=\"query[]\"><input type=\"hidden\" name=\"field[]\" value=\"".$option_name[$i]."\"></td>
						</tr>";
		}
		return $output;
	}

	/*==============================================================*
	*
	* processSearch() : Function to process search strings
	*
	*==============================================================*/

	function processSearch($queryArr, $fieldArr) {

		global $query, $field, $condSQL;

		if ( count($queryArr) > 0 ) {
			for ( $i=0; $i<count($queryArr); $i++ ) {
				if (!empty($queryArr[$i])) {
					$searchSQL .= "lower($fieldArr[$i]) like '%".strtolower($queryArr[$i])."%' and ";
					if ( !$query_value ) $query_value = $queryArr[$i];
					if ( !$field_value ) $field_value = $fieldArr[$i];
				}
			}
			if ( !empty($searchSQL) ) {
				$searchSQL	= substr($searchSQL, 0, -5);
				if (!empty($condSQL)) $condSQL	= $condSQL."and ".$searchSQL; else $condSQL = $searchSQL;
			}
		}
		$query	= $query_value;
		$field	= $field_value;

	}



	/*==============================================================*
	*
	* loopTime() : Function to create
	*				Year/Month/Date/Hour/Minutes/second
	*				Select Box List
	*
	*		$date_comp : Y|m|d|H|i|s refer to date function
	*
	*==============================================================*/

	function loopTime($variable_default,$variable_name,$date_comp,$start,$end,$current='',$script=''){

		$showname = substr($variable_name,0,3);

		$output		 = "$showname <select name=$variable_default"."_"."$variable_name $script>\n";
		$output		.= "<option></option>\n";
		for($i=$start;$i<=$end;$i++){

			$x= ($i < 10)?"0$i":"$i";

			if(strlen($current)){
				if($current==$x) $selected="selected";
			}
			$output .= "<option value=$x $selected>$x</option>\n";
			unset($selected,$x);
		}
		$output .= "</select> \n";
		return $output;
	}

	/*==============================================================*
	*
	* escByteA() : Function to Escape binary data before insertion
	*				for PostgreSQL
	*
	*==============================================================*/

	function escByteA($binData) {
		/**
		* \134 = 92 = backslash, \000 = 00 = NULL, \047 = 39 = Single Quote
		*
		* str_replace() replaces the searches array in order.
		* Therefore, we must
		* process the 'backslash' character first. If we process it last, it'll
		* replace all the escaped backslashes from the other searches that came
		* before. tomATminnesota.com
		*/
		$search = array(chr(92), chr(0), chr(39));
		$replace = array('\\\134', '\\\000', '\\\047');
		$binData = str_replace($search, $replace, $binData);
		return $binData;
	}


	/*==============================================================*
	*
	* setSetting($variable, $value) :
	*			Function save setting on tbl_setting
	*
	*==============================================================*/

	function setSetting ($variable, $value) {
		global $db, $t;

		$strSQL		= "UPDATE tbl_setting SET value='$value' WHERE variable='$variable'";
		$result		= $db->Execute($strSQL);
		if (!$result) print $db->ErrorMsg();

	}



	/*==============================================================*
	*
	* getName($id, $query)
	*	Function to get $query name
	*
	*==============================================================*/

	function getName($id, $query) {

		global $db, $f;

		$strSQL		= "SELECT
					nama 
				   FROM
				   	tbl_".$query." 
				   WHERE
				   	id = $id";

		$result         = $db->Execute($strSQL);
		if (!$result)   print $db->ErrorMsg();
		$row    	= $result->FetchRow();

		$nama	= $row[$f->fmtCase('nama')];

		return $nama;
	}
	function boxTitleSection($msg){
		global $t;
		echo"
                <table border=0 align=center cellpading=5 cellspacing=1 width=100% bgcolor=$t->tableLine>
                <tr>
                        <td>$msg
                        </td>

                </tr>
                </table>
                ";
	}

	function convert_value($var){

		//cs = column search
		//cd = column define
		//vd = value define
		//

		global $db,$f;
		$table =$var["table"];
		$vd=strtolower($var["vd"]);
		$cd=$var["cd"];
		$cs=$var["cs"];
		$print_query=$var["print_query"];

		$sql = "select $cs as x from $table where $cd ='$vd'";

		if($print_query=='1') echo $sql;

		$result         = $db->Execute($sql);

		if (!$result){
			echo $sql;
			print $db->ErrorMsg();
		}
		$row            = $result->FetchRow();
		$new_value      = $row[$f->fmtCase('x')];
		return $new_value;
	}

	function convert_value1($var){

		//cs = column search
		//cd = column define
		//vd = value define
		//

		global $db,$f;
		$table =$var["table"];
		$vd=strtolower($var["vd"]);
		$cd=$var["cd"];
		$cs=$var["cs"];

		$sql = "select $cs as x from $table where $cd ='$vd'";
		if($var[print_query]=="1") echo $sql;
		$result      = $db->Execute($sql);
		if (!$result)   print $db->ErrorMsg();
		$row            = $result->FetchRow();
		$new_value      = $row[$f->fmtCase('x')];
		return $new_value;
	}

	function total($var){

		//table = table
		//column = column
		global $db,$f;
		$table =$var[table];
		$column= (!empty($var[column]))?"$var[column]":"id";

		$sql = "select count(1) as x from $table";
		if($var[print_query]=='1')echo $sql;
		$result         = $db->Execute($sql);
		if (!$result)   print $db->ErrorMsg();
		$row            = $result->FetchRow();
		$new_value      = $row[$f->fmtCase('x')];
		return $new_value;
	}
	function max_id($var){

		//table = table
		//column = column
		global $db,$f;
		$table =$var[table];
		$column= (!empty($var[column]))?"$var[column]":"id";

		$sql = "select max($column) as x from $table";
		if($var[print_query]=='1')echo $sql;
		$result         = $db->Execute($sql);
		if (!$result)   print $db->ErrorMsg();
		$row            = $result->FetchRow();
		$new_value      = $row[$f->fmtCase('x')];
		return $new_value;
	}

	/*==============================================================*
	*
	* getTransactionStatusName($id)
	*      Function to get Status name
	*
	*==============================================================*/

	function getTransactionStatusName($id){
		$statusArr	= array(1=>"Requested", 2=>"Recharged");
		$statusName	= $statusArr[$id];

		return $statusName;

	}

	function paging($var){

		global $PHP_SELF;
		if(!empty($var[order])) $order=ttime;
		$num    = $var[num];
		$page   = $var[page];
		$total  = $var[total];
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
			$output .="<a href=$link&page=1>First </a>  <a  href=$link&page=".($page-1)." title='Previous Page'> &laquo;</a> ";
			#$output .="<font class=darkorange style=font-size:11px>
			#<a  href=$link&page=".($page-1)." class=darkorange><< PREVIOUS</a>   ";
		}else{
			$output .="First  &laquo; ";
			#$output .="<font class=darkorange style=font-size:11px;><< PREVIOUS</a>   ";
		}
		#$output .="<h1>Page:$page</h1>";
		#jika halamannya bukan kelipatan 10 kita mulai dari kelipatan 10 paling kecil

		if(($page % $paging == '0') && $page != '0') $output .="<B>$page</B> ";


		if($page <10)                   $page = substr($page/10,0,0) ;
		if($page <100 && $page >= 10)   $page = substr($page/10,0,1)."0" ;
		if($page >=100 && $page < 1000) $page = substr($page/10,0,2)."0" ;
		if($page >=1000)                $page = substr($page/10,0,3)."0" ;

		for($pn=$page+1;$pn <= ($paging+$page) ;$pn++){

			if($pn == $bold){
				$output .="<font class=darkorange><B>$pn</b>&nbsp</font>";

			}else{
				$output .= "<a  href=\"$link&page=$pn\" class=darkorange>$pn</a>&nbsp";
			}

			#                if($pn > sprintf("%.0f\n",($total/$num)+0.5)-1)$pn=($paging+$page) ;
			$_pn=$pn;
			if($pn >= sprintf("%.0f\n",ceil($total/$num))) $pn=($paging+$page+1) ;
			if($_pn != sprintf("%.0f\n",ceil($total/$num))) $output .= "  ";
		}

		if($pn >= $total/$num){
			$output .=" &raquo; ";
		}else{
			$output .=" <a  href=\"$link&page=".substr($pn,0,4)."\"  title='Next Page'> &raquo; </a>";
		}
		$output .="<a  href=\"$link&page=".ceil($total/$num)."\">Last</a> ";
		if($var[show_total]) $output .=" - Total ".ceil($total/$num)." page(s), $total record(s).";
		echo"<table class=default><tr><td>$output</td></tr></table>";
	}

	function insert_log($activity,$sql=""){
		global $login_id,$db;
		global $REMOTE_ADDR;
		$ctime=date("Y-m-d H:i:s");
		if (!$user_id) $user_id="1";
		$sql="insert into tbl_log (user_id,activity,ctime,ip,detail) values ('$user_id','$activity','$ctime','$REMOTE_ADDR','$sql')";
		//echo $sql;
		$result=$db->Execute($sql);
		if (!$result){
			print $db->ErrorMsg();
			echo $sql;
		}
	}
	function convertdatetime($array){
		$datetime=$array[datetime];
		$y=substr($datetime,0,4);
		$m=substr($datetime,5,2);
		$d=substr($datetime,8,2);
		$conv_datetime=date("j/n/Y",mktime(1,0,0,$m,$d,$y));#"$d / $m / $y";
		return($conv_datetime);

	}
	function convertdatetime2($array){
		$datetime=$array[datetime];
		$conf	 =$array[conf];

		$y=substr($datetime,0,4);
		$m=substr($datetime,5,2);
		$d=substr($datetime,8,2);
		$h=substr($datetime,11,2);
		$i=substr($datetime,14,2);
		$s=substr($datetime,17,2);

		if(empty($conf)) $conf="d-m-Y";
		if(empty($h)) $h="1";
		if(empty($i)) $i="0";
		if(empty($s)) $s="0";
		$conv_datetime=date("$conf",mktime($h,$i,$s,$m,$d,$y));#"$d - $m - $y";
		return($conv_datetime);

	}
	function convertdatetime3($array){
		$datetime=$array[datetime];
		$y=substr($datetime,0,4);
		$m=substr($datetime,5,2);
		$d=substr($datetime,8,2);
		$conv_datetime=date("j-n-Y",mktime(1,0,0,$m,$d,$y));#"$d / $m / $y";
		return($conv_datetime);

	}
	function preloading(){
		echo"
		<body onload=hd();>
		<div ID=preloading style=position:absolute;background-color:white;width:100%;height:100%;>
		  <img src=/admin/loading.gif><BR>
		<font color=666666 face=verdana size=1>Please wait, page is still loading..</font>
		</div>";

	}
	function getmicrotime(){
		list($usec, $sec) = explode(" ",microtime());
		return ((float)$usec + (float)$sec);
	}
	function standard_buttons($array=""){
		global $PHP_SELF;
        if ($array['cond']) $cond = $array['cond'];
	
		echo"
		<table class=default><tr><td align=right>";
		if (!$array['noadd']) echo "<input type=button onClick=location.href='$PHP_SELF?act=add$cond'; value='Add New Record' class=select>";
		if (!$array['norefresh']) echo "<input type=button onClick=location.href='$PHP_SELF$cond'; value='Refresh' class=select>";
		echo "
        </td></tr></table>";
	}

	function merchant_buttons(){
		global $PHP_SELF;
		echo"
		<table class=default><tr><td align=right>
		<input type=button onClick=location.replace('$PHP_SELF'); value='Refresh' class=select>
		<!--<a href=$PHP_SELF?act=add><img src=../images/ButtonAdd.gif border=0></a>-->
		</td></tr></table>";
	}

	function search_box($query=""){
		global $advance_search;
		echo"
		<table class=search>
		<form method=post name=f2>
		<input type=hidden name=start value='0'>
		<input type=hidden name=page value='1'>
		<input type=hidden name=type value='$type'>	
		<tr class=bgSearch>
		<td><img src=/images/icon_search.gif>
		<input type=text name=query value=\"$query\" size=20 style=font-size:11px;>";
		echo"
		<input type=submit value='  Search  ' class=buttonhi>";
		if($advance_search != "0") echo"<a href=# onClick=openAdvanceSearchBox(1);>Advance Search</a>";
		echo"</td>
		</tr>	
		</form>
		</table	>
		<P>
		";
	}
	function count_total($table,$cond=""){
		global $db;
		$sql="select count(1) as TOTAL from $table $cond";
		$result_total=$db->Execute("$sql");

		if(!$result_total){
			#echo"$sql";
			print $db->ErrorMsg();
		}
		$row_total=$result_total->FetchRow();
		$total=$row_total[TOTAL];
		return $total;
	}

	function define_department($field,$rel=""){
		global $login_department;
		if(empty($rel)) $rel="and";
		if(!eregi("\|",$login_department)){
			$cond_department ="$rel $field='$login_department'";
		}else{
			$dept_cond=preg_replace("/\|/","','",$login_department);
			$cond_department ="$rel $field in ('$dept_cond')";
		}
		return $cond_department;
	}
	function result_message($message){
		global $PHP_SELF;
		echo"
		<table class=index><tr><td>
		<p class=judul>Result:</p>
		$message
		<p>
		<a href=$PHP_SELF>Return to Main Page</a>
		</td></tr></table>
		";
	}
	function generate_nomorbarcode($num){
		$prefix = 'RM-';
		$format = '%2$s%1$07d';
		
		$barcode = sprintf($format, $num, $prefix);
		return $barcode;
	}
	function generate_nomorperbaikan($table,$column,$prefix){
		global $db;

		$column=strtoupper($column);

		$strSQL = "select cast(substring($column,5,9) as bigint)+1 as nomerurut
	                from $table where $column like '$prefix%'
	                order by cast(substring($column,5,9) as bigint) desc";
		#echo"strSQL : $strSQL";
		$result = $db->SelectLimit($strSQL,1,0);
		if (!$result) echo $db->ErrorMsg();
		$row = $result->FetchRow();

		$nomor = $row["NOMERURUT"];
		if(empty($nomor)) $nomor="1";
		$nomor="$prefix-".sprintf("%09d",$nomor);
		return $nomor;
	}


	function generate_nomorkolom($table,$column,$prefix){
		global $db;

		$column=strtoupper($column);

		$strSQL = "select cast(substring($column,5,9) as bigint)+1 as nomerurut
	                from $table where $column like '$prefix%'
	                order by cast(substring($column,5,9) as bigint) desc";
		#echo"strSQL : $strSQL";
		$result = $db->SelectLimit($strSQL,1,0);
		if (!$result) echo $db->ErrorMsg();
		$row = $result->FetchRow();

		$nomor = $row["NOMERURUT"];
		if(empty($nomor)) $nomor="1";
		$nomor="$prefix-".sprintf("%09d",$nomor);
		return $nomor;
	}


	function terbilang($bilangan) {

		$angka = array('0','0','0','0','0','0','0','0','0','0',
		'0','0','0','0','0','0');
		$kata = array('','satu','dua','tiga','empat','lima',
		'enam','tujuh','delapan','sembilan');
		$tingkat = array('','ribu','juta','milyar','triliun');

		$panjang_bilangan = strlen($bilangan);

		/* pengujian panjang bilangan */
		if ($panjang_bilangan > 15) {
			$kalimat = "Diluar Batas";
			return $kalimat;
		}

		/* mengambil angka-angka yang ada dalam bilangan,
		dimasukkan ke dalam array */
		for ($i = 1; $i <= $panjang_bilangan; $i++) {
			$angka[$i] = substr($bilangan,-($i),1);
		}

		$i = 1;
		$j = 0;
		$kalimat = "";


		/* mulai proses iterasi terhadap array angka */
		while ($i <= $panjang_bilangan) {

			$subkalimat = "";
			$kata1 = "";
			$kata2 = "";
			$kata3 = "";

			/* untuk ratusan */
			if ($angka[$i+2] != "0") {
				if ($angka[$i+2] == "1") {
					$kata1 = "Seratus";
				} else {
					$kata1 = $kata[$angka[$i+2]] . " ratus";
				}
			}

			/* untuk puluhan atau belasan */
			if ($angka[$i+1] != "0") {
				if ($angka[$i+1] == "1") {
					if ($angka[$i] == "0") {
						$kata2 = "Sepuluh";
					} elseif ($angka[$i] == "1") {
						$kata2 = "Sebelas";
					} else {
						$kata2 = $kata[$angka[$i]] . " belas";
					}
				} else {
					$kata2 = $kata[$angka[$i+1]] . " puluh";
				}
			}

			/* untuk satuan */
			if ($angka[$i] != "0") {
				if ($angka[$i+1] != "1") {
					$kata3 = $kata[$angka[$i]];
				}
			}

			/* pengujian angka apakah tidak nol semua,
			lalu ditambahkan tingkat */
			if (($angka[$i] != "0") OR ($angka[$i+1] != "0") OR
			($angka[$i+2] != "0")) {
				$subkalimat = "$kata1 $kata2 $kata3 " . $tingkat[$j] . " ";
			}

			/* gabungkan variabe sub kalimat (untuk satu blok 3 angka)
			ke variabel kalimat */
			$kalimat = $subkalimat . $kalimat;
			$i = $i + 3;
			$j = $j + 1;

		}

		/* mengganti satu ribu jadi seribu jika diperlukan */
		if (($angka[5] == "0") AND ($angka[6] == "0")) {
			$kalimat = str_replace("satu ribu","Seribu",$kalimat);
		}

		return trim($kalimat);

	}

	function box($title,$description,$button,$type="error",$width=""){
		/* example
		$f->box("title","d);

		*/

		echo"
		<p>
        <table cellpadding=0 cellspacing=0 align=center width=$width>
        <tr>
                <td background=/i/bgleft.gif width=3><img src=/i/s.gif></td>
                <td background=/i/bgbox.jpg colspan=2 height=25 style=padding-left:15px;><font color=white><B>$title</td>
                <td bgcolor=#808080><img src=/i/s.gif width=2></td>
        </tr>
        <tr bgcolor=#D4D0C8>
                <td background=/i/bgleft.gif width=3><img src=/i/s.gif></td>
                <td width=75 align=center valign=top><BR>";
		if($type=='error') echo"<img src=/i/stop.gif>";
		if($type=='info') echo"<img src=/i/information.gif>";
		if($type=='warning') echo"<img src=/i/warning.gif>";

		echo"</td>
                <td style=padding-left:20px;padding-right:20px;><font face=arial size=2><BR>$description<P><BR>";

		if(is_array($button)){
			for($i=0;$i<count($button);$i++){
				if($button[$i][0]=='back'){
					$action="javascript:history.back(-1)";
				}else{
					$action="location.replace('".$button[$i][0]."')";
				}
				echo"<input type=button onClick=\"$action\" value='".$button[$i][1]."'> ";
			}
		}else{
			echo"<input type=button onClick=history.back(-1); value='« Back'> ";
		}

		echo"<P><BR></td>
                <td bgcolor=#808080><img src=/i/s.gif width=2></td>
        </tr>
        <tr>
                <td background=/i/bgleft.gif width=3><img src=/i/s.gif></td>
                <td bgcolor=#808080 colspan=3 background=/i/bgbottom.gif><img src=/i/s.gif height=3></td>
        </tr>
        </table><P><BR><BR><BR><BR><BR><BR><BR><BR><BR>
        ";
		if($type=="error") die();
	}

	function tab(){
		global $f,$db,$sessionCookie,$_SESSION,$DOCUMENT_ROOT,$HTTP_HOST,$login_username;
		$sql="select * from tbl_setting";
		$result=$f->get_last_record($sql);
		foreach($result as $key=>$val) $$key=$val;

		echo"
		<script type=\"text/javascript\" language=\"javascript\" src=\"/jquery.dropdownPlain.js\"></script> 
		<script type=\"text/javascript\" language=\"javascript\" src=\"/classes/js/jsConfirmStyle.js\"></script>
		<LINK rel='stylesheet' type='text/css' media='all' href=\"/classes/style/delete.css\">
		<table width=100% border=0 cellpadding=0 cellspacing=0>
		<tr style=height:60px;>
		    <td bgcolor='$header_color' valign=bottom><a href=/index.php><img src=$path border=0></a></td>
		    <td bgcolor='$header_color' align=right valign=bottom style=padding-right:20px;>";
		if(!empty($_SESSION[$sessionCookie])){
			echo "<a href=/?act=logout style=color:red><img src='/i/logout.png' border=0></a></span>";
		}else{
			#echo "<a href=/login.php style=color:#FFFFFF>Login</a> | <a href=/signup.php?act=add style='color:#FFFFFF;'>Sign Up</a>";
		}
		echo"</td>
		</tr>
		<tr style=height:12px;>
		    <td colspan=2 bgcolor=$tab_color style=padding-left:20px;>";
		
		echo"</td>
		</tr>
		</table>";		

	}

	function primary_key($primary_key){
		if(eregi(",",$primary_key)){
			$cond_arr=split(",",$primary_key);
			foreach($cond_arr as $key){
				global $$key;
				$cond_primary_key .=" $key='".$$key."' and";
			}
			$cond_primary_key=preg_replace("#and$#i","",$cond_primary_key);
		}else{
			global $$primary_key;
			$cond_primary_key="$primary_key ='".$$primary_key."'";
		}
		return $cond_primary_key;
	}

	function get_record_array($array){
		//example
		//$f->get_record_array(array("table"=>"spd_jenisangkutan","key"=>"jnsang","value"=>"nmangk"));
		global $db;
		$table=$array["table"];
		$key	=strtoupper($array["key"]);
		$value=strtoupper($array["value"]);
		$sql="select $key,$value from $table";
		$result=$db->Execute($sql);
		if(!$result) print $db->ErrorMsg();
		$return=array();
		while($row=$result->FetchRow()){
			$_key		=$row[$key];
			$_value	=$row[$value];
			$return[$_key]=$_value;
		}
		return $return;

	}
	function get_record_by_value($table,$primary_key){
		global $db;
		if(eregi(",",$primary_key)){
			$cond_arr=split(",",$primary_key);
			foreach($cond_arr as $key){
				global $$key;
				$cond_primary_key .=" $key='".$$key."' and";
			}
			$cond_primary_key=preg_replace("#and$#i","",$cond_primary_key);
		}else{
			global $$primary_key;
			$cond_primary_key="$primary_key ='".$$primary_key."'";
		}
		$sql="select * from $table where $cond_primary_key";
		#echo"$sql<HR>";
		$result=$db->Execute("$sql");

		if(!$result) print $db->ErrorMsg();
		$row=$result->FetchRow();
		$array=array();
		if(is_array($row)){
			foreach($row as $key=>$val){
				$key=strtolower($key);
				$array[$key]=$val;
			}
		}
		#print_r($array);
		return $array;
	}
	function get_last_record($sql){
		global $db;
		$result=$db->SelectLimit($sql,1,0);
		if(!$result) {
			echo"<font color=red>$sql</font>";
			print $db->ErrorMsg();
		}
		//die($sql);
		$row=$result->FetchRow();
		$array=array();
		if(is_array($row)){
			foreach($row as $key=>$val){
				$key=strtolower($key);
				$$key= $val;
				$array[$key]=$val;
			}
		}
		return $array;
	}


	function check_exist_value($sql){
		global $db;
		if(empty($sql)) die("Query tidak boleh kosong");
		$result=$db->SelectLimit("$sql",1,0);
		if(!$result) print $db->ErrorMsg();
		$row=$result->FetchRow();
		$array=array();
		if(is_array($row)){
			foreach($row as $key=>$val){
				$key=strtolower($key);
				$array[$key]=$val;
			}
		}

		if(count($array) > 0) {
			return true;
		}else{
			return false;
		}
	}
	function parsing_sql_cond($cond){
		if(eregi(",",$cond)){
			$cond=split(",",$cond);
			foreach($cond as $key){
				global $$key;
				$column .=" $key='".$$key."' and";
			}
			$column=preg_replace("/(and)$/i","","$column");
		}else{
			global $$cond;
			$column ="$cond='".$$cond."' ";
		}
		return $column;
	}

	function upload_file($array){

		/*
		# cara pemakaian
		if($act=='add'){
		$array=array(
		"dir"=>"/i/diklat",
		"act"=>"do_add",
		"input_name"=>"file",
		"extension"=>"doc|docx|jpg|jpeg|pdf"
		);
		if(!empty($HTTP_POST_FILES['file']['name'])) $filename=$f->upload_file($array);
		}else{
		$array=array(
		"dir"=>"/i/diklat",
		"act"=>"do_update",
		"input_name"=>"file",
		"path_old"=>"$file_loc",
		"change_file"=>"$change_file",
		"extension"=>"doc|docx|jpg|jpeg|pdf"
		);
		$filename=$f->upload_file($array);
		}


		*/
		$dir		=$array['dir'];
		$change_file=$array['change_file'];
		$path_old	=$array['path_old'];
		$act		=$array['act'];
		$input_name	=$array['input_name'];
		$extension	=$array['extension'];

		global $db,$f;
		global $HTTP_POST_FILES;
		global $DOCUMENT_ROOT,$HTTP_HOST,$REMOTE_ADDR,$login_nip,$REQUEST_URI,$PHP_SELF;
		if(($act=='do_update' && $change_file=='2') || $act=='do_add'){ //change file
			$filename=time()."_".$HTTP_POST_FILES[$input_name]['name'];
			$filename=preg_replace("/\'|\s|\"|\-/","_",strtolower($filename));
			if(empty($dir)){
				$dir ="$DOCUMENT_ROOT/i/upload";
			}else{
				$dir =$DOCUMENT_ROOT."$dir";
			}
			if(eregi("\.php",$filename)){
				$this->logfile(array("filename"=>"ilegal_upload.log","message"=>"$REMOTE_ADDR,$login_nip,$REQUEST_URI $PHP_SELF"));
				die('file extensi ini tidak diperbolehkan untuk diupload ke server!');
			}
			if(!empty($extension)){
				#echo"<h1>$extension | $filename</h1>";
				if(!preg_match("/($extension)$/",$filename)) die('file extensi ini tidak diperbolehkan untuk diupload ke server!');
			}
			move_uploaded_file($HTTP_POST_FILES[$input_name]['tmp_name'],"$dir/$filename") or die("upload gagal. periksa permission direktori xx $dir/$filename");
			$path=str_replace("$DOCUMENT_ROOT","","$dir/$filename");

		}elseif($act=='do_update' && $change_file=='3'){ //delete
			//$path_old=$f->convert_value(array("table"=>"","cs"=>"path","cd"=>"dik_id","vd"=>"$dik_id"));
			@unlink("$DOCUMENT_ROOT$path_old");
			$path="";
		}

		return $path;
	}

	function input_image($nama_input,$file_location,$keterangan=""){
		global $db;
		global $act;
		$output .="<input type=file name=$nama_input value='$path'> <BR>$keterangan<BR>";
		#if($act=='update'){
		$output .="<table class=noindex><tr><td valign=top width=10>";
		$output .= (!empty($file_location)?$this->check_file_type($file_location,$file_location,"_blank"):"")."<BR>";
		$output .="</td><td>
			<input type=radio name=change_file value='1' checked>Keep File
			<input type=radio name=change_file value='2'>Change<BR>
			<input type=radio name=change_file value='3'>Delete</td></tr>
			</table>";
		#}
		return  $output;

	}
	function check_file_type($filename,$href="",$target=""){
		global $download;
		$extension=substr($filename,-4);
		if(eregi("pdf",$extension)){
			$icon="<img src=/i/icon/pdf.gif border=0>";
		}elseif(eregi("jpg|jpeg",$extension)){
			$icon="<img src=/i/icon/jpg.gif border=0>";
		}elseif(eregi("png",$extension)){
			$icon="<img src=/i/icon/png.gif border=0>";
		}elseif(eregi("gif",$extension)){
			$icon="<img src=/i/icon/gif.gif border=0>";
		}elseif(eregi("doc",$extension)){
			$icon="<img src=/i/icon/doc.gif border=0>";
		}elseif(eregi("xls",$extension)){
			$icon="<img src=/i/icon/xls.gif border=0>";
		}elseif(eregi("ppt",$extension)){
			$icon="<img src=/i/icon/ppt.gif border=0>";
		}elseif(eregi("rar|zip",$extension)){
			$icon="<img src=/i/icon/zip.gif border=0>";
		}else{
			$icon=$extension;
		}
		if($download == '0'){
			return "$icon";
		}else{
			return "<a href=$href target=$target>$icon</a>";
		}
	}

	function get_formulir_record($msf_formulir,$kso_kasusnomor,$atf_fieldketerangan){
		global $db;

		$atf_fieldketerangan_ori=$atf_fieldketerangan;
		if(eregi(",",$atf_fieldketerangan)){
			$field=split(",",$atf_fieldketerangan);
			unset($atf_fieldketerangan);
			foreach($field as $val){
				$atf_fieldketerangan .="'".$val."',";
			}
			$atf_fieldketerangan = preg_replace("#,$#","",$atf_fieldketerangan);
			$atf_fieldketerangan = preg_replace("#^\'|\'$#","",$atf_fieldketerangan);
		}

		$sql="select a.* from
		tbl_formulirattribute a,tbl_formulirfield b
                where a.atf_attributekode=b.atf_attributekode and b.msf_formulirkode='$msf_formulir'
                and a.atf_fieldlokasi is NOT NULL and atf_flagaktif='1' and atf_fieldketerangan in ('$atf_fieldketerangan')
		order by atf_fieldketerangan asc
		";	
		if($atf_fieldketerangan=='a185_a218') echo"$sql";
		$result=$db->Execute($sql);
		if(!$result) print $db->ErrorMsg();
		while($row=$result->FetchRow()){
			$atf_fieldketerangan    = $row[ATF_FIELDKETERANGAN];
			$atf_fieldlokasi        = $row[ATF_FIELDLOKASI];
			$atf_formulatipe        = $row[ATF_FORMULATIPE];
			$atf_formulaparameter   = $row[ATF_FORMULAPARAMETER];
			$atf_fieldtipe          = $row[ATF_FIELDTIPE];

			$ftd_attribute=preg_replace("/attr/i","ftd_attribute",$atf_fieldlokasi);
			$ftd_attribute=strtoupper($ftd_attribute);
			$sql="select $ftd_attribute from tbl_opformulirtransaksidata where fto_nomor in (
	                               select fto_nomor from tbl_opformulirtransaksi where kso_kasusnomor='$kso_kasusnomor' and
	 				msf_formulirkode='$msf_formulir')
	                       ";


			$result_ftd=$db->Execute($sql);
			if(!$result_ftd) print $db->ErrorMsg();
			$row_ftd=$result_ftd->FetchRow();
			$_ftd_attribute=$row_ftd[$ftd_attribute];

			$$atf_fieldketerangan=$_ftd_attribute;

			if(eregi(",",$atf_fieldketerangan_ori)){
				$return_value[$atf_fieldketerangan] = $$atf_fieldketerangan;
			}else{
				$return_value=$$atf_fieldketerangan;
			}
		}

		$return_value=preg_replace("#,$#","",$return_value);
		return $return_value;

	}
	function get_case_record($kso_kasusnomor,$jnk_jeniskasuskode,$attribute_nama){
		global $db;
		$atk_array=array();
		$sql="select ATK_ATTRIBUETNAMA,ATK_LOKASIDATA from tbl_kasusattribute where jnk_jeniskasuskode='$jnk_jeniskasuskode' and
		atk_attribuetnama in ('$attribute_nama')";
		$result_dynamic=$db->Execute($sql);
		#	echo"$sql";
		if(!$result_dynamic) print $db->ErrorMsg();
		$row_dynamic=$result_dynamic->FetchRow();
		$atk_lokasidata          = $row_dynamic[ATK_LOKASIDATA];
		$atk_lokasidata          = strtoupper($atk_lokasidata);

		$sql   = "select $atk_lokasidata from tbl_opkasusattribute where kso_kasusnomor='$kso_kasusnomor'";

		$resultattr  = $db->Execute($sql);
		if(!$result) print $db->ErrorMsg();
		$rowattr    = $resultattr->FetchRow();
		$result		= $rowattr["$atk_lokasidata"];
		return $result;

	}

	function createRandomKey($amount){
		$keyset  = "abcdefghijklmABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$randkey = "";
		for ($i=0; $i<$amount; $i++)
		$randkey .= substr($keyset, rand(0, strlen($keyset)-1), 1);
		return $randkey;
	}

	function preparedate($date){
		list($day, $month, $year) = split('[/.-]', $date);
		return "$year-".sprintf("%02d", $month)."-".sprintf("%02d", $day);
	}

	function preparetime($time){
		list($hrs, $min, $apm) = split('[:. ]', $time);
		if ($apm == 'PM') $hrs = intval($hrs)+12;
		return sprintf("%02d", $hrs).":".sprintf("%02d", $min).":00";
	}

	function r_preparetime($time){
		list($hrs, $min, $apm) = split(':', $time);
		return date('G:i', mktime($hrs, $min, 0, 0, 0, 0));
	}
    
	function check_hari($tanggal){
    
        $hari_array=array(
		"1"=>"Senin",
		"2"=>"Selasa",
		"3"=>"Rabu",
		"4"=>"Kamis",
		"5"=>"Jumat",
		"6"=>"Sabtu",
		"7"=>"Minggu");
        
        $r_bulan_array = array(
        "Januari"=>"1",
		"Februari"=>"2",
		"Maret"=>"3",
		"April"=>"4",
		"Mei"=>"5",
		"Juni"=>"6",
		"Juli"=>"7",
        "Agustus"=>"8",
        "September"=>"9",
        "Oktober"=>"10",
        "November"=>"11",
        "Desember"=>"12"
        );
		$tanggal_array=split(' ', $tanggal); 
		// 1 Desember 2013 -> $tanggal_array[0] = 1, $tanggal_array[1] = Desember, $tanggal_array[2] = 2013
        $hari_n=date("N",mktime(0,0,0,$r_bulan_array[$tanggal_array[1]],$tanggal_array[0],$tanggal_array[2]));
		return $hari_array[$hari_n];
	}
	
	function check_hari2($tanggal){
    
        $hari_array=array(
		"1"=>"Senin",
		"2"=>"Selasa",
		"3"=>"Rabu",
		"4"=>"Kamis",
		"5"=>"Jumat",
		"6"=>"Sabtu",
		"7"=>"Minggu");
        
		$tanggal_array=split('-', $tanggal); //Y-m-d
		// 1 Desember 2013 -> $tanggal_array[0] = 1, $tanggal_array[1] = Desember, $tanggal_array[2] = 2013
        $hari_n=date("N",mktime(0,0,0,$tanggal_array[1],$tanggal_array[2],$tanggal_array[0]));
		// 12, 1, 2013 -> mm-dd-yyyy
		return $hari_array[$hari_n];
	}
    
    function check_bulan($tanggal){
		$bulan_array=array(
		"1"=>"Januari",
		"2"=>"Februari",
		"3"=>"Maret",
		"4"=>"April",
		"5"=>"Mei",
		"6"=>"Juni",
		"7"=>"Juli",
        "8"=>"Agustus",
        "9"=>"September",
        "10"=>"Oktober",
        "11"=>"November",
        "12"=>"Desember");
		$tanggal_array=split('[/.-]', $tanggal);
		$bulan_n=date("n",mktime("1","1","1",$tanggal_array[1],$tanggal_array[2],$tanggal_array[0]));
		return $bulan_array[$bulan_n];
	}
    
    function format_tgl_cetak($tanggal) {
        list($year, $month, $day) = split('[/.-]', $tanggal);
		return intval($day)." ".$this->check_bulan($tanggal)." ".$year;        
    }
    
    function format_tgl_cetak2($tanggal) { // Gak pake tanggal
        list($year, $month, $day) = split('[/.-]', $tanggal);
		return " &nbsp; &nbsp; &nbsp; &nbsp; ".$this->check_bulan($tanggal)." &nbsp; &nbsp; ".$year;        
    }
    
    function format_text($text) {
        $text = str_replace("'","&#039;",$text);
        $text = str_replace('"',"&quot;",$text);
        return $text;
    }

}

?>
