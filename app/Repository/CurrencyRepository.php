<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\CurrencyAmount;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class CurrencyRepository implements CurrencyInterface
{

    readonly CurrencyAmount $amount;
    readonly array $todayCurrencies;
    private Collection $collection;
    private array $insertData = [];
    private array $insertCurrencies = [];

    public function __construct(CurrencyAmount $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @param array $data ['currency' => string, 'amount' => float].
     * @return array Returns arrays with added currencies.
     */
    public function createAmounts(array $data): array
    {
        $allCurrencies = $this->amount->getAllCurrencies();
        $this->todayCurrencies = $this->getTodayCurrenciesId();

        foreach ($data as $value) {
            $currencyName = strtoupper($value['currency']);

            if (!array_key_exists($currencyName, $allCurrencies)) {
                $allCurrencies[$currencyName] = $this->amount->addCurrency($currencyName);
            }

            if (!in_array($allCurrencies[$currencyName], $this->todayCurrencies)) {

                $this->insertCurrencies[] = $currencyName;

                $this->insertData[] = [
                    'currency_id' => $allCurrencies[$currencyName],
                    'amount'      => $value['amount']
                ];
            }
        }

        if (count($this->insertData) > 0) {
            if ($this->amount->insert($this->insertData)) {
                return $this->insertCurrencies;
            }
        }
        return $this->insertCurrencies;
    }

    /**
     * @param string $date Date in the format YYYY-mm-dd.
     * @return array Returns the currencies of the selected day.
     */
    public function allOfTheDay(string $date): array
    {
        $this->collection = $this->amount
            ->with('currency')
            ->whereDate('created_at', '=', $date)
            ->get();

        return $this->prepareData();
    }

    /**
     * @param string $date Date in the format YYYY-mm-dd.
     * @param int $id Identifier of the currency name in the database.
     * @return array Returns the selected currency from the selected date.
     */
    public function selectedForTheDay(string $date, int $id): array
    {
        $this->collection = $this->amount
            ->with('currency')
            ->where('currency_id', $id)
            ->whereDate('created_at', '=', $date)
            ->get();

        return $this->prepareData();
    }

    /**
     * @param string $currencyName Currency abbreviation.
     * @return int|null Returns the currency name ID.
     */
    public function getIdCurrency(string $currencyName): ?int
    {
        return $this->amount->getIdCurrency($currencyName);
    }

    /**
     * @return array Returns arrays of data with modified keys.
     */
    private function prepareData(): array
    {
        $response = [];
        foreach ($this->collection ?? [] as $amount) {
            $response[] = [
                'currency' => $amount->currency->name,
                'date'     => $amount->created_at->toDateString(),
                'amount'   => $amount->amount
            ];
        }
        return $response;
    }

    /**
     * @return array Returns today's currency ID arrays.
     */
    private function getTodayCurrenciesId(): array
    {
        $currenciesID = [];
        $result = $this->amount->whereDate('created_at', Carbon::today())
            ->distinct()
            ->get('currency_id')
            ->toArray();

        foreach ($result as $value) {
            $currenciesID[] = $value['currency_id'];
        }

        return $currenciesID;
    }
}
