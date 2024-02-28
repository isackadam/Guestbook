<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guestbook</title>
    <link rel="stylesheet" href="css/style1.css">
</head>
<body>
    <h1>Welcome to the Guestbook</h1>
    <form action="process.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea>
        <button type="submit">Submit</button>
    </form>
    <div class="messages">
        <h2>Messages</h2>
        <?php

        include 'config.php';

        try {
            // Create a PDO instance
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Fetch messages from database
            $stmt = $pdo->query("SELECT id, name, message, posted_at FROM messages ORDER BY posted_at DESC");

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='message";
                if (new DateTime($row['posted_at']) > new DateTime('-1 day')) {
                    echo " new-message"; // Add the new-message class if the condition is met
                }
                echo "'>";
                echo "<strong>" . htmlspecialchars($row['name']) . ":</strong> ";
                echo htmlspecialchars($row['message']) . "<br>";
                echo "<em>at " . $row['posted_at'] . "</em>";
                echo " <a href='edit.php?id=" . $row['id'] . "' class='edit-link'>Edit</a>";
                // Delete link - make sure to confirm before deletion
                echo " <a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this message?\");' class='delete-link'>Delete</a>";
                echo "</div>";
            }
        } catch (PDOException $e) {
            // If there is an error with the database connection, display the error
            echo "Connection failed: " . $e->getMessage();
        }
        ?>
    </div>

</body>
</html>
