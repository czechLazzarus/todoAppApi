<?php

$I = new ApiTester($scenario);
$I->wantTo('Testing Patch request');
$I->sendPATCH('todos/1');

$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
$I->seeResponseIsJson();
