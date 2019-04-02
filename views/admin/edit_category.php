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
            <h2 class="sub-header">Edit category</h2>
            <form action="edit_category.php" method="post">
                <input type="hidden" name="id" value="<?= $category->id; ?>" />
                <div class="form-group <?= error('name') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="name">Title</label>
                    <input type="text" class="form-control" name="name" id="name" value="<?= old('name', $category->name); ?>">
                    <span class="help-block"><?= error('name'); ?></span>
                </div>
                <button onclick="history.back(-1)" class="btn btn-link">Cancel</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php include 'templates/admin/footer.php'; ?>
