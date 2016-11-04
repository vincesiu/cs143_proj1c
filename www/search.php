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
			<a href="add-actor-movie-relation.php"><h3>Add Actor to Movie</h3></a>
			<a href="add-director-movie-relation.php"><h3>Add Director to Movie</h3></a>
		</div>

		<!-- Main Content Div -->
		<div class="small-7 medium-8 large-9 columns" id="main">
			<h2>Search Database</h2>
			
            <div>
            <form action="search.php" method="GET">
                Enter actor name or movie title
                <input type="text" name="query" size="20">
                <input type="submit" value="Search">
            </form>
            </div>

            <?php

            $debug = false;

            // ini_set('display_startup_errors', 1);
            // ini_set('display_errors', 1);
            // error_reporting(-1);

            $query = $_GET["query"];
            // strip whitespace
            $query = $query.trim();



            $mysqli = new mysqli('localhost', 'cs143', '', 'CS143');

            if ($query !== '') {

                if ($mysqli->connect_errno > 0) {
                    die('Unable to connect to database [' . $mysqli->connect_error . ']');
                }

                // this is for debugging purposes, pls remove vincent
                // if (count($query) > 0) {
                $query_components = explode(' ', $query);

                $query_actors = 'SELECT DISTINCT first, last, dob, id FROM Actor WHERE ';
                $query_movies = 'SELECT DISTINCT id,title FROM Movie WHERE ';

                $first = true;

                foreach ($query_components as $s) {
                    $s = '\'%' . $s . '%\'';
                    if ($first) {
                        $first = false;
                    } else {
                        $query_actors .= ' AND ';
                        $query_movies .= ' AND ';
                    }

                    $query_actors .= '(last LIKE ' . $s . ' OR first LIKE ' . $s . ')';
                    $query_movies .= '(title LIKE ' . $s . ')';
                }

                $res_actors = $mysqli->query($query_actors);
                echo '<div class="results">
                    <h2>Actor Results</h2>';
                if ($debug) echo "<p>Query: " . $query_actors . "</p>";

                // $fields = $res_actors->fetch_fields();
                if (mysqli_num_rows($res_actors) >= 1 ) {
                    echo "<table>";                
                    echo "<tr>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        </tr>";
                    while ($row = $res_actors->fetch_assoc()) {
                        echo "<tr>";
                        echo '<td><a href="browse-actors.php?id=' . $row[ 'id' ] . '">' 
                            . $row[ 'first' ] . ' ' . $row[ 'last' ] . "</a></td>";
                        echo "<td>" . $row[ 'dob' ] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No actors found</p>";
                }
                

                $res_movies = $mysqli->query($query_movies);
                echo '</div>
                    <div class="results">
                    <h2>Movie Results</h2>';
                if ($debug) echo "<p>Query: " . $query_movies . "</p>"; // DEBUGGING ONLY
                
                if (mysqli_num_rows($res_movies) >= 1 ) {
                    echo "<table>";                
                    echo "<tr>
                        <th>Title</th>
                        </tr>";

                    while ($row = $res_movies->fetch_assoc()) {
                        echo "<tr>";
                        echo '<td><a href="browse-movies.php?id=' . $row[ 'id' ] . '">' 
                            . $row[ 'title' ] . "</a></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No movies found</p>";
                }

                echo "</div>";

            }
            ?>          
 

		</div>
	</div>

	<!-- scripts, incl foundation -->
	<script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/vendor/foundation.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
