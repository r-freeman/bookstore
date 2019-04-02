<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bookstore | <?= $author->name; ?></title>
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
                <div class="row">
                    <div class="col-12 col-md-4">
                        <img class="d-block img-fluid w-100 mb-5"
                             src="<?= $author->photo ?>" alt="">
                    </div>
                    <div class="col-12 col-md-8">
                        <h3 class="m-0"><?= $author->name; ?></h3>
                        <span class="mb-5"><?= $author->born; ?></span>
                        <ul class="list-unstyled mb-5">
                            <li class="d-inline-block"><a href="#"><i class="fas fa-external-link-alt"></i></a></li>
                            <li class="d-inline-block"><a href="#"><i class="fab fa-twitter"></i></a></li>
                        </ul>
                    </div>
                    <div class="col-12">
                        <section class="biography mb-7">
                            <h6>Biography</h6>
                            <p><?= $author->bio; ?></p>
                        </section>
                    </div>
                </div>
                <?php if(count($booksWritten) > 0) { ?>
                    <div class="row">
                        <div class="col-12">
                            <h3 class="mb-5">Books by <?= $author->name; ?></h3>
                        </div>
                        <?php foreach($booksWritten as $book) { ?>
                            <div class="col-6 col-sm-4 mb-4">
                                <a href="book.php?id=<?= $book->id; ?>" title="<?= $book->title; ?>"><img class="d-block img-fluid w-100"
                                                 src="<?= $book->cover; ?>" alt="<?= $book->title; ?>"></a>
                            </div>
                        <?php }; ?>
                    </div>
                <?php }; ?>
            </main>
        </div>
    </div>
<?php include 'templates/user/footer.php'; ?>