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
            <h2 class="sub-header">Add author</h2>
            <form action="add_author.php" method="post" enctype="multipart/form-data">
                <div class="form-group <?= error('name') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="<?= old('name'); ?>">
                    <span class="help-block"><?= error('name'); ?></span>
                </div>
                <div class="form-group <?= error('born') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="born">Born</label>
                    <input type="text" class="form-control" name="born" id="born" value="<?= old('born'); ?>">
                    <span class="help-block"><?= error('born'); ?></span>
                </div>
                <div class="form-group <?= error('bio') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="title">Bio</label>
                    <textarea class="form-control" name="bio" id="bio"><?= old('bio'); ?></textarea>
                    <span class="help-block"><?= error('bio'); ?></span>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="featured" id="featured"> Featured
                    </label>
                </div>
                <div class="form-group <?= error('photo') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="photo">Photo</label>
                    <input type="file" class="form-control" id="photo" name="photo">
                    <span class="help-block"><?= error('photo'); ?></span>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php include 'templates/admin/footer.php'; ?>
