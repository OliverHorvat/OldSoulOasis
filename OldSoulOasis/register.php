<?php
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
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
            header('Location: index.php');
            exit;
        } else {
            header('Location: register.php');
            exit;
        }

        $conn->close();
    } else {
        header('Location: register.php');
        exit;
    }
}
?>
