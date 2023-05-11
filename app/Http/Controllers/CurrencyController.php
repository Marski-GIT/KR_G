<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateAmountRequest;
use App\Repository\CurrencyInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\JsonResponse;

class CurrencyController extends Controller
{
    private CurrencyInterface $repository;
    const DATE_FORMAT_REGEX = '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/';

    public function __construct(CurrencyInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $date Date in the format YYYY-mm-dd.
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(string $date): JsonResponse
    {
        if (!Gate::allows('currency_get')) {
            return response()->json(['message' => 'No permissions.'], 401);
        }

        if ($this->validDataFormat($date)) {
            $data = $this->repository->allOfTheDay($date);
            return response()->json($data, 202);
        }

        return response()->json(['message' => 'Invalid date format. Date in Y-m-d format'], 400);
    }

    /**
     * @param string $date Date in the format YYYY-mm-dd.
     * @param string $currency Currency abbreviation.
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(string $date, string $currency): JsonResponse
    {
        if (!Gate::allows('currency_get')) {
            return response()->json(['message' => 'No permissions.'], 401);
        }

        if (!$this->validDataFormat($date)) {
            return response()->json(['message' => 'Invalid date format. Date in Y-m-d format'], 400);
        }

        $idCurrency = $this->repository->getIdCurrency($currency);

        if (is_null($idCurrency)) {
            return response()->json(['message' => 'Currency not found'], 400);
        }

        $data = $this->repository->selectedForTheDay($date, $idCurrency);

        return response()->json($data, 202);
    }

    /**
     * @param CreateAmountRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(CreateAmountRequest $request): JsonResponse
    {
        if (!Gate::allows('currency_store')) {
            return response()->json(['message' => 'No permissions.'], 401);
        }

        $data = $request->validated();

        $response = $this->repository->createAmounts($data);

        if (count($response) > 0) {
            return response()->json(['message' => 'Created successfully: ' . implode(', ', $response)], 201);
        }
        return response()->json(['message' => 'Currency update only once a day.'], 400);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    private function validDataFormat(mixed $value): bool
    {
        return (bool)preg_match(self::DATE_FORMAT_REGEX, $value);
    }
}
