<?php
session_start();

$error = ''; // Initialize error message
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "OldSoulOasis";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepare SQL statement
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists and verify password
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Password correct, set session variables
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $success = true;
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

    // Return JSON response
    echo json_encode(array('success' => $success, 'error' => $error));
}
?>
