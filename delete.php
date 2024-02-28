<?php
include 'config.php'; // Include your database configuration

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the delete statement
        $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
        $stmt->execute([$id]);

        // Redirect back to the index page
        header("Location: index.php");
    } catch (PDOException $e) {
        die("Could not connect to the database $dbname :" . $e->getMessage());
    }
} else {
    // Redirect to index.php if the id parameter is not set
    header("Location: index.php");
}
?>
