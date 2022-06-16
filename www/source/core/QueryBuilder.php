<?php

namespace App\core;

use PDO;

class QueryBuilder
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getMembersFromDB(): bool|array
    {
        $statement = $this->pdo->prepare(
            'select photo, firstName, lastName, email, subject from MemberList.Members;'
        );
        $statement->execute();
        return $statement->fetchAll();
    }

    public function insertMemberToDB($dbAndTable, $data)
    {
        $sql = sprintf('insert into %s (%s) values(%s)', $dbAndTable, implode(', ', array_keys($data)), str_repeat('?,', count($data)));
        $statement = $this->pdo->prepare($sql);
        $statement->execute([array_values($data)]);
    }


}