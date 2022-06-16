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

    public function getMembersFromDB(string $selectString, $dbAndTable, $where = '', $searchItem =''): bool|array
    {
        if ($searchItem !== ''){
            $searchItem = "'$searchItem'";
        }
        $sql = sprintf("select %s from %s %s %s", $selectString, $dbAndTable, $where, $searchItem);
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function insertMemberToDB($dbAndTable, $data): void
    {
        $sql = sprintf('insert into %s (%s) values(%s)',
            $dbAndTable,
            implode(', ', array_keys($data)),
            str_repeat('?,', count($data) - 1) . '?');
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array_values($data));
    }

    public function searchMemberInDB(string $selectString, $dbAndTable, $where, $searchItem): bool|array
    {
        return $this->getMembersFromDB($selectString, $dbAndTable, $where, $searchItem);
    }

    public function update($dbAndTable, $data, $where, $searchItem): void
    {
        echo implode(' = ?, ', array_keys($data)) . ' = ?, photo = ?';
        $sql = sprintf('update %s set %s  where %s = %s',
            $dbAndTable,
            implode(' = ?, ', array_keys($data)) . ' = ?, photo = ?',
            $where,
            $searchItem
        );
        $statement = $this->pdo->prepare($sql);
        $statement->execute([array_values($data)]);
    }

}