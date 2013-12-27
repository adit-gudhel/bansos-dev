
$(function() {
    
    $('#ff').form({  
        success:function(data){  
            $.messager.alert('Info', data, 'info', function(r){
                location.href='hibah.php';
            });
        }  
    });
    
    $( "#hib_tanggal" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });
    
});
 