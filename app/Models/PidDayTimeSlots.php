<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PidDayTimeSlots extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'pid_sale_id',
        'day_id',
        'pid_time_slot_id',
    ];

    public function day()
    {
        return $this->belongsTo(Days::class, 'day_id');
    }

    public function pidTimeSlots()
    {
        return $this->belongsTo(PidTimeSlots::class, 'pid_time_slot_id');
    }

    public function getDayTime( $dayTime )
    {
        $this->with('day', function($day) use ($dayTime){
                    return $day->where('day','=', $dayTime['day']);
                })
                ->with('time', function($time) use ($dayTime){
                    $time->whereTime('start_time', '<=', $dayTime['time'])
                            ->whereTime('end_time', '>=', $dayTime['time']);
                });
    }
}
