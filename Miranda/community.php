<?php
include 'db_connect.php';
include 'header.php';

// Handle new post
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['username']) && !empty($_POST['message'])) {
    $username = htmlspecialchars($_POST['username']);
    $message = htmlspecialchars($_POST['message']);
    $stmt = $conn->prepare("INSERT INTO guestbook_messages (username, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $message);
    $stmt->execute();
    $stmt->close();
}

// Fetch recent messages
$messages = [];
$result = $conn->query("SELECT username, message, posted_at FROM guestbook_messages ORDER BY posted_at DESC LIMIT 20");
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}
?>
<main>
  <h1>Community Guestbook</h1>
  <form method="post" action="community.php">
    <input type="text" name="username" placeholder="Your name" required>
    <textarea name="message" placeholder="Say something..." required></textarea>
    <button type="submit">Post</button>
  </form>
  <section class="messages">
    <h2>Recent Messages</h2>
    <pre>
<?php
if (!empty($messages)) {
    foreach ($messages as $msg) {
        echo htmlspecialchars($msg['username']) . " (" . date("M d, Y H:i", strtotime($msg['posted_at'])) . "):\n";
        echo htmlspecialchars($msg['message']) . "\n\n";
    }
} else {
    echo "No messages yet. Be the first!";
}
?>
    </pre>
  </section>
</main>
<?php
$conn->close();
include 'footer.php';
?>