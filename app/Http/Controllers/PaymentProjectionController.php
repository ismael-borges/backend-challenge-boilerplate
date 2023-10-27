<?php

namespace App\Http\Controllers;

use App\Repositorys\PaymentProjectionRepository;
use Illuminate\Http\Request;

class PaymentProjectionController extends Controller
{
    public function __construct(
        private readonly PaymentProjectionRepository $repository
    )
    {}

    public function upload(Request $request): \Illuminate\Http\JsonResponse
    {
        if ($request->file('file')->isValid()) {
            $path = $request->file('file')->store('sheets');
            $this->repository->import($path);
        }
        return response()->json(['success' => true]);
    }
}
