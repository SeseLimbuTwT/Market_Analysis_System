<?php

require_once "includes/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password)
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        $message = "Registration successful!";
    } else {
        $message = "Email already exists.";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Register - Market Analyst</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include "includes/navbar.php"; ?>

<h1>Create Account</h1>

<form method="POST">

    <label>Name:</label>
    <input type="text" name="name" required>

    <br><br>

    <label>Email:</label>
    <input type="email" name="email" required>

    <br><br>

    <label>Password:</label>
    <input type="password" name="password" required>

    <br><br>

    <button type="submit">Register</button>

</form>

<p><?php echo $message; ?></p>

<p>
    Already have an account?
    <a href="login.php">Login</a>
</p>

</body>
</html>