<?

class formatter {

	function formatter () {
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

}

?>