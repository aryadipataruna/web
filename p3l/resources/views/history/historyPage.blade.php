<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReUse Mart - Riwayat Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #0a0a0a;
            --secondary-dark: #1a1a1a;
            --card-dark: #2a2a2a;
            --accent-green: #00ff88;
            --accent-blue: #00aaff;
            --text-light: #f8f9fa;
            --text-muted: #adb5bd;
            --star-gold: #FFD700; /* Gold color for stars */
        }

        * {
            scroll-behavior: smooth;
        }

        body {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 100%);
            color: var(--text-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding-top: 80px; /* To prevent content from being hidden by fixed navbar */
        }

        /* Navbar Styles */
        .navbar {
            background: rgba(26, 26, 26, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            background: linear-gradient(45deg, var(--accent-green), var(--accent-blue));
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .search-container {
            position: relative;
            max-width: 600px;
            margin: 0 auto;
        }

        .search-input {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            color: white;
            padding: 12px 50px 12px 20px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--accent-green);
            box-shadow: 0 0 20px rgba(0, 255, 136, 0.3);
            color: white;
        }

        .search-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(45deg, var(--accent-green), var(--accent-blue));
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            color: white;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 5px 15px rgba(0, 255, 136, 0.4);
        }

        /* Section Title */
        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 3rem;
            background: linear-gradient(45deg, var(--accent-green), var(--accent-blue));
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* History Card */
        .history-card {
            background: var(--card-dark);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            position: relative;
            cursor: pointer; /* Add cursor pointer to indicate clickability */
        }

        .history-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border-color: var(--accent-green);
        }

        .history-image {
            width: 100%;
            height: 200px; /* Slightly smaller for history view */
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .history-card:hover .history-image {
            transform: scale(1.05);
        }

        .history-info {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 2;
        }

        .history-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: var(--text-light);
        }

        .history-description {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            flex-grow: 1;
        }

        .history-price {
            font-size: 1.1rem;
            font-weight: bold;
            color: var(--accent-green); /* Price can be green */
            margin-bottom: 0.5rem;
        }

        .history-date {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }

        /* Rating Stars */
        .rating-stars, .rating-display { /* Apply styles to both containers */
            font-size: 1.5rem; /* Ukuran bintang */
            color: var(--text-muted); /* Warna default bintang kosong */
            cursor: pointer;
            text-align: center;
            margin-top: 1rem;
            display: flex; /* Menggunakan flexbox untuk penataan */
            justify-content: center; /* Pusatkan bintang */
            gap: 2px; /* Jarak antar bintang */
        }

        .rating-stars .fa-star,
        .rating-stars .fa-star-o,
        .rating-display .fa-star,
        .rating-display .fa-star-o {
            transition: all 0.2s ease;
            color: inherit; /* Warna default dari parent */
        }

        .rating-stars .fa-star.filled,
        .rating-display .fa-star.filled {
            color: var(--star-gold); /* Warna emas untuk bintang terisi */
        }

        .rating-stars .fa-star-o,
        .rating-display .fa-star-o {
            color: var(--text-muted); /* Pastikan bintang kosong terlihat */
        }

        .rating-stars .fa-star:hover,
        .rating-stars .fa-star-o:hover {
            transform: scale(1.1); /* Efek zoom saat hover */
            color: var(--star-gold); /* Bintang yang di-hover berubah jadi emas */
        }

        .rating-text, .rating-text-display {
            font-size: 0.9rem;
            color: var(--text-muted);
            text-align: center;
            margin-top: 0.5rem;
        }

        /* Nav Links */
        .nav-link {
            transition: all 0.3s ease;
            border-radius: 10px;
            padding: 8px 16px !important;
        }

        .nav-link:hover {
            background: rgba(0, 255, 136, 0.1);
            color: var(--accent-green) !important;
            transform: translateY(-2px);
        }

        /* Footer */
        footer {
            background: var(--secondary-dark);
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        footer h5 {
            background: linear-gradient(45deg, var(--accent-green), var(--accent-blue));
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
        }

        footer .list-unstyled a {
            transition: color 0.3s ease;
        }

        footer .list-unstyled a:hover {
            color: var(--accent-green) !important;
        }

        /* Modal Styles */
        .modal-content {
            background: var(--card-dark);
            color: var(--text-light);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-header {
            border-bottom-color: rgba(255, 255, 255, 0.1);
        }

        .modal-footer {
            border-top-color: rgba(255, 255, 255, 0.1);
        }

        .modal-title {
            background: linear-gradient(45deg, var(--accent-green), var(--accent-blue));
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
        }

        .btn-close {
            filter: invert(1) grayscale(1) brightness(2); /* Make close button visible on dark background */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top px-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.html">
            <i class="fa fa-recycle me-2"></i>ReUse <strong>Mart</strong>
        </a>
        
        <div class="search-container flex-grow-1 mx-4">
            <input class="form-control search-input" type="search" placeholder="Cari barang bekas berkualitas..." id="searchInput">
            <button class="btn search-btn" type="button">
                <i class="fa fa-search"></i>
            </button>
        </div>
        
        <div class="d-flex align-items-center">
            <a href="index.html#categories" class="nav-link text-light me-2">
                <i class="fa fa-th-large me-1"></i>Kategori
            </a>
            <a href="index.html#products" class="nav-link text-light me-2">
                <i class="fa fa-shopping-bag me-1"></i>Produk
            </a>
            <a href="#" class="nav-link text-light me-2">
                <i class="fa fa-shopping-cart me-1"></i>Keranjang
            </a>
            <a href="#" class="nav-link text-light me-2 active">
                <i class="fa fa-history me-1"></i>Riwayat
            </a>
            <a href="#" class="nav-link text-light">
                <i class="fa fa-user me-1"></i>Masuk
            </a>
        </div>
    </div>
</nav>

<section class="py-5" id="history">
    <div class="container">
        <h2 class="section-title">Riwayat Pembelian Anda</h2>
        <div class="row g-4" id="historyItemsRow">
        </div>
    </div>
</section>

<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ratingModalLabel">Berikan Rating untuk <span id="modalItemTitle"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="rating-stars" id="modalRatingStars" data-rating="0">
                    <i class="fa-regular fa-star" data-value="1"></i>
                    <i class="fa-regular fa-star" data-value="2"></i>
                    <i class="fa-regular fa-star" data-value="3"></i>
                    <i class="fa-regular fa-star" data-value="4"></i>
                    <i class="fa-regular fa-star" data-value="5"></i>
                </div>
                <p class="rating-text mt-3" id="modalRatingText">Pilih jumlah bintang Anda</p>
                <input type="hidden" id="modalItemId">
                <input type="hidden" id="selectedRatingValue">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitRatingBtn" style="background: linear-gradient(45deg, var(--accent-green), var(--accent-blue)); border: none;">Kirim Rating</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="detailItemImage" src="" class="img-fluid rounded-start" alt="Gambar Barang">
                    </div>
                    <div class="col-md-6">
                        <h4 id="detailItemTitle" class="mb-3"></h4>
                        <p class="text-muted" id="detailItemDescription"></p>
                        <h5 class="text-accent-green" id="detailItemPrice"></h5>
                        <p class="text-muted" id="detailItemDate"></p>
                        <div class="rating-display mb-3" id="detailItemRatingDisplay" data-rating="0"></div>
                        <p class="rating-text-display" id="detailItemRatingText">Belum ada rating.</p>
                        <button class="btn btn-primary mt-3" id="openRatingFromDetailBtn" style="background: linear-gradient(45deg, var(--accent-green), var(--accent-blue)); border: none;">Beri Rating</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="py-5 mt-5" style="background: var(--secondary-dark); border-top: 1px solid rgba(255,255,255,0.1);">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5 class="mb-3">
                    <i class="fa fa-recycle me-2"></i>ReUse Mart
                </h5>
                <p class="text-muted">Marketplace terpercaya untuk barang bekas berkualitas. Bersama kita ciptakan masa depan yang lebih berkelanjutan.</p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-light"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-light"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-light"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-light"><i class="fab fa-whatsapp fa-lg"></i></a>
                </div>
            </div>
            <div class="col-md-2">
                <h6>Kategori</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-muted text-decoration-none">Elektronik</a></li>
                    <li><a href="#" class="text-muted text-decoration-none">Furniture</a></li>
                    <li><a href="#" class="text-muted text-decoration-none">Otomotif</a></li>
                    <li><a href="#" class="text-muted text-decoration-none">Fashion</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <h6>Bantuan</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-muted text-decoration-none">FAQ</a></li>
                    <li><a href="#" class="text-muted text-decoration-none">Cara Beli</a></li>
                    <li><a href="#" class="text-muted text-decoration-none">Cara Jual</a></li>
                    <li><a href="#" class="text-muted text-decoration-none">Kontak</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const historyItemsRow = document.getElementById('historyItemsRow');
        const ratingModal = new bootstrap.Modal(document.getElementById('ratingModal'));
        const detailModal = new bootstrap.Modal(document.getElementById('detailModal')); // Inisialisasi modal detail
        const modalItemTitle = document.getElementById('modalItemTitle');
        const modalItemIdInput = document.getElementById('modalItemId');
        const modalRatingStarsContainer = document.getElementById('modalRatingStars');
        const modalRatingText = document.getElementById('modalRatingText');
        const selectedRatingValueInput = document.getElementById('selectedRatingValue');
        const submitRatingBtn = document.getElementById('submitRatingBtn');

        // Elemen-elemen untuk Modal Detail Barang
        const detailItemImage = document.getElementById('detailItemImage');
        const detailItemTitle = document.getElementById('detailItemTitle');
        const detailItemDescription = document.getElementById('detailItemDescription');
        const detailItemPrice = document.getElementById('detailItemPrice');
        const detailItemDate = document.getElementById('detailItemDate');
        const detailItemRatingDisplay = document.getElementById('detailItemRatingDisplay');
        const detailItemRatingText = document.getElementById('detailItemRatingText');
        const openRatingFromDetailBtn = document.getElementById('openRatingFromDetailBtn');

        let currentItemBeingRated = null; // To keep track of the item whose rating is being submitted

        // Function to render stars for display (on the product card and detail modal)
        function renderDisplayStars(container, ratingValue) {
            container.innerHTML = ''; // Clear existing stars
            for (let i = 1; i <= 5; i++) {
                // Use fa-solid for filled stars and fa-regular for empty stars
                const starClass = i <= ratingValue ? 'fa-solid fa-star filled' : 'fa-regular fa-star';
                container.innerHTML += `<i class="${starClass}" data-value="${i}"></i>`; // Add data-value for consistency
            }
        }

        // Function to render stars in the modal (interactive)
        function renderModalStars(ratingValue, isHover = false) {
            const stars = Array.from(modalRatingStarsContainer.children);
            stars.forEach((star, index) => {
                // Use fa-solid for filled stars and fa-regular for empty stars
                if (index < ratingValue) {
                    star.classList.remove('fa-regular', 'fa-star-o');
                    star.classList.add('fa-solid', 'fa-star', 'filled');
                } else {
                    star.classList.remove('fa-solid', 'fa-star', 'filled');
                    star.classList.add('fa-regular', 'fa-star');
                }
            });

            if (isHover) {
                modalRatingText.textContent = `Anda memberi ${ratingValue} bintang`;
            } else {
                if (ratingValue === 0) {
                    modalRatingText.textContent = 'Pilih jumlah bintang Anda';
                } else {
                    modalRatingText.textContent = `Anda memilih ${ratingValue} bintang`;
                }
            }
        }

        // Function to create a product card element
        function createProductCard(item, rating = 0) {
            // Determine the correct item ID property from the backend response
            // We use 'id_barang' if it exists, otherwise fallback to 'id' (Laravel's default primary key)
            const itemId = item.id_barang || item.id; 
            // If itemId is still undefined (shouldn't happen if API returns data), handle gracefully
            if (!itemId) {
                console.warn('Item ID is missing for item:', item);
                return null; // Don't create card if no ID
            }

            const col = document.createElement('div');
            col.className = 'col-lg-3 col-md-6';
            col.innerHTML = `
                <div class="history-card" data-item-id="${itemId}">
                    <img src="${item.gambar_barang || 'https://via.placeholder.com/400x250?text=No+Image'}" alt="${item.nama_barang}" class="history-image">
                    <div class="history-info">
                        <h5 class="history-title">${item.nama_barang}</h5>
                        <p class="history-description">${item.deskripsi_barang}</p>
                        <div class="history-price">Rp ${new Intl.NumberFormat('id-ID').format(item.harga_barang)}</div>
                        <div class="history-date">Dibeli pada: ${new Date(item.tgl_laku).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' })}</div>
                        <div class="rating-display" data-rating="${item.rating}"></div>
                        <p class="rating-text-display">Belum ada rating.</p>
                    </div>
                </div>
            `;
            return col;
        }

        // Fetch items and their ratings on page load
        async function fetchItemsAndRatings() {
            historyItemsRow.innerHTML = '<div class="col-12 text-center text-muted">Memuat riwayat pembelian...</div>'; // Loading message

            try {
                // Step 1: Fetch purchased items using the correct endpoint and handle the 'data' property
                const itemsResponse = await fetch('/api/barang/terjual', { // Using the correct endpoint
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        // Add any authorization headers if needed
                    }
                });

                if (!itemsResponse.ok) {
                    throw new Error(`Failed to fetch purchased items! status: ${itemsResponse.status}`);
                }

                const responseData = await itemsResponse.json(); // Get the entire response object

                // Ensure 'data' property exists and is an array
                const items = responseData.data || []; 
                if (!Array.isArray(items)) {
                    throw new Error('API response data is not an array.'); // Add explicit validation
                }
                
                historyItemsRow.innerHTML = ''; // Clear loading message

                if (items.length === 0) {
                    historyItemsRow.innerHTML = '<div class="col-12 text-center text-muted">Anda belum memiliki riwayat pembelian.</div>';
                    return;
                }

                // Step 2: For each item, fetch its rating and display the card
                for (const item of items) {
                    // Determine the correct item ID property from the backend response
                    const itemId = item.id_barang || item.id; 
                    if (!itemId) {
                        console.error('Skipping item due to missing ID:', item);
                        continue; // Skip this item if no valid ID found
                    }

                    let rating = 0; // Default rating if not found
                    try {
                        // Use the determined itemId for the rating API call
                        const ratingResponse = await fetch(`/api/barang/${itemId}/rating`, { 
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                // Add any authorization headers if needed
                            }
                        });
                        
                        if (ratingResponse.ok) {
                            const ratingData = await ratingResponse.json();
                            rating = ratingData.rating || 0; // Assuming the API returns { "rating": X }
                        } else if (ratingResponse.status === 404) {
                            console.warn(`No rating found for item ${itemId}.`);
                        } else {
                            console.error(`Error fetching rating for ${itemId}: ${ratingResponse.status}`);
                        }
                    } catch (error) {
                        console.error(`Network error fetching rating for ${itemId}:`, error);
                    }

                    const card = createProductCard(item, rating);
                    if (card) { // Only append if card was successfully created (i.e., had an ID)
                        historyItemsRow.appendChild(card);
                        const ratingDisplayContainer = card.querySelector('.rating-display');
                        const ratingDisplayText = card.querySelector('.rating-text-display');
                        
                        renderDisplayStars(ratingDisplayContainer, rating);
                        if (rating > 0) {
                            ratingDisplayText.textContent = `Rating: ${rating} bintang`;
                        } else {
                            ratingDisplayText.textContent = 'Belum ada rating.';
                        }
                    }
                }

            } catch (error) {
                console.error('Error loading history items:', error);
                historyItemsRow.innerHTML = `<div class="col-12 text-center text-danger">Gagal memuat riwayat pembelian: ${error.message}</div>`;
            }
        }

        // --- Perubahan Logika di sini ---

        // Event listener untuk membuka modal detail barang ketika kartu diklik
        historyItemsRow.addEventListener('click', async function(event) {
            const card = event.target.closest('.history-card');
            if (card) {
                const itemId = card.dataset.itemId;
                if (!itemId) {
                    console.error('Item ID not found on clicked card.');
                    return;
                }

                try {
                    // Panggil API /api/barang/{id} untuk mendapatkan detail barang
                    const detailResponse = await fetch(`/api/barang/${itemId}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            // Add any authorization headers if needed
                        }
                    });

                    if (!detailResponse.ok) {
                        throw new Error(`Failed to fetch item details! status: ${detailResponse.status}`);
                    }

                    const itemDetail = await detailResponse.json();
                    
                    // Pastikan respons memiliki properti 'data' jika API Anda mengembalikannya dalam bentuk { "data": {...} }
                    const item = itemDetail.data || itemDetail; // Sesuaikan dengan struktur respons API Anda

                    let rating = 0;
                    try {
                        const ratingResponse = await fetch(`/api/barang/${itemId}/rating`, {
                            method: 'GET',
                            headers: { 'Content-Type': 'application/json' }
                        });
                        if (ratingResponse.ok) {
                            const ratingData = await ratingResponse.json();
                            rating = ratingData.rating || 0;
                        } else if (ratingResponse.status === 404) {
                            console.warn(`No rating found for item ${itemId} when fetching details.`);
                        } else {
                            console.error(`Error fetching rating for ${itemId} in detail modal: ${ratingResponse.status}`);
                        }
                    } catch (error) {
                        console.error(`Network error fetching rating for ${itemId} in detail modal:`, error);
                    }

                    // Isi data ke dalam modal detail
                    detailItemImage.src = item.gambar_barang || 'https://via.placeholder.com/400x250?text=No+Image';
                    detailItemTitle.textContent = item.nama_barang;
                    detailItemDescription.textContent = item.deskripsi_barang;
                    detailItemPrice.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(item.harga_barang)}`;
                    detailItemDate.textContent = `Dibeli pada: ${new Date(item.tgl_laku).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' })}`;
                    
                    renderDisplayStars(detailItemRatingDisplay, rating);
                    if (rating > 0) {
                        detailItemRatingText.textContent = `Rating: ${rating} bintang`;
                    } else {
                        detailItemRatingText.textContent = 'Belum ada rating.';
                    }

                    // Set data-item-id pada tombol "Beri Rating" di modal detail
                    openRatingFromDetailBtn.dataset.itemId = itemId;
                    openRatingFromDetailBtn.dataset.itemTitle = item.nama_barang;
                    openRatingFromDetailBtn.dataset.currentRating = rating;

                    detailModal.show(); // Tampilkan modal detail barang

                } catch (error) {
                    console.error('Error fetching item details:', error);
                    alert(`Gagal memuat detail barang: ${error.message}`);
                }
            }
        });

        // Event listener untuk tombol "Beri Rating" di dalam modal detail
        openRatingFromDetailBtn.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            const itemTitle = this.dataset.itemTitle;
            const currentRating = parseInt(this.dataset.currentRating || 0);

            // Sembunyikan modal detail dulu
            detailModal.hide(); 

            // Isi data ke modal rating
            modalItemTitle.textContent = itemTitle;
            modalItemIdInput.value = itemId;
            selectedRatingValueInput.value = currentRating;
            renderModalStars(currentRating);
            
            currentItemBeingRated = document.querySelector(`.history-card[data-item-id="${itemId}"]`);

            ratingModal.show(); // Tampilkan modal rating
        });


        // Event listener for when the modal is shown
        document.getElementById('ratingModal').addEventListener('shown.bs.modal', function () {
            const currentRating = parseInt(selectedRatingValueInput.value || 0);
            renderModalStars(currentRating); // Ensure stars are rendered correctly on modal show
        });

        // Event listeners for star interaction in the modal
        modalRatingStarsContainer.addEventListener('click', function(event) {
            const clickedStar = event.target.closest('i');
            if (clickedStar) {
                const newRating = parseInt(clickedStar.dataset.value);
                selectedRatingValueInput.value = newRating; // Update the hidden input
                renderModalStars(newRating); // Render based on clicked value
            }
        });

        modalRatingStarsContainer.addEventListener('mouseover', function(event) {
            const hoveredStar = event.target.closest('i');
            if (hoveredStar) {
                const hoverRating = parseInt(hoveredStar.dataset.value);
                renderModalStars(hoverRating, true); // Render based on hover value, and indicate it's a hover
            }
        });

        modalRatingStarsContainer.addEventListener('mouseout', function() {
            const currentRating = parseInt(selectedRatingValueInput.value || 0);
            renderModalStars(currentRating); // Revert to the selected rating (or 0 if none selected)
        });

        // Event listener for submitting the rating
        submitRatingBtn.addEventListener('click', async function() {
            const itemId = modalItemIdInput.value;
            const rating = parseInt(selectedRatingValueInput.value);

            if (rating === 0) {
                alert('Silakan pilih jumlah bintang sebelum mengirim rating.');
                return;
            }

            try {
                const response = await fetch('/api/barang/rating', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token
                    },
                    body: JSON.stringify({ item_id: itemId, rating: rating })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Gagal mengirim rating.');
                }

                const result = await response.json();
                console.log('Rating submitted successfully:', result);
                alert('Terima kasih! Rating Anda telah disimpan.');

                // Update the rating on the card in the history view
                if (currentItemBeingRated) {
                    const ratingDisplayContainer = currentItemBeingRated.querySelector('.rating-display');
                    const ratingDisplayText = currentItemBeingRated.querySelector('.rating-text-display');
                    ratingDisplayContainer.dataset.rating = rating;
                    renderDisplayStars(ratingDisplayContainer, rating);
                    ratingDisplayText.textContent = `Rating: ${rating} bintang`;
                }

                ratingModal.hide();
            } catch (error) {
                console.error('Error submitting rating:', error);
                alert(`Gagal menyimpan rating: ${error.message}`);
            }
        });

        // Initial fetch of items and ratings when the page loads
        fetchItemsAndRatings();
    });
</script>
</body>
</html>