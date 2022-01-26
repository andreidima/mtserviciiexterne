@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class="mb-0">
                    <a href="/rapoarte/stingatoare"><i class="fas fa-file-alt me-1"></i></a>
                    <a href="/rapoarte/stingatoare">Stingătoare</a>
                </h4>
            </div>
            <div class="col-lg-9" id="app">
                <form class="needs-validation" novalidate method="GET" action="/rapoarte/stingatoare">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <label for="search_data" class="mb-0 align-self-center me-1">Luna:</label>
                            <vue2-datepicker
                                data-veche="{{ $search_data }}"
                                nume-camp-db="search_data"
                                tip="date"
                                value-type="YYYY-MM-DD"
                                format="DD-MM-YYYY"
                                :latime="{ width: '125px' }"
                                style="margin-right: 20px;"
                            ></vue2-datepicker>
                            <small class="align-self-center">
                                *Selectează orice zi din luna dorită
                            </small>
                        </div>
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary text-white col-md-4 me-3 border border-dark rounded-3" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-3" href="/rapoarte/stingatoare" role="button">
                            <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="table-responsive rounded-3">
                <table class="table table-striped table-hover rounded-3">
                    <thead class="text-white rounded-3" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th colspan="4" class="text-center">
                                Luna {{ \Carbon\Carbon::parse($search_data)->isoFormat('MM.YYYY') }} / Total stingătoare =
                                    <span class="badge bg-success fs-6 border border-white">
                                        {{ $stingatoare->sum('p1') + $stingatoare->sum('p2') + $stingatoare->sum('p3') + $stingatoare->sum('p4') + $stingatoare->sum('p5') + $stingatoare->sum('p6') + $stingatoare->sum('p9') + $stingatoare->sum('p20') + $stingatoare->sum('p50') +
                                            $stingatoare->sum('p100') + $stingatoare->sum('sm3') + $stingatoare->sum('sm6') + $stingatoare->sum('sm9') + $stingatoare->sum('sm50') + $stingatoare->sum('sm100') + $stingatoare->sum('g2') + $stingatoare->sum('g5') }}
                                    </span>
                                <br>
                                Luna precedentă {{ \Carbon\Carbon::parse($search_data_luna_precedenta)->isoFormat('MM.YYYY') }} / Total stingătoare nerezolvate =
                                    <span class="badge bg-danger fs-6 border border-white">
                                        {{ $stingatoare_luna_precedenta->sum('p1') + $stingatoare_luna_precedenta->sum('p2') + $stingatoare_luna_precedenta->sum('p3') + $stingatoare_luna_precedenta->sum('p4') + $stingatoare_luna_precedenta->sum('p5') + $stingatoare_luna_precedenta->sum('p6') + $stingatoare_luna_precedenta->sum('p9') + $stingatoare_luna_precedenta->sum('p20') + $stingatoare_luna_precedenta->sum('p50') +
                                            $stingatoare_luna_precedenta->sum('p100') + $stingatoare_luna_precedenta->sum('sm3') + $stingatoare_luna_precedenta->sum('sm6') + $stingatoare_luna_precedenta->sum('sm9') + $stingatoare_luna_precedenta->sum('sm50') + $stingatoare_luna_precedenta->sum('sm100') + $stingatoare_luna_precedenta->sum('g2') + $stingatoare_luna_precedenta->sum('g5') }}
                                    </span>
                            </th>
                        </tr>
                        <tr class="" style="padding:2rem">
                            <th width="5%">#</th>
                            <th width="50%">Firma</th>
                            <th width="15%">Telefon</th>
                            <th width="30%">
                                <div class="d-flex justify-content-between align-items-end">
                                    <div>
                                        Stingătoare
                                    </div>
                                    <div>
                                        <a class="btn btn-sm btn-primary border border-light rounded-3"
                                            href="/rapoarte/stingatoare/{{ $search_data->toDateString() }}/export-pdf" role="button">
                                            Export PDF
                                        </a>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // dd($stingatoare);
                        @endphp
                        @forelse ($stingatoare->groupBy('firma.traseu_id') as $stingatoare_per_traseu)
                            {{-- @php
                                $total_stingatoare_per_traseu = 0;
                            @endphp --}}
                            <tr>
                                <td colspan="4">
                                    Traseu:
                                    <span class="badge bg-dark fs-6">
                                        {{ $stingatoare_per_traseu->first()->firma->traseu->nume ?? '' }}
                                    </span>
                                    /
                                    Stingatoare =
                                    <span class="badge bg-success fs-6">
                                        {{ $stingatoare_per_traseu->sum('p1') + $stingatoare_per_traseu->sum('p2') + $stingatoare_per_traseu->sum('p3') + $stingatoare_per_traseu->sum('p4') + $stingatoare_per_traseu->sum('p5') + $stingatoare_per_traseu->sum('p6') + $stingatoare_per_traseu->sum('p9') + $stingatoare_per_traseu->sum('p20') + $stingatoare_per_traseu->sum('p50') +
                                            $stingatoare_per_traseu->sum('p100') + $stingatoare_per_traseu->sum('sm3') + $stingatoare_per_traseu->sum('sm6') + $stingatoare_per_traseu->sum('sm9') + $stingatoare_per_traseu->sum('sm50') + $stingatoare_per_traseu->sum('sm100') + $stingatoare_per_traseu->sum('g2') + $stingatoare_per_traseu->sum('g5') }}
                                    </span>
                                </td>
                            </tr>
                            @forelse ($stingatoare_per_traseu as $stingator)
                                {{-- @php
                                    $total_stingatoare_per_stingator =
                                        $stingator->p1 + $stingator->p2 + $stingator->p3 + $stingator->p4 + $stingator->p5 + $stingator->p6 + $stingator->p9 + $stingator->p20 + $stingator->p50 +
                                        $stingator->p100 + $stingator->sm3 + $stingator->sm6 + $stingator->sm9 + $stingator->sm50 + $stingator->sm100 + $stingator->g2 + $stingator->g5;
                                    $total_stingatoare_per_traseu += $total_stingatoare_per_stingator
                                @endphp --}}
                                <tr>
                                    <td align="">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <b>
                                            {{ $stingator->firma->nume ?? '' }}
                                        </b>
                                    </td>
                                    <td>
                                        {{ $stingator->firma->telefon ?? '' }}
                                    </td>
                                    <td>
                                        <span class="badge fs-6 bg-success">
                                            {{
                                                $stingator->p1 + $stingator->p2 + $stingator->p3 + $stingator->p4 + $stingator->p5 + $stingator->p6 + $stingator->p9 + $stingator->p20 + $stingator->p50 +
                                                $stingator->p100 + $stingator->sm3 + $stingator->sm6 + $stingator->sm9 + $stingator->sm50 + $stingator->sm100 + $stingator->g2 + $stingator->g5;
                                            }}
                                        </span> =
                                        @if($stingator->p1 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p1 }} P1
                                                </span>
                                        @endif
                                        @if($stingator->p2 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p2 }} P2
                                                </span>
                                        @endif
                                        @if($stingator->p3 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p3 }} P3
                                                </span>
                                        @endif
                                        @if($stingator->p4 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p4 }} P4
                                                </span>
                                        @endif
                                        @if($stingator->p5 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p5 }} P5
                                                </span>
                                        @endif
                                        @if($stingator->p6 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p6 }} P6
                                                </span>
                                        @endif
                                        @if($stingator->p9 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p9 }} P9
                                                </span>
                                        @endif
                                        @if($stingator->p20 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p20 }} P20
                                                </span>
                                        @endif
                                        @if($stingator->p50 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p50 }} P50
                                                </span>
                                        @endif
                                        @if($stingator->p100 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p100 }} P100
                                                </span>
                                        @endif
                                        @if($stingator->sm3 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->sm3 }} SM3
                                                </span>
                                        @endif
                                        @if($stingator->sm6 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->sm6 }} SM6
                                                </span>
                                        @endif
                                        @if($stingator->sm9 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->sm9 }} SM9
                                                </span>
                                        @endif
                                        @if($stingator->sm50 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->sm50 }} SM50
                                                </span>
                                        @endif
                                        @if($stingator->sm100 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->sm100 }} SM100
                                                </span>
                                        @endif
                                        @if($stingator->g2 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->g2 }} G2
                                                </span>
                                        @endif
                                        @if($stingator->g5 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->g5 }} G5
                                                </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                            @endforelse
                            <tr>
                                <td colspan="4">
                                    &nbsp;
                                </td>
                            </tr>
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>


            <div class="table-responsive rounded-3">
                <table class="table table-striped table-hover rounded-3">
                    <thead class="text-white rounded-3" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th colspan="4" class="text-center">
                                Luna precedentă {{ \Carbon\Carbon::parse($search_data_luna_precedenta)->isoFormat('MM.YYYY') }} / Total stingătoare nerezolvate =
                                    <span class="badge bg-danger fs-6 border border-white">
                                        {{ $stingatoare_luna_precedenta->sum('p1') + $stingatoare_luna_precedenta->sum('p2') + $stingatoare_luna_precedenta->sum('p3') + $stingatoare_luna_precedenta->sum('p4') + $stingatoare_luna_precedenta->sum('p5') + $stingatoare_luna_precedenta->sum('p6') + $stingatoare_luna_precedenta->sum('p9') + $stingatoare_luna_precedenta->sum('p20') + $stingatoare_luna_precedenta->sum('p50') +
                                            $stingatoare_luna_precedenta->sum('p100') + $stingatoare_luna_precedenta->sum('sm3') + $stingatoare_luna_precedenta->sum('sm6') + $stingatoare_luna_precedenta->sum('sm9') + $stingatoare_luna_precedenta->sum('sm50') + $stingatoare_luna_precedenta->sum('sm100') + $stingatoare_luna_precedenta->sum('g2') + $stingatoare_luna_precedenta->sum('g5') }}
                                    </span>
                            </th>
                        </tr>
                        <tr class="" style="padding:2rem">
                            <th width="5%">#</th>
                            <th width="50%">Firma</th>
                            <th width="15%">Telefon</th>
                            <th width="30%">Stingătoare</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // dd($stingatoare);
                        @endphp
                        @forelse ($stingatoare_luna_precedenta->groupBy('firma.traseu_id') as $stingatoare_per_traseu)
                            @php
                                $total_stingatoare_per_traseu = 0;
                            @endphp
                            <tr>
                                <td colspan="4">
                                    Traseu:
                                    <span class="badge bg-dark fs-6">
                                        {{ $stingatoare_per_traseu->first()->firma->traseu->nume ?? '' }}
                                    </span>
                                    /
                                    Stingatoare =
                                    <span class="badge bg-success fs-6">
                                        {{ $stingatoare_per_traseu->sum('p1') + $stingatoare_per_traseu->sum('p2') + $stingatoare_per_traseu->sum('p3') + $stingatoare_per_traseu->sum('p4') + $stingatoare_per_traseu->sum('p5') + $stingatoare_per_traseu->sum('p6') + $stingatoare_per_traseu->sum('p9') + $stingatoare_per_traseu->sum('p20') + $stingatoare_per_traseu->sum('p50') +
                                            $stingatoare_per_traseu->sum('p100') + $stingatoare_per_traseu->sum('sm3') + $stingatoare_per_traseu->sum('sm6') + $stingatoare_per_traseu->sum('sm9') + $stingatoare_per_traseu->sum('sm50') + $stingatoare_per_traseu->sum('sm100') + $stingatoare_per_traseu->sum('g2') + $stingatoare_per_traseu->sum('g5') }}
                                    </span>
                                </td>
                            </tr>
                            @forelse ($stingatoare_per_traseu as $stingator)
                                @php
                                    $total_stingatoare_per_stingator =
                                        $stingator->p1 + $stingator->p2 + $stingator->p3 + $stingator->p4 + $stingator->p5 + $stingator->p6 + $stingator->p9 + $stingator->p20 + $stingator->p50 +
                                        $stingator->p100 + $stingator->sm3 + $stingator->sm6 + $stingator->sm9 + $stingator->sm50 + $stingator->sm100 + $stingator->g2 + $stingator->g5;
                                    $total_stingatoare_per_traseu += $total_stingatoare_per_stingator
                                @endphp
                                <tr>
                                    <td align="">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <b>
                                            {{ $stingator->firma->nume ?? '' }}
                                        </b>
                                    </td>
                                    <td>
                                        {{ $stingator->firma->telefon ?? '' }}
                                    </td>
                                    <td>
                                        <span class="badge fs-6 bg-success">
                                            {{ $total_stingatoare_per_stingator }}
                                        </span> =
                                        @if($stingator->p1 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p1 }} P1
                                                </span>
                                        @endif
                                        @if($stingator->p2 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p2 }} P2
                                                </span>
                                        @endif
                                        @if($stingator->p3 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p3 }} P3
                                                </span>
                                        @endif
                                        @if($stingator->p4 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p4 }} P4
                                                </span>
                                        @endif
                                        @if($stingator->p5 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p5 }} P5
                                                </span>
                                        @endif
                                        @if($stingator->p6 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p6 }} P6
                                                </span>
                                        @endif
                                        @if($stingator->p9 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p9 }} P9
                                                </span>
                                        @endif
                                        @if($stingator->p20 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p20 }} P20
                                                </span>
                                        @endif
                                        @if($stingator->p50 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p50 }} P50
                                                </span>
                                        @endif
                                        @if($stingator->p100 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->p100 }} P100
                                                </span>
                                        @endif
                                        @if($stingator->sm3 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->sm3 }} SM3
                                                </span>
                                        @endif
                                        @if($stingator->sm6 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->sm6 }} SM6
                                                </span>
                                        @endif
                                        @if($stingator->sm9 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->sm9 }} SM9
                                                </span>
                                        @endif
                                        @if($stingator->sm50 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->sm50 }} SM50
                                                </span>
                                        @endif
                                        @if($stingator->sm100 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->sm100 }} SM100
                                                </span>
                                        @endif
                                        @if($stingator->g2 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->g2 }} G2
                                                </span>
                                        @endif
                                        @if($stingator->g5 > 0)
                                                <span class="badge bg-secondary">
                                                {{ $stingator->g5 }} G5
                                                </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                            @endforelse
                            <tr>
                                <td colspan="4">
                                    &nbsp;
                                </td>
                            </tr>
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>

                {{-- <nav>
                    <ul class="pagination justify-content-center">
                        {{$stingatoare->appends(Request::except('page'))->links()}}
                    </ul>
                </nav> --}}

        </div>
    </div>

    {{-- Modalele pentru stergere --}}
    {{-- @foreach ($stingatoare as $stingator)
        <div class="modal fade text-dark" id="stergeStingător{{ $stingator->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Stingător: <b>{{ $stingator->nume ?? '' }}</b></h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să ștergi Stingător?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                    <form method="POST" action="{{ $stingator->path() }}">
                        @method('DELETE')
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger text-white"
                            >
                            Șterge Stingător
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @endforeach --}}

@endsection
