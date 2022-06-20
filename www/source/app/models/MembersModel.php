<?php

namespace App\app\models;

use App\core\Model;

class MembersModel extends Model
{
    public function rules(): array
    {
        return [
            'firstName' => [self::RULE_REQUIRED, self::RULE_INVALID, self::RULE_30_LONG],
            'lastName' => [self::RULE_REQUIRED, self::RULE_INVALID, self::RULE_30_LONG],
            'date' => [self::RULE_REQUIRED, self::RULE_MAXLENGTH, self::RULE_DATE],
            'country' => [self::RULE_REQUIRED, self::RULE_MAXLENGTH],
            'subject' => [self::RULE_REQUIRED, self::RULE_MAXLENGTH],
            'phone' => [self::RULE_REQUIRED, self::RULE_PHONE],
            'email' => [self::RULE_REQUIRED, self::RULE_MAXLENGTH, self::RULE_EMAIL, self::RULE_EMAIL_UNIQUE]
        ];
    }

    public function validation($config, $record): bool|string
    {
        foreach ($record as $fieldName => $fieldValue) {
            if (isset($this->rules()[$fieldName])) {
                foreach ($this->rules()[$fieldName] as $rule) {
                    if ($rule === self::RULE_REQUIRED && $fieldValue === '') {
                        $this->addError(static::$errors, $fieldName, $rule);
                        continue 2;
                    } else if ($rule === self::RULE_INVALID && !preg_match("/^[.\D]{1,30}$/", $fieldValue)) {
                        $this->addError(static::$errors, $fieldName, $rule);
                        continue 2;
                    } else if ($rule === self::RULE_DATE && strtotime($fieldValue) > strtotime(2005 - 01 - 01)) {
                        $this->addError(static::$errors, $fieldName, $rule);
                        continue 2;
                    } else if ($rule === self::RULE_MAXLENGTH && strlen($fieldValue) > 255) {
                        $this->addError(static::$errors, $fieldName, $rule);
                        continue 2;
                    } else if ($rule === self::RULE_PHONE && !preg_match('/\+\d \(\d{3}\) \d{3}-\d{4}/i', $fieldValue)) {
                        $this->addError(static::$errors, $fieldName, $rule);
                        continue 2;
                    } else if ($rule === self::RULE_EMAIL && filter_var($record['email'], FILTER_VALIDATE_EMAIL) === false) {
                        $this->addError(static::$errors, $fieldName, $rule);
                        continue 2;
                    } else if ($rule === self::RULE_EMAIL_UNIQUE && isset($this->search(
                                'memberId',
                                $config['database']['dbAndTable'],
                                'where email=',
                                $fieldValue
                            )[0])) {
                        $this->addError(static::$errors, $fieldName, $rule);
                        continue 2;
                    }
                }
            }
        }
        if (count(static::$errors) === 0) {
            return true;
        } else {
            $result = json_encode(static::$errors);
            static::$errors = [];
            return $result;
        }
    }

    protected function newMemberRecord($config, array $member): bool|string
    {
        $data = $member;
        $validateResult = $this->validation($config, $data);
        if ($validateResult === "1") {
            $this->add($data);
        } else {
            return $validateResult;
        }
        return true;
    }

    protected function updateMemberRecord($config, $data, $uploadFile, $basename): bool|array
    {
        $searchedId = $this->search(
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
            $this->update($data,
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