<?php include 'templates/admin/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li><a href="books.php">Books</a></li>
                <li class="active"><a href="authors.php">Authors</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="publishers.php">Publishers</a></li>
                <li><?php include 'templates/admin/users.php'; ?></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="sub-header">Authors <a href="add_author.php" class="btn btn-success pull-right">Add Author</a></h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name <a href="authors.php?sortby=name&order=ASC" class="btn-link">&uarr;</a> <a
                                    href="authors.php?sortby=name&order=DESC" class="btn-link">&darr;</a></th>
                        <th>Born</th>
                        <th>Bio</th>
                        <th>Featured</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($authors as $author) { ?>
                        <tr>
                            <td>
                                <p><?= $author->name; ?></p>
                            </td>
                            <td>
                                <p><?= $author->born; ?></p>
                            </td>
                            <td>
                                <p><?= mb_strimwidth($author->bio,0, 75, ' ...'); ?></p>
                            </td>
                            <td>
                                <p><?= $author->featured ? 'Yes' : 'No'; ?></p>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="edit_author.php?id=<?= $author->id; ?>" class="btn btn-default">Edit</a>
                                    <a href="delete_author.php?id=<?= $author->id; ?>" class="btn btn-danger" onclick="return confirm('Delete this author?')">Delete</a>
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
