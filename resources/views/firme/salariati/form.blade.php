@csrf

<div class="row mb-0 p-3 d-flex border-radius: 0px 0px 40px 40px" id="app">
    <div class="col-lg-12 mb-0">

        <div class="row p-2 mb-0">
            <div class="col-lg-10 mb-2 mx-auto">
                <label for="firma_id" class="mb-0 ps-3">Firma:</label>
                <select name="firma_id"
                    class="form-select form-select-sm rounded-pill {{ $errors->has('firma_id') ? 'is-invalid' : '' }}"
                >
                        <option value='' selected>Selectează</option>
                    @foreach ($firme as $firma)
                        <option
                            value='{{ $firma->id }}'
                            {{ ($firma->id == old('firma_id', $firma->firma->id ?? '')) ? 'selected' : '' }}
                        >{{ $firma->nume }} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-10 mb-2 mx-auto">
                <label for="nume" class="mb-0 ps-3">Nume*:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume', $salariat->nume) }}"
                    required>
            </div>
            <div class="col-lg-10 mb-2 mx-auto">
                <label for="cnp" class="mb-0 ps-3">CNP:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('cnp') ? 'is-invalid' : '' }}"
                    name="cnp"
                    placeholder=""
                    value="{{ old('cnp', $salariat->cnp) }}">
            </div>
            <div class="col-lg-10 mb-2 mx-auto">
                <label for="functia" class="mb-0 ps-3">Funcția:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('functia') ? 'is-invalid' : '' }}"
                    name="functia"
                    placeholder=""
                    value="{{ old('functia', $salariat->functia) }}">
            </div>
            <div class="col-lg-10 mb-2 mx-auto">
                <label for="data_angajare" class="mb-0 ps-3">Angajare:</label>
                <vue2-datepicker
                    data-veche="{{ old('data_angajare', ($firma->data_angajare ?? '')) }}"
                    nume-camp-db="data_angajare"
                    tip="date"
                    value-type="YYYY-MM-DD"
                    format="DD-MM-YYYY"
                    :latime="{ width: '125px' }"
                ></vue2-datepicker>
            </div>
            <div class="col-lg-10 mb-2 mx-auto">
                <label for="data_incetare" class="mb-0 ps-3">Încetare:</label>
                <vue2-datepicker
                    data-veche="{{ old('data_incetare', ($firma->data_incetare ?? '')) }}"
                    nume-camp-db="data_incetare"
                    tip="date"
                    value-type="YYYY-MM-DD"
                    format="DD-MM-YYYY"
                    :latime="{ width: '125px' }"
                ></vue2-datepicker>
            </div>
            <div class="col-lg-10 mb-2 mx-auto">
                <label for="tip_instructaj" class="mb-0 ps-3">Tip instructaj:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('tip_instructaj') ? 'is-invalid' : '' }}"
                    name="tip_instructaj"
                    placeholder=""
                    value="{{ old('tip_instructaj', $salariat->tip_instructaj) }}">
            </div>
            <div class="col-lg-10 mb-2 mx-auto">
                <label for="data_instructaj" class="mb-0 ps-3">Instructaj:</label>
                <vue2-datepicker
                    data-veche="{{ old('data_instructaj', ($firma->data_instructaj ?? '')) }}"
                    nume-camp-db="data_instructaj"
                    tip="date"
                    value-type="YYYY-MM-DD"
                    format="DD-MM-YYYY"
                    :latime="{ width: '125px' }"
                ></vue2-datepicker>
            </div>
            <div class="form-check col-lg-10 mb-2 ps-5 mx-auto">
                <input type="hidden" name="anexa_ssm" value="false" />
                <input class="form-check-input" type="checkbox" value="true" name="anexa_ssm" id=""
                    {{ old('anexa_ssm', $firma->anexa_ssm) == 'true' ? 'checked' : '' }}>
                <label class="form-check-label" for="anexa_ssm">
                    Anexa SSM
                </label>
            </div>
            <div class="form-check col-lg-10 mb-2 ps-5 mx-auto">
                <input type="hidden" name="lista_eip" value="false" />
                <input class="form-check-input" type="checkbox" value="true" name="lista_eip" id=""
                    {{ old('lista_eip', $firma->lista_eip) == 'true' ? 'checked' : '' }}>
                <label class="form-check-label" for="lista_eip">
                    Lista EIP
                </label>
            </div>
            <div class="col-lg-10 mb-2 mx-auto">
                <label for="medicina_muncii_expirare" class="mb-0 ps-3">Medicina muncii expirare:</label>
                <vue2-datepicker
                    data-veche="{{ old('medicina_muncii_expirare', ($firma->medicina_muncii_expirare ?? '')) }}"
                    nume-camp-db="medicina_muncii_expirare"
                    tip="date"
                    value-type="YYYY-MM-DD"
                    format="DD-MM-YYYY"
                    :latime="{ width: '125px' }"
                ></vue2-datepicker>
            </div>
            <div class="col-lg-10 mb-2 mx-auto">
                <label for="locatie_fisa_ssm" class="mb-0 ps-3">Locație fișă SSM:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('locatie_fisa_ssm') ? 'is-invalid' : '' }}"
                    name="locatie_fisa_ssm"
                    placeholder=""
                    value="{{ old('locatie_fisa_ssm', $salariat->locatie_fisa_ssm) }}">
            </div>
            <div class="col-lg-10 mb-2 mx-auto">
                <label for="locatie_fisa_su" class="mb-0 ps-3">Locație fisă SU:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('locatie_fisa_su') ? 'is-invalid' : '' }}"
                    name="locatie_fisa_su"
                    placeholder=""
                    value="{{ old('locatie_fisa_su', $salariat->locatie_fisa_su) }}">
            </div>
        </div>

        <div class="row p-2">
            <div class="col-lg-12 py-3 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary text-white btn-sm me-2 rounded-pill">{{ $buttonText }}</button>
                <a class="btn btn-secondary btn-sm rounded-pill" href="/firme/salariati">Renunță</a>
            </div>
        </div>
    </div>
</div>
