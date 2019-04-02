<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bookstore | Authors</title>
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
                        <a class="nav-link active px-5" href="authors.php">Authors</a><span>&vert;</span>
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
                    <div class="col-12">
                        <h3 class="mb-5">Authors A-Z</h3>
                    </div>
                    <?= list_authors($authors); ?>
                </div>
                <?php if(count($featuredAuthors) > 0) { ?>
                    <div class="row">
                        <div class="col-12">
                            <h3 class="my-5">Featured authors</h3>
                        </div>
                        <?php foreach($featuredAuthors as $author) { ?>
                            <div class="col-6 col-sm-3 mb-3">
                                <a href="author.php?id=<?= $author->id; ?>" title="<?= $author->name; ?>">
                                    <img class="d-block img-fluid w-100" src="<?= $author->photo; ?>" alt="<?= $author->name; ?>"></a>
                            </div>
                        <?php }; ?>
                    </div>
                <?php }; ?>
            </main>
        </div>
    </div>
<?php include 'templates/user/footer.php'; ?>