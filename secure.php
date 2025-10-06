<?php
// index.php - Secure login (prepared statements), uses appuser/AppP@ssw0rd and sqli_lab
session_start();

$DB_HOST = 'localhost';
$DB_USER = 'appuser';
$DB_PASS = 'AppP@ssw0rd';
$DB_NAME = 'sqli_lab';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_error) {
    // log or show brief message
    error_log("DB connection error: " . $mysqli->connect_error);
    http_response_code(500);
    echo "Internal server error.";
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_username = trim($_POST['username'] ?? '');

    if ($input_username === '') {
        $message = 'Please enter a username';
    } else {
        // Prepared statement - safe from SQLi
        $stmt = $mysqli->prepare("SELECT id, username, fullname FROM users WHERE username = ? LIMIT 1");
        if ($stmt) {
            $stmt->bind_param('s', $input_username);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res && $res->num_rows === 1) {
                $row = $res->fetch_assoc();
                // Save user (fullname and username) in session and redirect
                $_SESSION['username'] = $row['username'];
                $_SESSION['fullname'] = $row['fullname'];
                header('Location: /welcome.php');
                exit();
            } else {
                $message = 'Invalid user';
            }
            $stmt->close();
        } else {
            // prepare failed
            error_log("Prepare failed: " . $mysqli->error);
            $message = 'Internal error';
        }
    }
}

$mysqli->close();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Secure Login</title>
  <style>
    body { font-family: Arial, sans-serif; text-align:center; margin-top:80px; background:#f7f7f7; }
    form { background:#fff; padding:20px; display:inline-block; border-radius:8px; box-shadow:0 4px 10px rgba(0,0,0,0.06); }
    input { padding:8px 10px; width:220px; }
    button { padding:8px 12px; margin-left:8px; }
    p.msg { color:#b00020; margin-top:12px; }
  </style>
</head>
<body>
  <h2>Secure Login</h2>
  <form method="post" action="">
    <input type="text" name="username" placeholder="username" required />
    <button type="submit">Login</button>
  </form>

  <?php if ($message): ?>
    <p class="msg"><?= htmlspecialchars($message) ?></p>
  <?php endif; ?>
</body>
</html>
