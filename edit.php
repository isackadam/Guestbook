<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Message</title>
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="css/style1.css">
</head>
<body>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    include 'config.php';
    
    try {
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Fetch the specific message
        $stmt = $pdo->prepare("SELECT * FROM messages WHERE id = ?");
        $stmt->execute([$id]);
        $message = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($message) {
            // Display form with message data
            echo "<form action='update.php' method='post'>
                    <input type='hidden' name='id' value='" . $message['id'] . "'>
                    <label for='name'>Name:</label>
                    <input type='text' id='name' name='name' value='" . htmlspecialchars($message['name']) . "' required>
                    <label for='message'>Message:</label>
                    <textarea id='message' name='message' required>" . htmlspecialchars($message['message']) . "</textarea>
                    <button type='submit'>Update</button>
                  </form>";
        } else {
            echo "Message not found.";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} else {
    echo "No message selected for editing.";
}
?>

</body>
</html>
