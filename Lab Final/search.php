<?php
include 'db.php';

$q = $_GET['q'];

$sql = "SELECT * FROM employees WHERE name LIKE '%$q%'";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
    echo "ID: " . $row['id'] . " | ";
    echo "Name: " . $row['name'] . " | ";
    echo "Contact: " . $row['contact'] . "<br><br>";
}
?>
