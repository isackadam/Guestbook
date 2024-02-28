<?php
include 'config.php';
// Add this line to dump the POST data
var_dump($_POST);

if (isset($_POST['id'], $_POST['name'], $_POST['message'])) {
    
    try {
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Update the message
        $stmt = $pdo->prepare("UPDATE messages SET name = ?, message = ? WHERE id = ?");
        $stmt->execute([$_POST['name'], $_POST['message'], $_POST['id']]);
        
        // Redirect back to the index page
        header("Location: index.php");
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
