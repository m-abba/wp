function greet() {
	/*Use prompt to get name and save to a variable */
	let name = prompt('What is your name?', 'Type name here');
	/*Display a greeting including the name variable */
	alert('Hello ' + name);
}

alert('Just to show you that code NOT in a function\n will be executed automatically');