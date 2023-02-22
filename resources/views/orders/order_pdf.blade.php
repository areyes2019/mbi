<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }
        .header{
            font-size: 10px;
        }
        .header table{
            padding: 5px;
            color: black;
        }
        .info{
            background-color: #53676c;
            width: 100%;
            color: white;
            font-size: 12px;
        }
        .footer{
            margin-top: 15px;
            font-size: 12px;
        }
        .footer p{
            padding:15px;
            color: #57606f;
            margin-top: 120px;
        }
        .footer ul{
            padding: 20px;
            color: #57606f;
            margin-top: 100px;
            margin-left: 90;
        }
        #customers {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
          font-size: 12px;
        }
        #anticipo{
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
            color: blue;
        }
        #customers td, #customers th {
          border: 1px solid #ddd;
          padding: 8px;
        }
        #customers tr:nth-child(even){background-color: #f2f2f2;}
        #customers th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #aa0000;
          color: white;
        }
        .deco{
            height: 0px;
            width: 40%;
            background-color: grey;
            margin: 15px;
        }
        .cuenta{
            width: 50%;
            margin-left: 365px;
        }
    </style>
</head>
<body>
    <div class="header" style="height: 200px;">
        <table width="100%" style="padding-top: 20px;">
            <tr>
                <td style="vertical-align: top; padding: 15px;">
                    <img src="{{asset('img/logo2.png')}}" width="150">
                </td>
                <td align="top" style="vertical-align: top;">
                    <p><strong>Sello Pronto Celaya</strong> <br>
                    Real del Seminario #122 <br>
                    Valle del Real<br>
                    Celaya, Gto <br>
                    Tel 461 358 10 90 <br>
                    Offna: (461)250 74 82 <br>
                    </p>
                    <p style="margin-top: 5px">
                    <strong >Sello Pronto Querétaro</strong> <br>
                    Nogal #15 <br>
                    Frac. Arboledas<br>
                    Querétaro, Qro <br>
                    Tel 442 359 4212 <br>
                    Offna: (442)833 84 73
                    </p>
                </td>
            </tr>
        </table>
    </div>
    <div class="info">
        <table width="100%" style="padding: 15px;">
            <tr>
               <td><h2>Orden de Cotización {{$totals['idOrder']}}</h2></td>
            </tr>
            <tr>
                <td><h3>Distribuidora Universal Kimu</h3></td>
            </tr>
            <tr>
                <td><h4>Con Guia del cliente</h4></td>
            </tr>
        </table>
    </div>
    <div class="resumen" style="margin-top: 10px; padding: 15px;">
        <table id="customers">
          <tr>
            <th>Cant.</th>
            <th>Artículo</th>
            <th>Modelo</th>
            <th>P/U</th>
            <th>Total</th>
          </tr>
          @foreach ($details as $item)
          <tr>
            <td>{{$item->quantity}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->model}}</td>
            <td>${{$item->cost}}</td>
            <td>${{$item->total}}</td>
          </tr>
          @endforeach
        </table>
    </div>
    <div class="deco">
        
    </div>
    <div class="cuenta" style="margin-top: 10px; padding: 15px;">
        <table id="customers">
            <tr>
                <th>TOTAL</th>
                <td>${{$totals['sub_total']}}</td>
            </tr>
        </table>
    </div>
    <div class="footer">
        <p>Tenga la bondad de confirmar esta solicitud</p>
    </div>
</body>
</html>