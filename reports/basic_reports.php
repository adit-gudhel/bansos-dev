<?
include "../s/config.php";
$f->checkaccess();
$t->basicheader();

if (!$start_date) $start_date = date('d/m/Y',mktime(0, 0, 0, intval(date('m')-1), date('d'), date('Y')));
if (!$end_date) $end_date = date('d/m/Y',mktime(0, 0, 0, date('m'), intval(date('d')+1), date('Y')));


if (!$_GET['opd'])
	$sql = "SELECT * FROM tbl_opd";
else
	$sql = "SELECT * FROM tbl_opd WHERE opd_kode='".$_GET['opd']."'";

#echo $sql;

$result_q = $db->Execute($sql. " ORDER BY opd_nama");
while ($row_q = $result_q->Fetchrow()) {

    $opd_kode = $row_q['opd_kode'];
    $opd_nama = $row_q['opd_nama'];
    
    $rel 	= $cond?"AND":"WHERE";
    $cond = " $rel opd_kode = '$opd_kode' ";
    $_opd_kode = $opd_kode;
	
    $no++;
    if ($no == 1) $opd_kode_1 = $opd_kode;

    //get Hibah
    $sql = "SELECT count(*) as num FROM tbl_hibah $cond and (hib_tanggal>='".$f->preparedate($start_date)."' and hib_tanggal<='".$f->preparedate($end_date)."')";
	# echo $sql. "<br>";
    $result=$db->Execute($sql);
    if ($result && $result->RecordCount()>0) {
        $row = $result->Fetchrow();
        $num_hibah = $row['num'];
    }
    $num_hibah_1 = $num_hibah_1 + $num_hibah;
	
    //get Bantuan Sosial
    $sql = "SELECT count(*) as num FROM tbl_bansos $cond and (ban_tanggal>='".$f->preparedate($start_date)."' and ban_tanggal<='".$f->preparedate($end_date)."')";
	# echo $sql. "<br>";
    $result=$db->Execute($sql);
    if ($result && $result->RecordCount()>0) {
        $row = $result->Fetchrow();
        $num_bansos= $row['num'];
    }
	$num_bansos_1 = $num_bansos_1 + $num_bansos;

    $table_rows .= "<tr><td><a href=?opd=$opd_kode&start_date=$start_date&end_date=$end_date>$opd_nama</a></td>
                    <td><a href=# onclick=\"parent.addTab('Data Pemohon Hibah','/hibah.php?query=$opd_nama');\">$num_hibah</a></td>
                    <td><a href=# onclick=\"parent.addTab('Data Pemohon Bantuan Sosial','/bansos.php?query=$opd_nama');\">$num_bansos</a></td>"; 
    unset($num_hibah, $num_bansos, $cond);  
}

?>
<script type="text/javascript" src="basic_reports.js"></script>
<p align=center><b><font size=4>LAPORAN JUMLAH PEMOHON HIBAH DAN BANTUAN SOSIAL</font></b></p>
<form>
<center><input type="text" name="start_date" id="start_date" value="<?=$start_date?>" /> s/d <input type="text" name="end_date" id="end_date" value="<?=$end_date?>" /> <input type=submit value=" Set "></center>
</form>

<script type="text/javascript" src="/classes/RGraph/libraries/RGraph.common.core.js" ></script>
<script type="text/javascript" src="/classes/RGraph/libraries/RGraph.bar.js" ></script>
<script type="text/javascript" src="/classes/RGraph/libraries/RGraph.common.effects.js" ></script>
<!--[if lt IE 9]><script src="/classes/RGraph/excanvas/excanvas.js"></script><![endif]-->
<center><canvas id="cvs" width="600" height="250">[No canvas support]</canvas></center>
<script>
    window.onload = function ()
    {
        var bar = new RGraph.Bar('cvs', [<?=$num_hibah_1?>, <?=$num_bansos_1?>]);
        bar.Set('chart.labels', ['Hibah','Bantuan Sosial']);
		bar.Set('chart.hmargin', 85);
        RGraph.Effects.Bar.Grow(bar);
        
        bar.Set('chart.colors.sequential', true);
        bar.Set('chart.shadow', true);
        bar.Set('chart.shadow.color', '#ccc');  
        bar.Set('chart.ylabels.count', 5);
        bar.Set('chart.variant', '3d');
        bar.Set('chart.strokestyle', 'transparent');
        bar.Set('chart.scale.round', true);
        
        bar.Draw();
        
        /**
        * Now the chart has been drawn use the coords to create some appropriate gradients
        */
        for (var i=0,colors=[]; i<bar.coords.length; ++i) {
        
            var x = bar.coords[i][0];
            var y = bar.coords[i][1];
            var w = bar.coords[i][0] + bar.coords[i][2];
            var h = bar.coords[i][1];

            colors[i] = RGraph.LinearGradient(bar, x, y, w, h, '#00c', 'blue')
        }

        bar.Set('chart.colors', colors);
        RGraph.Clear(bar.canvas);
        RGraph.Redraw();
    }
</script>
<?
echo "<table class=\"index\">";

if ($opd) {
echo "<tr class=bgTitleTr>
		<th class=white colspan=10 valign=top><a href=javascript:history.go(-1)><img src=/i/icon/prev_month.gif border=0></a></th>
    </tr>
    ";
}
echo "<tr class=bgTitleTr>
		<th class=white  valign=top>Nama OPD</th>
		<th class=white  valign=top>Hibah</th>
        <th class=white  valign=top>Bantuan Sosial</th>
    </tr>
    ";
echo $table_rows;
echo "<tr><td><b>Total Data</b></td><td>$num_hibah_1</td><td>$num_bansos_1</td></tr>";
echo "</table>";

$t->basicfooter();
?>