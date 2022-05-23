<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Salariați</title>
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

                @forelse ($salariati->groupBy('nume_client') as $salariati_per_firma)

                    <table>

                        @if ($loop->first)
                            <tr>
                                <td colspan="7">
                                    <div style="border:dashed #999; border-radius: 25px; padding:0px 20px">
                                        <h3 style="">
                                            MT Servicii Externe
                                        </h3>


                                        <h2 style="text-align: center">
                                            Raport SSM - Salariați
                                        </h2>

                                        <h3 style="text-align: center">
                                            {{-- Data SSM/ PSI <u>{!! $data_ssm_psi === 'search_data_ssm_psi' ? '&nbsp;&nbsp;&nbsp;&nbsp;' : $data_ssm_psi !!}</u> /
                                            Semnat SSM <u>{!! $semnat_ssm ?? '&nbsp;&nbsp;&nbsp;&nbsp;' !!}</u> /
                                            Semnat PSI <u>{!! $semnat_psi ?? '&nbsp;&nbsp;&nbsp;&nbsp;' !!}</u> / --}}
                                            @isset ($search_data_ssm_psi)
                                                Data SSM/ PSI <u>{{ $search_data_ssm_psi }}</u> /
                                            @endisset
                                            @isset ($search_semnat_ssm)
                                                Semnat SSM <u>{{ $search_semnat_ssm }}</u> /
                                            @endisset
                                            @isset ($search_semnat_psi)
                                                Semnat PSI <u>{{ $search_semnat_psi }}</u> /
                                            @endisset
                                            @isset ($search_firma)
                                                Firma <u>{{ $search_firma }}</u> /
                                            @endisset
                                            Total salariati =
                                                            <span class="badge bg-success fs-6 border border-white">
                                                                {{ $salariati->count() }}
                                                            </span>
                                        </h3>
                                    </div>

                                    <br><br><br><br>
                                </td>
                            </tr>
                        @endif

                        <tr class="" style="padding:2rem; background-color:lightgrey">
                            <th colspan="7">
                                Firma:
                                    <span class="badge bg-dark fs-6">
                                        {{ $salariati_per_firma->first()->nume_client ?? '' }}
                                    </span>
                                    /
                                    Salariați =
                                    <span class="badge bg-success fs-6">
                                        {{ $salariati_per_firma->count() }}
                                    </span>
                            </th>
                        </tr>
                        <tr class="" style="padding:2rem">
                            <th rowspan="2">#</th>
                            <th rowspan="2">Salariat</th>
                            <th rowspan="2">Funcția</th>
                            <th rowspan="2">Data angajării</th>
                            <th rowspan="2">Data SSM/ PSI</th>
                            <th colspan="2" class="text-center">Semnat</th>
                        </tr>
                        <tr>
                            <th>SSM</th>
                            <th>PSI</th>
                        </tr>

                        @forelse ($salariati_per_firma as $salariat)
                            <tr>
                                <td align="">
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    @if (stripos($salariat->salariat, '3 luni') !== false)
                                        {!! str_replace("3 luni", "<span style='font-size: 12px; color:rgb(0, 140, 255)'>3 luni</span>", $salariat->salariat) !!}
                                    @elseif (stripos($salariat->salariat, '3luni') !== false)
                                        {!! str_replace("3luni", "<span style='font-size: 12px; color:rgb(0, 140, 255)'>3luni</span>", $salariat->salariat) !!}
                                    @elseif (stripos($salariat->salariat, '6 luni') !== false)
                                        {!! str_replace("6 luni", "<span style='font-size: 12px; color:rgb(0, 140, 255)'>6 luni</span>", $salariat->salariat) !!}
                                    @elseif (stripos($salariat->salariat, '6luni') !== false)
                                        {!! str_replace("6luni", "<span style='font-size: 12px; color:rgb(0, 140, 255)'>6luni</span>", $salariat->salariat) !!}
                                    @else
                                        {!! $salariat->salariat !!}
                                    @endif
                                </td>
                                <td>
                                    @php
                                        if (stripos($salariat->functia, 'adm.') !== false){
                                            $salariat->functia = str_replace("adm.", "<span style='font-size: 12px; color:blueviolet'>adm.</span>", $salariat->functia);
                                        } elseif (stripos($salariat->functia, 'adm') !== false){
                                            $salariat->functia = str_replace("adm", "<span style='font-size: 12px; color:blueviolet'>adm</span>", $salariat->functia);
                                        }
                                        $salariat->functia = str_replace("pers. des.", "<span style='font-size: 12px; color:blueviolet'>pers. des.</span>", $salariat->functia);
                                    @endphp
                                    {!! $salariat->functia !!}
                                </td>
                                <td>
                                    {{ $salariat->data_angajare ?? '' }}
                                </td>
                                <td>
                                    {{ $salariat->data_ssm_psi ?? '' }}
                                </td>
                                <td style="font-size: 12px; padding:1px;">
                                    @if (stripos($salariat->semnat_ssm, 'client') !== false)
                                        <span style="font-size: 12px; color:rgb(0, 140, 255)">
                                    @elseif (stripos($salariat->semnat_ssm, 'Lipsa') !== false)
                                        <span style="font-size: 12px; color:rgb(255, 0, 0)">
                                    @elseif (stripos($salariat->semnat_ssm, 'comp.la cl.') !== false)
                                        <span style="font-size: 12px; color:rgb(0, 180, 75)">
                                    @elseif (stripos($salariat->semnat_ssm, 'n.de s') !== false)
                                        <span style="font-size: 12px; color:blueviolet">
                                    @else
                                        <span style="font-size: 12px; color:rgb(0, 0, 0)">
                                    @endif
                                            {{ $salariat->semnat_ssm }}
                                        </span>
                                </td>
                                <td style="font-size: 12px; padding:1px;">
                                    @if (stripos($salariat->semnat_psi, 'client') !== false)
                                        <span style="font-size: 12px; color:rgb(0, 140, 255)">
                                    @elseif (stripos($salariat->semnat_psi, 'Lipsa') !== false)
                                        <span style="font-size: 12px; color:rgb(255, 0, 0)">
                                    @elseif (stripos($salariat->semnat_psi, 'comp.la cl.') !== false)
                                        <span style="font-size: 12px; color:rgb(0, 180, 75)">
                                    @elseif (stripos($salariat->semnat_psi, 'n.de s') !== false)
                                        <span style="font-size: 12px; color:blueviolet">
                                    @else
                                        <span style="font-size: 12px; color:rgb(0, 0, 0)">
                                    @endif
                                            {{ $salariat->semnat_psi }}
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
