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

    <meta property="og:image" content="<?php echo DOMAIN; ?>/web/wlog_logo.png"/>

    <?php require MAIN_PATH . '/web/template/head_styles.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo DOMAIN; ?>/backend/web/stylesheet/main.min.css"/>
</head>


<body>
<div class="container">
    <table class="highlight">
        <thead>
        <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Creation Date</th>
            <th>Published</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($articles as $key => $article) : ?>
            <tr>
                <td><?php echo $article['title']; ?></td>
                <td>
                    <?php
                    foreach ($articles[$key]['processCategories'] as $category) {
                        echo $category["category"] . '<br />';
                    }
                    ?>
                </td>
                <td><?php echo date('d. F Y', $article['creation_date']); ?></td>
                <td>WIP</td>
                <td>
                    <div class="input-field">
                        <button class="btn-small" onclick="toggleDropdown('article-id:<?php echo $article['id']; ?>')">
                            Action
                        </button>
                        <ul id="article-id:<?php echo $article['id']; ?>"
                            class="dropdown-content custom-article-list-dropdown">
                            <li>
                                <a href="<?php echo DOMAIN; ?>/backend/edit/article/<?php echo $article['id']; ?>">Edit</a>
                            </li>
                            <li>
                                <a href="<?php echo DOMAIN; ?>/backend/delete/article/<?php echo $article['id']; ?>">Delete</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>

    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);

        if (dropdown && !dropdown.classList.contains('menu-open')) {
            dropdown.classList.add("menu-open");
        } else if (dropdown && dropdown.classList.contains('menu-open')) {
            dropdown.classList.remove("menu-open");
        }


    }
</script>
</body>
</html>