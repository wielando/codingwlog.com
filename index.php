<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use Base\View;
use Controller\ArticleController;
use Controller\CategoryController;

header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/router.php';
require __DIR__ . '/app/Config/tables.php';
require_once __DIR__ . '/config.php';

function controllerAutoload($class_name)
{
    $class_file = __DIR__ . '\\app\\' . str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';

    if (file_exists($class_file)) {
        require $class_file;
    }
}

spl_autoload_register('controllerAutoload');

// ##################################################
// ##################################################
// ##################################################

get(['/', '/index', '/articles', '/home'], function () {
    $articleController = new ArticleController();
    $categoryController = new CategoryController();

    $articles = $articleController->getAllArticles();
    $categories = $categoryController->getCategories();

    $templateParams = [
        "articles" => $articles,
        "categories" => $categories
    ];

    $view = new View();
    echo $view->renderTemplate('Home', $templateParams);
});

get(['/article/$title'], function (string $title) {
    $articleController = new ArticleController();
    $categoryController = new CategoryController();

    $article = $articleController->getArticleByTitle($title);
    $articleSeoInformation = $articleController->getArticleSeoInformation($article[0]['id']);
    $categories = $categoryController->getCategories();

    $templateParams = [
        "articles" => $article,
        "categories" => $categories,
        "articleSeoInformation" => $articleSeoInformation[0]
    ];

    $view = new View();
    echo $view->renderTemplate('article', $templateParams);
});

get(['/articles/category/$category'], function (string $category){
    $articleController = new ArticleController();
    $categoryController = new CategoryController();

    $articles = $articleController->getArticlesByCategory($category);
    $categories = $categoryController->getCategories();
    $categorySeoInformation = $categoryController->getCategorySeoInformation($articles[0]['category_id']);


    $templateParams = [
        "articles" => $articles,
        "categories" => $categories,
        "categorySeoInformation" => $categorySeoInformation[0]
    ];

    $view = new View();
    echo $view->renderTemplate('CategoryArticles', $templateParams);
});

