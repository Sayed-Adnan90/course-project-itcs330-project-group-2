<?php

header('Content-Type: application/json');

require_once '../../common/db.php';

$conn = getDBConnection();

$method = $_SERVER['REQUEST_METHOD'];

switch($method){

    case 'GET':

        $stmt = $conn->query("SELECT * FROM resources");

        $resources = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($resources);

        break;

    case 'POST':

        $data = json_decode(file_get_contents("php://input"), true);

        $title = $data['title'];
        $description = $data['description'];
        $link = $data['link'];

        $stmt = $conn->prepare(
            "INSERT INTO resources(title, description, link)
             VALUES (?, ?, ?)"
        );

        $stmt->execute([$title, $description, $link]);

        echo json_encode([
            "success" => true,
            "message" => "Resource added"
        ]);

        break;

    case 'DELETE':

        $id = $_GET['id'];

        $stmt = $conn->prepare(
            "DELETE FROM resources WHERE id=?"
        );

        $stmt->execute([$id]);

        echo json_encode([
            "success" => true,
            "message" => "Resource deleted"
        ]);

        break;
}
?>
<?php

function getDBConnection() {

    $host = "localhost";
    $dbname = "UOB_COURSE_DB";
    $username = "root";
    $password = "";

    try {

        $conn = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8",
            $username,
            $password
        );

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;

    } catch(PDOException $e){

        die("Connection failed: " . $e->getMessage());
    }
}

?>