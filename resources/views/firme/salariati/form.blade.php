@csrf

<div class="row mb-0 p-3 d-flex border-radius: 0px 0px 40px 40px" id="app">
    <div class="col-lg-12 mb-0">

        <div class="row mb-0">
            <div class="col-lg-4 mb-5">
                <label for="nume" class="mb-0 ps-3">Nume<span class="text-danger">*</span></label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume', $salariat->nume) }}"
                    required>
            </div>
            <div class="col-lg-4 mb-5">
                <label for="firma_id" class="mb-0 ps-3">Firma</label>
                <select name="firma_id"
                    class="form-select bg-white rounded-3 {{ $errors->has('firma_id') ? 'is-invalid' : '' }}"
                >
                        <option value='' selected>Selectează</option>
                    @foreach ($firme as $firma)
                        <option
                            value='{{ $firma->id }}'
                            {{ ($firma->id == old('firma_id', ($salariat->firma->id ?? $firma_curenta->id ?? ''))) ? 'selected' : '' }}
                        >{{ $firma->nume }} </option>
                    @endforeach
                </select>
            </div>
            {{-- <input type="hidden" name="firma_id" value="{{ $firma->id }}"> --}}

            <div class="col-lg-4 mb-5">
                <label for="cnp" class="mb-0 ps-3">CNP</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('cnp') ? 'is-invalid' : '' }}"
                    name="cnp"
                    placeholder=""
                    value="{{ old('cnp', $salariat->cnp) }}">
            </div>
            <div class="col-lg-4 mb-5">
                <label for="functie" class="mb-0 ps-3">Funcția</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('functie') ? 'is-invalid' : '' }}"
                    name="functie"
                    placeholder=""
                    value="{{ old('functie', $salariat->functie) }}">
            </div>
            <div class="col-lg-3 mb-5 d-flex justify-content-center">
                <div>
                    <label for="data_angajare" class="mb-0 ps-xxl-3">Dată Angajare</label>
                    <vue2-datepicker
                        data-veche="{{ old('data_angajare', ($salariat->data_angajare ?? '')) }}"
                        nume-camp-db="data_angajare"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                        :latime="{ width: '125px' }"
                    ></vue2-datepicker>
                </div>
            </div>
            <div class="col-lg-3 mb-5 d-flex justify-content-center">
                <div>
                    <label for="data_incetare" class="mb-0 ps-xxl-3">Dată Încetare</label>
                    <vue2-datepicker
                        data-veche="{{ old('data_incetare', ($salariat->data_incetare ?? '')) }}"
                        nume-camp-db="data_incetare"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                        :latime="{ width: '125px' }"
                    ></vue2-datepicker>
                </div>
            </div>
        </div>
        @if($serviciu == "medicina-muncii")
        <div class="row mb-0">
            <div class="col-lg-3 mb-5 d-flex justify-content-center">
                <div>
                    <label for="medicina_muncii_nr_inregistrare" class="mb-0 ps-xxl-3"><small>Medicina muncii</small></label>
                    <input
                        type="text"
                        class="form-control bg-white rounded-3 {{ $errors->has('medicina_muncii_nr_inregistrare') ? 'is-invalid' : '' }}"
                        name="medicina_muncii_nr_inregistrare"
                        placeholder=""
                        value="{{ old('medicina_muncii_nr_inregistrare', $salariat->medicina_muncii_nr_inregistrare) }}">
                    <small class="ps-3">*nr inregistrare</small>
                </div>
            </div>
            <div class="col-lg-3 mb-5 d-flex justify-content-center">
                <div>
                    <label for="medicina_muncii_examinare" class="mb-0 ps-xxl-3"><small>Medicina muncii</small></label>
                    <vue2-datepicker
                        data-veche="{{ old('medicina_muncii_examinare', ($salariat->medicina_muncii_examinare ?? '')) }}"
                        nume-camp-db="medicina_muncii_examinare"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                        :latime="{ width: '125px' }"
                    ></vue2-datepicker>
                    <small class="ps-3">*data examinare</small>
                </div>
            </div>
            <div class="col-lg-3 mb-5 d-flex justify-content-center">
                <div>
                    <label for="medicina_muncii_expirare" class="mb-0 ps-xxl-3"><small>Medicina muncii</small></label>
                    <vue2-datepicker
                        data-veche="{{ old('medicina_muncii_expirare', ($salariat->medicina_muncii_expirare ?? '')) }}"
                        nume-camp-db="medicina_muncii_expirare"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                        :latime="{ width: '125px' }"
                    ></vue2-datepicker>
                    <small class="ps-3">*data expirării</small>
                </div>
            </div>
            <div class="col-lg-3 mb-5 ps-5 d-flex align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="hidden" name="activ" value="0" />
                    <input class="form-check-input" type="checkbox" value="1" name="activ" id="activ"
                        {{ (old('activ', $salariat->activ) ?? 1) == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="activ">
                        Activ
                    </label>
                </div>
            </div>
        </div>
        @elseif($serviciu == "ssm")
        <div class="row mb-0">
            <div class="col-lg-2 mb-5">
                <label for="ssm_data_instructaj" class="mb-0 ps-3">SSM</label>
                <vue2-datepicker
                    data-veche="{{ old('ssm_data_instructaj', ($salariat->ssm_data_instructaj ?? '')) }}"
                    nume-camp-db="ssm_data_instructaj"
                    tip="date"
                    value-type="YYYY-MM-DD"
                    format="DD-MM-YYYY"
                    :latime="{ width: '125px' }"
                ></vue2-datepicker>
                <small class="ps-3">*dată instructaj</small>
            </div>
            <div class="col-lg-2 mb-5">
                <label for="ssm_instructaj_la_nr_luni" class="mb-0 ps-2">SSM <small>Instructaj la</small></label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('ssm_instructaj_la_nr_luni') ? 'is-invalid' : '' }}"
                    name="ssm_instructaj_la_nr_luni"
                    placeholder=""
                    value="{{ old('ssm_instructaj_la_nr_luni', $salariat->ssm_instructaj_la_nr_luni) }}">
                <small class="ps-3">*nr. de luni</small>
            </div>
            <div class="col-lg-2 mb-5">
                <label for="psi_data_instructaj" class="mb-0 ps-3">PSI</label>
                <vue2-datepicker
                    data-veche="{{ old('psi_data_instructaj', ($salariat->psi_data_instructaj ?? '')) }}"
                    nume-camp-db="psi_data_instructaj"
                    tip="date"
                    value-type="YYYY-MM-DD"
                    format="DD-MM-YYYY"
                    :latime="{ width: '125px' }"
                ></vue2-datepicker>
                <small class="ps-3">*dată instructaj</small>
            </div>
            <div class="col-lg-2 mb-5">
                <label for="psi_instructaj_la_nr_luni" class="mb-0 ps-2">PSI Instructaj la</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('psi_instructaj_la_nr_luni') ? 'is-invalid' : '' }}"
                    name="psi_instructaj_la_nr_luni"
                    placeholder=""
                    value="{{ old('psi_instructaj_la_nr_luni', $salariat->psi_instructaj_la_nr_luni) }}">
                <small class="ps-3">*nr. de luni</small>
            </div>
            <div class="col-lg-3 mb-5">
                <label for="anexa_ssm" class="mb-0 ps-3">Anexă SSM</label>
                <select name="anexa_ssm"
                    class="form-select bg-white rounded-3 {{ $errors->has('anexa_ssm') ? 'is-invalid' : '' }}"
                >
                    <option value='' selected>Selectează</option>
                    <option
                        value='1'
                        {{ (old('anexa_ssm', $salariat->anexa_ssm) == '1') ? 'selected' : '' }}
                    >Are Anexă</option>
                    <option
                        value='2'
                        {{ (old('anexa_ssm', $salariat->anexa_ssm) == '2') ? 'selected' : '' }}
                    >Are Anexă și este semnată</option>
                </select>
            </div>
            <div class="col-lg-3 mb-5">
                <label for="lista_eip" class="mb-0 ps-3">Listă EIP</label>
                <select name="lista_eip"
                    class="form-select bg-white rounded-3 {{ $errors->has('lista_eip') ? 'is-invalid' : '' }}"
                >
                    <option value='' selected>Selectează</option>
                    <option
                        value='1'
                        {{ (old('lista_eip', $salariat->lista_eip) == '1') ? 'selected' : '' }}
                    >Are Anexă</option>
                    <option
                        value='2'
                        {{ (old('lista_eip', $salariat->lista_eip) == '2') ? 'selected' : '' }}
                    >Are Anexă și este semnată</option>
                </select>
            </div>
            <div class="col-lg-3 mb-5">
                <label for="locatie_fisa_ssm" class="mb-0 ps-3">Locație fișă SSM:</label>
                <select name="locatie_fisa_ssm"
                    class="form-select bg-white rounded-3 {{ $errors->has('locatie_fisa_ssm') ? 'is-invalid' : '' }}"
                >
                    <option value='' selected>Selectează</option>
                    <option
                        value='1'
                        {{ (old('locatie_fisa_ssm', $salariat->locatie_fisa_ssm) == '1') ? 'selected' : '' }}
                    >La noi semnată</option>
                    <option
                        value='2'
                        {{ (old('locatie_fisa_ssm', $salariat->locatie_fisa_ssm) == '2') ? 'selected' : '' }}
                    >La noi de semnat</option>
                    <option
                        value='3'
                        {{ (old('locatie_fisa_ssm', $salariat->locatie_fisa_ssm) == '3') ? 'selected' : '' }}
                    >La client de semnat</option>
                    <option
                        value='4'
                        {{ (old('locatie_fisa_ssm', $salariat->locatie_fisa_ssm) == '4') ? 'selected' : '' }}
                    >CCC</option>
                </select>
            </div>
            <div class="col-lg-3 mb-5">
                <label for="locatie_fisa_su" class="mb-0 ps-3">Locație fisă SU:</label>
                <select name="locatie_fisa_su"
                    class="form-select bg-white rounded-3 {{ $errors->has('locatie_fisa_su') ? 'is-invalid' : '' }}"
                >
                    <option value='' selected>Selectează</option>
                    <option
                        value='1'
                        {{ (old('locatie_fisa_su', $salariat->locatie_fisa_su) == '1') ? 'selected' : '' }}
                    >la noi</option>
                    <option
                        value='0'
                        {{ (old('locatie_fisa_su', $salariat->locatie_fisa_su) == '0') ? 'selected' : '' }}
                    >la ei</option>
                </select>
            </div>
            <div class="col-lg-3 mb-5 ps-5 d-flex align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="hidden" name="suspendat" value="0" />
                    <input class="form-check-input" type="checkbox" value="1" name="suspendat" id="suspendat"
                        {{ (old('suspendat', $salariat->suspendat) == '1') ? 'checked' : '' }}>
                    <label class="form-check-label" for="suspendat">
                        Suspendat
                    </label>
                </div>
            </div>
        </div>
        @endif
        <div class="row mb-0">
            <div class="col-lg-12 mb-5">
                <label for="observatii" class="form-label mb-0 ps-3">Observații</label>
                <textarea class="form-control bg-white {{ $errors->has('observatii') ? 'is-invalid' : '' }}"
                    name="observatii" rows="2">{{ old('observatii', $salariat->observatii) }}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-2 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary text-white me-3 rounded-3">{{ $buttonText }}</button>
                <a class="btn btn-secondary rounded-3" href="{{ Session::get('salariat_return_url') }}">Renunță</a>
            </div>
        </div>
    </div>
</div>
