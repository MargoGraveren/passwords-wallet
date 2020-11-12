<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class UserAuthTest extends TestCase
{
    /**
     * @test
     */
    public function testCreateUser_returnCorrectResult_correctParametersGiven()
    {
        $user = factory(User::class, 3)->create();
        $this->assertTrue($user != null);
    }

    /**
     * @test
     */
    public function testCreateUser_throwQueryException_whenNameIsMissing(){
            $this->expectException(QueryException::class);
            $user = factory(User::class)->create([
                'name'=>null
            ]);
            $this->assertTrue($user == null);
    }

    /**
     * @test
     */
    public function testCreateUser_throwQueryException_whenEmailIsMissing(){
        $this->expectException(QueryException::class);
        $user = factory(User::class)->create([
            'email'=>null
        ]);
        $this->assertTrue($user == null);
    }

    /**
     * @test
     */
    public function testCreateUser_throwQueryException_whenPasswordIsMissing(){
        $this->expectException(QueryException::class);
        $user = factory(User::class)->create([
            'password'=>null
        ]);
        $this->assertTrue($user == null);
    }

    /**
     * @test
     */
    public function testCreateUser_throwQueryException_whenKeyIsMissing(){
        $this->expectException(QueryException::class);
        $user = factory(User::class)->create([
            'key'=>null
        ]);
        $this->assertTrue($user == null);
    }

    /**
     * @test
     */
    public function testCreateUser_throwQueryException_whenHashTypeIsMissing(){
        $this->expectException(QueryException::class);
        $user = factory(User::class)->create([
            'isPasswordKeptHash'=>null
        ]);
        $this->assertTrue($user == null);
    }
}
