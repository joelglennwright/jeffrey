<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache'); // recommended to prevent caching of event data.

/**
 * Constructs the SSE data format and flushes that data to the client.
 *
 * @param string $id Timestamp/id of this connection.
 * @param string $msg Line of text that should be transmitted.
 */	

date_default_timezone_set("America/Vancouver");

$update = $_POST["text"]; 
$checking = $_GET["polling"];
$id = $_POST["id"];


// Create connection
$con = mysqli_connect("localhost","growple_admin","NRqm-uMNW34i9q7","growple_jeffrey");


// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}


if(isset($update)){

	$today = date('Y-m-d H:i:s');

	$message = mysqli_escape_string($con, $update);

	$sql_statement = "INSERT INTO messages (message, created) VALUES ('$message', '$today')";

	$query = mysqli_query($con, $sql_statement);

	if (!mysqli_query($con, $query)) {
  		//die('Error: ' . mysqli_error($con));
	}

	mysqli_close ($con);

	echo "success!";

}else if (isset($checking)){

	
	$result = mysqli_query($con,"SELECT * FROM messages WHERE retrieved = '00000-00-00 00:00:00' LIMIT 10");

	$data = array();

	while ( $row = $result->fetch_assoc() ){
	    $data[] = json_encode($row);
	}

	echo json_encode($data);

	mysqli_close($con);

}else if (isset($id)){

	echo $id;

	$today = date('Y-m-d H:i:s');

	$sql_statement = "UPDATE messages SET retrieved = '$today' WHERE id = $id";

	$query = mysqli_query($con, $sql_statement);

	if (!mysqli_query($con, $query)) {
  		//die('Error: ' . mysqli_error($con));
	}

	mysqli_close ($con);

	echo "success!";
}
