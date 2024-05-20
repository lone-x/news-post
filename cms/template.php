<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{title}}</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>{{title}}</h1>
    <?php if ('{{image_url}}'): ?>
        <img src="<?php echo '../{{image_url}}'; ?>" alt="<?php echo '{{title}}'; ?>" class="img-fluid">

    <?php endif; ?>
    <p class="mt-4"><?php echo nl2br(htmlspecialchars('{{content}}')); ?></p>
    <a href="../index.php" class="btn btn-secondary mt-3">Back to homepage</a>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
