
$(function() {
    
    $('#ff').form({  
        success:function(data){  
            $.messager.alert('Info', data, 'info', function(r){
                location.href='lpj_hibah.php';
            });
        }  
    });
    
    $( "#lpj_tgl" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });
	
    
});
 