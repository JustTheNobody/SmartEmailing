@php
    $days = [];
    foreach($item->pidDayTimeSlots as $dayTime)
        $days[$dayTime->day->day_of_week][] = $dayTime->pidTimeSlots->start_time . '-' . $dayTime->pidTimeSlots->end_time;
@endphp

<tr>
    <td  class="uk-text-bold">{{$item->id}}</td>
    <td><span class="uk-text-small">{{$item->type->type}}</span></td>
    <td>{{$item->name}}</td>
    <td>{{$item->address}}</td>
    <td>
        <span class="uk-text-right">
        <a href="https://www.google.com/maps?q={{$item->lat}},{{$item->lon}}" data-lat="{{$item->lat}}" data-lon="{{$item->lon}}" uk-tooltip="google map" target="_blank" class="mapLink fa-4">
            <i class="fa fa-map-marker" aria-hidden="true"></i>
        </a>
        @if($item->link)
            <a href="{{$item->link}}" target="_blank" uk-tooltip="link to site" target="_blank" class="uk-margin-small-left fa-4">
                <i class="fa fa-link" aria-hidden="true"></i>
            </a>
        @endif
        </span>
    </td>
    <td>{{$item->remarks}}</td>
    <td>
        <span class="uk-badge">
            {{$item->payMethod->id}}
        </span>
        | {{$item->services->pid_id}}
    </td>
</tr>
<tr class="uk-position-relative times">
    <td colspan="7" class="uk-padding-remove">
        <ul uk-accordion>
            <li>
                <a class="uk-accordion-title" href>
                    <span class="uk-label">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        Pid <span class="uk-text-bold">{{$item->id}}</span> times
                    </span>
                </a>
                <div class="uk-accordion-content uk-child-width-auto" data-uk-grid>
                    @foreach($days as $key => $value)
                        <div class="ukpadding-small">
                            {{$key}}<br>
                            <ul class="uk-list">
                                @foreach($value as $time)
                                    <li>{{$time}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </li>
        </ul>
    </td>
</tr>