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
    <h3 class="center-align">Login</h3>

    <form class="col s12" action="<?php echo DOMAIN . '/backend/admin/login' ?>" method="post">
        <div class="row">
            <div class="input-field col s12">
                <input id="username" type="text" name="username" class="validate">
                <label for="username" class="active">Username</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <input id="password" type="password" name="password" class="validate">
                <label for="password" class="active">Password</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <button class="btn waves-effect waves-light" type="submit" name="action">Login
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </div>
    </form>
</div>
</body>
</html>