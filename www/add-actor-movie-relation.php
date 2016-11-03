<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Movie Database - Add Actor to Movie</title>
  
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

			<a href="add-actor.php"><h3>Add Actor or Director</h3></a>
			<a href="add-movie.php"><h3>Add Movie</h3></a>
			<a href="add-comments.php"><h3>Add Comments</h3></a>
			<a href="add-actor-movie-relation.php"><h3 class="active-section">Add Actor to Movie</h3></a>
			<a href="add-director-movie-relation.php"><h3>Add Director to Movie</h3></a>
		</div>

		<!-- Main Content Div -->
		<div class="small-7 medium-8 large-9 columns" id="main">
			<h2>Add Actor to Movie</h2>
			
			<form action="add-actor-movie-relation.php" method="post">
				Select Movie: <select name="movieid">
				<?php 
					if (isset($_GET['mid'])) {
						$query1 = 'SELECT id, title, year FROM Movie WHERE id = ' . $_GET['mid'];
					} else {
						$query1 = 'SELECT id, title, year FROM Movie';
					}
	                $mysqli1 = new mysqli('localhost', 'cs143', '', 'CS143');
	                if ($mysqli1->connect_errno > 0) {
	                    // do something
	                }
	                if (!$res1 = $mysqli1->query($query1)) {
	                    // do something
	                }
	                while ($row = $res1->fetch_assoc()) {
	                	echo '<option value="' . $row['id'] . '">' . $row['title'] . ' (' . $row['year'] . ')</option>';
	                }
				?>
				</select>
				Select Actor: <select name="actorid">
				<?php 
					if (isset($_GET['aid'])) {
						$query2 = 'SELECT id, first, last, dob FROM Actor WHERE id = ' . $_GET['aid'];
					} else {
						$query2 = 'SELECT id, first, last, dob FROM Actor';
					}
					
	                $mysqli2 = new mysqli('localhost', 'cs143', '', 'CS143');
	                if ($mysqli2->connect_errno > 0) {
	                    // do something
	                }
	                if (!$res2 = $mysqli2->query($query2)) {
	                    // do something
	                }
	                while ($row = $res2->fetch_assoc()) {
	                	echo '<option value="' . $row['id'] . '">' . $row['first'] . ' ' . $row['last'] . ' (' . $row['dob'] . ')</option>';
	                }
				?>
				</select>
				Role: <input type="text" name="role">
				<input type="submit" value="Submit">
			</form>

			<div class="results">
			
			<?php
                    include 'helper.php';

					$mid = $_POST["movieid"];
					$aid = $_POST["actorid"];
                    if (empty($_POST["role"])){
                        failure("Please provide a role for the actor");
                    }
                    $role = $_POST["role"];
                    if (strlen($role) > 50) {
                        failure("Please describe the role in less than 50 characters");
                    }
                    $mysqli = new mysqli($host, $user, $pass, $db);
                    $query = 'INSERT INTO MovieActor VALUES (' . $mid . ', ' . $aid . ', "' . $role . '")';
                    if ($mysqli->query($query)) {
                        $query = 'SELECT first,last,title FROM Actor, Movie WHERE Actor.id = ' . $aid . ' AND Movie.id = ' . $mid;
                		if ($postinsertres = $mysqli->query($query)) {
                			while ($row = $postinsertres->fetch_assoc()) {
			                	echo 'Added ' . $row['first'] . ' ' . $row['last'] . ' as actor to movie titled ' . $row['title'] . ' in the role ' . $role;
			                }
                		}
            			else {
            				echo 'Actor added to movie';
            			}
                    } else {
                        echo "Failed to add actor to movie";
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
