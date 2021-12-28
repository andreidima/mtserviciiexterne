@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class="mb-0">
                    <a href="/rapoarte/instructaj"><i class="fas fa-users me-1"></i></a>
                    <a href="/rapoarte/instructaj">Instructaj</a>
                </h4>
            </div>
            <div class="col-lg-9" id="app">
                <form class="needs-validation" novalidate method="GET" action="/rapoarte/instructaj">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <label for="search_data_inceput" class="mb-0 align-self-center me-1">Data început:</label>
                            <vue2-datepicker
                                data-veche="{{ $search_data_inceput }}"
                                nume-camp-db="search_data_inceput"
                                tip="date"
                                value-type="YYYY-MM-DD"
                                format="DD-MM-YYYY"
                                :latime="{ width: '125px' }"
                                style="margin-right: 20px;"
                            ></vue2-datepicker>
                            <label for="search_data_sfarsit" class="mb-0 align-self-center me-1">Data sfârșit:</label>
                            <vue2-datepicker
                                data-veche="{{ $search_data_sfarsit }}"
                                nume-camp-db="search_data_sfarsit"
                                tip="date"
                                value-type="YYYY-MM-DD"
                                format="DD-MM-YYYY"
                                :latime="{ width: '125px' }"
                            ></vue2-datepicker>
                        </div>
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary text-white col-md-4 me-3 border border-dark rounded-3" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-3" href="/rapoarte/instructaj" role="button">
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
                            <th>Nr. Crt.</th>
                            <th>Firma</th>
                            <th>Salariat</th>
                            <th>Expirare instructaj</th>
                            {{-- <th class="text-end">Acțiuni</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($salariati->groupBy('traseu_id', 'id') as $salariati_per_traseu)
                            <tr>
                                <td colspan="5">
                                    Traseu:
                                    <span class="badge bg-dark">
                                        {{ $salariati_per_traseu->first()->firma->traseu->nume ?? '' }}
                                    </span>
                                </td>
                            </tr>
                            @forelse ($salariati_per_traseu->groupBy('firma_id', 'id') as $salariati_per_traseu_per_firma)
                                <tr>
                                    <td align="">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $salariati_per_traseu_per_firma->first()->firma->nume ?? '' }}
                                    </td>
                                    <td>
                                        @forelse ($salariati_per_traseu_per_firma as $salariat)
                                            {{ $salariat->nume ?? '' }}
                                            @if (!$loop->last)
                                                <br>
                                            @endif
                                        @empty
                                        @endforelse
                                    </td>
                                    <td>
                                        @forelse ($salariati_per_traseu_per_firma as $salariat)
                                            {{ $salariat->data_expirare ? \Carbon\Carbon::parse($salariat->data_expirare)->isoFormat('DD.MM.YYYY') : '' }}
                                            @if (!$loop->last)
                                                <br>
                                            @endif
                                        @empty
                                        @endforelse
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        @empty
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
