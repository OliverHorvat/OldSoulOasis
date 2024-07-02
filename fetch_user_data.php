<?php
// Uključi vašu konekciju na bazu podataka
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "oldsouloasis";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Dohvati korisničke podatke iz baze podataka
    $stmt = $conn->prepare("SELECT email FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $_SESSION['id']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Podaci korisnika
        $email = $user['email'];
    } else {
        // Ako korisnik nije pronađen, obradi grešku
        echo "Korisnik nije pronađen.";
        exit;
    }

    // Dohvati sve transakcije korisnika s detaljima proizvoda i ukupnom cijenom
    $stmt = $conn->prepare("
        SELECT th.transaction_id, 
               GROUP_CONCAT(pr.name SEPARATOR ', ') AS products,
               GROUP_CONCAT(th.quantity SEPARATOR ', ') AS quantities,
               GROUP_CONCAT(pr.price SEPARATOR ', ') AS prices,
               SUM(pr.price * th.quantity) AS total_price,
               th.transaction_date
        FROM transaction_history th
        INNER JOIN products_archive pr ON th.product_id = pr.id
        WHERE th.user_id = :user_id
        GROUP BY th.transaction_id
        ORDER BY th.transaction_date DESC
    ");
    $stmt->bindParam(':user_id', $_SESSION['id']);
    $stmt->execute();
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Greška u bazi podataka
    echo "Database error: " . $e->getMessage();
    exit;
}
?>
