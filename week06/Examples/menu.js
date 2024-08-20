function doMenu() {
	let menu = document.getElementById("menu");
	let optionNumber = menu.options.selectedIndex;
	let url = menu.options[optionNumber].value;
	location.href = url;
}