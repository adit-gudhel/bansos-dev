
$(function() {
    
    $('#ff').form({  
        success:function(data){  
            $.messager.alert('Info', data, 'info', function(r){
                location.href='lpj_hibah.php';
            });
        }  
    });
    
    $( "#tgl_lpj" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });
	
	$( "#hib_nama" ).autocomplete({
        minLength: 2,
        source:'autocomplete_monev_hibah.php',
        focus: function( event, ui ) {
            $( "#hib_nama" ).val( ui.item.label );
            return false;
        },
        select: function( event, ui ) {
            $( "#hib_nama" ).val( ui.item.value );
            $( "#hib_kode" ).val( ui.item.hib_kode);
            return false;
        }
    });
    
});
 