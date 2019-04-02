<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bookstore | Log in to your account</title>
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
<div class="col-12 col-sm-12 col-md-12 col-xl-5">
    <main>
        <h3 class="mb-5">Log in to your account</h3>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control<?= error('username') ? ' form-control-error is-invalid' : ''; ?>"
                       name="username" id="username"
                       placeholder="Enter username"
                       value="<?= old('username'); ?>">
                <div class="invalid-feedback d-block"><?= error('username'); ?></div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password"
                       class="form-control<?= error('password') ? ' form-control-error is-invalid' : ''; ?>"
                       name="password" id="password">
                <div class="invalid-feedback d-block"><?= error('password'); ?></div>
            </div>
            <button type="submit" class="btn btn-primary px-5 py-2">Submit</button>
        </form>
    </main>
</div>
</div>
<?php include 'templates/user/footer.php'; ?>