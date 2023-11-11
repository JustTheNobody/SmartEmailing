@extends('app')

@section('content')
<div class="">
    <div class="">
        <h1>Testovací zadání:</h1>
        <ul class="uk-list">
            <li>
                1) Navrhnout a vytvořit MySQL databázi prodejních míst PID: https://pid.cz/o-systemu/opendata/. Program bude umět prodejní místa do tabulky uložit z endpointů PID.   2) Zpřístupnit tato data na API endpointu tak, aby bylo možné:
            </li>
            <ul>
                <li>
                    a) filtrovat výsledky dle toho, zda je prodejní místo otevřeno
                </li>
                <li>
                    b) čas a datum specifikovat parametrem, nebo použít aktuální
                </li>
            </ul>
            <li>
                Kód je potřeba napsat v PHP.
            </li>
            <li>
                Uvítáme použití Nette Frameworku, ale rozhodně se nebráníme dalším, jako například Symfony, Laravel nebo čistému PHP :-) Preferujeme, abyste finální kód nahrál na Github a následně nám poslal odkaz na repozitář.
            </li>
        </ul>
    </div>
    <div class="">
        <h2>Vypracování:</h2>
        <ul class="uk-list">
            <li>
                Vytvořená databáze:
                <ul>
                    <li>tabulka pid_sales obsahuje data a cizí klíče k tabulkám, do kterých byli přesunuty opakující se informace. Tabulky pid_service_id a pid_pay_method_id nemají vyplněn slopec s názvem a to zdůvodu že jsem potřeblé informace na webu https://pid.cz/o-systemu/opendata/ nanalez</li>
                    <li>tabulka pid_day_time_slots je pivot table</li>
                    <li>tabulka pid_time_slots byla vytvořena z důvodu možnosti filtrace časů, které jsou u PID </li>
                </ul>
                <p>v adresáři database jsou migrace, ve stejné složce je i soubor smartemailing-cz pro případ že jsem udělal chybu v migraci.</p>

                <p>Kód určitě bude možno více optimalizovat, ale pro účely tohoto zadání jsem to moc neřešil.</p>
            </li>
            <li>

            </li>
        </ul>
    </div>
    <div class="uk-margin-large-top">
        <a href="{{route('pid_list')}}" class="uk-button uk-button-primary">Show Pids</a>
    </div>
</div>
@endsection