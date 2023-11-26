<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Wlog - <?php echo htmlspecialchars($articleSeoInformation['seo_title'], ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description"
          content="<?php echo htmlspecialchars($articleSeoInformation['seo_description'], ENT_QUOTES, 'UTF-8') ?>">
    <meta name="author" content="<?php echo $articleSeoInformation['seo_author'] ?>">

    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:site_name"
          content="<?php echo htmlspecialchars($articleSeoInformation['seo_og_site_name'], ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:type" content="website">
    <meta property="og:title"
          content="<?php echo htmlspecialchars($articleSeoInformation['seo_og_title'], ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:description"
          content="<?php echo htmlspecialchars($articleSeoInformation['seo_og_description'], ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:url"
          content="<?php echo DOMAIN . '/article'. htmlspecialchars($articleSeoInformation['seo_og_url'], ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:image"
          content="<?php echo ($articleSeoInformation['seo_og_image'] != null) ? htmlspecialchars($articleSeoInformation['seo_og_image'], ENT_QUOTES, 'UTF-8') : "https://codingwlog.com/images/wlog_logo.png"; ?>"/>

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