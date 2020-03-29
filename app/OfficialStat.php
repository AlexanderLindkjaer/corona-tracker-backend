<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfficialStat extends Model
{
    protected $fillable = ['label', 'value', 'group', 'date'];
}
