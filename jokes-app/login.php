<?php
// Start session to store user information upon successful login
session_start();

// Include the database configuration file
require 'config.php';

// Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the username and password from the form input
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare an SQL statement to select the user with the provided username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    // Execute the SQL query with the given username
    $stmt->execute([$username]);
    // Fetch the user's data from the database
    $user = $stmt->fetch();

    // Check if the user exists and the password is correct
    if ($user && password_verify($password, $user['password'])) {
        // If valid, store user ID and username in session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        // Redirect to the index page after successful login
        header("Location: index.php");
        exit;
    } else {
        // Display an error message if login fails
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Link to Google Fonts for Roboto font style -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* General styling */
        * {
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f0f2f5;
            margin: 0;
        }
        /* Styling for the login form container */
        .login-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 300px;
            text-align: center;
        }
        .login-container h2 {
            margin: 0 0 20px;
            color: #333;
            font-weight: 500;
        }
        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .input-group label {
            font-size: 14px;
            color: #333;
            font-weight: 500;
            display: block;
            margin-bottom: 6px;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        /* Styling for the login button */
        .login-btn {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .login-btn:hover {
            background: #0056b3;
        }
        /* Styling for error messages */
        .error-message {
            color: #d9534f;
            font-size: 14px;
            margin-top: 10px;
        }
        /* Styling for the link to registration page */
        .link {
            margin-top: 20px;
            font-size: 14px;
            color: #333;
        }
        .link a {
            color: #007bff;
            text-decoration: none;
        }
        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <!-- Login form for user authentication -->
    <form method="POST" action="">
        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="login-btn">Login</button>
        <!-- Display error message if login fails -->
        <?php if (isset($error)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </form>
    <!-- Link to redirect users to the registration page if they don't have an account -->
    <div class="link">
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</div>

</body>
</html>
