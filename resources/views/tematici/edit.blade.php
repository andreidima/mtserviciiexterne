@extends ('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                    <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                        <h6 class="ms-3 my-0" style="color:white">
                            <i class="fas fa-file-pdf me-1"></i>
                            Tematici
                        </h6>
                    </div>

                    @include ('errors')

                    <div class="card-body py-2 border border-secondary"
                        style="border-radius: 0px 0px 40px 40px;"
                    >

                        @if (count($tematica->fisiere))
                            <div class="mb-4 table-responsive rounded border border-secondary">
                                <table class="table table-striped table-hover rounded mb-0">
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            Fișiere atașate
                                        </td>
                                    </tr>
                                    @forelse ($tematica->fisiere as $fisier)
                                        <tr>
                                            <td>
                                                {{ $fisier->nume }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <a href="{{ '/tematici/file-download/' . $fisier->id }}"
                                                        class="me-1"
                                                    >
                                                        <span class="badge bg-success">
                                                            Descarcă
                                                        </span>
                                                    </a>
                                                    <a
                                                        href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#stergeFisier{{ $fisier->id }}"
                                                        title="Șterge Fișier"
                                                        >
                                                        <span class="badge bg-danger">Șterge</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </table>
                            </div>
                        @endif

                        <form  class="needs-validation" novalidate method="POST" action="{{ $tematica->path() }}" enctype="multipart/form-data">
                            @method('PATCH')

                                    @include ('tematici.form', [
                                        'buttonText' => 'Modifică Tematică'
                                    ])

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- Modalele pentru stergere --}}
    @forelse ($tematica->fisiere as $fisier)
        <div class="modal fade text-dark" id="stergeFisier{{ $fisier->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Fișier: <b>{{ $fisier->nume ?? '' }}</b></h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să ștergi Fișierul?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                    <form method="POST" action="{{ $fisier->path() }}">
                        @method('DELETE')
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger text-white"
                            >
                            Șterge Fișierul
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @empty
    @endforelse
@endsection
