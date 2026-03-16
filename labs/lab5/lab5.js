/* Lab 5 JavaScript File 
   Place variables and functions in this file */

function validate(formObj) {
   // put your validation code here
   // it will be a series of if statements

   if (formObj.firstName.value == "") {
      alert("You must enter a first name");
      formObj.firstName.focus();
      return false;
   }
   return true;
}
