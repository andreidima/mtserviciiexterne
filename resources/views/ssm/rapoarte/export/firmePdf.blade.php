<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Firme</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        * {
            /* padding: 0;
            text-indent: 0; */
        }
        table{
            border-collapse:collapse;
            /* margin: 0px 0px; */
            /* margin-left: 5px; */
            margin-top: 0px;
            border-style: solid;
            border-width:0px;
            width: 100%;
            word-wrap:break-word;
            /* word-break: break-all; */
            /* table-layout: fixed; */
            page-break-inside: avoid;
        }
        th, td {
            padding: 5px 5px;
            border-width:1px;
            border-style: solid;
            table-layout:fixed;
            font-weight: normal;
        }
        tr {
            /* text-align:; */
            /* border-style: solid;
            border-width:1px; */
        }
        hr {
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 0.5px;
        }
        /* tr:nth-child(even) {background-color:lightgray;} */
    </style>
</head>

<body>
            <div style="
                width:700px;
                min-height:600px;
                padding: 0px 0px 0px 0px;
                margin:0px 0px;
                    -moz-border-radius: 10px;
                    -webkit-border-radius: 10px;
                    border-radius: 10px;">


                    @php
                        $lunaCurenta = \Carbon\Carbon::now()->month // Folosita la inrosirea textului din Luna SSM si PSI
                    @endphp

                @forelse ($firme->groupBy('traseu') as $firme_per_traseu)

                    <table>

                        @if ($loop->first)
                            <tr>
                                <td colspan="7">
                                    <div style="border:dashed #999; border-radius: 25px; padding:0px 20px">
                                        {{-- <h3 style="">
                                            MT Servicii Externe
                                        </h3> --}}

                                        <h2 style="text-align: center">
                                            Raport SSM - Firme
                                        </h2>

                                        {{-- <h3 style="text-align: center">
                                            @isset ($search_ssm_luna)
                                                SSM luna <u>{{ $search_ssm_luna }}</u> /
                                            @endisset
                                            @isset ($search_psi_luna)
                                                PSI luna <u>{{ $search_psi_luna }}</u> /
                                            @endisset
                                            Total firme =
                                                            <span class="badge bg-success fs-6 border border-white">
                                                                {{ $firme->count() }}
                                                            </span>
                                        </h3> --}}
                                    </div>

                                    <br><br>
                                </td>
                            </tr>
                        @endif)

                        <tr class="" style="padding:2rem; background-color:lightgrey">
                            <th colspan="7">
                                Traseu:
                                    <span class="badge bg-dark fs-6">
                                        {{ $firme_per_traseu->first()->traseu ?? '' }}
                                    </span>
                                    /
                                    Firme =
                                    <span class="badge bg-success fs-6">
                                        {{ $firme_per_traseu->count() }}
                                    </span>
                            </th>
                        </tr>
                        <tr class="" style="padding:2rem">
                            <th rowspan="2">#</th>
                            <th rowspan="2">Firma</th>
                            <th rowspan="2">CUI</th>
                            <th colspan="2" class="text-center">Luna</th>
                            <th colspan="2" class="text-center">Stare fișe</th>
                        </tr>
                        <tr>
                            <th>SSM</th>
                            <th>PSI</th>
                            <th>SSM</th>
                            <th>PSI</th>
                        </tr>

                        @forelse ($firme_per_traseu as $firma)
                            <tr>
                                <td align="right">
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $firma->nume ?? '' }}
                                </td>
                                <td>
                                    {{ $firma->cui ?? '' }}
                                </td>
                                <td>
                                    @php
                                        $ultimulNumarDinPerioada = null;
                                        if(preg_match_all('/\d+/', $firma->ssm_luna, $numere)){
                                            $ultimulNumarDinPerioada = (int)end($numere[0]);
                                        }
                                    @endphp
                                    @isset ($ultimulNumarDinPerioada)
                                        @if ($firma->perioada === 'LUNAR')
                                            @if ($ultimulNumarDinPerioada !== $lunaCurenta)
                                                <span style="font-size: 12px; color:red">{{ $firma->ssm_luna }}</span>
                                            @else
                                                {{ $firma->ssm_luna }}
                                            @endif
                                        @elseif (($firma->perioada === 'TRI') || ($firma->perioada === 'TRI.'))
                                            @if (
                                                    (
                                                        ($ultimulNumarDinPerioada < 10) // fiind perioada TRI, se calculeaza la 3 luni
                                                        &&
                                                        (
                                                            ( $ultimulNumarDinPerioada > $lunaCurenta ) // este cel putin de anul trecut
                                                            ||
                                                            ( ($ultimulNumarDinPerioada + 3) <= $lunaCurenta ) // au trecut minim 3 luni
                                                        )
                                                    )
                                                    ||
                                                    (
                                                        ($ultimulNumarDinPerioada >= 10) // fiind perioada TRI, se calculeaza la 3 luni
                                                        &&
                                                        ( ($ultimulNumarDinPerioada + 3)%12 <= $lunaCurenta ) // au trecut minim 3 luni
                                                    )
                                                )
                                                <span style="font-size: 12px; color:red">{{ $firma->ssm_luna }}</span>
                                            @else
                                                {{ $firma->ssm_luna }}
                                            @endif
                                        @elseif (($firma->perioada === 'SEM') || ($firma->perioada === 'SEM.'))
                                            @if (
                                                    (
                                                        ($ultimulNumarDinPerioada < 7) // fiind perioada SEM, se calculeaza la 6 luni
                                                        &&
                                                        (
                                                            ( $ultimulNumarDinPerioada > $lunaCurenta ) // este cel putin de anul trecut
                                                            ||
                                                            ( ($ultimulNumarDinPerioada + 6) <= $lunaCurenta ) // au trecut minim 6 luni
                                                        )
                                                    )
                                                    ||
                                                    (
                                                        ($ultimulNumarDinPerioada >= 7) // fiind perioada SEM, se calculeaza la 6 luni
                                                        &&
                                                        ( ($ultimulNumarDinPerioada + 6)%12 <= $lunaCurenta ) // au trecut minim 6 luni
                                                    )
                                                )
                                                <span style="font-size: 12px; color:red">{{ $firma->ssm_luna }}</span>
                                            @else
                                                {{ $firma->ssm_luna }}
                                            @endif
                                        @else
                                            {{ $firma->ssm_luna }}
                                        @endif
                                    @endisset
                                </td>
                                <td>
                                    @php
                                        $ultimulNumarDinPerioada = null;
                                        if(preg_match_all('/\d+/', $firma->psi_luna, $numere)){
                                            $ultimulNumarDinPerioada = (int)end($numere[0]);
                                        }
                                    @endphp
                                    @isset ($ultimulNumarDinPerioada)
                                        @if ($firma->perioada === 'LUNAR')
                                            @if ($ultimulNumarDinPerioada !== $lunaCurenta)
                                                <span style="font-size: 12px; color:red">{{ $firma->psi_luna }}</span>
                                            @else
                                                {{ $firma->psi_luna }}
                                            @endif
                                        @elseif (($firma->perioada === 'TRI') || ($firma->perioada === 'TRI.'))
                                            @if (
                                                    (
                                                        ($ultimulNumarDinPerioada < 10) // fiind perioada TRI, se calculeaza la 3 luni
                                                        &&
                                                        (
                                                            ( $ultimulNumarDinPerioada > $lunaCurenta ) // este cel putin de anul trecut
                                                            ||
                                                            ( ($ultimulNumarDinPerioada + 3) <= $lunaCurenta ) // au trecut minim 3 luni
                                                        )
                                                    )
                                                    ||
                                                    (
                                                        ($ultimulNumarDinPerioada >= 10) // fiind perioada TRI, se calculeaza la 3 luni
                                                        &&
                                                        ( ($ultimulNumarDinPerioada + 3)%12 <= $lunaCurenta ) // au trecut minim 3 luni
                                                    )
                                                )
                                                <span style="font-size: 12px; color:red">{{ $firma->psi_luna }}</span>
                                            @else
                                                {{ $firma->psi_luna }}
                                            @endif
                                        @elseif (($firma->perioada === 'SEM') || ($firma->perioada === 'SEM.'))
                                            @if (
                                                    (
                                                        ($ultimulNumarDinPerioada < 7) // fiind perioada SEM, se calculeaza la 6 luni
                                                        &&
                                                        (
                                                            ( $ultimulNumarDinPerioada > $lunaCurenta ) // este cel putin de anul trecut
                                                            ||
                                                            ( ($ultimulNumarDinPerioada + 6) <= $lunaCurenta ) // au trecut minim 6 luni
                                                        )
                                                    )
                                                    ||
                                                    (
                                                        ($ultimulNumarDinPerioada >= 7) // fiind perioada SEM, se calculeaza la 6 luni
                                                        &&
                                                        ( ($ultimulNumarDinPerioada + 6)%12 <= $lunaCurenta ) // au trecut minim 6 luni
                                                    )
                                                )
                                                <span style="font-size: 12px; color:red">{{ $firma->psi_luna }}</span>
                                            @else
                                                {{ $firma->psi_luna }}
                                            @endif
                                        @else
                                            {{ $firma->psi_luna }}
                                        @endif
                                    @else
                                        {{ $firma->psi_luna }}
                                    @endisset
                                </td>
                                <td>
                                    @if ((strpos($firma->ssm_stare_fise, 'noi.p;de s.p') !== false) ||
                                            (strpos($firma->ssm_stare_fise, 'noi.p;de s') !== false) ||
                                            (strpos($firma->ssm_stare_fise, 'noi;de s') !== false))
                                        <span style="font-size: 12px; color:blueviolet">
                                    @elseif ((strpos($firma->ssm_stare_fise, 'comp.la cl.') !== false))
                                        <span style="font-size: 12px; color:rgb(0, 145, 77)">
                                    @elseif ((strpos($firma->ssm_stare_fise, 'cl;de s') !== false) ||
                                            (strpos($firma->ssm_stare_fise, 'cl.p;de s') !== false) ||
                                            (strpos($firma->ssm_stare_fise, 'Fișe-C') !== false) ||
                                            (strpos($firma->ssm_stare_fise, 'cl;control') !== false))
                                        <span style="font-size: 12px; color:rgb(0, 96, 175)">
                                    @elseif ((strpos($firma->ssm_stare_fise, 'de adus') !== false))
                                        <span style="font-size: 12px; color:rgb(204, 0, 0)">
                                    @elseif ((strpos($firma->ssm_stare_fise, 'La anulate') !== false))
                                        <span style="font-size: 12px; color:rgb(94, 94, 94)">
                                    @else
                                        <span style="font-size: 12px;">
                                    @endif
                                        {{ $firma->ssm_stare_fise }}
                                        </span>
                                </td>
                                <td>
                                    @if ((strpos($firma->psi_stare_fise, 'noi.p;de s.p') !== false) ||
                                            (strpos($firma->psi_stare_fise, 'noi.p;de s') !== false) ||
                                            (strpos($firma->psi_stare_fise, 'noi;de s') !== false))
                                        <span style="font-size: 12px; color:blueviolet">
                                    @elseif ((strpos($firma->psi_stare_fise, 'comp.la cl.') !== false))
                                        <span style="font-size: 12px; color:rgb(0, 145, 77)">
                                    @elseif ((strpos($firma->psi_stare_fise, 'cl;de s') !== false) ||
                                            (strpos($firma->psi_stare_fise, 'cl.p;de s') !== false) ||
                                            (strpos($firma->psi_stare_fise, 'Fișe-C') !== false) ||
                                            (strpos($firma->psi_stare_fise, 'cl;control') !== false))
                                        <span style="font-size: 12px; color:rgb(0, 96, 175)">
                                    @elseif ((strpos($firma->psi_stare_fise, 'de adus') !== false))
                                        <span style="font-size: 12px; color:rgb(204, 0, 0)">
                                    @elseif ((strpos($firma->psi_stare_fise, 'La anulate') !== false))
                                        <span style="font-size: 12px; color:rgb(94, 94, 94)">
                                    @else
                                        <span style="font-size: 12px;">
                                    @endif
                                        {{ $firma->psi_stare_fise }}
                                        </span>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                </table>

                <br><br><br>

                @empty
                @endforelse


                {{-- Here's the magic. This MUST be inside body tag. Page count / total, centered at bottom of page --}}
                <script type="text/php">
                    if (isset($pdf)) {
                        $text = "Pagina {PAGE_NUM} / {PAGE_COUNT}";
                        $size = 10;
                        $font = $fontMetrics->getFont("DejaVu Sans");
                        $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                        $x = ($pdf->get_width() - $width) / 2;
                        $y = $pdf->get_height() - 35;
                        $pdf->page_text($x, $y, $text, $font, $size);
                    }
                </script>


            </div>




</body>

</html>
