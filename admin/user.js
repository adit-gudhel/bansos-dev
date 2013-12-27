$(function () {
    
            $('#satker1').change(function(event){
                var rand = Math.floor(Math.random()*11);
                $.ajax({
                    type : "GET",
                    url : "user.php",
                    data : 'ajaxselect=satker1&satker1='+ $('#satker1').val()+'&r='+ rand,
                    success : function(data){
                        update = data.split('||');
                        $('#satker2').removeOption(/./);
                        $('#satker3').removeOption(/./);
                        var box_length = 1;
				        arrSelected = new Array();
				    	var count = 0;
				    	var x;
                        $("#satker2").addOption('', '-');
                        
				    	for(var i=0;i<update.length;i++){
				    	    var subCat=update[i].split(';;');
                            $("#satker2").addOption(subCat[0],subCat[1]);
				    	}
                        $("#satker2").selectOptions("");
                    }
                });
                return false;
            });
            
            $('#satker2').change(function(event){
                var rand = Math.floor(Math.random()*11);
                $.ajax({
                    type : "GET",
                    url : "user.php",
                    data : 'ajaxselect=satker2&satker2='+ $('#satker2').val()+'&r='+ rand,
                    success : function(data){
                        update = data.split('||');
                        $('#satker3').removeOption(/./);
                        var box_length = 1;
				        arrSelected = new Array();
				    	var count = 0;
				    	var x;
                        $("#satker3").addOption('', '-');
                        
				    	for(var i=0;i<update.length;i++){
				    	    var subCat=update[i].split(';;');
                            $("#satker3").addOption(subCat[0],subCat[1]);
				    	}
                        $("#satker3").selectOptions("");
                    }
                });
                return false;
            });


}); 