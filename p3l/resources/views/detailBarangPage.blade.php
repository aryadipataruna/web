<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - ReUse Mart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Basic reset and font */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif; /* Use Poppins font */
        }

        body {
            background-color: #1a1a1a; /* Dark background */
            color: #fff; /* Default text color */
            line-height: 1.6;
        }

        .navbar {
            background-color: #222; /* Slightly lighter dark for navbar */
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .navbar .navbar-brand {
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            display: flex;
            align-items: center;
        }

        .navbar .navbar-brand i {
            margin-right: 5px;
            color: #7BC9FF; /* Highlight icon color */
        }

        .navbar .search-bar {
            flex-grow: 1; /* Allow search bar to take space */
            margin: 0 20px;
        }

        .navbar .search-bar input {
            width: 100%;
            padding: 8px 15px;
            border: none;
            border-radius: 20px; /* Rounded search bar */
            background-color: #333; /* Darker input background */
            color: #fff;
        }

        .navbar .search-bar input::placeholder {
            color: #bbb;
        }

        .navbar .nav-icons a {
            color: #fff;
            text-decoration: none;
            margin-left: 15px;
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }

        .navbar .nav-icons a:hover {
            color: #7BC9FF; /* Highlight color on hover */
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #222; /* Container background */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            border-radius: 8px;
        }

        .page-header {
            display: flex;
            justify-content: space-around; /* Distribute space */
            margin-bottom: 30px;
            border-bottom: 2px solid #333; /* Separator */
            padding-bottom: 15px;
        }

        .page-header a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 5px 10px;
            transition: color 0.3s ease, border-bottom 0.3s ease;
        }

        .page-header a:hover,
        .page-header a.active {
            color: #7BC9FF;
            border-bottom: 2px solid #7BC9FF;
        }

        .product-detail-section {
            display: flex;
            flex-wrap: wrap; /* Allow wrapping on smaller screens */
            gap: 30px; /* Space between image/details and side info */
        }

        .product-image-area {
            flex-basis: 40%; /* Take 40% width */
            min-width: 300px; /* Minimum width */
            flex-grow: 1; /* Allow growth */
        }

        .product-image-area img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .product-info-area {
            flex-basis: 55%; /* Take 55% width */
            min-width: 300px; /* Minimum width */
            flex-grow: 1; /* Allow growth */
        }

        .product-info-area h2 {
            font-size: 2rem;
            color: #7BC9FF; /* Highlight color for title */
            margin-bottom: 10px;
        }

        .product-info-area .rating-sold {
            font-size: 0.9rem;
            color: #bbb;
            margin-bottom: 15px;
        }

        .product-info-area .rating-sold i {
            color: #ffc107; /* Star color */
            margin-right: 5px;
        }

        .product-info-area .price {
            font-size: 2.5rem;
            font-weight: 700;
            color: #28a745; /* Green color for price */
            margin-bottom: 20px;
        }

        .product-info-area .description h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
        }

        .product-info-area .description p {
            font-size: 1rem;
            color: #ccc;
        }

        .product-options {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #333;
        }

        .product-options h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .product-options .capacity-options button {
            background-color: #333;
            color: #fff;
            border: 1px solid #555;
            padding: 8px 15px;
            margin-right: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .product-options .capacity-options button:hover,
        .product-options .capacity-options button.selected {
            background-color: #7BC9FF;
            border-color: #7BC9FF;
            color: #1a1a1a;
            font-weight: 600;
        }

        /* --- Custom styles for buttons --- */
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .action-buttons .btn {
            flex-grow: 1;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .action-buttons .btn-buy {
            background-color: #28a745; /* Green for Buy Now */
            border: none;
            color: white;
        }

        .action-buttons .btn-buy:hover {
            background-color: #218838; /* Darker green on hover */
            transform: translateY(-2px);
        }

        .action-buttons .btn-cart {
            background-color: #007bff; /* Blue for Add to Cart */
            border: none;
            color: white;
        }

        .action-buttons .btn-cart:hover {
            background-color: #0056b3; /* Darker blue on hover */
            transform: translateY(-2px);
        }
        /* --- End Custom styles for buttons --- */


        .side-info-area {
            flex-basis: 30%; /* Take 30% width */
            min-width: 250px; /* Minimum width */
            background-color: #333; /* Darker background for side info */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .side-info-area h3 {
            font-size: 1.2rem;
            margin-bottom: 15px;
            border-bottom: 1px solid #555;
            padding-bottom: 10px;
        }

        .side-info-area .info-item {
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        .side-info-area .info-item strong {
            display: block;
            margin-bottom: 3px;
        }

        /* Style for loading message */
        .loading-message {
            text-align: center;
            padding: 50px;
            font-size: 1.5rem;
            color: #ccc;
        }

        /* Style for error message */
        .error-message {
            text-align: center;
            padding: 50px;
            font-size: 1.5rem;
            color: #ff6b6b; /* Red color for error */
        }

        /* Styles for Barang Selection Area */
        #barang-selection-area {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #2a2a2a;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        #barang-selection-area h2 {
            font-size: 1.5rem;
            color: #fff;
            margin-bottom: 15px;
            border-bottom: 1px solid #444;
            padding-bottom: 10px;
        }

        #barang-selection-area .barang-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        #barang-selection-area .barang-item-button {
            background-color: #333;
            color: #fff;
            border: 1px solid #555;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        #barang-selection-area .barang-item-button:hover {
            background-color: #7BC9FF;
            border-color: #7BC9FF;
            color: #1a1a1a;
        }

        #barang-selection-area .barang-item-button.selected-item {
            background-color: #7BC9FF;
            border-color: #7BC9FF;
            color: #1a1a1a;
            font-weight: 600;
            box-shadow: 0 0 0 3px rgba(123, 201, 255, 0.5); /* Highlight selected */
        }

        /* Loading spinner */
        .loading-spinner {
            border: 4px solid #f3f3f3; /* Light grey */
            border-top: 4px solid #7BC9FF; /* Blue */
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }


        /* Responsive adjustments */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 10px;
            }

            .navbar .search-bar {
                margin: 0;
                width: 100%; /* Full width on small screens */
            }

            .navbar .nav-icons {
                margin-top: 10px;
            }

            .product-detail-section {
                flex-direction: column; /* Stack sections vertically */
                gap: 20px;
            }

            .product-image-area,
            .product-info-area,
            .side-info-area {
                flex-basis: 100%; /* Full width */
                min-width: unset; /* Remove min-width constraint */
            }

            .page-header {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }

            .page-header a {
                font-size: 1rem;
            }

            .action-buttons {
                flex-direction: column; /* Stack buttons vertically on small screens */
            }
        }

    </style>
</head>
<body>

    <nav class="navbar">
        <a class="navbar-brand" href="/">
            <i class="fa fa-shopping-basket"></i> ReUse <strong>Mart</strong>
        </a>
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Daftar & cari Barang">
        </div>
        <div class="nav-icons">
            <a href="#"><i class="fa fa-search"></i></a>
            <a href="/cartPembeli"><i class="fa fa-shopping-cart"></i></a>
            <a href="#">Daftar</a>
            <a href="#">Log In</a>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <a href="#" class="active" id="detailProdukLink">Detail Produk</a>
            <a href="#" id="diskusiLink">Diskusi</a>
            <a href="#" id="ratingLink">Rating</a>
        </div>

        <div id="loading-message" class="loading-message"><span class="loading-spinner"></span> Memuat detail produk...</div>
        <div id="error-message" class="error-message"></div>

        {{-- Section to select a barang item --}}
        <div id="barang-selection-area">
            <h2>Pilih Barang untuk Dilihat</h2>
            <div class="barang-list" id="barang-list">
                <p class="loading-message"><span class="loading-spinner"></span> Memuat daftar barang...</p>
            </div>
        </div>

        <div class="product-detail-section" id="product-detail-content" style="display: none;">
            <div class="product-image-area">
                <img id="product-image" src="" alt="Product Image" onerror="this.onerror=null;this.src='https://placehold.co/600x400/2a2a2a/f8f9fa?text=No+Image';">
            </div>
            <div class="product-info-area">
                <h2 id="product-name"></h2>
                <div class="rating-sold">
                    <span id="product-rating"><i class="fas fa-star"></i> 4</span>
                    <span id="product-sold"> | Terjual 14</span>
                </div>
                <div class="price" id="product-price"></div>

                <div class="product-options">
                    <h3>Pilih Kapasitas : <span id="selected-capacity"></span></h3>
                    <div class="capacity-options" id="capacity-options">
                        {{-- Capacity buttons will be added here --}}
                    </div>
                    <div class="info-item mt-3">
                        <strong>Stok Tersedia:</strong> <span id="available-stock"></span>
                    </div>

                    <div class="action-buttons">
                        <button class="btn btn-buy" id="buy-now-btn">
                            <i class="fas fa-money-bill-wave me-2"></i>Beli Sekarang
                        </button>
                        <button class="btn btn-cart" id="add-to-cart-btn">
                            <i class="fas fa-cart-plus me-2"></i>Masukkan Keranjang
                        </button>
                    </div>

                </div>

                <div class="description mt-4">
                    <h3>Deskripsi Produk</h3>
                    <p id="product-description"></p>
                    <div id="additional-description">
                        <div class="info-item"><strong>Garansi:</strong> <span id="product-warranty"></span></div>
                    </div>
                </div>
            </div>

            <div class="side-info-area">
                <h3>Info Produk</h3>
                <div class="info-item">
                    <strong>Min. Pemesanan:</strong> <span id="min-order"></span>
                </div>
                <div class="info-item">
                    <strong>Etalase:</strong> <span id="etalase"></span>
                </div>
            </div>
        </div>

        {{-- Placeholder sections for Diskusi and Rating --}}
        <div id="diskusi-section" style="display: none; margin-top: 30px;">
            <h2>Diskusi</h2>
            <p>Diskusi section content will go here.</p>
        </div>

        <div id="rating-section" style="display: none; margin-top: 30px;">
            <h2>Rating</h2>
            <p>Rating section content will go here.</p>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let allBarangData = []; // Store all fetched barang data
        let currentSelectedBarang = null; // Store the currently displayed barang item
        let currentSelectedVariantStock = 0; // Store stock of the currently selected variant

        const loadingMessage = document.getElementById('loading-message');
        const errorMessage = document.getElementById('error-message');
        const barangSelectionArea = document.getElementById('barang-selection-area');
        const barangList = document.getElementById('barang-list');
        const productDetailContent = document.getElementById('product-detail-content');

        const productImage = document.getElementById('product-image');
        const productName = document.getElementById('product-name');
        const productRating = document.getElementById('product-rating');
        const productSold = document.getElementById('product-sold');
        const productPrice = document.getElementById('product-price');
        const selectedCapacitySpan = document.getElementById('selected-capacity');
        const capacityOptionsDiv = document.getElementById('capacity-options');
        // const productQuantityInput = document.getElementById('product-quantity'); // Removed
        // const decreaseQuantityBtn = document.getElementById('decrease-quantity'); // Removed
        // const increaseQuantityBtn = document.getElementById('increase-quantity'); // Removed
        // const quantityInfoSpan = document.getElementById('quantity-info'); // Removed
        const availableStockSpan = document.getElementById('available-stock'); // New
        // const subtotalPrice = document.getElementById('subtotal-price'); // Removed as 'Atur Jumlah' is gone
        const productDescription = document.getElementById('product-description');
        const productWarrantySpan = document.getElementById('product-warranty'); // Updated
        const minOrderSpan = document.getElementById('min-order');
        const etalaseSpan = document.getElementById('etalase');

        // New buttons
        const buyNowBtn = document.getElementById('buy-now-btn');
        const addToCartBtn = document.getElementById('add-to-cart-btn');

        // Fungsi untuk mengambil data dari API (untuk semua barang)
        async function fetchAllBarang() {
            barangList.innerHTML = '<p class="loading-message"><span class="loading-spinner"></span> Memuat daftar barang...</p>';
            loadingMessage.style.display = 'block'; // Tampilkan loading umum untuk seluruh halaman

            try {
                const response = await fetch('/api/barang', { // Asumsi /api/barang mengembalikan semua item
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    }
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(`HTTP error! status: ${response.status}, Message: ${errorData.message || response.statusText}`);
                }

                const responseData = await response.json();

                if (responseData.status === true && responseData.data) {
                    allBarangData = responseData.data; // Simpan semua data secara global
                    renderBarangSelection(allBarangData);
                    loadingMessage.style.display = 'none'; // Sembunyikan loading umum
                    return allBarangData;
                } else {
                    barangList.innerHTML = `<p class="error-message">Gagal memuat daftar barang: ${responseData.message || 'Error tidak diketahui'}</p>`;
                    loadingMessage.style.display = 'none';
                    errorMessage.innerText = `Gagal memuat data: ${responseData.message || 'Error tidak diketahui'}`;
                    errorMessage.style.display = 'block';
                    console.error('API response indicates failure for all Barang:', responseData);
                    return [];
                }

            } catch (error) {
                barangList.innerHTML = `<p class="error-message">Error memuat daftar barang. Silakan cek konsol untuk detail.</p>`;
                loadingMessage.style.display = 'none';
                errorMessage.innerText = `Error memuat data. Silakan cek konsol untuk detail.`;
                errorMessage.style.display = 'block';
                console.error("Error fetching all barang data:", error);
                return [];
            }
        }

        // Fungsi untuk mengambil satu item barang berdasarkan ID
        async function fetchBarangDetail(id) {
            productDetailContent.style.display = 'none';
            barangSelectionArea.style.display = 'none';
            loadingMessage.style.display = 'block';
            errorMessage.style.display = 'none';

            try {
                // Sesuaikan endpoint API jika endpoint item individual berbeda
                const response = await fetch(`/api/barang/${id}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    }
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(`HTTP error! status: ${response.status}, Message: ${errorData.message || response.statusText}`);
                }

                const responseData = await response.json();

                if (responseData.status === true && responseData.data) {
                    loadingMessage.style.display = 'none';
                    productDetailContent.style.display = 'flex'; // Tampilkan konten detail
                    return responseData.data; // Kembalikan data item tunggal
                } else {
                    loadingMessage.style.display = 'none';
                    errorMessage.innerText = `Gagal memuat detail produk: ${responseData.message || 'Error tidak diketahui'}`;
                    errorMessage.style.display = 'block';
                    console.error('API response indicates failure for Barang detail:', responseData);
                    return null;
                }

            } catch (error) {
                loadingMessage.style.display = 'none';
                errorMessage.innerText = `Error memuat detail produk. Silakan cek konsol untuk detail.`;
                errorMessage.style.display = 'block';
                console.error("Error fetching barang detail data:", error);
                return null;
            }
        }

        // Fungsi untuk merender daftar barang untuk seleksi
        function renderBarangSelection(barangData) {
            barangList.innerHTML = ''; // Bersihkan konten yang ada

            if (barangData.length === 0) {
                barangList.innerHTML = '<p class="text-center text-white">Tidak ada barang tersedia untuk dipilih.</p>';
                return;
            }

            barangData.forEach(item => {
                const button = document.createElement('button');
                button.classList.add('barang-item-button');
                button.innerText = item.nama_barang;
                button.dataset.id = item.id_barang;
                button.addEventListener('click', async () => {
                    // Hapus kelas 'selected-item' dari tombol sebelumnya
                    document.querySelectorAll('.barang-item-button').forEach(btn => {
                        btn.classList.remove('selected-item');
                    });
                    // Tambahkan kelas 'selected-item' ke tombol yang diklik
                    button.classList.add('selected-item');

                    const detail = await fetchBarangDetail(item.id_barang);
                    if (detail) {
                        currentSelectedBarang = detail; // Atur item yang saat ini dipilih
                        renderProductDetail(detail);
                    }
                });
                barangList.appendChild(button);
            });
            barangSelectionArea.style.display = 'block'; // Tampilkan area seleksi
        }

        // Fungsi untuk merender detail produk
        function renderProductDetail(item) {
            productImage.src = item.gambar_barang || 'https://placehold.co/600x400/2a2a2a/f8f9fa?text=No+Image';
            productName.innerText = item.nama_barang;
            productRating.innerHTML = `<i class="fas fa-star"></i> ${item.rating || 'N/A'}`; // Asumsi API menyediakan rating
            productSold.innerText = ` | Terjual ${item.terjual || 'N/A'}`; // Asumsi API menyediakan jumlah terjual
            productPrice.innerText = `Rp ${item.harga_barang ? parseInt(item.harga_barang).toLocaleString('id-ID') : 'N/A'}`;
            productDescription.innerText = item.deskripsi_barang;

            // Atur garansi
            if (item.garansi === true) {
                productWarrantySpan.innerText = 'Bergaransi';
            } else {
                productWarrantySpan.innerText = 'Tidak ada';
            }

            // Isi info samping
            minOrderSpan.innerText = item.min_pemesanan || '1'; // Asumsi bidang min_pemesanan
            etalaseSpan.innerText = item.etalase || 'Umum'; // Asumsi bidang etalase

            // Tangani kapasitas (jika item memiliki variasi)
            capacityOptionsDiv.innerHTML = '';
            if (item.variasi && item.variasi.length > 0) {
                item.variasi.forEach((variant, index) => {
                    const capacityButton = document.createElement('button');
                    capacityButton.innerText = variant.kapasitas;
                    capacityButton.dataset.index = index; // Simpan indeks untuk pencarian mudah
                    capacityButton.addEventListener('click', () => {
                        document.querySelectorAll('#capacity-options button').forEach(btn => btn.classList.remove('selected'));
                        capacityButton.classList.add('selected');
                        selectedCapacitySpan.innerText = variant.kapasitas;
                        currentSelectedVariantStock = variant.stok; // Update stock for selected variant
                        availableStockSpan.innerText = variant.stok; // Update displayed stock
                    });
                    capacityOptionsDiv.appendChild(capacityButton);
                });
                // Pilih kapasitas pertama secara default
                capacityOptionsDiv.querySelector('button').click();
            } else {
                selectedCapacitySpan.innerText = '1';
                currentSelectedVariantStock = item.stok_barang || 1; // Use base stock if no variations
                availableStockSpan.innerText = item.stok_barang || 1;
            }

            // Pastikan tombol beli dan keranjang aktif jika stok > 0
            if (currentSelectedVariantStock > 0) {
                buyNowBtn.disabled = false;
                addToCartBtn.disabled = false;
                buyNowBtn.style.opacity = '1';
                addToCartBtn.style.opacity = '1';
            } else {
                buyNowBtn.disabled = true;
                addToCartBtn.disabled = true;
                buyNowBtn.style.opacity = '0.5'; // Visual cue for disabled
                addToCartBtn.style.opacity = '0.5';
            }
        }

        // Event listener untuk tombol "Beli Sekarang"
        buyNowBtn.addEventListener('click', () => {
            if (!currentSelectedBarang) {
                alert('Silakan pilih barang terlebih dahulu.');
                return;
            }
            if (currentSelectedVariantStock <= 0) {
                alert('Maaf, stok untuk item ini habis.');
                return;
            }
            // Logika untuk "Beli Sekarang"
            alert(`Membeli sekarang: ${currentSelectedBarang.nama_barang} (Kapasitas: ${selectedCapacitySpan.innerText}).`);
            // Anda bisa mengarahkan ke halaman checkout atau memproses pembelian langsung
            // window.location.href = `/checkout?itemId=${currentSelectedBarang.id_barang}&capacity=${selectedCapacitySpan.innerText}`;
        });

        // Event listener untuk tombol "Masukkan ke Keranjang"
        // Event listener untuk tombol "Masukkan ke Keranjang"
        addToCartBtn.addEventListener('click', () => {
            if (!currentSelectedBarang) {
                alert('Silakan pilih barang terlebih dahulu.');
                return;
            }
            if (currentSelectedVariantStock <= 0) {
                alert('Maaf, stok untuk item ini habis.');
                return;
            }

            // Ambil data keranjang yang sudah ada dari localStorage, atau buat array kosong jika belum ada
            let cart = JSON.parse(localStorage.getItem('shoppingCart')) || [];

            // Siapkan data item yang akan ditambahkan
            const itemId = currentSelectedBarang.id_barang;
            const itemName = currentSelectedBarang.nama_barang;
            // Pastikan harga_barang adalah angka (string angka seperti "1500000")
            const itemPrice = parseFloat(currentSelectedBarang.harga_barang);
            const selectedCapacity = selectedCapacitySpan.innerText || 'N/A'; // Jika tidak ada kapasitas, default ke 'N/A'
            const itemImage = productImage.src; // Ambil URL gambar produk saat ini
            const quantity = 1; // Untuk contoh ini, kita tambahkan 1 item setiap kali klik

            // Cek apakah item dengan ID dan kapasitas yang sama sudah ada di keranjang
            const existingItemIndex = cart.findIndex(
                cartItem => cartItem.id === itemId && cartItem.capacity === selectedCapacity
            );

            if (existingItemIndex > -1) {
                // Jika sudah ada, tambahkan kuantitasnya
                cart[existingItemIndex].quantity += quantity;
            } else {
                // Jika belum ada, tambahkan sebagai item baru
                cart.push({
                    id: itemId,
                    name: itemName,
                    price: itemPrice,
                    capacity: selectedCapacity,
                    image: itemImage,
                    quantity: quantity
                    // Anda bisa menambahkan properti lain seperti variant_id jika perlu
                });
            }

            // Simpan kembali keranjang yang sudah diperbarui ke localStorage
            localStorage.setItem('shoppingCart', JSON.stringify(cart));

            // Beri notifikasi ke pengguna (opsional)
            alert(`"${itemName}" (Kapasitas: ${selectedCapacity}) telah ditambahkan ke keranjang!`);

            // Arahkan pengguna ke halaman keranjang
            window.location.href = '/cartPembeli'; // Pastikan URL ini sesuai dengan route halaman keranjang Anda
        });
        // Tangani tautan navigasi untuk menampilkan/menyembunyikan bagian
        const detailProdukLink = document.getElementById('detailProdukLink');
        const diskusiLink = document.getElementById('diskusiLink');
        const ratingLink = document.getElementById('ratingLink');
        const diskusiSection = document.getElementById('diskusi-section');
        const ratingSection = document.getElementById('rating-section');

        function showSection(sectionToShow) {
            // Sembunyikan semua bagian
            productDetailContent.style.display = 'none';
            barangSelectionArea.style.display = 'none'; // Jaga area seleksi tetap tersembunyi saat bagian lain aktif
            diskusiSection.style.display = 'none';
            ratingSection.style.display = 'none';

            // Hapus kelas aktif dari semua tautan
            detailProdukLink.classList.remove('active');
            diskusiLink.classList.remove('active');
            ratingLink.classList.remove('active');

            // Tampilkan bagian yang dipilih dan tambahkan kelas aktif ke tautannya
            if (sectionToShow === 'detail') {
                productDetailContent.style.display = 'flex';
                barangSelectionArea.style.display = 'block'; // Tampilkan area seleksi saat detail aktif
                detailProdukLink.classList.add('active');
            } else if (sectionToShow === 'diskusi') {
                diskusiSection.style.display = 'block';
                diskusiLink.classList.add('active');
            } else if (sectionToShow === 'rating') {
                ratingSection.style.display = 'block';
                ratingLink.classList.add('active');
            }
        }

        detailProdukLink.addEventListener('click', (e) => {
            e.preventDefault();
            showSection('detail');
        });
        diskusiLink.addEventListener('click', (e) => {
            e.preventDefault();
            showSection('diskusi');
        });
        ratingLink.addEventListener('click', (e) => {
            e.preventDefault();
            showSection('rating');
        });

        // Pemuatan awal: Ambil semua barang dan tampilkan daftar seleksi
        document.addEventListener('DOMContentLoaded', async () => {
            await fetchAllBarang();
            // Jika ada ID di URL, secara otomatis ambil dan tampilkan item tersebut
            const pathSegments = window.location.pathname.split('/');
            const itemIdFromUrl = pathSegments[pathSegments.length - 1]; // Mengambil segmen terakhir

            // Periksa apakah itu ID yang valid (misalnya, numerik, atau cocok dengan pola untuk ID Anda)
            // Untuk kesederhanaan, kita akan mengasumsikan itu adalah ID jika bukan "detailBarang"
            if (itemIdFromUrl && itemIdFromUrl !== 'detailBarang' && allBarangData.length > 0) {
                const foundItem = allBarangData.find(item => item.id_barang == itemIdFromUrl); // Gunakan == untuk perbandingan longgar jika ID bisa string/angka
                if (foundItem) {
                    const detail = await fetchBarangDetail(foundItem.id_barang);
                    if (detail) {
                        currentSelectedBarang = detail;
                        renderProductDetail(detail);
                        // Tandai tombol sebagai terpilih jika ada
                        const selectedButton = document.querySelector(`.barang-item-button[data-id="${foundItem.id_barang}"]`);
                        if (selectedButton) {
                            selectedButton.classList.add('selected-item');
                        }
                    }
                } else {
                    console.warn('ID Item dari URL tidak ditemukan dalam data yang diambil:', itemIdFromUrl);
                    // Fallback untuk menampilkan daftar seleksi jika ID URL tidak valid
                    showSection('detail'); // Tampilkan tampilan 'detail' default dengan daftar seleksi
                }
            } else {
                // Default: tampilkan daftar seleksi jika tidak ada ID valid di URL
                showSection('detail');
            }
        });


        // Fungsionalitas pencarian dasar untuk daftar seleksi
        document.getElementById('searchInput').addEventListener('input', (event) => {
            const searchTerm = event.target.value.toLowerCase();
            const buttons = document.querySelectorAll('#barang-list .barang-item-button');
            let found = false;

            buttons.forEach(button => {
                const itemName = button.innerText.toLowerCase();
                if (itemName.includes(searchTerm)) {
                    button.style.display = 'inline-block'; // Tampilkan tombol
                    found = true;
                } else {
                    button.style.display = 'none'; // Sembunyikan tombol
                }
            });

            const noResultsMessage = barangList.querySelector('.no-results-message');
            if (!found && searchTerm.length > 0) {
                if (!noResultsMessage) {
                    const p = document.createElement('p');
                    p.classList.add('text-center', 'text-white', 'no-results-message');
                    p.innerText = 'Tidak ada barang yang cocok dengan pencarian Anda.';
                    barangList.appendChild(p);
                }
            } else {
                if (noResultsMessage) {
                    noResultsMessage.remove();
                }
            }
        });

    </script>
</body>
</html>
