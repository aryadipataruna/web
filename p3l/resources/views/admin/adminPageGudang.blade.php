<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page Gudang - ReUse Mart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* Custom Header */
        .custom-header {
            background-color: #2c2c2c;
            padding: 0.75rem 0;
        }

        .nav-custom .nav-link {
            color: white !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .nav-custom .nav-link:hover,
        .nav-custom .nav-link.active {
            background-color: rgba(124, 58, 237, 0.8);
        }

        .user-info {
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background-color: #7c3aed;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        /* Page Title */
        .page-title {
            color: #4a4a4a;
            font-weight: 600;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }

        /* Custom Buttons */
        .btn-primary-custom {
            background-color: #7c3aed;
            border-color: #7c3aed;
            font-weight: 500;
        }

        .btn-primary-custom:hover {
            background-color: #6d28d9;
            border-color: #6d28d9;
        }

        .btn-edit {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
        }

        .btn-edit:hover {
            background-color: #2563eb;
            border-color: #2563eb;
            color: white;
        }

        .btn-delete {
            background-color: #ef4444;
            border-color: #ef4444;
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
        }

        .btn-delete:hover {
            background-color: #dc2626;
            border-color: #dc2626;
            color: white;
        }

        /* Table Styling */
        .table-custom {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .table-custom thead {
            background-color: #f8f9fa;
        }

        .table-custom th {
            font-weight: 600;
            color: #4a5568;
            border-bottom: 2px solid #e2e8f0;
            padding: 1rem 0.75rem;
        }

        .table-custom td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-bottom: 1px solid #e2e8f0;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        /* Search Input */
        .search-input {
            border-radius: 6px;
            border: 1px solid #d1d5db;
        }

        .search-input:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, 0.25);
        }
    </style>
</head>
<body>
    <!-- Header Navigation -->
    <header class="custom-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <nav class="nav nav-custom">
                    <a class="nav-link" href="#"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a class="nav-link" href="#"><i class="fas fa-users me-2"></i>Pegawai</a>
                    <a class="nav-link" href="#"><i class="fas fa-building me-2"></i>Organisasi</a>
                    <a class="nav-link" href="#"><i class="fas fa-box me-2"></i>Merchandise</a>
                    <a class="nav-link active" href="#"><i class="fas fa-warehouse me-2"></i>Gudang</a>
                    <a class="nav-link" href="#"><i class="fas fa-user me-2"></i>Profile</a>
                </nav>
                <div class="user-info">
                    <span>GreenTea123</span>
                    <span class="text-muted">Admin</span>
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h2 class="page-title">Data Gudang - ReUse Mart</h2>
                        
                        <!-- Filter Section -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center">
                                    <label class="form-label me-3 mb-0 fw-semibold">Filter Rows:</label>
                                    <input type="text" class="form-control search-input" placeholder="Search by Name or ID Gudang" style="max-width: 300px;">
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <button class="btn btn-primary-custom">
                                    <i class="fas fa-plus me-2"></i>Tambah Gudang
                                </button>
                            </div>
                        </div>

                        <!-- Data Table -->
                        <div class="table-responsive">
                            <table id="barangTable" class="table table-striped table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID Barang</th>
                                        <th>ID Penitip</th>
                                        <th>ID Pegawai</th>
                                        <th>Nama Barang</th>
                                        <th>Deskripsi</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Tgl Titip</th>
                                        <th>Tgl Laku</th>
                                        <th>Tgl Akhir</th>
                                        <th>Garansi</th>
                                        <th>Perpanjangan</th>
                                        <th>Count Perpanjangan</th>
                                        <th>Status</th>
                                        <th>Gambar</th>
                                        <th>Bukti Pembayaran</th>
                                        <th>No Nota Penitipan</th> 
                                        <th>Actions</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal fade" id="addBarangModal" tabindex="-1" aria-labelledby="addBarangModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addBarangModalLabel">Tambah Barang Baru</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="addBarangForm">
                                        <div class="mb-3">
                                            <label for="add_id_penitip" class="form-label">ID Penitip:</label>
                                            <input type="text" class="form-control" id="add_id_penitip" name="id_penitip" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="add_id_pegawai" class="form-label">ID Pegawai:</label>
                                            <input type="text" class="form-control" id="add_id_pegawai" name="id_pegawai" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="add_nama_barang" class="form-label">Nama Barang:</label>
                                            <input type="text" class="form-control" id="add_nama_barang" name="nama_barang" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="add_deskripsi_barang" class="form-label">Deskripsi Barang:</label>
                                            <textarea class="form-control" id="add_deskripsi_barang" name="deskripsi_barang" required></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="add_kategori" class="form-label">Kategori:</label>
                                            <input type="text" class="form-control" id="add_kategori" name="kategori" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="add_harga_barang" class="form-label">Harga Barang:</label>
                                            <input type="number" class="form-control" id="add_harga_barang" name="harga_barang" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="add_tgl_titip" class="form-label">Tanggal Titip:</label>
                                            <input type="date" class="form-control" id="add_tgl_titip" name="tgl_titip" readonly required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="add_tgl_akhir" class="form-label">Tanggal Akhir Titip:</label>
                                            <input type="date" class="form-control" id="add_tgl_akhir" name="tgl_akhir" readonly required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="add_garansi" class="form-label">Garansi:</label>
                                            <select class="form-select" id="add_garansi" name="garansi" required>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="add_gambar_barang" class="form-label">Gambar Barang URL:</label>
                                            <input type="text" class="form-control" id="add_gambar_barang" name="gambar_barang" required>
                                        </div>

                                        <button type="submit" class="btn btn-success"><i class="fas fa-save me-2"></i>Tambah Barang</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="updateBarangModal" tabindex="-1" aria-labelledby="updateBarangModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateBarangModalLabel">Update Barang</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="updateBarangForm">
                                        <input type="hidden" id="update_id_barang" name="id_barang">

                                        <div class="mb-3">
                                            <label for="update_id_penitip" class="form-label">Nama Penitip:</label>
                                            <input type="text" class="form-control" id="update_id_penitip" name="id_penitip" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="update_id_pegawai" class="form-label">ID Pegawai:</label>
                                            <input type="text" class="form-control" id="update_id_pegawai" name="id_pegawai" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="update_nama_barang" class="form-label">Nama Barang:</label>
                                            <input type="text" class="form-control" id="update_nama_barang" name="nama_barang" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="update_deskripsi_barang" class="form-label">Deskripsi Barang:</label>
                                            <textarea class="form-control" id="update_deskripsi_barang" name="deskripsi_barang" required></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="update_kategori" class="form-label">Kategori:</label>
                                            <input type="text" class="form-control" id="update_kategori" name="kategori" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="update_harga_barang" class="form-label">Harga Barang:</label>
                                            <input type="number" class="form-control" id="update_harga_barang" name="harga_barang" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="update_tgl_titip" class="form-label">Tgl Titip:</label>
                                            <input type="date" class="form-control" id="update_tgl_titip" name="tgl_titip" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="update_tgl_laku" class="form-label">Tgl Laku:</label>
                                            <input type="date" class="form-control" id="update_tgl_laku" name="tgl_laku">
                                        </div>

                                        <div class="mb-3">
                                            <label for="update_tgl_akhir" class="form-label">Tgl Akhir:</label>
                                            <input type="date" class="form-control" id="update_tgl_akhir" name="tgl_akhir">
                                        </div>

                                        <div class="mb-3">
                                            <label for="update_garansi" class="form-label">Garansi:</label>
                                            <select class="form-select" id="update_garansi" name="garansi" required>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="update_perpanjangan" class="form-label">Perpanjangan:</label>
                                            <select class="form-select" id="update_perpanjangan" name="perpanjangan">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="update_count_perpanjangan" class="form-label">Count Perpanjangan:</label>
                                            <input type="number" class="form-control" id="update_count_perpanjangan" name="count_perpanjangan">
                                        </div>

                                        <div class="mb-3">
                                            <label for="update_status" class="form-label">Status:</label>
                                            <input type="text" class="form-control" id="update_status" name="status">
                                        </div>

                                        <div class="mb-3">
                                            <label for="update_gambar_barang" class="form-label">Gambar Barang URL:</label>
                                            <input type="text" class="form-control" id="update_gambar_barang" name="gambar_barang" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="update_bukti_pembayaran" class="form-label">Bukti Pembayaran URL:</label>
                                            <input type="text" class="form-control" id="update_bukti_pembayaran" name="bukti_pembayaran">
                                        </div>

                                        <button type="submit" class="btn btn-warning"><i class="fas fa-edit me-2"></i>Update Barang</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        // --- Configuration ---
        const API_BASE_URL = 'http://localhost:8000/api'; // <--- IMPORTANT: SET YOUR LARAVEL API URL HERE

        // --- DOM Elements ---
        const barangTableBody = document.querySelector('#barangTable tbody');
        const addBarangButton = document.querySelector('.btn-primary-custom'); // "Tambah Gudang" button
        const searchInput = document.querySelector('.search-input');

        // Modals
        const addBarangModal = new bootstrap.Modal(document.getElementById('addBarangModal'));
        const updateBarangModal = new bootstrap.Modal(document.getElementById('updateBarangModal'));

        // Forms
        const addBarangForm = document.getElementById('addBarangForm');
        const updateBarangForm = document.getElementById('updateBarangForm');

        // Specific fields for auto-date generation in Add Modal
        const addTglTitipInput = document.getElementById('add_tgl_titip');
        const addTglAkhirInput = document.getElementById('add_tgl_akhir');

        // --- Helper Functions ---

        // Function to get today's date in YYYY-MM-DD format
        function getTodayDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Month is 0-indexed
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Function to get date after N days from a given start date in YYYY-MM-DD format
        function getDateAfterDays(startDate, days) {
            const date = new Date(startDate);
            date.setDate(date.getDate() + days);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Function to fetch and display barang data
        async function fetchBarang(searchTerm = '') {
            try {
                const response = await fetch(`${API_BASE_URL}/barang`);
                const result = await response.json();

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}, message: ${result.message || 'Unknown error'}`);
                }

                if (result.status) {
                    barangTableBody.innerHTML = ''; // Clear existing rows

                    const filteredData = result.data.filter(barang =>
                        barang.nama_barang.toLowerCase().includes(searchTerm.toLowerCase()) ||
                        String(barang.id_barang).toLowerCase().includes(searchTerm.toLowerCase())
                    );

                    if (filteredData.length > 0) {
                        filteredData.forEach(barang => {
                            const row = barangTableBody.insertRow();
                            row.innerHTML = `
                                <td>${barang.id_barang || 'N/A'}</td>
                                <td>${barang.id_penitip || 'N/A'}</td>
                                <td>${barang.id_pegawai || 'N/A'}</td>
                                <td>${barang.nama_barang || 'N/A'}</td>
                                <td>${barang.deskripsi_barang || 'N/A'}</td>
                                <td>${barang.kategori || 'N/A'}</td>
                                <td>${barang.harga_barang || 'N/A'}</td>
                                <td>${barang.tgl_titip || 'N/A'}</td>
                                <td>${barang.tgl_laku || 'N/A'}</td>
                                <td>${barang.tgl_akhir || 'N/A'}</td>
                                <td>${barang.garansi ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>'}</td>
                                <td>${barang.perpanjangan ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>'}</td>
                                <td>${barang.count_perpanjangan || 0}</td>
                                <td>${barang.status || 'N/A'}</td>
                                <td>${barang.gambar_barang ? `<a href="${barang.gambar_barang}" target="_blank"><i class="fas fa-image"></i> View</a>` : 'N/A'}</td>
                                <td>${barang.bukti_pembayaran ? `<a href="${barang.bukti_pembayaran}" target="_blank"><i class="fas fa-receipt"></i> View</a>` : 'N/A'}</td>
                                <td>${barang.no_nota_penitipan || 'N/A'}</td>
                                <td class="action-buttons">
                                    <button class="btn btn-edit btn-sm update-btn" data-id="${barang.id_barang}"><i class="fas fa-edit"></i> Edit</button>
                                    <button class="btn btn-delete btn-sm delete-btn" data-id="${barang.id_barang}"><i class="fas fa-trash-alt"></i> Delete</button>
                                    ${barang.no_nota_penitipan ? `<button class="btn btn-primary btn-sm generate-nota-btn" data-notaid="${barang.no_nota_penitipan}"><i class="fas fa-print"></i> Nota</button>` : ''}
                                </td>
                            `;
                        });
                    } else {
                        barangTableBody.innerHTML = '<tr><td colspan="17" class="text-center text-muted">No matching barang data found.</td></tr>';
                    }
                } else {
                    alert('Error fetching barang data: ' + result.message);
                    console.error('API Error Details:', result.data);
                }
            } catch (error) {
                console.error('Fetch Error:', error);
                alert('Failed to connect to the API or an unexpected error occurred: ' + error.message);
            }
        }

        // --- Event Listeners ---

        // Initial fetch when the page loads
        fetchBarang();

        // "Tambah Gudang" button click to show add modal
        addBarangButton.addEventListener('click', () => {
            // Auto-generate dates
            const today = getTodayDate();
            addTglTitipInput.value = today;
            addTglAkhirInput.value = getDateAfterDays(today, 30);
            addBarangModal.show(); // Show Bootstrap modal
        });

        // Add Barang Form Submission
        addBarangForm.addEventListener('submit', async (event) => {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(addBarangForm);
            const data = Object.fromEntries(formData.entries());

            // Convert 'garansi' string to boolean
            data.garansi = data.garansi === '1';

            // Ensure other fields not directly in form but expected by backend are sent
            // or handled by backend defaults (if applicable)
            data.perpanjangan = false; // Assuming new items don't start as extended
            data.count_perpanjangan = 0;
            data.status = 'available'; // Default status for new items

            console.log('Sending data:', data);

            try {
                const response = await fetch(`${API_BASE_URL}/barang/create`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(data),
                });

                const result = await response.json();

                if (response.ok && result.status) {
                    alert('Barang added successfully! ID: ' + result.data.id_barang);
                    addBarangModal.hide(); 
                    addBarangForm.reset(); 
                    fetchBarang(); 
                } else {
                    const errorMessage = result.message || 'Unknown error occurred.';
                    const errorDetails = result.data ? '\nDetails: ' + JSON.stringify(result.data) : '';
                    alert(`Failed to add barang: ${errorMessage}${errorDetails}`);
                    console.error('API Error:', result);
                }
            } catch (error) {
                console.error('Fetch Error:', error);
                alert('An error occurred while adding barang. Check console for details.');
            }
        });

        // Delegate click events for Delete and Update buttons on the table body
        barangTableBody.addEventListener('click', async (event) => {
            // Delete functionality
            if (event.target.closest('.delete-btn')) {
                const barangId = event.target.closest('.delete-btn').dataset.id;
                if (confirm(`Are you sure you want to delete Barang ID: ${barangId}? This action cannot be undone.`)) {
                    try {
                        const response = await fetch(`${API_BASE_URL}/barang/delete/${barangId}`, {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                            },
                        });
                        const result = await response.json();

                        if (response.ok && result.status) {
                            alert('Barang deleted successfully!');
                            fetchBarang(); // Refresh table
                        } else {
                            alert('Failed to delete barang: ' + (result.message || 'Unknown error'));
                            console.error('API Error:', result);
                        }
                    } catch (error) {
                        console.error('Fetch Error:', error);
                        alert('An error occurred while deleting barang. Check console for details.');
                    }
                }
            }

            // Update functionality - Populate modal
            if (event.target.closest('.update-btn')) {
                const barangId = event.target.closest('.update-btn').dataset.id;
                try {
                    // Fetch the specific barang data to populate the update form
                    const response = await fetch(`${API_BASE_URL}/barang/${barangId}`);
                    const result = await response.json();

                    if (response.ok && result.status) {
                        const barang = result.data;
                        // Populate the update form fields
                        document.getElementById('update_id_barang').value = barang.id_barang || '';
                        document.getElementById('update_id_penitip').value = barang.id_penitip || '';
                        document.getElementById('update_id_pegawai').value = barang.id_pegawai || '';
                        document.getElementById('update_nama_barang').value = barang.nama_barang || '';
                        document.getElementById('update_deskripsi_barang').value = barang.deskripsi_barang || '';
                        document.getElementById('update_kategori').value = barang.kategori || '';
                        document.getElementById('update_harga_barang').value = barang.harga_barang || '';

                        // Format dates to YYYY-MM-DD for date input type
                        document.getElementById('update_tgl_titip').value = barang.tgl_titip ? new Date(barang.tgl_titip).toISOString().split('T')[0] : '';
                        document.getElementById('update_tgl_laku').value = barang.tgl_laku ? new Date(barang.tgl_laku).toISOString().split('T')[0] : '';
                        document.getElementById('update_tgl_akhir').value = barang.tgl_akhir ? new Date(barang.tgl_akhir).toISOString().split('T')[0] : '';

                        document.getElementById('update_garansi').value = barang.garansi ? '1' : '0';
                        document.getElementById('update_perpanjangan').value = barang.perpanjangan ? '1' : '0';
                        document.getElementById('update_count_perpanjangan').value = barang.count_perpanjangan || 0;
                        document.getElementById('update_status').value = barang.status || '';
                        document.getElementById('update_gambar_barang').value = barang.gambar_barang || '';
                        document.getElementById('update_bukti_pembayaran').value = barang.bukti_pembayaran || '';

                        updateBarangModal.show(); // Show the update modal
                    } else {
                        alert('Failed to fetch barang for update: ' + (result.message || 'Unknown error'));
                        console.error('API Error:', result);
                    }
                } catch (error) {
                    console.error('Fetch Error:', error);
                    alert('An error occurred while fetching barang data for update. Check console for details.');
                }
            }

            if (event.target.closest('.generate-nota-btn')) {
                const notaId = event.target.closest('.generate-nota-btn').dataset.notaid;
                if (notaId) {
                    // Open the PDF in a new tab
                    window.open(`${API_BASE_URL}/nota-penitipan/${notaId}/pdf`, '_blank');
                    // Using .replace('/api', '') because your frontend API_BASE_URL likely ends with /api
                    // but the PDF route might be in web.php or a direct route, not under /api.
                    // Adjust this URL based on your actual backend route setup.
                } else {
                    alert('Nomor Nota tidak tersedia untuk barang ini.');
                }
            }
        });

        // Update Barang Form Submission
        updateBarangForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const barangId = document.getElementById('update_id_barang').value;
            const formData = new FormData(updateBarangForm);
            const data = Object.fromEntries(formData.entries());

            // Remove id_barang from data as it's part of the URL
            delete data.id_barang;

            // Convert boolean-like strings to actual booleans
            data.garansi = data.garansi === '1';
            data.perpanjangan = data.perpanjangan === '1';

            // Ensure nullable fields are sent as null if empty string
            const nullableFields = ['tgl_laku', 'tgl_akhir', 'bukti_pembayaran', 'status'];
            for (const key of nullableFields) {
                if (data[key] === '') {
                    data[key] = null;
                }
            }
            // For count_perpanjangan, ensure it's a number (0 if empty) as it's not nullable in DB
            if (data.count_perpanjangan === '') {
                data.count_perpanjangan = 0;
            }

            console.log('Sending update data for ID:', barangId, data);

            try {
                const response = await fetch(`${API_BASE_URL}/barang/update/${barangId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(data),
                });

                const result = await response.json();

                if (response.ok && result.status) {
                    alert('Barang updated successfully!');
                    updateBarangModal.hide(); // Hide Bootstrap modal
                    fetchBarang(); // Refresh table data
                } else {
                    const errorMessage = result.message || 'Unknown error occurred.';
                    const errorDetails = result.data ? '\nDetails: ' + JSON.stringify(result.data) : '';
                    alert(`Failed to update barang: ${errorMessage}${errorDetails}`);
                    console.error('API Error:', result);
                }
            } catch (error) {
                console.error('Fetch Error:', error);
                alert('An error occurred while updating barang. Check console for details.');
            }
        });

        // Search functionality
        searchInput.addEventListener('input', (event) => {
            const searchTerm = event.target.value;
            fetchBarang(searchTerm);
        });
    });
</script>
</body>
</html>