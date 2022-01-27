<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Medicina Muncii</title>
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

                {{-- <div style="border:dashed #999; border-radius: 25px; padding:0px 20px">
                    <h3 style="">
                        MT Servicii Externe
                    </h3>


                    <h2 style="text-align: center">
                        Raport Medicina Muncii pe luna {{ \Carbon\Carbon::parse($search_data)->isoFormat('MM.YYYY') }}
                    </h2>

                    <h3 style="text-align: center">
                        Total salariați =
                        {{ $salariati->count() }}

                    </h3>
                </div> --}}

                @forelse ($salariati->groupBy('firma_id') as $salariati_per_firma)
                    <table>
                        @if ($loop->first)
                        <tr>
                            <td colspan="4" style="border:0px">
                                <div style="border:dashed #999; border-radius: 25px; padding:0px 20px">
                                    <h3 style="">
                                        MT Servicii Externe
                                    </h3>


                                    <h2 style="text-align: center">
                                        Raport Medicina Muncii pe luna {{ \Carbon\Carbon::parse($search_data)->isoFormat('MM.YYYY') }}
                                    </h2>

                                    <h3 style="text-align: center">
                                        Total salariați =
                                        {{ $salariati->count() }}

                                    </h3>
                                </div>
                                <br><br><br><br>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="4" style="text-align:center; font-weight:bold">
                                {{ $salariati_per_firma->first()->firma->nume ?? '' }}
                                    / Telefon: {{ $salariati_per_firma->first()->firma->telefon ?? '' }}
                                    / Salariați = {{ $salariati_per_firma->count() }}
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center; font-weight:bold">
                                #
                            </td>
                            <td style="text-align:center; font-weight:bold">
                                Salariat
                            </td>
                            <td style="text-align:center; font-weight:bold">
                                CNP
                            </td>
                            <td style="text-align:center; font-weight:bold">
                                Următoarea examinare
                            </td>
                        </tr>
                            @forelse ($salariati_per_firma as $salariat)
                                <tr>
                                    <td width="5%" style="text-align: right">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td width="40%">
                                        {{ $salariat->nume }}
                                    </td>
                                    <td width="30%" style="text-align: center">
                                        {{ $salariat->cnp }}
                                    </td>
                                    <td width="25%" style="text-align: center">
                                        {{ $salariat->medicina_muncii_expirare ?
                                            \Carbon\Carbon::parse($salariat->medicina_muncii_expirare)->isoFormat('DD.MM.YYYY') : '' }}
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tr>
                    </table>
                    <br><br><br><br>
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
