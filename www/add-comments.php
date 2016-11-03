<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Movie Database - Add Comments</title>
  
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
			<a href="add-comments.php"><h3 class="active-section">Add Comments</h3></a>
			<a href="add-actor-movie-relation.php"><h3>Add Actor to Movie</h3></a>
			<a href="add-director-movie-relation.php"><h3>Add Director to Movie</h3></a>
		</div>

		<!-- Main Content Div -->
		<div class="small-7 medium-8 large-9 columns" id="main">
			<h2>Add Comments to Database</h2>
			
			<form action="add-comments.php" method="post" id="commentform">
				Select Movie: <select name="movieid">
				<?php 
					if (isset($_GET['mid'])) {
						$query = 'SELECT id, title, year FROM Movie WHERE id = ' . $_GET['mid'];
					} else {
						$query = 'SELECT id, title, year FROM Movie';
					}
	                $mysqli = new mysqli('localhost', 'cs143', '', 'CS143');
	                if ($mysqli->connect_errno > 0) {
	                    // do something
	                }
	                if (!$res = $mysqli->query($query)) {
	                    // do something
	                }
	                while ($row = $res->fetch_assoc()) {
	                	echo '<option value="' . $row['id'] . '">' . $row['title'] . ' (' . $row['year'] . ')</option>';
	                }
				?>
				</select>
				Your Name: <input type="text" name="name">
				Rating:
				<select name="rating">
				  <option disabled selected value>Please select a rating</option>
				  <option value="1">1</option>
				  <option value="2">2</option>
				  <option value="3">3</option>
				  <option value="4">4</option>
				  <option value="5">5</option>
				</select>
				<textarea name="comment" form="commentform" rows="5" placeholder="Enter rating body here..."></textarea>
				<input type="submit" value="Submit">
			</form>

			<div class="results">
			
			<?php
                    
//                    if (empty($_POST["rating")) {
//                        echo "I suck";
//                    }

					$id = $_POST["movieid"];

                    if (empty($_POST["name"])) {
                        $name = "Anonymous";
                    } else {
                        $name = $_POST["name"];
                    }
                    $review = $_POST['comment'];
                    $timestamp = date('Y-m-d H:i:s', time());
                    

                    if (strlen($name) > 20) {
                        failure('Please choose a number under 20 characters');
                    }
                    if (strlen($review) > 500) {
                        failure('Please keep your comment under 500 characters');
                    }

                    echo "hi";

                    $mysqli = new mysqli($host, $user, $pass, $db);
                    $query = 'INSERT INTO Review VALUES ("' . $name . '", "' . $timestamp . '", ' . $id . ', ' . $rating . ', "' . $review .  '")';
                    echo $query;

                    echo "hi";
                    if ($mysqli->connect_error) {
                        failure('Could not connect to db');
                    }

                    echo "hi";
                    if ($mysqli->query($query_person)) {
                        echo "success";
                        echo "Added review to database successfully";
                    } else {
                        echo "fail";
                        echo "Failed to add review";
                    }
                    echo "hi";
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
