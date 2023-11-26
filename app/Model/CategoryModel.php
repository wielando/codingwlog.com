<?php

namespace Model;

use Base\Controller;
use Base\Model;

class CategoryModel extends Model
{
    public string $table = CATEGORY_TABLE;

    public function __construct(Controller $controller)
    {
        parent::__construct();
    }

    public function getCategories(): array
    {
        $query = "SELECT c.id, c.name FROM {$this->table} AS c";

        $this->setQueryString($query);
        $this->executeStatement();

        return $this->getResult();
    }

    public function getCategorySeoInformation(int $categoryId): array
    {
        $query = "SELECT cs.* FROM ". SEO_CATEGORY_INFO ." AS cs
                  WHERE cs.category_id = :categoryId";

        $this->setQueryString($query);
        $this->setParams(['categoryId' => $categoryId]);
        $this->executeStatement();

        return $this->getResult();

    }
}