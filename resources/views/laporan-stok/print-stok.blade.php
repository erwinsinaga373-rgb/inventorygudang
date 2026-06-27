<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            font-size: 14px;
        }
        h1 {
            text-align: center;
            margin-bottom: 5px;
            text-transform: uppercase;
            font-size: 22px;
        }
        p {
            text-align: center;
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 14px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            text-align: center;
            padding: 10px 8px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        /* Penataan teks khusus untuk nama barang agar rata kiri */
        .text-left {
            text-align: left;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 12px;
            text-align: right;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <h1>Laporan Stok Barang</h1>
    <p>Keterangan Filter : 
        <strong>
            @if($selectedOption == 'semua')
                Semua Barang
            @elseif($selectedOption == 'minimum')
                Batas Minimum (Restock)
            @elseif($selectedOption == 'maksimum')
                Batas Maksimum (Overstock)
            @elseif($selectedOption == 'stok-habis')
                Stok Habis
            @else
                {{ ucfirst($selectedOption) }}
            @endif
        </strong>
    </p>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode Barang</th>
                <th width="35%" class="text-left">Nama Barang</th>
                <th width="15%">Stok Minimum</th>
                <th width="15%">Stok Maksimum</th>
                <th width="15%">Stok Saat Ini</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barangs as $index => $barang)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="font-weight: bold; color: #059669;">{{ $barang->kode_barang }}</td>
                <td class="text-left">{{ $barang->nama_barang }}</td>
                <td>{{ $barang->stok_minimum ?? 0 }}</td>
                <td>{{ $barang->stok_maksimum ?? 0 }}</td>
                <td style="font-weight: bold;">
                    {{ $barang->stok ?? 0 }} 
                    <span style="font-weight: normal; font-size: 12px; color: #666;">
                        {{ $barang->satuan->satuan ?? '' }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding: 20px; color: #999; font-style: italic;">
                    Tidak ada data barang yang memenuhi kriteria filter ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh: <strong>{{ auth()->user()->name ?? 'System' }}</strong><br>
        Tanggal Cetak: {{ date('d-m-Y H:i') }}
    </div>
</body>
</html>