<?php

namespace App\core\database;

use PDO;

class QueryBuilder
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getFromDB(string $selectString, $dbAndTable, $where = '', $searchItem =''): bool|array
    {
        if ($searchItem !== ''){
            $searchItem = "'$searchItem'";
        }
        $sql = sprintf("select %s from %s %s %s", $selectString, $dbAndTable, $where, $searchItem);
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function insertToDB($dbAndTable, $data): void
    {
        $sql = sprintf('insert into %s (%s) values(%s)',
            $dbAndTable,
            implode(', ', array_keys($data)),
            str_repeat('?,', count($data) - 1) . '?');
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array_values($data));
    }

    public function searchInDB(string $selectString, $dbAndTable, $where, $searchItem): bool|array
    {
        return $this->getFromDB($selectString, $dbAndTable, $where, $searchItem);
    }

    public function updateDB($dbAndTable, $data, $where, $searchItem): void
    {
        $searchItem = "'$searchItem'";
        $sql = sprintf('update %s set %s  where %s = %s',
            $dbAndTable,
            implode(' = ?, ', array_keys($data)) . ' = ?',
            $where,
            $searchItem
        );
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array_values($data));
    }

}