<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = null;

    public function getTable()
    {
        throw new \RuntimeException('Report model has no table — it is only used for authorization gates.');
    }
}