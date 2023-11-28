<?php


include 'DBconnect.php';
$objDB = new DbConnect();
$conn = $objDB->connect();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "GET":

        $sql = "SELECT bo.official_type, bo.officials_id AS latest_id, bo.official_name
        FROM barangay_officials bo
        JOIN (
            SELECT official_type, MAX(officials_id) AS latest_id
            FROM barangay_officials
            GROUP BY official_type
        ) latest_ids ON bo.official_type = latest_ids.official_type
            AND bo.officials_id = latest_ids.latest_id";


        if (isset($sql)) {
            $stmt = $conn->prepare($sql);

            $stmt->execute();
            $officials = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($officials);
        }


        break;





    case "POST":
        $officials = json_decode(file_get_contents('php://input'));
        $sql = "INSERT INTO barangay_officials (official_type, official_name) VALUES (:official_type, :official_name)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':official_type', $officials->official_type);
        $stmt->bindParam(':official_name', $officials->official_name);


        if ($stmt->execute()) {

            $response = [
                "status" => "success",
                "message" => "officials successfully"
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "officials failed"
            ];
        }

        echo json_encode($response);
        break;
}
