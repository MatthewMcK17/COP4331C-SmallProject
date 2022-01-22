<?php
	$inData = getRequestInfo();


  $user_id = $inData["user_id"];
	$first_name = $inData["first_name"];
	$last_name = $inData["last_name"];
	$phone = $inData["phone"];

	$conn = new mysqli("localhost", "lampy", "P@ssw0rd", "lamp");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare("INSERT into contacts (user_id, first_name, last_name, phone) VALUES(?,?,?,?)");
		$stmt->bind_param("isss", $user_id, $first_name, $last_name, $phone);
		$stmt->execute();
		$stmt->close();
		$conn->close();
		returnWithError("25");
	}

	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}

	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

?>