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
				First Name: <input type="text" name="first" value=
            <?php 
            $temp = $_POST['first'];
            if (isset($temp)) {
                $out = $temp;
            } else {
                $out = '';
            }
            echo $out;
            ?>
                >
				Last Name: <input type="text" name="last" value=
            <?php 
            $temp = $_POST['last'];
            if (isset($temp)) {
                $out = $temp;
            } else {
                $out = '';
            }
            echo $out;
            ?>
                >
				<input type="radio" name="gender" value="male" checked> Male
  				<input type="radio" name="gender" value="female"> Female <br/>
				Date of Birth: (i.e. 1995-06-15) <input type="text" name="dob" value=
            <?php 
            $temp = $_POST['dob'];
            if (isset($temp)) {
                $out = $temp;
            } else {
                $out = '';
            }
            echo $out;
            ?>
                >
				Date of Death: (Leave blank if currently alive) <input type="text" name="dod" value=
            <?php 
            $temp = $_POST['dod'];
            if (isset($temp)) {
                $out = $temp;
            } else {
                $out = '';
            }
            echo $out;
            ?>
                >
				<input type="submit" value="Submit">
			</form>

			<div class="results">
			<?php 
                include 'helper.php';

                if (empty($_POST['first']) 
                        && empty($_POST['last']) 
                        && empty($_POST['dob']) 
                        && empty($_POST['dod'])) 
                {
                    // Nothing was provided
                    failure('Please fill out the form to add a person');
                } else if (!empty($_POST['first']) 
                        && !empty($_POST['last']) 
                        && !empty($_POST['dob']))
                {
                    // All forms filled out
                    $first = $_POST['first'];
                    $last = $_POST['last'];
                    $gender = $_POST['gender'];
                    $dob = $_POST['dob'];
                    if (preg_match('/[0-2][0-9]{3}-[0-1][0-9]-[0-3][0-9]$/', $_POST['dob']) === 0) {
                        failure("Please provide a valid date of birth");
                    }
                    $dob = '"' . $dob . '"';
                    if (!empty($_POST['dod']) ) {
                        if (preg_match('/[0-2][0-9]{3}-[0-1][0-9]-[0-3][0-9]$/', $_POST['dod']) === 0) {
                            failure("Please provide a valid date of death");
                        }
                        $dod = $_POST['dod'];
                        $dod = '"' . $dod . '"';
                    } else {
                        $dod = "NULL";
                    }

                    $actordirector = $_POST['actordirector'];

                    if (strlen($first) > 20) {
                        failure('Please provide a first name of less than 20 characters');
                    }
                    if (strlen($last) > 20) {
                        failure('Please provide a last name of less than 20 characters');
                    }


                $mysqli = new mysqli($host, $user, $pass, $db);
                if ($mysqli->connect_error) {
                    failure('Could not connect to db');
                }

                
                $query_update = 'UPDATE MaxPersonID SET id = id + 1';
                $mysqli->query($query_update);
                $query_id = 'SELECT id FROM MaxPersonID';
                $res = $mysqli->query($query_id);
                $row = $res->fetch_assoc();
                $id = $row['id'];

                
                if (strcmp($actordirector, 'actor') === 0 ) {
                    $query_person = 'INSERT INTO Actor VALUES (' . $id . ', "' . $last . '", "' . $first . '", "' . $gender . '", ' . $dob . ', ' . $dod . ')';
                } else {
                    $query_person = 'INSERT INTO Director VALUES (' . $id . ', "' . $last . '", "' . $first . '", "' . $dob . ', ' . $dod . ')';
                }
                echo $query_person;
                
//                $query_person = 'INSERT INTO Movie VALUES (' . $row['id'] .  ', "' . $title . '", ' . $year . ', "' . $rating . '", "' . $company . '")';
                if ($mysqli->query($query_person)) {
                    echo "Added person to database successfully";
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
