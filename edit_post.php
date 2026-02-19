<?php
include '../public/db_connect.php';

$error = "";
$success = "";

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid post ID!'); window.location.href='dashboard.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// Fetch existing post details
$query = $connection->prepare("SELECT * FROM posts WHERE id = :id");
$query->execute(array(':id' => $id));
$post = $query->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    echo "<script>alert('Post not found!'); window.location.href='dashboard.php';</script>";
    exit;
}

// Handle form submission
if (isset($_POST['update'])) {
    $title = htmlspecialchars(trim($_POST['title']));
    $content = htmlspecialchars(trim($_POST['content']));
    $price = htmlspecialchars(trim($_POST['price']));
    $category_id = intval($_POST['category_id']);

    if ($title == "" || $content == "" || $price == "" || $category_id == 0) {
        $error = "Please fill all required fields.";
    } else {
        $new_image_name = $post['image']; // keep old image by default

        // If new image uploaded
        if (!empty($_FILES['image']['name'])) {
            $image_name = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];
            $arr = explode('.', $image_name);
            $ext = strtolower(array_pop($arr));
            $new_image_name = "post_" . md5(time()) . "." . $ext;
            $destination = "../uploads/" . $new_image_name;

            if (move_uploaded_file($tmp_name, $destination)) {
                // delete old image
                if (file_exists("../uploads/" . $post['image'])) {
                    unlink("../uploads/" . $post['image']);
                }
            } else {
                $error = "Failed to upload new image.";
            }
        }

        // Update query
        if (empty($error)) {
            $update = $connection->prepare("UPDATE posts SET title = :title, price = :price, content = :content, category_id = :category_id, image = :image WHERE id = :id");
            $update->execute(array(
                ':title' => $title,
                ':price' => $price,
                ':content' => $content,
                ':category_id' => $category_id,
                ':image' => $new_image_name,
                ':id' => $id
            ));

            $success = "Post updated successfully!";
            // Refresh post data
            $query->execute(array(':id' => $id));
            $post = $query->fetch(PDO::FETCH_ASSOC);
        }
    }
}
?>

<?php include '../public/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>

<div class="addpost-container">
    <h2>Edit Menu Item / Offer</h2>

    <?php if (!empty($error)): ?>
        <div class="message error"><?= $error ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="message success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="input-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="<?= htmlspecialchars($post['title']) ?>" required>
        </div>

        <div class="input-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" value="<?= htmlspecialchars($post['price']) ?>" required>
        </div>

        <div class="input-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" required>
                <option value="">-- Select Category --</option>
                <option value="1" <?= ($post['category_id'] == 1) ? 'selected' : '' ?>>Snacks</option>
                <option value="2" <?= ($post['category_id'] == 2) ? 'selected' : '' ?>>Drinks</option>
                <option value="3" <?= ($post['category_id'] == 3) ? 'selected' : '' ?>>Combos</option>
                <option value="4" <?= ($post['category_id'] == 4) ? 'selected' : '' ?>>Meals</option>
                <option value="5" <?= ($post['category_id'] == 5) ? 'selected' : '' ?>>Desserts</option>
            </select>
        </div>

        <div class="input-group">
            <label for="content">Description</label>
            <textarea name="content" id="content" rows="5" required><?= htmlspecialchars($post['content']) ?></textarea>
        </div>

        <div class="input-group">
            <label>Current Image:</label><br>
            <img src="../uploads/<?= htmlspecialchars($post['image']) ?>" width="120"><br><br>
            <label for="image">Change Image (optional)</label>
            <input type="file" name="image" id="image" accept="image/*">
        </div>

        <button type="submit" name="update" class="btn-submit">Update Post</button>
    </form>
</div>

</body>
</html>
