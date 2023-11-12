<?php

namespace App\Models;

use Log;
use File;
use Exeption;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PidSales extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'id' => 'string',
    ];

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'id',
        'pid_type_id',
        'name',
        'address',
        'lat',
        'lon',
        'pid_service_id',
        'pid_pay_method',
        'link',
        'remarks',
    ];

    public function pidDayTimeSlots()
    {
        return $this->hasMany(PidDayTimeSlots::class, 'pid_sale_id', 'id')
                    ->with(['day', 'pidTimeSlots']);
    }

    public function type()
    {
        return $this->hasOne(PidTypes::class, 'id', 'pid_type_id');
    }

    public function payMethod()
    {
        return $this->hasOne(pidPayMethods::class, 'id', 'pid_pay_method_id');
    }

    public function services()
    {
        return $this->hasOne(pidServices::class, 'id', 'pid_service_id');
    }


    public function getPidData()
    {
        $response = Http::get('https://data.pid.cz/pointsOfSale/json/pointsOfSale.json');

        if ($response->successful()) {
            $jsonContent = $response->body();
            $dataArray = json_decode($jsonContent, true);


            $openingHours = [];

            //save pis sale
            foreach ($dataArray as $data) {

                $openingHours[$data['id']] = $data['openingHours'];

                $type_id            = PidTypes::firstOrCreate(['type' => $data['type']]);
                $pid_pay_method_id  = pidPayMethods::firstOrCreate(['id' => $data['payMethods']]);
                if( $data['services'] )
                    $pid_service_id     = pidServices::updateOrCreate(['pid_id' => $data['services']]);

                $data['pid_type_id']        = $type_id->id;
                $data['pid_pay_method_id']  = $pid_pay_method_id->id;
                $data['pid_service_id']     = $pid_service_id->id;

                unset($data['openingHours']);
                unset($data['type']);
                unset($data['payMethods']);
                unset($data['services']);

                $this->updateOrInsert(['id' => $data['id']], $data);
            }

            $pivotTable = []; //PidDayTimeSlots
            foreach($openingHours as $id => $data){

                foreach($data as $value){

                    $hours = explode(',', str_replace('–', '-', $value['hours']));
                    if( $value['from'] == $value['to'] ){ //same day
                        foreach($hours as $hour){
                            $timeSplitMore = explode('-', $hour);
                            $record = PidTimeSlots::firstOrCreate([
                                            'start_time' => $timeSplitMore[0],
                                            'end_time'   => $timeSplitMore[1],
                                        ]);
                            //add to array tobe saved to PidDayTimeSlots
                            $pivotTable[] = [
                                'pid_sale_id'       => $id,
                                'day_id'            => $value['from'] + 1,
                                'pid_time_slot_id'  => $record->id,
                            ];
                        }
                    }else{ //more days
                        for( $i = $value['from']; $i <= $value['to']; $i++ ){
                            foreach($hours as $hour){
                                $timeSplitMore = explode('-', $hour);
                                $record = PidTimeSlots::firstOrCreate([
                                    'start_time' => $timeSplitMore[0],
                                    'end_time'   => $timeSplitMore[1],
                                ]);
                                //add to array tobe saved to PidDayTimeSlots
                                $pivotTable[] = [
                                    'pid_sale_id'       => $id,
                                    'day_id'            => $i + 1,
                                    'pid_time_slot_id'  => $record->id,
                                ];
                            }
                        }
                    }
                }
            }
            //save to pivot
            PidDayTimeSlots::insertOrIgnore($pivotTable);
            return true;
        } else {
            $statusCode = $response->status();
            return false;
        }
    }

}
