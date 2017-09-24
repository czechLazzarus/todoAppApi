<?php

$I = new ApiTester($scenario);
$I->wantTo('Testing Post request');
$data = [
'title' => "55"
];
$I->haveHttpHeader('Content-Type', 'application/json');
$I->sendPOST('todos', json_encode($data));


$I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
$I->seeResponseIsJson();
