<?php

namespace Base;


class Model
{
    private array $result;
    private Database $database;

    public function __construct()
    {
        $this->database = Database::initDatabase($this);
    }

    protected function setQueryString(string $query): void
    {
        $this->database->prepareStatement($query);
    }

    protected function buildUpdateQuery(string $table, array $information, string $idColumn, int $id): array
    {
        $setString = "SET ";
        $keys = array_keys($information);
        $params = [$idColumn => $id];

        foreach ($information as $columnName => $data) {
            if ($columnName !== null || $data !== null) {
                $setString .= "{$columnName} = :{$columnName}, ";
                $params["{$columnName}"] = $data;
            }

            if ($columnName === end($keys) && $data === end($information)) {
                // Entferne das "," am Ende des Strings
                $setString = rtrim($setString, ', ');
            }
        }

        $query = "UPDATE {$table}
              {$setString}
              WHERE {$idColumn} = :{$idColumn}";

        return ['query' => $query, 'params' => $params];
    }

    protected function buildInsertQuery(string $table, array $data): array
    {
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";

        return ['query' => $query, 'params' => $data];
    }

    protected function commit(): bool
    {
        return $this->database->commitTransactions();
    }

    protected function setParams(array $params): void
    {
        if ($this->database->PDOStatement === null) {
            return;
        }

        $this->database->bindParams($params);
    }

    protected function executeStatement(): bool
    {
        return $this->database->queryDatabase();
    }

    protected function getResult(): array
    {
        return $this->database->fetchResult();
    }

    protected function getLastInsertedId(): int
    {
        return $this->database->lastInsertId();
    }

}