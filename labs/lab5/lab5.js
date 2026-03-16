function validate(formObj) {

   if (formObj.firstName.value == "") {
      alert("You must enter a first name");
      formObj.firstName.focus();
      return false;
   }
   
   if (formObj.lastName.value == "") {
      alert("You must enter a last name");
      formObj.lastName.focus();
      return false;
   }
   
   if (formObj.title.value == "") {
      alert("You must enter a title");
      formObj.title.focus();
      return false;
   }
   
   if (formObj.org.value == "") {
      alert("You must enter an organization");
      formObj.org.focus();
      return false;
   }
   
   if (formObj.pseudonym.value == "") {
      alert("You must enter a nickname");
      formObj.pseudonym.focus();
      return false;
   }
   
   if (formObj.comments.value == "" || formObj.comments.value == "Please enter your comments") {
      alert("You must enter your comments");
      formObj.comments.focus();
      return false;
   }
   
   alert("Form successfully submitted!");
   return true;
}

// Shows Full Name and Nickname
function showNickname() {
   var first = document.getElementById("firstName").value;
   var last = document.getElementById("lastName").value;
   var nick = document.getElementById("pseudonym").value;
   
   alert(first + " " + last + " is " + nick);
}


// If comment left blank original text will stay
function restoreText() {
   var commentsBox = document.getElementById("comments");
   if (commentsBox.value == "") {
      commentsBox.value = "Please enter your comments";
   }
}

// Clears original text if comment added
function clearText() {
   var commentsBox = document.getElementById("comments");
   if (commentsBox.value == "Please enter your comments") {
      commentsBox.value = "";
   }
}


// Automatically go to first element(name) when website loads
window.onload = function() {
   document.getElementById("firstName").focus();
};