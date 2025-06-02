<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Pegawai</title>
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

        .filter-section {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap; /* Allow wrapping on smaller screens */
        }

        .filter-section label {
            font-weight: 600;
        }

        .filter-section .search-input {
            flex-grow: 1; /* Allow search input to take available space */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            min-width: 150px; /* Minimum width for search input */
        }

        .filter-section .add-button {
            background-color: #8576FF; /* Button background */
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .filter-section .add-button:hover {
            background-color: #6b60c4; /* Darker color on hover */
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .data-table th {
            background-color: #f2f2f2; /* Header background */
            font-weight: 700;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f9f9f9; /* Zebra striping */
        }

        .data-table .action-buttons a {
            margin-right: 5px;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .data-table .action-buttons .edit-btn {
            background-color: #7BC9FF; /* Edit button color */
            color: #fff;
        }

        .data-table .action-buttons .delete-btn {
            background-color: #ff6b6b; /* Delete button color */
            color: #fff;
        }

         /* Style for loading message */
        #loading-message {
            text-align: center;
            padding: 20px;
            font-size: 1.2rem;
            color: #666;
        }

        /* Style for success/error messages below the table */
        #status-message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            display: none; /* Hidden by default */
        }

        #status-message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        #status-message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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

            .filter-section {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-section .search-input,
            .filter-section .add-button {
                width: 100%;
            }

            .data-table th,
            .data-table td {
                padding: 8px;
            }

             .modal-content {
                 width: 95%; /* Make modal wider on smaller screens */
             }
        }

        @media (max-width: 480px) {
            .page-title {
                font-size: 1.5rem;
            }
        }

    </style>
</head>
<body>

    <div class="navbar">
        <div class="nav-links">
            <a href="#">Dashboard</a>
            <a href="{{ route('adminPagePegawai') }}">Pegawai</a> 
            <a href="{{ route('adminPageOrganisasi') }}">Organisasi</a>
            <a href="{{ route('adminPageMerchandise') }}">Merchandise</a>
            <a href="#">Profile</a>
        </div>
        <div class="user-info">
            <div class="user-details">
                <span>GreenTea123</span>
                <span class="role">Admin</span>
            </div>
            <div class="user-avatar">
                 <i class="fas fa-user"></i> {{-- User icon --}}
            </div>
        </div>
    </div>

    <div class="container">
        <h1 class="page-title">Data Pegawai - ReUse Mart</h1>

        <div class="filter-section">
            <label for="search">Filter Rows:</label>
            {{-- Changed placeholder to reflect filtering by name or ID --}}
            <input type="text" id="search" class="search-input" placeholder="Search By Name or ID Pegawai">
            <button class="add-button" id="add-pegawai-button">
                 <i class="fas fa-plus"></i> Tambah Pegawai
            </button>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>ID Pegawai</th>
                    <th>Nama Pegawai</th>
                    <th>Email</th>
                    <th>Nomor Telepon</th>
                    <th>Alamat</th>
                    <th>ID Jabatan</th> {{-- Or Jabatan Name if joining tables --}}
                    {{-- Add other relevant Pegawai columns here --}}
                </tr>
            </thead>
            <tbody id="pegawai-table-body">
                {{-- Data will be loaded here by JavaScript --}}
                 <tr>
                    <td colspan="7" id="loading-message">Loading Pegawai data...</td>
                 </tr>
            </tbody>
        </table>
        <div id="status-message" class="status"></div> {{-- Area for status messages --}}
    </div>

    <div id="addPegawaiModal" class="modal">
        <div class="modal-content">
            <span class="close-button add-close-button">&times;</span>
            <h2>Tambah Pegawai Baru</h2>
            <div id="addFormErrorMessages" class="form-error-messages"></div> {{-- Error message area for the form --}}
            <form id="addPegawaiForm">
                <label for="addIdJabatan">ID Jabatan:</label>
                {{-- You might want a dropdown here populated with Jabatan options --}}
                <input type="text" id="addIdJabatan" name="ID_JABATAN" required>

                <label for="addNamaPegawai">Nama Pegawai:</label>
                <input type="text" id="addNamaPegawai" name="NAMA_PEGAWAI" required>

                <label for="addTglLahirPegawai">Tanggal Lahir:</label>
                <input type="date" id="addTglLahirPegawai" name="TGL_LAHIR_PEGAWAI" required>

                <label for="addNotelpPegawai">Nomor Telepon:</label>
                <input type="text" id="addNotelpPegawai" name="NOTELP_PEGAWAI" required>

                <label for="addEmailPegawai">Email:</label>
                <input type="email" id="addEmailPegawai" name="EMAIL_PEGAWAI" required>

                <label for="addPasswordPegawai">Password:</label>
                <input type="password" id="addPasswordPegawai" name="PASSWORD_PEGAWAI" required minlength="8">

                <label for="addAlamatPegawai">Alamat:</label>
                <input type="text" id="addAlamatPegawai" name="ALAMAT_PEGAWAI" required>

                <button type="submit">Tambah Pegawai</button>
            </form>
        </div>
    </div>


    <div id="editPegawaiModal" class="modal">
        <div class="modal-content">
            <span class="close-button edit-close-button">&times;</span>
            <h2>Edit Pegawai</h2>
            <div id="editFormErrorMessages" class="form-error-messages"></div> {{-- Error message area for the form --}}
            <form id="editPegawaiForm">
                {{-- Hidden input for Pegawai ID --}}
                <input type="hidden" id="editPegawaiId" name="ID_PEGAWAI">

                <label for="editIdJabatan">ID Jabatan:</label>
                {{-- You might want a dropdown here populated with Jabatan options --}}
                <input type="text" id="editIdJabatan" name="ID_JABATAN" required>

                <label for="editNamaPegawai">Nama Pegawai:</label>
                <input type="text" id="editNamaPegawai" name="NAMA_PEGAWAI" required>

                 <label for="editTglLahirPegawai">Tanggal Lahir:</label>
                <input type="date" id="editTglLahirPegawai" name="TGL_LAHIR_PEGAWAI" required>

                <label for="editNotelpPegawai">Nomor Telepon:</label>
                <input type="text" id="editNotelpPegawai" name="NOTELP_PEGAWAI" required>

                <label for="editEmailPegawai">Email:</label>
                <input type="email" id="editEmailPegawai" name="EMAIL_PEGAWAI" required>

                <label for="editAlamatPegawai">Alamat:</label>
                <input type="text" id="editAlamatPegawai" name="ALAMAT_PEGAWAI" required>

                {{-- Password field (optional for update, handle carefully in backend) --}}
                <label for="editPasswordPegawai">Password (Optional):</label>
                <input type="password" id="editPasswordPegawai" name="PASSWORD_PEGAWAI" minlength="8">


                <button type="submit">Update Pegawai</button>
            </form>
        </div>
    </div>


    <script>
        // Get reference to the table body and status message div
        const pegawaiTableBody = document.querySelector('#pegawai-table-body');
        const loadingMessage = document.querySelector('#loading-message');
        const statusMessageDiv = document.getElementById('status-message');

        // Get references to Add modal elements
        const addPegawaiModal = document.getElementById('addPegawaiModal');
        const addCloseButton = addPegawaiModal.querySelector('.close-button');
        const addPegawaiForm = document.getElementById('addPegawaiForm');
        const addFormErrorMessages = document.getElementById('addFormErrorMessages');
        const addPegawaiButton = document.getElementById('add-pegawai-button'); // Reference to the "Tambah Pegawai" button


        // Get references to Edit modal elements
        const editPegawaiModal = document.getElementById('editPegawaiModal');
        const editCloseButton = editPegawaiModal.querySelector('.close-button');
        const editPegawaiForm = document.getElementById('editPegawaiForm');
        const editFormErrorMessages = document.getElementById('editFormErrorMessages');

        // Get references to Edit form input fields
        const editPegawaiIdInput = document.getElementById('editPegawaiId');
        const editIdJabatanInput = document.getElementById('editIdJabatan');
        const editNamaPegawaiInput = document.getElementById('editNamaPegawai');
        const editTglLahirPegawaiInput = document.getElementById('editTglLahirPegawai'); // Added date input
        const editNotelpPegawaiInput = document.getElementById('editNotelpPegawai');
        const editEmailPegawaiInput = document.getElementById('editEmailPegawai');
        const editAlamatPegawaiInput = document.getElementById('editAlamatPegawai');
        const editPasswordPegawaiInput = document.getElementById('editPasswordPegawai');

        // Get reference to the search input
        const searchInput = document.getElementById('search');


        // Function to display status messages
        function showStatusMessage(message, type) {
            statusMessageDiv.textContent = message;
            statusMessageDiv.className = 'status'; // Reset classes
            statusMessageDiv.classList.add(type); // Add 'success' or 'error' class
            statusMessageDiv.style.display = 'block'; // Make it visible

            // Hide the message after a few seconds
            setTimeout(() => {
                statusMessageDiv.style.display = 'none';
            }, 5000); // Hide after 5 seconds
        }


        // Function to fetch and display Pegawai data
        async function fetchPegawaiData() {
            try {
                // Show loading message
                pegawaiTableBody.innerHTML = `<tr><td colspan="7" id="loading-message">Loading Pegawai data...</td></tr>`;
                statusMessageDiv.style.display = 'none'; // Hide any previous status messages


                // Get the token from localStorage
                const token = localStorage.getItem('api_token');

                if (!token) {
                    // Redirect to login if no token is found
                    showStatusMessage('Authentication token not found. Please log in.', 'error');
                    // Redirect to login page after a delay
                    setTimeout(() => { window.location.href = '/login-regis'; }, 2000); // Adjust login route as needed
                    return; // Stop execution
                }


                // Fetch data from the API route
                // Adjust the URL if your API route is different from /api/pegawai/authenticated
                const response = await fetch('/api/pegawai/authenticated', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        // Include Authorization header with the bearer token
                        'Authorization': 'Bearer ' + token
                    }
                });

                // Check if the request was successful (status code 200-299)
                if (!response.ok) {
                    // If authentication failed (e.g., 401 Unauthorized), redirect to login
                    if (response.status === 401) {
                         showStatusMessage('Session expired or invalid token. Please log in again.', 'error');
                         // Clear token and redirect to login
                         localStorage.removeItem('api_token');
                         localStorage.removeItem('user_info');
                         localStorage.removeItem('user_role');
                         setTimeout(() => { window.location.href = '/login-regis'; }, 2000); // Adjust login route as needed
                    } else {
                        // Handle other HTTP errors
                        const errorData = await response.json(); // Attempt to parse error response
                        throw new Error(`HTTP error! status: ${response.status}, Message: ${errorData.message || response.statusText}`);
                    }
                    return; // Stop execution
                }

                const responseData = await response.json();

                // Check if the API response indicates success and contains data
                // Assuming your API returns { status: true, data: [...] } on success
                if (responseData.status === true && responseData.data) {
                    const pegawaiData = responseData.data;

                    // Store the fetched data globally or in a data attribute for filtering
                    // This allows filtering without re-fetching every time
                    pegawaiTableBody.dataset.allPegawai = JSON.stringify(pegawaiData);

                    // Populate the table with fetched data
                    renderPegawaiTable(pegawaiData);


                } else {
                    // Handle API response indicating failure (status: false)
                    console.error('API response indicates failure:', responseData);
                    pegawaiTableBody.innerHTML = `<tr><td colspan="7" style="text-align:center; color:red;">Failed to load data: ${responseData.message || 'Unknown error'}</td></tr>`;
                }

            } catch (error) {
                // Handle network errors or other exceptions during fetch
                console.error('Error fetching Pegawai data:', error);
                pegawaiTableBody.innerHTML = `<tr><td colspan="7" style="text-align:center; color:red;">Error loading data. Please check console for details.</td></tr>`;
                showStatusMessage(`Error loading data: ${error.message}`, 'error');
            }
        }

        // Function to render the pegawai table with provided data
        function renderPegawaiTable(pegawaiData) {
             // Clear the table body
            pegawaiTableBody.innerHTML = '';

            if (pegawaiData.length > 0) {
                pegawaiData.forEach(pegawai => {
                    const row = document.createElement('tr');
                    // Store the Pegawai ID on the row for easy access
                    row.dataset.pegawaiId = pegawai.ID_PEGAWAI;

                    row.innerHTML = `
                        <td class="action-buttons">
                            <a href="#" class="edit-btn" data-id="${pegawai.ID_PEGAWAI}">Edit</a>
                            <a href="#" class="delete-btn" data-id="${pegawai.ID_PEGAWAI}">Delete</a>
                        </td>
                        <td>${pegawai.ID_PEGAWAI}</td>
                        <td>${pegawai.NAMA_PEGAWAI}</td>
                        <td>${pegawai.EMAIL_PEGAWAI}</td>
                        <td>${pegawai.NOTELP_PEGAWAI}</td>
                        <td>${pegawai.ALAMAT_PEGAWAI}</td>
                        <td>${pegawai.ID_JABATAN}</td>
                        {{-- Add other data cells based on your API response --}}
                    `;
                    pegawaiTableBody.appendChild(row);
                });

                // Re-attach event listeners to the new buttons after populating the table
                attachButtonListeners();

            } else {
                // Display a message if no data is available
                pegawaiTableBody.innerHTML = '<tr><td colspan="7" style="text-align:center;">No Pegawai data found.</td></tr>';
            }
        }


        // Function to attach event listeners to action buttons
        function attachButtonListeners() {
             // Add event listeners for Edit buttons
            document.querySelectorAll('.action-buttons .edit-btn').forEach(button => {
                button.addEventListener('click', async (event) => { // Made async to fetch data
                    event.preventDefault(); // Prevent default link behavior
                    const pegawaiId = event.target.dataset.id; // Get ID from data attribute

                    // Clear previous error messages in the form
                    editFormErrorMessages.textContent = '';

                    // Get the token from localStorage
                    const token = localStorage.getItem('api_token');

                    if (!token) {
                        showStatusMessage('Authentication token not found. Please log in.', 'error');
                        setTimeout(() => { window.location.href = '/login-regis'; }, 2000);
                        return;
                    }

                    try {
                        // Fetch the specific Pegawai data for editing
                        // Assuming your route is /api/pegawai/authenticated/{id} for fetching a single record
                        const fetchUrl = `/api/pegawai/authenticated/${pegawaiId}`;
                        const response = await fetch(fetchUrl, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': 'Bearer ' + token
                            }
                        });

                        if (!response.ok) {
                             // If authentication failed (e.g., 401 Unauthorized), redirect to login
                            if (response.status === 401) {
                                showStatusMessage('Session expired or invalid token. Please log in again.', 'error');
                                localStorage.removeItem('api_token');
                                localStorage.removeItem('user_info');
                                localStorage.removeItem('user_role');
                                setTimeout(() => { window.location.href = '/login-regis'; }, 2000); // Adjust login route as needed
                            } else {
                                // Handle other HTTP errors
                                const errorData = await response.json();
                                showStatusMessage(`Failed to fetch Pegawai data for editing: ${errorData.message || response.statusText}`, 'error');
                                console.error('Error fetching Pegawai data for editing:', errorData);
                            }
                            return; // Stop execution
                        }

                        const result = await response.json();

                        // Assuming your show method returns { status: true, data: { ...pegawai } }
                        if (result.status === true && result.data) {
                            const pegawaiData = result.data;

                            // Populate the edit form with the fetched data
                            editPegawaiIdInput.value = pegawaiData.ID_PEGAWAI;
                            editIdJabatanInput.value = pegawaiData.ID_JABATAN;
                            editNamaPegawaiInput.value = pegawaiData.NAMA_PEGAWAI;
                            editTglLahirPegawaiInput.value = pegawaiData.TGL_LAHIR_PEGAWAI; // Populate date input
                            editNotelpPegawaiInput.value = pegawaiData.NOTELP_PEGAWAI;
                            editEmailPegawaiInput.value = pegawaiData.EMAIL_PEGAWAI;
                            editAlamatPegawaiInput.value = pegawaiData.ALAMAT_PEGAWAI;
                            // Do NOT populate the password field for security reasons

                            // Show the modal
                            editPegawaiModal.style.display = 'flex'; // Use flex to center
                        } else {
                             console.error('API response indicates failure when fetching data for editing:', result.message);
                             showStatusMessage(`Failed to fetch Pegawai data: ${result.message || 'Unknown error'}`, 'error');
                        }

                    } catch (error) {
                        console.error('Error fetching Pegawai data for editing:', error);
                        showStatusMessage(`Error fetching Pegawai data for editing: ${error.message}`, 'error');
                    }
                });
            });

            // Add event listeners for Delete buttons
             document.querySelectorAll('.action-buttons .delete-btn').forEach(button => {
                button.addEventListener('click', async (event) => { // Made async to use await
                    event.preventDefault(); // Prevent default link behavior
                    const pegawaiId = event.target.dataset.id; // Get ID from data attribute
                    const row = event.target.closest('tr'); // Get the parent table row

                    // Corrected: Use pegawaiId in the confirm message
                    if (confirm('Are you sure you want to delete Pegawai ID: ' + pegawaiId + '?')) {
                        // User confirmed deletion

                        // Get the token from localStorage
                        const token = localStorage.getItem('api_token');

                        if (!token) {
                            showStatusMessage('Authentication token not found. Please log in.', 'error');
                            setTimeout(() => { window.location.href = '/login-regis'; }, 2000);
                            return;
                        }

                        try {
                            // Corrected: Use pegawaiId in the delete API URL
                            const deleteUrl = `/api/pegawai/delete/authenticated/${pegawaiId}`; // Use the correct route path

                            // Send the DELETE request
                            const response = await fetch(deleteUrl, {
                                method: 'DELETE',
                                headers: {
                                    'Accept': 'application/json',
                                    'Authorization': 'Bearer ' + token
                                    // Include X-CSRF-TOKEN if your API route uses web middleware
                                    // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : ''
                                }
                            });

                            const result = await response.json();

                            // Check if the API call was successful
                            // Assuming your delete method returns { status: true, message: ... } on success
                            if (response.ok && result.status === true) {
                                showStatusMessage('Pegawai successfully deleted!', 'success');
                                console.log('Delete successful:', result.message);
                                // Remove the row from the table
                                row.remove();
                                // Update the stored data after deletion
                                updateStoredDataAfterDeletion(pegawaiId);
                            } else {
                                // Handle API response indicating failure
                                console.error('Delete failed:', result.message);
                                showStatusMessage(`Failed to delete Pegawai: ${result.message || 'Unknown error'}`, 'error');

                                // If authentication failed (e.g., 401 Unauthorized), redirect to login
                                if (response.status === 401) {
                                     localStorage.removeItem('api_token');
                                     localStorage.removeItem('user_info');
                                     localStorage.removeItem('user_role');
                                     setTimeout(() => { window.location.href = '/login-regis'; }, 2000); // Adjust login route as needed
                                }
                            }

                        } catch (error) {
                            // Handle network errors or other exceptions during fetch
                            console.error('Error during delete:', error);
                            showStatusMessage(`Error deleting Pegawai: ${error.message}`, 'error');
                        }
                    }
                });
            });
        }

        // Function to update the stored data after a successful deletion
        function updateStoredDataAfterDeletion(deletedId) {
            const allPegawaiData = JSON.parse(pegawaiTableBody.dataset.allPegawai || '[]');
            const updatedData = allPegawaiData.filter(pegawai => pegawai.ID_PEGAWAI !== deletedId);
            pegawaiTableBody.dataset.allPegawai = JSON.stringify(updatedData);
            // No need to re-render the table here as the row is already removed
            // If search is active, re-apply the filter
             if (searchInput.value) {
                 filterTable();
             }
        }


        // --- Add Pegawai Button Listener ---
        addPegawaiButton.addEventListener('click', () => {
            // Clear the form and any previous error messages
            addPegawaiForm.reset();
            addFormErrorMessages.textContent = '';
            // Show the add modal
            addPegawaiModal.style.display = 'flex';
        });


        // --- Modal Close Button Listeners (for both Add and Edit) ---
        document.querySelectorAll('.close-button').forEach(button => {
            button.addEventListener('click', () => {
                // Determine which modal to close based on the button's parent
                const modal = button.closest('.modal');
                if (modal) {
                    modal.style.display = 'none'; // Hide the modal
                    // Reset the form and clear error messages for the specific modal
                    if (modal.id === 'addPegawaiModal') {
                        addPegawaiForm.reset();
                        addFormErrorMessages.textContent = '';
                    } else if (modal.id === 'editPegawaiModal') {
                        editPegawaiForm.reset();
                        editFormErrorMessages.textContent = '';
                    }
                }
            });
        });


        // Close any modal if the user clicks outside of it
        window.addEventListener('click', (event) => {
            if (event.target.classList.contains('modal')) {
                 // Determine which modal was clicked outside of
                 const modal = event.target;
                 if (modal.id === 'addPegawaiModal') {
                     addPegawaiForm.reset();
                     addFormErrorMessages.textContent = '';
                 } else if (modal.id === 'editPegawaiModal') {
                     editPegawaiForm.reset();
                     editFormErrorMessages.textContent = '';
                 }
                 modal.style.display = 'none'; // Hide the modal
            }
        });


        // --- Add Form Submission Listener ---
        addPegawaiForm.addEventListener('submit', async (event) => {
            event.preventDefault(); // Prevent default form submission

            // Clear previous error messages
            addFormErrorMessages.textContent = '';

            const token = localStorage.getItem('api_token');

            if (!token) {
                showStatusMessage('Authentication token not found. Please log in.', 'error');
                setTimeout(() => { window.location.href = '/login-regis'; }, 2000);
                return;
            }

            // Collect data from the form
            const newPegawaiData = {
                ID_JABATAN: document.getElementById('addIdJabatan').value,
                NAMA_PEGAWAI: document.getElementById('addNamaPegawai').value,
                TGL_LAHIR_PEGAWAI: document.getElementById('addTglLahirPegawai').value,
                NOTELP_PEGAWAI: document.getElementById('addNotelpPegawai').value,
                EMAIL_PEGAWAI: document.getElementById('addEmailPegawai').value,
                PASSWORD_PEGAWAI: document.getElementById('addPasswordPegawai').value,
                ALAMAT_PEGAWAI: document.getElementById('addAlamatPegawai').value,
            };

            try {
                // Construct the create API URL
                // Assuming your create route is /api/pegawai/store/authenticated
                const createUrl = '/api/pegawai/create/authenticated'; // Use the renamed route

                // Send the POST request
                const response = await fetch(createUrl, {
                    method: 'POST', // Use POST method for creation
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token
                         // Include X-CSRF-TOKEN if your API route uses web middleware
                         // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : ''
                    },
                    body: JSON.stringify(newPegawaiData) // Send new data in the body
                });

                const result = await response.json();

                // Check if the API call was successful
                 // Assuming your store method returns { status: true, message: ... } on success
                if (response.ok && result.status === true) {
                    showStatusMessage('Pegawai successfully added!', 'success');
                    console.log('Add successful:', result.message);
                    // Hide the modal and refresh the table data
                    addPegawaiModal.style.display = 'none';
                    addPegawaiForm.reset();
                    fetchPegawaiData(); // Refresh the table to show the new entry
                } else {
                    // Handle API response indicating failure
                    console.error('Add failed:', result.message);
                    // Display validation errors if they exist
                     if (result.errors) {
                         let errorMessages = 'Validation errors:\n';
                         for (const field in result.errors) {
                             errorMessages += `- ${field}: ${result.errors[field].join(', ')}\n`;
                         }
                         addFormErrorMessages.textContent = errorMessages;
                         console.error('Validation errors:', result.errors);
                    } else {
                         addFormErrorMessages.textContent = result.message || 'Add failed. Please try again.';
                    }


                    // If authentication failed (e.g., 401 Unauthorized), redirect to login
                    if (response.status === 401) {
                         localStorage.removeItem('api_token');
                         localStorage.removeItem('user_info');
                         localStorage.removeItem('user_role');
                         setTimeout(() => { window.location.href = '/login-regis'; }, 2000); // Adjust login route as needed
                    }
                }

            } catch (error) {
                // Handle network errors or other exceptions during fetch
                console.error('Error during add:', error);
                addFormErrorMessages.textContent = `Error adding Pegawai: ${error.message}`;
                showStatusMessage(`Error adding Pegawai: ${error.message}`, 'error');
            }
        });


        // --- Edit Form Submission Listener ---
        editPegawaiForm.addEventListener('submit', async (event) => {
            event.preventDefault(); // Prevent default form submission

            // Clear previous error messages
            editFormErrorMessages.textContent = '';

            const pegawaiId = editPegawaiIdInput.value; // Get the ID from the hidden input
            const token = localStorage.getItem('api_token');

             if (!token) {
                showStatusMessage('Authentication token not found. Please log in.', 'error');
                setTimeout(() => { window.location.href = '/login-regis'; }, 2000);
                return;
            }

            // Collect updated data from the form
            const updatedData = {
                ID_JABATAN: editIdJabatanInput.value, // Use the correct field name
                NAMA_PEGAWAI: editNamaPegawaiInput.value, // Use the correct field name
                TGL_LAHIR_PEGAWAI: editTglLahirPegawaiInput.value, // Get date value
                NOTELP_PEGAWAI: editNotelpPegawaiInput.value, // Use the correct field name
                EMAIL_PEGAWAI: editEmailPegawaiInput.value, // Use the correct field name
                ALAMAT_PEGAWAI: editAlamatPegawaiInput.value, // Use the correct field name
            };

            // Only include password if it was provided in the form
            // Your backend controller should handle hashing if password is sent
            if (editPasswordPegawaiInput.value) {
                 updatedData.PASSWORD_PEGAWAI = editPasswordPegawaiInput.value;
            }


            try {
                // Construct the update API URL
                const updateUrl = `/api/pegawai/update/authenticated/${pegawaiId}`; // Use the correct route path and ID

                // Send the PUT request
                const response = await fetch(updateUrl, {
                    method: 'PUT', // Use PUT method
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token
                         // Include X-CSRF-TOKEN if your API route uses web middleware
                         // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : ''
                    },
                    body: JSON.stringify(updatedData) // Send updated data in the body
                });

                const result = await response.json();

                // Check if the API call was successful
                 // Assuming your update method returns { status: true, message: ... } on success
                if (response.ok && result.status === true) {
                    showStatusMessage('Pegawai successfully updated!', 'success');
                    console.log('Update successful:', result.message);
                    // Hide the modal and refresh the table data
                    editPegawaiModal.style.display = 'none';
                    editPegawaiForm.reset();
                    fetchPegawaiData(); // Refresh the table
                } else {
                    // Handle API response indicating failure
                    console.error('Update failed:', result.message);
                    // Display validation errors if they exist
                    if (result.errors) {
                         let errorMessages = 'Validation errors:\n';
                         for (const field in result.errors) {
                             errorMessages += `- ${field}: ${result.errors[field].join(', ')}\n`;
                         }
                         editFormErrorMessages.textContent = errorMessages;
                         console.error('Validation errors:', result.errors);
                    } else {
                         editFormErrorMessages.textContent = result.message || 'Update failed. Please try again.';
                    }


                    // If authentication failed (e.g., 401 Unauthorized), redirect to login
                    if (response.status === 401) {
                         localStorage.removeItem('api_token');
                         localStorage.removeItem('user_info');
                         localStorage.removeItem('user_role');
                         setTimeout(() => { window.location.href = '/login-regis'; }, 2000); // Adjust login route as needed
                    }
                }

            } catch (error) {
                // Handle network errors or other exceptions during fetch
                console.error('Error during update:', error);
                editFormErrorMessages.textContent = `Error updating Pegawai: ${error.message}`;
                showStatusMessage(`Error updating Pegawai: ${error.message}`, 'error');
            }
        });

        // --- Search Functionality ---
        searchInput.addEventListener('input', filterTable);

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const rows = pegawaiTableBody.querySelectorAll('tr');

            rows.forEach(row => {
                // Skip the loading message row if it's still there
                if (row.id === 'loading-message') {
                    row.style.display = 'none'; // Hide loading message during filter
                    return;
                }

                // Get the text content of the relevant cells (ID and Name)
                const idCell = row.cells[1]; // Assuming ID is the second cell (index 1)
                const nameCell = row.cells[2]; // Assuming Name is the third cell (index 2)

                if (idCell && nameCell) {
                     const idText = idCell.textContent.toLowerCase();
                     const nameText = nameCell.textContent.toLowerCase();

                     // Check if the search term is included in either the ID or the Name
                     if (idText.includes(searchTerm) || nameText.includes(searchTerm)) {
                         row.style.display = ''; // Show the row
                     } else {
                         row.style.display = 'none'; // Hide the row
                     }
                } else {
                     // Handle cases where cells might be missing unexpectedly
                     console.warn("Row structure unexpected, skipping filtering for this row:", row);
                }
            });
        }


        // --- Initial Data Load ---
        // Fetch data when the page loads
        fetchPegawaiData();

    </script>

</body>
</html>
