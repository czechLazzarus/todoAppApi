<?php

$I = new ApiTester($scenario);
$I->wantTo('Testing get specific todo');
$I->sendGET('todos/1');

$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
$I->seeResponseIsJson();
