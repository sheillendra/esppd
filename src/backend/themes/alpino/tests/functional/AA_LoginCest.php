<?php

namespace backend\themes\alpino\tests\functional;

use backend\themes\alpino\tests\FunctionalTester;
use common\fixtures\UserFixture;

/**
 * Class LoginCest
 */
class AA_LoginCest {

    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures() {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'login_user_data.php',
            ],
        ];
    }

    public function _before(FunctionalTester $I) {
        $I->amOnRoute('/login');
    }

    protected function formParams($login, $password) {
        return [
            'LoginForm[nip]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function checkEmpty(FunctionalTester $I) {
        $I->submitForm('#login-form', $this->formParams('', ''));
        $I->seeValidationError('Nip tidak boleh kosong.');
        $I->seeValidationError('Password tidak boleh kosong.');
    }

    public function checkWrongPassword(FunctionalTester $I) {
        $I->submitForm('#login-form', $this->formParams('superadmin', 'wrong'));
        $I->dontSeeValidationError('Nip tidak boleh kosong.');
        $I->dontSeeValidationError('Password tidak boleh kosong.');
        $I->seeValidationError('Nip atau password tidak benar.');
    }

    public function checkInactiveAccount(FunctionalTester $I) {
        $I->submitForm('#login-form', $this->formParams('banned_user', 'password_0'));
        $I->seeValidationError('Nip atau password tidak benar.');
    }

    public function checkValidLogin(FunctionalTester $I) {
        $I->submitForm('#login-form', $this->formParams('superadmin', '123456'));
        $I->see('superadmin', 'h6');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }

}
