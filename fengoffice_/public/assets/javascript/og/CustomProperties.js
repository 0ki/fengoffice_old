og.addCPValue = function(id, name, numeric){
 	var value = document.getElementById("field" + id).value;
 	if(value == ""){
 		alert(lang("value cannot be empty"));
 		return;
 	}
 	if(numeric && isNaN(value)){
 		alert(lang("value must be numeric"));
 		return;
 	}
 	document.getElementById("field" + id).value = "";
 	var valueList = document.getElementById(name);
 	var valueCount =  valueList.options.length;
 	for (i=0; i<valueCount; i++) {
 		if (valueList.options[i].value == value) {
 			alert(lang("value is alerady in the list"));
 			return;
 		}
 	}
 	var newValue = new Option(value, value);
 	newValue.selected = true;
 	if (valueList.selectedIndex != -1)
 		valueList.options[valueList.selectedIndex].selected = false;
 	valueList.options[valueCount] = newValue;
 	
 	// remove substring "list-" from name to save the value
 	var splitted = name.split('-');
 	var sep = valueCount > 0 ? "," : "";
 	document.getElementById(splitted[1]).value += sep + value;
};
 
og.removeCPValue = function(name){
 	var valueList = document.getElementById(name);
 	if (valueList.selectedIndex != -1) {
 		var splitted = name.split('-');
 		var valContainer = document.getElementById(splitted[1])
 		newVal = valContainer.value.replace(valueList.options[valueList.selectedIndex].value, '');
 		newVal = newVal.replace(',,', ',');
 		while (newVal.substr(newVal.length - 1) == ",")
 			newVal = newVal.substr(0, newVal.length - 1);
 		while (newVal.substr(0, 1) == ",")
 			newVal = newVal.substr(1, newVal.length);
 			
 		document.getElementById(splitted[1]).value = newVal;
 	
 		valueList.remove(valueList.selectedIndex);
 	}
};