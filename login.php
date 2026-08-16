<?php

session_start();

require_once "includes/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT id, name, password FROM users WHERE email = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];

            header("Location: index.php");
    exit();
            
        } else {
            $message = "Incorrect password.";
        }

    } else {
        $message = "Account not found.";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login - Market Analyst</title>
    <link rel="stylesheet" href="css/style.css?v=2">
</head>

<body class="auth-page">

    <div class="auth-container">

        <div class="auth-card">

            <h1>Market Analyst</h1>

            <p class="auth-subtitle">Welcome back</p>

            <form method="POST">

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email"
                           placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password"
                           placeholder="Enter your password" required>
                </div>

                <button type="submit" class="auth-button">
                    Login
                </button>

            </form>

            <?php if ($message != ""): ?>
                <p class="auth-message">
                    <?php echo $message; ?>
                </p>
            <?php endif; ?>

            <p class="auth-link">
                Don't have an account?
                <a href="register.php">Register</a>
            </p>

        </div>

    </div>

</body>
</html>