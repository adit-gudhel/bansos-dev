
$(function() {
    
    $('#ff').form({  
        success:function(data){  
            $.messager.alert('Info', data, 'info', function(r){
                location.href='pencairan_bansos.php';
            });
        }  
    });
    
	$( "#ban_nama" ).autocomplete({
        minLength: 2,
        source:'autocomplete_cair_bansos.php',
        focus: function( event, ui ) {
            $( "#ban_nama" ).val( ui.item.value );
            return false;
        },
        select: function( event, ui ) {
			$( "#ban_nama" ).val( ui.item.value );
            $( "#ban_kode" ).val( ui.item.ban_kode );
            $( "#besaran_tapd" ).val( ui.item.besaran_tapd);
			//$( "#jml_cair" ).val( ui.item.besaran_tapd);
            return false;
        }
    });
	
    $( "#tgl_cair" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });
    
	$( "#sppbs_tgl" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });
	
	$( "#sp2d_tgl" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });
	
});
 