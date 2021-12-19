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
                                    Firma
                                </td>
                                <td>
                                    {{ $stingator->firma->nume }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    P1
                                </td>
                                <td>
                                    {{ $stingator->p1 }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    P2
                                </td>
                                <td>
                                    {{ $stingator->p2 }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    P3
                                </td>
                                <td>
                                    {{ $stingator->p3 }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    P6
                                </td>
                                <td>
                                    {{ $stingator->p6 }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    P9
                                </td>
                                <td>
                                    {{ $stingator->p9 }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    SM6
                                </td>
                                <td>
                                    {{ $stingator->sm6 }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    SM9
                                </td>
                                <td>
                                    {{ $stingator->sm9 }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    P50
                                </td>
                                <td>
                                    {{ $stingator->p50 }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    P100
                                </td>
                                <td>
                                    {{ $stingator->p100 }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    SM50
                                </td>
                                <td>
                                    {{ $stingator->sm50 }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    SM100
                                </td>
                                <td>
                                    {{ $stingator->sm100 }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    G2
                                </td>
                                <td>
                                    {{ $stingator->g2 }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    G5
                                </td>
                                <td>
                                    {{ $stingator->g5 }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Expirare stingătoare
                                </td>
                                <td>
                                    {{ $stingator->stingatoare_expirare ? \Carbon\Carbon::parse($stingator->stingatoare_expirare)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Expirare hidranți
                                </td>
                                <td>
                                    {{ $stingator->hidranti_expirare ? \Carbon\Carbon::parse($stingator->hidranti_expirare)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Observații
                                </td>
                                <td>
                                    {{ $stingator->observatii }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-primary text-white rounded-3" href="/firme/stingatoare">Pagină Stingătoare</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
