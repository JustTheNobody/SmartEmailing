<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PidSales;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PidSalesController extends Controller
{
    protected int $pagination = 20;
    protected int $timestamp;

    //return void
    public function index( Request $request )
    {
        if( $request->time ){

            $dayTime = ($this->getDayTime( $request ));

            $pidSale = PidSales::with([
                'type',
                'services',
                'payMethod'
            ])->whereHas('pidDayTimeSlots.day', function($day) use ($dayTime) {
                $day->where('day_of_week', '=', $dayTime['day']);
            })->whereHas('pidDayTimeSlots.pidTimeSlots', function($time) use ($dayTime) {
                $time->whereTime('start_time', '<=', $dayTime['time'])
                    ->whereTime('end_time', '>=', $dayTime['time']);
            })->orderBy('name')->paginate($this->pagination);

        }else{


            $pidSale = PidSales::with([
                                'type',
                                'services',
                                'payMethod'
                                ])
                                ->orderBy('name')
                                ->paginate($this->pagination);
        }

        return view('pid_list', [
            'pid_list'   => $pidSale,
            'pagination' => $this->pagination
        ]);
    }

    public function import()
    {
        (new PidSales)->getPidData();
        return redirect('pid_list')->with(['success' => 'data imported']);
    }

    /**
     *
     * @return array
     */
    public function getDayTime( $request ) : array
    {
        if( $request->time ){
            $this->timestamp = $request->time;
            session()->put('timestamp', $this->timestamp);
        }elseif( session()->has('timestamp') ){
            $this->timestamp = session()->get('timestamp');
        }else{
            $this->timestamp = time();
        }

        $carbonInstance = Carbon::createFromTimestamp($this->timestamp);
        $formattedTime = $carbonInstance->format('H:i');
        $dayOfWeek = $carbonInstance->format('l');

        return ['day' => $dayOfWeek, 'time' => $formattedTime];
    }

    // TODO move to base model
    public function destroy()
    {
        $tables = ['pid_day_time_slots', 'pid_sales', 'pid_time_slots'];

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        return back()->with(['success' => 'data deleted']);
    }
}
