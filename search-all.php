<?php
/**
 * Created by PhpStorm.
 * User: Takatathien
 * Date: 11/22/2016
 * Time: 5:22 PM
 *
 * Php file that will run if the user want to know what movies is the actor have played in
 * by looking through the database.
 */

// include the code/function from the common.php
include("common.php");

// get the user input actor's name
$first_name = $_GET["firstname"];
$last_name = $_GET["lastname"];
$full_name = $first_name . " " . $last_name;

// get the actor id from the return rows of actor
foreach($actors as $actor) {
    $id = $actor["id"];
}

// set the top HTML tag of the page.
setTop();

// Look through the database for actors if the actor name is available, then make a table of movies
// Else return a negative comment.
if ($actors->rowCount() > 0) {
    openMainFound($full_name);
    ?>
    <p>All Films</p>
    <?php

    $movies = $db->query("SELECT name, year FROM roles r JOIN movies m on m.id = r.movie_id WHERE r.actor_id = $id ORDER BY m.year DESC, m.name ASC");
    makeTable($movies);

} else {
    openMainNotFound($full_name);
}

// closing out of the HTML tag of the page.
setBottom();