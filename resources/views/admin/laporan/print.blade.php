<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pembayaran SPP</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; font-size: 12px; color: #1e293b; }
        .header { text-align: center; padding: 20px 0; border-bottom: 3px double #334155; margin-bottom: 20px; }
        .header h1 { font-size: 18px; font-weight: 700; color: #1e293b; }
        .header p { font-size: 11px; color: #64748b; margin-top: 4px; }
        .meta { margin-bottom: 16px; font-size: 11px; color: #64748b; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f1f5f9; border: 1px solid #cbd5e1; padding: 8px 10px; text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; color: #475569; }
        td { border: 1px solid #e2e8f0; padding: 7px 10px; font-size: 11px; }
        tr:nth-child(even) { background: #f8fafc; }
        .total { font-weight: 700; background: #f1f5f9; }
        .amount { text-align: right; font-weight: 600; }
        .footer { margin-top: 30px; text-align: right; font-size: 11px; color: #64748b; }
        @media print { body { margin: 15mm; } }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h1>LAPORAN PEMBAYARAN SPP</h1>
        <p>SPP Bersama - Sistem Pembayaran SPP</p>
        <p style="margin-top:8px; font-size:12px; color:#334155;">
            @if($bulan) Bulan: {{ $bulan }} @endif
            @if($tahun) Tahun: {{ $tahun }} @endif
            @if($nisn) | NISN: {{ $nisn }} @endif
        </p>
    </div>

    <div class="meta">
        Dicetak: {{ now()->format('d F Y H:i') }} | Total Data: {{ $pembayaran->count() }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NISN</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Bulan/Tahun</th>
                <th>Tanggal Bayar</th>
                <th style="text-align:right">Jumlah</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembayaran as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->nisn }}</td>
                <td>{{ $p->siswa->nama ?? '-' }}</td>
                <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $p->bulan_bayar }} {{ $p->tahun_bayar }}</td>
                <td>{{ $p->tgl_bayar->format('d/m/Y') }}</td>
                <td class="amount">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                <td>{{ $p->petugas->name ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center; padding:20px;">Tidak ada data</td></tr>
            @endforelse
        </tbody>
        @if($pembayaran->count() > 0)
        <tfoot>
            <tr class="total">
                <td colspan="6" style="text-align:right; font-weight:700;">TOTAL</td>
                <td class="amount">Rp {{ number_format($totalAmount, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer">
        <p>Dokumen ini digenerate oleh sistem SPP Bersama</p>
    </div>
</body>
</html>
