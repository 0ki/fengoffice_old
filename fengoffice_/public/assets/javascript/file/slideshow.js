function slideshow(url) {
	/* fullscreen windows are annoying so let's size it 80% of the screen size */
	var top = screen.height * 0.1;
	var left = screen.width * 0.1;
	var width = screen.width * 0.8;
	var height = screen.height * 0.8;
	window.open(url, 'slideshow', 'top=' + top + ',left=' + left + ',width=' + width + ',height=' + height + ',status=no,menubar=no,location=no,toolbar=no,scrollbars=no,directories=no,resizable=yes')
}