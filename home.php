<?
ob_start();
include_once ("$DOCUMENT_ROOT/s/config.php");
$f->checkaccess();

function parseMenu($level, $under) {

		global $db, $i, $login_access;

		++$i;
		$resultname = "result$i";
        $resultcheck = "resultcheck$i";
        $rowcheck = "rowcheck$i";

		$strSQL			= "SELECT * from tbl_menu WHERE ((level=$level) and (referensi=$under)) order by bobot asc";
		
		$$resultname	= $db->Execute($strSQL);
		if (!$$resultname) print $db>ErrorMsg();
        
        if ($level>0) echo "<ul>";

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
            $keterangan			= $row['keterangan'];
            
			
            $sql="select read_priv from tbl_functionaccess where name='$login_access' and menu_id='$nomorurut'";
            $$resultcheck=$db->Execute($sql);
            if(!$$resultcheck) print $db->ErrorMsg();
            $rowcheck=$$resultcheck->FetchRow();
            
            $fua_read=$rowcheck['read_priv'];
            
            if($fua_read=='1'){
            
                unset($_target, $_url_1, $_url_2);
                if ($target) $_target = " target=\"$target\" ";
                if ($url) {
                    if ($judul=='Log Out') $type = 'iconCls="icon-no"';
                    elseif ($judul=='Ganti Password') $type = 'iconCls="icon-pencil"';
                    
                    if ($judul=='Log Out') {
                        $_url_1 = "<span><a href=\"$url\" title=\"$keterangan\" target=\"_top\">";
                        $_url_2 = "</a></span>";                    
                    } else {
                        $_url_1 = "<span><a href=# title=\"$keterangan\" onclick=\"addTab('$judul','$url')\">";
                        $_url_2 = "</a></span>";                    
                    }
                }
                else {
                    $_url_1 = "<span>";
                    $_url_2 = "</span>";                    
                }
                if ($level == 0) $judul = "<b>$judul</b>";
                if (!$url) echo "<li data-options=\"state:'closed'\">$_url_1 $judul $_url_2";
                else echo "<li $type>$_url_1 $judul $_url_2";
            
            }
            
            ++$j;
            $resultname2 = "result2level$j";
            $checklevel = $level + 1;
            
			$strSQL			= "SELECT * from tbl_menu WHERE level=$checklevel and referensi=$nomorurut";
            $$resultname2	= $db->Execute($strSQL);
			if (!$$resultname2) print $db->ErrorMsg();

			if ($$resultname2->RecordCount() > 0) {
				parseMenu($checklevel, $nomorurut);	
			}	
            
            if($fua_read=='1') echo "</li>\n";
		}	
        if ($level>0) echo "</ul>\n";
	}
?>

<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title><?=$site_title?></title>
<script type="text/javascript" src="/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="/jquery.easyui.min.js"></script>

<link type="text/css" rel="stylesheet" href="/themes/gray/easyui.css">
<link type="text/css" rel="stylesheet" href="/themes/icon.css">
<style>

div.footer { 
	font-face: Verdana;
    font-size: 11px;
    position: absolute;
    right: 10px;
}
#mainFrame {
    width: 100%;
    height: 100%;
    border-top: 0px;
    border-right: 0px;
    border-left: 0px;
    border-bottom: 0px;
}
.tree li a{
	text-decoration: none;
    color: #000;
}
</style>
<script type="text/javascript">
    function addTab(title, url){  
    if ($('#tt').tabs('exists', title)){  
        var content = '<iframe scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%;height:100%;"></iframe>';
        $('#tt').tabs('select', title);  
        var tab = $('#tt').tabs('getSelected'); 
        $('#tt').tabs('update', {
            tab: tab,
            options: {
                title: title,
                content:content
            }
        });
    } else {  
        var content = '<iframe scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%;height:100%;"></iframe>';  
        $('#tt').tabs('add',{  
            title:title,  
            content:content,  
            closable:true  
        });  
    }  
}  
</script>
</head>
<body class="easyui-layout">
	<div region="north" border="false" style="height:90px; overflow:hidden;"><?$f->tab()?></div>
	<div region="west" split="true" title="Menu" style="width:300px;padding:10px;">
       <ul class="easyui-tree">
		    <?=parseMenu(0, 0)?>		
       </ul>
    </div>
	<div region="south" border="false" style="height:20px;background:#EEE;padding:2px;">
    	<div style="font:11px verdana; position:absolute; left:10px;">Pemerintah Kota Bogor &copy; <?=date('Y')?> - Powered by : Balai IPTEKNet</div>
        <div style="font:11px verdana; position:absolute; right:10px;">Welcome <b><?=$login_username?></b></div></div>
	<div region="center" border="false">
        <div id="tt" class="easyui-tabs" fit="true" border="false" plain="true">
            <div title="Home" style="overflow:hidden;">
                <iframe  frameborder="0" src="info.php" style="width:100%;height:100%;"></iframe>
            </div>
        </div>
    </div>
</body>
</html>