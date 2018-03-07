<?php

namespace app\models;

use yii\base\Model;

class SignUpForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'password_repeat'], 'required', 'message' => 'Заполните поле'],

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', 'unique', 'targetAttribute' => 'username', 'targetClass' => 'app\models\User', 'message' => 'Этот логин уже занят.'],

            [['password', 'password_repeat'], 'string', 'min' => 6, 'max' => 255],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'message' => 'Пароль не совпадает'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите Пароль'
        ];
    }

    /**
     * Signs user up
     * @return User|null
     * @throws \yii\base\Exception
     */
    public function signUp()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->setPassword($this->password);
            $user->generateAuthKey();

            if ($user->save())
                return $user;
        }

        return null;
    }
}
