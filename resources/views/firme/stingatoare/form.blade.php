@csrf

<div class="row mb-0 p-3 d-flex border-radius: 0px 0px 40px 40px" id="app">
    <div class="col-lg-12 mb-0">

        <div class="row mb-0">
            {{-- <div class="col-lg-4 mb-5">
                <label for="firma_id" class="mb-0 ps-3">Firma<span class="text-danger">*</span></label>
                <select name="firma_id"
                    class="form-select bg-white rounded-3 {{ $errors->has('firma_id') ? 'is-invalid' : '' }}"
                >
                        <option value='' selected>Selectează</option>
                    @foreach ($firme as $firma)
                        <option
                            value='{{ $firma->id }}'
                            {{ ($firma->id == old('firma_id', ($stingator->firma->id ?? ''))) ? 'selected' : '' }}
                        >{{ $firma->nume }} </option>
                    @endforeach
                </select>
            </div> --}}
            <input type="hidden" name="firma_id" value="{{ $firma->id }}">

            <div class="col-lg-2 mb-5">
                <label for="p1" class="mb-0 ps-3">P1</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('p1') ? 'is-invalid' : '' }}"
                    name="p1"
                    placeholder=""
                    value="{{ old('p1', $stingator->p1) }}">
            </div>
            <div class="col-lg-2 mb-5">
                <label for="p2" class="mb-0 ps-3">P2</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('p2') ? 'is-invalid' : '' }}"
                    name="p2"
                    placeholder=""
                    value="{{ old('p2', $stingator->p2) }}">
            </div>
            <div class="col-lg-2 mb-5">
                <label for="p3" class="mb-0 ps-3">P3</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('p3') ? 'is-invalid' : '' }}"
                    name="p3"
                    placeholder=""
                    value="{{ old('p3', $stingator->p3) }}">
            </div>
            <div class="col-lg-2 mb-5">
                <label for="p4" class="mb-0 ps-3">P4</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('p4') ? 'is-invalid' : '' }}"
                    name="p4"
                    placeholder=""
                    value="{{ old('p4', $stingator->p4) }}">
            </div>
            <div class="col-lg-2 mb-5">
                <label for="p5" class="mb-0 ps-3">P5</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('p5') ? 'is-invalid' : '' }}"
                    name="p5"
                    placeholder=""
                    value="{{ old('p5', $stingator->p5) }}">
            </div>
            <div class="col-lg-2 mb-5">
                <label for="p6" class="mb-0 ps-3">P6</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('p6') ? 'is-invalid' : '' }}"
                    name="p6"
                    placeholder=""
                    value="{{ old('p6', $stingator->p6) }}">
            </div>
            <div class="col-lg-2 mb-5">
                <label for="p9" class="mb-0 ps-3">P9</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('p9') ? 'is-invalid' : '' }}"
                    name="p9"
                    placeholder=""
                    value="{{ old('p9', $stingator->p9) }}">
            </div>
            <div class="col-lg-2 mb-5">
                <label for="p20" class="mb-0 ps-3">P20</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('p20') ? 'is-invalid' : '' }}"
                    name="p20"
                    placeholder=""
                    value="{{ old('p20', $stingator->p20) }}">
            </div>
            <div class="col-lg-2 mb-5">
                <label for="p50" class="mb-0 ps-3">P50</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('p50') ? 'is-invalid' : '' }}"
                    name="p50"
                    placeholder=""
                    value="{{ old('p50', $stingator->p50) }}">
            </div>
            <div class="col-lg-2 mb-5">
                <label for="p100" class="mb-0 ps-3">P100</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('p100') ? 'is-invalid' : '' }}"
                    name="p100"
                    placeholder=""
                    value="{{ old('p100', $stingator->p100) }}">
            </div>
            <div class="col-lg-2 mb-5">
                <label for="sm3" class="mb-0 ps-3">SM3</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('sm3') ? 'is-invalid' : '' }}"
                    name="sm3"
                    placeholder=""
                    value="{{ old('sm3', $stingator->sm3) }}">
            </div>
            <div class="col-lg-2 mb-5">
                <label for="sm6" class="mb-0 ps-3">SM6</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('sm6') ? 'is-invalid' : '' }}"
                    name="sm6"
                    placeholder=""
                    value="{{ old('sm6', $stingator->sm6) }}">
            </div>
            <div class="col-lg-2 mb-5">
                <label for="sm9" class="mb-0 ps-3">SM9</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('sm9') ? 'is-invalid' : '' }}"
                    name="sm9"
                    placeholder=""
                    value="{{ old('sm9', $stingator->sm9) }}">
            </div>
            <div class="col-lg-2 mb-5">
                <label for="sm50" class="mb-0 ps-3">SM50</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('sm50') ? 'is-invalid' : '' }}"
                    name="sm50"
                    placeholder=""
                    value="{{ old('sm50', $stingator->sm50) }}">
            </div>
            <div class="col-lg-2 mb-5">
                <label for="sm100" class="mb-0 ps-3">SM100</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('sm100') ? 'is-invalid' : '' }}"
                    name="sm100"
                    placeholder=""
                    value="{{ old('sm100', $stingator->sm100) }}">
            </div>
            <div class="col-lg-2 mb-5">
                <label for="g2" class="mb-0 ps-3">G2</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('g2') ? 'is-invalid' : '' }}"
                    name="g2"
                    placeholder=""
                    value="{{ old('g2', $stingator->g2) }}">
            </div>
            <div class="col-lg-2 mb-5">
                <label for="g5" class="mb-0 ps-3">G5</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('g5') ? 'is-invalid' : '' }}"
                    name="g5"
                    placeholder=""
                    value="{{ old('g5', $stingator->g5) }}">
            </div>
            <div class="col-lg-2 mb-5">
                <label for="stingatoare_expirare" class="mb-0 ps-3 pe-3">Stingătoare</label>
                <vue2-datepicker
                    data-veche="{{ old('stingatoare_expirare', ($stingator->stingatoare_expirare ?? '')) }}"
                    nume-camp-db="stingatoare_expirare"
                    tip="date"
                    value-type="YYYY-MM-DD"
                    format="DD-MM-YYYY"
                    :latime="{ width: '125px' }"
                ></vue2-datepicker>
                <small class="ps-xl-3">*data expirării</small>
            </div>
            <div class="col-lg-2 mb-5">
                <label for="hidranti" class="mb-0 ps-3">Hidranți</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('hidranti') ? 'is-invalid' : '' }}"
                    name="hidranti"
                    placeholder=""
                    value="{{ old('hidranti', $stingator->hidranti) }}">
            </div>
            <div class="col-lg-2 mb-5">
                <label for="hidranti_expirare" class="mb-0 ps-3 pe-3">Hidranți</label>
                <vue2-datepicker
                    data-veche="{{ old('hidranti_expirare', ($stingator->hidranti_expirare ?? '')) }}"
                    nume-camp-db="hidranti_expirare"
                    tip="date"
                    value-type="YYYY-MM-DD"
                    format="DD-MM-YYYY"
                    :latime="{ width: '125px' }"
                ></vue2-datepicker>
                <small class="ps-xl-3">*data expirării</small>
            </div>
            <div class="col-lg-12 mb-5">
                <label for="observatii" class="form-label mb-0 ps-3">Observații</label>
                <textarea class="form-control bg-white {{ $errors->has('observatii') ? 'is-invalid' : '' }}"
                    name="observatii" rows="2">{{ old('observatii', $stingator->observatii) }}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-2 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary text-white me-3 rounded-3">{{ $buttonText }}</button>
                <a class="btn btn-secondary rounded-3" href="{{ Session::get('stingatoare_return_url') }}">Renunță</a>
            </div>
        </div>
    </div>
</div>
