<?php
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["register"])) {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if ($name !== "" && $email !== "" && $password !== "") {

        $_SESSION["user"] = [
            "name" => $name,
            "email" => $email,
            "password" => $password
        ];

        $message = "Registration successful! <a href='login.php'>Go to Login</a>";
    } else {
        $message = "Please fill all fields.";
    }
}
?>

<form method="post">
  Name: <input type="text" name="name"><br>
  Email: <input type="email" name="email"><br>
  Password: <input type="password" name="password"><br>
  <input type="submit" name="register" value="Register">
</form>

<p><?php echo $message; ?></p>