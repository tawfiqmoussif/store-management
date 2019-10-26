<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SortieDetails extends Model
{
    public function sortieDetails()
    {
        return $this->belongsTo('App\SortieDetails');
    }
    public function article()
    {
        return $this->belongsTo('App\Article');
    }
}
