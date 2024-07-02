<?php
session_start();

$error = ''; 
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "OldSoulOasis";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        if (strlen($password) < 8) {
            $error = "Password must be at least 8 characters long.";
        } else {
            $sql = "SELECT * FROM users WHERE email=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "User with this email address already exists.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $email, $hashedPassword);

                if ($stmt->execute()) {
                    $_SESSION['id'] = $stmt->insert_id;
                    $_SESSION['email'] = $email;
                    $_SESSION['admin'] = 0;
                    $success = true;
                } else {
                    $error = "Error: " . $stmt->error;
                }
            }
            $stmt->close();
        }
        $conn->close();
    } else {
        $error = "Please enter email and password.";
    }
    echo json_encode(array('success' => $success, 'error' => $error));
}
?>