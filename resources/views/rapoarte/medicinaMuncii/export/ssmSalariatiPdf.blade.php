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
                    border-radius: 10px;
                page-break-inside: avoid;
            ">

                <h3 style="text-align: center; margin:0px;">
                    MT Servicii Externe
                </h3>
                <h2 style="text-align: center; margin:0px;">
                    Raport Salariați SSM
                </h2>
                <br>
                <br>

                @forelse ($salariati as $salariat)
                    @if ($loop->first)
                        <table>
                            <thead>
                                <tr>
                                    <th><b>#</b></th>
                                    <th><b>Firma</b></th>
                                    <th><b>Salariat</b></th>
                                    <th><b>CNP</b></th>
                                    <th><b>Funcția</b></th>
                                    <th><b>Data angajare</b></th>
                                    <th><b>Data încetare</b></th>
                                    <th><b>Medicina Muncii</b></th>
                                </tr>
                            </thead>
                            <tbody>
                    @endif
                            <tr>
                                <td align="">
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $salariat->nume_client ?? '' }}
                                </td>
                                <td>
                                    {{ $salariat->salariat ?? '' }}
                                </td>
                                <td>
                                    {{ $salariat->cnp ?? '' }}
                                </td>
                                <td>
                                    {{ $salariat->functia ?? '' }}
                                </td>
                                <td>
                                    {{ $salariat->data_angajare ?? '' }}
                                </td>
                                <td>
                                    {{ $salariat->data_incetare ?? '' }}
                                </td>
                                <td>
                                    {{ $salariat->med_muncii ?? '' }}
                                </td>
                            </tr>
                    @if ($loop->last)
                            </tbody>
                        </table>
                    @endif
                @empty
                    {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
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
