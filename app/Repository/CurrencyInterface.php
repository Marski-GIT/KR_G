<?php

declare(strict_types=1);

namespace App\Repository;
interface CurrencyInterface
{
    public function createAmounts(array $data): array;

    public function allOfTheDay(string $date): array;

    public function selectedForTheDay(string $date, int $id): array;

    public function getIdCurrency(string $currencyName): ?int;
}
