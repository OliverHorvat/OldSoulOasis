<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OldSoulOasis";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

if (!isset($_SESSION['id']) || $_SESSION['admin'] !== true) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productDescription = $_POST['productDescription'];

    $productDescription = str_replace('<br>', "\n", $productDescription);

    $targetDir = 'images/';
    $targetFile = $targetDir . basename($_FILES['productImage']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES['productImage']['tmp_name']);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if ($_FILES['productImage']['size'] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        try {
            $pdo->beginTransaction();

            $stmtMaxId = $pdo->query("SELECT MAX(id) AS max_id FROM products_archive");
            $row = $stmtMaxId->fetch(PDO::FETCH_ASSOC);
            $newProductId = $row['max_id'] + 1;

            $stmtProducts = $pdo->prepare("INSERT INTO products (id, name, price, description, image) VALUES (:id, :name, :price, :description, :image)");
            $stmtProducts->bindParam(':id', $newProductId);
            $stmtProducts->bindParam(':name', $productName);
            $stmtProducts->bindParam(':price', $productPrice);
            $stmtProducts->bindParam(':description', $productDescription);
            $stmtProducts->bindParam(':image', $targetFile);

            $stmtArchive = $pdo->prepare("INSERT INTO products_archive (id, name, price, description, image) VALUES (:id, :name, :price, :description, :image)");

            if ($stmtProducts->execute() && $stmtArchive->execute(array(':id' => $newProductId, ':name' => $productName, ':price' => $productPrice, ':description' => $productDescription, ':image' => $targetFile))) {
                if (move_uploaded_file($_FILES['productImage']['tmp_name'], $targetFile)) {
                    echo "The file " . htmlspecialchars(basename($_FILES["productImage"]["name"])) . " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
                $pdo->commit();
                header('Location: add_product.php');
                exit();
            } else {
                echo "Error inserting product into database.";
            }
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
}
?>