<?php
// Vulnerable single-field login (for lab only)
// Make sure DB credentials below match your MariaDB user & database.
$servername = 'localhost';
$dbuser     = 'appuser';
$dbpass     = 'AppP@ssw0rd';
$dbname     = 'sqli_lab';

$conn = new mysqli($servername, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';

    // VULNERABLE: direct concatenation into SQL (for demonstration only)
    $sql = "SELECT id, username, fullname FROM users WHERE username = '$username' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $message = "Welcome, " . htmlspecialchars($row['fullname']);
    } else {
        $message = "Invalid user";
    }
}
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Vulnerable Login</title>
  </head>
  <body>
    <h2>Login (single field)</h2>
    <form method="POST" action="/">
      <input type="text" name="username" placeholder="username" />
      <button type="submit">Login</button>
    </form>
    <p><?php echo htmlspecialchars($message); ?></p>
  </body>
</html>
