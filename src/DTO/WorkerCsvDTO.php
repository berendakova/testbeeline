<?php

namespace App\DTO;

final class WorkerCsvDTO
{
    private string $name;
    private ?string $bossName;

    public function __construct(string $name, ?string $bossName)
    {
        $this->name = $name;
        $this->bossName = $bossName;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBossName(): ?string
    {
        return $this->bossName;
    }
}