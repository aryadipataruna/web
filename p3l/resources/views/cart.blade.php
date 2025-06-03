<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja Anda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        .quantity-input::-webkit-outer-spin-button,
        .quantity-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .quantity-input[type=number] {
            -moz-appearance: textfield;
        }
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        .modal-content {
            background-color: white;
            padding: 24px;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
        }
        .body-no-scroll {
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-100">

    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex flex-col sm:flex-row justify-between items-center">
            <div class="text-2xl font-bold text-green-600 mb-2 sm:mb-0">ReUseMart</div>
            <div class="w-full sm:w-1/2 lg:w-1/3">
                <div class="relative">
                    <input type="text" placeholder="Cari di TokoKita" class="w-full py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
            <div class="flex items-center space-x-4 mt-2 sm:mt-0">
                <a href="#" class="text-gray-600 hover:text-green-600 relative">
                    <i class="fas fa-shopping-cart fa-lg"></i>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center" id="cartIconCount">0</span>
                </a>
                <a href="#" class="text-gray-600 hover:text-green-600"><i class="fas fa-bell fa-lg"></i></a>
                <a href="#" class="text-gray-600 hover:text-green-600"><i class="fas fa-user-circle fa-lg"></i></a>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-semibold mb-6 text-gray-800">Keranjang</h1>

        <div class="flex flex-col lg:flex-row gap-8">
            <div class="w-full lg:w-2/3">
                <div class="bg-white p-6 rounded-lg shadow-lg" id="cartListContainer">
                    </div>
            </div>

            <div class="w-full lg:w-1/3">
                <div class="bg-white p-6 rounded-lg shadow-lg sticky top-24" id="cartSummaryContainer">
                    </div>
            </div>
        </div>

        <div id="checkoutSection" class="mt-12 hidden">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Checkout</h2>
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="w-full lg:w-2/3 space-y-6">
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-semibold text-gray-700">Alamat Pengiriman</h3>
                            <button id="changeAddressButton" class="text-sm text-green-600 hover:underline">Ganti Alamat</button>
                        </div>
                        <div id="currentShippingAddressDisplay" class="text-gray-600 text-sm">
                            </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Pesanan</h3>
                        <div id="checkoutOrderItemsContainer" class="space-y-4">
                            </div>
                    </div>

                    <div id="paymentMethodSelectionContainer" class="bg-white p-6 rounded-lg shadow-lg">
                        <div class="flex justify-between items-center mb-3">
                                <h3 class="text-lg font-semibold text-gray-700">Metode Pembayaran</h3>
                        </div>
                        <div class="space-y-3">
                                <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition-all">
                                    <input type="radio" name="paymentMethod" value="bank_transfer" class="form-radio h-4 w-4 text-green-600 focus:ring-green-500" checked>
                                    <i class="fas fa-university fa-lg mx-3 text-gray-600 w-[40px] text-center"></i>
                                    <span class="text-sm text-gray-700 flex-grow">Bank Transfer (Upload Bukti)</span>
                                        <i class="fas fa-chevron-right text-gray-400"></i>
                                </label>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/3">
                    <div id="checkoutSummaryContainer" class="bg-white p-6 rounded-lg shadow-lg sticky top-24">
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div id="addressModal" class="modal-overlay hidden">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Daftar Alamat</h2>
                <button id="closeAddressModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times fa-lg"></i>
                </button>
            </div>
            <div class="mb-4 border-b">
                <nav class="flex space-x-4">
                    <button class="pb-2 border-b-2 border-green-500 text-green-600 font-medium">Semua Alamat</button>
                    <button class="pb-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700">Dari Teman</button>
                </nav>
            </div>
            <div class="mb-4">
                <input type="text" placeholder="Tulis Nama Alamat/Kota/Kecamatan tujuan pengiriman" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <button class="w-full border-2 border-green-500 text-green-600 py-2 rounded-lg hover:bg-green-50 transition duration-200 mb-4">
                Tambah Alamat Baru
            </button>
            <div id="addressListContainerModal" class="space-y-3">
                </div>
        </div>
    </div>


    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <span id="currentYear"></span> ReUseMart. Semua hak dilindungi.</p>
        </div>
    </footer>

    <script>
        // ========== 0. LOCALSTORAGE HELPER FUNCTIONS ==========
        function loadCartFromLocalStorage() {
            const storedCart = localStorage.getItem('shoppingCart');
            if (storedCart) {
                try {
                    const parsedCart = JSON.parse(storedCart);
                    // Adapt items from localStorage to the structure expected by this page's state
                    return parsedCart.map(item => ({
                        id: item.id || `TEMP_ID_${Math.random().toString(36).substr(2, 9)}`, // Beri ID sementara jika tidak ada
                        name: item.name || "Nama Produk Tidak Ada",
                        description: item.description || "", // Deskripsi dari halaman detail mungkin tidak ada
                        notes: item.capacity || "", // 'capacity' dari halaman detail jadi 'notes' di sini
                        price: parseFloat(item.price) || 0,
                        originalPrice: item.originalPrice || null, // Mungkin tidak ada di halaman detail
                        quantity: parseInt(item.quantity) || 1,
                        checked: item.checked !== undefined ? item.checked : false, // Default 'checked' ke false jika baru dari localStorage
                        store: item.store || "ReUseMart Store", // Beri default store jika tidak ada
                        image: item.image || 'https://placehold.co/100x100/E0E0E0/757575?text=No+Image'
                    }));
                } catch (e) {
                    console.error("Error parsing cart from localStorage:", e);
                    localStorage.removeItem('shoppingCart'); // Hapus data korup
                    return []; // Kembalikan array kosong jika parsing gagal
                }
            }
            // Jika tidak ada di localStorage, bisa gunakan data contoh atau array kosong
            // Untuk aplikasi nyata, kembalikan array kosong:
            return [];
            // Untuk testing dengan data contoh jika localStorage kosong (hapus atau komentari baris 'return [];' di atas):
            /*
            return [
                { id: "P001", name: "ASUS ROG ZEPHYRUS G16 GU603VI RTX4070", description: "i7 13620H, 32GB RAM, 1TB SSD, W11, 16.0\" FHD 165Hz", notes: "NON BUNDLING, 16GB 1TBSSD", price: 24479000, originalPrice: 24499000, quantity: 1, checked: false, store: "Top Tech Comp", image: "https://placehold.co/100x100/E0E0E0/757575?text=Laptop+Gaming" },
                { id: "P002", name: "Apple iPhone 11 | 11 Pro | 11 Pro Max", description: "512GB 256GB 64GB Second iBox", notes: "iPhone 11, Face ID 64gb", price: 3880000, originalPrice: null, quantity: 1, checked: false, store: "GudangGadget", image: "https://placehold.co/100x100/E0E0E0/757575?text=iPhone+11" }
            ];
            */
        }

        function saveCartToLocalStorage() {
            // Simpan hanya data yang relevan untuk persistensi keranjang
            // Properti seperti 'checked' mungkin tidak perlu disimpan jika ingin default saat load ulang
            const itemsToSave = state.cartItems.map(item => ({
                id: item.id,
                name: item.name,
                price: item.price,
                capacity: item.notes, // Kembalikan 'notes' menjadi 'capacity' untuk konsistensi dengan halaman detail
                image: item.image,
                quantity: item.quantity,
                store: item.store,
                // Opsional: simpan juga properti lain jika diperlukan
                description: item.description,
                originalPrice: item.originalPrice,
                checked: item.checked // Simpan status checked agar tidak hilang saat refresh
            }));
            localStorage.setItem('shoppingCart', JSON.stringify(itemsToSave));
        }


        // ========== 1. STATE & DATA ==========
        const state = {
            cartItems: loadCartFromLocalStorage(), // MODIFIKASI: Muat dari localStorage
            stores: [ // Data toko bisa juga dinamis dari backend
                { name: "Top Tech Comp", logo: "https://placehold.co/24x24/28A745/FFFFFF?text=T" },
                { name: "GudangGadget", logo: "https://placehold.co/24x24/4A90E2/FFFFFF?text=G" },
                { name: "ReUseMart Store", logo: "https://placehold.co/24x24/FFA500/FFFFFF?text=R" } // Default store
            ],
            userAvailablePoints: 5000, // Ganti dengan data user asli
            addresses: [
                { id: "ADDR001", label: "Kos", recipientName: "Daniel", phone: "081227803688", fullAddress: "Kost Swargaloka 19A, Caturtunggal, Depok, Kab. Sleman, D.I. Yogyakarta, 55281", isPinpointed: true, isPrimary: true },
                { id: "ADDR002", label: "Rumah Nenek", recipientName: "Nenek Siti", phone: "081xxxxxxxxx", fullAddress: "Jl. Merpati Putih No. 10, Kota Bahagia, 12345", isPinpointed: false, isPrimary: false }
            ],
            selectedAddressId: "ADDR001", // Default alamat terpilih
            checkout: {
                totalShippingCost: 0,
                redeemedPointsAmount: 0,
                orderConfirmed: false,
                paymentTimerInterval: null,
                paymentTimeout: null,
                currentOrderId: null
            }
        };

        // ========== 2. UTILITIES ==========
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
        }

        // ========== 3. RENDER FUNCTIONS ==========

        function renderCartListDOM() {
            const container = document.getElementById('cartListContainer');
            if (!container) return;

            const storesMap = new Map();
            state.cartItems.forEach(item => {
                if (!storesMap.has(item.store)) {
                    storesMap.set(item.store, []);
                }
                storesMap.get(item.store).push(item);
            });

            if (state.cartItems.length === 0) {
                container.innerHTML = `<div class="text-center py-8 text-gray-500 empty-cart-message">
                    <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                    <p class="text-lg">Keranjang belanja Anda kosong.</p>
                    <a href="/home" class="text-green-600 hover:underline mt-2 inline-block">Mulai belanja</a> </div>`;
                document.getElementById('cartIconCount').textContent = '0';
                renderCartSummaryDOM(); // Pastikan summary juga update
                return;
            }

            const selectedCount = state.cartItems.filter(i => i.checked).length;
            const allItemsChecked = state.cartItems.length > 0 && selectedCount === state.cartItems.length;

            let html = `
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                    <label class="flex items-center space-x-2 text-gray-700">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-green-600 rounded focus:ring-green-500" id="selectAllItems" ${allItemsChecked ? 'checked' : ''}>
                        <span>Pilih Semua (<span id="totalSelectedCount">${selectedCount}</span>)</span>
                    </label>
                    <button class="text-red-500 hover:text-red-700 font-medium" id="removeSelectedBtn" ${selectedCount === 0 ? 'disabled' : ''}>
                        <i class="fas fa-trash-alt mr-1"></i> Hapus
                    </button>
                </div>
            `;

            storesMap.forEach((items, storeName) => {
                const storeDetails = state.stores.find(s => s.name === storeName);
                const storeItemsChecked = items.every(item => item.checked);
                const storeCheckboxId = `store-checkbox-${storeName.replace(/\s+/g, '-')}`;

                html += `
                    <div class="mb-8 store-group" data-store-name="${storeName}">
                        <div class="flex items-center mb-4">
                            <input type="checkbox" id="${storeCheckboxId}" class="form-checkbox h-5 w-5 text-green-600 rounded store-checkbox" data-store="${storeName}" ${storeItemsChecked ? 'checked' : ''}>
                            <img src="${storeDetails?.logo || 'https://placehold.co/24x24/CCCCCC/FFFFFF?text=?'}" alt="Logo ${storeName}" class="w-6 h-6 rounded-full ml-3 mr-2">
                            <h3 class="font-semibold text-gray-800">${storeName}</h3>
                        </div>`;

                items.forEach(item => {
                    const itemCheckboxId = `item-checkbox-${item.id}`;
                    html += `
                        <div class="flex flex-col sm:flex-row items-start sm:items-center py-4 border-t border-gray-200 product-item" data-product-id="${item.id}">
                            <input type="checkbox" id="${itemCheckboxId}" class="form-checkbox h-5 w-5 text-green-600 rounded item-checkbox self-center sm:self-auto mb-2 sm:mb-0" data-id="${item.id}" ${item.checked ? 'checked' : ''}>
                            <img src="${item.image}" alt="Gambar ${item.name}" class="w-24 h-24 object-cover rounded-lg mx-4" onerror="this.onerror=null;this.src='https://placehold.co/100x100/E0E0E0/757575?text=No+Image';">
                            <div class="flex-grow">
                                <h4 class="font-medium text-gray-800">${item.name}</h4>
                                <p class="text-sm text-gray-500">${item.description || ''}</p>
                                <p class="text-xs text-gray-400 mt-1">${item.notes || ''}</p>
                                <div class="mt-2">
                                    <span class="text-lg font-bold text-green-600">${formatRupiah(item.price)}</span>
                                    ${item.originalPrice ? `<span class="text-sm text-gray-400 line-through ml-2">${formatRupiah(item.originalPrice)}</span>` : ''}
                                </div>
                            </div>
                            <div class="flex items-center space-x-3 mt-3 sm:mt-0 self-center sm:self-auto">
                                <button class="text-gray-500 hover:text-red-500 action-btn" data-action="wishlist" data-id="${item.id}" title="Tambahkan ke wishlist"><i class="far fa-heart"></i></button>
                                <button class="text-gray-500 hover:text-red-500 action-btn" data-action="remove-item" data-id="${item.id}" title="Hapus item"><i class="far fa-trash-alt"></i></button>
                                <div class="flex items-center border border-gray-300 rounded-md">
                                    <button class="px-2 py-1 text-gray-700 hover:bg-gray-200 rounded-l-md quantity-btn" data-action="decrease" data-id="${item.id}" ${item.quantity <= 1 ? 'disabled' : ''}>-</button>
                                    <input type="number" class="w-12 text-center border-0 quantity-input focus:ring-0" value="${item.quantity}" min="1" data-id="${item.id}">
                                    <button class="px-2 py-1 text-gray-700 hover:bg-gray-200 rounded-r-md quantity-btn" data-action="increase" data-id="${item.id}">+</button>
                                </div>
                            </div>
                        </div>`;
                });
                html += `</div>`;
            });
            container.innerHTML = html;
            document.getElementById('cartIconCount').textContent = state.cartItems.reduce((sum, item) => sum + item.quantity, 0); // Hitung total kuantitas
            bindCartEvents();
        }

        function renderCartSummaryDOM() {
            const container = document.getElementById('cartSummaryContainer');
            if (!container) return;

            const selectedItems = state.cartItems.filter(item => item.checked);
            const subtotal = selectedItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);

            // Simulasi biaya pengiriman (bisa lebih kompleks di aplikasi nyata)
            let initialShippingCost = 0;
            if (selectedItems.length > 0) {
                 initialShippingCost = subtotal < 1500000 && subtotal > 0 ? 100000 : 0; // Gratis ongkir jika subtotal >= 1.5jt atau jika 0
            }
            const total = subtotal + initialShippingCost;

            container.innerHTML = `
                <h2 class="text-xl font-semibold mb-4 pb-3 border-b border-gray-200 text-gray-800">Ringkasan belanja</h2>
                <div class="bg-blue-50 border border-blue-200 p-3 rounded-lg mb-4 flex items-center">
                    <i class="fas fa-mobile-alt text-blue-500 text-xl mr-3"></i>
                    <div>
                        <p class="text-sm text-blue-700 font-medium">Verifikasi nomor HP biar bisa pakai promo!</p>
                        <a href="#" class="text-xs text-blue-600 hover:underline">Verifikasi sekarang ></a>
                    </div>
                </div>
                <div class="flex justify-between mb-2 text-gray-700">
                    <span>Total Harga (<span id="summaryItemCount">${selectedItems.length}</span> barang)</span>
                    <span id="summarySubtotal">${formatRupiah(subtotal)}</span>
                </div>
                <div class="flex justify-between mb-2 text-gray-700">
                    <span>Biaya Pengiriman Awal</span>
                    <span id="summaryShipping">${formatRupiah(initialShippingCost)}</span>
                </div>
                <div class="border-t border-gray-200 my-3"></div>
                <div class="flex justify-between items-center font-semibold text-lg text-gray-800">
                    <span>Total Sementara</span>
                    <span id="summaryTotal" class="text-green-600">${formatRupiah(total)}</span>
                </div>
                <button id="proceedToCheckoutButton" class="w-full bg-green-600 text-white py-3 rounded-lg mt-6 font-semibold hover:bg-green-700 transition duration-200 ${selectedItems.length === 0 ? 'opacity-50 cursor-not-allowed' : ''}" ${selectedItems.length === 0 ? 'disabled' : ''}>
                    Lanjut ke Pembayaran (<span id="checkoutItemCount">${selectedItems.length}</span>)
                </button>
            `;
            const proceedBtn = document.getElementById('proceedToCheckoutButton');
            if(proceedBtn) proceedBtn.addEventListener('click', handleProceedToCheckout);
        }

        // ... (Sisa fungsi renderCheckoutOrderItemsDOM, renderCheckoutSummaryDOM, dll. tetap sama) ...
        function renderCheckoutOrderItemsDOM() {
            const container = document.getElementById('checkoutOrderItemsContainer');
            if (!container) return;
            container.innerHTML = '';

            const selectedCartItems = state.cartItems.filter(item => item.checked);
            const storesMap = new Map();
            selectedCartItems.forEach(item => {
                if (!storesMap.has(item.store)) {
                    storesMap.set(item.store, []);
                }
                storesMap.get(item.store).push(item);
            });

            storesMap.forEach((items, storeName) => {
                const storeDetails = state.stores.find(s => s.name === storeName);
                const storeDiv = document.createElement('div');
                storeDiv.className = 'mb-6 pb-4 border-b border-gray-200 last:border-b-0 last:pb-0 last:mb-0';

                let itemsHTML = '';
                items.forEach(item => {
                    itemsHTML += `
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center">
                                <img src="${item.image}" alt="Gambar ${item.name}" class="w-12 h-12 object-cover rounded-md mr-3" onerror="this.onerror=null;this.src='https://placehold.co/48x48/E0E0E0/757575?text=No+Img';">
                                <div>
                                    <p class="text-sm font-medium text-gray-800">${item.name}</p>
                                    <p class="text-xs text-gray-500">${item.quantity} x ${formatRupiah(item.price)}</p>
                                </div>
                            </div>
                            <p class="text-sm font-semibold text-gray-800">${formatRupiah(item.quantity * item.price)}</p>
                        </div>
                    `;
                });

                storeDiv.innerHTML = `
                    <div class="flex items-center mb-3">
                        <img src="${storeDetails?.logo || 'https://placehold.co/24x24/CCCCCC/FFFFFF?text=?'}" alt="Logo ${storeName}" class="w-5 h-5 rounded-full mr-2">
                        <h4 class="font-medium text-gray-700">${storeName}</h4>
                    </div>
                    ${itemsHTML}
                `;
                container.appendChild(storeDiv);
            });
        }

        function renderCheckoutSummaryDOM() {
            const container = document.getElementById('checkoutSummaryContainer');
            if (!container || state.checkout.orderConfirmed) {
                if (container && state.checkout.orderConfirmed) {
                    const userPointsDisplay = container.querySelector('#userAvailablePointsDisplay');
                    if(userPointsDisplay) userPointsDisplay.textContent = `${state.userAvailablePoints} poin`;
                }
                return;
            }

            const selectedCartItems = state.cartItems.filter(item => item.checked);
            const subtotal = selectedCartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);

            let totalCheckoutShipping = 0;
            if (selectedCartItems.length > 0) {
                totalCheckoutShipping = subtotal < 1500000 && subtotal > 0 ? 100000 : 0;
            }
            state.checkout.totalShippingCost = totalCheckoutShipping;


            let pointsEarned = 0;
            let bonusPoints = 0;
            if (subtotal > 0) {
                pointsEarned = Math.floor(subtotal / 10000);
                if (subtotal > 500000) {
                    bonusPoints = Math.floor(pointsEarned * 0.20);
                }
            }

            const pointsRedeemedValue = state.checkout.redeemedPointsAmount * 10000; // Asumsi 1 poin = Rp 10.000
            const discount = 0;
            const finalTotal = Math.max(0, subtotal + totalCheckoutShipping - discount - pointsRedeemedValue);

            container.innerHTML = `
                <h2 class="text-xl font-semibold mb-4 pb-3 border-b border-gray-200 text-gray-800">Ringkasan Pembayaran</h2>
                <div class="flex justify-between mb-2 text-gray-700 text-sm">
                    <span>Total Harga (<span id="checkoutSummaryItemCountVal">${selectedCartItems.length}</span> barang)</span>
                    <span id="checkoutSummarySubtotalVal">${formatRupiah(subtotal)}</span>
                </div>
                <div class="flex justify-between mb-2 text-gray-700 text-sm">
                    <span>Total Ongkos Kirim</span>
                    <span id="checkoutSummaryShippingVal">${formatRupiah(totalCheckoutShipping)}</span>
                </div>
                <div class="flex justify-between mb-2 text-gray-700 text-sm">
                    <span>Diskon Barang</span>
                    <span id="checkoutSummaryDiscountVal" class="text-red-500">-${formatRupiah(discount)}</span>
                </div>

                <div class="mt-3 pt-3 border-t border-gray-200 space-y-1 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Poin yang Didapat:</span>
                        <span id="checkoutPointsEarnedVal">${pointsEarned} poin</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Bonus Poin:</span>
                        <span id="checkoutBonusPointsVal">${bonusPoints} poin</span>
                    </div>
                </div>

                <div class="mt-3 pt-3 border-t border-gray-200">
                    <label for="redeemPointsInput" class="block text-sm font-medium text-gray-700">Tukar Poin Anda</label>
                    <p class="text-xs text-gray-500 mb-1">Saldo Poin Anda: <span id="userAvailablePointsDisplay">${state.userAvailablePoints}</span> poin</p>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="number" id="redeemPointsInput" placeholder="Jumlah poin" class="form-input flex-1 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300 p-2" value="${state.checkout.redeemedPointsAmount > 0 ? state.checkout.redeemedPointsAmount : ''}">
                        <button id="applyRedeemPointsButton" class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-green-500">
                            Tukarkan
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Poin Digunakan: <span id="checkoutPointsRedeemedValueVal" class="text-red-500">-${formatRupiah(pointsRedeemedValue)}</span></p>
                </div>

                <div class="border-t border-gray-200 my-3"></div>
                <div class="flex justify-between items-center font-semibold text-lg text-gray-800">
                    <span>Total Tagihan</span>
                    <span id="checkoutSummaryTotalVal" class="text-green-600">${formatRupiah(finalTotal)}</span>
                </div>

                <div id="paymentTimerDisplay" class="mt-4 text-center text-blue-600 font-semibold hidden"></div>

                <div id="uploadProofSection" class="mt-4 hidden">
                    <label for="paymentProofInput" class="block text-sm font-medium text-gray-700 mb-1">Upload Bukti Pembayaran</label>
                    <input type="file" id="paymentProofInput" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 mb-2">
                    <span id="fileNameDisplay" class="text-xs text-gray-500 block mb-2"></span>
                    <button id="confirmPaymentProofButton" class="w-full bg-blue-500 text-white py-2 rounded-lg font-semibold hover:bg-blue-600 transition duration-200">
                        Konfirmasi Pembayaran
                    </button>
                </div>
                <div id="paymentStatusMessage" class="mt-2 text-center font-medium hidden p-3 rounded-md"></div>
                <button id="payNowButton" class="w-full bg-green-500 text-white py-3 rounded-lg mt-6 font-semibold hover:bg-green-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    Bayar Sekarang
                </button>
            `;
            bindCheckoutSummaryEvents();
        }

        function renderCurrentShippingAddress() {
            const displayElement = document.getElementById('currentShippingAddressDisplay');
            if (!displayElement) return;

            const selectedAddr = state.addresses.find(addr => addr.id === state.selectedAddressId);
            if (selectedAddr) {
                displayElement.innerHTML = `
                    <p class="font-medium">${selectedAddr.recipientName} - ${selectedAddr.label} ${selectedAddr.isPrimary ? '<span class="text-xs bg-green-100 text-green-700 px-1.5 py-0.5 rounded-full ml-1">Utama</span>' : ''}</p>
                    <p>${selectedAddr.fullAddress}</p>
                    <p>${selectedAddr.phone}</p>
                `;
            } else {
                displayElement.innerHTML = `<p class="text-red-500">Alamat belum dipilih.</p>`;
            }
        }

        function renderAddressListModal() {
            const container = document.getElementById('addressListContainerModal');
            if (!container) return;
            let html = '';
            state.addresses.forEach(addr => {
                const isSelected = addr.id === state.selectedAddressId;
                html += `
                    <div class="p-3 border rounded-lg cursor-pointer hover:bg-gray-50 ${isSelected ? 'border-green-500 ring-2 ring-green-500' : 'border-gray-300'}" data-address-id="${addr.id}">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="font-semibold text-gray-800">${addr.label}</span>
                                ${addr.isPrimary ? '<span class="text-xs bg-green-100 text-green-700 px-1.5 py-0.5 rounded-full ml-1">Utama</span>' : ''}
                                <p class="text-sm text-gray-600">${addr.recipientName} (${addr.phone})</p>
                                <p class="text-sm text-gray-500">${addr.fullAddress}</p>
                                ${addr.isPinpointed ? '<p class="text-xs text-blue-500 mt-1"><i class="fas fa-map-marker-alt mr-1"></i> Sudah Pinpoint</p>' : ''}
                            </div>
                            ${isSelected ? '<i class="fas fa-check-circle text-green-500 text-xl"></i>' : ''}
                        </div>
                        <div class="mt-2 pt-2 border-t border-gray-200 flex space-x-3 text-sm">
                            <button class="text-green-600 hover:underline">Share</button>
                            <button class="text-green-600 hover:underline">Ubah Alamat</button>
                        </div>
                    </div>
                `;
            });
            container.innerHTML = html;
            bindAddressModalEvents();
        }


        // ========== 4. EVENT HANDLERS & LOGIC ==========

        function handleCartItemCheck(itemId, checked) {
            const item = state.cartItems.find(i => i.id === itemId);
            if (item) item.checked = checked;
            saveCartToLocalStorage(); // MODIFIKASI: Simpan perubahan
            renderCartListDOM();
            renderCartSummaryDOM();
        }

        function handleStoreItemCheck(storeName, checked) {
            state.cartItems.filter(i => i.store === storeName).forEach(i => i.checked = checked);
            saveCartToLocalStorage(); // MODIFIKASI: Simpan perubahan
            renderCartListDOM();
            renderCartSummaryDOM();
        }

        function handleSelectAllItems(checked) {
            state.cartItems.forEach(item => item.checked = checked);
            saveCartToLocalStorage(); // MODIFIKASI: Simpan perubahan
            renderCartListDOM();
            renderCartSummaryDOM();
        }

        function handleRemoveItem(itemId) {
            state.cartItems = state.cartItems.filter(i => i.id !== itemId);
            saveCartToLocalStorage(); // MODIFIKASI: Simpan perubahan
            renderCartListDOM();
            renderCartSummaryDOM();
            if (!document.getElementById('checkoutSection').classList.contains('hidden') && !state.checkout.orderConfirmed) {
                renderCheckoutOrderItemsDOM();
                renderCheckoutSummaryDOM();
            }
        }

        function handleRemoveSelectedItems() {
            const selectedItemsCount = state.cartItems.filter(item => item.checked).length;
            if (selectedItemsCount === 0) {
                alert("Tidak ada item yang dipilih untuk dihapus.");
                return;
            }
            if (confirm(`Anda yakin ingin menghapus ${selectedItemsCount} item yang dipilih?`)) {
                state.cartItems = state.cartItems.filter(item => !item.checked);
                saveCartToLocalStorage(); // MODIFIKASI: Simpan perubahan
                renderCartListDOM();
                renderCartSummaryDOM();
                if (!document.getElementById('checkoutSection').classList.contains('hidden') && !state.checkout.orderConfirmed) {
                    renderCheckoutOrderItemsDOM();
                    renderCheckoutSummaryDOM();
                }
            }
        }


        function handleUpdateQuantity(itemId, action) {
            const item = state.cartItems.find(i => i.id === itemId);
            if (item) {
                if (action === 'increase') item.quantity++;
                else if (action === 'decrease') item.quantity = Math.max(1, item.quantity - 1);
            }
            saveCartToLocalStorage(); // MODIFIKASI: Simpan perubahan
            renderCartListDOM();
            renderCartSummaryDOM();
            if (!document.getElementById('checkoutSection').classList.contains('hidden') && !state.checkout.orderConfirmed) {
                renderCheckoutOrderItemsDOM();
                renderCheckoutSummaryDOM();
            }
        }

        function handleChangeQuantityInput(itemId, newQuantity) {
            const item = state.cartItems.find(i => i.id === itemId);
            if (item) {
                item.quantity = Math.max(1, parseInt(newQuantity) || 1);
            }
            saveCartToLocalStorage(); // MODIFIKASI: Simpan perubahan
            renderCartListDOM();
            renderCartSummaryDOM();
            if (!document.getElementById('checkoutSection').classList.contains('hidden') && !state.checkout.orderConfirmed) {
                renderCheckoutOrderItemsDOM();
                renderCheckoutSummaryDOM();
            }
        }
        // ... (Sisa fungsi handleProceedToCheckout, handleApplyRedeemPoints, dll. tetap sama) ...
        function handleProceedToCheckout() {
            const selectedItems = state.cartItems.filter(item => item.checked);
            if (selectedItems.length === 0) {
                alert("Pilih barang terlebih dahulu untuk melanjutkan ke pembayaran.");
                return;
            }
            state.checkout.orderConfirmed = false;
            state.checkout.redeemedPointsAmount = 0;
            state.checkout.totalShippingCost = 0;
            state.checkout.currentOrderId = null;

            renderCheckoutOrderItemsDOM();
            renderCheckoutSummaryDOM();
            renderCurrentShippingAddress();

            const checkoutSection = document.getElementById('checkoutSection');
            if (checkoutSection) checkoutSection.classList.remove('hidden');

            const paymentMethodContainer = document.getElementById('paymentMethodSelectionContainer');
            if (paymentMethodContainer) paymentMethodContainer.classList.remove('hidden');

            const payNowBtn = document.getElementById('payNowButton');
            if (payNowBtn) {
                payNowBtn.classList.remove('hidden');
                payNowBtn.disabled = false;
            }

            const uploadSection = document.getElementById('uploadProofSection');
            if (uploadSection) uploadSection.classList.add('hidden');
             const fileNameDisp = document.getElementById('fileNameDisplay');
            if(fileNameDisp) fileNameDisp.textContent = '';
            const proofInpt = document.getElementById('paymentProofInput');
            if(proofInpt) proofInpt.value = '';


            const timerDisp = document.getElementById('paymentTimerDisplay');
            if (timerDisp) timerDisp.classList.add('hidden');

            const statusMsg = document.getElementById('paymentStatusMessage');
            if (statusMsg) statusMsg.classList.add('hidden');

            const redeemInpt = document.getElementById('redeemPointsInput');
            if (redeemInpt) {
                redeemInpt.value = '';
                redeemInpt.disabled = false;
            }

            const applyRedeemBtn = document.getElementById('applyRedeemPointsButton');
            if (applyRedeemBtn) applyRedeemBtn.disabled = false;

            if (checkoutSection) checkoutSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        function handleApplyRedeemPoints() {
            if (state.checkout.orderConfirmed) return;
            const inputElement = document.getElementById('redeemPointsInput');
            let redeemAmount = parseInt(inputElement.value) || 0;

            if (redeemAmount < 0) {
                alert("Jumlah poin tidak valid.");
                redeemAmount = 0;
            }
            if (redeemAmount > state.userAvailablePoints) {
                alert(`Anda hanya dapat menukarkan maksimal ${state.userAvailablePoints} poin.`);
                redeemAmount = state.userAvailablePoints;
            }

            const selectedCartItems = state.cartItems.filter(item => item.checked);
            const subtotal = selectedCartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);

            let totalCheckoutShipping = 0;
            if (selectedCartItems.length > 0) {
                totalCheckoutShipping = subtotal < 1500000 && subtotal > 0 ? 100000 : 0;
            }

            const discount = 0;
            const currentBillBeforePoints = subtotal + totalCheckoutShipping - discount;
            const maxPointsToRedeemBasedOnBill = Math.floor(Math.max(0, currentBillBeforePoints) / 10000);


            if (redeemAmount > maxPointsToRedeemBasedOnBill) {
                alert(`Anda tidak dapat menukarkan poin melebihi total tagihan. Maksimal poin untuk ditukar: ${maxPointsToRedeemBasedOnBill}`);
                redeemAmount = maxPointsToRedeemBasedOnBill;
            }

            state.checkout.redeemedPointsAmount = redeemAmount;
            inputElement.value = state.checkout.redeemedPointsAmount > 0 ? state.checkout.redeemedPointsAmount : '';
            renderCheckoutSummaryDOM();
        }

        function startPaymentProcess() {
            if (state.checkout.orderConfirmed) return;

            // Simulasi proses pembuatan pesanan di backend
            state.checkout.currentOrderId = "NOTA-" + new Date().getFullYear() +
                ('0' + (new Date().getMonth() + 1)).slice(-2) +
                ('0' + new Date().getDate()).slice(-2) + "-" +
                Math.random().toString(36).substr(2, 6).toUpperCase();
            console.log("Pesanan dibuat dengan ID (simulasi):", state.checkout.currentOrderId);


            const payNowButton = document.getElementById('payNowButton');
            const paymentMethodSelectionContainer = document.getElementById('paymentMethodSelectionContainer');
            const uploadProofSection = document.getElementById('uploadProofSection');
            const paymentStatusMessage = document.getElementById('paymentStatusMessage');
            const timerDisplay = document.getElementById('paymentTimerDisplay');

            if (payNowButton) payNowButton.classList.add('hidden');
            if (paymentMethodSelectionContainer) paymentMethodSelectionContainer.classList.add('hidden');
            if (uploadProofSection) uploadProofSection.classList.remove('hidden');
            if (paymentStatusMessage) paymentStatusMessage.classList.add('hidden');

            if (timerDisplay) {
                timerDisplay.classList.remove('hidden');
                let timeLeft = 1 * 60 * 60; // 1 jam dalam detik

                clearInterval(state.checkout.paymentTimerInterval);
                clearTimeout(state.checkout.paymentTimeout);

                function formatTime(seconds) {
                    const h = Math.floor(seconds / 3600);
                    const m = Math.floor((seconds % 3600) / 60);
                    const s = seconds % 60;
                    return `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                }
                timerDisplay.innerHTML = `Selesaikan pembayaran dalam: <strong class="text-red-500">${formatTime(timeLeft)}</strong>`;


                state.checkout.paymentTimerInterval = setInterval(() => {
                    timeLeft--;
                    timerDisplay.innerHTML = `Selesaikan pembayaran dalam: <strong class="text-red-500">${formatTime(timeLeft)}</strong>`;
                    if (timeLeft <= 0) {
                        clearInterval(state.checkout.paymentTimerInterval);
                        handlePaymentTimeout();
                    }
                }, 1000);
                state.checkout.paymentTimeout = setTimeout(handlePaymentTimeout, timeLeft * 1000);
            } else {
                console.error("Error: paymentTimerDisplay not found in startPaymentProcess");
            }
        }

        function handlePaymentTimeout() {
            if (state.checkout.orderConfirmed) return;

            clearInterval(state.checkout.paymentTimerInterval);
            const timerDisplay = document.getElementById('paymentTimerDisplay');
            if(timerDisplay) timerDisplay.classList.add('hidden');

            const uploadSection = document.getElementById('uploadProofSection');
            if(uploadSection) uploadSection.classList.add('hidden');

            const statusMessage = document.getElementById('paymentStatusMessage');
            if(statusMessage) {
                statusMessage.textContent = "Waktu habis, pesanan dibatalkan. Poin dikembalikan.";
                statusMessage.className = 'mt-2 text-center font-medium p-3 rounded-md bg-red-100 text-red-700';
                statusMessage.classList.remove('hidden');
            }

            const payNowButton = document.getElementById('payNowButton');
            if(payNowButton) payNowButton.classList.remove('hidden');

            const paymentMethodContainer = document.getElementById('paymentMethodSelectionContainer');
            if(paymentMethodContainer) paymentMethodContainer.classList.remove('hidden');

            const redeemInput = document.getElementById('redeemPointsInput');
            const applyPointsBtn = document.getElementById('applyRedeemPointsButton');
            if(redeemInput) redeemInput.disabled = false;
            if(applyPointsBtn) applyPointsBtn.disabled = false;

            state.checkout.redeemedPointsAmount = 0;
            if(redeemInput) redeemInput.value = '';
            renderCheckoutSummaryDOM();
            console.log("Barang simulasi tersedia kembali (jika ada logika stok).");
            state.checkout.currentOrderId = null;
        }

        function handleConfirmPaymentProof() {
            if (state.checkout.orderConfirmed) return;

            const proofInput = document.getElementById('paymentProofInput');
            if (proofInput.files.length === 0) {
                alert("Mohon upload bukti pembayaran Anda.");
                return;
            }
            const isProofValid = true;

            clearInterval(state.checkout.paymentTimerInterval);
            clearTimeout(state.checkout.paymentTimeout);

            const timerDisplay = document.getElementById('paymentTimerDisplay');
            if(timerDisplay) timerDisplay.classList.add('hidden');

            const uploadSection = document.getElementById('uploadProofSection');
            if(uploadSection) uploadSection.classList.add('hidden');


            if (isProofValid) {
                state.checkout.orderConfirmed = true;
                const statusMessage = document.getElementById('paymentStatusMessage');
                if(statusMessage) {
                    statusMessage.textContent = "Bukti pembayaran diterima. Pesanan sedang disiapkan.";
                    statusMessage.className = 'mt-2 text-center font-medium p-3 rounded-md bg-green-100 text-green-700';
                    statusMessage.classList.remove('hidden');
                }

                const payNowButton = document.getElementById('payNowButton');
                if(payNowButton) payNowButton.classList.add('hidden');

                const paymentMethodContainer = document.getElementById('paymentMethodSelectionContainer');
                if(paymentMethodContainer) paymentMethodContainer.classList.add('hidden');

                const redeemInput = document.getElementById('redeemPointsInput');
                const applyPointsBtn = document.getElementById('applyRedeemPointsButton');
                if(redeemInput) redeemInput.disabled = true;
                if(applyPointsBtn) applyPointsBtn.disabled = true;

                const subtotal = state.cartItems.filter(i => i.checked).reduce((sum, item) => sum + (item.price * item.quantity), 0);
                let pointsEarnedTx = Math.floor(subtotal / 10000);
                let bonusPointsTx = 0;
                if (subtotal > 500000) {
                   bonusPointsTx = Math.floor(pointsEarnedTx * 0.20);
                }
                state.userAvailablePoints = state.userAvailablePoints - state.checkout.redeemedPointsAmount + pointsEarnedTx + bonusPointsTx;

                // Simpan item yang tidak dicheckout
                const itemsToKeep = state.cartItems.filter(item => !item.checked);
                state.cartItems = itemsToKeep;
                saveCartToLocalStorage(); // MODIFIKASI: Simpan keranjang yang sudah dikurangi item yang dicheckout

                // Redirect ke nota setelah beberapa saat agar user sempat lihat pesan sukses
                const orderIdForNota = state.checkout.currentOrderId;
                if (orderIdForNota) {
                    console.log('Pembayaran berhasil, memuat PDF nota untuk pesanan: ' + orderIdForNota + ' di tab ini.');
                    setTimeout(() => {
                        window.location.href = `/penjualan/nota/${orderIdForNota}/pdf`;
                    }, 3000); // Tunggu 3 detik sebelum redirect
                } else {
                    console.error('ID Pesanan tidak ditemukan untuk generate nota.');
                    alert('Terjadi kesalahan, ID pesanan tidak ditemukan.');
                     // Jika tidak ada redirect, refresh halaman keranjang untuk menunjukkan item yang tersisa
                    setTimeout(() => {
                        renderCartListDOM();
                        renderCartSummaryDOM();
                        document.getElementById('checkoutSection').classList.add('hidden'); // Sembunyikan lagi section checkout
                    }, 3000);
                }
            } else {
                // Ini tidak akan terpanggil jika isProofValid selalu true
                handlePaymentTimeout();
            }
        }


        function openAddressModal() {
            renderAddressListModal();
            document.getElementById('addressModal').classList.remove('hidden');
            document.body.classList.add('body-no-scroll');
        }

        function closeAddressModal() {
            document.getElementById('addressModal').classList.add('hidden');
            document.body.classList.remove('body-no-scroll');
        }

        function handleSelectAddress(addressId) {
            state.selectedAddressId = addressId;
            renderCurrentShippingAddress();
            closeAddressModal();
        }


        // ========== 5. BIND EVENTS ==========
        function bindCartEvents() {
            const cartContainer = document.getElementById('cartListContainer');
            if (!cartContainer) return;

            cartContainer.addEventListener('change', (e) => {
                if (e.target.id === 'selectAllItems') {
                    handleSelectAllItems(e.target.checked);
                } else if (e.target.classList.contains('store-checkbox')) {
                    handleStoreItemCheck(e.target.dataset.store, e.target.checked);
                } else if (e.target.classList.contains('item-checkbox')) {
                    handleCartItemCheck(e.target.dataset.id, e.target.checked);
                } else if (e.target.classList.contains('quantity-input')) {
                    handleChangeQuantityInput(e.target.dataset.id, e.target.value);
                }
            });

            cartContainer.addEventListener('click', (e) => {
                const targetButton = e.target.closest('button');
                if (!targetButton) return;

                if (targetButton.id === 'removeSelectedBtn') {
                    handleRemoveSelectedItems();
                } else if (targetButton.classList.contains('action-btn') && targetButton.dataset.action === 'remove-item') {
                     const itemId = targetButton.dataset.id;
                     const itemToRemove = state.cartItems.find(i => i.id === itemId);
                     if (itemToRemove && confirm(`Anda yakin ingin menghapus "${itemToRemove.name}" dari keranjang?`)) {
                        handleRemoveItem(itemId);
                    }
                } else if (targetButton.classList.contains('quantity-btn')) {
                    handleUpdateQuantity(targetButton.dataset.id, targetButton.dataset.action);
                }
            });
        }

        function bindCheckoutSummaryEvents() {
            const applyPointsButton = document.getElementById('applyRedeemPointsButton');
            if (applyPointsButton) {
                applyPointsButton.onclick = handleApplyRedeemPoints;
            }
            const payNowButton = document.getElementById('payNowButton');
            if (payNowButton) {
                payNowButton.onclick = startPaymentProcess;
            }
            const confirmProofButton = document.getElementById('confirmPaymentProofButton');
            if (confirmProofButton) {
                confirmProofButton.onclick = handleConfirmPaymentProof;
            }
            const proofInput = document.getElementById('paymentProofInput');
            if (proofInput) {
                proofInput.addEventListener('change', function() {
                    const fileNameDisplay = document.getElementById('fileNameDisplay');
                    if (this.files.length > 0) {
                        if(fileNameDisplay) fileNameDisplay.textContent = `File dipilih: ${this.files[0].name}`;
                    } else {
                        if(fileNameDisplay) fileNameDisplay.textContent = '';
                    }
                });
            }
        }

        function bindAddressModalEvents() {
            const modal = document.getElementById('addressModal');
            if (!modal) return;

            document.getElementById('closeAddressModal')?.addEventListener('click', closeAddressModal);
            modal.addEventListener('click', (e) => {
                if (e.target === modal) { // Klik di luar konten modal
                    closeAddressModal();
                }
            });

            const addressListContainer = document.getElementById('addressListContainerModal');
            if(addressListContainer) {
                addressListContainer.addEventListener('click', (e) => {
                    const addressDiv = e.target.closest('div[data-address-id]');
                    if (addressDiv) {
                        handleSelectAddress(addressDiv.dataset.addressId);
                    }
                });
            }
        }


        // ========== 6. INIT ==========
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('currentYear').textContent = new Date().getFullYear();
            renderCartListDOM();
            renderCartSummaryDOM();
            renderCurrentShippingAddress(); // Panggil ini untuk set alamat awal di checkout section

            const changeAddrBtn = document.getElementById('changeAddressButton');
            if(changeAddrBtn) changeAddrBtn.addEventListener('click', openAddressModal);

            // Hapus checkout section dari DOM jika tidak ada item yang dicheckout (initial state)
            // Atau pastikan ia benar-benar tersembunyi dan baru muncul saat checkout
            const checkoutSection = document.getElementById('checkoutSection');
            if (checkoutSection && state.cartItems.filter(item => item.checked).length === 0) {
                // checkoutSection.classList.add('hidden'); // Pastikan tersembunyi
            }
        });
    </script>
</body>
</html>
