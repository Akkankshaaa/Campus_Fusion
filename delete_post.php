<?php
include '../public/db_connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch the image name before deleting
    $stmt = $connection->prepare("SELECT image FROM posts WHERE id = :id");
    $stmt->execute(array(':id' => $id));
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        // Delete image file
        if (file_exists("../uploads/" . $post['image'])) {
            unlink("../uploads/" . $post['image']);
        }

        // Delete record
        $delete = $connection->prepare("DELETE FROM posts WHERE id = :id");
        $delete->execute(array(':id' => $id));

        echo "<script>alert('Post deleted successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Post not found!'); window.location.href='dashboard.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='dashboard.php';</script>";
}
?>
