<?php
require 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM posts WHERE id = $id");
    $post = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Handle image upload
    $image_url = $post['image_url'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = basename($_FILES["image"]["name"]);
        $target_dir = "postedimages/";
        $target_file = $target_dir . $image_name;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = $image_name;
        } else {
            echo "Failed to upload image.";
        }
    }

    $sql = "UPDATE posts SET title='$title', content='$content', image_url='$image_url' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: manage_post.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Edit Post</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" id="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" class="form-control" id="content" rows="5" required><?php echo htmlspecialchars($post['content']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control-file" id="image">
            <?php if (!empty($post['image_url'])): ?>
                <p>Current image:</p>
                <img src="postedimages/<?php echo htmlspecialchars($post['image_url']); ?>" alt="Post Image" style="width: 200px; height: auto;">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Update Post</button>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
