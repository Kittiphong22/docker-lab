<?php
require 'connectdb.php';

$message = '';

// ตรวจสอบการส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $content = mysqli_real_escape_string($conn, trim($_POST['content']));

    if ($title && $content) {
        $sql = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php");
            exit;
        } else {
            $message = "❌ Error: " . mysqli_error($conn);
        }
    } else {
        $message = "⚠️ Please fill in both Title and Content.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create New Post</title>
<style>
/* Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Global */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #dbeafe, #eef2ff);
    color: #333;
    line-height: 1.6;
}

/* Navbar */
nav {
    background: linear-gradient(90deg, #007BFF, #0056b3);
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

nav h1 {
    font-size: 1.5em;
    font-weight: 600;
}

nav a {
    color: #fff;
    text-decoration: none;
    background: rgba(255,255,255,0.2);
    padding: 8px 16px;
    border-radius: 8px;
    transition: 0.3s;
    font-weight: 500;
}

nav a:hover {
    background: rgba(255,255,255,0.35);
}

/* Container */
.container {
    max-width: 700px;
    margin: 50px auto;
    background-color: #fff;
    padding: 40px;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    animation: fadeIn 0.6s ease-in-out;
}

/* Heading */
h2 {
    text-align: center;
    color: #007BFF;
    margin-bottom: 25px;
    font-weight: 700;
}

/* Form */
form input[type="text"],
form textarea {
    width: 100%;
    padding: 14px;
    margin: 10px 0 20px;
    border-radius: 10px;
    border: 1px solid #ccc;
    font-size: 1em;
    transition: 0.3s;
    background: #f9f9f9;
}

form input[type="text"]:focus,
form textarea:focus {
    border-color: #007BFF;
    background: #fff;
    box-shadow: 0 0 8px rgba(0,123,255,0.4);
    outline: none;
}

form textarea {
    min-height: 200px;
    resize: vertical;
}

/* Button */
form button {
    background: linear-gradient(90deg, #007BFF, #0056b3);
    color: #fff;
    padding: 14px 25px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 1.05em;
    font-weight: bold;
    transition: 0.3s;
    display: block;
    width: 100%;
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

form button:hover {
    background: linear-gradient(90deg, #0056b3, #003f88);
    transform: translateY(-2px);
}

/* Message */
.message {
    text-align: center;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-weight: bold;
}

.message.error {
    background: #ffe0e0;
    color: #b30000;
    border: 1px solid #ff9999;
}

.message.warning {
    background: #fff7e6;
    color: #b36b00;
    border: 1px solid #ffd480;
}

.message.success {
    background: #e6ffed;
    color: #007a33;
    border: 1px solid #80ffaa;
}

/* Back link */
a.back-link {
    display: block;
    margin-top: 20px;
    text-align: center;
    color: #007BFF;
    text-decoration: none;
    font-weight: 500;
}

a.back-link:hover {
    text-decoration: underline;
}

/* Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
</head>
<body>
<nav>
    <h1>📖 My Blog & Reviews</h1>
    <a href="index.php">&larr; Back</a>
</nav>

<div class="container">
    <h2>Create New Post</h2>

    <?php if ($message): ?>
        <div class="message <?= strpos($message, 'Error') !== false ? 'error' : 'warning' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="title" placeholder="Post Title" required>
        <textarea name="content" placeholder="Write your review or article..." required></textarea>
        <button type="submit">🚀 Publish Post</button>
    </form>
</div>
</body>
</html>
