<?php

namespace App\Http\Controllers;

use App\Repositorys\ScheduleImportRepository;
use Illuminate\Http\Request;

class ScheduleImportController extends Controller
{
    public function __construct(
        private readonly ScheduleImportRepository $repository
    )
    {}

    public function upload(Request $request): \Illuminate\Http\JsonResponse
    {
        if ($request->file('file')->isValid()) {
            $path = $request->file('file')->store('sheets');
            $this->repository->import($path);
        }
        return response()->json(['success' => true, 'message' => 'Arquivo importado com sucesso.']);
    }
}
