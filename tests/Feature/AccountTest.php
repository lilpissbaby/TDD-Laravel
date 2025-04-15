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
        $account->deposit(-100);
        $this->assertEquals(0, $account->balance);
    }

    public function test_invalid_deposit_too_many_decimals()
    {
        $account = Account::create();
        $account->deposit(100.457);
        $this->assertEquals(0, $account->balance);
    }

    public function test_maximum_deposit()
    {
        $account = Account::create();
        $account->deposit(6000);
        $this->assertEquals(6000, $account->balance);

        $account = Account::create();
        $account->deposit(6000.01);
        $this->assertEquals(0, $account->balance);
    }

    public function test_valid_withdraw()
    {
        $account = Account::create(['balance' => 500]);
        $account->withdraw(100);
        $this->assertEquals(400, $account->balance);
    }

    public function test_invalid_withdraw_more_than_balance()
    {
        $account = Account::create(['balance' => 200]);
        $account->withdraw(500);
        $this->assertEquals(200, $account->balance);
    }

    public function test_valid_transfer()
    {
        $from = Account::create(['balance' => 500]);
        $to = Account::create(['balance' => 50]);
        $from->transferTo($to, 100);
        $this->assertEquals(400, $from->balance);
        $this->assertEquals(150, $to->balance);
    }

    public function test_invalid_transfer_over_daily_limit()
    {
        $from = Account::create(['balance' => 5000]);
        $to = Account::create(['balance' => 50]);

        $from->transferTo($to, 2000);
        $from->transferTo($to, 1200);

        $this->assertEquals(1500, $from->balance);
        $this->assertEquals(2050, $to->balance);

        $result = $from->transferTo($to, 100);
        $this->assertFalse($result);
        $this->assertEquals(1500, $from->balance);
        $this->assertEquals(2050, $to->balance);
    }
}
