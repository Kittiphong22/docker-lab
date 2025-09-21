<?php
require 'connectdb.php';

// ดึงโพสต์ล่าสุด
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

$posts = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Blog & Reviews</title>
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
    background: linear-gradient(180deg, #f9fbfd, #eef3f8);
    color: #333;
    line-height: 1.6;
}

/* Navbar */
nav {
    background: linear-gradient(90deg, #007BFF, #00C6FF);
    padding: 18px 35px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    position: sticky;
    top: 0;
    z-index: 1000;
}

nav h1 {
    font-size: 1.6em;
    font-weight: bold;
    letter-spacing: 0.5px;
}

nav a {
    color: #fff;
    text-decoration: none;
    background: rgba(0,0,0,0.15);
    padding: 10px 18px;
    border-radius: 6px;
    transition: 0.3s;
    font-weight: 500;
}

nav a:hover {
    background: rgba(0,0,0,0.3);
    transform: translateY(-2px);
}

/* Container */
.container {
    max-width: 1100px;
    margin: 40px auto;
    padding: 0 20px;
}

/* Dashboard Grid */
.posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 25px;
    align-items: stretch; /* ให้ทุกการ์ดสูงเท่ากัน */
}

/* Post Card */
.post-card {
    background: linear-gradient(135deg, #ffffff, #f5f9ff);
    border-radius: 14px;
    padding: 25px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    border: 1px solid #e6ecf5;

    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 250px; /* fix ความสูงขั้นต่ำให้การ์ดเท่ากัน */
}

.post-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 28px rgba(0,0,0,0.15);
}

/* เนื้อหา */
.post-card h2 {
    font-size: 1.2em;
    margin-bottom: 12px;
    color: #007BFF;
    transition: color 0.3s;
}

.post-card:hover h2 {
    color: #0056b3;
}

.post-card p {
    flex-grow: 1; /* ขยายเต็มพื้นที่เหลือ */
    color: #555;
    font-size: 0.95em;
    margin-bottom: 18px;
    line-height: 1.6;

    max-width: 100%;
    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: pre-wrap;
}

/* ปุ่ม Read More */
.post-card a.read-more {
    align-self: flex-start;
    display: inline-block;
    padding: 10px 18px;
    background: linear-gradient(90deg, #6C63FF, #007BFF);
    color: #fff;
    border-radius: 8px;
    font-size: 0.9em;
    text-decoration: none;
    transition: background 0.3s, transform 0.2s;
    font-weight: 500;
}

.post-card a.read-more:hover {
    background: linear-gradient(90deg, #5348d6, #0056b3);
    transform: scale(1.05);
}

/* Footer */
footer {
    margin-top: 60px;
    text-align: center;
    padding: 25px;
    background: #eef3f8;
    color: #555;
    font-size: 0.9em;
    border-top: 1px solid #ddd;
}

/* Responsive tweaks */
@media (max-width: 768px) {
    .post-card {
        min-height: auto; /* บนมือถือไม่ fix ความสูง ให้ auto */
    }
}
</style>
</head>
<body>
<nav>
    <h1>📖 My Blog & Reviews</h1>
    <a href="create_post.php">+ New Post</a>
</nav>

<div class="container">
    <div class="posts-grid">
        <?php foreach($posts as $post): ?>
        <div class="post-card">
            <h2><?= htmlspecialchars($post['title']) ?></h2>
            <p><?= nl2br(substr(htmlspecialchars($post['content']), 0, 200)) ?>...</p>
            <a class="read-more" href="post.php?id=<?= $post['id'] ?>">Read More & Comment →</a>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<footer>
    &copy; <?= date('Y') ?> My Blog. All rights reserved.
</footer>
</body>
</html>
