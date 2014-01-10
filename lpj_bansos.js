
$(function() {
    
    $('#ff').form({  
        success:function(data){  
            $.messager.alert('Info', data, 'info', function(r){
                location.href='lpj_bansos.php';
            });
        }  
    });
    
    $( "#tgl_lpj" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });
	
	$( "#hib_nama" ).autocomplete({
        minLength: 2,
        source:'autocomplete_lpj_bansos.php',
        focus: function( event, ui ) {
            $( "#ban_nama" ).val( ui.item.label );
            return false;
        },
        select: function( event, ui ) {
            $( "#ban_nama" ).val( ui.item.value );
            $( "#ban_kode" ).val( ui.item.ban_kode);
            return false;
        }
    });
    
});
 