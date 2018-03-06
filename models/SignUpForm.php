<?php

namespace app\models;

use yii\base\Model;

class SignUpForm extends Model
{
    public $username;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required', 'message' => 'Заполните поле'],

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', 'unique', 'targetAttribute' => 'username', 'targetClass' => 'app\models\User', 'message' => 'Этот логин уже занят.'],

            ['password', 'string', 'min' => 6]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль'
        ];
    }

    /**
     * Signs user up
     * @return User|null
     */
    public function signUp()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->password = $this->password;
            $user->generateAuthKey();

            if ($user->save())
                return $user;
        }

        return null;
    }
}
