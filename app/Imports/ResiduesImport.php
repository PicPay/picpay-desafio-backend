<?php

namespace App\Imports;

use App\Residue;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ResiduesImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue
{
    public function model(array $row)
    {
        return new Residue([
            'name' => $row['nome_comum_do_residuo'], 
            'type' => $row['tipo_de_residuo'], 
            'category' => $row['categoria'], 
            'treatment' => $row['tecnologia_de_tratamento'], 
            'class' => $row['classe'], 
            'unit_measurement' => $row['unidade_de_medida'], 
            'weight' => $row['peso'],
        ]);
    }

    public function headingRow(): int
    {
        return 5;
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
