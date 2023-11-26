<?php

namespace Controller;

use Base\Controller;
use Model\CategoryModel;

class CategoryController extends Controller
{
    private CategoryModel $categoryModel;

    public function __construct()
    {
        if ($this->callModel("CategoryModel") == null) {
            return;
        }

        $this->categoryModel = $this->callModel("CategoryModel");
    }

    public function getCategories(): array
    {
        return $this->categoryModel->getCategories();
    }

    public function getCategorySeoInformation(int $categoryId): array
    {
        return $this->categoryModel->getCategorySeoInformation($categoryId);
    }

}