<?php
/**
 * Created by PhpStorm.
 * User: Takatathien
 * Date: 11/22/2016
 * Time: 5:22 PM
 *
 * A php file that contained the majority of the mymdb code and function that is shared between all
 * of its associated files/webpages.
 */

try {
    // get the user input
    $first_name = $_GET["firstname"];
    $last_name = $_GET["lastname"];
    $kevin_id = 91976;

    // call the query for the actor id associated with the input name.
    $db = new PDO("mysql:dbname=imdb;host=localhost;charset=utf8", "trinht2", "36GIsmjxS3");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $first_name = $db->quote($first_name . "%");
    $last_name = $db->quote($last_name);
    $actors = $db->query("SELECT * FROM actors WHERE first_name LIKE $first_name AND last_name = $last_name ORDER BY film_count DESC LIMIT 1;");

    // set the top of the resulting page, including the banner and title.
    function setTop() {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>My Movie Database (MyMDb)</title>
            <meta charset="utf-8" />
            <link href="https://webster.cs.washington.edu/images/kevinbacon/favicon.png" type="image/png" rel="shortcut icon" />

            <!-- Link to your CSS file that you should edit -->
            <link href="bacon.css" type="text/css" rel="stylesheet" />
        </head>

        <body>
        <div id="frame">
            <div id="banner">
                <a href="mymdb.php"><img src="https://webster.cs.washington.edu/images/kevinbacon/mymdb.png" alt="banner logo" /></a>
                My Movie Database
            </div>
        <?php
    }

    // set the bottom of the resulting page, including the forms and W3Cs, while closing out the tags.
    function setBottom() {
        ?>
            <!-- form to search for every movie by a given actor -->
            <form action="search-all.php" method="get">
                <fieldset>
                    <legend>All movies</legend>
                    <div>
                        <input name="firstname" type="text" size="12" placeholder="first name" autofocus="autofocus" />
                        <input name="lastname" type="text" size="12" placeholder="last name" />
                        <input type="submit" value="go" />
                    </div>
                </fieldset>
            </form>

            <!-- form to search for movies where a given actor was with Kevin Bacon -->
            <form action="search-kevin.php" method="get">
                <fieldset>
                    <legend>Movies with Kevin Bacon</legend>
                    <div>
                        <input name="firstname" type="text" size="12" placeholder="first name" />
                        <input name="lastname" type="text" size="12" placeholder="last name" />
                        <input type="submit" value="go" />
                    </div>
                </fieldset>
            </form>
            </div> <!-- end of #main div -->

            <div id="w3c">
                <a href="https://webster.cs.washington.edu/validate-html.php"><img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML5" /></a>
                <a href="https://webster.cs.washington.edu/validate-css.php"><img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
            </div>
        </div> <!-- end of #frame div -->
        </body>
        </html>
        <?php
    }

    // Insert this main title if the actor have made movies (name found in the query).
    function openMainFound($full_name) {
        ?>
        <div id="main">
            <h1>Result for <?=$full_name?></h1>
        <?php
    }

    // Insert this main title if the actor does not have movies (name not found in query).
    function openMainNotFound($full_name) {
        ?>
        <div id="main">
            <p>Actor <?=$full_name?> not found</p>
        <?php
    }

    // Check to see if there is movies the actor and Kevin Bacon both participated at or not.
    // If there are none, ten insert a negative comment.
    // If found then forward the data to make a table.
    function makeTableWithKevin($movies, $full_name) {
        if ($movies->rowCount() > 0) {
            openMainFound($full_name);
            ?>
            <p>Films with <?=$full_name?> and Kevin Bacon</p>
            <?php
            makeTable($movies);
        } else {
            ?>
            <p><?=$full_name?> wasn't in any films with Kevin Bacon</p>
            <?php
        }
    }

    // Make a table of all the movies of the actor, with index, name, and year of the movie.
    function makeTable($movies) {
        ?>
        <table>
            <tr>
                <th>#</th><th>Title</th><th>Year</th>
            </tr>
        <?php
        $count = 1;
        foreach ($movies as $movie) {
            ?>
            <tr>
                <td><?= $count ?></td>
                <td><?= $movie["name"] ?></td>
                <td><?= $movie["year"] ?></td>
            </tr>
            <?php
            $count++;
        }
        ?>
        </table>
        <?php
    }

} catch (PDOException $ex) {
    ?>
    <p>Sorry, a database error occurred.</p>
    <p>(Error details: <?= $ex->getMessage() ?>)</p>
    <?php
}