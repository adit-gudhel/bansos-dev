function sendForm() {
        this.f1.act.value = this.f1.tempact.value;
        this.f1.submit();
}

function chooseVendor(myval) {
	if(myval=='add_new_vendor') {
		location.href('../inventory/vendor.php?act=add');
	
	}
	return false;
}

function createRequestObject() {
    var ro;
    var browser = navigator.appName;
    if(browser == "Microsoft Internet Explorer"){
        ro = new ActiveXObject("Microsoft.XMLHTTP");
    }else{
        ro = new XMLHttpRequest();
    }
    return ro;
}



function checkExchangeRate(id) {
    http.open('get', 'rpc.php?id='+id);
    http.onreadystatechange = handleResponse;
    http.send(null);
}

function handleResponse() {
    if(http.readyState == 4){
		document.f1.exchange_rate.value=http.responseText;
		//alert(http.responseText);
    }
}


function checkUsefulLife(id) {
    http.open('get', 'useful_life.php?id='+id);
    http.onreadystatechange = handleResponseUsefulLife;
    http.send(null);
}

function handleResponseUsefulLife() {
    if(http.readyState == 4){
		document.f1.useful_life.value=http.responseText;
		//alert(http.responseText);
    }
}

function checkStock(id) {
    randval=Math.random();
    http.open('get', 'check_stock.php?id='+id+'&randval='+randval);
    http.onreadystatechange = handleResponseStock;
    http.send(null);
}


function handleResponseStock() {
    if(http.readyState == 4){
		document.f1.stock.value=http.responseText;
		//alert(http.responseText);
    }
}

function checkStockAsset(description) {
    randval=Math.random();
    http.open('get', 'check_stock_asset.php?description='+description+'&randval='+randval);
    http.onreadystatechange = handleResponseStockAsset;
    http.send(null);
}

function handleResponseStockAsset() {
    if(http.readyState == 4){
		document.f1.stock.value=http.responseText;
    }
}

function checkStockInventory(description) {
    randval=Math.random();
    url='check_stock_inventory.php?id='+description+'&randval='+randval;
    http.open('get',url);
    http.onreadystatechange = handleResponseStockInventory;
    http.send(null);
}

function handleResponseStockInventory() {
    if(http.readyState == 4){
		document.f1.stock_on_request.value=http.responseText;
    }
}

function chooseDepartment(id) {
    randval=Math.random();
    http.open('get', 'generate_po_number.php?id='+id+'&randval='+randval);
    http.onreadystatechange = handleResponseDepartment;
    http.send(null);
}

function handleResponseDepartment() {
    if(http.readyState == 4){
		document.f1.po_number.value=http.responseText;
		//alert(http.responseText);
    }
}

function checkRegional(id,randval,checkuseful) {
    if(checkuseful=='1'){
	    checkUsefulLife(id);
    }
    http.open('get', 'check_regional.php?id='+id+'&rand='+randval);
    http.onreadystatechange = handleResponseRegional;
    http.send(null);




}

function handleResponseRegional() {
    if(http.readyState == 4){
	    var response = http.responseText;
	    var update = new Array();
	    var subCat	= new Array();
		var mydel=response.indexOf('||');
		if(response.indexOf('||') != -1) {
			update = response.split('||');
			//reset value2 sebelumnya!


			var boxLength = document.f1.office_id.length;
			arrSelected = new Array();
			var count = 0;

			var x;
			for (l = 0; l < boxLength; l++) {
			  	document.f1.office_id.options[l+1] = new Option('','');
			}


			for(var i=0;i<update.length;i++){
				var subCat=update[i].split(';;');	
				document.f1.office_id.options[i+1]=new Option(subCat[1],subCat[0]);
			}
		} 

    }
}

function calculateNBV(id,randval) {
    disposalDate=document.f1.disposal_date.value;
 // alert(disposalDate);
    http.open('get', 'check_nbv.php?id='+id+'&disposal_date='+disposalDate+'&randval='+randval);
//    alert(disposalDate);
    http.onreadystatechange = handleResponseCalculateNBV;
    http.send(null);

}

function handleResponseCalculateNBV() {
    if(http.readyState == 4){
	    var response = http.responseText;
	    document.f1.nbvtemp.value=http.responseText;
	   document.f1.nbv.value=http.responseText;
	   //alert(http.responseText);
    }
}

function generateMID(id) {
    randval=Math.random();

	var missinginfo="";
	var selectedItem        	= document.f1.bii_branch.selectedIndex;
	var selectedBIIBranch  	= document.f1.bii_branch.options[selectedItem].value;
	var selectedItem        	= document.f1.area.selectedIndex;
	var selectedArea  		= document.f1.area.options[selectedItem].value;
	if (selectedBIIBranch==""){
		missinginfo += "\n     -  Branch / HQ";
	}
	if (selectedArea==""){
		missinginfo += "\n     -  Area";
	}

	if (missinginfo != "") {
                        missinginfo ="_____________________________\n" +
                        "Please fill in this required information:\n" +
                        missinginfo + "\n_____________________________" +
                        "\nPlease re-enter and submit button GenerateMID again!";
                        alert(missinginfo);
                        return false;
        } else {

	}

	http.open('get', 'generate_mid.php?cabang='+selectedBIIBranch+'&area='+selectedArea+'&randval='+randval);
	http.onreadystatechange = handleResponseGenerateMID;
	http.send(null);

}

function handleResponseGenerateMID() {
    if(http.readyState == 4){
	  var response = http.responseText;
	  document.f1.merchant_no.value=http.responseText;
    }
}
function generateTID(id) {
    randval=Math.random();

	var missinginfo="";
	var selectedItem        	= document.f1.mcc.selectedIndex;
	var selectedMCC  		= document.f1.mcc.options[selectedItem].value;
	var selectedItem        	= document.f1.area.selectedIndex;
	var selectedArea  		= document.f1.area.options[selectedItem].value;
	if (selectedMCC==""){
		missinginfo += "\n     -  MCC";
	}
	if (selectedArea==""){
		missinginfo += "\n     -  Area";
	}

	if (missinginfo != "") {
                        missinginfo ="_____________________________\n" +
                        "Please fill in this required information:\n" +
                        missinginfo + "\n_____________________________" +
                        "\nPlease re-enter and submit button Generate TID again!";
                        alert(missinginfo);
                        return false;
        } else {

	}

	http.open('get', 'generate_tid.php?mcc='+selectedMCC+'&area='+selectedArea+'&randval='+randval);
	http.onreadystatechange = handleResponseGenerateTID;
	http.send(null);

}

function handleResponseGenerateTID() {
    if(http.readyState == 4){
	  var response = http.responseText;
	  document.f1.tid.value=http.responseText;
    }
}


function checkSubCategory(id,randval,checkuseful) {
    if(checkuseful=='1'){
	    checkUsefulLife(id);
    }
    http.open('get', 'check_sub_category.php?id='+id+'&rand='+randval);
    http.onreadystatechange = handleResponseSubCategory;
    http.send(null);

}

function handleResponseSubCategory() {
    if(http.readyState == 4){
			//document.f1.useful_life.value=http.responseText;
	    var response = http.responseText;
	    var update = new Array();
	    var subCat	= new Array();
		var mydel=response.indexOf('||');
		//alert(response.indexOf(||));
		//alert(mydel);
		//alert(response);
		if(response.indexOf('||') != -1) {
			update = response.split('||');
			//reset value2 sebelumnya!


			var boxLength = document.f1.sub_category_id.length;
			arrSelected = new Array();
			var count = 0;

			var x;
			for (l = 0; l < boxLength; l++) {
			  	document.f1.sub_category_id.options[l+1] = new Option('','');
			}


			for(var i=0;i<update.length;i++){
				var subCat=update[i].split(';;');	
				document.f1.sub_category_id.options[i+1]=new Option(subCat[1],subCat[0]);
			}
		} 

    }
}

function checkStorage(id,randval) {

    http.open('get', 'check_storage.php?id='+id+'&rand='+randval);
    http.onreadystatechange = handleResponseStorage;
    http.send(null);




}

function handleResponseStorage() {
    if(http.readyState == 4){
	    var response = http.responseText;
	    var update = new Array();
	    var subCat	= new Array();
		var mydel=response.indexOf('||');
		if(response.indexOf('||') != -1) {
			update = response.split('||');
			//reset value2 sebelumnya!

			var boxLength = document.f1.storage_id.length;
			arrSelected = new Array();
			var count = 0;

			var x;
			for (l = 0; l < boxLength; l++) {
			  	document.f1.storage_id.options[l+1] = new Option('','');
			}


			for(var i=0;i<update.length;i++){
				var subCat=update[i].split(';;');	
				document.f1.storage_id.options[i+1]=new Option(subCat[1],subCat[0]);
			}
		} 
    }
}

function checkProduct(id) {
    http.open('get', 'check_product.php?sub_category_id='+id);
    http.onreadystatechange = handleResponseProduct;
    http.send(null);
}


function handleResponseProduct() {
    if(http.readyState == 4){
	    var response = http.responseText;
	    var update = new Array();
	    var subCat	= new Array();
		var mydel=response.indexOf('||');
		//alert(response.indexOf(||));
		//alert(mydel);
		//alert(response);
		if(response.indexOf('||') != -1) {
			update = response.split('||');
			//reset value2 sebelumnya!


			var boxLength = document.f1.product_id.length;
			arrSelected = new Array();
			var count = 0;

			var x;
			for (l = 0; l < boxLength; l++) {
			  	document.f1.product_id.options[l+1] = new Option('','');
			}


			for(var i=0;i<update.length;i++){
				var subCat=update[i].split(';;');	
				document.f1.product_id.options[i+1]=new Option(subCat[1],subCat[0]);
			}
		} 

    }
}


function checkNode(id,randval) {

    http.open('get', 'check_table.php?id='+id+'&rand='+randval);
    http.onreadystatechange = handleResponseTable;
    http.send(null);

}

function handleResponseTable() {
	if(http.readyState == 4){
		var response = http.responseText;
		//alert(response);
		var update = new Array();
		var subCat	= new Array();
		var mydel=response.indexOf('||');
		if(response.indexOf('||') != -1) {
			update = response.split('||');

			var boxLength = document.f1.node_id.length;
			//alert('boxlength'+ boxLength)
			arrSelected = new Array();
			var count = 0;

			var x;
			for (l = 0; l < boxLength; l++) {
			  	document.f1.node_id.options[l+1] = new Option('','');
			}


			for(var i=0;i<update.length;i++){
				var subCat=update[i].split(';;');	
				document.f1.node_id.options[i+1]=new Option(subCat[1],subCat[0]);
			}
		} 

	}
}

function checkMerchant(id) {
	randval=Math.random();
	url='check_merchant.php?id='+id+'&rand='+randval;
 
   //alert(url);
  	http.open('get', url);
   

    http.onreadystatechange = handleResponseMerchant;
    http.send(null);

}

function handleResponseMerchant() {
	if(http.readyState == 4){
		var response = http.responseText;
		//alert(response);
		var update = new Array();
		var subCat	= new Array();
		var mydel=response.indexOf('||');
		if(response.indexOf('||') != -1) {
			update = response.split('||');
			var boxLength = document.f1.merchant_id.length;
			//alert('boxlength'+ boxLength)
			arrSelected = new Array();
			var count = 0;

			var x;
			for (l = 0; l < boxLength; l++) {
			  	document.f1.merchant_id.options[l+1] = new Option('','');
			}


			for(var i=0;i<update.length;i++){
				var subCat=update[i].split(';;');	
				document.f1.merchant_id.options[i+1]=new Option(subCat[1],subCat[0]);
			}
		} 
	}
}

function checkAssetDescription(id,randval) {

    http.open('get', 'check_asset_description.php?id='+id+'&rand='+randval);
    http.onreadystatechange = handleResponseAssetDescription;
    http.send(null);

}

function handleResponseAssetDescription() {
	if(http.readyState == 4){
		var response = http.responseText;
		//alert(response);
		var update = new Array();
		var subCat	= new Array();
		var mydel=response.indexOf('||');
		if(response.indexOf('||') != -1) {
			update = response.split('||');

			var boxLength = document.f1.description_exist.length;
			//alert('boxlength'+ boxLength)
			arrSelected = new Array();
			var count = 0;

			var x;
			for (l = 0; l < boxLength; l++) {
			  	document.f1.description_exist.options[l+1] = new Option('','');
			}


			for(var i=0;i<update.length;i++){
				var subCat=update[i].split(';;');	
				document.f1.description_exist.options[i+1]=new Option(subCat[1],subCat[0]);
			}
		} 

	}
}

function checkProductStock(id,randval) {

    http.open('get', 'check_product_stock.php?id='+id+'&rand='+randval);
    http.onreadystatechange = handleResponseProductStock;
    http.send(null);

}

function handleResponseProductStock() {
	if(http.readyState == 4){
		var response = http.responseText;
		//alert(response);
		var update = new Array();
		var subCat	= new Array();
		var mydel=response.indexOf('||');
		if(response.indexOf('||') != -1) {
			update = response.split('||');

			var boxLength = document.f1.product_id.length;
			//alert('boxlength'+ boxLength)
			arrSelected = new Array();
			var count = 0;

			var x;
			for (l = 0; l < boxLength; l++) {
			  	document.f1.product_id.options[l+1] = new Option('','');
			}


			for(var i=0;i<update.length;i++){
				var subCat=update[i].split(';;');	
				document.f1.product_id.options[i+1]=new Option(subCat[1],subCat[0]);
			}
		} 

	}
}

function checkLocation(id,randval) {

    http.open('get', 'check_location.php?id='+id+'&rand='+randval);
    http.onreadystatechange = handleResponseLocation;
    http.send(null);

}

function handleResponseLocation() {
	if(http.readyState == 4){
		var response = http.responseText;
		//alert(response);
		var update = new Array();
		var subCat	= new Array();
		var mydel=response.indexOf('||');
		if(response.indexOf('||') != -1) {
			update = response.split('||');

			var boxLength = document.f1.location_id.length;
			//alert('boxlength'+ boxLength)
			arrSelected = new Array();
			var count = 0;

			var x;
			for (l = 0; l < boxLength; l++) {
			  	document.f1.location_id.options[l+1] = new Option('','');
			}


			for(var i=0;i<update.length;i++){
				var subCat=update[i].split(';;');	
				document.f1.location_id.options[i+1]=new Option(subCat[1],subCat[0]);
			}
		} 

	}
}


var http = createRequestObject();



function checkFieldsAddFA() {
                missinginfo = "";
		var selectedItem 	= document.f1.category_id.selectedIndex;
		var selectedCategoryID 	= document.f1.category_id.options[selectedItem].value;

		var selectedItem 	= document.f1.department_id.selectedIndex;
		var selectedDepartmentID= document.f1.department_id.options[selectedItem].value;

                //if (document.f1.description.value == "") {
                //        missinginfo += "\n     -  Description";
                //}
                if (document.f1.acquisition_cost.value == "") {
                        missinginfo += "\n     -  Acquisition Cost";
                }
                if (document.f1.sticker_number.value == "") {
                        missinginfo += "\n     -  Sticker Number";
                }

                if (document.f1.purchase_date.value == "") {
                        missinginfo += "\n     -  Purchase Date";
                }

                if (document.f1.useful_life.value == "") {
                        missinginfo += "\n     -  Useful Life";
                }

		if (selectedCategoryID==""){
		        missinginfo += "\n     -  Category";
		}


		if (selectedDepartmentID==""){
		        missinginfo += "\n     -  Department";
		}

		
                if (missinginfo != "") {
                        missinginfo ="_____________________________\n" +
                        "Please fill in this required information:\n" +
                        missinginfo + "\n_____________________________" +
                        "\nPlease re-enter and submit again!";
                        alert(missinginfo);
                        return false;
                }
                else return true;
}

function checkFieldsDisposal() {

                missinginfo = "";
                if (document.f1.proceeds_of_sale.value == "") {
                        missinginfo += "\n     -  Proceeds of sale";
                }
                if (document.f1.disposal_date.value == "") {
                        missinginfo += "\n     -  Disposal Date";
                }

                if (missinginfo != "") {
                        missinginfo ="_____________________________\n" +
                        "Please fill in this required information:\n" +
                        missinginfo + "\n_____________________________" +
                        "\nPlease re-enter and submit again!";
                        alert(missinginfo);
                        return false;
                }
                else return true;
}

function confirmSubmit(){
	var agree=confirm("Are you sure you wish to continue?");
	if (agree)
		return true ;
	else
		return false ;
}


function calculateGainLoss(myval){
			var nbv=document.f1.nbv.value;
			gainLoss =  parseInt(nbv) - parseInt(myval) ;
			document.f1.gain_loss.value=gainLoss;
			gainLoss = Math.abs(gainLoss);
			document.f1.gain_loss_temp.value=gainLoss;
}

function closeAdvanceSearchBox(i){
	document.getElementById('t'+i).style.display='none';
}
function openAdvanceSearchBox(i){
	document.getElementById('t'+i).style.display='block';
}

function SelectAll( ){
        for (var i=0;i<document.myform.elements.length;i++){
                var e = document.myform.elements[i];
                e.checked = true;
        }
}

function DeselectAll( ){
        for (var i=0;i<document.myform.elements.length;i++){
                var e = document.myform.elements[i];
                e.checked = false;
        }
}
	function openNewWindows(mypage,myname,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+''
	win = window.open(mypage,myname,settings)
	if(win.window.focus){win.window.focus();}
	}
