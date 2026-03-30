
alert("The page is about to load!");

$(document).ready(function () {
  const defaultTitle = "ITWS 1100 - Quiz 2";
  const myTitle = "Christopher Hernandez – Quiz 2";

  document.title = defaultTitle;

  $("#go to this page").click(function () {
    if (document.title = defaultTitle) {
      document.title = myTitle;
    } else {
      document.title = defaultTitle;
    }
  });

  $("#lastName").hover(
    function () {
      $(this).addClass("makeItPurple");
    },
    function () {
      $(this).removeClass("makeItPurple");
    }
  );
});



