<?php

namespace Base;

class Controller
{
    public function callModel(string $modelName): null|object
    {
        $modelClassName = "\\Model\\{$modelName}"; // Annahme: Models sind im Namespace "Models"

        if (class_exists($modelClassName) && is_subclass_of($modelClassName, '\Base\Model')) {
            return new $modelClassName($this);
        } else {
            return null;
        }
    }
}