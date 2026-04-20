<?php
  /* Delete a movie */

  @$db = new mysqli('localhost', 'root', 'root', 'iit');

  if ($db->connect_error) {
    $connectErrors = array(
      'errors' => true,
      'errno' => mysqli_connect_errno(),
      'error' => mysqli_connect_error()
    );
    echo json_encode($connectErrors);
  } else {
    if (isset($_POST["id"])) {
      // get our id and cast as an integer
      $movieId = (int) $_POST["id"];

      // Setup a prepared statement.
      $query = "delete from movies where movieid = ?";
      $statement = $db->prepare($query);
      $statement->bind_param("i", $movieId);
      $statement->execute();

      // return a json object that indicates success
      $success = array('errors' => false, 'message' => 'Delete successful');
      echo json_encode($success);

      $statement->close();
      $db->close();
    }
  }
?>
