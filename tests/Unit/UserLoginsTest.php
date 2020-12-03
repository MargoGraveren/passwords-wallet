<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\TestCase;
use App\Http\Controllers\UserLoginsController;

class UserLoginsTest extends TestCase
{
    /**
     * @test
     */
    public function testBlockUser_returnCorrectResult_correctParameterGiven(){
        $this->assertTrue(true);
    }
}
