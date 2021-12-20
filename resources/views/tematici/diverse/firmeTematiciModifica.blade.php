@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ms-3 my-0" style="color:white">
                        <i class="fas fa-fa-file-pdf me-1"></i>
                        Firme - Tematici
                    </h6>
                </div>

                @include ('errors')

                <div class="card-body px-4 py-4 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
                >
                    <form  class="needs-validation" novalidate method="POST" action="/tematici/firme-tematici/{{ $firma->id }}/tematici-modifica">

                        <div class="row px-2 py-2 rounded-3"
                            style="background-color:lightyellow; border-left:6px solid; border-color:goldenrod"
                        >
                            <div class="col-lg-12">
                                {{-- <div class="form-check rounded-3 px-2"
                                    style="background-color:lightyellow;
                                        border:1px solid goldenrod;
                                        border-left:8px solid goldenrod;
                                        display: inline-block;
                                    "
                                > --}}
                                {{-- <span class="badge bg-dark fs-6">  --}}
                                    <b>Firma: {{ $firma->nume }}</b>
                                {{-- </span> --}}
                                {{-- <br> --}}
                                {{-- <span class="badge bg-dark fs-6"> --}}

                                {{-- </span> --}}
                                {{-- </div> --}}
                            </div>
                        </div>
                        <div class="row px-2 py-2 rounded-3"
                            style="background-color:#B8FFB8;
                                border-left:6px solid mediumseagreen;
                                "
                        >
                            <div class="col-lg-12 mb-2 rounded-3">
                                Selectează tematicile:
                            </div>
                            @foreach ($tematici as $tematica)
                                <div class="col-lg-6 mb-2 rounded-3">
                                    <div class="form-check rounded-3"
                                        style="padding-left:30px;
                                            display: inline-block;
                                            border:4px solid mediumseagreen;
                                            background-color:lightgreen">
                                        <input type="checkbox" class="form-check-input" style=""
                                            name="servicii_selectate[]"
                                            value="{{ $tematica->id }}"
                                            id="{{ $tematica->id }}"
                                            @if (old("servicii_selectate"))
                                                {{ in_array($tematica->id, old("servicii_selectate")) ? "checked":"" }}
                                            @else
                                                {{ in_array($tematica->id, $firma->tematici->pluck('id')->toArray()) ? "checked":"" }}
                                            @endif
                                            >
                                        <label class="form-check-label text-white px-1" for="{{ $tematica->id }}" style="background-color:mediumseagreen;">
                                            {{ $tematica->nume }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
