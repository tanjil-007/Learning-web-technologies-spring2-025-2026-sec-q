<?php
include 'db.php';

$message = "";

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "INSERT INTO employees(name, contact, username, password)
            VALUES('$name','$contact','$username','$password')";

    if($conn->query($sql)){
        $message = "Registration Successful";
    } else {
        $message = "Error";
    }
}
?>

<html>
<head>
<title>Register</title>

<script>
function validateForm(){
    let name = document.forms["regForm"]["name"].value;
    let contact = document.forms["regForm"]["contact"].value;
    let username = document.forms["regForm"]["username"].value;
    let password = document.forms["regForm"]["password"].value;

    if(name == "" || contact == "" || username == "" || password == ""){
        alert("All fields are required");
        return false;
    }
}
</script>

</head>

<body>

<h2>Employee Registration</h2>

<form name="regForm" method="POST" onsubmit="return validateForm()">

Name:
<input type="text" name="name"><br><br>

Contact:
<input type="text" name="contact"><br><br>

Username:
<input type="text" name="username"><br><br>

Password:
<input type="password" name="password"><br><br>

<input type="submit" name="register" value="Register">

</form>

<br>

<a href="login.php">Go To Login</a>

<p><?php echo $message; ?></p>

</body>
</html>
