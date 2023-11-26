<?php
function listenArticles(array $articles, bool $includeBacklink = false): void
{
    foreach ($articles as $key => $article) : ?>

        <article class="blog-post">
            <?php echo ($includeBacklink) ? '<p class="back-link"><a href="/articles" title="Get back back to Article list">« Get back to the Article overview</a></p>' : '' ?>
            <header class="blog-post-header">
                <h1 class="blog-post-title"><a href="<?php echo DOMAIN . '/article/' . $article['articleUrlProcessed']; ?>"
                                           title="Read Wlog Blogpost about <?php echo $article['title']; ?>"><?php echo htmlspecialchars($article['title']); ?></a></h1>


                <section class="blog-post-categories">
                    <?php

                    foreach ($articles[$key]['processCategories'] as $category) {

                        $catNameProcessed = strtolower(str_replace(' ', '-', $category['category']));
                        $tagClass = $category['tagClass'];

                        echo '<a href="' . DOMAIN . '/articles/category/' . $catNameProcessed . '" title="Category: ' . $category['category'] . '"><div class="chip ' . $tagClass . '"><p>' . $category['category'] . '</p></div></a>';
                    }
                    ?>

                    <div class="blog-post-meta">
                        Published <?php echo date('d. F Y', $article['creation_date']); ?> - estimated reading
                        time: <?php echo $article['time_to_read']; ?> minutes
                    </div>
                </section>
            </header>

            <section class="blog-post-content-meta">
                <div class="blog-post-content">
                    <?php echo $article['content_html']; ?>
                </div>
            </section>
        </article>
    <?php endforeach;
}

?>

