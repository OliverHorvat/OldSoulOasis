<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Old Soul Oasis</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-4 search-form">
    <div class="row align-items-center">
        <div class="col-md-6 mb-2 mb-md-0">
            <input class="form-control form-control-lg mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        </div>
        <div class="col-md-2 mb-2 mb-md-0">
            <select class="form-control">
                <option value="">Category</option>
                <option value="category1">Category 1</option>
                <option value="category2">Category 2</option>
                <option value="category3">Category 3</option>
                <option value="category4">Category 4</option>
            </select>
        </div>
        <div class="col-md-2 mb-2 mb-md-0">
            <select class="form-control">
                <option value="">Sort by</option>
                <option value="price_asc">Price: Low to High</option>
                <option value="price_desc">Price: High to Low</option>
                <option value="name_asc">Name: A to Z</option>
                <option value="name_desc">Name: Z to A</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-secondary btn-lg my-2 my-sm-0 btn-block" type="submit">Search</button>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <?php include 'display_items.php'; ?>
    </div>
</div>

<?php include 'modals.php'; ?>
<?php include 'footer.php'; ?>
<?php include 'scripts.php'; ?>

</body>
</html>