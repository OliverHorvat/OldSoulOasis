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

        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['admin'] = false;
                $success = true;
                if ($row['admin'] == 1) {
                    $_SESSION['admin'] = true;
                }
            } else {
                $error = "Incorrect password. Please try again.";
            }
        } else {
            $error = "User with this email address does not exist.";
        }

        $stmt->close();
        $conn->close();
    } else {
        $error = "Please enter email and password.";
    }
    echo json_encode(array('success' => $success, 'error' => $error));
}
?>