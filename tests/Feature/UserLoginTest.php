<?php

namespace Tests\Feature;

use App\Http\Controllers\UserLoginsController;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    //data providers
    /**
     * @return array
     */
    public function generateExampleUserIds(){
        return $id[] = [[1],[2],[3]];
    }

    /**
     * @return array
     */
    public function generateExampleFakeUserIds(){
        return $id[] = [[100],[200],[300], [400]];
    }

    /**
     * @return array
     */
    public function generateExampleIpAdresses(){
        return $ipAddress[] = [['127.0.0.1:8000', 1],['127.0.0.2:8000', 1],['127.0.0.3:8000', 2]];
    }

    /**
     * @return array
     */
    public function generateExampleFakeIpAdresses(){
        return $ipAddress[] = [['129.0.0.1:8000', 1],['129.0.0.2:8000', 1],['129.0.0.3:8000', 2]];
    }

    //tests

    /**
     * @dataProvider generateExampleUserIds
     */
    public function testBlockingUser_returnCorrectResult_correctParameterGiven($id){
        (new \App\Http\Controllers\UserLoginsController)->blockUser($id);
        $this->assertDatabaseHas('blocked_accounts', ['user_id'=>$id]);
    }

    /**
     * @dataProvider generateExampleIpAdresses
     */
    public function testBlockingIp_returnCorrectResult_correctParameterGiven($ipAddress, $id){
        (new \App\Http\Controllers\UserLoginsController)->blockIP($ipAddress, $id);
        $this->assertDatabaseHas('blocked_accounts', ['IP_address'=>$ipAddress]);
    }

    /**
     * @dataProvider generateExampleIpAdresses
     */
    public function testCheckIfIpIsBlocked_returnCorrectResult_correctParameterGiven($ipAddress, $id){
        $result = (new \App\Http\Controllers\UserLoginsController)->checkIfIPIsBlocked($ipAddress, $id);
        $this->assertTrue($result == true);
    }

    /**
     * @dataProvider generateExampleFakeIpAdresses
     */
    public function testCheckIfIpIsBlocked_returnCorrectResult_incorrectParameterGiven($ipAddress, $id){
        $result = (new \App\Http\Controllers\UserLoginsController)->checkIfIPIsBlocked($ipAddress, $id);
        $this->assertTrue($result == false);
    }

    /**
     * @dataProvider generateExampleUserIds
     */
    public function testCheckIfUserIsBlocked_returnCorrectResult_correctParameterGiven($id){
        $result = (new \App\Http\Controllers\UserLoginsController)->checkIfUserIsBlocked($id);
        $this->assertTrue($result == true);
    }

    /**
     * @dataProvider generateExampleFakeUserIds
     */
    public function testCheckIfUserIsBlocked_returnCorrectResult_incorrectParameterGiven($id){
        $result = (new \App\Http\Controllers\UserLoginsController)->checkIfUserIsBlocked($id);
        $this->assertTrue($result == false);
    }

    /**
     * @dataProvider generateExampleUserIds
     */
    public function testCheckIfCountFailedLoginsAmountForUser_returnCorrectResult_correctParameterGiven($id){
        $result = (new \App\Http\Controllers\UserLoginsController)->countFailedLoginsAmountForUser($id);
        $this->assertIsInt($result);
    }
}
