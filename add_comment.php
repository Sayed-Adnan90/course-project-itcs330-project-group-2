<?php
include "db.php";
$conn = getDBConnection();

$resource_id = $_POST['resource_id'];
$comment = $_POST['comment'];

$sql = "INSERT INTO comments_resource (resource_id, comment)
        VALUES ('$resource_id', '$comment')";

$conn->query($sql);

header("Location: resources.php");
exit;
?>