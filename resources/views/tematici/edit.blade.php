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
                        <div class="table-responsive rounded">
                            <table class="table table-striped table-hover rounded">
                                <tr>
                                    <td colspan="3">
                                        Fișiere atașate:
                                    </td>
                                </tr>
                                @forelse ($tematica->fisiere as $fisier)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $fisier->fisier_nume }}
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
                            </table>
                        </div>
                    @endif
                                                {{-- <div style="" class="d-flex m-auto">
                                                    <a
                                                        href="#"
                                                        data-toggle="modal"
                                                        data-target="#stergeFisier{{ $fisier->id }}"
                                                        title="Șterge Fișier"
                                                        >
                                                        <span class="badge badge-danger">Șterge</span>
                                                    </a>
                                                        <div class="modal fade text-dark" id="stergeFisier{{ $imagine->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                <div class="modal-header bg-danger">
                                                                    <h5 class="modal-title text-white" id="exampleModalLabel">Componenta: <b>{{ $componenta_pc->nume }}</b></h5>
                                                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body" style="text-align:left;">
                                                                    Ești sigur ca vrei să ștergi imaginea „{{ $imagine->imagine_nume }}”?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                                    <form method="POST" action="/service/componente-pc/sterge-imagine/{{ $imagine->id }}">
                                                                        @method('PATCH')
                                                                        @csrf
                                                                        <button
                                                                            type="submit"
                                                                            class="btn btn-danger"
                                                                            >
                                                                            Șterge imaginea
                                                                        </button>
                                                                    </form>

                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div> --}}

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
@endsection
