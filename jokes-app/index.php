<?php
session_start(); // Start the session

// Check if the user is logged in; if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Function to fetch a joke from the Joke API
function fetchJoke() {
    $api_url = 'https://v2.jokeapi.dev/joke/Any'; // API endpoint
    $response = file_get_contents($api_url); // Get the joke
    $joke_data = json_decode($response, true); // Decode the JSON response

    // Return joke based on its type (single or two-part)
    return $joke_data['type'] == 'single' ? $joke_data['joke'] : "{$joke_data['setup']} - {$joke_data['delivery']}";
}

// If no joke is set in the session, fetch a new one
if (!isset($_SESSION['joke'])) {
    $_SESSION['joke'] = fetchJoke(); // Store the joke in session
}

// If the button to fetch a new joke is clicked
if (isset($_POST['new_joke'])) {
    $_SESSION['joke'] = fetchJoke(); // Fetch a new joke
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* CSS styles for the home page */
        * {
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f0f2f5;
            color: #333;
        }
        .container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h1 {
            font-size: 24px;
            font-weight: 500;
            margin-bottom: 20px;
            color: #007bff; // Title color
        }
        .joke {
            font-size: 18px;
            margin: 20px 0;
            line-height: 1.5;
            color: #555;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            border-left: 5px solid #007bff; // Joke box style
        }
        .new-joke-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background: #28a745; // Button color
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .new-joke-btn:hover {
            background: #218838; // Button hover color
        }
        .logout {
            display: inline-block;
            margin-top: 10px;
            color: #333;
            font-size: 14px;
            text-decoration: none;
        }
        .logout:hover {
            text-decoration: underline; // Underline on hover
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1> <!-- Welcome message -->
    <div class="joke">
        <?php echo $_SESSION['joke']; ?> <!-- Display the joke -->
    </div>
    <form method="POST">
        <button type="submit" name="new_joke" class="new-joke-btn">Get New Joke</button> <!-- Button to fetch a new joke -->
    </form>
    <p><a href="logout.php" class="logout">Logout</a></p> <!-- Link to logout -->
</div>

</body>
</html
