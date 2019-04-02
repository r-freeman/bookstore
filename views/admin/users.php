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
            <h2 class="sub-header">Users</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <td>
                                <p><?= $user->username; ?></p>
                            </td>
                            <td>
                                <p><?= $user->role_title; ?></p>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="edit_user.php?id=<?= $user->id; ?>" class="btn btn-default">Edit</a>
                                    <a href="delete_user.php?id=<?= $user->id; ?>" class="btn btn-danger" onclick="return confirm('Delete this publisher?')">Delete</a>
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
