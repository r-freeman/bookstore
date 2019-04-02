<?php $categories = Category::all('name', 'ASC', true); ?>
<div class="row">
    <div class="navbar-collapse collapse col-12 col-sm-12 col-md-12 col-lg-12 col-xl-3 d-xl-block" id="nav">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-12">
                <h3 class="mb-5">Categories</h3>
                <nav class="mb-7">
                    <ul class="side-nav list-unstyled">
                        <?php foreach ($categories as $category) { ?>
                            <li class="nav-item mb-3">
                                <a class="nav-link p-0"
                                   href="category.php?id=<?= $category->id; ?>"><?= $category->name; ?></a>
                            </li>
                        <? } ?>
                    </ul>
                </nav>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-9 col-xl-12">
                <h3 class="mb-5">Best sellers</h3>
                <article class="mb-5">
                    <a href="#"><img class="d-block img-fluid float-left"
                                     src="uploads/51F48HFHq6L.png"
                                     alt=""></a>
                    <h6 class="mb-3"><a href="#">Python Crash Course: A Hands-On, Project-Based Introduction to
                            Programming</a></h6>
                    <p class="m-0"><sup>£<span>22</span>.78</sup></p>
                </article>
                <article class="mb-5">
                    <a href="#"><img class="d-block img-fluid float-left"
                                     src="uploads/51aUTzDIxxL.png"
                                     alt=""></a>
                    <h6 class="mb-3"><a href="#">Learning PHP, MySQL & JavaScript</a></h6>
                    <p class="m-0"><sup>£<span>25</span>.72</sup></p>
                </article>
                <article class="mb-5">
                    <a href="#"><img class="d-block img-fluid float-left"
                                     src="uploads/41WznOEKmAL.png"
                                     alt=""></a>
                    <h6 class="mb-3"><a href="#">HTML and CSS: Design and Build Websites</a></h6>
                    <p class="m-0"><sup>£<span>12</span>.60</sup></p>
                </article>
            </div>
        </div>
    </div>