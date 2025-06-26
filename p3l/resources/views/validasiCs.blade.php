<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Pesanan - ReUse Mart</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 30px;
        }
        .card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            padding: 30px;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 25px;
            border-bottom: 2px solid #f1f1f1;
            padding-bottom: 15px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(90deg, #27ae60, #229954);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
        }
        .order-summary {
            position: sticky;
            top: 20px;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }
        .summary-item.total {
            font-weight: 700;
            font-size: 1.2rem;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #f1f1f1;
            color: #2c3e50;
        }
        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .cart-item img {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            margin-right: 15px;
            object-fit: cover;
        }
        .cart-item-details {
            flex-grow: 1;
        }
        .cart-item-details p {
            margin: 0;
            font-weight: 600;
        }
        .cart-item-details span {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .cart-item-price {
            font-weight: 600;
        }

        @media (max-width: 900px) {
            .container {
                grid-template-columns: 1fr;
            }
            .order-summary {
                position: static;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Kolom Kiri: Form Detail Pengiriman -->
        <main>
            <div class="card">
                <h1 class="card-title">Detail Pengiriman & Pembayaran</h1>
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_pembeli">Nama Lengkap</label>
                        <input type="text" id="nama_pembeli" name="nama_pembeli" class="form-control" required placeholder="Masukkan nama lengkap Anda">
                    </div>
                    <div class="form-group">
                        <label for="nomor_telepon">Nomor Telepon</label>
                        <input type="tel" id="nomor_telepon" name="nomor_telepon" class="form-control" required placeholder="Contoh: 081234567890">
                    </div>
                    <div class="form-group">
                        <textarea id="alamat_pengiriman" name="alamat_pengiriman" class="form-control" rows="4" required placeholder="Masukkan jalan, RT/RW, kelurahan, kecamatan, kota, dan kode pos"></textarea>
                    </div>

                    <button type="submit" class="btn-submit">Konfirmasi Pesanan</button>
                </form>
            </div>
        </main>

        <!-- Kolom Kanan: Ringkasan Pesanan -->
        <aside>
            <div class="card order-summary">
                <h1 class="card-title">Ringkasan Pesanan</h1>

                @forelse ($cartItems as $item)
                    <div class="cart-item">
                        <img src="{{ $item['gambar'] ?? 'https://placehold.co/60x60/e2e8f0/a0aec0?text=Produk' }}" alt="Gambar Produk">
                        <div class="cart-item-details">
                            <p>{{ $item['nama'] }}</p>
                            <span>{{ $item['jumlah'] }} x Rp {{ number_format($item['harga'], 0, ',', '.') }}</span>
                        </div>
                        <div class="cart-item-price">
                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                        </div>
                    </div>
                @empty
                    <p>Keranjang belanja Anda kosong.</p>
                @endforelse

                <div class="summary-item">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($totals['subtotal'], 0, ',', '.') }}</span>
                </div>
                <div class="summary-item">
                    <span>Biaya Pengiriman</span>
                    <span>Rp {{ number_format($totals['pengiriman'], 0, ',', '.') }}</span>
                </div>
                <div class="summary-item total">
                    <span>Total</span>
                    <span>Rp {{ number_format($totals['total'], 0, ',', '.') }}</span>
                </div>
            </div>
        </aside>
    </div>
</body>
</html>
