<?
class template{

	function template() {
	}

	function htmlHeader() {
		global $site_title;

		?>
		<html>
		<head>
		<title><?=$site_title?></title>
		</head>
		<body>
		<?
	}

	function htmlFooter() {

		?>
		</body>
		</html>
		<?
	}
}
?>