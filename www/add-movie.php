<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Movie Database - Add Movie</title>
  
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
			<a href="add-movie.php"><h3 class="active-section">Add Movie</h3></a>
			<a href="add-comments.php"><h3>Add Comments</h3></a>
			<a href="add-actor-movie-relation.php"><h3>Add Actor to Movie</h3></a>
			<a href="add-director-movie-relation.php"><h3>Add Director to Movie</h3></a>
		</div>

		<!-- Main Content Div -->
		<div class="small-7 medium-8 large-9 columns" id="main">
			<h2>Add Movie to Database</h2>
			
			<form action="add-movie.php" method="post">
				Title: <input type="text" name="title">
				Company: <input type="text" name="company">
				Year: <input type="text" name="year">
				Rating: <select name="rating">
				  <option value="G">G</option>
				  <option value="NC-17">NC-17</option>
				  <option value="PG">PG</option>
				  <option value="PG-13">PG-13</option>
				  <option value="R">R</option>
				</select>
				Genre: <input type="text" name="genre">
				<input type="submit" value="Submit">
			</form>

			<div class="results">
			
			<?php 
				echo $_POST["title"];
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