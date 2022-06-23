<?php

namespace App\app\models;

use App\core\Application;
use App\core\Model;

class MembersModel extends Model
{
    public function rules(): array
    {
        return [
            'firstName' => [
                'required',
                ['invalid', 'pattern' => "/^[.\D]{1,}$/",],
                ['length', 'max' => 30,],
            ],
            'lastName' => [
                'required',
                ['invalid', 'pattern' => "/^[.\D]{1,}$/",],
                ['length', 'max' => 30,],
            ],
            'date' => [
                'required',
                ['length', 'max' => 255,],
                ['date', 'maxDate' => 2005 - 01 - 01,],
            ],
            'country' => [
                'required',
                ['length', 'max' => 255,],
                ],
            'subject' => [
                'required',
                ['length', 'max' => 255,],
            ],
            'phone' => [
                'required',
                ['phone', 'pattern' => '/\+\d \(\d{3}\) \d{3}-\d{4}/i'],
                ],
            'email' => [
                'required',
                ['length', 'max' => 255,],
                'email format',
                'unique',
                ]
        ];
    }

    protected function newMemberRecord($config, array $member): bool|string
    {
        $data = $member;
        $validateResult = $this->validation($config, $data);

        if ($validateResult === true) {
            $this->add($data);
        } else {
            return $validateResult;
        }
        return true;
    }

    protected function updateMemberRecord($config, $data, $uploadFile, $basename): bool|array
    {
        $searchedId = Application::get('database')->searchInDB(
            'memberId',
            $config['database']['dbAndTable'],
            'where email=',
            $data['email']
        );
        if (isset($searchedId)) {
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