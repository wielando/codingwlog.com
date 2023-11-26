<?php

namespace Model;

use Base\Controller;
use Base\Model;

class ArticleModel extends Model
{
    public string $table = ARTICLE_TABLE;

    public function __construct(Controller $controller)
    {
        parent::__construct();
    }

    public function getAllArticles(): array
    {
        $query = "SELECT a.*, GROUP_CONCAT(CONCAT(c.name ,' (', cc.id, ')', ' (', cc.classname, ')')) AS categories FROM {$this->table} AS a
                  LEFT JOIN " . ARTICLE_CATEGORY . " AS ac ON a.id = ac.article_id
                  LEFT JOIN " . CATEGORY_TABLE . " AS c ON ac.category_id = c.id
                  LEFT JOIN " . CHIP_TABLE . " AS cc ON c.chip_id = cc.id
                  GROUP BY a.id
                  ORDER BY a.id DESC";

        $this->setQueryString($query);
        $this->executeStatement();

        return $this->getResult();
    }

    public function getArticleById(int $id): array
    {
        $query = "SELECT a.*, GROUP_CONCAT(CONCAT(c.name ,' (', cc.id, ')', ' (', cc.classname, ')')) AS categories FROM {$this->table} AS a
                  LEFT JOIN " . ARTICLE_CATEGORY . " AS ac ON a.id = ac.article_id
                  LEFT JOIN " . CATEGORY_TABLE . " AS c ON ac.category_id = c.id
                  LEFT JOIN " . CHIP_TABLE . " AS cc ON c.chip_id = cc.id
                  WHERE a.id = :id
                  GROUP BY a.id
                  ORDER BY a.id DESC";

        $this->setQueryString($query);
        $this->setParams(['id' => $id]);
        $this->executeStatement();

        return $this->getResult();
    }

    public function getArticlesByCategory(string $categoryName): array
    {
        $query = "SELECT a.*, c.id as category_id, GROUP_CONCAT(CONCAT(c.name ,' (', cc.id, ')', ' (', cc.classname, ')')) AS categories FROM {$this->table} AS a
                  LEFT JOIN " . ARTICLE_CATEGORY . " AS ac ON a.id = ac.article_id
                  LEFT JOIN " . CATEGORY_TABLE . " AS c ON ac.category_id = c.id
                  LEFT JOIN " . CHIP_TABLE . " AS cc ON c.chip_id = cc.id
                  WHERE REPLACE(LOWER(c.name), ' ', '-') = :categoryName
                  GROUP BY a.id
                  ORDER BY a.id DESC";

        $this->setQueryString($query);
        $this->setParams(['categoryName' => $categoryName]);
        $this->executeStatement();

        return $this->getResult();
    }


    public function getArticleByTitle(string $title): array
    {
        $query = "SELECT a.*, GROUP_CONCAT(CONCAT(c.name ,' (', cc.id, ')', ' (', cc.classname, ')')) AS categories FROM {$this->table} AS a
                  LEFT JOIN " . ARTICLE_CATEGORY . " AS ac ON a.id = ac.article_id
                  LEFT JOIN " . CATEGORY_TABLE . " AS c ON ac.category_id = c.id
                  LEFT JOIN " . CHIP_TABLE . " AS cc ON c.chip_id = cc.id
                  LEFT JOIN " . SEO_ARTICLE_INFO . " AS sa ON sa.article_id = a.id
                  WHERE sa.seo_processed_url = :url";

        $this->setQueryString($query);
        $this->setParams(['url' => $title]);
        $this->executeStatement();

        return $this->getResult();
    }

    public function getArticleSeoInformation(int $id): array
    {
        $query = "SELECT si.* FROM " . SEO_ARTICLE_INFO . " AS si 
                  LEFT JOIN {$this->table} AS a ON a.id = si.article_id
                  WHERE a.id = :id";

        $this->setQueryString($query);
        $this->setParams(['id' => $id]);
        $this->executeStatement();

        return $this->getResult();
    }

    public function deleteArticleInformations(int $id): bool
    {
        $this->setQueryString("DELETE FROM {$this->table} WHERE id = :articleID");
        $this->setParams([':articleID' => $id]);

        if (!$this->executeStatement()) {
            return false;
        }

        // Lösche aus "article_category"
        $this->setQueryString("DELETE FROM " . ARTICLE_CATEGORY . " WHERE article_id = :articleID");
        $this->setParams([':articleID' => $id]);
        if (!$this->executeStatement()) {
            return false;
        }

        // Lösche aus "seo_article_information"
        $this->setQueryString("DELETE FROM " . SEO_ARTICLE_INFO . " WHERE article_id = :articleID");
        $this->setParams([':articleID' => $id]);
        if (!$this->executeStatement()) {
            return false;
        }

        return true;
    }

    public function createCategoriesOnArticle(array $categoryIds, int $articleId): bool
    {
        $query = "INSERT INTO " . ARTICLE_CATEGORY . "(article_id, category_id) VALUES (:artId, :catId)";

        foreach ($categoryIds as $categoryId) {
            $this->setQueryString($query);
            $this->setParams([':artId' => $articleId, ':catId' => $categoryId]);

            if (!$this->executeStatement()) {
                return false;
            }
        }

        return true;
    }

    public function updateArticleInformation(int $articleId, array $information): bool
    {
        $updateInfo = $this->buildUpdateQuery($this->table, $information, 'id', $articleId);
        $this->setQueryString($updateInfo['query']);
        $this->setParams($updateInfo['params']);

        return $this->executeStatement();
    }

    public function updateArticleSeoInformation(int $articleId, array $information): bool
    {
        $updateInfo = $this->buildUpdateQuery(SEO_ARTICLE_INFO, $information, 'article_id', $articleId);
        $this->setQueryString($updateInfo['query']);
        $this->setParams($updateInfo['params']);

        return $this->executeStatement();
    }

    public function createArticleInformation(array $articleInformation, array $categoryInformation): int
    {
        $createInfo = $this->buildInsertQuery($this->table, $articleInformation);
        $this->setQueryString($createInfo['query']);
        $this->setParams($createInfo['params']);

        $this->executeStatement();

        $articleId = $this->getLastInsertedId();

        $this->createCategoriesOnArticle($categoryInformation, $articleId);

        return $articleId;
    }

    public function createArticleSeoInformation(array $information): int
    {
        $createInfo = $this->buildInsertQuery(SEO_ARTICLE_INFO, $information);
        $this->setQueryString($createInfo['query']);
        $this->setParams($createInfo['params']);

        $this->executeStatement();

        return $this->getLastInsertedId();
    }

}