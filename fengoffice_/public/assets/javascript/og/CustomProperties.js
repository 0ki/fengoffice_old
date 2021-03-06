og.addCPValue = function(id, memo){	
	var listDiv = document.getElementById('listValues' + id);
	var newValue = document.createElement('div');
	var count = listDiv.getElementsByTagName('div').length;
	newValue.id = 'value' + count;
	if(memo){
		newValue.innerHTML = '<textarea cols="40" rows="10" name="object_custom_properties[' + id + '][]" id="object_custom_properties[' + id + '][]"></textarea>' +
			'&nbsp;<a href="#" class="link-ico ico-add" onclick="og.addCPValue(' + id + ', true)">' + lang('add value') + '</a><br/>';
	}else{
		newValue.innerHTML = '<input type="text" name="object_custom_properties[' + id + '][]" id="object_custom_properties[' + id + '][]" />' +
			'&nbsp;<a href="#" class="link-ico ico-add" onclick="og.addCPValue(' + id + ', false)">' + lang('add value') + '</a><br/>';
	}
	
	listDiv.appendChild(newValue);
	var item = listDiv.childNodes.item(count - 1);
	var value = item.firstChild.value;
	if(memo){
		item.innerHTML = '<textarea cols="40" rows="10" name="object_custom_properties[' + id + '][]" id="object_custom_properties[' + id + '][]">' + value + '</textarea>' +
		'&nbsp;<a href="#" class="link-ico ico-delete" onclick="og.removeCPValue(' + id + ',' + (count - 1) + ', true)" ></a>';
	}else{
		item.innerHTML = '<input type="text" name="object_custom_properties[' + id + '][]" id="object_custom_properties[' + id + '][]" value="' + value + '" />' +
			'&nbsp;<a href="#" class="link-ico ico-delete" onclick="og.removeCPValue(' + id + ',' + (count - 1) + ', false)" ></a>';
	}
};
 
og.removeCPValue = function(id, pos, memo){
	var listDiv = document.getElementById('listValues' + id);
	var item = listDiv.childNodes.item(pos);
	listDiv.removeChild(item);
	var value = '';
	var count = listDiv.getElementsByTagName('div').length;
	if(count == 1){
		item = listDiv.childNodes.item(0);
		value = item.firstChild.value;
		if(memo){
			item.innerHTML = '<textarea cols="40" rows="10" name="object_custom_properties[' + id + '][]" id="object_custom_properties[' + id + '][]">' + value + '</textarea>' +
				'&nbsp;<a href="#" class="link-ico ico-add" onclick="og.addCPValue(' + id + ', true)">' + lang('add value') + '</a><br/>';
		}else{
			item.innerHTML = '<input type="text" name="object_custom_properties[' + id + '][]" id="object_custom_properties[' + id + '][]" value="' + value + '" />' +
				'&nbsp;<a href="#" class="link-ico ico-add" onclick="og.addCPValue(' + id + ', false)">' + lang('add value') + '</a><br/>';
		}
	}else{
		for(i=0; i < listDiv.childNodes.length; i++){
			item = listDiv.childNodes.item(i);
			item.id = 'value' + i;
			value = item.firstChild.value;
			if(i < listDiv.childNodes.length - 1){
				if(memo){
					item.innerHTML = '<textarea cols="40" rows="10" name="object_custom_properties[' + id + '][]" id="object_custom_properties[' + id + '][]">' + value + '</textarea>' +
					'&nbsp;<a href="#" class="link-ico ico-delete" onclick="og.removeCPValue(' + id + ',' + i + ', true)" ></a>';
				}else{
					item.innerHTML = '<input type="text" name="object_custom_properties[' + id + '][]" id="object_custom_properties[' + id + '][]" value="' + value + '" />' +
						'&nbsp;<a href="#" class="link-ico ico-delete" onclick="og.removeCPValue(' + id + ',' + i + ', false)" ></a>';
				}
			}
			
		}
	}
};