<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nour\Filter\FilterTrait;

class Ticket extends Model
{
    use HasFactory, FilterTrait;

    protected $guarded = [];

}
