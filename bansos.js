
$(function() {
    
    $('#ff').form({  
        success:function(data){  
            $.messager.alert('Info', data, 'info', function(r){
                location.href='bansos.php';
            });
        }  
    });
    
    $( "#ban_tanggal" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });
    
});
 