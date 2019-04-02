<div class="container h-100">
    <div class="row">
        <div class="col-12 mb-3">
            <header>
                <div class="pt-3 text-right">
                    <?php if(is_logged_in()) { ?>
                        <small>Hello, <a href="#"><?= ucfirst($user->username); ?></a> &vert; <a href="logout.php">Log out</a></small>
                    <?php } else { ?>
                        <small><a href="login.php">Log in</a> &vert; <a href="register.php">Register</a></small>
                    <?php }; ?>
                </div>
                <div class="d-xl-none text-left pl-3 py-3 float-left">
                    <a href="#" class="navbar-toggler" data-toggle="collapse" data-target="#nav"><i
                            class="fas fa-bars fa-2x"></i></a>
                </div>
                <div class="text-right float-right">
                    <ul class="list-unstyled pr-3 py-3 m-0">
                        <li><a href="#"><i class="fas fa-shopping-basket fa-2x"></i></a></li>
                    </ul>
                </div>
                <h1 class="m-0 text-center"><a href="index.php">Bookstore <span>EST &bullet; 1986</span></a></h1>
            </header>
        </div>
    </div>