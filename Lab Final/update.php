<?php
include 'db.php';

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM employees WHERE id='$id'");

$row = $result->fetch_assoc();

if(isset($_POST['update'])){

    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "UPDATE employees
            SET
            name='$name',
            contact='$contact',
            username='$username',
            password='$password'
            WHERE id='$id'";

    if($conn->query($sql)){
        header("Location: dashboard.php");
    }
}
?>

<html>
<head>
<title>Update</title>

<script>
function validateUpdate(){

    let name = document.forms["updateForm"]["name"].value;
    let contact = document.forms["updateForm"]["contact"].value;
    let username = document.forms["updateForm"]["username"].value;
    let password = document.forms["updateForm"]["password"].value;

    if(name == "" || contact == "" || username == "" || password == ""){
        alert("All fields are required");
        return false;
    }
}
</script>

</head>

<body>

<h2>Update Employee</h2>

<form name="updateForm" method="POST" onsubmit="return validateUpdate()">

Name:
<input type="text" name="name" value="<?php echo $row['name']; ?>"><br><br>

Contact:
<input type="text" name="contact" value="<?php echo $row['contact']; ?>"><br><br>

Username:
<input type="text" name="username" value="<?php echo $row['username']; ?>"><br><br>

Password:
<input type="text" name="password" value="<?php echo $row['password']; ?>"><br><br>

<input type="submit" name="update" value="Update">

</form>

</body>
</html>
