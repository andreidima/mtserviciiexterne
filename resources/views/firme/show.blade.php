@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ms-2 my-0" style="color:white">
                        <i class="fas fa-building me-1"></i>
                        @switch($serviciu)
                            @case('SSM')
                                ssm
                                @break
                            @case('medicina-muncii')
                                Medicina muncii
                                @break
                            @case('stingatoare')
                                Stingătoare și hidranți
                                @break
                            @default
                        @endswitch
                        - Firme / {{ $firma->nume ?? '' }}</h6>
                </div>

                <div class="card-body py-2 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
                >

            @include ('errors')

                    <div class="table-responsive col-md-12 mx-auto">
                        <table class="table table-striped table-hover"
                        >
                            <tr>
                                <td class="pe-4">
                                    Nume
                                </td>
                                <td>
                                    {{ $firma->nume }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Cod fiscal
                                </td>
                                <td>
                                    {{ $firma->cod_fiscal }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Domeniu de activitate
                                </td>
                                <td>
                                    {{ $firma->domeniu_de_activitate->nume ?? ''}}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Telefon
                                </td>
                                <td>
                                    {{ $firma->telefon }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Adresa
                                </td>
                                <td>
                                    {{ $firma->adresa }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Localitate
                                </td>
                                <td>
                                    {{ $firma->localitate }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Județ
                                </td>
                                <td>
                                    {{ $firma->judet }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Email
                                </td>
                                <td>
                                    {{ $firma->email }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Buletin pram data expirare
                                </td>
                                <td>
                                    {{ $firma->buletin_pram_expirare ? \Carbon\Carbon::parse($firma->buletin_pram_expirare)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    ISCIR
                                </td>
                                <td>
                                    {{ ($firma->iscir == '1') ? 'DA' : 'NU' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    ISCIR_descriere
                                </td>
                                <td>
                                    {{ $firma->iscir_descriere }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Nume administrator
                                </td>
                                <td>
                                    {{ $firma->nume_administrator }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Angajat desemnat
                                </td>
                                <td>
                                    {{ $firma->angajat_desemnat }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Traseu
                                </td>
                                <td>
                                    {{ $firma->traseu->nume ?? ''}}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Ordine în traseu
                                </td>
                                <td>
                                    {{ $firma->traseu_ordine }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Observații
                                </td>
                                <td>
                                    {{ $firma->observatii }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-primary text-white rounded-3" href="{{ Session::get('firma_return_url') }}">Înapoi</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
