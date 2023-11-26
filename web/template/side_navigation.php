<div class="row">
    <div class="hide-on-med-and-down">
        <div class="col s3 p0">
            <div class="category-navigation">
                <h4>Categories</h4>
                <ul class="category-list">
                    <?php foreach ($categories as $category) : ?>
                        <?php
                        $processedCategoryName = strtolower(str_replace(' ', '-', $category['name']));
                        ?>
                        <li class="category-item"><a
                                    href="<?php echo DOMAIN; ?>/articles/category/<?php echo $processedCategoryName ?>"
                                    title="Category: <?php echo $category['name'] ?>"><?php echo $category['name'] ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>