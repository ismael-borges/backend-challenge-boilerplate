<?php

namespace App\Repositorys;

use App\Models\ScheduleImport;

class ScheduleImportRepository
{
    public function import(string $path): void
    {
        ScheduleImport::create([
            'path' => $path
        ]);
    }

    public function update(int $id, array $data): void
    {
        ScheduleImport::find($id)->update($data);
    }
}
