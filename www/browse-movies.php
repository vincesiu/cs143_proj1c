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
            <form action="search.php" method="GET">
                <input type="text" name="query" size="20">
                <input type="submit" value="Search">
            </form>
            <div class="results">
			
			<!-- TODO -->
            <?php
                include 'helper.php';

                $id = $_GET['id'];

                if (empty($id)) {
                    failure('');
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

                $query2 = 'SELECT first,last FROM Director JOIN (SELECT did FROM MovieDirector WHERE mid = ' . $id . ') AS Dids ON Director.id = Dids.did';
                if (!$diretorres = $mysqli->query($query2)) {
                    die('Unable to finish query');
                }
                if ($diretorres->num_rows === 0) {
                    $director = "No director listed";
                } else {
                    $first = true;
                    while ($row = $diretorres->fetch_assoc()) {
                        if ($first) { 
                            $director = '';
                            $first = false;
                        }
                        else { 
                            $director .= ', ';
                        }
                        $director .= ($row['first'] . ' ' . $row['last']);
                    }
                }

                $query3 = 'SELECT genre FROM MovieGenre WHERE mid = ' . $id;
                if (!$genreres = $mysqli->query($query3)) {
                    die('Unable to finish query');
                }
                if ($genreres->num_rows === 0) {
                    $genre = "No genre listed";
                } else {
                    $first = true;
                    while ($row = $genreres->fetch_assoc()) {
                        if ($first) {
                            $genre = '';
                            $first = false;
                        } else {
                            $genre .= ', ';
                        }
                        $genre .= $row['genre'];
                    }
                }
                
                $query4 = 'SELECT AVG(rating) FROM Review WHERE mid = ' . $id;
                if (!$avgres = $mysqli->query($query4)) {
                    die('Unable to finish query');
                }
                if ($avgres->num_rows === 0) {
                    
                } else {
                    while ($row = $avgres->fetch_assoc()) {
                        if ($row['AVG(rating)'] !== null) {
                            $avgreview = $row['AVG(rating)'];
                        }
                        else {
                            $avgreview = "No reviews listed";
                        }
                    }
                }

                echo '</div><div class="results">';
                echo '<h2>Movie Information</h2>';

                echo '<table style="margin-bottom: 1rem;">';
                while ($row = $res->fetch_assoc()) {
                    echo '<tr><td><p class="bold table">Title</p></td><td>' . $row['title'] . '</td></tr>';
                    echo '<tr><td><p class="bold table">Year</p></td><td>' . $row['year'] . '</td></tr>';
                    echo '<tr><td><p class="bold table">Rating</p></td><td>' . $row['rating'] . '</td></tr>';
                    echo '<tr><td><p class="bold table">Company</p></td><td>' . $row['company'] . '</td></tr>';
                    echo '<tr><td><p class="bold table">Director</p></td><td>' . $director . '</td></tr>';
                    echo '<tr><td><p class="bold table">Genre</p></td><td>' . $genre . '</td></tr>';
                    echo '<tr><td><p class="bold table">Average Rating</p></td><td>' . $avgreview . '</td></tr>';
                }
                echo '</table>';

                echo '<a href="add-director-movie-relation.php?mid=' . $id . '"><p>Add director to movie</p></a>';
                echo '</div>';

                $query = 'SELECT first, last, id, role FROM Actor, MovieActor WHERE MovieActor.mid = ' . $id . ' AND MovieActor.aid = Actor.id';

                echo '<div class="results">';
                echo '<h2>Actors in this movie</h2>';
                        
                if (!$res = $mysqli->query($query)) {
                    die('Unable to finish query');
                }
                if ($res->num_rows === 0) {
                    echo '<p>No actors found.</p>';
                }
                else {
                    echo '<table style="margin-bottom: 1rem;">';
                    echo '<tr><th>Name</th><th>Role</th></tr>';
                    while ($row = $res->fetch_assoc()) {
                        $link = 'browse-actors.php?id=' . $row['id'];
                        echo '<tr>';
                        echo '<td><a href="' . $link . '">' . $row['first'] . ' ' . $row['last'] . '</a></td>';
                        echo '<td>' . $row['role'] . '</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                }
                echo '<a href="add-actor-movie-relation.php?mid=' . $id . '"><p>Add actor to movie</p></a>';
                echo '</div>';

                $query = 'SELECT name, time, rating, comment FROM Review WHERE mid = ' . $id;
                echo '<div class="results commentsection">';
                echo '<h2>Comments Section</h2>';
                
                if (!$res = $mysqli->query($query)) {
                    die('Unable to finish query');
                }
                if ($res->num_rows === 0) {
                    echo '<p>No reviews found.</p>';
                }
                else {
                    echo '<table style="margin-bottom: 1rem;">';
                    echo '<tr><th>Name</th><th>Time</th><th>Rating</th><th>Review</th></tr>';
                    while ($row = $res->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td>' . $row['time'] . '</td>';
                        echo '<td>' . $row['rating'] . '</td>';
                        echo '<td>' . $row['comment'] . '</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                }
                echo '<a href="add-comments.php?mid=' . $id . '"><p>Add review to movie</p></a>';
                
            ?>
            </div>
		</div>
	</div>

	<!-- scripts, incl foundation -->
	<script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/vendor/foundation.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
