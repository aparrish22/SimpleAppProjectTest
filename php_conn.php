<?php
	/* Connect to DB */
	$connection  = mysqli_connect('localhost', 'root', '');
	if (!$connection ) {
		die('Could not connect: ' . mysqli_error());
	}
	
	mysqli_select_db($connection,"employees");

	/* Select Variables via SQL */
	$SQLstring = "SELECT first_name, last_name FROM users";

	$QueryResult = @mysqli_query($connection, $SQLstring);


	/* fetch each row and store into array, then json encode for ajax call */
	$rowArray = array();

	while ($row = mysqli_fetch_array($QueryResult)) {

		// array_push($rowArray,$row);

		$rowArray[] = array(
			'first_name' => $row["first_name"],
			'last_name' => $row["last_name"]
		);

	};

	/* results/data for DataTable to read */
	$tableData = array(
		"sEcho" => 10,
		"iTotalRecords" => count($rowArray),
		"iTotalDisplayRecords" => count($rowArray),
		"aaData" => $rowArray
	);

	/* Create json file */
	$file = 'data'.'.json';

	if (file_put_contents($file, json_encode($tableData) )) {
		echo $file.' file created';
	} else {
		echo 'Error with Creating data.json file.';
	}
	
?>
