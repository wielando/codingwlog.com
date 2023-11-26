<?php

namespace Controller;

use Base\Controller;
use Model\ArticleModel;

class ArticleController extends Controller
{
    private ArticleModel $articleModel;

    public function __construct()
    {
        if ($this->callModel("ArticleModel") == null) {
            return;
        }

        $this->articleModel = $this->callModel("ArticleModel");
    }

    public function getAllArticles(): array
    {
        return $this->processArticleData($this->articleModel->getAllArticles());
    }

    private function processArticleUrl(string $title): string
    {
        $articleUrlProcessed = preg_replace('/[^a-z0-9]+/', '-', strtolower($title));
        return rtrim($articleUrlProcessed, '-');
    }

    private function processArticleData(array $articles): array
    {
        $articles = array_map(function ($article) {
            $tags = [];

            $article["articleUrlProcessed"] = $this->processArticleUrl($article['title']);
            $categories = explode(',', $article['categories']);

            if (!empty($categories)) {
                foreach ($categories as $category) {
                    list($categoryName, $id, $tagClass) = explode(' (', $category);
                    $id = rtrim($id, ')');
                    $tagClass = rtrim($tagClass, ')');

                    $tag = [
                        'category' => $categoryName,
                        'tagClass' => $tagClass,
                        'id' => $id
                    ];

                    if (!isset($tags[$article['id']])) {
                        $tags[$article['id']] = [];
                    }


                    $article['processCategories'][] = $tag;
                }
            }

            return $article;
        }, $articles);

        return $articles;
    }

    public function getArticleByTitle(string $title): array
    {
        return $this->processArticleData($this->articleModel->getArticleByTitle($title));
    }

    public function getArticlesByCategory(string $category): array
    {
        return $this->processArticleData($this->articleModel->getArticlesByCategory($category));
    }

    public function getArticleById(int $id): array
    {
        return $this->processArticleData($this->articleModel->getArticleById($id));
    }

    public function getArticleSeoInformation(int $id): array
    {
        return $this->articleModel->getArticleSeoInformation($id);
    }

    public function updateArticle(int $id): bool
    {
        $articleInformation = [
            'title' => $_POST['title'] ?? null,
            'content_html' => $_POST['content_html'] ?? null,
            'time_to_read' => $_POST['time_to_read'] ?? null,
            'creation_date' => strtotime($_POST['creation_date']) ?? null,
        ];

        $articleTitle = $_POST['title'] ?? null;

        $seoProcessedUrl = ($articleTitle != null) ? $this->processArticleUrl($articleTitle) : null;

        $seoInformation = [
            'seo_title' => $_POST['seo_title'] ?? null,
            'seo_description' => $_POST['seo_description'] ?? null,
            'seo_og_site_name' => $_POST['seo_og_site_name'] ?? null,
            'seo_og_title' => $_POST['seo_og_title'] ?? null,
            'seo_og_description' => $_POST['seo_og_description'] ?? null,
            'seo_og_url' => $_POST['seo_og_url'] ?? null,
            'seo_processed_url' => $seoProcessedUrl ?? null,
        ];


        if (!$this->articleModel->updateArticleInformation($id, $articleInformation) || !$this->articleModel->updateArticleSeoInformation($id, $seoInformation)) {
            return false;
        }

        return true;
    }

    public function deleteArticle($id): bool
    {

        return $this->articleModel->deleteArticleInformations($id);

    }

    public function createArticle(): int
    {

        $articleInformation = [
            'title' => $_POST['title'] ?? null,
            'content_html' => $_POST['content_html'] ?? null,
            'time_to_read' => $_POST['time_to_read'] ?? null,
            'creation_date' => strtotime($_POST['creation_date']) ?? null,
            'language' => 'en'
        ];

        $createdArticleId = $this->articleModel->createArticleInformation($articleInformation, $_POST['selectedCategories']);


        if (!$createdArticleId) {
            return false;
        }

        $seoProcessedUrl = $this->processArticleUrl($this->articleModel->getArticleById($createdArticleId)[0]['title']);

        $seoInformation = [
            'seo_title' => $_POST['seo_title'] ?? null,
            'seo_description' => $_POST['seo_description'] ?? null,
            'seo_og_site_name' => $_POST['seo_og_site_name'] ?? null,
            'seo_og_title' => $_POST['seo_og_title'] ?? null,
            'seo_og_description' => $_POST['seo_og_description'] ?? null,
            'seo_og_url' => $seoProcessedUrl ?? null,
            'seo_processed_url' => $seoProcessedUrl ?? null,
            'article_id' => $createdArticleId ?? null,
            'seo_author' => 'Wieland Wüller',
        ];

        $this->articleModel->createArticleSeoInformation($seoInformation);

        return $createdArticleId;
    }

}