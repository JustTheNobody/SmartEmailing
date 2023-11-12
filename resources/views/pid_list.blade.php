@extends('app')
@section('title')
    Pid list
@endsection
@section('content')
    <div class="uk-align-right">
        <a href="{{route('destroy_pids')}}" id="deleteData" class="uk-align-left uk-button uk-button-danger">Delete data</a>
    </div>
    <div>
        <a href="{{route('home')}}" class="uk-align-left uk-button uk-button-primary">Home</a>
    </div>
    <div class="uk-margin-large-top">
        <div class="uk-margin-bottom uk-flex uk-flex-middle uk-flex-center uk-text-bold">
            Records count:
            <span class="uk-text-lead uk-padding-small uk-margin-left uk-margin-right uk-background-secondary uk-light uk-border-circle">
                {{$pid_list->total()}}
            </span>
            @if( app('request')->input('time') )
                for {{ \Carbon\Carbon::createFromTimestamp(app('request')->input('time'))->format('l') }} at {{ date('H:i', app('request')->input('time')) }}
            @endif
        </div>
        <div>
            <h3>Filter</h3>
            <span>
            {{--is open specify?--}}
                <p id="messageTimeDate" class="uk-margin-large-left uk-margin-remove-bottom uk-text-danger"></p>
                <input type="time" name="time" class="uk-input uk-form-width-small">
                <input type="date" name="day" class="uk-input uk-form-width-small">
                <a href="{{route('pid_list')}}?time=" id="custom" class="uk-button uk-button-secondary">Show Locations</a>
            </span>
            {{--is open now?--}}
            <a href="{{route('pid_list')}}?time={{time()}}" id="current" class="uk-button uk-button-primary uk-margin-left">Currently Opened</a>
            {{--reset--}}
            <a href="{{route('pid_list')}}" id="current" class="uk-button uk-button-default uk-margin-left">Reset filter</a>
        </div>

        <div class="uk-margin-top">
            {{ $pid_list->links() }}
        </div>

        <table class="uk-table uk-table-striped uk-table-hover">
            <thead class="uk-background-secondary">
                <tr>
                    <th>id</th>
                    <th>type</th>
                    <th>name</th>
                    <th>address</th>
                    <th>links</th>
                    <th>remarks</th>
                    <th>service | payMethod</th>
                </tr>
            </thead>
            <tbody id="pidTable">
                @forelse( $pid_list as $item )
                    @include('item')
                @empty
                    <div class="uk-text-center uk-margin-large">
                        <h3>There are no PIDs imported yet</h3>
                        <a href="{{route('import_pids')}}" class="uk-button uk-button-secondary">Import Pids</a>
                    </div>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <div class="uk-margin-large-bottom">
            {{ $pid_list->links() }}
        </div>
    </div>

    <div id="map" uk-modal>
        <div class="uk-modal-dialog uk-padding-remove uk-modal-body">
            <h2 class="uk-modal-title"></h2>
            <a class="uk-modal-close uk-align-right uk-margin-right" type="button"><i class="fa fa-times" aria-hidden="true"></i></a>
            <div style="width: 100%">
                <iframe
                    width="100%"
                    height="600"
                    frameborder="0"
                    scrolling="no"
                    marginheight="0"
                    marginwidth="0"
                    id="mapFrame"
                    src="https://maps.google.com/maps?q=MAP_LAT,MAP_LON&hl=es&z=17&amp;output=embed"
                >
               </iframe>
            </div>
        </div>
    </div>
@endsection