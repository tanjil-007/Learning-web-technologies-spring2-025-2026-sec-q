<?php
session_start();
include 'db.php';

$message = "";

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM employees WHERE username='$username' AND password='$password'";

    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
    } else {
        $message = "Invalid Username or Password";
    }
}
?>

<html>
<head>
<title>Login</title>
</head>

<body>

<h2>Login</h2>

<form method="POST">

Username:
<input type="text" name="username"><br><br>

Password:
<input type="password" name="password"><br><br>

<input type="submit" name="login" value="Login">

</form>

<br>

<a href="register.php">Register Here</a>

<p><?php echo $message; ?></p>

</body>
</html>
