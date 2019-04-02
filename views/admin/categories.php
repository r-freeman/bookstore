<?php include 'templates/admin/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li><a href="books.php">Books</a></li>
                <li><a href="authors.php">Authors</a></li>
                <li class="active"><a href="categories.php">Categories</a></li>
                <li><a href="publishers.php">Publishers</a></li>
                <li><?php include 'templates/admin/users.php'; ?></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="sub-header">Categories <a href="add_category.php" class="btn btn-success pull-right">Add Category</a></h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name <a href="categories.php?sortby=name&order=ASC" class="btn-link">&uarr;</a> <a
                                    href="categories.php?sortby=name&order=DESC" class="btn-link">&darr;</a></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($categories as $category) { ?>
                        <tr>
                            <td>
                                <p><?= $category->name; ?></p>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="edit_category.php?id=<?= $category->id; ?>" class="btn btn-default">Edit</a>
                                    <a href="delete_category.php?id=<?= $category->id; ?>" class="btn btn-danger" onclick="return confirm('Delete this category?')">Delete</a>
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
