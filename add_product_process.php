<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OldSoulOasis";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Provjera je li korisnik prijavljen kao admin
if (!isset($_SESSION['id']) || $_SESSION['admin'] !== true) {
    header('Location: index.php'); // Preusmjeravamo neovlaštene korisnike
    exit();
}

// Provjera je li forma poslana
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productDescription = $_POST['productDescription'];

    // Zamjena HTML novih redova s pravim novim redovima
    $productDescription = str_replace('<br>', "\n", $productDescription);

    // Upload slike proizvoda
    $targetDir = 'images/';
    $targetFile = $targetDir . basename($_FILES['productImage']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Provjera je li slika stvarno slika
    $check = getimagesize($_FILES['productImage']['tmp_name']);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Provjera veličine slike (možete prilagoditi vaše potrebe)
    if ($_FILES['productImage']['size'] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Dopuštene formate slike (ovdje možete dodati ili promijeniti formate)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        try {
            // Početak transakcije
            $pdo->beginTransaction();

            // Dohvaćanje maksimalnog ID-a iz products_archive
            $stmtMaxId = $pdo->query("SELECT MAX(id) AS max_id FROM products_archive");
            $row = $stmtMaxId->fetch(PDO::FETCH_ASSOC);
            $newProductId = $row['max_id'] + 1;

            // Spremanje proizvoda u products
            $stmtProducts = $pdo->prepare("INSERT INTO products (id, name, price, description, image) VALUES (:id, :name, :price, :description, :image)");
            $stmtProducts->bindParam(':id', $newProductId);
            $stmtProducts->bindParam(':name', $productName);
            $stmtProducts->bindParam(':price', $productPrice);
            $stmtProducts->bindParam(':description', $productDescription);
            $stmtProducts->bindParam(':image', $targetFile); // Ovdje ćemo spremiti putanju do slike

            // Spremanje proizvoda u products_archive
            $stmtArchive = $pdo->prepare("INSERT INTO products_archive (id, name, price, description, image) VALUES (:id, :name, :price, :description, :image)");

            if ($stmtProducts->execute() && $stmtArchive->execute(array(':id' => $newProductId, ':name' => $productName, ':price' => $productPrice, ':description' => $productDescription, ':image' => $targetFile))) {
                // Upload slike na server
                if (move_uploaded_file($_FILES['productImage']['tmp_name'], $targetFile)) {
                    echo "The file " . htmlspecialchars(basename($_FILES["productImage"]["name"])) . " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
                // Commit transakcije ako je unos uspješan
                $pdo->commit();
                header('Location: add_product.php');
                exit();
            } else {
                echo "Error inserting product into database.";
            }
        } catch (PDOException $e) {
            // Rollback transakcije u slučaju greške
            $pdo->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
