<?php
session_start();

// If not logged in, go back to login
if (!isset($_SESSION['username']) || !isset($_SESSION['fullname'])) {
    header('Location: /index.php');
    exit();
}

$fullname = htmlspecialchars($_SESSION['fullname']);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Welcome</title>
  <style>
    body { font-family: Arial, sans-serif; text-align:center; margin-top:100px; background:#eef9f1; }
    .card { display:inline-block; background:#fff; padding:30px; border-radius:10px; box-shadow:0 6px 18px rgba(0,0,0,0.08); }
    a.logout { display:block; margin-top:16px; color:#fff; background:#d9534f; padding:8px 12px; border-radius:6px; text-decoration:none; }
  </style>
</head>
<body>
  <div class="card">
    <h1>Hello, <?= $fullname ?> 👋</h1>
    <p>Welcome to your secured page.</p>
    <a class="logout" href="/logout.php">Logout</a>
  </div>
</body>
</html>
