<?php

namespace App\core;

class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_INVALID = 'invalid';
    public const RULE_DATE = 'date';
    public const RULE_PHONE = 'phone';
    public const RULE_EMAIL = 'email format';
    public const RULE_EMAIL_UNIQUE = 'unique';
    public const RULE_LENGTH = 'length';

    public function add($data): void
    {
        Application::get('database')->insertToDB(
            Application::get('config')['database']['dbAndTable'],
            $data
        );
    }

    public function update($data, $whereStatement, $match): void
    {
        Application::get('database')->updateDB(
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
            self::RULE_DATE => 'Incorrect date value!',
            self::RULE_PHONE => 'Incorrect phone number format! Should contain 11 digits!',
            self::RULE_EMAIL => 'Incorrect email format!',
            self::RULE_EMAIL_UNIQUE => 'This email is already registered!',
            self::RULE_LENGTH => "Input length should be maximum %s symbols!"
        ];
    }

    public function addError($errorList, $name, $rule, $spec = '')
    {
        if ($spec !== '') {
            $errorMessage = sprintf($this->errorMessages()[$rule], $spec);
            $errorList[$name] = $errorMessage;
            return $errorList;
        }
        $errorList[$name] = $this->errorMessages()[$rule];
        return $errorList;
    }

    public function validation($config, $record): bool|string
    {
        $errors = [];
        foreach ($record as $fieldName => $fieldValue) {
            if (isset($this->rules()[$fieldName])) {
                foreach ($this->rules()[$fieldName] as $rule) {
                    $ruleName = $rule;
                    if (!is_string($ruleName)) {
                        $ruleName = $rule[0];
                    }

                    if ($ruleName === self::RULE_REQUIRED && $fieldValue === '') {
                        $errors = $this->addError($errors, $fieldName, $ruleName);
                        continue 2;

                    } else if ($ruleName === self::RULE_INVALID && !preg_match($rule['pattern'], $fieldValue)) {
                        $errors = $this->addError($errors, $fieldName, $ruleName);
                        continue 2;

                    } else if ($ruleName === self::RULE_LENGTH && strlen($fieldValue) > $rule['max']) {
                        $errors = $this->addError($errors, $fieldName, $ruleName, $rule['max']);
                        continue 2;

                    } else if ($ruleName === self::RULE_DATE && strtotime($fieldValue) > strtotime($rule['maxDate'])) {
                        $errors = $this->addError($errors, $fieldName, $ruleName);
                        continue 2;

                    } else if ($ruleName === self::RULE_MAXLENGTH && strlen($fieldValue) > $rule['max']) {
                        $errors = $this->addError($errors, $fieldName, $ruleName, $rule['max']);
                        continue 2;

                    } else if ($ruleName === self::RULE_PHONE && !preg_match($rule['pattern'], $fieldValue)) {
                        $errors = $this->addError($errors, $fieldName, $ruleName);
                        continue 2;

                    } else if ($ruleName === self::RULE_EMAIL && filter_var($record['email'], FILTER_VALIDATE_EMAIL) === false) {
                        $errors = $this->addError($errors, $fieldName, $ruleName);
                        continue 2;

                    } else if ($ruleName === self::RULE_EMAIL_UNIQUE && isset(Application::get('database')->searchInDB(
                                'memberId',
                                $config['database']['dbAndTable'],
                                'where email=',
                                $fieldValue
                            )[0])) {
                        $errors = $this->addError($errors, $fieldName, $ruleName);
                        continue 2;
                    }
                }
            }
        }
        if (count($errors) === 0) {
            return true;
        } else {
            $result = json_encode($errors);
            unset($errors);
            return $result;
        }
    }

    public static function getData($select, $dbAndTable, $where = '', $searchedItem = '')
    {
        return Application::get('database')->getFromDB($select, $dbAndTable, $where, $searchedItem);
    }
}