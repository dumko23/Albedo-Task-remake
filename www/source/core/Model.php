<?php

namespace App\core;

class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_INVALID = 'invalid';
    public const RULE_30_LONG = '30_long';
    public const RULE_MAXLENGTH = 'max';
    public const RULE_DATE = 'date';
    public const RULE_PHONE = 'phone';
    public const RULE_EMAIL = 'email format';
    public const RULE_EMAIL_UNIQUE = 'unique';
    public static array $errors = [];

    public function add($data): void
    {
        Application::get('database')->insertToDB(
            Application::get('config')['database']['dbAndTable'],
            $data
        );
    }

    public function update($data, $whereStatement, $match): void
    {
        Application::get('database')->update(
            Application::get('config')['database']['dbAndTable'],
            $data,
            $whereStatement,
            $match
        );
    }

    public function search(string $selectString, $dbAndTable, $where, $searchItem)
    {
        return Application::get('database')
            ->searchInDB($selectString, $dbAndTable, $where, $searchItem);
    }

    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'Input is empty!',
            self::RULE_INVALID => 'Invalid input!',
            self::RULE_30_LONG => 'Input field should be maximum 30 symbols long',
            self::RULE_MAXLENGTH => 'Your input is too long',
            self::RULE_DATE => 'Incorrect date value!',
            self::RULE_PHONE => 'Incorrect phone number format! Should contain 11 digits!',
            self::RULE_EMAIL => 'Incorrect email format!',
            self::RULE_EMAIL_UNIQUE => 'This email is already registered!'
        ];
    }

    public function addError($errorList, $name, $rule): void
    {
        static::$errors[$name] = $this->errorMessages()[$rule];
    }
}