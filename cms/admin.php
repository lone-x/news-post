<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $slug = strtolower(str_replace(' ', '-', $title));

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $imagePath = 'postedimages/' . basename($image['name']);
        move_uploaded_file($image['tmp_name'], $imagePath);
    } else {
        $imagePath = '';
    }

    $stmt = $conn->prepare("INSERT INTO posts (title, content, image_url, slug) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $content, $imagePath, $slug);
    $stmt->execute();
    $stmt->close();

    // Generate PHP file for the post
    $post_id = $conn->insert_id;
    generatePostFile($post_id, $title, $content, $imagePath, $slug);

    // Move the newly created PHP file to the posts folder
    rename("post_$post_id.php", "posts/post_$post_id.php");

    header('Location: index.php');
}

function generatePostFile($post_id, $title, $content, $image_url, $slug) {
    $template = file_get_contents('template.php');
    $template = str_replace('{{title}}', $title, $template);
    $template = str_replace('{{content}}', $content, $template);
    $template = str_replace('{{image_url}}', $image_url, $template);
    $template = str_replace('{{post_id}}', $post_id, $template);

    $filename = "post_$post_id.php";
    file_put_contents($filename, $template);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Create a New Post</h1>
    <form action="admin.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-primary">Create Post</button>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
