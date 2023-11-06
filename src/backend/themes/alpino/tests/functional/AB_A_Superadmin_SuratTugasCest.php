<?php

namespace backend\themes\alpino\tests\functional;

use backend\themes\alpino\tests\FunctionalTester;
use common\fixtures\UserFixture;

/**
 * Class SuratTugasCest
 */
class AB_SuratTugasCest {

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
        ];
    }

    protected function login(FunctionalTester $I) {
        $I->submitForm('#login-form', [
            'LoginForm[nip]' => 'superadmin',
            'LoginForm[password]' => '123456'
        ]);
    }
    
    protected function newData(){
        return [
            'SuratTugasExt[tanggal_terbit]' => date('Y-m-d'),
            'SuratTugasExt[nomor]' => '00001',
            'SuratTugasExt[maksud]' => 'maksud_00001'
        ];
    }

    public function checkAll(FunctionalTester $I) {
        $I->amOnRoute('/surat-tugas');
        $this->login($I);
        $I->see('Surat Tugas', 'h2');
        $I->click('Tambah Surat Tugas');
        $I->see('Form Tambah Surat Tugas');
        $I->submitForm('#surat-tugas-form', []);
        $I->seeValidationError('Tanggal Terbit tidak boleh kosong.');
        $I->seeValidationError('Jumlah Hari tidak boleh kosong.');
        $I->seeValidationError('Nomor tidak boleh kosong.');
        $I->seeValidationError('Maksud tidak boleh kosong.');
        $I->submitForm('#surat-tugas-form', $this->newData());
    }

}
