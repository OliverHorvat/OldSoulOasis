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

        // Validate password length
        if (strlen($password) < 8) {
            $error = "Password must be at least 8 characters long.";
        } else {
            // Check if email already exists
            $sql = "SELECT * FROM users WHERE email=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // User with this email already exists
                $error = "User with this email address already exists.";
            } else {
                // Email does not exist, create new user
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $email, $hashedPassword);

                if ($stmt->execute()) {
                    // Registration successful, set session variables
                    $_SESSION['id'] = $stmt->insert_id;
                    $_SESSION['email'] = $email;
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

    // Return JSON response
    echo json_encode(array('success' => $success, 'error' => $error));
}
?>
