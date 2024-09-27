<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'testdb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errors = [];
$success_msg = '';

if (isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email_or_phone = $_POST['email_or_phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Password validation
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match!";
    } elseif (!preg_match("/^(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/", $password)) {
        $errors[] = "Password must be at least 8 characters long and contain at least one special character!";
    } else {
        // Check if the user already exists
        $check_query = "SELECT * FROM users WHERE email_or_phone='$email_or_phone'";
        $check_result = $conn->query($check_query);
        
        if ($check_result->num_rows > 0) {
            $errors[] = "An account with this email or phone number already exists!";
        } else {
            // Hash the password
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            // Insert user data into the database
            $query = "INSERT INTO users (first_name, last_name, email_or_phone, password) VALUES ('$fname', '$lname', '$email_or_phone', '$password_hash')";

            if ($conn->query($query)) {
                $success_msg = "Registration Successful!";
                header("Location: login.php");
                exit();
            } else {
                $errors[] = "Error in registration!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form method="POST" action="register.php">
            <h2>Create Account</h2>
            
            <?php if (!empty($errors)): ?>
                <div class="error">
                    <?php foreach ($errors as $error): ?>
                        <p><i class="warning-icon"></i> <?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <input type="text" name="fname" placeholder="First Name" value="<?php echo isset($fname) ? $fname : ''; ?>" required><br>
            <input type="text" name="lname" placeholder="Last Name" value="<?php echo isset($lname) ? $lname : ''; ?>" required><br>
            <input type="text" name="email_or_phone" placeholder="Email or Phone Number" value="<?php echo isset($email_or_phone) ? $email_or_phone : ''; ?>" required><br>
            
            <input type="password" id="password" name="password" placeholder="Password" required><br>
            <span id="passwordHelp" class="error-text"></span>
            
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required><br>
            <span id="confirmPasswordHelp" class="error-text"></span>
            
            <button type="submit" name="register">Register</button>

            <?php if ($success_msg): ?>
                <div class="success">
                    <p><?php echo $success_msg; ?></p>
                </div>
            <?php endif; ?>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p> 
    </div>

    <script>
        document.getElementById('password').addEventListener('input', function() {
            var password = this.value;
            var passwordHelp = document.getElementById('passwordHelp');
            if (password.length < 8 || !/[!@#$%^&*]/.test(password)) {
                passwordHelp.innerHTML = '<i class="warning-icon"></i> Password must be at least 8 characters long and contain at least one special character!';
            } else {
                passwordHelp.innerHTML = '';
            }
        });

        document.getElementById('confirm_password').addEventListener('input', function() {
            var password = document.getElementById('password').value;
            var confirmPassword = this.value;
            var confirmPasswordHelp = document.getElementById('confirmPasswordHelp');
            if (password !== confirmPassword) {
                confirmPasswordHelp.innerHTML = '<i class="warning-icon"></i> Passwords do not match!';
            } else {
                confirmPasswordHelp.innerHTML = '';
            }
        });
    </script>
</body>
</html>
