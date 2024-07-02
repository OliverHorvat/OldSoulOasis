<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OldSoulOasis";

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT wallet FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $walletAmount = $result['wallet'];

        echo json_encode(['amount' => $walletAmount]);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'User ID not provided']);
}
?>