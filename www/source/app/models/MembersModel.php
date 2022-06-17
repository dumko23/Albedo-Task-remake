<?php

namespace App\app\models;

use App\core\Application;
use App\core\Model;

class MembersModel extends Model
{
    protected function validateInput($config, $record): string
    {
        $errors = [];
        if ($record['firstName'] === '') {
            $errors['firstName'] = 'Input is empty!';
        } else if (!preg_match("/^[.\D]{1,30}$/", $record['firstName'])) {
            $errors['firstName'] = 'Invalid input!';
        } else if (strlen($record['firstName']) > 30) {
            $errors['firstName'] = 'Input field should be maximum 30 symbols long';
        }

        if ($record['lastName'] === '') {
            $errors['lastName'] = 'Input is empty!';
        } else if (!preg_match("/^[.\D]{1,30}$/", $record['lastName'])) {
            $errors['lastName'] = 'Invalid input!';
        } else if (strlen($record['lastName']) > 30) {
            $errors['lastName'] = 'Input field should be maximum 30 symbols long';
        }

        if ($record['date'] === '') {
            $errors['date'] = 'Input is empty!';
        } else if (strlen($record['date']) > 255) {
            $errors['date'] = 'Your input is too long';
        } else if(strtotime($record['date']) > strtotime(2005-01-01)){
            $errors['date'] = 'Incorrect date value!';
        }

        if ($record['subject'] === '') {
            $errors['subject'] = 'Input is empty!';
        } else if (strlen($record['subject']) > 255) {
            $errors['subject'] = 'Your input is too long';
        }

        if (!isset($record['country'])) {
            $errors['country'] = 'Input is empty!';
        } else if (strlen($record['country']) > 255) {
            $errors['country'] = 'Your input is too long';
        }

        if ($record['phone'] === '') {
            $errors['phone'] = 'Input is empty!';
        } else {

            $number = preg_replace('/\D/', '', $record['phone']);
            if (strlen($number) === 11) {
                $number = str_split($number);
                $number = sprintf('+%s (%s) %s-%s',
                    $number[0],
                    implode('', array_splice($number, 0, 3)),
                    implode('', array_splice($number, 0, 3)),
                    implode('', array_splice($number, 0, 4))
                );
            }
            //"+1 (555) 555-5555"  validation
            if (preg_match('/\+\d \(\d{3}\) \d{3}-\d{4}/i', $number)) {
                $record['phone'] = $record;
            } else {
                $errors['phone'] = "Incorrect phone number format! Should contain 11 digits!";
            }
        }

        if ($record['email'] === '') {
            $errors['email'] = 'Input is empty!';
        } else if (strlen($record['email']) > 255) {
            $errors['email'] = 'Your input is too long';
        } else {
            if (filter_var($record['email'], FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = 'Incorrect email format!';
            } else {
                if (isset(Application::get('database')->searchMemberInDB(
                        'memberId',
                        $config['database']['dbAndTable'],
                        'where email=',
                        $record['email']
                    )[0])) {
                    $errors['email'] = 'This email is already registered!';
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

    protected function newMemberRecord($config, array $member): bool|string
    {
        $data = $member;
        $validateResult = $this->validateInput($config, $data);
        if ($validateResult === "1") {
            $this->addMember($data);
        } else {
            return $validateResult;
        }
        return true;
    }

    protected function updateMemberRecord($config, $data, $uploadFile, $basename): bool|array
    {
        $searchedId = Application::get('database')->searchMemberInDB(
            'memberId',
            $config['database']['dbAndTable'],
            'where email=',
            $data['email']
        );
        if ($searchedId) {
            if (!$data['company']) {
                $data['company'] = '';
            }
            if (!$data['position']) {
                $data['position'] = '';
            }
            if (!$data['about']) {
                $data['about'] = '';
            }
            if (!$basename) {
                $uploadFile = '';
            }
            $data['photo'] = $uploadFile;
            $this->updateMember($data,
                'email',
                $data['email']);
            return true;
        }
        return $searchedId;
    }


    public function registerNewMember($config, $data): bool|string
    {
        $result = $this->newMemberRecord($config, $data);
        if ($result === true) {
            return true;
        } else {
            return $result;
        }
    }

    public function updateAdditionalInfo($config, $data, $uploadFile, $basename): bool|array
    {
        $result = $this->updateMemberRecord($config, $data, $uploadFile, $basename);
        if (gettype($result) === 'object') {
            return true;
        } else {
            return $result;
        }
    }
}