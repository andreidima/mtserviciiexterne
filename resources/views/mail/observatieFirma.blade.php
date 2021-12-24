@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            MT Servicii Externe
        @endcomponent
    @endslot

# Bună ziua {{ $observatie->firma->nume ?? ''}},
<br>
Vă trimitem observația din teren:
<ul>
@if ($observatie->nume)
    <li>
        {{ $observatie->nume }}
    </li>
@endif
@if ($observatie->data)
    <li>
        {{ \Carbon\Carbon::parse($observatie->data)->isoFormat('DD.MM.YYYY') }}
    </li>
@endif
@if ($observatie->descriere)
    <li>
        {{ $observatie->descriere }}
    </li>
@endif
</ul>

<br>

Mulțumim,<br>
{{ config('app.name') }}


{{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}
            <br>
            Sistem informatic dezvoltat de <a href="validsoftware.ro" target="_blank">validsoftware.ro</a>
            <br>
            - Servicii Informatice Focșani -
        @endcomponent
    @endslot
@endcomponent
