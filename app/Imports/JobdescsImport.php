<?php

namespace App\Imports;

use App\Jobdesc;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JobdescsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {   

            $jobdescs = Jobdesc::updateOrCreate(
                ['jobname'=> $row['jobname']],
                ['description'=> $row['deskripsi'], 
                'status'=> $row['status']]
            );            
        }
    }
}
