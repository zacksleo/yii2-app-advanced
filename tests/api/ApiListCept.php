<?php
$I = new ApiTester($scenario);
$I->wantTo('API列表');
$I->haveHttpHeader('Content-Type', 'application/json');
$I->sendGET('default/index');
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
$I->seeResponseIsJson();

