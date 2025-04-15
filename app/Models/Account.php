<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['balance'];
    public $timestamps = true;

    public function deposit(float $amount): bool
    {
        if ($amount <= 0 || $amount > 6000 || !$this->isValidAmount($amount)) return false;
        $this->balance += $amount;
        $this->save();
        return true;
    }

    public function withdraw(float $amount): bool
    {
        if ($amount <= 0 || $amount > 6000 || !$this->isValidAmount($amount) || $this->balance < $amount) return false;
        $this->balance -= $amount;
        $this->save();
        return true;
    }

    public function transferTo(Account $to, float $amount): bool
    {
        $todayTransfers = Transaction::where('from_account_id', $this->id)
            ->whereDate('created_at', today())
            ->sum('amount');

        if (
            $amount <= 0 ||
            $amount > 6000 ||
            !$this->isValidAmount($amount) ||
            $this->balance < $amount ||
            ($todayTransfers + $amount) > 3000
        ) return false;

        $this->withdraw($amount);
        $to->deposit($amount);
        Transaction::create([
            'from_account_id' => $this->id,
            'to_account_id' => $to->id,
            'amount' => $amount
        ]);
        return true;
    }

    private function isValidAmount(float $amount): bool
    {
        return preg_match('/^\d+(\.\d{1,2})?$/', number_format($amount, 2, '.', ''));
    }
}
