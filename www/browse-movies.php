<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Movie Database - Browse Movies</title>
  
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

			<a href="search.php"><h3>Search Database</h3></a>
			<a href="browse-actors.php"><h3>Browse Actors</h3></a>
			<a href="browse-movies.php"><h3 class="active-section">Browse Movies</h3></a>
			<div class="spacer"></div>

			<a href="add-actor.php"><h3>Add Actor or Director</h3></a>
			<a href="add-movie.php"><h3>Add Movie</h3></a>
			<a href="add-comments.php"><h3>Add Comments</h3></a>
			<a href="add-actor-movie-relation.php"><h3>Add Actor to Movie</h3></a>
			<a href="add-director-movie-relation.php"><h3>Add Director to Movie</h3></a>
		</div>

		<!-- Main Content Div -->
		<div class="small-7 medium-8 large-9 columns" id="main">
			<h2>Browse Movies</h2>
			
			<!-- TODO -->
            <?php
                include 'helper.php';

                $id = $_GET['id'];

                if (empty($id)) {
                    failure('Please provide a movie id');
                }
                
                $fields = array('id', 'title', 'year', 'rating', 'company');

                if (!is_numeric($id)) {
                    failure('Please provide a valid movie id');
                }


                $query = 'SELECT id, title, year, rating, company FROM Movie WHERE id = ' . $id;
                $mysqli = new mysqli('localhost', 'cs143', '', 'CS143');
                if ($mysqli->connect_errno > 0) {
                    failure('Unable to connect to database');
                }
                if (!$res = $mysqli->query($query)) {
                    failure('Could not query database');
                }
                if ($res->num_rows === 0) {
                    failure('Please provide a valid movie id');
                }

                echo '<div class="results">';
                echo '<h2>Movie Information</h2>';

                echo '<table>';
                while ($row = $res->fetch_assoc()) {
                    echo '<tr>';
                    foreach ($fields as $field) {
                        echo '<td>' . $row[$field] . '</td>';
                    }
                    echo '</tr>';
                }
                echo '</table>';
                echo '</div>';

                $query = 'SELECT first, last, id FROM Actor, MovieActor WHERE MovieActor.mid = ' . $id . ' AND MovieActor.aid = Actor.id';

                        
                if (!$res = $mysqli->query($query)) {
                    die('Unable to finish query');
                }
                if ($res->num_rows === 0) {
                    echo '<h2>No Actors in this movie :(</h2>';
                }
                else {
                    echo '<div class="results">';
                    echo '<h2>Actors in this movie</h2>';
                    echo '<table>';
                    while ($row = $res->fetch_assoc()) {
                        $link = 'browse-actors.php?id=' . $row['id'];
                        echo '<tr>';
                        echo '<td><a href="' . $link . '">' . $row['first'] . ' ' . $row['last'] . '</a></td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                    echo '</div>';
                }

                $query = 'SELECT name, time, rating, comment FROM Review WHERE mid = ' . $id;
                echo '<div class="commentssection">';
                echo '<h2>Comments Section</h2>';

                while ($row = $res->fetch_assoc()) {
                    echo '<div class="comment">';
                    echo '<p>' . $row['name'] . '</p>';
                    echo '<p>' . $row['time'] . '</p>';
                    echo '<p>' . $row['rating'] . '</p>';
                    echo '<p>' . $row['comment'] . '</p>';
                    echo '</div>';
                }
                echo '</div>';
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
