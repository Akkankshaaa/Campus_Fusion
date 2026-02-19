<?php
include '../public/db_connect.php';

// Fetch all posts with category name (if exists)
try {
    $query = $connection->prepare("
        SELECT 
            posts.id, 
            posts.title, 
            posts.price, 
            posts.created_at, 
            categories.name AS category_name 
        FROM posts 
        LEFT JOIN categories ON posts.category_id = categories.id
        ORDER BY posts.created_at DESC
    ");

    $query->execute();
    $posts = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<?php include '../public/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../public/style.css">
    <style>
        .dashboard-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
        }
        .btn-add {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .posts-table {
            width: 100%;
            border-collapse: collapse;
        }
        .posts-table th, .posts-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .btn-edit {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h2>Admin Dashboard</h2>
    <a href="add_post.php" class="btn-add">+ Add New Post</a>

    <table class="posts-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Price</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?= htmlspecialchars($post['id']) ?></td>
                        <td><?= htmlspecialchars($post['title']) ?></td>
                        <td><?= htmlspecialchars($post['category_name'] ?? 'Uncategorized') ?></td>
                        <td><?= htmlspecialchars($post['price']) ?></td>
                        <td><?= htmlspecialchars($post['created_at']) ?></td>
                        <td>
                            <a href="edit_post.php?id=<?= $post['id'] ?>" class="btn-edit">Edit</a>
                            <a href="delete_post.php?id=<?= $post['id'] ?>" class="btn-delete"
                               onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No posts found. Add a new post to get started!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
