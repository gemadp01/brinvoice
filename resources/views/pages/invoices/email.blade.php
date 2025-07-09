<!DOCTYPE html>
<html>
<head>
    <title>Invoice {{ $invoice->invoice_code }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { padding: 20px; max-width: 600px; margin: auto; border: 1px solid #ddd; }
        .header { font-size: 24px; font-weight: bold; margin-bottom: 20px; }
        .details { margin-bottom: 20px; }
        .footer { margin-top: 30px; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Invoice Baru dari {{ $invoice->user->brand_name }}</div>

        <div class="details">
            <p>Halo,</p>
            <p>
                Terlampir adalah invoice dengan nomor <strong>{{ $invoice->invoice_code }}</strong> untuk Anda.
            </p>
            <p>
                Tanggal Invoice : <strong>{{ $invoice->invoice_date->translatedFormat('d F Y') }}</strong>
            </p>
            <p>
                Total Tagihan: <strong>Rp {{ number_format($invoice->bill_total, 0, ',', '.') }}</strong>
            </p>
            <p>
                Detail lengkap invoice terlampir dalam file PDF.
            </p>
            <a target="_blank" href="{{ route('invoices.pdf', $invoice->invoice_code) }}">Lihat Invoice</a>
        </div>

        <div class="footer">
            <p>Terima kasih.</p>
            <p>Hormat kami,<br>{{ $invoice->user->brand_name }}</p>
        </div>
    </div>
</body>
</html>
