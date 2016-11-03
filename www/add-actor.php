<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Movie Database - Add Actor / Director</title>
  
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
			<a href="browse-movies.php"><h3>Browse Movies</h3></a>
			<div class="spacer"></div>

			<a href="add-actor.php"><h3 class="active-section">Add Actor or Director</h3></a>
			<a href="add-movie.php"><h3>Add Movie</h3></a>
			<a href="add-comments.php"><h3>Add Comments</h3></a>
			<a href="add-actor-movie-relation.php"><h3>Add Actor to Movie</h3></a>
			<a href="add-director-movie-relation.php"><h3>Add Director to Movie</h3></a>
		</div>

		<!-- Main Content Div -->
		<div class="small-7 medium-8 large-9 columns" id="main">
			<h2>Add Actor / Director to Database</h2>
			
			<form action="add-actor.php" method="post">
				<input type="radio" name="actordirector" value="actor" checked> Actor
  				<input type="radio" name="actordirector" value="director">Director<br/>
				First Name: <input type="text" name="first">
				Last Name: <input type="text" name="last">
				<input type="radio" name="gender" value="male" checked> Male
  				<input type="radio" name="gender" value="female"> Female <br/>
				Date of Birth: (i.e. 1995-06-15) <input type="text" name="dob">
				Date of Death: (Leave blank if currently alive) <input type="text" name="dod">
				<input type="submit" value="Submit">
			</form>
            <?php 
            $temp = $_POST['title'];
            if (isset($temp)) {
                $out = $temp;
            } else {
                $out = '';
            }
            echo $out;
            ?>

			<div class="results">
			<?php 
                include 'helper.php';

                if (empty($_POST['first']) 
                        && empty($_POST['last']) 
                        && empty($_POST['dob']) 
                        && empty($_POST['dod'])) 
                {
                    // Nothing was provided
                    failure('Please fill out the form to add a movie');
                } else if (!empty($_POST['title']) 
                        && !empty($_POST['company']) 
                        && !empty($_POST['year']) 
                        && !empty($_POST['genre'])) 
                {
                    // All forms filled out
                    $title = $_POST['title'];
                    $company = $_POST['company'];
                    $year = $_POST['year'];
                    $genre = $_POST['genre'];
                    $rating = $_POST['rating'];

                    if (strlen($title) > 100) {
                        failure('Please provide a title of less than 100 characters');
                    }
                    if (strlen($company) > 50) {
                        failure('Please provide a company name of less than 50 characters');
                    }
                    if (!is_numeric($year)) {
                        failure('Please provide a valid year');
                    }
                    if (strlen($genre) > 20) {
                        failure('Please provide a genre name of less than 20 characters');
                    }
                $mysqli = new mysqli($host, $user, $pass, $db);
                if ($mysqli->connect_error) {
                    failure('Could not connect to db');
                }

                $query_update = 'UPDATE MaxMovieID SET id = id + 1';
                $mysqli->query($query_update);
                $query_id = 'SELECT id FROM MaxMovieID';
                $res = $mysqli->query($query_id);
                $row = $res->fetch_assoc();

                
                
                $query_movie = 'INSERT INTO Movie VALUES (' . $row['id'] .  ', "' . $title . '", ' . $year . ', "' . $rating . '", "' . $company . '")';
                if ($mysqli->query($query_movie)) {
                    echo "Added movie to database successfully";
                } else {
                    echo "Could not add movie";
                }
                
                $mysqli->close();

                } else {
                    // Not all forms filled out
                    failure('Please fill out all fields');
                }
                    
               

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
