<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\CurrencyAmount;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class CurrencyRepository implements CurrencyInterface
{

    readonly CurrencyAmount $amount;
    private Collection $collection;

    public function __construct(CurrencyAmount $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @param array $data ['currency' => string, 'date' => YYYY-MM-DD, 'amount' => float].
     * @return bool
     */
    public function createAmounts(array $data = []): bool
    {
        $insertData = [];
        $allCurrencies = $this->amount->getAllCurrencies();

        foreach ($data as $value) {
            $currencyName = strtoupper($value['currency']);

            if (!array_key_exists($currencyName, $allCurrencies)) {
                $allCurrencies[$currencyName] = $this->amount->addCurrency($currencyName);
            }

            $insertData[] = [
                'currency_id' => $allCurrencies[$currencyName],
                'date'        => $value['date'] ?? Carbon::now()->toDateString(),
                'amount'      => $value['amount']
            ];
        }

        return $this->amount->insert($insertData);
    }

    /**
     * @param string $date Date in the format YYYY-mm-dd.
     * @return array
     */
    public function allOfTheDay(string $date): array
    {
        $this->collection = $this->amount
            ->with('currency')
            ->whereDate('date', '=', $date)
            ->get();

        return $this->prepareData();
    }

    /**
     * @param string $date Date in the format YYYY-mm-dd.
     * @param int $id Identifier of the currency name in the database.
     * @return array
     */
    public function selectedForTheDay(string $date, int $id): array
    {
        $this->collection = $this->amount
            ->with('currency')
            ->where('currency_id', $id)
            ->whereDate('date', '=', $date)
            ->get();

        return $this->prepareData();
    }

    /**
     * @param string $currencyName Currency abbreviation.
     * @return int|null
     */
    public function getIdCurrency(string $currencyName): ?int
    {
        return $this->amount->getIdCurrency($currencyName);
    }

    /**
     * @return array
     */
    private function prepareData(): array
    {
        $response = [];
        foreach ($this->collection ?? [] as $amount) {
            $response[] = [
                'currency' => $amount->currency->name,
                'date'     => date('Y-m-d', strtotime($amount->date)),
                'amount'   => $amount->amount
            ];
        }
        return $response;
    }
}
