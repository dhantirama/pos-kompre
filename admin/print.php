<?php
include "../koneksi.php";


$id = isset($_GET['id']) ? $_GET['id'] : '';
$queryTrans = mysqli_query($koneksi, "SELECT customer.nama_customer , trans_laundry_pickup.pickup_date, trans_order.*  
FROM trans_order 
LEFT JOIN trans_laundry_pickup ON trans_order.id = trans_laundry_pickup.id_order 
LEFT JOIN customer ON trans_order.id_customer = customer.id
WHERE trans_order.id = '$id'");
$dataOrder = mysqli_fetch_assoc($queryTrans);


$queryDetail = mysqli_query($koneksi, "SELECT trans_order_detail.*, type_of_service.service_name, type_of_service.price 
FROM trans_order_detail 
LEFT JOIN type_of_service ON trans_order_detail.id_service = type_of_service.id
WHERE id_order = '$id'");


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Transaksi : </title>
    <style>
        body {
            margin: 20px;
            margin: 0;
            font-size: 10px;
            font-family: monospace;

        }

        hr {
            border: none;
            height: 1px;
            color: #333;
            background-color: #333;
        }

        .struk {
            width: 80mm;
            max-width: 100%;
            border: 1px solid #000;
            padding: 10px;
            margin: 0 auto;
        }

        .struk-header,
        .struk-footer {
            text-align: center;
            margin-bottom: 10px;
        }

        .struk-header h1 {
            font-size: 18px;
            margin: 0;
        }

        .struk-body {
            margin-bottom: 10px;
        }

        .struk-body table {
            border-collapse: collapse;
            width: 100%;
        }

        .struk-body table th,
        .struk-body table td {
            padding: 5px;
            text-align: left;
        }

        .struk-body,
        .struk-footer table th {
            border-bottom: 1px solid #000;
        }

        .total,
        .payment,
        .change {
            display: flex;
            justify-content: space-evenly;
            /* memberikan space antara dua bagian */
            padding: 5px 0;
            font-weight: bold;
        }

        .total {
            margin-top: 10px;
            border-top: 1px solid #000;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                background-color: #BFECFF;
            }

            .struk {
                width: auto;
                border: none;
                margin: 0;
                padding: 0;
            }

            .struk-header h1,
            .struk-footer {
                font-size: 14px;
            }

            .struk-body table th,
            .struk-body table td {
                padding: 2px;
            }

            .total,
            .payment,
            .change {
                padding: 2px 0;
            }
        }
    </style>
</head>

<body>
    <div class="struk">
        <div class="struk-header">
            <h1>Laundry Banyak Gaya</h1>
            <p>Jl. Karet Jakarta Pusat</p>
            <p>08213694204</p>
        </div>
        <div class="struk-body">
            <div>
                <h4>Pemesan : <?php echo $dataOrder['nama_customer'] ?></h4>
                <h4>Tanggal Ambil : <?php echo $dataOrder['pickup_date'] ?></h4>
                <h4>Kode Pemesanan : <?php echo $dataOrder['order_code'] ?></h4>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Paket</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody class="mb-4">
                    <?php while ($rowDetail = mysqli_fetch_assoc($queryDetail)) : ?>
                        <!-- cara panggilanya juga bisa $row as $rowDetail -->
                        <tr>
                            <td><?php echo $rowDetail['service_name'] ?></td>
                            <td><?php echo "Rp." . number_format($rowDetail['price']) ?></td>
                            <td><?php echo $rowDetail['qty'] ?></td>
                            <td><?php echo "Rp." . number_format($rowDetail['subtotal']) ?></td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
                <hr>
                <tfoot class="struk-footer">
                    <tr>
                        <td colspan="3" align="right"><strong>Total Harga</strong></td>
                        <td><?= 'Rp ' . number_format($dataOrder['total_price']) ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right"><strong>Total Bayar</strong></td>
                        <td><?= 'Rp ' . number_format($dataOrder['order_pay']) ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right"><strong>Kembalian</strong></td>
                        <td><?= 'Rp ' . number_format($dataOrder['order_change']) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="struk-footer">
            <p>Terima Kasih</p>
            <p>Selamat Berbelanja Kembali</p>
        </div>
    </div>
    <script>
        //untuk print struk 
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>