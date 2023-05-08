<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repository\CurrencyInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CurrencyController extends Controller
{
    private CurrencyInterface $repository;

    public function __construct(CurrencyInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $date Date in the format YYYY-mm-dd.
     * @return JsonResponse
     */
    public function index(string $date): JsonResponse
    {
        $data = $this->repository->allOfTheDay($date);

        return response()->json($data, 202);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request = json_decode($request->getContent());

        $status = $this->repository->createAmounts($request);

        if ($status) {
            return response()->json(['message' => 'Created successfully'], 201);
        }
        return response()->json(['message' => 'Internal server error'], 500);
    }

    /**
     * @param string $date Date in the format YYYY-mm-dd.
     * @param string $currency Currency abbreviation.
     * @return JsonResponse
     */
    public function show(string $date, string $currency): JsonResponse
    {
        $idCurrency = $this->repository->getIdCurrency($currency);

        if (is_null($idCurrency)) {
            return response()->json(['message' => 'Currency not found'], 400);
        }

        $data = $this->repository->selectedForTheDay($date, $idCurrency);

        return response()->json($data, 202);
    }

}
