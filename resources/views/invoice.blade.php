<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Be Natural </title>
    <link rel="stylesheet" href="style.css" media="all"/>
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }

        body {
            position: relative;
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #2d2d2d;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-family: DejaVu Sans;
        }

        header {
            padding: 10px 0;
            margin-bottom: 20px;
        }

        #logo {
            float: left;
            margin-top: 8px;
        }

        #logo img {
            height: 70px;
        }

        #company {
            float: left;
            text-align: left;
            margin-right: 130px;
        }

        #details {
            margin-bottom: 50px;
        }

        #client {
            padding-left: 6px;
            border-left: 6px solid #0087C3;
            float: left;
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1.4em;
            font-weight: normal;
            margin: 0;
        }

        #invoice {
            float: right;
            text-align: right;
        }

        #invoice h1 {
            color: #0087C3;
            font-size: 2.4em;
            line-height: 1em;
            font-weight: normal;
            margin: 0 0 10px 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }

        /*table {*/
            /*width: 90%;*/
            /*border-collapse: collapse;*/
            /*border-spacing: 0;*/
            /*margin-bottom: 20px;*/
        /*}*/

        table th,
        table td {
            padding: 5px;
            text-align: center;
            /*border-bottom: 1px solid #000000;*/
        }

        /*table th {*/
            /*white-space: nowrap;*/
            /*font-weight: normal;*/
        /*}*/

        /*table td {*/
            /*text-align: right;*/
        /*}*/

        /*table td h3 {*/
            /*color: #000000;*/
            /*font-size: 1em;*/
            /*font-weight: normal;*/
            /*margin: 0 0 0.2em 0;*/
        /*}*/

        table td {
            text-align: left;
            font-size: 1em;
        }

        /*table .desc {*/
            /*text-align: left;*/
        /*}*/

        /*table .unit {*/
            /*background: #DDDDDD;*/
        /*}*/

        /*table .qty {*/
        /*}*/

        /*table .total {*/
            /*background: #fff;*/
            /*color: #000000;*/
        /*}*/

        /*table td.unit,*/
        /*table th.unit,*/
        /*table td.qty,*/
        /*table th.qty,*/
        /*table td.desc,*/
        /*table th.desc,*/
        /*table td.no,*/
        /*table th.no,*/
        /*table td.total,*/
        /*table th.total{*/
            /*color: #333333;*/
            /*background: white;*/
            /*font-size: 0.9em;*/
            /*border: 1px solid #555555;*/
        /*}*/

        /*table tbody tr:last-child td {*/
            /*border: none;*/
        /*}*/

        /*table tfoot td {*/
            /*padding: 10px 20px;*/
            /*background: #FFFFFF;*/
            /*border-bottom: none;*/
            /*font-size: 1.2em;*/
            /*white-space: nowrap;*/
            /*border-top: 1px solid #AAAAAA;*/
        /*}*/

        /*table tfoot tr:first-child td {*/
            /*border-top: none;*/
        /*}*/

        /*table tfoot tr:last-child td {*/
            /*color: #57B223;*/
            /*font-size: 1.4em;*/
            /*border-top: 1px solid #57B223;*/

        /*}*/

        /*table tfoot tr td:first-child {*/
            /*border: none;*/
        /*}*/

        #thanks {
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices {
            padding-left: 6px;
            border-left: 6px solid #0087C3;
        }

        #notices .notice {
            font-size: 1.2em;
        }

        footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #AAAAAA;
            padding: 8px 0;
            text-align: center;
        }


    </style>
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <img src="images/logo.png" style="width:700px;height:150px;">
    </div>
</header>
<main>
    <div id="details" class="clearfix">
        <div id="company">
            <div>Račun: <h3>
                    <strong> {{$order->account_number."/".Carbon\Carbon::parse($order->date)->format('Y') }}</strong>
                </h3></div>
            <div class="date">Datum: {{ "  " . Carbon\Carbon::parse($order->date)->format('d.m.Y.') }}</div>
        </div>

        <div id="client">
            <div class="to">Klijent:</div>
            <h2 class="name">{{ $order->client->name }}</h2>
            <h2 class="name">PIB: {{ $order->client->pib_number }}</h2>
            <div class="address">Adresa: {{ $order->client->address}}</div>
            <div class="address">{{$order->client->city ." ".$order->client->postal_code}}</div>
        </div>

    </div>
    <table border="1" cellspacing="0" cellpadding="0"  style="margin-right: 80px; margin-bottom: 30px">
        <thead>
        <tr>
            <th>#</th>
            <th>Opis</th>
            <th>Cena</th>
            <th>Kol.</th>
            <th>UKUPNO</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $order_items as $order_item)
            <tr>
                <td style="text-align: center">{{$loop->iteration}}</td>
                <td>{{$order_item->item->name }}</td>
                <td style="text-align: right">{{$order_item->unit_price}} <da style="font-size: 0.6em;">RSD</da></td>
                <td style="text-align: center">{{$order_item->quantity}}</td>
                <td style="text-align: right">{{($order_item->unit_price * $order_item->quantity). " RSD"}}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <td colspan="2"></td>
        <td colspan="2">Ukupna cena:</td>
        <td> <strong>{{number_format((float)$order->total, 2)." RSD"}}</strong></td>
        </tr>
        </tfoot>
    </table>
    <div>
        <div>Izdavalac računa nije obveznik PDV po članu 33. Zakona o PDV-u</div>
        <div>Rok plačanja : 10 dana</div>
        <div>Tekuči račun: 250-241285-47 Komercijalna Banka</div>
        <div>Prilikom uplate upisati broj računa u pozivu na broj odobrenja na nalogu za
            prenos: {{$order->account_number."/".Carbon\Carbon::parse($order->date)->format('Y') }}</div>
    </div>

    <div class="clearfix" style="margin-top: 30px">
        <div style="float: left; text-align: left; margin-right: 350px; margin-left: 40px">
            <div>Usluge primio: </div>
            <div style="margin-left: 20px">M.P.</div>
        </div>

        <div style="float: left;">
            <div>Usluge  izvršio:</div>
            <div>Božanić Dragan</div>
        </div>
    </div>


</main>

</body>
</html>
