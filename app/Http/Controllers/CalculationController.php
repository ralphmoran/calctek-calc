<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculationRequest;
use App\Http\Resources\CalculationResource;
use App\Models\Calculation;
use App\Services\CalculatorService;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class CalculationController extends Controller
{
    public function __construct(
        private readonly CalculatorService $calculator
    ) {}

    public function page(): InertiaResponse
    {
        return Inertia::render('Calculator', [
            'history' => CalculationResource::collection(
                Calculation::latest()->limit(50)->get()
            )->resolve(),
        ]);
    }

    public function store(CalculationRequest $request): JsonResponse
    {
        $result = $this->calculator->evaluate($request->input('expression'));

        $calculation = Calculation::create([
            'expression' => $request->input('expression'),
            'result' => $result,
        ]);

        return (new CalculationResource($calculation))
            ->response()
            ->setStatusCode(201);
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return CalculationResource::collection(
            Calculation::latest()->limit(50)->get()
        );
    }

    public function destroy(Calculation $calculation): JsonResponse
    {
        $calculation->delete();

        return response()->json(null, 204);
    }

    public function clear(): JsonResponse
    {
        Calculation::truncate();

        return response()->json(null, 204);
    }
}
