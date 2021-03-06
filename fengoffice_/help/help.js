var current = 1;

function $(id) {
	return document.getElementById(id);
}

function showPage(i) {
	$('page' + current).style.display = 'none';
	$('page' + i).style.display = 'block';
	
	if ($('page' + (i - 1))) {
		$('prev').style.visibility = 'visible';
	} else {
		$('prev').style.visibility = 'hidden';
	}
	if ($('page' + (i + 1))) {
		$('next').style.visibility = 'visible';
	} else {
		$('next').style.visibility = 'hidden';
	}
	
	current = i;
}
