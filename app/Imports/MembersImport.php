<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class MembersImport implements ToModel, WithStartRow, WithCustomCsvSettings
{
    public function startRow(): int
    {
        return 2;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }

    public function model(array $row)
    {
        return new Member([
            'group_id'      => 1,
            'name'          => $row[2],
            'address'       => $row[3],
            'phone'         => $row[4],
            'email'         => $row[5],
            'profile_pic'   => 'test',
        ]);
    }
}
