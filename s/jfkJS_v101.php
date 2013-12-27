<script language=javascript>
function isEmpty(str) {
   if (str.value.length == 0) { return true; } return false;
}

function isSelected(sel) {
   if (sel.selectedIndex == 0) {return false; } return true;
}

var daysOfMonth = [0,31,28,31,30,31,30,31,31,30,31,30,31];

function DateValidate(day,month,year)
{
// an obvious screw
	if(day > 31 || month > 13) return false;
	if(month == 2 && (year % 4) == 0) {
		if( 29 >= day)return true;
	} else {
		if(daysOfMonth[month] >= day) return true; 
	}
	return false;
}

var monthOfYear = ["","Januari","Pebruari","Maret","April","Mei","Juni", "Juli","Agustus","September","Oktober","Nopember","Desember"];

function CheckDate(date,month,year) {
	var dateVal = date.options[date.selectedIndex].value;
	//var monthVal = month.options[month.selectedIndex].value;
	var monthVal = month.selectedIndex;
	var yearVal = year.options[year.selectedIndex].value;
	if (!DateValidate(parseInt(dateVal), parseInt(monthVal), parseInt(yearVal)) ) { 
		//alert("CheckDate Invalid Date : " + dateVal + " - " + monthOfYear[monthVal] + " - " + yearVal);
		return false; 
	}
	return true;
}

function ReasonableDate(theForm) {
if (theForm.ptime_date.selectedIndex == 0 || theForm.ptime_month.selectedIndex == 0 || theForm.ptime_year.value.length < 4) { 
	if (theForm.ptime_year.value.length < 4) {
		alert("Year must be 4-digit length");
		return false;	
	}
	return false;
}
return true;
}

function CheckEmail(email) {
if (email.value.length > 0) {
	if ((email.value.indexOf('@') == -1) || (email.value.indexOf('.') == -1)) {
		return false;
	}
	if (email.value.indexOf('.') == email.value.length -1) {
		return false;
	}
	return true;
} else { 
	return true;
}
}

function checkUser(userid) { 
   var i;
   var str1 = new String(userid);
   var str = str1.toLowerCase();	
   var len = str.length - 1;

if (str.charCodeAt(0) < "a".charCodeAt(0) || str.charCodeAt(0) > "z".charCodeAt(0)) {
   if (str.charCodeAt(0) < "0".charCodeAt(0) || str.charCodeAt(0) > "9".charCodeAt(0)) {
       alert("karakter pertama pada userid \nharus alphanumerik (a-zA-Z0-9)");
       return false;
   }
}
	
if (str.charCodeAt(len) < "a".charCodeAt(0) || str.charCodeAt(len) > "z".charCodeAt(0)) {
    if (str.charCodeAt(len) < "0".charCodeAt(0) || str.charCodeAt(len) > "9".charCodeAt(0)){        
       alert("karakter terakhir pada userid \nharus alphanumerik (a-zA-Z0-9)");
       return false;
    }
}
	
for(i=1;i < str.length; i++) {
  if (str.charCodeAt(i) >= "a".charCodeAt(0) && str.charCodeAt(i) <= "z".charCodeAt(0)) {
     continue;
  } else if (str.charCodeAt(i) >= "0".charCodeAt(0) && str.charCodeAt(i) <= "9".charCodeAt(0)){
     continue;
  } else if (str.charCodeAt(i) == "_".charCodeAt(0)) {
     continue;
  } else {
     alert("karakter `" + str.charAt(i) + "` tidak valid di user id");
     return false;			
  }
}
return true;
}

</script>
