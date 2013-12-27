<?
ob_start();
include_once ("$DOCUMENT_ROOT/s/config.php");
$f->checkaccess();

function parseMenu($level, $under) {

		global $db, $i, $login_access, $menu_output;

		++$i;
		$resultname = "result$i";
        $resultcheck = "resultcheck$i";
        $rowcheck = "rowcheck$i";

		$strSQL			= "SELECT * from tbl_menu WHERE ((level=$level) and (referensi=$under)) order by bobot asc";
		
		$$resultname	= $db->Execute($strSQL);
		if (!$$resultname) print $db>ErrorMsg();
        
        $menu_output .= "[";

		// Display Query
		while ($row = $$resultname->FetchRow()) 
			{

			$id					= $row['id'];
			$nomorurut			= $row['nomorurut'];
			$level				= $row['level'];
			$referensi			= $row['referensi'];
            $judul  			= $row['judul'];
			$url				= $row['url'];
			$target				= $row['target'];
			
            $sql="select read_priv from tbl_functionaccess where name='$login_access' and menu_id='$nomorurut'";
            $$resultcheck=$db->Execute($sql);
            if(!$$resultcheck) print $db->ErrorMsg();
            $rowcheck=$$resultcheck->FetchRow();
            
            $fua_read=$rowcheck['read_priv'];
            
            if($fua_read=='1'){
            
                unset($_target, $_url_1, $_url_2);
                //if ($target) $_target = "\"target\": \"$target\", ";
                if ($url) {
                    if ($judul=='Log Out') $type = 'logout';
                    elseif ($judul=='Ganti Password') $type = 'password';
                    else $type = 'file';
                    $_url = "\"attributes\":{\"url\": \"$url\"}, ";
                }
                else {
                    $_url = "";
                }
                $_judul = "\"text\": \"$judul\", ";
                $_state = "\"state\": \"close\", ";
                $menu_output .= substr("{".$_judul.$_state.$_target.$_url, 0, -2);
            
            }
            
            ++$j;
            $resultname2 = "result2level$j";
            $checklevel = $level + 1;
            
			$strSQL			= "SELECT * from tbl_menu WHERE level=$checklevel and referensi=$nomorurut";
            $$resultname2	= $db->Execute($strSQL);
			if (!$$resultname2) print $db->ErrorMsg();
    
            if ($$resultname2->RecordCount() > 0) {
                $menu_output .= ", \"children\": ";
				parseMenu($checklevel, $nomorurut);	
                
			}	
            
            if($fua_read=='1') $menu_output .= "}, ";
		}	
        $menu_output = substr($menu_output, 0, -2);
        $menu_output .= "]\n";
}

parseMenu(0, 0);

echo $menu_output;
    
    
?>