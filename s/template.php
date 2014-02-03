<?
class template{

	function template(){

		/*==============================================================*
		 *
		 *					Set Template Configuration
		 *
		 *==============================================================*/

		//Table Setting
		$this->tableLine		="#800000";
		$this->tableColor		="#FFFFFF";
		$this->tableColor2		="#F2F2E3";
		$this->tableColor3		="#F7F7F7";
		$this->tableTitleColor	="#ebebeb";

		//Font Setting
		$this->fontColor		="#000000";
		$this->linkColor		="#333333";

		//Form Setting
		$this->formColor		="#ebebeb";
		$this->formFontColor	="#333333";
		$this->formFontColor2	="#999999";


	}
    
    function basicheader($site="") {
    
        global $HTTP_HOST,$db,$f;
        $sql="select * from tbl_setting";
        $result=$f->get_last_record($sql);
        foreach($result as $key=>$val){
            $$key=$val;
    #		echo"$key - $val<BR>";
        }
        echo"

        <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
        <html xmlns='http://www.w3.org/1999/xhtml'>
        <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        <title>$title</title>
        
        <script type=\"text/javascript\" src=\"/jquery-1.8.2.min.js\"></script>
        <script type=\"text/javascript\" src=\"/jquery.easyui.min.js\"></script>
        <script type=\"text/javascript\" src=\"/js/jquery-ui-1.9.1.custom.js\"></script>
        <script type=\"text/javascript\" src=\"/jquery.ui.timepicker.js\"></script>
		<script type=\"text/javascript\" src=\"/jquery.validate.js\"></script>

        <link type=\"text/css\" rel=\"stylesheet\" href=\"/prototipe.css\" >
        <link type=\"text/css\" rel=\"stylesheet\" href=\"/themes/gray/easyui.css\">
        <link type=\"text/css\" rel=\"stylesheet\" href=\"/themes/icon.css\">
        <link type=\"text/css\" rel=\"stylesheet\" href=\"/css/smoothness/jquery-ui-1.9.1.custom.css\">
        <link type=\"text/css\" rel=\"stylesheet\" href=\"/jquery.ui.timepicker.css\">

        </head>
        <body topmargin=0 leftmargin=0 marginheight=0 marginwidth=0 bgcolor=\"$page_color\">
        <BR><center><div class=wrapper style=width:auto;height:auto;text-align:left><BR>
        ";
    }
    
    function basicfooter() {
    
        echo "
        <p>&nbsp;</p>
        </div>
        <p>&nbsp;</p>
        </body>
        </html>";
    
    }
    
    function title($text) {
        echo "<span><b><i>$text</i></b></span><p></p>";
    }
    
    function message($message, $link)  {
	
		?>
		<form name="form1" method="post" action="<?=$link?>">
		<table border="0" align="center" cellpadding="5" cellspacing="2" bgcolor="<?=$this->tableLine?>">
		<tr bgcolor="<?=$this->tableTitleColor?>"> 
			<td align="center"><img src=/images/access_denied.gif></td>
		</tr>
		<tr bgcolor="<?=$this->tableColor?>"> 
			<td align="center"><br>
			<b><?=$message?></b><p>
			<input type="submit" name="Submit" value="   Ok   "><p>
			</td>
		</tr>
		</table>
		</form>
		<?
	}
	
	
	function messageAnchor($message, $link)  {
	
		global $_POST;
	
		?>
		<form name="form1" method="post" action="<?=$link?>">
		<table border="0" align="center" cellpadding="5" cellspacing="2" bgcolor="<?=$this->tableLine?>">
		<tr bgcolor="<?=$this->tableTitleColor?>"> 
			<td align="center">Pesan</td>
		</tr>
		<tr bgcolor="<?=$this->tableColor?>"> 
			<td align="center"><br>
			<b><?=$message?></b><p>
			<input type="submit" name="Submit" value="   Ok   "><p>
			</td>
		</tr>
		</table>
		
		<?
		
		reset ($_POST);
		while (list ($key, $val) = each ($_POST)) {
			if ( $key != "act" and count($val)==1  ) echo "<input type=\"hidden\" name=\"$key\" value=\"$val\">\n";
			
			if ( count($val)>1 ) {			
				for ( $i=0; $i<count($val); $i++ ) {
					echo "<input type=\"hidden\" name=\"".$key."[".$i."]\" value=\"$val[$i]\">\n"; 
				}			
			}
			
		}
		
		
		?>
		
		</form>
		<?
	}


	function confirmation($message, $link)  {
		?>
		<form name="form1" method="post" action="<?=$link?>">
		<table border="0" align="center" cellpadding="5" cellspacing="2" bgcolor="<?=$this->tableLine?>">
		<tr bgcolor="<?=$this->tableTitleColor?>"> 
			<td align="center">Konfirmasi</td>
		</tr>
		<tr bgcolor="<?=$this->tableColor?>"> 
			<td align="center"><br>
			<b><?=$message?></b><p>
			<input type="submit" name="Submit" value="   Ya   ">
			<p>
			</td>
		</tr>
		</table>
		</form>
		<?
	}

	

}

?>