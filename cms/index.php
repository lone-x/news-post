<?php
require 'db.php';

$result = $conn->query("SELECT id, title, content, image_url, slug FROM posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Homepage</h1>
    <div class="row">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card mb-4" style="width: 18rem;">
                    <?php if (!empty($row['image_url'])): ?>
                        <img src="./<?php echo htmlspecialchars($row['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars(substr($row['content'], 0, 100)); ?>...</p>
                        <a href="posts/post_<?php echo $row['id']; ?>.php" class="btn btn-primary">Read more</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
