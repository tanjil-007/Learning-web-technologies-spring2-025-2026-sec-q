<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}

include 'db.php';

$result = $conn->query("SELECT * FROM employees");
?>

<html>
<head>
<title>Dashboard</title>

<script>
function searchEmployee(str){

    if(str.length == 0){
        document.getElementById("searchResult").innerHTML = "";
        return;
    }

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            document.getElementById("searchResult").innerHTML = this.responseText;
        }
    };

    xhttp.open("GET", "search.php?q=" + str, true);
    xhttp.send();
}
</script>

</head>

<body>

<h2>Dashboard</h2>

<p>Welcome <?php echo $_SESSION['username']; ?></p>

<a href="logout.php">Logout</a>

<h3>Search Employee</h3>

<input type="text" onkeyup="searchEmployee(this.value)" placeholder="Search by name">

<div id="searchResult"></div>

<h3>Employee List</h3>

<table border="1" cellpadding="10">

<tr>
<th>ID</th>
<th>Name</th>
<th>Contact</th>
<th>Username</th>
<th>Action</th>
</tr>

<?php
while($row = $result->fetch_assoc()){
?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['contact']; ?></td>
<td><?php echo $row['username']; ?></td>

<td>
<a href="update.php?id=<?php echo $row['id']; ?>">Update</a>
<a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
</td>

</tr>

<?php
}
?>

</table>

</body>
</html>
