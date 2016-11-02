<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Movie Database - Search</title>
  
  <!-- basic styling -->
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" href="css/foundation.css">
  <link rel="stylesheet" href="css/app.css">
</head>

<body>
	<div class="row" id="fullpage">
		<!-- Left menu div -->
		<div class="small-5 medium-4 large-3 columns" id="menu">
			<h1 id="menu-main-title">CS143 Movie Database System</h1>
			<div class="spacer"></div>

			<a href="search.php"><h3 class="active-section">Search Database</h3></a>
			<a href="browse-actors.php"><h3>Browse Actors</h3></a>
			<a href="browse-movies.php"><h3>Browse Movies</h3></a>
			<div class="spacer"></div>

			<a href="add-actor.php"><h3>Add Actor or Director</h3></a>
			<a href="add-movie.php"><h3>Add Movie</h3></a>
			<a href="add-comments.php"><h3>Add Comments</h3></a>
			<a href="add-actor-to-movie.php"><h3>Add Actor to Movie</h3></a>
			<a href="add-director-to-movie.php"><h3>Add Director to Movie</h3></a>
		</div>

		<!-- Main Content Div -->
		<div class="small-7 medium-8 large-9 columns" id="main">
			<h2>Search Database</h2>
			
			<!-- TODO -->

            <div>
            <h1>Query</h1>
            <form action="search.php" method="GET" id="queryform">
                <textarea name="query" form="queryform" rows="8" cols="60"></textarea>
                <input type="submit" value="Run Query">
            </form>
            </div>


            <table>
            <?php

            ini_set('display_startup_errors', 1);
            ini_set('display_errors', 1);
            error_reporting(-1);

            $query = $_GET["query"];

            $mysqli = new mysqli('localhost', 'cs143', '', 'CS143');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            if (count($query) > 0) {
            $query_actors = "SELECT first, last FROM Actor WHERE last LIKE '%hanks%' OR first LIKE '%hanks%'";
            $res_actors = $mysqli->query($query_actors);
            echo "<h1>Actor Query</h1>";
            echo $query_actors;


            $query_movies = "SELECT title FROM Movie WHERE title LIKE '%hanks%'";

            echo "<h1>Movie Query</h1>";
            echo $query_movies;
            $res_movies = $mysqli->query($query_movies);

            $results = array($res_movies, $res_actors);


            foreach($results as $res) {
                $fields = $res->fetch_fields();

                // put column names into table header cells
//                echo "<tr>\n";
//                foreach($fields as $field) {
//                    echo "<th>" . $field->name . "</th>";
//                }
//                echo "\n</tr>\n";
            
                // fetch rows and place row data into table cells
                while ($row = $res->fetch_assoc()) {
                    echo "<tr>\n";
                
                    foreach($fields as $field) {
                        echo "<td>" . $row[ $field->name ] . "</td>";
                    }
                
                    echo "\n</tr>\n";
                }
            }

            }
            ?>

            </table>

		</div>
	</div>

	<!-- scripts, incl foundation -->
	<script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/vendor/foundation.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
