<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Laporan Donasi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Basic reset and font */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f0f0f0;
            color: #333;
            line-height: 1.6;
        }

        .navbar {
            background-color: #1a1a1a;
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

        .navbar .nav-links a:hover, .navbar .nav-links a.active {
            color: #7BC9FF;
        }

        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar .user-info .user-avatar {
            width: 30px;
            height: 30px;
            background-color: #7BC9FF;
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
            border-bottom: 2px solid #8576FF;
            padding-bottom: 10px;
        }

        .data-section {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .data-section h2 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 15px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 0.95rem;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .data-table th {
            background-color: #f2f2f2;
            font-weight: 700;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .print-button {
             padding: 10px 18px;
             background-color: #8576FF;
             color: white;
             border: none;
             border-radius: 5px;
             cursor: pointer;
             margin-bottom: 15px;
             font-weight: 600;
             transition: background-color 0.3s ease;
        }

        .print-button:hover {
            background-color: #6b60c4;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
                padding: 15px;
            }
            .page-title { font-size: 1.5rem; }
            .data-table { font-size: 0.85rem; }
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
            <div class="user-avatar">
                <i class="fas fa-user-tie"></i>
            </div>
        </div>
    </div>

    <div class="container">
        <h1 class="page-title">Laporan Donasi - ReUse Mart</h1>

        <!-- Section for Laporan Donasi Barang -->
        <div class="data-section">
            <h2>Laporan Donasi Barang</h2>
            <button id="print-donasi-btn" class="print-button"><i class="fas fa-print"></i> Cetak PDF Laporan Donasi</button>
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
                <tbody id="laporan-donasi-table-body">
                    <!-- Data will be populated by JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Section for Laporan Request Donasi -->
        <div class="data-section">
            <h2>Laporan Request Donasi (Belum Terpenuhi)</h2>
            <button id="print-request-btn" class="print-button"><i class="fas fa-print"></i> Cetak PDF Request Donasi</button>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID Organisasi</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Request</th>
                    </tr>
                </thead>
                <tbody id="laporan-request-table-body">
                    <!-- Data will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- jsPDF Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

    <script>
        // --- DUMMY DATA ---

        // Dummy data for Laporan Donasi Barang
        const laporanDonasiData = [
            { kodeProduk: 'K202', namaProduk: 'Kipas angin Jumbo', idPenitip: 'T25', namaPenitip: 'Adi Sanjaya', tanggalDonasi: '29/3/2025', organisasi: 'Pemuda Pejuang Kebersihan', namaPenerima: 'Pak Sugeng' },
            { kodeProduk: 'K203', namaProduk: 'Kulkas 3 Pintu', idPenitip: 'T14', namaPenitip: 'Gani Hendrawan', tanggalDonasi: '29/3/2025', organisasi: 'Yayasan Kasih Ibu Sleman', namaPenerima: 'Bu Rini' },
            { kodeProduk: 'B101', namaProduk: 'Set Pakaian Anak', idPenitip: 'T31', namaPenitip: 'Rina Pertiwi', tanggalDonasi: '05/4/2025', organisasi: 'Panti Asuhan Pelita Harapan', namaPenerima: 'Ibu Susi' },
            { kodeProduk: 'E405', namaProduk: 'Rice Cooker Digital', idPenitip: 'T28', namaPenitip: 'Budi Setiawan', tanggalDonasi: '11/4/2025', organisasi: 'Komunitas Berbagi Yogyakarta', namaPenerima: 'Pak Joko' },
            { kodeProduk: 'F607', namaProduk: 'Meja Belajar Kayu', idPenitip: 'T45', namaPenitip: 'Fira Anjani', tanggalDonasi: '18/4/2025', organisasi: 'Rumah Belajar Ceria', namaPenerima: 'Kak Bima' }
        ];

        // Dummy data for Laporan Request Donasi (Unfulfilled)
        const laporanRequestData = [
            { idOrganisasi: 'ORG10', nama: 'Yayasan Kasih Ibu Sleman', alamat: 'Jl. Kebangsaan 12 Maguwo', request: 'Kulkas (untuk menyimpan makanan bayi dan anak-anak)' },
            { idOrganisasi: 'ORG15', nama: 'Pemuda Pejuang Kebersihan', alamat: 'Jl. Garuda CTX/13 Tambak Bayan', request: 'Kipas angin, alat kebersihan seperti vacum cleaner dan blower' },
            { idOrganisasi: 'ORG18', nama: 'Panti Asuhan Pelita Harapan', alamat: 'Jl. Cendrawasih No. 22', request: 'Lemari pakaian 2 pintu dan buku-buku cerita anak' },
            { idOrganisasi: 'ORG21', nama: 'Rumah Belajar Ceria', alamat: 'Gg. Pelajar No. 5 Mlati', request: 'Proyektor bekas dan layar untuk kegiatan belajar mengajar' },
            { idOrganisasi: 'ORG25', nama: 'Dapur Umum Gotong Royong', alamat: 'Jl. Merdeka 192 Depok', request: 'Peralatan masak besar seperti wajan, panci, dan kompor' }
        ];

        // --- RENDER TABLE FUNCTIONS ---

        function renderTable(tableBodyId, data, columns) {
            const tableBody = document.getElementById(tableBodyId);
            tableBody.innerHTML = ''; // Clear previous data

            if (data.length > 0) {
                data.forEach(item => {
                    const row = document.createElement('tr');
                    columns.forEach(column => {
                        const cell = document.createElement('td');
                        cell.textContent = item[column];
                        row.appendChild(cell);
                    });
                    tableBody.appendChild(row);
                });
            } else {
                const colSpan = columns.length;
                tableBody.innerHTML = `<tr><td colspan="${colSpan}" style="text-align:center; padding: 20px;">Tidak ada data ditemukan.</td></tr>`;
            }
        }

        // --- PDF PRINTING FUNCTIONS ---

        function getFormattedDate(date = new Date()) {
            const day = date.getDate();
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            const month = monthNames[date.getMonth()];
            const year = date.getFullYear();
            return `${day} ${month} ${year}`;
        }

        function printLaporanDonasiPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('p', 'pt', 'a4'); // Using points for better control

            // Header
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(14);
            doc.text("ReUse Mart", 40, 50);
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(10);
            doc.text("Jl. Green Eco Park No. 456 Yogyakarta", 40, 65);

            // Title
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(11);
            doc.text("LAPORAN DONASI BARANG", doc.internal.pageSize.getWidth() / 2, 95, { align: 'center' });

            doc.setFont('helvetica', 'normal');
            doc.setFontSize(10);
            doc.text("Tahun: 2025", 40, 115);
            doc.text(`Tanggal cetak: ${getFormattedDate()}`, 40, 130);

            // Table
            doc.autoTable({
                head: [['Kode Produk', 'Nama Produk', 'Id Penitip', 'Nama Penitip', 'Tanggal Donasi', 'Organisasi', 'Nama Penerima']],
                body: laporanDonasiData.map(item => Object.values(item)),
                startY: 145,
                theme: 'grid',
                headStyles: { fillColor: [230, 230, 230], textColor: [0, 0, 0], fontStyle: 'bold', lineWidth: 0.5, lineColor: [0, 0, 0] },
                styles: { fontSize: 8, lineWidth: 0.5, lineColor: [0, 0, 0] },
            });

            doc.save('Laporan-Donasi-Barang.pdf');
        }

        function printLaporanRequestPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('p', 'pt', 'a4');

            // Header
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(14);
            doc.text("ReUse Mart", 40, 50);
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(10);
            doc.text("Jl. Green Eco Park No. 456 Yogyakarta", 40, 65);

            // Title
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(11);
            doc.text("LAPORAN REQUEST DONASI", doc.internal.pageSize.getWidth() / 2, 95, { align: 'center' });

            doc.setFont('helvetica', 'normal');
            doc.setFontSize(10);
            doc.text(`Tanggal cetak: ${getFormattedDate()}`, 40, 115);

            // Table
            doc.autoTable({
                head: [['ID Organisasi', 'Nama', 'Alamat', 'Request']],
                body: laporanRequestData.map(item => Object.values(item)),
                startY: 130,
                theme: 'grid',
                headStyles: { fillColor: [230, 230, 230], textColor: [0, 0, 0], fontStyle: 'bold', lineWidth: 0.5, lineColor: [0, 0, 0] },
                styles: { fontSize: 8, lineWidth: 0.5, lineColor: [0, 0, 0], cellPadding: 5 },
                columnStyles: { 3: { cellWidth: 'auto' } } // Make last column wrap text
            });

            doc.save('Laporan-Request-Donasi.pdf');
        }

        // --- EVENT LISTENERS ---

        document.addEventListener('DOMContentLoaded', () => {
            // Render Donasi Barang Table
            const donasiColumns = ['kodeProduk', 'namaProduk', 'idPenitip', 'namaPenitip', 'tanggalDonasi', 'organisasi', 'namaPenerima'];
            renderTable('laporan-donasi-table-body', laporanDonasiData, donasiColumns);

            // Render Request Donasi Table
            const requestColumns = ['idOrganisasi', 'nama', 'alamat', 'request'];
            renderTable('laporan-request-table-body', laporanRequestData, requestColumns);

            // Attach print button listeners
            document.getElementById('print-donasi-btn').addEventListener('click', printLaporanDonasiPDF);
            document.getElementById('print-request-btn').addEventListener('click', printLaporanRequestPDF);
        });

    </script>

</body>
</html>
