<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Wlog - Coding & Learning Blog</title>

    <meta name="description"
          content="Wlog - Blog about Coding, Programming and other IT Stuff where you can learn anything about Webdevelopment, Gamedevelopment and other Topics!">
    <meta name="author" content="Wieland Wüller">

    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:site_name" content="Wlog Programming and IT stuff">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Wlog - Coding & Learning Blog">
    <meta property="og:description"
          content="Wlog - Blog about Coding, Programming and other IT Stuff where you can learn anything about Webdevelopment, Gamedevelopment and other topics!">
    <meta property="og:url" content="">
    <meta property="og:image" content="<?php echo DOMAIN; ?>/web/wlog_logo.png"/>

    <?php require MAIN_PATH . '/web/template/head_styles.php'; ?>
</head>


<body>
<div class="container">
    <?php require MAIN_PATH . '/web/template/top_navigation.php'; ?>
    <?php require MAIN_PATH . '/web/template/side_navigation.php'; ?>

    <main class="col s12 m12 l9 xl9" role="main">
        <?php
        require MAIN_PATH . '/web/template/article_list.php';
        listenArticles($articles);
        ?>

    </main>
</div>
</body>
</html>