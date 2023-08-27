<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Hasil</title>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 14px;
        }

        th {
            height: 30px;
            text-align: center;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 3px;
        }

        thead {
            background: lightgray;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>
    <h3 class="center">
        LAPORAN HASIL PREDIKSI
    </h3>
    <table>
        <thead>
            <tr class="center">
                <th>No</th>
                <th>Produk</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Order</th>
                <th>Penjualan</th>
                <th>Stok</th>
                <th>Prediksi</th>
                <th>Aktual</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($hasil)) : ?>
                <?php $no = 1; ?>
                <?php foreach ($hasil as $row) : ?>
                    <tr>
                        <td class="center"><?php echo $no++; ?></td>
                        <td><?php echo $row['nama_produk']; ?></td>
                        <td><?php echo $row['bulan']; ?></td>
                        <td class="center"><?php echo $row['tahun']; ?></td>
                        <td class="center"><?php echo $row['orders']; ?></td>
                        <td class="center"><?php echo $row['shipment']; ?></td>
                        <td class="center"><?php echo $row['stok']; ?></td>
                        <td class="center"><?php echo $row['produksi_prediksi']; ?></td>
                        <td class="center"><?php echo $row['produksi_aktual']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>