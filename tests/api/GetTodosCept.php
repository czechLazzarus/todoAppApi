<?php

$I = new ApiTester($scenario);
$I->wantTo('Testing get all todos');

$I->haveHttpHeader('Content-Type', 'application/json');
$I->sendGET('todos');


$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
$I->seeResponseIsJson();
