<?php

namespace App\Service;

use App\DTO\WorkerCsvDTO;

class CSVHandler
{
    public function readFromFile(string $fileName): array
    {
        $data = [];
        $handle = fopen($fileName, "r");
        while (($row = fgetcsv($handle)) !== false) {
          $data[] = $row;
        }
        fclose($handle);
        return $data;
    }

    public function read(string $fileName): array
    {
        $data = [];
        $handle = fopen($fileName, "r");
        while (($row = fgetcsv($handle)) !== false) {
            $data[] = new WorkerCsvDTO($row[0], $row[1]);
        }
        fclose($handle);
        return $data;
    }

}