<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CurrencyAmount extends Model
{
    use HasFactory;

    protected $table = 'amounts';
    protected $primaryKey = 'id';

    public function currency(): HasOne
    {
        return $this->hasOne(CurrencyNames::class, 'id', 'currency_id');
    }

    public function getIdCurrency(string $currencyName): ?int
    {
        $currencyName = strtoupper($currencyName);

        $id = CurrencyNames::where('name', '=', $currencyName)
            ->first('id');

        return $id['id'] ?? null;
    }

    public function getAllCurrencies(): array
    {
        $data = [];
        $currencies = CurrencyNames::orderBy('name')
            ->get(['id', 'name'])
            ->toArray();

        foreach ($currencies as $value) {
            $data[$value['name']] = $value['id'];
        }

        return $data;
    }

    public function addCurrency(string $currencyName): int
    {
        $data = [
            'name' => strtoupper($currencyName),
        ];

        return CurrencyNames::insertGetId($data);
    }
}
