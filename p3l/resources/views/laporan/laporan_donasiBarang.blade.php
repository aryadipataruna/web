<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Owner</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Basic reset and font */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif; /* Use Poppins font */
        }

        body {
            background-color: #f0f0f0; /* Light grey background */
            color: #333; /* Default text color */
            line-height: 1.6;
        }

        .navbar {
            background-color: #1a1a1a; /* Dark background for navbar */
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar .nav-links {
            display: flex;
            gap: 20px;
        }

        .navbar .nav-links a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .navbar .nav-links a:hover {
            color: #7BC9FF; /* Highlight color on hover */
        }

        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar .user-info .user-avatar {
            width: 30px;
            height: 30px;
            background-color: #7BC9FF; /* Avatar background color */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a1a1a;
            font-weight: 700;
        }

        .navbar .user-info .user-details {
            display: flex;
            flex-direction: column;
            font-size: 0.9rem;
        }

        .navbar .user-info .user-details .role {
            font-size: 0.8rem;
            color: #ccc;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .page-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #8576FF; /* Underline title */
            padding-bottom: 10px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
            margin-bottom: 40px; /* Add margin below grid */
        }

        .dashboard-card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .dashboard-card h3 {
            color: #8576FF;
            margin-bottom: 10px;
        }

        .dashboard-card p {
            font-size: 1.1rem;
            color: #555;
        }

        .dashboard-card a {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 15px;
            background-color: #7BC9FF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .dashboard-card a:hover {
            background-color: #5aaee0;
        }

        /* Styles for data tables */
        .data-section {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .data-section h2 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 15px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .report-header { /* New style for report header */
            margin-bottom: 20px;
        }

        .report-header p {
            margin: 2px 0;
            font-size: 0.9rem;
        }
        .report-header .report-title-main {
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 10px;
        }


        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 0.9rem; /* Adjusted for more columns */
        }

        .data-table th {
            background-color: #f2f2f2;
            font-weight: 700;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .loading-message, .error-message {
            text-align: center;
            padding: 20px;
            font-size: 1.1rem;
            color: #666;
        }

        .error-message {
            color: red;
        }

        /* --- Modal Styles (Shared) --- */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 10; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            align-items: center; /* Center modal content vertically */
            justify-content: center; /* Center modal content horizontally */
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto; /* Center horizontally and vertically */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Adjust width as needed */
            max-width: 600px; /* Maximum width */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            position: relative; /* Needed for close button positioning */
        }

        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 15px;
        }

        .close-button:hover,
        .close-button:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-content h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
            border-bottom: 2px solid #8576FF;
            padding-bottom: 10px;
        }

        .modal-content label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .modal-content input[type="text"],
        .modal-content input[type="email"],
        .modal-content input[type="password"],
        .modal-content input[type="date"], /* Added date input type */
        .modal-content select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }

        .modal-content button[type="submit"] {
            background-color: #8576FF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .modal-content button[type="submit"]:hover {
            background-color: #6b60c4;
        }

        /* Error message styles (Shared) */
        .form-error-messages {
             color: red;
             font-size: 0.9rem;
             margin-bottom: 15px;
        }

        .action-buttons-group {
            display: flex;
            gap: 8px; /* Space between buttons */
            justify-content: center; /* Center buttons in the cell */
        }

        .action-buttons-group .btn-action {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .action-buttons-group .btn-correct {
            background-color: #28a745; /* Green for correct */
            color: white;
        }

        .action-buttons-group .btn-correct:hover {
            background-color: #218838;
        }

        .action-buttons-group .btn-cancel {
            background-color: #dc3545; /* Red for cancel */
            color: white;
        }

        .action-buttons-group .btn-cancel:hover {
            background-color: #c82333;
        }


        /* Responsive adjustments */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 10px;
            }

            .navbar .nav-links {
                flex-direction: column;
                align-items: center;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .data-table th,
            .data-table td {
                padding: 8px;
                font-size: 0.85rem; /* Further adjust for more columns */
            }

            .modal-content {
                width: 95%; /* Make modal wider on smaller screens */
            }
        }

        @media (max-width: 480px) {
            .page-title {
                font-size: 1.2rem;
            }
            .data-table th,
            .data-table td {
                font-size: 0.75rem; /* Further adjust for smaller screens */
                word-break: break-word; /* Prevent table overflow */
            }
        }

    </style>
</head>
<body>

    <div class="navbar">
        <div class="nav-links">
            <a href="#">Dashboard Owner</a> {{-- Highlight Owner Dashboard link --}}
            <a href="#">Pegawai</a>
            <a href="#">Organisasi</a>
            <a href="#">Merchandise</a>
            <a href="#">Pembeli</a>
            <a href="#">Penitip</a>
            <a href="#">Laporan</a>
            <a href="#">Profile</a>
        </div>
        <div class="user-info">
            <div class="user-details">
                <span>GreenTea123</span>
                <span class="role">Owner</span>
            </div>
            <div class="user-avatar">
                 <i class="fas fa-user-tie"></i> {{-- Owner icon --}}
            </div>
        </div>
    </div>

    <div class="container">
        <h1 class="page-title">Dasbor Owner - ReUse Mart</h1>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>Manajemen Pegawai</h3>
                <p>Kelola data pegawai, jabatan, dan performa.</p>
                <a href="#">Lihat Pegawai</a>
            </div>
            <div class="dashboard-card">
                <h3>Manajemen Organisasi</h3>
                <p>Kelola data organisasi mitra dan donasi.</p>
                <a href="#">Lihat Organisasi</a>
            </div>
            <div class="dashboard-card">
                <h3>Manajemen Merchandise</h3>
                <p>Kelola inventaris merchandise dan penukaran.</p>
                <a href="#">Lihat Merchandise</a>
            </div>
            <div class="dashboard-card">
                <h3>Manajemen Pembeli</h3>
                <p>Kelola data pembeli dan riwayat transaksi.</p>
                <a href="#">Lihat Pembeli</a>
            </div>
            <div class="dashboard-card">
                <h3>Manajemen Penitip</h3>
                <p>Kelola data penitip dan barang titipan.</p>
                <a href="#">Lihat Penitip</a>
            </div>
            <div class="dashboard-card">
                <h3>Laporan Keuangan</h3>
                <p>Lihat ringkasan penjualan, komisi, dan keuntungan.</p>
                <a href="#">Lihat Laporan</a>
            </div>
            <div class="dashboard-card">
                <h3>Pengaturan Sistem</h3>
                <p>Konfigurasi parameter sistem dan akses pengguna.</p>
                <a href="#">Pengaturan</a>
            </div>
        </div>

        {{-- Section for ReqDonasi Data --}}
        <div class="data-section">
            <h2>Data Permintaan Donasi</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Action</th> {{-- New Action column for ReqDonasi --}}
                        <th>ID Permintaan</th>
                        <th>ID Organisasi</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Permintaan</th>
                    </tr>
                </thead>
                <tbody id="reqdonasi-table-body">
                    <tr>
                        <td colspan="5" class="loading-message">Memuat data permintaan donasi...</td> {{-- Updated colspan --}}
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Section for Donasi Data --}}
        <div class="data-section">
            <h2>Data Donasi</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Action</th> {{-- New Action column --}}
                        <th>ID Donasi</th>
                        <th>ID Organisasi</th>
                        <th>Nama Barang Donasi</th>
                        <th>Tanggal Donasi</th>
                        <th>Nama Penerima</th>
                    </tr>
                </thead>
                <tbody id="donasi-table-body">
                    <tr>
                        <td colspan="6" class="loading-message">Memuat data donasi...</td> {{-- Updated colspan --}}
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- NEW Section for Laporan Donasi Barang --}}
        <div class="data-section">
            <h2>Laporan Donasi Barang</h2>
            <div class="report-header">
                <p style="font-weight: bold;">ReUse Mart</p>
                <p>Jl. Green Eco Park No. 456 Yogyakarta</p>
                <p class="report-title-main">LAPORAN Donasi Barang</p>
                <p>Tahun: 2025</p>
                <p>Tanggal cetak: 2 April 2025</p> {{-- Static date as per image --}}
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Id Penitip</th>
                        <th>Nama Penitip</th>
                        <th>Tanggal Donasi</th>
                        <th>Organisasi</th>
                        <th>Nama Penerima</th>
                    </tr>
                </thead>
                <tbody id="laporan-donasi-barang-table-body">
                    {{-- Example Row (dynamic content will be loaded by JavaScript) --}}
                    {{-- <tr>
                        <td>K202</td>
                        <td>Kipas angin Jumbo</td>
                        <td>T25</td>
                        <td>Adi Sanjaya</td>
                        <td>29/3/2025</td>
                        <td>Pemuda Pejuang Kebersihan</td>
                        <td>Pak Sugeng</td>
                    </tr>
                    <tr>
                        <td>K203</td>
                        <td>Kulkas 3 Pintu</td>
                        <td>T14</td>
                        <td>Gani Hendrawan</td>
                        <td>29/3/2025</td>
                        <td>Yayasan Kasih Ibu Sleman</td>
                        <td>Bu Rini</td>
                    </tr> --}}
                    <tr>
                        <td colspan="7" class="loading-message">Memuat data laporan donasi barang...</td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{-- END NEW Section for Laporan Donasi Barang --}}


        <p style="text-align: center; margin-top: 40px; color: #666;">
            Ini adalah dasbor utama untuk Owner. Konten lebih lanjut akan ditambahkan di sini.
        </p>
    </div>

    <div id="editDonasiModal" class="modal">
        <div class="modal-content">
            <span class="close-button edit-donasi-close-button">&times;</span>
            <h2>Edit Data Donasi</h2>
            <div id="editDonasiFormErrorMessages" class="form-error-messages"></div>
            <form id="editDonasiForm">
                <input type="hidden" id="editDonasiId" name="ID_DONASI">

                <label for="editTglDonasi">Tanggal Donasi:</label>
                <input type="date" id="editTglDonasi" name="TGL_DONASI" required>

                <label for="editNamaPenerima">Nama Penerima:</label>
                <input type="text" id="editNamaPenerima" name="NAMA_PENERIMA" required>

                <button type="submit">Update Donasi</button>
            </form>
        </div>
    </div>

    <div id="correctReqDonasiModal" class="modal">
        <div class="modal-content">
            <span class="close-button correct-reqdonasi-close-button">&times;</span>
            <h2>Konfirmasi Donasi</h2>
            <div id="correctReqDonasiFormErrorMessages" class="form-error-messages"></div>
            <form id="correctReqDonasiForm">
                <input type="hidden" id="correctReqDonasiId" name="ID_REQDONASI">
                <input type="hidden" id="correctReqDonasiIdOrganisasi" name="ID_ORGANISASI">
                <input type="hidden" id="correctReqDonasiNamaBarang" name="NAMA_BARANG_DONASI">

                <p>Anda akan mengkonfirmasi permintaan donasi ini menjadi donasi yang diterima.</p>
                <p><strong>ID Permintaan:</strong> <span id="displayReqDonasiId"></span></p>
                <p><strong>Organisasi:</strong> <span id="displayReqDonasiOrganisasi"></span></p>
                <p><strong>Nama Barang:</strong> <span id="displayReqDonasiNamaBarang"></span></p>
                <p><strong>Tanggal Donasi:</strong> <span id="displayTglDonasi"></span> (Otomatis hari ini)</p>

                <label for="correctNamaPenerima">Nama Penerima Donasi:</label>
                <input type="text" id="correctNamaPenerima" name="NAMA_PENERIMA" required>

                <button type="submit">Konfirmasi & Buat Donasi</button>
            </form>
        </div>
    </div>

    <script>
        // JavaScript untuk halaman Owner akan ditempatkan di sini.

        // Get references to Donasi edit modal elements
        const editDonasiModal = document.getElementById('editDonasiModal');
        const editDonasiCloseButton = editDonasiModal.querySelector('.close-button');
        const editDonasiForm = document.getElementById('editDonasiForm');
        const editDonasiFormErrorMessages = document.getElementById('editDonasiFormErrorMessages');
        const editDonasiIdInput = document.getElementById('editDonasiId');
        const editTglDonasiInput = document.getElementById('editTglDonasi');
        const editNamaPenerimaInput = document.getElementById('editNamaPenerima');

        // Get references to Correct ReqDonasi modal elements
        const correctReqDonasiModal = document.getElementById('correctReqDonasiModal');
        const correctReqDonasiCloseButton = correctReqDonasiModal.querySelector('.close-button');
        const correctReqDonasiForm = document.getElementById('correctReqDonasiForm');
        const correctReqDonasiFormErrorMessages = document.getElementById('correctReqDonasiFormErrorMessages');
        const correctReqDonasiIdInput = document.getElementById('correctReqDonasiId');
        const correctReqDonasiIdOrganisasiInput = document.getElementById('correctReqDonasiIdOrganisasi');
        const correctReqDonasiNamaBarangInput = document.getElementById('correctReqDonasiNamaBarang');
        const correctNamaPenerimaInput = document.getElementById('correctNamaPenerima');
        const displayReqDonasiId = document.getElementById('displayReqDonasiId');
        const displayReqDonasiOrganisasi = document.getElementById('displayReqDonasiOrganisasi');
        const displayReqDonasiNamaBarang = document.getElementById('displayReqDonasiNamaBarang');
        const displayTglDonasi = document.getElementById('displayTglDonasi');


        // Function to display status messages
        function showStatusMessage(message, type) {
            const statusMessageDiv = document.createElement('div'); // Create a new div for the message
            statusMessageDiv.textContent = message;
            statusMessageDiv.className = 'status'; // Reset classes
            statusMessageDiv.classList.add(type); // Add 'success' or 'error' class
            statusMessageDiv.style.display = 'block'; // Make it visible
            statusMessageDiv.style.marginTop = '20px'; // Add some margin
            statusMessageDiv.style.padding = '10px';
            statusMessageDiv.style.borderRadius = '4px';
            statusMessageDiv.style.textAlign = 'center';

            if (type === 'success') {
                statusMessageDiv.style.backgroundColor = '#d4edda';
                statusMessageDiv.style.color = '#155724';
                statusMessageDiv.style.border = '1px solid #c3e6cb';
            } else if (type === 'error') {
                statusMessageDiv.style.backgroundColor = '#f8d7da';
                statusMessageDiv.style.color = '#721c24';
                statusMessageDiv.style.border = '1px solid #f5c6cb';
            }

            document.querySelector('.container').appendChild(statusMessageDiv);

            setTimeout(() => {
                statusMessageDiv.remove();
            }, 5000);
        }


        // Function to fetch and display ReqDonasi data
        async function fetchReqDonasiData() {
            const reqDonasiTableBody = document.getElementById('reqdonasi-table-body');
            reqDonasiTableBody.innerHTML = `<tr><td colspan="5" class="loading-message">Memuat data permintaan donasi...</td></tr>`;

            try {
                const response = await fetch('/api/reqDonasi', {
                    method: 'GET',
                    headers: { 'Accept': 'application/json' }
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(`HTTP error! status: ${response.status}, Message: ${errorData.message || response.statusText}`);
                }

                const responseData = await response.json();

                if (responseData.status === true && responseData.data) {
                    renderReqDonasiTable(responseData.data);
                } else {
                    reqDonasiTableBody.innerHTML = `<tr><td colspan="5" class="error-message">Gagal memuat data permintaan donasi: ${responseData.message || 'Error tidak diketahui'}</td></tr>`;
                    console.error('API response indicates failure for ReqDonasi:', responseData);
                }

            } catch (error) {
                reqDonasiTableBody.innerHTML = `<tr><td colspan="5" class="error-message">Error memuat data permintaan donasi. Silakan cek konsol untuk detail.</td></tr>`;
                console.error('Error fetching ReqDonasi data:', error);
            }
        }

        function renderReqDonasiTable(reqDonasiData) {
            const reqDonasiTableBody = document.getElementById('reqdonasi-table-body');
            reqDonasiTableBody.innerHTML = '';

            if (reqDonasiData.length > 0) {
                reqDonasiData.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>
                            <div class="action-buttons-group">
                                <button class="btn-action btn-correct"
                                    data-id="${item.ID_REQDONASI}"
                                    data-id-organisasi="${item.ID_ORGANISASI}"
                                    data-nama-barang="${item.NAMA_BARANG_REQDONASI}">Correct</button>
                                <button class="btn-action btn-cancel" data-id="${item.ID_REQDONASI}">Cancel</button>
                            </div>
                        </td>
                        <td>${item.ID_REQDONASI}</td>
                        <td>${item.ID_ORGANISASI}</td>
                        <td>${item.NAMA_BARANG_REQDONASI}</td>
                        <td>${item.TGL_REQ}</td>
                    `;
                    reqDonasiTableBody.appendChild(row);
                });
                attachReqDonasiButtonListeners();
            } else {
                reqDonasiTableBody.innerHTML = '<tr><td colspan="5" class="loading-message">Tidak ada data permintaan donasi ditemukan.</td></tr>';
            }
        }

        function attachReqDonasiButtonListeners() {
            document.querySelectorAll('.btn-correct').forEach(button => {
                button.addEventListener('click', (event) => {
                    const reqDonasiId = event.target.dataset.id;
                    const idOrganisasi = event.target.dataset.idOrganisasi;
                    const namaBarang = event.target.dataset.namaBarang;

                    correctReqDonasiIdInput.value = reqDonasiId;
                    correctReqDonasiIdOrganisasiInput.value = idOrganisasi;
                    correctReqDonasiNamaBarangInput.value = namaBarang;

                    displayReqDonasiId.textContent = reqDonasiId;
                    displayReqDonasiOrganisasi.textContent = idOrganisasi;
                    displayReqDonasiNamaBarang.textContent = namaBarang;

                    const today = new Date();
                    const formattedDate = today.getFullYear() + '-' +
                                          String(today.getMonth() + 1).padStart(2, '0') + '-' +
                                          String(today.getDate()).padStart(2, '0');
                    displayTglDonasi.textContent = formattedDate;

                    correctReqDonasiFormErrorMessages.textContent = '';
                    correctNamaPenerimaInput.value = '';
                    correctReqDonasiModal.style.display = 'flex';
                });
            });

            document.querySelectorAll('.btn-cancel').forEach(button => {
                button.addEventListener('click', async (event) => {
                    const reqDonasiId = event.target.dataset.id;
                    if (confirm(`Apakah Anda yakin ingin membatalkan permintaan donasi ID: ${reqDonasiId}?`)) {
                        try {
                            const response = await fetch(`/api/reqDonasi/delete/${reqDonasiId}`, {
                                method: 'DELETE',
                                headers: { 'Accept': 'application/json' }
                            });
                            const result = await response.json();
                            if (response.ok && result.status === true) {
                                showStatusMessage('Permintaan donasi berhasil dibatalkan!', 'success');
                                fetchReqDonasiData();
                            } else {
                                showStatusMessage(`Gagal membatalkan permintaan donasi: ${result.message || 'Error tidak diketahui'}`, 'error');
                            }
                        } catch (error) {
                            showStatusMessage(`Error membatalkan permintaan donasi: ${error.message}`, 'error');
                            console.error('Error during cancel reqDonasi:', error);
                        }
                    }
                });
            });

            correctReqDonasiCloseButton.addEventListener('click', () => {
                correctReqDonasiModal.style.display = 'none';
                correctReqDonasiForm.reset();
                correctReqDonasiFormErrorMessages.textContent = '';
            });
        }

        correctReqDonasiForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            correctReqDonasiFormErrorMessages.textContent = '';

            const reqDonasiId = correctReqDonasiIdInput.value;
            const idOrganisasi = correctReqDonasiIdOrganisasiInput.value;
            const namaBarangDonasi = correctReqDonasiNamaBarangInput.value;
            const namaPenerima = correctNamaPenerimaInput.value;
            const tglDonasi = displayTglDonasi.textContent;

            const newDonasiData = {
                ID_ORGANISASI: idOrganisasi,
                NAMA_BARANG_DONASI: namaBarangDonasi,
                TGL_DONASI: tglDonasi,
                NAMA_PENERIMA: namaPenerima,
            };

            try {
                const createDonasiResponse = await fetch('/api/donasi/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(newDonasiData)
                });

                const createDonasiResult = await createDonasiResponse.json();

                if (!createDonasiResponse.ok || createDonasiResult.status !== true) {
                    let errorMessage = createDonasiResult.message || 'Gagal membuat donasi.';
                    if (createDonasiResult.errors) {
                        for (const field in createDonasiResult.errors) {
                            errorMessage += `\n- ${field}: ${createDonasiResult.errors[field].join(', ')}`;
                        }
                    }
                    correctReqDonasiFormErrorMessages.textContent = errorMessage;
                    showStatusMessage(`Gagal membuat donasi: ${errorMessage}`, 'error');
                    console.error('Create Donasi failed:', createDonasiResult);
                    return;
                }

                const deleteReqDonasiResponse = await fetch(`/api/reqDonasi/delete/${reqDonasiId}`, {
                    method: 'DELETE',
                    headers: { 'Accept': 'application/json' }
                });

                const deleteReqDonasiResult = await deleteReqDonasiResponse.json();

                if (deleteReqDonasiResponse.ok && deleteReqDonasiResult.status === true) {
                    showStatusMessage('Donasi berhasil dibuat dan permintaan donasi dihapus!', 'success');
                    correctReqDonasiModal.style.display = 'none';
                    correctReqDonasiForm.reset();
                    fetchReqDonasiData();
                    fetchDonasiData();
                } else {
                    showStatusMessage(`Donasi berhasil dibuat, tetapi gagal menghapus permintaan donasi: ${deleteReqDonasiResult.message || 'Error tidak diketahui'}`, 'error');
                    console.error('Delete ReqDonasi failed after Donasi creation:', deleteReqDonasiResult);
                }

            } catch (error) {
                console.error('Error selama proses konfirmasi donasi:', error);
                correctReqDonasiFormErrorMessages.textContent = `Error: ${error.message}`;
                showStatusMessage(`Error selama proses konfirmasi donasi: ${error.message}`, 'error');
            }
        });


        async function fetchDonasiData() {
            const donasiTableBody = document.getElementById('donasi-table-body');
            donasiTableBody.innerHTML = `<tr><td colspan="6" class="loading-message">Memuat data donasi...</td></tr>`;

            try {
                const response = await fetch('/api/donasi', {
                    method: 'GET',
                    headers: { 'Accept': 'application/json' }
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(`HTTP error! status: ${response.status}, Message: ${errorData.message || response.statusText}`);
                }

                const responseData = await response.json();

                if (responseData.status === true && responseData.data) {
                    renderDonasiTable(responseData.data);
                } else {
                    donasiTableBody.innerHTML = `<tr><td colspan="6" class="error-message">Gagal memuat data donasi: ${responseData.message || 'Error tidak diketahui'}</td></tr>`;
                    console.error('API response indicates failure for Donasi:', responseData);
                }

            } catch (error) {
                donasiTableBody.innerHTML = `<tr><td colspan="6" class="error-message">Error memuat data donasi. Silakan cek konsol untuk detail.</td></tr>`;
                console.error('Error fetching Donasi data:', error);
            }
        }

        function renderDonasiTable(donasiData) {
            const donasiTableBody = document.getElementById('donasi-table-body');
            donasiTableBody.innerHTML = '';

            if (donasiData.length > 0) {
                donasiData.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>
                            <a href="#" class="edit-donasi-btn" data-id="${item.ID_DONASI}">Edit</a>
                        </td>
                        <td>${item.ID_DONASI}</td>
                        <td>${item.ID_ORGANISASI}</td>
                        <td>${item.NAMA_BARANG_DONASI}</td>
                        <td>${item.TGL_DONASI}</td>
                        <td>${item.NAMA_PENERIMA}</td>
                    `;
                    donasiTableBody.appendChild(row);
                });
                attachDonasiButtonListeners();
            } else {
                donasiTableBody.innerHTML = '<tr><td colspan="6" class="loading-message">Tidak ada data donasi ditemukan.</td></tr>';
            }
        }

        function attachDonasiButtonListeners() {
            document.querySelectorAll('.edit-donasi-btn').forEach(button => {
                button.addEventListener('click', async (event) => {
                    event.preventDefault();
                    const donasiId = event.target.dataset.id;
                    editDonasiFormErrorMessages.textContent = '';

                    try {
                        const response = await fetch(`/api/donasi/${donasiId}`);
                        if (!response.ok) {
                            const errorData = await response.json();
                            throw new Error(`HTTP error! status: ${response.status}, Message: ${errorData.message || response.statusText}`);
                        }
                        const result = await response.json();
                        if (result.status === true && result.data) {
                            const donasiData = result.data;
                            editDonasiIdInput.value = donasiData.ID_DONASI;
                            editTglDonasiInput.value = donasiData.TGL_DONASI;
                            editNamaPenerimaInput.value = donasiData.NAMA_PENERIMA;
                            editDonasiModal.style.display = 'flex';
                        } else {
                            showStatusMessage(`Gagal memuat data donasi: ${result.message || 'Error tidak diketahui'}`, 'error');
                        }
                    } catch (error) {
                        showStatusMessage(`Error memuat data donasi: ${error.message}`, 'error');
                        console.error('Error fetching single Donasi data:', error);
                    }
                });
            });

            editDonasiCloseButton.addEventListener('click', () => {
                editDonasiModal.style.display = 'none';
                editDonasiForm.reset();
                editDonasiFormErrorMessages.textContent = '';
            });
        }

        editDonasiForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            editDonasiFormErrorMessages.textContent = '';

            const donasiId = editDonasiIdInput.value;
            const updatedData = {
                TGL_DONASI: editTglDonasiInput.value,
                NAMA_PENERIMA: editNamaPenerimaInput.value,
            };

            try {
                const response = await fetch(`/api/donasi/update/${donasiId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(updatedData)
                });

                const result = await response.json();

                if (response.ok && result.status === true) {
                    showStatusMessage('Data Donasi berhasil diperbarui!', 'success');
                    editDonasiModal.style.display = 'none';
                    editDonasiForm.reset();
                    fetchDonasiData();
                } else {
                    console.error('Update Donasi gagal:', result.message);
                    if (result.errors) {
                        let errorMessages = 'Kesalahan validasi:\n';
                        for (const field in result.errors) {
                            errorMessages += `- ${field}: ${result.errors[field].join(', ')}\n`;
                        }
                        editDonasiFormErrorMessages.textContent = errorMessages;
                    } else {
                        editDonasiFormErrorMessages.textContent = result.message || 'Pembaruan gagal. Silakan coba lagi.';
                    }
                }
            } catch (error) {
                console.error('Error selama pembaruan Donasi:', error);
                editDonasiFormErrorMessages.textContent = `Error memperbarui Donasi: ${error.message}`;
                showStatusMessage(`Error memperbarui Donasi: ${error.message}`, 'error');
            }
        });

        // --- JavaScript for Laporan Donasi Barang ---
        async function fetchLaporanDonasiBarangData() {
            const laporanTableBody = document.getElementById('laporan-donasi-barang-table-body');
            laporanTableBody.innerHTML = `<tr><td colspan="7" class="loading-message">Memuat data laporan donasi barang...</td></tr>`;

            try {
                // IMPORTANT: Replace '/api/laporan/donasi-barang' with your actual API endpoint for this report
                const response = await fetch('/api/laporan/donasi-barang', { // Placeholder API endpoint
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        // Add Authorization header if needed, e.g., 'Authorization': 'Bearer ' + yourAuthToken
                    }
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({ message: response.statusText })); // Graceful error parsing
                    throw new Error(`HTTP error! status: ${response.status}, Message: ${errorData.message}`);
                }

                const responseData = await response.json();

                if (responseData.status === true && responseData.data) {
                    renderLaporanDonasiBarangTable(responseData.data);
                } else {
                     // Use a sample data for demonstration if API fails or returns no data for now
                    console.warn('API response indicates failure or no data for Laporan Donasi Barang:', responseData.message || 'Data kosong atau error.');
                    showStatusMessage('Gagal memuat laporan dari API. Menampilkan data contoh.', 'error');
                    renderLaporanDonasiBarangTable([
                        { KODE_PRODUK: "K202", NAMA_PRODUK: "Kipas angin Jumbo", ID_PENITIP: "T25", NAMA_PENITIP: "Adi Sanjaya", TGL_DONASI: "29/3/2025", ORGANISASI: "Pemuda Pejuang Kebersihan", NAMA_PENERIMA: "Pak Sugeng" },
                        { KODE_PRODUK: "K203", NAMA_PRODUK: "Kulkas 3 Pintu", ID_PENITIP: "T14", NAMA_PENITIP: "Gani Hendrawan", TGL_DONASI: "29/3/2025", ORGANISASI: "Yayasan Kasih Ibu Sleman", NAMA_PENERIMA: "Bu Rini" }
                    ]); // Render with sample data
                }

            } catch (error) {
                laporanTableBody.innerHTML = `<tr><td colspan="7" class="error-message">Error memuat data laporan: ${error.message}. Menampilkan data contoh.</td></tr>`;
                console.error('Error fetching Laporan Donasi Barang data:', error);
                 // Fallback to sample data on critical error
                renderLaporanDonasiBarangTable([
                    { KODE_PRODUK: "K202", NAMA_PRODUK: "Kipas angin Jumbo", ID_PENITIP: "T25", NAMA_PENITIP: "Adi Sanjaya", TGL_DONASI: "29/3/2025", ORGANISASI: "Pemuda Pejuang Kebersihan", NAMA_PENERIMA: "Pak Sugeng" },
                    { KODE_PRODUK: "K203", NAMA_PRODUK: "Kulkas 3 Pintu", ID_PENITIP: "T14", NAMA_PENITIP: "Gani Hendrawan", TGL_DONASI: "29/3/2025", ORGANISASI: "Yayasan Kasih Ibu Sleman", NAMA_PENERIMA: "Bu Rini" },
                    { KODE_PRODUK: "L005", NAMA_PRODUK: "Lemari Pakaian Kayu", ID_PENITIP: "T08", NAMA_PENITIP: "Siti Aminah", TGL_DONASI: "30/3/2025", ORGANISASI: "Panti Asuhan Ceria", NAMA_PENERIMA: "Ibu Pengurus Panti" }
                ]);
            }
        }

        function renderLaporanDonasiBarangTable(laporanData) {
            const laporanTableBody = document.getElementById('laporan-donasi-barang-table-body');
            laporanTableBody.innerHTML = ''; // Clear loading or error message

            if (laporanData.length > 0) {
                laporanData.forEach(item => {
                    const row = document.createElement('tr');
                    // Ensure your API provides these exact field names or adjust accordingly
                    row.innerHTML = `
                        <td>${item.KODE_PRODUK || 'N/A'}</td>
                        <td>${item.NAMA_PRODUK || 'N/A'}</td>
                        <td>${item.ID_PENITIP || 'N/A'}</td>
                        <td>${item.NAMA_PENITIP || 'N/A'}</td>
                        <td>${item.TGL_DONASI || 'N/A'}</td>
                        <td>${item.ORGANISASI || 'N/A'}</td>
                        <td>${item.NAMA_PENERIMA || 'N/A'}</td>
                    `;
                    laporanTableBody.appendChild(row);
                });
            } else {
                laporanTableBody.innerHTML = '<tr><td colspan="7" class="loading-message">Tidak ada data laporan donasi barang ditemukan.</td></tr>';
            }
        }
        // --- END JavaScript for Laporan Donasi Barang ---


        window.addEventListener('click', (event) => {
            if (event.target.classList.contains('modal')) {
                const modal = event.target;
                if (modal.id === 'editDonasiModal') {
                    editDonasiForm.reset();
                    editDonasiFormErrorMessages.textContent = '';
                } else if (modal.id === 'correctReqDonasiModal') {
                    correctReqDonasiForm.reset();
                    correctReqDonasiFormErrorMessages.textContent = '';
                }
                modal.style.display = 'none';
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            fetchReqDonasiData();
            fetchDonasiData();
            fetchLaporanDonasiBarangData(); // Fetch data for the new report

            const navLinks = document.querySelectorAll('.navbar .nav-links a');
            // Optional: Highlight active link based on actual routing if implemented
        });
    </script>

</body>
</html>
