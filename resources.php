<?php
include "db.php";
$conn = getDBConnection();

// Fetch resources
$sql = "SELECT * FROM resources";
$result = $conn->query($sql);
function getDBConnection() {
    $conn = new mysqli("localhost", "root", "", "lms_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Course Resources</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .card { border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; }
        .comment-box { margin-top: 10px; }
    </style>
</head>
<body>

<h1>Course Resources</h1>

<?php while ($row = $result->fetch_assoc()) { ?>
    <div class="card">
        <h3><?php echo $row['title']; ?></h3>
        <p><?php echo $row['description']; ?></p>
        <a href="<?php echo $row['link']; ?>" target="_blank">Open Resource</a>

        <h4>Comments</h4>

        <?php
        $id = $row['id'];
        $commentQuery = "SELECT * FROM comments_resource WHERE resource_id=$id ORDER BY created_at DESC";
        $comments = $conn->query($commentQuery);

        while ($c = $comments->fetch_assoc()) {
            echo "<p>💬 " . $c['comment'] . "</p>";
        }
        ?>

        <form method="POST" action="add_comment.php">
            <input type="hidden" name="resource_id" value="<?php echo $row['id']; ?>">
            <input type="text" name="comment" placeholder="Write comment..." required>
            <button type="submit">Add</button>
        </form>

    </div>
<?php } ?>

</body>
</html>