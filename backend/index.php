<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use Base\View;
use Controller\ArticleController;
use Controller\AuthenticationController;
use Controller\CategoryController;

header('X-Content-Type-Options: nosniff');

require_once '../router.php';
require '../app/Config/tables.php';
require_once '../config.php';

function controllerAutoload($class_name)
{
    $class_file = MAIN_PATH . '\\app\\' . str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';

    if (file_exists($class_file)) {
        require $class_file;
    }
}

spl_autoload_register('controllerAutoload');

// ##################################################
// ##################################################
// ##################################################

require MAIN_PATH . '/backend/web/views/template/top_navigation.php';


if(!isset($_SESSION['auth']) || !isset($_SESSION['authKey'])) {
    get(['/admin/login'], 'backend\\web\\views\\login');

    post(['/admin/login'], function () {
        $authenticationController = new AuthenticationController();

        $isLoggedIn = $authenticationController->logInUser($_POST['username'], $_POST['password']);


    });
}

if(isset($_SESSION['auth']) && isset($_SESSION['authKey'])) {

    get(['/', '/index', '/articles', '/home'], function () {
        $articleController = new ArticleController();
        $articles = $articleController->getAllArticles();

        $templateParams = [
            "articles" => $articles,
        ];

        $view = new View();
        echo $view->renderTemplate('articles', $templateParams, true);
    });

    get(['/edit/article/$id', '/create/article'], function (int|null $id = null) {
        $articleController = new ArticleController();
        $categoryController = new CategoryController();


        $formUrl = DOMAIN . '/backend/save/article';
        $selectedCategoryIds = null;

        if ($id != null) {
            $article = $articleController->getArticleById($id)[0];
            $articleSeoInformation = $articleController->getArticleSeoInformation($id)[0];

            foreach ($article['processCategories'] as $category) {
                $selectedCategoryIds[] = $category['id'];
            }


            $formUrl = DOMAIN . '/backend/save/article/' . $id;

        }

        $availableCategories = $categoryController->getCategories();

        $templateParams = [
            'title' => $article['title'] ?? "",
            'creationDate' => $article['creation_date'] ?? "",
            'contentHtml' => $article['content_html'] ?? "",
            'timeToRead' => $article['time_to_read'] ?? "",
            'seoTitle' => $articleSeoInformation['seo_title'] ?? "",
            'seoDescription' => $articleSeoInformation['seo_description'] ?? "",
            'seoAuthor' => $articleSeoInformation['seo_author'] ?? "",
            'seoOGSiteName' => $articleSeoInformation['seo_og_site_name'] ?? "",
            'seoOGTitle' => $articleSeoInformation['seo_og_title'] ?? "",
            'seoOGDescription' => $articleSeoInformation['seo_og_description'] ?? "",
            'processedUrl' => $articleSeoInformation['seo_processed_url'] ?? "",
            'articleId' => $article['id'] ?? "",
            'availableCategories' => $availableCategories,
            'selectedCategoryIds' => $selectedCategoryIds ?? [],
            'formUrl' => $formUrl
        ];

        $view = new View();
        echo $view->renderTemplate('articleformular', $templateParams, true);
    });

    get(['/delete/article/$id'], function (int $id) {
        $articleController = new ArticleController();
        $articleController->deleteArticle($id);

        header("Location: " . DOMAIN . "/backend/articles");
        exit();
    });

    post(['/save/article/$id', '/save/article'], function (int|null $id = null) {
        $articleController = new ArticleController();
        $createdArticleId = null;
        $formUrl = '';

        if ($id != null) {
            $success = $articleController->updateArticle($id);
            $formUrl = DOMAIN . '/backend/save/article/' . $id;
        } else {
            $createdArticleId = $articleController->createArticle();
            $success = true;
        }

        if ($createdArticleId !== null && $id == null) {
            $id = $createdArticleId;
        }

        $article = $articleController->getArticleById($id)[0];
        $articleSeoInformation = $articleController->getArticleSeoInformation($id)[0];

        $templateParams = [
            'title' => $article['title'],
            'creationDate' => $article['creation_date'],
            'contentHtml' => $article['content_html'],
            'timeToRead' => $article['time_to_read'],
            'seoTitle' => $articleSeoInformation['seo_title'],
            'seoDescription' => $articleSeoInformation['seo_description'],
            'seoAuthor' => $articleSeoInformation['seo_author'],
            'seoOGSiteName' => $articleSeoInformation['seo_og_site_name'],
            'seoOGTitle' => $articleSeoInformation['seo_og_title'],
            'seoOGDescription' => $articleSeoInformation['seo_og_description'],
            'processedUrl' => $articleSeoInformation['seo_processed_url'],
            'articleId' => $article['id'],
            'success' => $success,
            'formUrl' => $formUrl
        ];

        $view = new View();
        echo $view->renderTemplate('articleformular', $templateParams, true);
    });
}

