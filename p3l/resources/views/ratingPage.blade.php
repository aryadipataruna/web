<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReUse Mart - Rating Penitip Terbaik</title>
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

        /* Rating Card Styles */
        .rating-card {
            background: var(--card-dark);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .rating-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border-color: var(--accent-green);
        }

        /* Styling for the Font Awesome face icon as an avatar */
        .avatar-icon {
            font-size: 5rem; /* Larger size for impact */
            margin-bottom: 1rem;
            background: linear-gradient(45deg, var(--accent-green), var(--accent-blue));
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            border: 3px solid rgba(0, 255, 136, 0.5); /* Subtle border effect */
            border-radius: 50%; /* Makes it circular */
            padding: 10px; /* Padding inside the circular border */
            width: 120px; /* Explicit width to help with centering */
            height: 120px; /* Explicit height */
            display: flex;
            align-items: center;
            justify-content: center;
        }


        .penitip-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--text-light);
            margin-bottom: 0.5rem;
        }

        .penitip-location {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .star-rating .fa-star,
        .star-rating .fa-star-half-alt {
            color: var(--star-gold);
            font-size: 1.5rem;
            margin: 0 2px;
        }

        .star-rating .fa-star-o { /* For empty stars */
            color: var(--text-muted);
            font-size: 1.5rem;
            margin: 0 2px;
            opacity: 0.5;
        }

        .review-count {
            color: var(--text-muted);
            font-size: 0.85rem;
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
        }

        footer .list-unstyled a {
            transition: color 0.3s ease;
        }

        footer .list-unstyled a:hover {
            color: var(--accent-green) !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .section-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top px-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <i class="fa fa-shopping-basket"></i>ReUse <strong>Mart</strong>
        </a>
        
        <div class="search-container flex-grow-1 mx-4">
            <input class="form-control search-input" type="search" placeholder="Cari barang bekas berkualitas..." id="searchInput">
            <button class="btn search-btn" type="button">
                <i class="fa fa-search"></i>
            </button>
        </div>
        
        <div class="d-flex align-items-center">
            <a href="/#categories" class="nav-link text-light me-2">
                <i class="fa fa-th-large me-1"></i>Kategori
            </a>
            <a href="/#products" class="nav-link text-light me-2">
                <i class="fa fa-shopping-bag me-1"></i>Produk
            </a>
            <a href="#" class="nav-link text-light me-2">
                <i class="fa fa-shopping-cart me-1"></i>Keranjang
            </a>
            <a href="/historyPage" class="nav-link text-light me-2">
                <i class="fa fa-clock-rotate-left me-1"></i>History
            </a>
            <a href="/ratingPage" class="nav-link text-light me-2">
                <i class="fa fa-person me-1"></i>Best Seller
            </a>
            <a href="/login-regis" class="nav-link text-light">
                <i class="fa fa-user me-1"></i>Masuk
            </a>
        </div>
    </div>
</nav>

<section class="py-5" style="margin-top: 80px;">
    <div class="container">
        <h2 class="section-title">Rating Penitip Terbaik</h2>
        <div class="row g-4 justify-content-center" id="penitipRatings">
            <div class="col-md-4 col-sm-6">
                <div class="rating-card">
                    <i class="fa-solid fa-face-smile avatar-icon"></i>
                    <h5 class="penitip-name">John Doe</h5>
                    <p class="penitip-location"><i class="fa fa-map-marker-alt me-1"></i>Jakarta</p>
                    <div class="star-rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half-alt"></i>
                    </div>
                    <p class="review-count">(4.5 dari 5 Bintang - 120 Ulasan)</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="rating-card">
                    <i class="fa-solid fa-face-smile avatar-icon"></i>
                    <h5 class="penitip-name">Jane Smith</h5>
                    <p class="penitip-location"><i class="fa fa-map-marker-alt me-1"></i>Surabaya</p>
                    <div class="star-rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <p class="review-count">(5.0 dari 5 Bintang - 95 Ulasan)</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="rating-card">
                    <i class="fa-solid fa-face-smile avatar-icon"></i>
                    <h5 class="penitip-name">Peter Jones</h5>
                    <p class="penitip-location"><i class="fa fa-map-marker-alt me-1"></i>Bandung</p>
                    <div class="star-rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half-alt"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                    <p class="review-count">(3.5 dari 5 Bintang - 60 Ulasan)</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="rating-card">
                    <i class="fa-solid fa-face-smile avatar-icon"></i>
                    <h5 class="penitip-name">Maria Garcia</h5>
                    <p class="penitip-location"><i class="fa fa-map-marker-alt me-1"></i>Yogyakarta</p>
                    <div class="star-rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                    <p class="review-count">(4.0 dari 5 Bintang - 88 Ulasan)</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="rating-card">
                    <i class="fa-solid fa-face-smile avatar-icon"></i>
                    <h5 class="penitip-name">David Lee</h5>
                    <p class="penitip-location"><i class="fa fa-map-marker-alt me-1"></i>Medan</p>
                    <div class="star-rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <p class="review-count">(5.0 dari 5 Bintang - 150 Ulasan)</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="rating-card">
                    <i class="fa-solid fa-face-smile avatar-icon"></i>
                    <h5 class="penitip-name">Sarah Brown</h5>
                    <p class="penitip-location"><i class="fa fa-map-marker-alt me-1"></i>Makassar</p>
                    <div class="star-rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half-alt"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                    <p class="review-count">(3.5 dari 5 Bintang)</p>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5 class="mb-3">
                    <i class="fa fa-shopping-basket"></i>ReUse <strong>Mart</strong>
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
    document.addEventListener('DOMContentLoaded', async () => {
        const penitipRatingsContainer = document.getElementById('penitipRatings');
        const loadingMessage = document.getElementById('loadingMessage');

        // Function to generate star icons based on a rating
        function getStarRatingHtml(rating, reviewCount) {
            let starsHtml = '';
            const fullStars = Math.floor(rating);

            for (let i = 0; i < fullStars; i++) {
                starsHtml += '<i class="fa fa-star"></i>';
            }

            const emptyStars = 5 - Math.ceil(rating);
            for (let i = 0; i < emptyStars; i++) {
                starsHtml += '<i class="fa fa-star-o"></i>';
            }
            return `<div class="star-rating">${starsHtml}</div><p class="review-count">(${rating.toFixed(1)} dari 5 Bintang )</p>`;
        }

        try {
            // 1. Fetch all penitip data
            const penitipResponse = await fetch('/api/penitip');
            if (!penitipResponse.ok) {
                throw new Error(`HTTP error! status: ${penitipResponse.status}`);
            }
            const penitipData = await penitipResponse.json();

            // Clear loading message
            loadingMessage.remove();

            if (penitipData && penitipData.length > 0) {
                // Use Promise.all to fetch all ratings concurrently
                const penitipWithRatingsPromises = penitipData.map(async (penitip) => {
                    try {
                        const ratingResponse = await fetch(`/api/penitip/${penitip.id}/rating`);
                        if (!ratingResponse.ok) {
                            console.warn(`Could not fetch rating for penitip ID ${penitip.id}: HTTP status ${ratingResponse.status}`);
                            return { ...penitip, rating: 0, reviewCount: 0 }; // Default if rating fails
                        }
                        const ratingData = await ratingResponse.json();
                        return { 
                            ...penitip, 
                            rating: ratingData.averageRating || 0, // Assuming API returns { averageRating: X, reviewCount: Y }
                            reviewCount: ratingData.reviewCount || 0
                        };
                    } catch (error) {
                        console.error(`Error fetching rating for penitip ID ${penitip.id}:`, error);
                        return { ...penitip, rating: 0, reviewCount: 0 }; // Default on error
                    }
                });

                const penitipWithRatings = await Promise.all(penitipWithRatingsPromises);

                // Sort penitip by rating in descending order
                penitipWithRatings.sort((a, b) => b.rating - a.rating);

                // Render penitip cards
                penitipWithRatings.forEach(penitip => {
                    const cardHtml = `
                        <div class="col-md-4 col-sm-6">
                            <div class="rating-card">
                                <i class="fa-solid fa-face-smile avatar-icon"></i>
                                <h5 class="penitip-name">${penitip.NAMA_PENITIP || 'Nama Penitip'}</h5>
                                <p class="penitip-location"><i class="fa fa-map-marker-alt me-1"></i>${penitip.ALAMAT_PENITIP || 'Lokasi Tidak Diketahui'}</p>
                                ${getStarRatingHtml(penitip.RATING, penitip.reviewCount)}
                            </div>
                        </div>
                    `;
                    penitipRatingsContainer.insertAdjacentHTML('beforeend', cardHtml);
                });
            } else {
                penitipRatingsContainer.innerHTML = '<div class="col-12 text-center text-muted">Tidak ada data penitip yang ditemukan.</div>';
            }

        } catch (error) {
            console.error('Error fetching penitip data or ratings:', error);
            loadingMessage.remove(); // Remove loading message even on error
            penitipRatingsContainer.innerHTML = `
                <div class="col-12 text-center text-danger">
                    <p>Gagal memuat data penitip. Silakan coba lagi nanti.</p>
                    <p class="small text-muted">Detail error: ${error.message}</p>
                </div>
            `;
        }
    });
</script>
</body>
</html>