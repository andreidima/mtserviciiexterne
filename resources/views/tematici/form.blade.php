@csrf

<div class="row mb-0 p-3 d-flex border-radius: 0px 0px 40px 40px" id="app">
    <div class="col-lg-12 mb-0">

        <div class="row mb-0">
            <div class="col-lg-9 mb-5 mx-auto">
                <label for="nume" class="mb-0 ps-3">Nume<span class="text-danger">*</span></label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume', $tematica->nume) }}"
                    required>
            </div>
            <div class="col-lg-3 mb-5 mx-auto">
                <label for="tip" class="mb-0 ps-3">Tip:</label>
                <select name="tip"
                    class="form-select bg-white rounded-3 {{ $errors->has('tip') ? 'is-invalid' : '' }}"
                >
                    <option value='' selected>Selectează</option>
                    <option
                        value='0'
                        {{ (old('tip', $tematica->tip) == '0') ? 'selected' : '' }}
                    >SU</option>
                    <option
                        value='1'
                        {{ (old('tip', $tematica->tip) == '1') ? 'selected' : '' }}
                    >SSM</option>
                </select>
            </div>
            <div class="col-lg-12 mb-5 mx-auto">
                <label for="descriere" class="form-label mb-0 ps-3">Descriere</label>
                <textarea class="form-control bg-white {{ $errors->has('descriere') ? 'is-invalid' : '' }}"
                    name="descriere" rows="2">{{ old('descriere', $tematica->descriere) }}</textarea>
            </div>
            <div class="col-lg-12 mb-5">
                <label for="file" class="form-label mb-0 ps-3">Adaugă fișiere</label>
                <input type="file" name="fisiere[]" class="form-control rounded-3" multiple>
                @if($errors->has('fisiere'))
                <span class="help-block text-danger">{{ $errors->first('fisiere') }}</span>
                @endif
            </div>
            <div class="col-lg-12 mb-5 mx-auto">
                <label for="observatii" class="form-label mb-0 ps-3">Observații</label>
                <textarea class="form-control bg-white {{ $errors->has('observatii') ? 'is-invalid' : '' }}"
                    name="observatii" rows="2">{{ old('observatii', $tematica->observatii) }}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-2 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary text-white me-3 rounded-3">{{ $buttonText }}</button>
                <a class="btn btn-secondary rounded-3" href="/tematici">Renunță</a>
            </div>
        </div>
    </div>
</div>
