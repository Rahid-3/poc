<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "jfmgzeyswf";
$password = "QjgsbD8PSj";
$dbname = "jfmgzeyswf";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch shop options
$sql = "SELECT id, mainoption FROM main_option";
$result = $conn->query($sql);

$options = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = $row;
    }
}

$conn->close();

// Output JSON
echo json_encode($options);
?>
