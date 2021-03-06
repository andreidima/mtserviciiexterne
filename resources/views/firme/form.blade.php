@csrf

<div class="row mb-0 p-3 d-flex border-radius: 0px 0px 40px 40px" id="app">
    <div class="col-lg-12 mb-0">

        <div class="row mb-0">
            <div class="col-lg-6 mb-5 mx-auto">
                <label for="nume" class="mb-0 ps-3">Nume<span class="text-danger">*</span></label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume', $firma->nume) }}"
                    required>
            </div>
            <div class="col-lg-3 mb-5 mx-auto">
                <label for="cod_fiscal" class="mb-0 ps-3">Cod fiscal</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('cod_fiscal') ? 'is-invalid' : '' }}"
                    name="cod_fiscal"
                    placeholder=""
                    value="{{ old('cod_fiscal', $firma->cod_fiscal) }}">
            </div>
            <div class="col-lg-3 mb-5 mx-auto">
                <label for="domeniu_de_activitate_id" class="mb-0 ps-3">Domeniu de activitate</label>
                <select name="domeniu_de_activitate_id"
                    class="form-select bg-white rounded-3 {{ $errors->has('domeniu_de_activitate_id') ? 'is-invalid' : '' }}"
                >
                        <option value='' selected>Selectează</option>
                    @foreach ($domenii_de_activitate as $domeniu_de_activitate)
                        <option
                            value='{{ $domeniu_de_activitate->id }}'
                            {{ ($domeniu_de_activitate->id == old('domeniu_de_activitate_id', $firma->domeniu_de_activitate->id ?? '')) ? 'selected' : '' }}
                        >{{ $domeniu_de_activitate->nume }} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-6 mb-5 mx-auto">
                <label for="adresa" class="mb-0 ps-3">Adresa</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('adresa') ? 'is-invalid' : '' }}"
                    name="adresa"
                    placeholder=""
                    value="{{ old('adresa', $firma->adresa) }}">
            </div>
            <div class="col-lg-3 mb-5 mx-auto">
                <label for="localitate" class="mb-0 ps-3">Localitate</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('localitate') ? 'is-invalid' : '' }}"
                    name="localitate"
                    placeholder=""
                    value="{{ old('localitate', $firma->localitate) }}">
            </div>
            <div class="col-lg-3 mb-5 mx-auto">
                <label for="judet" class="mb-0 ps-3">Județ</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('judet') ? 'is-invalid' : '' }}"
                    name="judet"
                    placeholder=""
                    value="{{ old('judet', $firma->judet) }}">
            </div>
            <div class="col-lg-3 mb-5 mx-auto">
                <label for="telefon" class="mb-0 ps-3">Telefon</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('telefon') ? 'is-invalid' : '' }}"
                    name="telefon"
                    placeholder=""
                    value="{{ old('telefon', $firma->telefon) }}">
            </div>
            <div class="col-lg-3 mb-5 mx-auto">
                <label for="email" class="mb-0 ps-3">Email</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    name="email"
                    placeholder=""
                    value="{{ old('email', $firma->email) }}">
            </div>
            <div class="col-lg-3 mb-5 mx-auto">
                <label for="nume_administrator" class="mb-0 ps-3">Nume administrator</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('nume_administrator') ? 'is-invalid' : '' }}"
                    name="nume_administrator"
                    placeholder=""
                    value="{{ old('nume_administrator', $firma->nume_administrator) }}">
            </div>
            <div class="col-lg-3 mb-5 mx-auto">
                <label for="angajat_desemnat" class="mb-0 ps-3">Angajat desemnat</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('angajat_desemnat') ? 'is-invalid' : '' }}"
                    name="angajat_desemnat"
                    placeholder=""
                    value="{{ old('angajat_desemnat', $firma->angajat_desemnat) }}">
            </div>
            <div class="col-lg-3 mb-5 mx-auto">
                <label for="data" class="mb-0 ps-xxl-3">Buletin pram</label>
                    <vue2-datepicker
                        data-veche="{{ old('buletin_pram_expirare', ($firma->buletin_pram_expirare ?? '')) }}"
                        nume-camp-db="buletin_pram_expirare"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                        :latime="{ width: '125px' }"
                    ></vue2-datepicker>
                <small class="ps-3">*data expirare</small>
            </div>
            <div class="col-lg-3 mb-5 ps-5 mx-auto d-flex align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="hidden" name="iscir" value="0" />
                    <input class="form-check-input" type="checkbox" value="1" name="iscir" id="iscir"
                        {{ old('iscir', $firma->iscir) == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="iscir">
                        ISCIR
                    </label>
                </div>
            </div>
            <div class="col-lg-6 mb-5 mx-auto">
                <label for="iscir_descriere" class="form-label mb-0 ps-3">ISCIR descriere</label>
                <textarea class="form-control bg-white {{ $errors->has('iscir_descriere') ? 'is-invalid' : '' }}"
                    name="iscir_descriere" rows="2">{{ old('iscir_descriere', $firma->iscir_descriere) }}</textarea>
            </div>
            <div class="col-lg-3 mb-5 mx-auto">
                <label for="actionar" class="mb-0 ps-3">Acționar</label>
                <select name="actionar"
                    class="form-select bg-white rounded-3 {{ $errors->has('actionar') ? 'is-invalid' : '' }}"
                >
                    <option value='' selected>Selectează</option>
                    <option value='2' {{ (old('actionar', $firma->actionar) == 2) ? 'selected' : '' }}> Catalin </option>
                    <option value='1' {{ (old('actionar', $firma->actionar) == 1) ? 'selected' : '' }}> Ionut </option>
                </select>
            </div>
            <div class="col-lg-3 mb-5 mx-auto">
                <label for="traseu_id" class="mb-0 ps-3">Traseu</label>
                <select name="traseu_id"
                    class="form-select bg-white rounded-3 {{ $errors->has('traseu_id') ? 'is-invalid' : '' }}"
                >
                        <option value='' selected>Selectează</option>
                    @foreach ($trasee as $traseu)
                        <option
                            value='{{ $traseu->id }}'
                            {{ ($traseu->id == old('traseu_id', $firma->traseu->id ?? '')) ? 'selected' : '' }}
                        >{{ $traseu->nume }} </option>
                    @endforeach
                </select>
            </div>
            {{-- <div class="col-lg-3 mb-5 mx-auto">
                <label for="traseu_ordine" class="mb-0 ps-3">Ordine în traseu</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('traseu_ordine') ? 'is-invalid' : '' }}"
                    name="traseu_ordine"
                    placeholder=""
                    value="{{ old('traseu_ordine', $firma->traseu_ordine) }}">
            </div> --}}
            <div class="col-lg-6 mb-5 mx-auto">
                <label for="observatii" class="form-label mb-0 ps-3">Observații</label>
                <textarea class="form-control bg-white {{ $errors->has('observatii') ? 'is-invalid' : '' }}"
                    name="observatii" rows="2">{{ old('observatii', $firma->observatii) }}</textarea>
            </div>
        </div>
        @if($serviciu == "ssm")
            <div class="row mb-0">
                <div class="col-lg-3 mb-5 mx-auto">
                    <label for="contract_firma" class="mb-0 ps-3">Contract firma</label>
                    <input
                        type="text"
                        class="form-control bg-white rounded-3 {{ $errors->has('contract_firma') ? 'is-invalid' : '' }}"
                        name="contract_firma"
                        placeholder=""
                        value="{{ old('contract_firma', $firma->contract_firma) }}">
                </div>
                <div class="col-lg-3 mb-5 mx-auto">
                    <label for="contract_numar" class="mb-0 ps-3">Contract număr</label>
                    <input
                        type="text"
                        class="form-control bg-white rounded-3 {{ $errors->has('contract_numar') ? 'is-invalid' : '' }}"
                        name="contract_numar"
                        placeholder=""
                        value="{{ old('contract_numar', $firma->contract_numar) }}">
                </div>
                <div class="col-lg-3 mb-5 mx-auto">
                    <label for="contract_valoare" class="mb-0 ps-3">Contract valoare</label>
                    <input
                        type="text"
                        class="form-control bg-white rounded-3 {{ $errors->has('contract_valoare') ? 'is-invalid' : '' }}"
                        name="contract_valoare"
                        placeholder=""
                        value="{{ old('contract_valoare', $firma->contract_valoare) }}">
                </div>
                <div class="col-lg-3 mb-5 mx-auto">
                    <label for="documentatie" class="form-label mb-0 ps-3">Documentație</label>
                    <textarea class="form-control bg-white {{ $errors->has('documentatie') ? 'is-invalid' : '' }}"
                        name="documentatie" rows="2">{{ old('documentatie', $firma->documentatie) }}</textarea>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12 mb-2 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary text-white me-3 rounded-3">{{ $buttonText }}</button>
                <a class="btn btn-secondary rounded-3" href="{{ Session::get('firma_return_url') }}">Renunță</a>
            </div>
        </div>
    </div>
</div>
