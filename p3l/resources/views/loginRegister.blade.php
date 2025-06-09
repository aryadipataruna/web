<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In / Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #000; /* Black */
            --secondary-color: #fff; /* White */
            --accent-color: #333; /* Dark Gray for subtle accents */
            --text-color: #333; /* Dark Gray for text */
            --light-text-color: #eee; /* Light Gray for text on dark background */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: var(--accent-color); /* A subtle dark gray background */
        }

        .container-custom { /* Renamed to avoid conflict with Bootstrap's .container */
            position: relative;
            width: 100vw;
            height: 100vh;
            background: var(--secondary-color); /* White background for the main container */
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .container-custom::before {
            content: "";
            position: absolute;
            top: 0;
            left: -50%;
            width: 100%;
            height: 100%;
            background: linear-gradient(-45deg, var(--primary-color), var(--accent-color)); /* Black to Dark Gray gradient */
            z-index: 6;
            transform: translateX(100%);
            transition: 1s ease-in-out;
        }

        .signin-signup {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-around;
            z-index: 5;
        }

        form {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            width: 40%;
            min-width: 238px;
            padding: 0 10px;
        }

        form.sign-in-form {
            opacity: 1;
            transition: 0.5s ease-in-out;
            transition-delay: 1s;
        }

        form.sign-up-form {
            opacity: 0;
            transition: 0.5s ease-in-out;
            transition-delay: 1s;
        }

        .title {
            font-size: 35px;
            color: var(--primary-color); /* Black title */
            margin-bottom: 10px;
            font-weight: 700; /* Make titles bolder */
        }

        .input-field {
            width: 100%;
            height: 50px;
            background: var(--light-text-color); /* Light gray for input background */
            margin: 10px 0;
            border: 2px solid var(--accent-color); /* Dark gray border */
            border-radius: 50px;
            display: flex;
            align-items: center;
            padding: 0 15px; /* Add padding for better input appearance */
        }

        .input-field i {
            color: var(--text-color); /* Dark gray icon color */
            font-size: 18px;
            margin-right: 10px;
        }

        .input-field input,
        .input-field select {
            flex: 1; /* Allow input to take remaining space */
            background: none;
            border: none;
            outline: none;
            width: 100%;
            font-size: 16px; /* Slightly smaller font for inputs */
            font-weight: 500;
            color: var(--text-color); /* Dark gray input text */
        }

        .input-field select {
            appearance: none; /* Remove default select arrow */
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
            padding-right: 25px; /* Space for custom arrow */
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23333"><path d="M7 10l5 5 5-5z"/></svg>'); /* Custom arrow for select */
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 15px;
        }

        .btn-custom { /* Renamed to avoid conflict with Bootstrap's .btn */
            width: 150px;
            height: 50px;
            border: none;
            border-radius: 50px;
            background: var(--primary-color); /* Black button background */
            color: var(--secondary-color); /* White text color */
            font-weight: 600;
            margin: 10px 0;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-custom:hover {
            background: var(--accent-color); /* Darker gray on hover */
        }

        a {
            text-decoration: none;
            color: var(--primary-color); /* Black link color */
            font-weight: 600;
        }
        a:hover {
            color: var(--accent-color);
        }

        .panels-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-around;
        }

        .panel {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-around;
            width: 35%;
            min-width: 238px;
            padding: 0 10px;
            text-align: center;
            z-index: 6;
        }

        .left-panel {
            pointer-events: none;
        }

        .content {
            color: var(--secondary-color); /* White text for panel content */
            transition: 1.1s ease-in-out;
            transition-delay: 0.5s;
        }

        .panel h3 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .panel p {
            font-size: 15px;
            padding: 10px 0;
        }

        .image {
            width: 100%;
            transition: 1.1s ease-in-out;
            transition-delay: 0.4s;
            max-width: 400px; /* Limit image size for better responsiveness */
        }

        .left-panel .image,
        .left-panel .content {
            transform: translateX(-200%);
        }

        .right-panel .image,
        .right-panel .content {
            transform: translateX(0);
        }

        .account-text {
            display: none;
            color: var(--text-color); /* Dark gray for account text */
            margin-top: 20px; /* Added margin for better spacing */
        }
        .error-message {
            color: #dc3545; /* Red for error messages */
            font-size: 0.9em;
            margin-top: 5px;
            text-align: center;
            width: 100%;
        }

        /*Animation*/
        .container-custom.sign-up-mode::before {
            transform: translateX(0);
        }

        .container-custom.sign-up-mode .right-panel .image,
        .container-custom.sign-up-mode .right-panel .content {
            transform: translateX(200%);
        }

        .container-custom.sign-up-mode .left-panel .image,
        .container-custom.sign-up-mode .left-panel .content {
            transform: translateX(0);
        }

        .container-custom.sign-up-mode form.sign-in-form {
            opacity: 0;
        }

        .container-custom.sign-up-mode form.sign-up-form {
            opacity: 1;
        }

        .container-custom.sign-up-mode .right-panel {
            pointer-events: none;
        }

        .container-custom.sign-up-mode .left-panel {
            pointer-events: all;
        }

        /*Responsive*/
        @media (max-width: 779px) {
            .container-custom {
                width: 100vw;
                height: 100vh;
            }
        }

        @media (max-width: 635px) {
            .container-custom::before {
                display: none;
            }
            form {
                width: 80%;
            }
            form.sign-up-form {
                display: none;
            }
            .container-custom.sign-up-mode2 form.sign-up-form {
                display: flex;
                opacity: 1;
            }
            .container-custom.sign-up-mode2 form.sign-in-form {
                display: none;
            }
            .panels-container {
                display: none;
            }
            .account-text {
                display: initial;
                margin-top: 30px;
            }
        }

        @media (max-width: 320px) {
            form {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container-custom">
        <div class="signin-signup">
            {{-- Update action to your login route --}}
            <form action="{{ route('login') }}" method="POST" class="sign-in-form" id="signInForm">
                {{-- Include CSRF token for security if using Laravel Blade --}}
                @csrf
                <h2 class="title">Sign in</h2>
                {{-- Error message display area --}}
                <div id="signInErrorMessage" class="error-message"></div>

                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <button type="submit" class="btn-custom">Login</button>
                <p class="account-text">Don't have an account? <a href="#" id="sign-up-btn2">Sign up</a></p>
            </form>


            <form action="" method="POST" class="sign-up-form" id="signUpForm">
                @csrf
                <h2 class="title">Sign up</h2>
                {{-- Error message display area --}}
                <div id="signUpErrorMessage" class="error-message"></div>

                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="generic_name" placeholder="Nama Lengkap" required data-generic-name="name">
                </div>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="generic_email" placeholder="Email" required data-generic-name="email">
                </div>
                <div class="input-field">
                    <i class="fas fa-user-tag"></i>
                    <select name="role" id="role-select" required>
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="pembeli">Pembeli</option>
                        <option value="organisasi">Organisasi</option>
                    </select>
                </div>
                <div class="input-field">
                    <i class="fas fa-phone"></i>
                    <input type="text" name="generic_phone" placeholder="Nomor Telepon" required data-generic-name="phone">
                </div>
                <div class="input-field">
                    <i class="fas fa-map-marker-alt"></i>
                    <input type="text" name="generic_address" placeholder="Alamat" required data-generic-name="address">
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="generic_password" placeholder="Password" required data-generic-name="password">
                </div>
                {{-- Hidden inputs for default values for nullable fields based on role --}}
                <input type="hidden" name="generic_poin" value="0" data-generic-name="poin">
                <input type="hidden" name="generic_saldo" value="0" data-generic-name="saldo">


                <button type="submit" class="btn-custom">Sign Up</button>
                <p class="account-text">Already have an account? <a href="#" id="sign-in-btn2">Sign in</a></p>
            </form>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Sudah punya akun?</h3>
                    <p>Masuk untuk melanjutkan pengalaman berbelanja Anda!</p>
                    <button class="btn-custom" id="sign-in-btn">Sign in</button>
                </div>
                <img src="signin.svg" alt="Sign In Illustration" class="image">
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Belum punya akun?</h3>
                    <p>Daftar sekarang dan temukan barang-barang unik di ReUse Mart!</p>
                    <button class="btn-custom" id="sign-up-btn">Sign up</button>
                </div>
                <img src="signup.svg" alt="Sign Up Illustration" class="image"> {{-- Added missing signup image --}}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlcoJoZ/z4nGSsNqF0/mHp/rS/sQ4pQ1Q1h/oI6" crossorigin="anonymous"></script>

    <script>
        // Get references to DOM elements
        const sign_in_btn = document.querySelector("#sign-in-btn");
        const sign_up_btn = document.querySelector("#sign-up-btn");
        const container = document.querySelector(".container-custom");
        const sign_in_btn2 = document.querySelector("#sign-in-btn2");
        const sign_up_btn2 = document.querySelector("#sign-up-btn2");

        // Get references to the forms and error message divs
        const signInForm = document.getElementById('signInForm');
        const signUpForm = document.getElementById('signUpForm');
        const signInErrorMessage = document.getElementById('signInErrorMessage');
        const signUpErrorMessage = document.getElementById('signUpErrorMessage');

        // Get references to the sign-up form specific elements for dynamic naming
        const roleSelect = document.querySelector("#role-select");
        const signUpInputs = signUpForm.querySelectorAll('input[type="text"], input[type="email"], input[type="password"], input[type="hidden"]');
        const signUpInputFields = signUpForm.querySelectorAll('.input-field');


        // Function to update the sign-up form action and input names based on the selected role
        function updateSignUpForm() {
            const selectedRole = roleSelect.value;
            let registrationRoute = '';
            let nameMapping = {};
            let requiredFields = []; // Define required fields for each role

            switch (selectedRole) {
                case 'pembeli':
                    registrationRoute = '{{ route("pembeli.store") }}';
                    nameMapping = {
                        'name': 'NAMA_PEMBELI',
                        'email': 'EMAIL_PEMBELI',
                        'password': 'PASSWORD_PEMBELI',
                        'phone': 'NO_PEMBELI',
                        'address': 'ALAMAT_PEMBELI',
                        'poin': 'POIN_PEMBELI',
                    };
                    requiredFields = ['name', 'email', 'password', 'phone', 'address'];
                    break;
                case 'organisasi':
                    registrationRoute = '{{ route("organisasi.store") }}';
                    nameMapping = {
                        'name': 'NAMA_ORGANISASI',
                        'email': 'EMAIL_ORGANISASI',
                        'phone': 'NOTELP_ORGANISASI',
                        'address': 'ALAMAT_ORGANISASI',
                        'password': 'PASSWORD_ORGANISASI',
                    };
                    requiredFields = ['name', 'email', 'password', 'phone', 'address'];
                    break;
                default:
                    // This case should ideally not be hit if "Pilih Role" is disabled and only pembeli/organisasi are options
                    registrationRoute = '';
                    nameMapping = {};
                    requiredFields = [];
            }

            // Update the form's action attribute
            signUpForm.action = registrationRoute;

            // Update the name attribute of each input field based on the mapping
            signUpInputFields.forEach(inputFieldDiv => {
                const inputElement = inputFieldDiv.querySelector('input, select');
                if (inputElement) {
                    const genericName = inputElement.getAttribute('data-generic-name') || (inputElement.name === 'role' ? 'role' : null);

                    if (genericName && nameMapping[genericName]) {
                        inputElement.name = nameMapping[genericName];
                        inputFieldDiv.style.display = ''; // Show the input field
                        inputElement.required = requiredFields.includes(genericName); // Set required attribute
                    } else if (genericName === 'role') {
                        // The role select input is always visible
                        inputFieldDiv.style.display = '';
                    }
                    else {
                        // If no specific mapping for the current role, hide the field
                        inputFieldDiv.style.display = 'none';
                        inputElement.required = false; // Not required if hidden
                        // Reset name to generic if it was mapped to a specific name for a different role
                        inputElement.name = 'generic_' + genericName;
                    }

                    // Set default values for hidden fields if they are part of the mapping
                    if (inputElement.type === 'hidden') {
                        if (inputElement.getAttribute('data-generic-name') === 'poin' && selectedRole === 'pembeli') {
                            inputElement.value = '0';
                            inputFieldDiv.style.display = ''; // Ensure hidden field's parent is visible if it's explicitly needed
                        } else if (inputElement.getAttribute('data-generic-name') === 'saldo' && selectedRole === 'organisasi') { // Corrected logic for saldo based on previous conversation
                            inputElement.value = '0';
                            inputFieldDiv.style.display = ''; // Ensure hidden field's parent is visible if it's explicitly needed
                        } else {
                            // If a hidden field is not relevant for the selected role, hide its container
                             inputFieldDiv.style.display = 'none';
                        }
                    }
                }
            });
        }

        // Add event listener to the role select dropdown to update the form action and input names on change
        roleSelect.addEventListener("change", updateSignUpForm);

        // Call the function initially to set the correct action and input names based on the default selected option
        updateSignUpForm();


        // Event listener for the desktop "Sign up" button
        sign_up_btn.addEventListener("click", () => {
            container.classList.add("sign-up-mode");
            signUpForm.reset();
            signUpErrorMessage.textContent = '';
            // Ensure form names are updated for the default/currently selected role
            updateSignUpForm();
        });

        // Event listener for the desktop "Sign in" button
        sign_in_btn.addEventListener("click", () => {
            container.classList.remove("sign-up-mode");
            signInForm.reset();
            signInErrorMessage.textContent = '';
        });

        // Event listener for the mobile "Sign up" link
        sign_up_btn2.addEventListener("click", () => {
            container.classList.add("sign-up-mode2");
            signUpForm.reset();
            signUpErrorMessage.textContent = '';
            updateSignUpForm();
        });

        // Event listener for the mobile "Sign in" link
        sign_in_btn2.addEventListener("click", () => {
            container.classList.remove("sign-up-mode2");
            signInForm.reset();
            signInErrorMessage.textContent = '';
        });

        // --- API Call Logic for Sign In ---
        signInForm.addEventListener("submit", async (event) => {
            event.preventDefault(); // Prevent default form submission

            // Clear previous error messages
            signInErrorMessage.textContent = '';

            const formData = new FormData(signInForm);
            const data = {
                email: formData.get('email'),
                password: formData.get('password'),
                remember: formData.has('remember') ? formData.get('remember') : false
            };

            try {
                const response = await fetch(signInForm.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : ''
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    console.log('Login successful:', result);
                    localStorage.setItem('api_token', result.data.token);
                    localStorage.setItem('user_info', JSON.stringify(result.data.user));
                    localStorage.setItem('user_role', result.data.role);

                    // Redirect based on role
                    if (result.data.role === 'admin') {
                        window.location.href = '/adminPagePegawai';
                    } else if (result.data.role === 'pembeli') {
                        window.location.href = '/home';
                    } else if (result.data.role === 'penitip') {
                        window.location.href = '/penitipDashboard';
                    } else if (result.data.role === 'organisasi') {
                        window.location.href = '/organisasiDashboard';
                    } else if (result.data.role === 'owner') {
                        window.location.href = '/adminPageOwner';
                    } else if (result.data.role === 'gudang') {
                        window.location.href = '/adminPageGudang';
                    } else if (result.data.role === 'customer service') {
                        window.location.href = '/adminPageCS';
                    } else if (result.data.role === 'hunter') {
                        window.location.href = '/hunterDashboard';
                    } else if (result.data.role === 'kurir') {
                        window.location.href = '/kurirDashboard';
                    } else {
                        window.location.href = '/dashboard';
                    }
                } else {
                    console.error('Login failed:', result.message);
                    signInErrorMessage.textContent = result.message || 'Login failed. Please try again.';
                }
            } catch (error) {
                console.error('Error during login:', error);
                signInErrorMessage.textContent = 'An error occurred. Please try again later.';
            }
        });

        // --- API Call Logic for Sign Up ---
        signUpForm.addEventListener("submit", async (event) => {
            event.preventDefault(); // Prevent default form submission

            // Clear previous error messages
            signUpErrorMessage.textContent = '';

            const formData = new FormData(signUpForm);
            const data = Object.fromEntries(formData.entries());

            const registrationEndpoint = signUpForm.action;

            if (!registrationEndpoint) {
                signUpErrorMessage.textContent = 'Please select a role to register.';
                console.error('Registration endpoint not set. Role not selected or invalid.');
                return;
            }

            // Remove the 'role' field and any fields that still have 'generic_' prefix
            const finalData = {};
            for (const key in data) {
                if (!key.startsWith('generic_') && key !== 'role') {
                    finalData[key] = data[key];
                }
            }

            try {
                const response = await fetch(registrationEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : ''
                    },
                    body: JSON.stringify(finalData)
                });

                const result = await response.json();

                if (response.ok && result.status === true) {
                    console.log('Registration successful:', result);
                    alert('Registration successful! Please sign in.');
                    container.classList.remove("sign-up-mode");
                    container.classList.remove("sign-up-mode2");
                    signInForm.reset();
                    signInErrorMessage.textContent = '';
                } else {
                    console.error('Registration failed:', result.message);
                    if (result.errors) {
                        let errorMessages = '';
                        for (const field in result.errors) {
                            errorMessages += result.errors[field].join(', ') + '\n';
                        }
                        signUpErrorMessage.textContent = 'Validation failed:\n' + errorMessages;
                        console.error('Validation errors:', result.errors);
                    } else {
                        signUpErrorMessage.textContent = result.message || 'Registration failed. Please try again.';
                    }
                }
            } catch (error) {
                console.error('Error during registration:', error);
                signUpErrorMessage.textContent = 'An error occurred during registration. Please try again later.';
            }
        });
    </script>
</body>
</html>