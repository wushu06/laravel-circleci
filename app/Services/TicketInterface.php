<?php

namespace App\Services;

interface TicketInterface
{
    public const page = 10;
    public const statuses = [
      0 => 'Pending',
      1 => 'Resolved'
    ];
    public function getData();
    public function sort($request);
}
