<?php
namespace App\Imports;
use App\Role;
use App\User;
use App\InternshipStudent;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class StudentsImport implements ToCollection, WithHeadingRow
{
/**
* @param Collection $collection
*/
public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $user = User::updateOrCreate(
                ['username' => $row['nim']],
                ['password' => $row['nim']]
            );

            $user->roles()->sync(Role::whereRoleName('mahasiswa')->first()->id);
            
            $mahasiswa = InternshipStudent::updateOrCreate(
                ['nim'=> $row['nim']],
                [
                    'name' => $row['nama'],
                    'status' => $row['status'],
                    'gender' => $row['jenis_kelamin'],
                    'angkatan' => $row['angkatan'],
                    'ip_sem' => $row['ip_semester'],
                    'sks_sem' => $row['sks_semester'],
                    'ipk' => $row['ipk'],
                    'sks_total' => $row['sks_total'],
                    'user_id' => $user->id
                ]
            );
        }
    }
}
