<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bookstore | <?= $book->title; ?></title>
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
                             src="<?= $book->cover; ?>" alt="">
                    </div>
                    <div class="col-12 col-md-8">
                        <h3 class="m-0"><?= $book->title; ?></h3>
                        <a class="mb-5"
                           href="author.php?id=<?= $bookAuthors[0]->id; ?>"><?= $bookAuthors[0]->name; ?></a>
                        <p class="mb-5"><sup>£<span><?= $betterPrice[0]; ?></span>.<?= $betterPrice[1]; ?></sup></p>
                        <button class="btn btn-primary mb-5 px-5 py-2 animate" data-elem=".fa-shopping-basket"
                                data-anim="swing">Add to cart
                        </button>
                    </div>
                    <div class="col-12">
                        <section class="synopsis mb-5">
                            <h6>Synopsis</h6>
                            <p><?= $book->synopsis; ?></p>
                        </section>
                        <h6>Product details</h6>
                        <div class="table-responsive">
                            <table class="table table-borderless table-sm mb-7">
                                <tbody>
                                <tr>
                                    <th scope="row">Category</th>
                                    <td>
                                        <a href="category.php?id=<?= $book->category_id; ?>"><?= Category::find($book->category_id)->name; ?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Authors</th>
                                    <td>
                                        <?php foreach ($bookAuthors as $author) { ?>
                                            <a href="author.php?id=<?= $author->id; ?>"><?= $author->name; ?></a>
                                        <?php }; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">ISBN</th>
                                    <td><?= $book->isbn; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Year</th>
                                    <td><?= $book->year; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Length</th>
                                    <td><?= $book->length; ?> pages</td>
                                </tr>
                                <tr>
                                    <th scope="row">Formats</th>
                                    <td>Paperback</td>
                                </tr>
                                <tr>
                                    <th scope="row">Publisher</th>
                                    <td>
                                        <a href="<?= $publisher->website; ?>" title="<?= $publisher->name; ?>"><?= $publisher->name; ?></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php if (count($moreBooks) > 0) { ?>
                    <div class="row">
                        <div class="col-12">
                            <h3 class="mb-5">More books like this</h3>
                        </div>
                        <?php foreach ($moreBooks as $book) { ?>
                            <div class="col-6 col-sm-3 col-lg-3 mb-4">
                                <a href="book.php?id=<?= $book->id; ?>"><img class="d-block img-fluid w-100"
                                                                             src="<?= $book->cover; ?>"
                                                                             alt="<?= $book->title; ?>"></a>
                            </div>
                        <?php }; ?>
                    </div>
                <?php }; ?>
            </main>
        </div>
    </div>
<?php include 'templates/user/footer.php'; ?>