<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Old Soul Oasis</title>
    <link rel="icon" href="images/logo.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('productDescription').addEventListener('keydown', function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    var textarea = event.target;
                    textarea.value = textarea.value + '\\n';
                }
                const adminSubmitButton = document.querySelector('.submit-btn');
                    adminSubmitButton.addEventListener('click', function() {
                    localStorage.setItem('addSuccess', 'true');
                });
            });
        });
    </script>
</head>
<body>

<?php include 'header.php'; ?>
<?php
if (!isset($_SESSION['id']) || $_SESSION['admin'] !== true) {
    header('Location: index.php');
    exit();
}
?>
<div aria-live="polite" aria-atomic="true" style="position: relative; z-index: 1050;">
    <div id="toast-container" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;"></div>
</div>

<div class="container mt-5">
    <h1>Add Product</h1>
    <br>
    <form id="addProductForm" method="POST" action="add_product_process.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="productName"><h4>Product Name</h4></label>
            <input type="text" class="form-control" id="productName" name="productName" required>
        </div>
        <div class="form-group">
            <label for="productPrice"><h4>Price</h4></label>
            <input type="number" class="form-control" id="productPrice" name="productPrice" step="0.01" min="0.01" required>
        </div>
        <div class="form-group">
            <label for="productDescription"><h4>Description</h4></label>
            <textarea class="form-control" id="productDescription" name="productDescription" rows="6" required></textarea>
        </div>
        <div class="form-group">            
            <div>
                <label for="productImage"><h4>Product Image</h4></label>
            </div>
            <div >
                <input type="file" class="form-control-file" id="productImage" name="productImage" accept="image/*" required>
            </div>
        </div>
        <button type="submit" class="btn btn-block submit-btn">Submit</button>
    </form>
</div>

<?php include 'footer.php'; ?>
<?php include 'scripts.php'; ?>

</body>
</html>