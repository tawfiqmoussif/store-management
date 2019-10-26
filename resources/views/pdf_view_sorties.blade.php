<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
     p {
            font-family: 'xbriyaz',arial;
           
            },

        table {
            font-family: 'xbriyaz',arial;
            border-collapse: collapse;
            width: 80%;
            margin-left:auto; 
            margin-right:auto;
            }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
       
  
    </style>
</head>



<body>
       
    <table>
            <tr>
                    <td  colspan="5" >
                        <table>
                            <tr>
                                    
                                        
                                        <td style="border: 0px !important;text-align: right;">
                                           {{$request->sorties['personne']['nom']}} {{$request->sorties['personne']['prenom']}}<br>
                                           {{$request->sorties['personne']['adresse']}}<br>
                                           {{$request->sorties['personne']['tel']}}
                                        </td>
                                        <td style="border: 0px !important;text-align: right;">
                                            {{$request->entreprise}}<br>
                                            {{$request->tel}}<br>
                                            {{$request->face}}<br>
                                            {{$request->site}}
                                        </td>
                            </tr>
                        </table>
                    </td>
            </tr>
        <tr>
            <th style="text-align: center;">الواجب</th>
            <th style="text-align: center;">العدد</th>
            <th style="text-align: center;">الثمن</th>
            <th style="text-align: center;">اللون</th>
            <th style="text-align: center;">نوع البضاعة</th>
        </tr>
        @foreach($request->sorties['lignes'] as $ligne)
        <tr>
        <td style="text-align: center;">{{$ligne['qte'] * $ligne['prix_unitaire']}}</td>
        <td style="text-align: center;">{{$ligne['qte']}}</td>
        <td style="text-align: center;">{{$ligne['prix_unitaire']}}</td>
        <td style="text-align: center;">{{$ligne['serie']['couleur']}}</td>
        <td style="text-align: center;">{{$ligne['serie']['ref']}}</td>
        </tr>
        @endforeach

       


    </table>
    <p style="margin-left: 80px;">     المجموع : {{$request->sorties['montant_total']}} درهم</p>
    <table>
        <tr>
        <th style="text-align: center;">المبلغ</th>
        <th style="text-align: center;">كيفية الدفع</th>
        <th style="text-align: center;">رقم الشيك أو الكمبيالة</th>
        <th style="text-align: center;">الوصف</th>
        </tr>
        @foreach($request->sorties['avances'] as $avance)
        <tr>
        <td style="text-align: center;">{{$avance['montant']}}</td>
        <td style="text-align: center;">{{$avance['type_paiement']}}</td>
        <td style="text-align: center;">{{$avance['numero']}}</td>
        <td style="text-align: center;">{{$avance['description']}}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>