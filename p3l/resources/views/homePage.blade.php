<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReUse Mart - Marketplace Barang Bekas Berkualitas</title>
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
        }

        * {
            scroll-behavior: smooth;
        }

        body {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 100%);
            color: var(--text-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
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

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, rgba(0, 255, 136, 0.1) 0%, rgba(0, 170, 255, 0.1) 100%);
            padding: 80px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, var(--accent-green), var(--accent-blue));
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: fadeInUp 1s ease-out;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease-out 0.2s both;
        }

        /* About Us Section */
        .about-section {
            padding: 80px 0;
            background: rgba(255, 255, 255, 0.02);
        }

        .about-card {
            background: var(--card-dark);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .about-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border-color: var(--accent-green);
        }

        .about-icon {
            font-size: 3rem;
            background: linear-gradient(45deg, var(--accent-green), var(--accent-blue));
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }

        /* Category Section */
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

        .category-card {
            background: var(--card-dark);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 255, 136, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .category-card:hover::before {
            left: 100%;
        }

        .category-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 255, 136, 0.2);
            border-color: var(--accent-green);
        }

        .category-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, var(--accent-green), var(--accent-blue));
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .category-name {
            font-size: 1.3rem;
            font-weight: bold;
            color: var(--text-light);
        }

        /* Product Cards */
        .product-card {
            background: var(--card-dark);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 255, 136, 0.05), rgba(0, 170, 255, 0.05));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .product-card:hover::before {
            opacity: 1;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border-color: var(--accent-green);
        }

        .product-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-info {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 2;
        }

        .product-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: var(--text-light);
        }

        .product-description {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            flex-grow: 1;
        }

        .product-price {
            font-size: 1.3rem;
            font-weight: bold;
            background: linear-gradient(45deg, var(--accent-green), var(--accent-blue));
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(45deg, var(--accent-green), var(--accent-blue));
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        /* Floating Elements */
        .floating-element {
            position: absolute;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
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

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .category-icon {
                font-size: 2.5rem;
            }
        }

        /* Loading Animation */
        .loading-spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 4px solid rgba(0, 255, 136, 0.3);
            border-radius: 50%;
            border-top-color: var(--accent-green);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top px-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <i class="fa fa-shopping-basket"></i>ReUse <strong>Mart</strong>
        </a>
        
        <div class="search-container flex-grow-1 mx-4">
            <input class="form-control search-input" type="search" placeholder="Cari barang bekas berkualitas..." id="searchInput">
            <button class="btn search-btn" type="button">
                <i class="fa fa-search"></i>
            </button>
        </div>
        
        <div class="d-flex align-items-center">
            <a href="#categories" class="nav-link text-light me-2">
                <i class="fa fa-th-large me-1"></i>Kategori
            </a>
            <a href="#products" class="nav-link text-light me-2">
                <i class="fa fa-shopping-bag me-1"></i>Produk
            </a>
            <a href="#" class="nav-link text-light me-2">
                <i class="fa fa-shopping-cart me-1"></i>Keranjang
            </a>
            <a href="/historyPage" class="nav-link text-light me-2">
                <i class="fa fa-clock-rotate-left me-1"></i>History
            </a>
            <a href="/login-regis" class="nav-link text-light">
                <i class="fa fa-user me-1"></i>Masuk
            </a>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">
                <i class="fa fa-recycle floating-element"></i>
                ReUse Mart
            </h1>
            <p class="hero-subtitle">
                Marketplace Terpercaya untuk Barang Bekas Berkualitas
            </p>
            <div class="row justify-content-center mt-4">
                <div class="col-md-3 col-6 text-center fade-in-up">
                    <div class="display-4 text-success">
                        <i class="fa fa-check-circle"></i>
                    </div>
                    <h5>Berkualitas</h5>
                </div>
                <div class="col-md-3 col-6 text-center fade-in-up">
                    <div class="display-4 text-info">
                        <i class="fa fa-shield-alt"></i>
                    </div>
                    <h5>Terpercaya</h5>
                </div>
                <div class="col-md-3 col-6 text-center fade-in-up">
                    <div class="display-4 text-warning">
                        <i class="fa fa-tags"></i>
                    </div>
                    <h5>Harga Terjangkau</h5>
                </div>
                <div class="col-md-3 col-6 text-center fade-in-up">
                    <div class="display-4 text-success">
                        <i class="fa fa-leaf"></i>
                    </div>
                    <h5>Ramah Lingkungan</h5>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Us Section -->
<section class="about-section" id="about">
    <div class="container">
        <h2 class="section-title">Tentang ReUse Mart</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="about-card">
                    <div class="about-icon">
                        <i class="fa fa-heart"></i>
                    </div>
                    <h4>Misi Kami</h4>
                    <p>Memberikan kehidupan kedua untuk barang-barang berkualitas dan mengurangi limbah dengan menciptakan marketplace yang terpercaya untuk jual-beli barang bekas.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="about-card">
                    <div class="about-icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <h4>Komunitas</h4>
                    <p>Bergabunglah dengan ribuan pengguna yang peduli lingkungan dan cerdas berbelanja. Bersama kita ciptakan gaya hidup berkelanjutan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="about-card">
                    <div class="about-icon">
                        <i class="fa fa-star"></i>
                    </div>
                    <h4>Kualitas</h4>
                    <p>Setiap produk melalui verifikasi ketat untuk memastikan kualitas terbaik. Garansi kepuasan pelanggan adalah prioritas utama kami.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- categories section -->
<section class="py-5" id="categories">
    <div class="container">
        <h2 class="section-title">Kategori Produk</h2>
        <div class="row g-4" id="categoriesRow">
            <div class="col-12 loading-message text-center">Memuat kategori...</div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-5" id="products">
    <div class="container">
        <h2 class="section-title">Produk Terbaru</h2>
        <div class="row g-4" id="barangRow">
            <div class="col-12 loading-message text-center">Memuat data barang...</div>
        </div>
        
        <div class="text-center mt-5">
            <button class="btn btn-lg px-5 py-3" style="background: linear-gradient(45deg, var(--accent-green), var(--accent-blue)); border: none; border-radius: 50px; color: white; font-weight: bold; transition: all 0.3s ease;">
                <i class="fa fa-plus me-2"></i>Lihat Lebih Banyak
            </button>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="py-5 mt-5" style="background: var(--secondary-dark); border-top: 1px solid rgba(255,255,255,0.1);">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5 class="mb-3">
                    <i class="fa fa-shopping-basket"></i>ReUse Mart
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to fetch data from the API
        async function fetchBarang() {
            const barangRow = document.getElementById('barangRow');
            const categoriesRow = document.getElementById('categoriesRow');

            // Set initial loading messages
            barangRow.innerHTML = '<div class="col-12 text-center text-white"><span class="loading-spinner mb-3"></span><p>Memuat data barang...</p></div>';
            categoriesRow.innerHTML = '<div class="col-12 text-center text-white"><span class="loading-spinner mb-3"></span><p>Memuat kategori...</p></div>';


            try {
                // Fetch data from the API route for Barang
                // Using relative path for API endpoint
                const response = await fetch('/api/barang/tersedia', {
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
                    return responseData.data; // Return the data array
                } else {
                    // Display specific error message if API response indicates failure
                    barangRow.innerHTML = `<div class="col-12 text-center text-white error-message">Gagal memuat data barang: ${responseData.message || 'Error tidak diketahui'}</div>`;
                    categoriesRow.innerHTML = `<div class="col-12 text-center text-white error-message">Gagal memuat kategori: ${responseData.message || 'Error tidak diketahui'}</div>`;
                    console.error('API response indicates failure for Barang:', responseData);
                    return []; // Return empty array on logical error
                }

            } catch (error) {
                // Display generic error message for network or unexpected errors
                barangRow.innerHTML = `<div class="col-12 text-center text-white error-message">Error memuat data barang. Silakan cek konsol untuk detail.</div>`;
                categoriesRow.innerHTML = `<div class="col-12 text-center text-white error-message">Error memuat kategori. Silakan cek konsol untuk detail.</div>`;
                console.error("Error fetching barang data:", error);
                return []; // Return empty array on error
            }
        }

        // Function to render categories
        function renderCategories(barangData) {
            const categoriesRow = document.getElementById('categoriesRow');
            categoriesRow.innerHTML = ''; // Clear loading message

            if (barangData.length === 0) {
                categoriesRow.innerHTML = '<div class="col-12 text-center text-white">Tidak ada kategori ditemukan.</div>';
                return;
            }

            // Extract unique categories and map them to Font Awesome icons
            const categoryIcons = {
                'Elektronik': 'fa-tv',
                'Olahraga': 'fa-dumbbell',
                'Komputer': 'fa-laptop',
                'Furniture': 'fa-couch',
                'Otomotif': 'fa-car',
                'Fashion': 'fa-tshirt',
                // Add more mappings as needed
            };

            const uniqueCategories = [...new Set(barangData.map(item => item.kategori))];

            // Render each category
            uniqueCategories.forEach(category => {
                const iconClass = categoryIcons[category] || 'fa-tag'; // Default icon if not mapped
                const categoryCol = document.createElement('div');
                categoryCol.classList.add('col-lg-2', 'col-md-4', 'col-6'); // Use Bootstrap grid classes

                categoryCol.innerHTML = `
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fa ${iconClass}"></i>
                        </div>
                        <div class="category-name">${category}</div>
                    </div>
                `;
                categoriesRow.appendChild(categoryCol);
            });
        }

        // Function to render barang items
        function renderBarang(barangData) {
            const barangRow = document.getElementById('barangRow');
            barangRow.innerHTML = ''; // Clear loading message

            if (barangData.length === 0) {
                barangRow.innerHTML = '<div class="col-12 text-center text-white">Tidak ada barang ditemukan.</div>';
                return;
            }

            // Render each barang item
            barangData.forEach(item => {
                // Log the ID_BARANG to console for debugging
                console.log('Rendering item with ID_BARANG:', item.id_barang);

                const itemCol = document.createElement('div');
                itemCol.classList.add('col-lg-3', 'col-md-6', 'mb-4'); // Use Bootstrap grid classes

                // Determine badge text and color based on 'kondisi'
                let badgeText = item.kondisi || 'Tidak Diketahui';
                let badgeClass = 'product-badge';
                // You can add more logic here for specific badge colors based on condition
                // For example: if (item.kondisi === 'Baru') badgeClass += ' badge-success';

                itemCol.innerHTML = `
                    <div class="product-card" data-id="${item.id_barang}">
                        <div class="${badgeClass}">${badgeText}</div>
                        <img src="${item.gambar_barang}" class="product-image" alt="${item.nama_barang}" onerror="this.onerror=null;this.src='https://placehold.co/400x250/2a2a2a/f8f9fa?text=No+Image';">
                        <div class="product-info">
                            <h5 class="product-title">${item.nama_barang}</h5>
                            <p class="product-description">${item.deskripsi_barang}</p>
                            <div class="product-price">Rp ${item.harga_barang ? parseInt(item.harga_barang).toLocaleString('id-ID') : 'N/A'}</div>
                        </div>
                    </div>
                `;
                barangRow.appendChild(itemCol);
            });

            // Add click event listeners to the item cards after rendering
            attachItemCardListeners();
        }

        // Function to attach click listeners to item cards
        function attachItemCardListeners() {
            document.querySelectorAll('#barangRow .product-card').forEach(card => {
                card.addEventListener('click', () => {
                    const itemId = card.dataset.id; // Get the item ID from the data-id attribute

                    // Check if itemId is defined before redirecting
                    if (itemId) {
                        // Redirect to the detail page, passing the item ID as a path parameter
                        window.location.href = `/detailBarang/${itemId}`;
                    } else {
                        console.error('Error: Item ID is undefined. Cannot redirect to detail page.');
                        // Optionally, display a user-friendly message
                        // alert('Product details are not available for this item.');
                    }
                });
            });
        }


        // Initial load: Fetch data and render
        document.addEventListener('DOMContentLoaded', async () => {
            const barangData = await fetchBarang();
            renderCategories(barangData);
            renderBarang(barangData);
        });

        // Basic search functionality (client-side filtering)
        // For a real application, you'd likely implement server-side search
        document.getElementById('searchInput').addEventListener('input', (event) => {
            const searchTerm = event.target.value.toLowerCase();
            const allItems = document.querySelectorAll('#barangRow .col-lg-3'); // Get all item columns

            let foundItems = 0;
            allItems.forEach(itemCol => {
                // Get the card element within the column
                const card = itemCol.querySelector('.product-card');
                if (card) {
                    const itemName = card.querySelector('.product-title').innerText.toLowerCase();
                    const itemDescription = card.querySelector('.product-description').innerText.toLowerCase();

                    if (itemName.includes(searchTerm) || itemDescription.includes(searchTerm)) {
                        itemCol.style.display = 'block'; // Show item column
                        foundItems++;
                    } else {
                        itemCol.style.display = 'none'; // Hide item column
                    }
                }
            });

            const barangRow = document.getElementById('barangRow');
            if (foundItems === 0 && searchTerm !== '') {
                barangRow.innerHTML = '<div class="col-12 text-center text-white">Tidak ada barang yang cocok dengan pencarian Anda.</div>';
            } else if (foundItems > 0 && barangRow.querySelector('.error-message')) {
                // If items are found after a previous "no items" message, clear it
                // This scenario might happen if the search term was cleared or changed after initial no results
                // The `renderBarang` function handles the initial render if no results at start
                // For this specific client-side search, we just need to ensure the message is gone
                if (barangRow.innerHTML === '<div class="col-12 text-center text-white">Tidak ada barang yang cocok dengan pencarian Anda.</div>') {
                    // This is a bit tricky with client-side filtering.
                    // A better approach for search would be to re-render from original data.
                    // For now, we'll just let the `display: none` handle visibility.
                }
            } else if (foundItems === 0 && searchTerm === '') {
                // If search term is empty and no items were initially loaded
                if (barangRow.innerHTML === '<div class="col-12 text-center text-white">Tidak ada barang yang cocok dengan pencarian Anda.</div>') {
                    // Do nothing, the initial message is still relevant
                }
            }
            // If there are items, they will already be displayed or hidden by the loop.
        });

    </script>
</body>
</html>
