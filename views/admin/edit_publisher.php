<?php include 'templates/admin/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li><a href="books.php">Books</a></li>
                <li><a href="authors.php">Authors</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li class="active"><a href="publishers.php">Publishers</a></li>
                <li><?php include 'templates/admin/users.php'; ?></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="sub-header">Edit publisher</h2>
            <form action="edit_publisher.php" method="post">
                <input type="hidden" name="id" value="<?= $publisher->id; ?>" />
                <div class="form-group <?= error('name') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="<?= old('name', $publisher->name); ?>">
                    <span class="help-block"><?= error('name'); ?></span>
                </div>
                <div class="form-group <?= error('address') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="address">Address</label>
                    <input type="text" class="form-control" name="address" id="address" value="<?= old('address', $publisher->address); ?>">
                    <span class="help-block"><?= error('address'); ?></span>
                </div>
                <div class="form-group <?= error('phone') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="phone">Phone</label>
                    <input type="text" class="form-control" name="phone" id="phone" value="<?= old('phone', $publisher->phone); ?>">
                    <span class="help-block"><?= error('phone'); ?></span>
                </div>
                <div class="form-group <?= error('email') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email" value="<?= old('email', $publisher->email); ?>">
                    <span class="help-block"><?= error('email'); ?></span>
                </div>
                <div class="form-group <?= error('website') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="website">Website</label>
                    <input type="text" class="form-control" name="website" id="website" value="<?= old('website', $publisher->website); ?>">
                    <span class="help-block"><?= error('website'); ?></span>
                </div>
                <button onclick="history.back(-1)" class="btn btn-link">Cancel</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php include 'templates/admin/footer.php'; ?>
