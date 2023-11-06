<?php

namespace backend\themes\alpino\tests\functional;

use backend\themes\alpino\tests\FunctionalTester;
use common\fixtures\SuratTugasFixture;
use common\fixtures\UserFixture;

/**
 * Class SuratTugasCest
 */
class AC_SppdCest
{
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
                'dataFile' => codecept_data_dir() . 'user_data.php',
            ],
            //'surat-tugas' => [
            //    'class' => SuratTugasFixture::className(),
                //'dataFile' => codecept_data_dir() . 'login_data.php',
            //],
        ];
    }

    protected function login(FunctionalTester $I) {
        $I->submitForm('#login-form', [
            'LoginForm[nip]' => 'superadmin',
            'LoginForm[password]' => '123456'
        ]);
    }
    
    public function checkCreate(FunctionalTester $I){
        $I->amOnRoute('/sppd/create');
        $this->login($I);
        $I->see('SPPD digenerate dari daftar pelaksana surat tugas');
    }
    
    public function checkIndex(FunctionalTester $I) {
        $I->amOnRoute('/sppd');
        $this->login($I);
        $I->see('SPPD', 'h2');
    }

}
