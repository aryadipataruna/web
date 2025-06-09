<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Merchandise & Penukaran - ReUse Mart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .filter-section {
            margin-bottom: 20px;
        }

        .filter-section label {
            margin-right: 10px;
            font-weight: bold;
        }

        .filter-section input[type="text"] {
            padding: 8px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tbody tr:hover {
            background-color: #e9e9e9;
        }

        .edit-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .edit-btn:hover {
            background-color: #0056b3;
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 8px;
            width: 80%; /* Could be more specific */
            max-width: 500px;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
            position: relative;
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
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-content h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
        }

        .modal-content label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .modal-content input[type="date"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .modal-content button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .modal-content button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Data Merchandise & Penukaran - ReUse Mart</h1>

        <div class="filter-section">
            <label for="filterInput">Filter Rows:</label>
            <input type="text" id="filterInput" placeholder="Search By Merchandise Name or Penukar Name">
        </div>

        <table id="merchandiseTable">
            <thead>
                <tr>
                    <th>ID Merchandise</th>
                    <th>Nama Merchandise</th>
                    <th>Nama Penukar</th>
                    <th>Tanggal Tukar</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                </tbody>
        </table>
    </div>

    <div id="editTanggalTukarModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2>Edit Tanggal Tukar</h2>
            <form id="editTanggalTukarForm">
                <input type="hidden" id="editPenukaranId">
                <input type="hidden" id="editIdPembeli">
                <input type="hidden" id="editNamaPenukar">

                <label for="tanggalTukarField">Tanggal Tukar:</label>
                <input type="date" id="tanggalTukarField" required>

                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        let allMerchandiseData = [];
        let allPenukaranData = new Map(); // Store penukaran data in a Map for easy lookup

        document.addEventListener('DOMContentLoaded', function() {
            const merchandiseTableBody = document.getElementById('merchandiseTable').getElementsByTagName('tbody')[0];
            const filterInput = document.getElementById('filterInput');
            const editTanggalTukarModal = document.getElementById('editTanggalTukarModal');
            const closeButton = editTanggalTukarModal.querySelector('.close-button');
            const editTanggalTukarForm = document.getElementById('editTanggalTukarForm');
            const tanggalTukarField = document.getElementById('tanggalTukarField');
            const editPenukaranId = document.getElementById('editPenukaranId');
            const editIdPembeli = document.getElementById('editIdPembeli');
            const editNamaPenukar = document.getElementById('editNamaPenukar');


            // Function to format date from YYYY-MM-DD HH:MM:SS to DD-MM-YYYY
            function formatDateToDDMMYYYY(dateString) {
                if (!dateString) return '';
                const date = new Date(dateString);
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0'); // Month is 0-indexed
                const year = date.getFullYear();
                return `${day}-${month}-${year}`;
            }

            // Function to format date from DD-MM-YYYY to YYYY-MM-DD (for API)
            function formatDateToYYYYMMDD(dateString) {
                if (!dateString) return '';
                const parts = dateString.split('-'); // Assumes DD-MM-YYYY
                if (parts.length === 3) {
                    return `${parts[2]}-${parts[1]}-${parts[0]}`; // YYYY-MM-DD
                }
                return dateString; // Return as is if format doesn't match
            }

            // Fetch data from both API endpoints
            async function fetchDataAndRender() {
                try {
                    const [merchandiseResponse, penukaranResponse] = await Promise.all([
                        fetch('/api/merchandise'),
                        fetch('/api/penukaran')
                    ]);

                    if (!merchandiseResponse.ok) throw new Error(`HTTP error! Merchandise status: ${merchandiseResponse.status}`);
                    if (!penukaranResponse.ok) throw new Error(`HTTP error! Penukaran status: ${penukaranResponse.status}`);

                    const merchandiseJson = await merchandiseResponse.json();
                    const penukaranJson = await penukaranResponse.json();

                    allMerchandiseData = merchandiseJson.data; // Store globaly
                    allPenukaranData.clear(); // Clear previous data
                    penukaranJson.data.forEach(penukaran => {
                        allPenukaranData.set(penukaran.ID_PENUKARAN, penukaran);
                    });

                    renderTable(); // Initial render
                } catch (error) {
                    console.error('Error fetching data:', error);
                    alert('Failed to load data. Please check console for details.');
                }
            }

            function renderTable(filterText = '') {
                merchandiseTableBody.innerHTML = ''; // Clear existing rows

                const lowerCaseFilter = filterText.toLowerCase();

                const combinedData = allMerchandiseData.map(merch => {
                    const penukaran = allPenukaranData.get(merch.ID_PENUKARAN);
                    return penukaran ? {
                        ID_MERCHANDISE: merch.ID_MERCHANDISE,
                        NAMA_MERCHANDISE: merch.NAMA_MERCHANDISE,
                        NAMA_PENUKAR: penukaran.NAMA_PENUKAR,
                        TANGGAL_TUKAR: penukaran.TANGGAL_TUKAR,
                        ID_PENUKARAN: penukaran.ID_PENUKARAN, // Add ID_PENUKARAN for editing
                        ID_PEMBELI: penukaran.ID_PEMBELI // Add ID_PEMBELI for updating penukaran
                    } : null;
                }).filter(item => item !== null); // Remove any merchandise without a matching penukaran

                const filteredCombinedData = combinedData.filter(item => {
                    const merchandiseName = item.NAMA_MERCHANDISE.toLowerCase();
                    const penukarName = item.NAMA_PENUKAR.toLowerCase();
                    return merchandiseName.includes(lowerCaseFilter) || penukarName.includes(lowerCaseFilter);
                });

                filteredCombinedData.forEach(item => {
                    const row = merchandiseTableBody.insertRow();
                    row.insertCell().textContent = item.ID_MERCHANDISE;
                    row.insertCell().textContent = item.NAMA_MERCHANDISE;
                    row.insertCell().textContent = item.NAMA_PENUKAR;
                    row.insertCell().textContent = formatDateToDDMMYYYY(item.TANGGAL_TUKAR); // Display formatted date

                    const actionCell = row.insertCell();
                    const editButton = document.createElement('button');
                    editButton.textContent = 'Edit Tanggal Tukar';
                    editButton.classList.add('edit-btn');
                    editButton.dataset.penukaranId = item.ID_PENUKARAN;
                    actionCell.appendChild(editButton);

                    editButton.addEventListener('click', () => openEditModal(item.ID_PENUKARAN));
                });
            }

            // Function to open the edit modal
            function openEditModal(penukaranIdToEdit) {
                const penukaranRecord = allPenukaranData.get(penukaranIdToEdit);
                if (penukaranRecord) {
                    editPenukaranId.value = penukaranRecord.ID_PENUKARAN;
                    editIdPembeli.value = penukaranRecord.ID_PEMBELI;
                    editNamaPenukar.value = penukaranRecord.NAMA_PENUKAR;

                    // Set the date input value (YYYY-MM-DD format for input type="date")
                    tanggalTukarField.value = penukaranRecord.TANGGAL_TUKAR ? penukaranRecord.TANGGAL_TUKAR.split(' ')[0] : '';
                    editTanggalTukarModal.style.display = 'flex'; // Use flex to center
                } else {
                    alert('Penukaran record not found!');
                }
            }

            // Function to close the edit modal
            function closeEditModal() {
                editTanggalTukarModal.style.display = 'none';
                editTanggalTukarForm.reset(); // Clear the form
            }

            // Event listener for close button
            closeButton.addEventListener('click', closeEditModal);

            // Close modal when clicking outside of it
            window.addEventListener('click', (event) => {
                if (event.target === editTanggalTukarModal) {
                    closeEditModal();
                }
            });

            // Handle form submission for updating tanggal tukar
            editTanggalTukarForm.addEventListener('submit', async function(event) {
                event.preventDefault(); // Prevent default form submission

                const penukaranId = editPenukaranId.value;
                const newTanggalTukar = tanggalTukarField.value; // This will be in YYYY-MM-DD format from input type="date"
                const currentIdPembeli = editIdPembeli.value;
                const currentNamaPenukar = editNamaPenukar.value;

                try {
                    const response = await fetch(`/api/penukaran/update/${penukaranId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            // If you have CSRF protection, you'll need to include the CSRF token:
                            // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            ID_PEMBELI: currentIdPembeli,
                            NAMA_PENUKAR: currentNamaPenukar,
                            TANGGAL_TUKAR: newTanggalTukar // Send as YYYY-MM-DD to API
                        })
                    });

                    const result = await response.json();

                    if (!response.ok) {
                        throw new Error(result.message || 'Failed to update tanggal tukar');
                    }

                    alert('Tanggal tukar updated successfully!');
                    closeEditModal();
                    await fetchDataAndRender(); // Re-fetch and re-render data to show updates
                } catch (error) {
                    console.error('Error updating tanggal tukar:', error);
                    alert(`Failed to update tanggal tukar: ${error.message}`);
                }
            });

            // Initial data fetch and render
            fetchDataAndRender();

            // Add event listener for filtering
            filterInput.addEventListener('keyup', (event) => {
                renderTable(event.target.value);
            });
        });
    </script>
</body>
</html>