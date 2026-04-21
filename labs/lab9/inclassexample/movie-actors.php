<?php
include('includes/init.inc.php');
include('includes/functions.inc.php');
?>
<title>PHP &amp; MySQL - ITWS</title>

<?php include('includes/head.inc.php'); ?>

<h1>PHP &amp; MySQL</h1>

<?php include('includes/menubody.inc.php'); ?>

<h3>Actors in Movies</h3>

<?php
$dbOk = false;

@$db = new mysqli('localhost', 'root', 'root', 'iit');

if ($db->connect_error) {
   echo '<div class="messages">Could not connect to the database. Error: ';
   echo $db->connect_errno . ' - ' . $db->connect_error . '</div>';
} else {
   $dbOk = true;
}

if ($dbOk) {
   $query = 'SELECT m.movieid, m.title, m.year, a.first_names, a.last_name
             FROM movies m
             LEFT JOIN movie_actors ma ON m.movieid = ma.movie_id
             LEFT JOIN actors a ON a.actorid = ma.actor_id
             ORDER BY m.title, a.last_name';

   $result = $db->query($query);

   if (!$result) {
      echo '<div class="messages">Database error: ' . $db->error . '</div>';
   } else {
      $movies = array();
      while ($row = $result->fetch_assoc()) {
         $mid = $row['movieid'];
         if (!isset($movies[$mid])) {
            $movies[$mid] = array(
               'title'  => $row['title'],
               'year'   => $row['year'],
               'actors' => array()
            );
         }
         if ($row['last_name'] != '') {
            $movies[$mid]['actors'][] = $row['first_names'] . ' ' . $row['last_name'];
         }
      }

      echo '<table id="movieActorTable">';
      echo '<tr><th>Title:</th><th>Year:</th><th>Actors:</th></tr>';

      $i = 0;
      foreach ($movies as $movie) {
         if ($i % 2 == 0) {
            echo '<tr>';
         } else {
            echo '<tr class="odd">';
         }
         echo '<td>' . htmlspecialchars($movie['title']) . '</td>';
         echo '<td>' . htmlspecialchars($movie['year']) . '</td>';
         if (count($movie['actors']) > 0) {
            echo '<td>' . htmlspecialchars(implode(', ', $movie['actors'])) . '</td>';
         } else {
            echo '<td><em>No actors listed</em></td>';
         }
         echo '</tr>';
         $i++;
      }

      echo '</table>';
      $result->free();
   }
   $db->close();
}
?>

<?php include('includes/foot.inc.php'); ?>
