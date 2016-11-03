<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Movie Database - Add Director to Movie</title>
  
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
			<a href="add-actor-movie-relation.php"><h3>Add Actor to Movie</h3></a>
			<a href="add-director-movie-relation.php"><h3 class="active-section">Add Director to Movie</h3></a>
		</div>

		<!-- Main Content Div -->
		<div class="small-7 medium-8 large-9 columns" id="main">
			<h2>Add Director to Movie</h2>
			
			<form action="add-director-movie-relation.php" method="post">
				Select Movie: <select name="movieid">
				<?php 
					if (isset($_GET['mid'])) {
						$query1 = 'SELECT id, title, year FROM Movie WHERE id = ' . $_GET['mid'];
					} else {
						$query1 = 'SELECT id, title, year FROM Movie';
					}
	                $mysqli = new mysqli('localhost', 'cs143', '', 'CS143');
	                if ($mysqli->connect_errno > 0) {
	                    // do something
	                }
	                if (!$res1 = $mysqli->query($query1)) {
	                    // do something
	                }
	                while ($row = $res1->fetch_assoc()) {
	                	echo '<option value="' . $row['id'] . '">' . $row['title'] . ' (' . $row['year'] . ')</option>';
	                }
				?>
				</select>
				Select Director: <select name="directorid">
				<?php
					$query2 = 'SELECT id, first, last, dob FROM Director';
	                $mysqli = new mysqli('localhost', 'cs143', '', 'CS143');
	                if ($mysqli->connect_errno > 0) {
	                    // do something
	                }
	                if (!$res2 = $mysqli->query($query2)) {
	                    // do something
	                }
	                while ($row = $res2->fetch_assoc()) {
	                	echo '<option value="' . $row['id'] . '">' . $row['first'] . ' ' . $row['last'] . ' (' . $row['dob'] . ')</option>';
	                }
				?>
				</select>
				<input type="submit" value="Submit">
			</form>

			<div class="results">
			
			<?php
					if (isset($_POST["movieid"]) && isset($_POST["directorid"])) {
						$mid = $_POST["movieid"];
						$did = $_POST["directorid"];

						$query = 'INSERT INTO MovieDirector VAlUES (' . $mid . ',' . $did . ')';
						if (!$insertres = $mysqli->query($query)) {
	                    	echo 'Insertion failed';
	                	} else {
	                		$query = 'SELECT first,last,title FROM Director, Movie WHERE Director.id = ' . $did . ' AND Movie.id =' . $mid;
	                		if ($postinsertres = $mysqli->query($query)) {
	                			while ($row = $postinsertres->fetch_assoc()) {
				                	echo 'Added ' . $row['first'] . ' ' . $row['last'] . ' as director for movie titled ' . $row['title'];
				                }
	                		}
                			else {
                				echo 'second bit failed';
                			}
                			// echo 'Insertion complete';
	                	}
					} else {
						echo "hihihi";
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