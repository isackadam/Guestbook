<?php


include 'config.php';



try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $password);
    // Set the PDO error mode to exception for better error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If there is an error with the database connection, stop the script and show the error.
    die("Connection failed: " . $e->getMessage());
}

// Check if the form is submitted correctly
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['message'])) {
    // Extract and sanitize input to prevent XSS attacks
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // SQL query to insert data into the messages table
    $sql = "INSERT INTO messages (name, message, posted_at) VALUES (:name, :message, NOW())";

    try {
        // Prepare the SQL statement for execution
        $stmt = $pdo->prepare($sql);
        
        // Bind the input values to the prepared statement
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        
        // Execute the prepared statement
        $stmt->execute();

        // Redirect to index.php after successful insertion
        header('Location: index.php');
        exit;
    } catch (PDOException $e) {
        // Handle SQL errors (e.g., duplicate entries, constraints violation) here
        die("Error: " . $e->getMessage());
    }
} else {
    // If the form is not submitted correctly, redirect to index.php
    header('Location: index.php');
    exit;
}

