<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Hidranti</title>
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
                        Raport Hidranți pe luna {{ \Carbon\Carbon::parse($search_data)->isoFormat('MM.YYYY') }}
                    </h2>

                    <h3 style="text-align: center">
                        Total hidranți =
                        {{ $hidranti->sum('hidranti') }}

                    </h3>
                </div>

                <br><br><br><br>

                @forelse ($hidranti->groupBy('firma.traseu_id') as $hidranti_per_traseu)

                    <table>
                        <tr class="" style="padding:2rem; background-color:lightgrey">
                            <th colspan="4">
                                Traseu: <b>{{ $hidranti_per_traseu->first()->firma->traseu->nume ?? '' }}</b>
                                /
                                Hidranti =
                                    <b>
                                    {{ $hidranti_per_traseu->sum('hidranti') }}
                                    </b>
                            </th>
                        </tr>
                        <tr class="" style="padding:2rem">
                            <th width="6%">#</th>
                            <th width="55%">Firma</th>
                            <th width="13%">Telefon</th>
                            <th width="20%">Hidranți</th>
                        </tr>

                        @forelse ($hidranti_per_traseu as $hidrant)
                            <tr>
                                <td align="right">
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $hidrant->firma->nume ?? '' }}
                                </td>
                                <td align="center">
                                    {{ $hidrant->firma->telefon ?? '' }}
                                </td>
                                <td align="right">
                                    <span class="badge fs-6 bg-success">
                                        {{
                                            $hidrant->hidranti
                                        }}
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
