<?php 
include('includes/init.inc.php');
include('includes/functions.inc.php');
?>

<title>Movies</title>

<?php include('includes/head.inc.php'); ?>

<h1>Movies</h1>

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
?>

<h3>Movie List</h3>

<table>
<?php
if ($dbOk) {

    $query = 'SELECT * FROM movies ORDER BY title';
    $result = $db->query($query);
    $numRecords = $result->num_rows;

    echo '<tr><th>Title</th><th>Year</th></tr>';

    for ($i = 0; $i < $numRecords; $i++) {
        $record = $result->fetch_assoc();

        if ($i % 2 == 0) {
            echo '<tr>';
        } else {
            echo '<tr class="odd">';
        }

        echo '<td>' . htmlspecialchars($record['title']) . '</td>';
        echo '<td>' . htmlspecialchars($record['year']) . '</td>';
        echo '</tr>';
    }

    $result->free();
    $db->close();
}
?>
</table>

<?php include('includes/foot.inc.php'); ?>
