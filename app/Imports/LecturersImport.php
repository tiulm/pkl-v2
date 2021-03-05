<?php

namespace App\Imports;

use App\User;
use App\Lecturer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LecturersImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {   

            $lecturers = Lecturer::updateOrCreate(
                ['NIP'=> $row['nip']],
                ['name' => $row['nama'],
                'NIDN' => $row['nidn'],
                'last_education' => $row['pendidikan_terakhir'],
                'status' => $row['status'],
                'jabatan' => $row['jabatan'],
                'phone_number' => $row['nomor_telepon'],
                'email' => $row['email']]
            );            
        }
    }
}
