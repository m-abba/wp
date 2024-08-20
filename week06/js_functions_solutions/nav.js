function doMenu() {
	let menu = document.getElementById("menu");
	let optionNumber = menu.options.selectedIndex;
	let url = menu.options[optionNumber].value;
	if (url.includes("http")) {
		window.open(url);
	} else {
		location.href = url;
	}
}