<?php
// Include the configuration file containing database connection settings
require 'config.php';

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form input data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify if password and confirm password match
    if ($password !== $confirm_password) {
        // Error message if passwords don't match
        $error = "Passwords do not match!";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement to insert the user details into the database
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");

        // Execute the prepared statement with user data
        if ($stmt->execute([$username, $hashed_password])) {
            // Redirect to the login page upon successful registration
            header("Location: login.php");
            exit;
        } else {
            // Display error message if registration fails
            $error = "Registration failed. Please try again!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Google Fonts for custom font styling -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* Reset box-sizing and apply font family */
        * {
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }
        /* Basic body styling */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f0f2f5;
            margin: 0;
        }
        /* Styling for the registration container */
        .register-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        /* Header styling */
        .register-container h2 {
            color: #333;
            margin-bottom: 20px;
            font-weight: 500;
        }
        /* Input group styling */
        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }
        /* Label styling */
        .input-group label {
            display: block;
            font-size: 14px;
            color: #333;
            font-weight: 500;
            margin-bottom: 6px;
        }
        /* Input field styling */
        .input-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        /* Submit button styling */
        .register-btn {
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
        /* Hover effect for submit button */
        .register-btn:hover {
            background: #0056b3;
        }
        /* Error message styling */
        .error-message {
            color: #d9534f;
            font-size: 14px;
            margin-top: 10px;
        }
        /* Link to login page styling */
        .link {
            margin-top: 20px;
            font-size: 14px;
            color: #333;
        }
        /* Link styling */
        .link a {
            color: #007bff;
            text-decoration: none;
        }
        /* Hover effect for link */
        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Create an Account</h2>
    <!-- Registration form with POST method to handle data submission -->
    <form method="POST" action="">
        <!-- Username input field -->
        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <!-- Password input field -->
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <!-- Confirm Password input field -->
        <div class="input-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <!-- Submit button for form submission -->
        <button type="submit" class="register-btn">Register</button>
        <!-- Display error message if set -->
        <?php if (isset($error)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </form>
    <!-- Link to login page if the user already has an account -->
    <div class="link">
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</div>

</body>
</html>
