
$(function() {
    
    $('#ff').form({  
        success:function(data){  
            $.messager.alert('Info', data, 'info', function(r){
                location.href='pencairan_hibah.php';
            });
        }  
    });
    
	$( "#hib_nama" ).autocomplete({
        minLength: 2,
        source:'autocomplete_cair_hibah.php',
        focus: function( event, ui ) {
            $( "#hib_nama" ).val( ui.item.value );
            return false;
        },
        select: function( event, ui ) {
			$( "#hib_nama" ).val( ui.item.value );
            $( "#hib_kode" ).val( ui.item.hib_kode );
            $( "#besaran_tapd" ).val( ui.item.besaran_tapd);
            return false;
        }
    });
	
    $( "#tgl_cair" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });
    
	$( "#spph_tgl" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });
	
	$( "#nphd_tgl" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });
	
	$( "#sp2d_tgl" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });
	
});
 