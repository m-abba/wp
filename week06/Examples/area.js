function calculateArea() {
	let length = document.getElementById("field1").value;
	let width = document.getElementById("field2").value;
	let area = length * width;
	document.getElementById("field3").value = area;
}