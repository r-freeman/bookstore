<?php include 'templates/admin/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="active"><a href="books.php">Books</a></li>
                <li><a href="authors.php">Authors</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="publishers.php">Publishers</a></li>
                <li><?php include 'templates/admin/users.php'; ?></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="sub-header">Add book</h2>
            <form action="add_book.php" method="post" enctype="multipart/form-data">
                <div class="form-group <?= error('title') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="title" value="<?= old('title'); ?>">
                    <span class="help-block"><?= error('title'); ?></span>
                </div>
                <div class="form-group <?= error('category_id') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="category_id">Category</label>
                    <select class="form-control" id="category_id" name="category_id">
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?= $category->id ?>"><?= $category->name ?></option>
                        <?php } ?>
                    </select>
                    <span class="help-block"><?= error('category_id'); ?></span>
                </div>
                <div class="form-group <?= error('synopsis') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="title">Synopsis</label>
                    <textarea class="form-control" name="synopsis" id="synopsis"><?= old('synopsis'); ?></textarea>
                    <span class="help-block"><?= error('synopsis'); ?></span>
                </div>
                <div class="form-group">
                    <label for="author_ids">Author(s)</label>
                    <select name="author_ids[]" id="author_ids" class="form-control" multiple>
                        <?php foreach ($authors as $author) { ?>
                            <option value="<?= $author->id ?>"><?= $author->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group <?= error('isbn') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="isbn">ISBN</label>
                    <input type="text" class="form-control" name="isbn" id="isbn" value="<?= old('isbn'); ?>">
                    <span class="help-block"><?= error('isbn'); ?></span>
                </div>
                <div class="form-group <?= error('year') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="year">Year</label>
                    <input type="text" class="form-control" name="year" id="year" value="<?= old('year'); ?>">
                    <span class="help-block"><?= error('year'); ?></span>
                </div>
                <div class="form-group <?= error('price') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="price">Price</label>
                    <input type="text" class="form-control" name="price" id="price" value="<?= old('price'); ?>">
                    <span class="help-block"><?= error('price'); ?></span>
                </div>
                <div class="form-group <?= error('length') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="length">Length</label>
                    <input type="text" class="form-control" name="length" id="length" value="<?= old('length'); ?>">
                    <span class="help-block"><?= error('length'); ?></span>
                </div>
                <div class="form-group <?= error('cover') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="cover">Cover image</label>
                    <input type="file" class="form-control" id="cover" name="cover">
                    <span class="help-block"><?= error('cover'); ?></span>
                </div>
                <div class="form-group <?= error('publisher_id') ? ' has-error' : ''; ?>">
                    <label class="control-label" for="publisher_id">Publisher</label>
                    <select class="form-control" id="publisher_id" name="publisher_id">
                        <?php foreach ($publishers as $publisher) { ?>
                            <option value="<?= $publisher->id ?>"><?= $publisher->name ?></option>
                        <?php } ?>
                    </select>
                    <span class="help-block"><?= error('publisher_id'); ?></span>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php include 'templates/admin/footer.php'; ?>
