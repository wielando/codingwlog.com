<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Wlog - <?php echo htmlspecialchars($categorySeoInformation['seo_title'], ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description"
          content="<?php echo htmlspecialchars($categorySeoInformation['seo_description'], ENT_QUOTES, 'UTF-8') ?>">
    <meta name="author" content="<?php echo $categorySeoInformation['seo_author'] ?>">

    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:site_name"
          content="<?php echo htmlspecialchars($categorySeoInformation['seo_title'], ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:type" content="website">
    <meta property="og:title"
          content="<?php echo htmlspecialchars($categorySeoInformation['seo_title'], ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:description"
          content="<?php echo htmlspecialchars($categorySeoInformation['seo_description'], ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:url"
          content="<?php echo DOMAIN . htmlspecialchars($categorySeoInformation['seo_og_url'], ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:image"
          content="https://codingwlog.com/images/wlog_logo.png"/>

    <?php require MAIN_PATH . '/web/template/head_styles.php'; ?>

</head>


<body>
<div class="container">
    <?php require MAIN_PATH . '/web/template/top_navigation.php'; ?>
    <?php require MAIN_PATH . '/web/template/side_navigation.php'; ?>

    <main class="col s12 m12 l9 xl9" role="main">
        <?php
        require MAIN_PATH . '/web/template/article_list.php';
        listenArticles($articles, true);
        ?>

    </main>
</div>
</body>
</html>