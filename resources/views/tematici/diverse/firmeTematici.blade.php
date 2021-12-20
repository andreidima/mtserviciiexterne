@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class="mb-0">
                    <a href="/tematici/firme-tematici"><i class="fas fa-file-pdf me-1"></i></a>
                    <a href="/tematici/firme-tematici">Firme - Tematici</a>
                </h4>
            </div>
            <div class="col-lg-6" id="app">
                <form class="needs-validation" novalidate method="GET" action="/tematici/firme-tematici">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
                        <input type="text" class="form-control form-control-sm col-md-4 me-3 rounded-3" id="search_nume" name="search_nume" placeholder="Firma" autofocus
                                value="{{ $search_nume }}">
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary text-white col-md-4 me-3 border border-dark rounded-3" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-3" href="/tematici/firme-tematici" role="button">
                            <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            {{-- <div class="col-lg-3 text-end">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-3 col-md-8" href="tematici/adauga" role="button">
                    <i class="fas fa-plus-square text-white me-1"></i>Adaugă tematică
                </a>
            </div> --}}
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th>Firma</th>
                            <th>Tematici</th>
                            <th class="text-end">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($firme as $firma)
                            <tr>
                                <td align="">
                                    {{ ($firme ->currentpage()-1) * $firme ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    <b>{{ $firma->nume ?? '' }}</b>
                                </td>
                                <td>
                                    <div>
                                        @foreach ($firma->tematici as $tematica)
                                            {{ $tematica->nume }}
                                            @if (!$loop->last)
                                                <br>
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ $firma->path() }}/modifica"
                                            class="me-1"
                                        >
                                            <span class="badge bg-primary">Modifică</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination justify-content-center">
                        {{$firme->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>

@endsection
