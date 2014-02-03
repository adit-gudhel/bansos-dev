
$(function() {
    
    $('#ff').form({  
        success:function(data){  
            $.messager.alert('Info', data, 'info', function(r){
                location.href='rekening_hibah.php';
            });
        }  
    });
    
    
});
 