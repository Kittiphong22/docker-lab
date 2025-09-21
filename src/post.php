<?php
require 'connectdb.php';

if (!isset($_GET['id'])) {
    die("Post ID missing!");
}

$post_id = (int)$_GET['id'];

// ดึงโพสต์
$sql = "SELECT * FROM posts WHERE id = $post_id";
$result = mysqli_query($conn, $sql);
$post = mysqli_fetch_assoc($result);
if (!$post) die("Post not found");

// เพิ่มคอมเมนต์
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $author = mysqli_real_escape_string($conn, trim($_POST['author']));
    $comment = mysqli_real_escape_string($conn, trim($_POST['comment']));
    if ($author && $comment) {
        $sql_insert = "INSERT INTO comments (post_id, author, comment) VALUES ($post_id, '$author', '$comment')";
        mysqli_query($conn, $sql_insert);
        header("Location: post.php?id=$post_id");
        exit;
    }
}

// ดึงคอมเมนต์
$sql_comments = "SELECT * FROM comments WHERE post_id = $post_id ORDER BY created_at DESC";
$result_comments = mysqli_query($conn, $sql_comments);
$comments = [];
while ($row = mysqli_fetch_assoc($result_comments)) {
    $comments[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($post['title']) ?></title>
<style>
/* Global */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #dbeafe, #eef2ff);
    margin: 0;
    padding: 20px;
    color: #333;
}

/* Container */
.container {
    max-width: 850px;
    margin: auto;
    background: #fff;
    padding: 35px;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    animation: fadeIn 0.6s ease-in-out;
}

/* Heading */
h1 {
    color: #007BFF;
    margin-bottom: 15px;
    font-size: 2em;
    font-weight: 700;
}

h3 {
    margin-top: 30px;
    color: #0056b3;
    font-weight: 600;
}

/* Back link */
a.back {
    display: inline-block;
    margin-bottom: 20px;
    color: #007BFF;
    text-decoration: none;
    font-weight: 500;
}
a.back:hover { text-decoration: underline; }

/* Post Content */
.post-content {
    font-size: 1.05em;
    line-height: 1.7;
    margin-bottom: 30px;
}

/* Comment Section */
.comment {
    border: 1px solid #eee;
    background: #f9f9f9;
    border-radius: 10px;
    padding: 15px 20px;
    margin-bottom: 15px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.05);
    transition: transform 0.2s;
}
.comment:hover {
    transform: translateY(-2px);
}
.comment-author {
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}
.comment-time {
    font-size: 0.85em;
    color: #666;
    margin-top: 8px;
}

/* Comment Form */
.comment-form {
    margin-top: 25px;
    background: #f9fbff;
    padding: 18px 20px;   /* ลด padding ให้เล็กลง */
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    border: 1px solid #e0e6f0;
}

.comment-form h3 {
    margin-bottom: 12px;
    font-size: 1.2em;
    color: #0056b3;
}

.comment-form input,
.comment-form textarea {
    width: 100%;
    padding: 10px;       /* ลด padding ลงเล็กน้อย */
    margin: 6px 0 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 0.95em;
    transition: 0.3s;
}

.comment-form input:focus,
.comment-form textarea:focus {
    border-color: #007BFF;
    box-shadow: 0 0 4px rgba(0,123,255,0.3);
    outline: none;
}

.comment-form button {
    background: linear-gradient(90deg, #007BFF, #0056b3);
    color: #fff;
    padding: 10px 18px;  /* ปรับขนาดปุ่มลงเล็กน้อย */
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.95em;
    font-weight: bold;
    transition: 0.3s;
    width: auto;         /* ไม่บังคับเต็มบรรทัดแล้ว */
    display: inline-block;
}

.comment-form button:hover {
    background: linear-gradient(90deg, #0056b3, #003f88);
    transform: translateY(-1px);
}


/* Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
</head>
<body>
<div class="container">
    <a class="back" href="index.php">&larr; Back to Home</a>

    <h1><?= htmlspecialchars($post['title']) ?></h1>
    <div class="post-content"><?= nl2br(htmlspecialchars($post['content'])) ?></div>

    <h3>💬 Comments</h3>
    <?php if ($comments): ?>
        <?php foreach($comments as $c): ?>
            <div class="comment">
                <div class="comment-author"><?= htmlspecialchars($c['author']) ?> said:</div>
                <div><?= nl2br(htmlspecialchars($c['comment'])) ?></div>
                <div class="comment-time"><?= $c['created_at'] ?></div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No comments yet. Be the first!</p>
    <?php endif; ?>

    <div class="comment-form">
        <h3>Add a Comment</h3>
        <form method="post">
            <input type="text" name="author" placeholder="Your name" required>
            <textarea name="comment" placeholder="Your comment..." rows="4" required></textarea>
            <button type="submit">➕ Submit Comment</button>
        </form>
    </div>
</div>
</body>
</html>
