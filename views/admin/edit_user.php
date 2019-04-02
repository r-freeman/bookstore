<?php include 'templates/admin/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li><a href="books.php">Books</a></li>
                <li><a href="authors.php">Authors</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="publishers.php">Publishers</a></li>
                <li class="active"><?php include 'templates/admin/users.php'; ?></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="sub-header">Edit user</h2>
            <form action="edit_user.php" method="post">
                <input type="hidden" name="id" value="<?= $_user->id; ?>" />
                <div class="form-group <?= error('username') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" value="<?= old('username', $_user->username); ?>">
                    <span class="help-block"><?= error('username'); ?></span>
                </div>
                <div class="form-group">
                    <label class="control-label" for="role_id">Role</label>
                    <select class="form-control" id="role_id" name="role_id">
                        <?php foreach ($roles as $role) { ?>
                            <option value="<?= $role->id ?>" <?= old('role_id', $_user->role_id) === $role->id ? 'selected' : '' ?> ><?= $role->title ?></option>
                        <?php } ?>
                    </select>
                    <span class="help-block"><?= error('role_id'); ?></span>
                </div>
                <button onclick="history.back(-1)" class="btn btn-link">Cancel</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php include 'templates/admin/footer.php'; ?>
