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
            <h2 class="sub-header">Add category</h2>
            <form action="add_category.php" method="post">
                <div class="form-group <?= error('name') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="<?= old('name'); ?>">
                    <span class="help-block"><?= error('name'); ?></span>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php include 'templates/admin/footer.php'; ?>
