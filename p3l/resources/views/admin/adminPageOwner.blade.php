<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Laporan Donasi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #8576FF;
            --secondary-color: #7BC9FF;
            --dark-color: #1a1a1a;
            --light-color: #f0f0f0;
            --text-color: #333;
            --border-color: #ddd;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--light-color); color: var(--text-color); line-height: 1.6; }

        .navbar {
            background-color: var(--dark-color);
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar .nav-links { display: flex; gap: 20px; }
        .navbar .nav-links a { color: #fff; text-decoration: none; font-weight: 600; transition: color 0.3s ease; }
        .navbar .nav-links a:hover, .navbar .nav-links a.active { color: var(--secondary-color); }
        .navbar .user-info { display: flex; align-items: center; gap: 10px; }
        .navbar .user-info .user-avatar { width: 30px; height: 30px; background-color: var(--secondary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--dark-color); font-weight: 700; }
        .navbar .user-info .user-details { display: flex; flex-direction: column; font-size: 0.9rem; }
        .navbar .user-info .user-details .role { font-size: 0.8rem; color: #ccc; }

        .container { max-width: 1200px; margin: 20px auto; padding: 20px; background-color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); border-radius: 8px; }
        .page-title { font-size: 2rem; color: var(--text-color); margin-bottom: 20px; border-bottom: 2px solid var(--primary-color); padding-bottom: 10px; }

        .data-section { margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; }
        .data-section h2 { font-size: 1.8rem; color: var(--text-color); margin-bottom: 15px; }

        .toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px; }
        .toolbar .search-bar { width: 100%; max-width: 300px; padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 5px; font-size: 0.9rem; }

        .btn { padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; transition: background-color 0.3s ease; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary { background-color: var(--primary-color); color: white; }
        .btn-primary:hover { background-color: #6b60c4; }
        .btn-edit { background-color: #3498db; color: white; padding: 5px 10px; font-size: 0.8rem; }
        .btn-delete { background-color: #e74c3c; color: white; padding: 5px 10px; font-size: 0.8rem; }

        .data-table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 0.95rem; }
        .data-table th, .data-table td { border: 1px solid var(--border-color); padding: 12px; text-align: left; }
        .data-table th { background-color: #f2f2f2; font-weight: 700; }
        .data-table tbody tr:nth-child(even) { background-color: #f9f9f9; }
        .data-table .action-cell { display: flex; gap: 8px; }

        /* Modal Styles */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); justify-content: center; align-items: center; }
        .modal-content { background-color: #fefefe; margin: auto; padding: 25px; border: 1px solid #888; width: 90%; max-width: 500px; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); position: relative; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; margin-bottom: 20px; }
        .modal-title { font-size: 1.5rem; color: var(--text-color); }
        .close-button { color: #aaa; font-size: 28px; font-weight: bold; cursor: pointer; }
        .close-button:hover { color: #000; }

        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px; font-size: 1rem; }
        .modal-footer { text-align: right; margin-top: 20px; }

        @media (max-width: 768px) {
            .navbar { flex-direction: column; gap: 15px; padding: 15px; }
            .page-title { font-size: 1.5rem; }
            .data-table { font-size: 0.85rem; }
            .toolbar { flex-direction: column; align-items: stretch; }
            .toolbar .search-bar { max-width: none; }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="nav-links">
            <a href="#">Dashboard</a>
            <a href="#">Pegawai</a>
            <a href="#">Organisasi</a>
            <a href="#" class="active">Laporan</a>
            <a href="#">Profile</a>
        </div>
        <div class="user-info">
            <div class="user-details">
                <span>GreenTea123</span>
                <span class="role">Owner</span>
            </div>
            <div class="user-avatar"><i class="fas fa-user-tie"></i></div>
        </div>
    </div>

    <div class="container">
        <h1 class="page-title">Dasbor Owner - Laporan ReUse Mart</h1>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>Penjualan Bulanan Keseluruhan</h3>
                <p>Laporan Penjualan Bulanan Keseluruhan PDF.</p>
                <a href="/api/laporan-penjualan-bulanan/2025">Laporan Penjualan Bulanan</a>
            </div>
            <div class="dashboard-card">
                <h3>Komisi Bulanan per Produk</h3>
                <p>Laporan Komisi Bulanan per Produk PDF.</p>
                <a href="/api/laporan-komisi">Laporan Komisi</a>
            </div>
            <div class="dashboard-card">
                <h3>Laporan Stok Gudang</h3>
                <p>Laporan Stok Barang di Gudang PDF.</p>
                <a href="/api/laporan-stok-gudang">Laporan Stok</a>
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
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Nama Penitip</th>
                        <th>Organisasi</th>
                        <th>Penerima</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="laporan-donasi-table-body"></tbody>
            </table>
        </div>

        <!-- Section for Laporan Request Donasi -->
        <div class="data-section">
            <h2>Laporan Request Donasi (Belum Terpenuhi)</h2>
            <div class="toolbar">
                <input type="search" id="search-request" class="search-bar" placeholder="Cari request donasi...">
                 <div>
                    <button id="add-request-btn" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Request</button>
                    <button id="print-request-btn" class="btn btn-primary"><i class="fas fa-print"></i> Cetak PDF</button>
                </div>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID Organisasi</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Request</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="laporan-request-table-body"></tbody>
            </table>
        </div>
    </div>

    <!-- Universal Modal for CRUD -->
    <div id="crud-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modal-title"></h2>
                <span class="close-button">&times;</span>
            </div>
            <form id="crud-form">
                <!-- Form content will be dynamically inserted here -->
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- DATA ---
            let laporanDonasiData = [
                { kodeProduk: 'K202', namaProduk: 'Kipas angin Jumbo', idPenitip: 'T25', namaPenitip: 'Adi Sanjaya', tanggalDonasi: '29/3/2025', organisasi: 'Pemuda Pejuang Kebersihan', namaPenerima: 'Pak Sugeng' },
                { kodeProduk: 'K203', namaProduk: 'Kulkas 3 Pintu', idPenitip: 'T14', namaPenitip: 'Gani Hendrawan', tanggalDonasi: '29/3/2025', organisasi: 'Yayasan Kasih Ibu Sleman', namaPenerima: 'Bu Rini' },
                { kodeProduk: 'B101', namaProduk: 'Set Pakaian Anak', idPenitip: 'T31', namaPenitip: 'Rina Pertiwi', tanggalDonasi: '05/4/2025', organisasi: 'Panti Asuhan Pelita Harapan', namaPenerima: 'Ibu Susi' },
            ];
            let laporanRequestData = [
                { idOrganisasi: 'ORG10', nama: 'Yayasan Kasih Ibu Sleman', alamat: 'Jl. Kebangsaan 12 Maguwo', request: 'Kulkas (untuk menyimpan makanan bayi dan anak-anak)' },
                { idOrganisasi: 'ORG15', nama: 'Pemuda Pejuang Kebersihan', alamat: 'Jl. Garuda CTX/13 Tambak Bayan', request: 'Kipas angin, alat kebersihan seperti vacum cleaner dan blower' },
                { idOrganisasi: 'ORG18', nama: 'Panti Asuhan Pelita Harapan', alamat: 'Jl. Cendrawasih No. 22', request: 'Lemari pakaian 2 pintu dan buku-buku cerita anak' },
            ];

            // --- DOM ELEMENTS ---
            const modal = document.getElementById('crud-modal');
            const modalTitle = document.getElementById('modal-title');
            const crudForm = document.getElementById('crud-form');
            const closeModalBtn = modal.querySelector('.close-button');

            // --- RENDER FUNCTIONS ---
            function renderDonasiTable(data) {
                const tableBody = document.getElementById('laporan-donasi-table-body');
                tableBody.innerHTML = '';
                if(data.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="6" style="text-align:center; padding: 20px;">Data tidak ditemukan.</td></tr>`;
                    return;
                }
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.kodeProduk}</td>
                        <td>${item.namaProduk}</td>
                        <td>${item.namaPenitip}</td>
                        <td>${item.organisasi}</td>
                        <td>${item.namaPenerima}</td>
                        <td class="action-cell">
                            <button class="btn btn-edit" data-id="${item.kodeProduk}" data-type="donasi"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-delete" data-id="${item.kodeProduk}" data-type="donasi"><i class="fas fa-trash"></i></button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            function renderRequestTable(data) {
                const tableBody = document.getElementById('laporan-request-table-body');
                tableBody.innerHTML = '';
                 if(data.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="5" style="text-align:center; padding: 20px;">Data tidak ditemukan.</td></tr>`;
                    return;
                }
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.idOrganisasi}</td>
                        <td>${item.nama}</td>
                        <td>${item.alamat}</td>
                        <td>${item.request}</td>
                        <td class="action-cell">
                            <button class="btn btn-edit" data-id="${item.idOrganisasi}" data-type="request"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-delete" data-id="${item.idOrganisasi}" data-type="request"><i class="fas fa-trash"></i></button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            // --- MODAL & FORM LOGIC ---
            function openModal(title, formHTML, submitHandler) {
                modalTitle.textContent = title;
                crudForm.innerHTML = formHTML;
                modal.style.display = 'flex';
                crudForm.onsubmit = (e) => {
                    e.preventDefault();
                    submitHandler(new FormData(crudForm));
                    closeModal();
                };
            }

            function closeModal() {
                modal.style.display = 'none';
                crudForm.innerHTML = '';
            }

            function getDonasiFormHTML(item = {}) {
                return `
                    <input type="hidden" name="kodeProduk" value="${item.kodeProduk || ''}">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" name="namaProduk" value="${item.namaProduk || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Penitip</label>
                        <input type="text" name="namaPenitip" value="${item.namaPenitip || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>Organisasi</label>
                        <input type="text" name="organisasi" value="${item.organisasi || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Penerima</label>
                        <input type="text" name="namaPenerima" value="${item.namaPenerima || ''}" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                `;
            }

            function getRequestFormHTML(item = {}) {
                 return `
                    <input type="hidden" name="idOrganisasi" value="${item.idOrganisasi || ''}">
                    <div class="form-group">
                        <label>Nama Organisasi</label>
                        <input type="text" name="nama" value="${item.nama || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" name="alamat" value="${item.alamat || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>Request</label>
                        <textarea name="request" rows="3" required>${item.request || ''}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                `;
            }


            // --- CRUD HANDLERS ---

            // ADD
            document.getElementById('add-donasi-btn').addEventListener('click', () => {
                const formHTML = getDonasiFormHTML();
                openModal('Tambah Donasi Barang', formHTML, (formData) => {
                    const newId = 'PRD' + (Math.floor(Math.random() * 900) + 100); // Generate simple random ID
                    const newItem = {
                        kodeProduk: newId,
                        namaProduk: formData.get('namaProduk'),
                        namaPenitip: formData.get('namaPenitip'),
                        organisasi: formData.get('organisasi'),
                        namaPenerima: formData.get('namaPenerima'),
                        idPenitip: 'T' + (Math.floor(Math.random() * 90) + 10),
                        tanggalDonasi: new Date().toLocaleDateString('id-ID'),
                    };
                    laporanDonasiData.push(newItem);
                    renderDonasiTable(laporanDonasiData);
                });
            });

             document.getElementById('add-request-btn').addEventListener('click', () => {
                const formHTML = getRequestFormHTML();
                openModal('Tambah Request Donasi', formHTML, (formData) => {
                    const newId = 'ORG' + (Math.floor(Math.random() * 900) + 100);
                    const newItem = {
                        idOrganisasi: newId,
                        nama: formData.get('nama'),
                        alamat: formData.get('alamat'),
                        request: formData.get('request'),
                    };
                    laporanRequestData.push(newItem);
                    renderRequestTable(laporanRequestData);
                });
            });

            // EDIT & DELETE (using event delegation)
            document.body.addEventListener('click', (e) => {
                const target = e.target.closest('.btn-edit, .btn-delete');
                if (!target) return;

                const id = target.dataset.id;
                const type = target.dataset.type;

                if (target.classList.contains('btn-edit')) {
                    if (type === 'donasi') {
                        const item = laporanDonasiData.find(d => d.kodeProduk === id);
                        const formHTML = getDonasiFormHTML(item);
                        openModal('Edit Donasi Barang', formHTML, (formData) => {
                           item.namaProduk = formData.get('namaProduk');
                           item.namaPenitip = formData.get('namaPenitip');
                           item.organisasi = formData.get('organisasi');
                           item.namaPenerima = formData.get('namaPenerima');
                           renderDonasiTable(laporanDonasiData);
                        });
                    } else if (type === 'request') {
                         const item = laporanRequestData.find(d => d.idOrganisasi === id);
                         const formHTML = getRequestFormHTML(item);
                         openModal('Edit Request Donasi', formHTML, (formData) => {
                           item.nama = formData.get('nama');
                           item.alamat = formData.get('alamat');
                           item.request = formData.get('request');
                           renderRequestTable(laporanRequestData);
                        });
                    }
                } else if (target.classList.contains('btn-delete')) {
                    if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) return;

                    if (type === 'donasi') {
                        laporanDonasiData = laporanDonasiData.filter(d => d.kodeProduk !== id);
                        renderDonasiTable(laporanDonasiData);
                    } else if (type === 'request') {
                        laporanRequestData = laporanRequestData.filter(d => d.idOrganisasi !== id);
                        renderRequestTable(laporanRequestData);
                    }
                }
            });

            // SEARCH
            document.getElementById('search-donasi').addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                const filteredData = laporanDonasiData.filter(item =>
                    Object.values(item).some(val => val.toString().toLowerCase().includes(searchTerm))
                );
                renderDonasiTable(filteredData);
            });

            document.getElementById('search-request').addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                const filteredData = laporanRequestData.filter(item =>
                    Object.values(item).some(val => val.toString().toLowerCase().includes(searchTerm))
                );
                renderRequestTable(filteredData);
            });


            // --- PDF PRINTING ---
            function getFormattedDate(date = new Date()) {
                const day = date.getDate();
                const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                const month = monthNames[date.getMonth()];
                const year = date.getFullYear();
                return `${day} ${month} ${year}`;
            }

            function printLaporanDonasiPDF() {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF('p', 'pt', 'a4');
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(14);
                doc.text("ReUse Mart", 40, 50);
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(10);
                doc.text("Jl. Green Eco Park No. 456 Yogyakarta", 40, 65);
                doc.setLineWidth(0.5);
                doc.line(40, 75, doc.internal.pageSize.getWidth() - 40, 75);
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(11);
                doc.text("LAPORAN DONASI BARANG", doc.internal.pageSize.getWidth() / 2, 100, { align: 'center' });
                doc.setFont('helvetica', 'normal');
                doc.text(`Tanggal cetak: ${getFormattedDate()}`, 40, 115);
                doc.autoTable({
                    head: [['Kode Produk', 'Nama Produk', 'Id Penitip', 'Nama Penitip', 'Tanggal Donasi', 'Organisasi', 'Nama Penerima']],
                    body: laporanDonasiData.map(item => Object.values(item)),
                    startY: 130, theme: 'grid',
                    headStyles: { fillColor: [255, 255, 255], textColor: [0,0,0], fontStyle: 'bold', lineWidth: 0.5, lineColor: [0,0,0] },
                    styles: { fontSize: 8, lineWidth: 0.5, lineColor: [0, 0, 0] },
                });
                doc.save('Laporan-Donasi-Barang.pdf');
            }

            function printLaporanRequestPDF() {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF('l', 'pt', 'a4'); // landscape
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(14);
                doc.text("ReUse Mart", 40, 50);
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(10);
                doc.text("Jl. Green Eco Park No. 456 Yogyakarta", 40, 65);
                doc.setLineWidth(0.5);
                doc.line(40, 75, doc.internal.pageSize.getWidth() - 40, 75);
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(11);
                doc.text("LAPORAN REQUEST DONASI (BELUM TERPENUHI)", doc.internal.pageSize.getWidth() / 2, 100, { align: 'center' });
                doc.setFont('helvetica', 'normal');
                doc.text(`Tanggal cetak: ${getFormattedDate()}`, 40, 115);
                doc.autoTable({
                    head: [['ID Organisasi', 'Nama', 'Alamat', 'Request']],
                    body: laporanRequestData.map(item => Object.values(item)),
                    startY: 130, theme: 'grid',
                    headStyles: { fillColor: [255, 255, 255], textColor: [0,0,0], fontStyle: 'bold', lineWidth: 0.5, lineColor: [0,0,0] },
                    styles: { fontSize: 9, lineWidth: 0.5, lineColor: [0, 0, 0] },
                });
                doc.save('Laporan-Request-Donasi.pdf');
            }

            // --- INITIALIZATION ---
            renderDonasiTable(laporanDonasiData);
            renderRequestTable(laporanRequestData);
            closeModalBtn.addEventListener('click', closeModal);
            document.getElementById('print-donasi-btn').addEventListener('click', printLaporanDonasiPDF);
            document.getElementById('print-request-btn').addEventListener('click', printLaporanRequestPDF);
        });
    </script>
</body>
</html>
