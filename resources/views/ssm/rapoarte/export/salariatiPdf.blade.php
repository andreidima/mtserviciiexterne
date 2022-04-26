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

                <div style="border:dashed #999; border-radius: 25px; padding:0px 20px">
                    <h3 style="">
                        MT Servicii Externe
                    </h3>


                    <h2 style="text-align: center">
                        Raport SSM - Salariați
                    </h2>

                    <h3 style="text-align: center">
                        Data SSM/ PSI <u>{!! $data_ssm_psi === 'search_data_ssm_psi' ? '&nbsp;&nbsp;&nbsp;&nbsp;' : $data_ssm_psi !!}</u> /
                        Semnat SSM <u>{!! $semnat_ssm ?? '&nbsp;&nbsp;&nbsp;&nbsp;' !!}</u> /
                        Semnat PSI <u>{!! $semnat_psi ?? '&nbsp;&nbsp;&nbsp;&nbsp;' !!}</u> /
                        Total salariati =
                                        <span class="badge bg-success fs-6 border border-white">
                                            {{ $salariati->count() }}
                                        </span>
                    </h3>
                </div>

                <br><br><br><br>

                @forelse ($salariati->groupBy('nume_client') as $salariati_per_firma)

                    <table>
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
                                    {{ $salariat->salariat ?? '' }}
                                </td>
                                <td>
                                    {{ $salariat->functia ?? '' }}
                                </td>
                                <td>
                                    {{ $salariat->data_angajare ?? '' }}
                                </td>
                                <td>
                                    {{ $salariat->data_ssm_psi ?? '' }}
                                </td>
                                <td>
                                    {{ $salariat->semnat_ssm ?? '' }}
                                </td>
                                <td>
                                    {{ $salariat->semnat_psi ?? '' }}
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
