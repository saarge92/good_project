<?php

declare(strict_types=1);

namespace App\Service\Remote;
interface Client
{
    public function get(string $url): Good;
}