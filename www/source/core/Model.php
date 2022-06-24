<?php

namespace App\core;

class Model
{
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

    public function addError($errorList, $name, $message)
    {
        $errorList[$name] = $message;
        return $errorList;
    }

    public static function getData($select, $dbAndTable, $where = '', $searchedItem = '')
    {
        return Application::get('database')->getFromDB($select, $dbAndTable, $where, $searchedItem);
    }

    public function validation($config, $record): bool|string
    {
        $errors = [];

        foreach ($this->rules() as $fieldName => $rule) {
            if (str_contains($rule, 'required') && $record[$fieldName] === '') {
                $errors = $this->addError($errors, $fieldName, 'Input is empty!');

            } else if (str_contains($rule, 'invalid')) {
                preg_match('/(?<=invalid:)(.+)(?=\|)/U', $rule, $matches, PREG_OFFSET_CAPTURE);
                $string = $record[$fieldName];
                if (!preg_match($matches[0][0], $string)) {
                    $errors = $this->addError($errors, $fieldName, 'Invalid input!');
                } else if ($record[$fieldName] === 'default') {
                    $errors = $this->addError($errors, $fieldName, 'You must select your country!');
                }

            } else if (str_contains($rule, 'maxlength')) {
                preg_match('/(?<=maxlength:)(\d+)(?=\|)/U', $rule, $matches, PREG_OFFSET_CAPTURE);
                if (strlen($matches[0][0]) > $rule['max']) {
                    $errors = $this->addError($errors, $fieldName, "Input length should be maximum {$matches[0][0]} symbols!");
                }

            } else if (str_contains($rule, 'date')) {
                preg_match('/(?<=date:)(.+)(?=\|)/U', $rule, $found, PREG_OFFSET_CAPTURE);
                if (strtotime($record[$fieldName]) > strtotime($found[0][0])) {
                    $errors = $this->addError($errors, $fieldName, 'Incorrect date value!');
                }

            } else if (str_contains($rule, 'emailFormat') && filter_var($record[$fieldName], FILTER_VALIDATE_EMAIL) === false) {
                $errors = $this->addError($errors, $fieldName, 'Incorrect email format!');


            } else if (str_contains($rule, 'unique') && isset(Application::get('database')->searchInDB(
                        'memberId',
                        $config['database']['dbAndTable'],
                        'where email=',
                        $record[$fieldName]
                    )[0])) {
                $errors = $this->addError($errors, $fieldName, 'This email is already registered!');

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
}