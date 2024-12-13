<?php
$host = "localhost";
$user = "tngo32";
$pass = "tngo32";
$dbname = "tngo32";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    echo "Could not connect to server\n";
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS STUDENTS (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    GPA FLOAT NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table STUDENTS created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// Inserting data into the table
$data = [
    ["Pro", "Lou Lou", 9.9],
    ["DaMan", "Doe", 8.5],
    ["Jane", "Smith", 7.8],
    ["John", "Doe", 8.2],
    ["Alice", "Johnson", 9.1]
];

foreach ($data as $student) {
    $sql = "INSERT INTO STUDENTS (firstname, lastname, GPA) VALUES ('{$student[0]}', '{$student[1]}', {$student[2]})";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully\n";
    } else {
        echo "Error: " . $sql . "\n" . $conn->error . "\n";
    }
}

// Function to sort data by GPA
$sql = "SELECT * FROM STUDENTS ORDER BY GPA DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Sorted data by GPA:\n";
    while ($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"] . " - Name: " . $row["firstname"] . " " . $row["lastname"] . " - GPA: " . $row["GPA"] . "\n";
    }
} else {
    echo "0 results\n";
}

$conn->close();
?>