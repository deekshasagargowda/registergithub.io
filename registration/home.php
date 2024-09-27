<?php
session_start();

if (!isset($_SESSION['user'])) {
    echo "<script>alert('Please login first!'); window.location.href='login.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .header {
            background-color: #0066cc;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .header .nav-links {
            display: flex;
            gap: 20px;
            flex-grow: 1;
        }

        .header .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .header .nav-links a:hover {
            text-decoration: underline;
        }

        .header .account {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
        }

        .header .account span {
            white-space: nowrap;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .header .account i {
            color: white;
            font-size: 30px;
            cursor: pointer;
        }

        .dropdown {
            display: none;
            position: absolute;
            top: 40px;
            right: 0;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown a {
            color: #333;
            padding: 10px;
            text-decoration: none;
            display: block;
        }

        .dropdown a:hover {
            background-color: #f1f1f1;
        }

        .container {
            text-align: center;
            margin: 100px auto 50px;
        }

        .footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="header">
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="services.php">Services</a>
            <a href="contact.php">Contact</a>
        </div>
        <div class="account">
            <i class="fas fa-user" onclick="toggleDropdown()"></i> <!-- User icon -->
            <span><?php echo $_SESSION['user']; ?></span>
            <div class="dropdown" id="dropdownMenu">
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['user']; ?>!</h1>
    </div>
    <div class="footer">
        <p>&copy; 2024. All Rights Reserved.</p>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

      
        window.onclick = function(event) {
            if (!event.target.matches('.fa-user')) {
                const dropdown = document.getElementById('dropdownMenu');
                if (dropdown.style.display === 'block') {
                    dropdown.style.display = 'none';
                }
            }
        }
    </script>
</body>
</html>
