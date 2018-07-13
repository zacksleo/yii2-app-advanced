<?php
namespace tests\api;

class CestBase
{
    public function _fixtures()
    {
        return [];
    }

    public $appKey = 'username';
    public $appSecret = 'password';

    protected function auth(\ApiTester $I)
    {
        $I->amHttpAuthenticated($this->appKey, $this->appSecret);
    }
}