@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ms-2 my-0" style="color:white">
                        <i class="fas fa-users me-1"></i>
                        Salariați / {{ $salariat->nume ?? '' }}</h6>
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
                                    {{ $salariat->nume }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Firma
                                </td>
                                <td>
                                    {{ $salariat->firma->nume ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    CNP
                                </td>
                                <td>
                                    {{ $salariat->cnp }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Funcția
                                </td>
                                <td>
                                    {{ $salariat->functie }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Dată Angajare
                                </td>
                                <td>
                                    {{ $salariat->data_angajare ? \Carbon\Carbon::parse($salariat->data_angajare)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Dată Încetare
                                </td>
                                <td>
                                    {{ $salariat->data_incetare ? \Carbon\Carbon::parse($salariat->data_incetare)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Instructaj la (nr. luni)
                                </td>
                                <td>
                                    {{ $salariat->instructaj_la_nr_luni }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Dată Instructaj
                                </td>
                                <td>
                                    {{ $salariat->data_instructaj ? \Carbon\Carbon::parse($salariat->data_instructaj)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Medicina muncii (dată expirare)
                                </td>
                                <td>
                                    {{ $salariat->medicina_muncii_expirare ? \Carbon\Carbon::parse($salariat->medicina_muncii_expirare)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Anexa SSM
                                </td>
                                <td>
                                    {{ ($salariat->anexa_ssm == '1') ? 'DA' : 'NU' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Lista EIP
                                </td>
                                <td>
                                    {{ ($salariat->lista_eip == '1') ? 'DA' : 'NU' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Locație fișă SSM
                                </td>
                                <td>
                                    @if ($salariat->locatie_fisa_ssm == '0')
                                        {{ 'la ei' }}
                                    @elseif ($salariat->locatie_fisa_ssm == '1')
                                        {{ 'la noi' }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Locație fisă SU
                                </td>
                                <td>
                                    @if ($salariat->locatie_fisa_su == '0')
                                        {{ 'la ei' }}
                                    @elseif ($salariat->locatie_fisa_su == '1')
                                        {{ 'la noi' }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Observații
                                </td>
                                <td>
                                    {{ $salariat->observatii }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-primary text-white rounded-3" href="/firme/salariati">Pagină Salariați</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
