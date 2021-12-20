@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class="mb-0">
                    <a href="tematici"><i class="fas fa-file-pdf me-1"></i></a>
                    <a href="tematici">Tematici</a>
                </h4>
            </div>
            <div class="col-lg-6" id="app">
                <form class="needs-validation" novalidate method="GET" action="tematici">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
                        <input type="text" class="form-control form-control-sm col-md-4 me-3 rounded-3" id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                value="{{ $search_nume }}">
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary text-white col-md-4 me-3 border border-dark rounded-3" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-3" href="tematici" role="button">
                            <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-end">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-3 col-md-8" href="tematici/adauga" role="button">
                    <i class="fas fa-plus-square text-white me-1"></i>Adaugă tematică
                </a>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th>Nume</th>
                            <th>Fișiere</th>
                            <th class="text-end">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tematici as $tematica)
                            <tr>
                                <td align="">
                                    {{ ($tematici ->currentpage()-1) * $tematici ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    <b>{{ $tematica->nume ?? '' }}</b>
                                </td>
                                <td>
                                    <div>
                                        @foreach ($tematica->fisiere as $fisier)
                                            {{ $fisier->nume }}
                                            @if (!$loop->last)
                                                <br>
                                            @endif
                                        @endforeach
                                    </div>
                                    {{-- {{ count($tematica->fisiere) }} --}}
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ $tematica->path() }}"
                                            class="me-1"
                                        >
                                            <span class="badge bg-success">Vizualizează</span>
                                        </a>
                                        <a href="{{ $tematica->path() }}/modifica"
                                            class="me-1"
                                        >
                                            <span class="badge bg-primary">Modifică</span>
                                        </a>
                                        <a
                                            href="#"
                                            data-bs-toggle="modal"
                                            data-bs-target="#stergeTematica{{ $tematica->id }}"
                                            title="Șterge Tematica"
                                            >
                                            <span class="badge bg-danger">Șterge</span>
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
                        {{$tematici->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>

    {{-- Modalele pentru stergere --}}
    @foreach ($tematici as $tematica)
        <div class="modal fade text-dark" id="stergeTematica{{ $tematica->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Traseu: <b>{{ $tematica->nume ?? '' }}</b></h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să ștergi Tematica?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                    <form method="POST" action="{{ $tematica->path() }}">
                        @method('DELETE')
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger text-white"
                            >
                            Șterge Tematica
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
