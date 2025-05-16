<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_account_starts_with_zero_balance()
    {
        $account = Account::create();
        $this->assertEquals(0, $account->balance);
    }

    public function test_valid_deposit()
    {
        $account = Account::create();
        $account->deposit(100);
        $this->assertEquals(100, $account->balance);
    }

    public function test_invalid_deposit_negative()
    {
        $account = Account::create();
        $account->deposit(-50);
        $this->assertEquals(0, $account->balance); // no se deposita nada
    }

    public function test_maximum_deposit()
    {
        $account = Account::create();
        $account->deposit(5999); // suponiendo que es el máximo válido
        $this->assertEquals(5999, $account->balance);
    }

    public function test_valid_withdraw()
    {
        $account = Account::create();
        $account->deposit(200);
        $account->withdraw(50);
        $this->assertEquals(150, $account->balance);
    }

    public function test_invalid_withdraw_more_than_balance()
    {
        $account = Account::create();
        $account->deposit(100);
        $account->withdraw(150); // no se debe permitir
        $this->assertEquals(100, $account->balance);
    }


}
