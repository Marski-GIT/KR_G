<?php

declare(strict_types=1);

namespace App\Repository;
interface CurrencyInterface
{
    public function createAmounts(array $data);

    public function allOfTheDay(string $date);

    public function selectedForTheDay(string $date, int $id);

    public function getIdCurrency(string $currencyName);
}
