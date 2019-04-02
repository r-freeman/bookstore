<?php include 'templates/admin/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="active"><a href="books.php">Books</a></li>
                <li><a href="authors.php">Authors</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="publishers.php">Publishers</a></li>
                <li><?php include 'templates/admin/users.php'; ?></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="sub-header">Books <a href="add_book.php" class="btn btn-success pull-right">Add Book</a></h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Title <a href="books.php?sortby=title&order=ASC" class="btn-link">&uarr;</a> <a
                                    href="books.php?sortby=title&order=DESC" class="btn-link">&darr;</a></th>
                        <th>Synopsis</th>
                        <th>Category</th>
                        <th>Author(s)</th>
                        <th>ISBN</th>
                        <th>Year</th>
                        <th>Price</th>
                        <th>Length</th>
                        <th>Publisher</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($books as $book) { ?>
                        <tr>
                            <td>
                                <p><?= $book->title; ?></p>
                            </td>
                            <td>
                                <p><?= mb_strimwidth($book->synopsis,0, 75, ' ...'); ?></p>
                            </td>
                            <td>
                                <p><?= Category::find($book->category_id)->name; ?></p>
                            </td>
                            <td>
                                <?php $bookAuthors = Book::getAuthors($book->id);
                                foreach ($bookAuthors as $author) { ?>
                                    <p><?= $author->name; ?></p>
                                <?php } ?>
                            </td>
                            <td>
                                <p><?= $book->isbn; ?></p>
                            </td>
                            <td>
                                <p><?= $book->year; ?></p>
                            </td>
                            <td>
                                <p><?= $book->price; ?></p>
                            </td>
                            <td>
                                <p><?= $book->length; ?> pages</p>
                            </td>
                            <td>
                                <p><?= Publisher::find($book->publisher_id)->name; ?></p>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="edit_book.php?id=<?= $book->id; ?>" class="btn btn-default">Edit</a>
                                    <a href="delete_book.php?id=<?= $book->id; ?>" class="btn btn-danger" onclick="return confirm('Delete this book?')">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php }; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include 'templates/admin/footer.php'; ?>
