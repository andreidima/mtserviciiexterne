<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Stingatoare</title>
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
                width:690px;
                min-height:600px;
                padding: 15px 10px 15px 10px;
                margin:0px 0px;
                    -moz-border-radius: 10px;
                    -webkit-border-radius: 10px;
                    border-radius: 10px;">

                <div style="border:dashed #999; border-radius: 25px; padding:0px 20px">
                    <h3 style="">
                        MT Servicii Externe
                    </h3>


                    <h2 style="text-align: center">
                        Raport Stingătoare pe luna {{ \Carbon\Carbon::parse($search_data)->isoFormat('MM.YYYY') }}
                    </h2>

                    <h3 style="text-align: center">
                        Total stingătoare =
                        {{ $stingatoare->sum('p1') + $stingatoare->sum('p2') + $stingatoare->sum('p3') + $stingatoare->sum('p4') + $stingatoare->sum('p5') + $stingatoare->sum('p6') + $stingatoare->sum('p9') + $stingatoare->sum('p20') + $stingatoare->sum('p50') +
                            $stingatoare->sum('p100') + $stingatoare->sum('sm3') + $stingatoare->sum('sm6') + $stingatoare->sum('sm9') + $stingatoare->sum('sm50') + $stingatoare->sum('sm100') + $stingatoare->sum('g2') + $stingatoare->sum('g5') }}

                    </h3>
                </div>

                <br><br><br><br>

                @forelse ($stingatoare->groupBy('firma.traseu_id') as $stingatoare_per_traseu)

                    <table>
                        <tr class="" style="padding:2rem">
                            <th colspan="5">
                                Traseu: <b>{{ $stingatoare_per_traseu->first()->firma->traseu->nume ?? '' }}</b>
                                /
                                Stingatoare =
                                    <b>
                                    {{ $stingatoare_per_traseu->sum('p1') + $stingatoare_per_traseu->sum('p2') + $stingatoare_per_traseu->sum('p3') + $stingatoare_per_traseu->sum('p4') + $stingatoare_per_traseu->sum('p5') + $stingatoare_per_traseu->sum('p6') + $stingatoare_per_traseu->sum('p9') + $stingatoare_per_traseu->sum('p20') + $stingatoare_per_traseu->sum('p50') +
                                        $stingatoare_per_traseu->sum('p100') + $stingatoare_per_traseu->sum('sm3') + $stingatoare_per_traseu->sum('sm6') + $stingatoare_per_traseu->sum('sm9') + $stingatoare_per_traseu->sum('sm50') + $stingatoare_per_traseu->sum('sm100') + $stingatoare_per_traseu->sum('g2') + $stingatoare_per_traseu->sum('g5') }}
                                    </b>
                            </th>
                        </tr>
                        <tr class="" style="padding:2rem">
                            <th width="6%">#</th>
                            <th width="55%">Firma</th>
                            <th width="13%">Telefon</th>
                            <th width="20%">Stingătoare</th>
                            <th width="6%">Total</th>
                        </tr>

                        @forelse ($stingatoare_per_traseu as $stingator)
                            <tr>
                                <td align="right">
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    @if ($stingator->firma->parohie === 1)
                                        Parohia
                                    @endif
                                    {{ $stingator->firma->nume ?? '' }}
                                </td>
                                <td align="center">
                                    {{ $stingator->firma->telefon ?? '' }}
                                </td>
                                <td align="center">
                                    @if($stingator->p1 > 0)
                                            <span class="badge bg-secondary">
                                            {{ $stingator->p1 }} P1
                                            </span>
                                    @endif
                                    @if($stingator->p2 > 0)
                                            <span class="badge bg-secondary">
                                            {{ $stingator->p2 }} P2
                                            </span>
                                    @endif
                                    @if($stingator->p3 > 0)
                                            <span class="badge bg-secondary">
                                            {{ $stingator->p3 }} P3
                                            </span>
                                    @endif
                                    @if($stingator->p4 > 0)
                                            <span class="badge bg-secondary">
                                            {{ $stingator->p4 }} P4
                                            </span>
                                    @endif
                                    @if($stingator->p5 > 0)
                                            <span class="badge bg-secondary">
                                            {{ $stingator->p5 }} P5
                                            </span>
                                    @endif
                                    @if($stingator->p6 > 0)
                                            <span class="badge bg-secondary">
                                            {{ $stingator->p6 }} P6
                                            </span>
                                    @endif
                                    @if($stingator->p9 > 0)
                                            <span class="badge bg-secondary">
                                            {{ $stingator->p9 }} P9
                                            </span>
                                    @endif
                                    @if($stingator->p20 > 0)
                                            <span class="badge bg-secondary">
                                            {{ $stingator->p20 }} P20
                                            </span>
                                    @endif
                                    @if($stingator->p50 > 0)
                                            <span class="badge bg-secondary">
                                            {{ $stingator->p50 }} P50
                                            </span>
                                    @endif
                                    @if($stingator->p100 > 0)
                                            <span class="badge bg-secondary">
                                            {{ $stingator->p100 }} P100
                                            </span>
                                    @endif
                                    @if($stingator->sm3 > 0)
                                            <span class="badge bg-secondary">
                                            {{ $stingator->sm3 }} SM3
                                            </span>
                                    @endif
                                    @if($stingator->sm6 > 0)
                                            <span class="badge bg-secondary">
                                            {{ $stingator->sm6 }} SM6
                                            </span>
                                    @endif
                                    @if($stingator->sm9 > 0)
                                            <span class="badge bg-secondary">
                                            {{ $stingator->sm9 }} SM9
                                            </span>
                                    @endif
                                    @if($stingator->sm50 > 0)
                                            <span class="badge bg-secondary">
                                            {{ $stingator->sm50 }} SM50
                                            </span>
                                    @endif
                                    @if($stingator->sm100 > 0)
                                            <span class="badge bg-secondary">
                                            {{ $stingator->sm100 }} SM100
                                            </span>
                                    @endif
                                    @if($stingator->g2 > 0)
                                            <span class="badge bg-secondary">
                                            {{ $stingator->g2 }} G2
                                            </span>
                                    @endif
                                    @if($stingator->g5 > 0)
                                            <span class="badge bg-secondary">
                                            {{ $stingator->g5 }} G5
                                            </span>
                                    @endif
                                </td>
                                <td align="right">
                                    <span class="badge fs-6 bg-success">
                                        {{
                                            $stingator->p1 + $stingator->p2 + $stingator->p3 + $stingator->p4 + $stingator->p5 + $stingator->p6 + $stingator->p9 + $stingator->p20 + $stingator->p50 +
                                            $stingator->p100 + $stingator->sm3 + $stingator->sm6 + $stingator->sm9 + $stingator->sm50 + $stingator->sm100 + $stingator->g2 + $stingator->g5;
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
            </div>




</body>

</html>
