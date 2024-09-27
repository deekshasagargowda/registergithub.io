<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'testdb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$error_msg = ''; // Variable to store error messages
$success_msg = ''; // Variable to store success message
$show_success_msg = false; // Variable to control success message display

if (isset($_POST['login'])) {
    $email_or_phone = $_POST['email_or_phone'];
    $password = $_POST['password'];

    // Check if the user exists
    $query = "SELECT * FROM users WHERE email_or_phone='$email_or_phone'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['first_name'];
            $success_msg = "Login Successful!"; // Set success message
            $show_success_msg = true; // Control success message display
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'home.php'; // Redirect to home page after 3 seconds
                    }, 3000);
                  </script>";
        } else {
            $error_msg = "Invalid password!"; // Set error message
        }
    } else {
        $error_msg = "No user found! Redirecting to registration."; // Set error message
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'register.php'; // Redirect to registration after 3 seconds
                }, 3000);
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .success {
            color: green; 
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .success-icon {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST" action="login.php">
            <h2>Login</h2>
            <input type="text" name="email_or_phone" placeholder="Email or Phone" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <?php if ($error_msg): ?>
                <div class="error">
                    <span class="warning-icon"></span> <?php echo $error_msg; ?>
                </div>
            <?php endif; ?>
            <button type="submit" name="login">Login</button>
            <?php if ($show_success_msg): ?>
                <div class="success">
                    <span class="success-icon">✔️</span> <?php echo $success_msg; ?> <!-- Tick mark icon -->
                </div>
            <?php endif; ?>
        </form>
        <p>New user? <a href="register.php">Create an account</a></p> <!-- Create account link -->
    </div>
</body>
</html>
