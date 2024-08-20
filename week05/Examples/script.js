// let a = parseInt(10.34); // a = 10
// let b = 20; 

// let sum = a + b; 
// let sub = a - b;
// let product = a * b;
// let div = a / b;

// console.log(" a + b = " + sum); 
// console.log(" a - b =  " + sub); 
// console.log(" a * b = " + product); 
// console.log(" a / b =  " + div); 

// var numbers = [1, 3, 5, 9]

// alert(numbers[0])
// alert(numbers.length) // 4

var book = {
    title: "The Giver",
    author: "Lois Lowry"
}

for (property in book ) {
    // alert(property + " = " + book[property]);
    document.write(property + " = " + book[property] + "<br>");
}

// alert(book.title);
// alert(book.author);
