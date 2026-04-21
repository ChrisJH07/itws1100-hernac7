<?php
include('includes/init.inc.php'); // include the DOCTYPE and opening tags
include('includes/functions.inc.php'); // functions
?>
<title>PHP &amp; MySQL - ITWS</title>

<?php
include('includes/head.inc.php');
// include global css, javascript, end the head and open the body
?>

<h1>PHP &amp; MySQL</h1>

<?php include('includes/menubody.inc.php'); ?>

<?php
$dbOk = false;

@$db = new mysqli('localhost', 'root', 'root', 'iit');

if ($db->connect_error) {
   echo '<div class="messages">Could not connect to the database. Error: ';
   echo $db->connect_errno . ' - ' . $db->connect_error . '</div>';
} else {
   $dbOk = true;
}

$havePost = isset($_POST["save"]);

$errors = '';
if ($havePost) {

   $title = htmlspecialchars(trim($_POST["title"]));
   $year  = htmlspecialchars(trim($_POST["year"]));

   $focusId = '';

   if ($title == '') {
      $errors .= '<li>Title may not be blank</li>';
      if ($focusId == '') $focusId = '#title';
   }
   if ($year == '') {
      $errors .= '<li>Year may not be blank</li>';
      if ($focusId == '') $focusId = '#year';
   }
   if ($year != '' && (!is_numeric($year) || strlen($year) != 4)) {
      $errors .= '<li>Enter a valid 4-digit year</li>';
      if ($focusId == '') $focusId = '#year';
   }

   if ($errors != '') {
      echo '<div class="messages"><h4>Please correct the following errors:</h4><ul>';
      echo $errors;
      echo '</ul></div>';
      echo '<script type="text/javascript">';
      echo '  $(document).ready(function() {';
      echo '    $("' . $focusId . '").focus();';
      echo '  });';
      echo '</script>';
   } else {
      if ($dbOk) {
         $titleForDb = trim($_POST["title"]);
         $yearForDb  = trim($_POST["year"]);

         $insQuery = "insert into movies (`title`, `year`) values(?, ?)";
         $statement = $db->prepare($insQuery);
         $statement->bind_param("ss", $titleForDb, $yearForDb);
         $statement->execute();

         echo '<div class="messages"><h4>Success: ' . $statement->affected_rows . ' movie added to database.</h4>';
         echo $title . ' (' . $year . ')</div>';

         $statement->close();
      }
   }
}
?>

<h3>Add Movie</h3>
<form id="addForm" name="addForm" action="movies.php" method="post" onsubmit="return validateMovie(this);">
   <fieldset>
      <div class="formData">

         <label class="field" for="title">Title:</label>
         <div class="value"><input type="text" size="60" value="<?php if ($havePost && $errors != '') { echo $title; } ?>" name="title" id="title" /></div>

         <label class="field" for="year">Year of release:</label>
         <div class="value"><input type="text" size="4" maxlength="4" value="<?php if ($havePost && $errors != '') { echo $year; } ?>" name="year" id="year" /> <em>yyyy</em></div>

         <input type="submit" value="save" id="save" name="save" />
      </div>
   </fieldset>
</form>

<h3>Movies</h3>
<table id="movieTable">
   <?php
   if ($dbOk) {

      $query = 'select * from movies order by title';
      $result = $db->query($query);

      if (!$result) {
         echo '<tr><td>Database error: ' . $db->error . '</td></tr>';
      } else {
         $numRecords = $result->num_rows;

         echo '<tr><th>Title:</th><th>Year of Release:</th><th></th></tr>';
         for ($i = 0; $i < $numRecords; $i++) {
            $record = $result->fetch_assoc();
            if ($i % 2 == 0) {
               echo "\n" . '<tr id="movie-' . $record['movieid'] . '"><td>';
            } else {
               echo "\n" . '<tr class="odd" id="movie-' . $record['movieid'] . '"><td>';
            }
            echo htmlspecialchars($record['title']);
            echo '</td><td>';
            echo htmlspecialchars($record['year']);
            echo '</td><td>';
            echo '<img src="resources/delete.png" class="deleteMovie" width="16" height="16" alt="delete movie"/>';
            echo '</td></tr>';
         }

         $result->free();
      }
      $db->close();
   }
   ?>
</table>

<script type="text/javascript">
function validateMovie(formObj) {
   if (formObj.title.value == "") {
      alert("Please enter a movie title");
      formObj.title.focus();
      return false;
   }
   if (formObj.year.value == "") {
      alert("Please enter a year");
      formObj.year.focus();
      return false;
   }
   return true;
}

$(document).ready(function() {

   $("#title").focus();

   $(".deleteMovie").click(function() {
      if (confirm("Remove movie? (This action cannot be undone.)")) {

         var curId = $(this).closest("tr").attr("id");
         var movieId = curId.substr(curId.indexOf("-") + 1);
         var postData = "id=" + movieId;

         $.ajax({
            type: "post",
            url: "movie-delete.php",
            dataType: "json",
            data: postData,
            success: function(responseData, status) {
               if (responseData.errors) {
                  alert(responseData.errno + " " + responseData.error);
               } else {
                  $("#" + curId).closest("tr").remove();
                  $(".messages").hide();
                  $("#jsMessages").html("<h4>Movie deleted</h4>").show();

                  $("#movieTable tr").each(function(i) {
                     if (i % 2 == 0) {
                        $(this).addClass("odd");
                     } else {
                        $(this).removeClass("odd");
                     }
                  });
               }
            },
            error: function(msg) {
               alert(msg.status + " " + msg.statusText);
            }
         });
      }
   });

});
</script>

<?php include('includes/foot.inc.php'); ?>
