/* In-class JavaScript File
   Place variables and functions in this file */

// variables declared outside of functions are global (scope)
var example = "An example.";
var firstName = "Hector";
var insuranceCutOffAge = 26;
var age = 19;


function example() {
  alert(example);
}

function example2() {
  // variables declared inside a function are local to that function (scope)
  var example = "A different example.";
  alert(example);
}


            // slide 27 - form
//   function showName(formObj) {
//     alert(formObj.fname.value + ' ' + formObj.lname.value);
//  }
         