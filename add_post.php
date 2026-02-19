<?php
include '../public/db_connect.php';

$error = "";
$success = "";

// Handle form submission
if (isset($_POST['upload'])) {
    $title = htmlspecialchars(trim($_POST['title']));
    $content = htmlspecialchars(trim($_POST['content']));
    $price = htmlspecialchars(trim($_POST['price']));
    $category_id = intval($_POST['category_id']); // from dropdown

    // Validate required fields
    if ($title == "" || $price == "" || $content == "" || $category_id == 0) {
        $error = "Please fill all required fields.";
    } else {
        // Image upload
        $image_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];

        if (!empty($image_name)) {
            $arr = explode('.', $image_name);
            $ext = strtolower(array_pop($arr));
            $new_name = "post_" . md5(time()) . "." . $ext;
            $destination = "../uploads/" . $new_name;

            if (move_uploaded_file($tmp_name, $destination)) {
                // Insert into posts table
                $query = $connection->prepare("INSERT INTO posts (title, price, content, category_id, image, created_at)
                                                VALUES (:title, :price, :content, :category_id, :image, NOW())");
                $query->execute(array(
                    ':title' => $title,
                    ':price' => $price,
                    ':content' => $content,
                    ':category_id' => $category_id,
                    ':image' => $new_name
                ));
                $success = "Post added successfully!";
            } else {
                $error = "Failed to upload image. Please try again.";
            }
        } else {
            $error = "Please upload an image.";
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
    <title>Add Post</title>
    <link rel="stylesheet" href="../public/style.css">

</head>
<body>

<div class="addpost-container">
    <h2>Add New Menu Item / Offer</h2>

    <?php if (!empty($error)): ?>
        <div class="message error"><?= $error ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="message success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="input-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" placeholder="Enter item name" required>
        </div>

        <div class="input-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" placeholder="Enter price" required>
        </div>

        <div class="input-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" required>
                <option value="">-- Select Category --</option>
                <option value="1">Snacks</option>
                <option value="2">Drinks</option>
                <option value="3">Combos</option>
                <option value="4">Meals</option>
                <option value="5">Desserts</option>
            </select>
        </div>

        <div class="input-group">
            <label for="content">Description</label>
            <textarea name="content" id="content" rows="5" placeholder="Enter item description..." required></textarea>
        </div>

        <div class="input-group">
            <label for="image">Upload Image</label>
            <input type="file" name="image" id="image" accept="image/*" required>
        </div>

        <button type="submit" name="upload" class="btn-submit">Add Post</button>
    </form>
</div>

</body>
</html>
