
$(function() {
    
    $('#ff').form({  
        success:function(data){  
            $.messager.alert('Info', data, 'info', function(r){
                location.href='evaluasi_hibah_opd.php';
            });
        }  
    });
	
	$( "#sk_tgl" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });
	
	$( "#ba_tgl" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });
	
});
 