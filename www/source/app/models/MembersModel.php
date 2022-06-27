<?php

namespace App\app\models;

use App\core\Application;
use App\core\Model;

class MembersModel extends Model
{
    public function rules(): array
    {
        return [
            'firstName' => 'required|invalid:/^[.\D]{1,}$/|length:30|',
            'lastName' => 'required|invalid:/^[.\D]{1,}$/|length:30|',
            'date' => 'required|length:255|date:2005-01-01|',
            'country' => 'country|length:255|',
            'subject' => 'required|length:255|',
            'phone' => 'required|invalid:/\+\d \(\d{3}\) \d{3}-\d{4}/i|',
            'email' => 'required|length:255|emailFormat|unique|',
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

    public static function showMembersData(){
        return Model::getData('members');
    }
}