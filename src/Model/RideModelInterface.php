<?php

declare(strict_types=1);

namespace App\Model;

interface RideModelInterface
{
    public function list(
        int $pageNumber,
        int $pageSize,
        string $sortBy,
        string $sortOrder
    ): array;

    public function listVehicles(string $type): array;

    public function count(): int;

    public function get(int $id): array;

    public function create(array $data): void;

    public function edit(int $id, array $data): void;

    public function delete(int $id): void;
}