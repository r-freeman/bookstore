<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bookstore | Buy Books Online</title>
    <link rel="stylesheet" href="styles/user/vendor.style.css">
    <link rel="stylesheet" href="styles/user/main.style.css">
</head>
<body>
<?php include 'templates/user/header.php'; ?>
    <div class="row">
        <div class="col-12">
            <nav class="text-center mb-5">
                <ul class="main-nav list-unstyled m-0 py-4">
                    <li class="nav-item">
                        <a class="nav-link px-5" href="books.php">Books</a><span>&vert;</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-5" href="authors.php">Authors</a><span>&vert;</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-5" href="#">New Releases</a><span>&vert;</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-5" href="#">Coming Soon</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
<?php include 'templates/user/sidebar.php'; ?>
        <div class="col-12 col-sm-12 col-md-12 col-xl-9">
            <main>
<?php include 'templates/user/carousel.php'; ?>
                <div class="row">
                    <div class="col-12 col-lg-6 mb-5">
                        <section class="feature-1 w-100"></section>
                    </div>
                    <div class="col-12 col-lg-3 mb-5">
                        <section class="feature-2 w-100"></section>
                    </div>
                    <div class="col-12 col-lg-3 mb-5">
                        <section class="feature-3 w-100"></section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="mb-5">Books of the Month</h3>
                    </div>
                    <?php foreach ($books as $book) { ?>
                        <div class="col-6 col-sm-6 col-lg-4 mb-4">
                            <a href="book.php?id=<?= $book->id; ?>" title="<?= $book->title; ?>"><img
                                        class="d-block img-fluid w-100"
                                        src="<?= $book->cover; ?>" alt="<?= $book->title; ?>"></a>
                        </div>
                    <? } ?>
                </div>
            </main>
        </div>
    </div>
<?php include 'templates/user/footer.php'; ?>