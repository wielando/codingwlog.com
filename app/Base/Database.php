<?php

namespace Base;

use PDO;
use PDOException;
use PDOStatement;

class Database extends PDO
{
    public PDOStatement $PDOStatement;

    private function __construct()
    {
        parent::__construct("mysql:host=" . HOST . ";dbname=" . SQLDB,
            SQLUSER, SQLPASS);
    }

    public static function initDatabase(Model $model): Database
    {
        return new Database();
    }

    public function prepareStatement(string $query): void
    {
        $this->PDOStatement = $this->prepare($query);
    }

    public function bindParams(array $params): void
    {
        foreach ($params as $param => $value) {
            if (is_int($value)) {
                $paramType = PDO::PARAM_INT;
            } elseif (is_bool($value)) {
                $paramType = PDO::PARAM_BOOL;
            } elseif (is_null($value)) {
                $paramType = PDO::PARAM_NULL;
            } else {
                $paramType = PDO::PARAM_STR;
            }

            $this->PDOStatement->bindValue($param, $value, $paramType);
        }
    }

    public function fetchResult(int $mode = PDO::FETCH_ASSOC): array
    {
        return $this->PDOStatement->fetchAll($mode);
    }

    public function commitTransactions(): bool
    {
        return $this->commit();
    }

    public function getPDOStatement(): PDOStatement
    {
        return $this->PDOStatement;
    }

    public function queryDatabase(): bool
    {
        try {

            return $this->PDOStatement->execute();

        } catch (PDOException $e) {

            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
}