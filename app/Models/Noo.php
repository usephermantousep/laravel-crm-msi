<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Noo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cluster()
    {
        return $this->belongsTo(Cluster::class);
    }

    public function getConfirmedAtAttribute($value)
    {
        if($value){
        return Carbon::parse($value)->getPreciseTimestamp(3);
        }
    }

    public function getRejectedAtAttribute($value)
    {
        if($value){
            return Carbon::parse($value)->getPreciseTimestamp(3);
        }

    }

    public function getApprovedAtAttribute($value)
    {
        if($value){
            return Carbon::parse($value)->getPreciseTimestamp(3);
        }
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->getPreciseTimestamp(3);
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->getPreciseTimestamp(3);
    }
}

