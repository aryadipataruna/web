<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <title>signin-signup</title>
    <style>
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
            background: #444;
        }
        .container {
            position: relative;
            width: 100vw;
            height: 100vh;
            background: #fff;
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.3), 0 6px 20px 0 rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        .container::before {
            content: "";
            position: absolute;
            top: 0;
            left: -50%;
            width: 100%;
            height: 100%;
            background: linear-gradient(-45deg, #8576FF, #7BC9FF);
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
            color: #8576FF;
            margin-bottom: 10px;
        }
        .input-field {
            width: 100%;
            height: 50px;
            background: #f0f0f0;
            margin: 10px 0;
            border: 2px solid #8576FF;
            border-radius: 50px;
            display: flex;
            align-items: center;
        }
        .input-field i {
            flex: 1;
            text-align: center;
            color: #666;
            font-size: 18px;
        }
        .input-field input {
            flex: 5;
            background: none;
            border: none;
            outline: none;
            width: 100%;
            font-size: 18px;
            font-weight: 600;
            color: #444;
        }
        .btn {
            width: 150px;
            height: 50px;
            border: none;
            border-radius: 50px;
            background: #8576FF;
            color: #fff;
            font-weight: 600;
            margin: 10px 0;
            text-transform: uppercase;
            cursor: pointer;
        }
        .btn:hover {
            background: #6b60c4;
        }
        a {
            text-decoration: none;
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
            color: #fff;
            transition: 1.1s ease-in-out;
            transition-delay: 0.5s;
        }
        .panel h3 {
            font-size: 24px;
            font-weight: 600;
        }
        .panel p {
            font-size: 15px;
            padding: 10px 0;
        }
        .image {
            width: 100%;
            transition: 1.1s ease-in-out;
            transition-delay: 0.4s;
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
        }
        /*Animation*/
        .container.sign-up-mode::before {
            transform: translateX(0);
        }
        .container.sign-up-mode .right-panel .image,
        .container.sign-up-mode .right-panel .content {
            transform: translateX(200%);
        }
        .container.sign-up-mode .left-panel .image,
        .container.sign-up-mode .left-panel .content {
            transform: translateX(0);
        }
        .container.sign-up-mode form.sign-in-form {
            opacity: 0;
        }
        .container.sign-up-mode form.sign-up-form {
            opacity: 1;
        }
        .container.sign-up-mode .right-panel {
            pointer-events: none;
        }
        .container.sign-up-mode .left-panel {
            pointer-events: all;
        }
        /*Responsive*/
        @media (max-width:779px) {
            .container {
                width: 100vw;
                height: 100vh;
            }
        }
        @media (max-width:635px) {
            .container::before {
                display: none;
            }
            form {
                width: 80%;
            }
            form.sign-up-form {
                display: none;
            }
            .container.sign-up-mode2 form.sign-up-form {
                display: flex;
                opacity: 1;
            }
            .container.sign-up-mode2 form.sign-in-form {
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
        @media (max-width:320px) {
            form {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="signin-signup">
            {{-- Update action to your login route --}}
            <form action="{{ route('login') }}" method="POST" class="sign-in-form" id="signInForm"> {{-- Added id="signInForm" --}}
                {{-- Include CSRF token for security if using Laravel Blade --}}
                @csrf
                <h2 class="title">Sign in</h2>
                {{-- Error message display area --}}
                <div id="signInErrorMessage" class="error-message"></div> {{-- Added error message div --}}

                <div class="input-field">
                    <i class="fas fa-envelope"></i> {{-- Changed icon to envelope for email --}}
                    {{-- Assuming your LoginController expects 'email' for login --}}
                    <input type="email" name="email" placeholder="Email" required> {{-- Changed name to email --}}
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                 {{-- Add remember me checkbox if needed --}}
                 {{-- <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                 </div> --}}
                <input type="submit" value="Login" class="btn">
                <p class="account-text">Don't have an account? <a href="#" id="sign-up-btn2">Sign up</a></p>
            </form>

            {{-- Note: The sign-up form needs to be updated to match the required fields
                 for the specific user type being registered (Pembeli, Penitip, Pegawai, or Organisasi)
                 and should target the correct registration API endpoint (e.g., /api/pembeli/register).
                 This example form is generic. --}}
            <form action="" method="POST" class="sign-up-form" id="signUpForm"> {{-- Added id="signUpForm" --}}
                 @csrf
                 <h2 class="title">Sign up</h2>
                 {{-- Error message display area --}}
                 <div id="signUpErrorMessage" class="error-message"></div> {{-- Added error message div --}}

                 {{-- Example fields - Update based on the specific registration you are implementing --}}
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
                         <option value="" disabled selected>Pilih Role</option> {{-- Default disabled option --}}
                         <option value="pembeli">Pembeli</option>
                         <option value="organisasi">Organisasi</option>
                         {{-- Add other roles (penitip, pegawai) if they can register via this form --}}
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
                 {{-- Add hidden inputs for default values for nullable fields based on role --}}
                 {{-- These will be updated by JavaScript based on the role --}}
                 <input type="hidden" name="generic_poin" value="0" data-generic-name="poin">
                 <input type="hidden" name="generic_saldo" value="0" data-generic-name="saldo">


                <input type="submit" value="Sign Up" class="btn"> {{-- Changed button text back to Sign Up --}}
                <p class="account-text">Already have an account? <a href="#" id="sign-in-btn2">Sign in</a></p>
            </form>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Sudah punya akun?</h3>
                    <p>Masuk untuk melanjutkan pengalaman berbelanja Anda!</p> <button class="btn" id="sign-in-btn">Sign in</button>
                </div>
                <img src="signin.svg" alt="Sign In Illustration" class="image"> </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Belum punya akun?</h3>
                    <p>Daftar sekarang dan temukan barang-barang unik di ReUse Mart!</p> <button class="btn" id="sign-up-btn">Sign up</button>
                </div>
                <div></div>
        </div>
    </div>

    <script>
        // Get references to DOM elements
        const sign_in_btn = document.querySelector("#sign-in-btn");
        const sign_up_btn = document.querySelector("#sign-up-btn");
        const container = document.querySelector(".container");
        const sign_in_btn2 = document.querySelector("#sign-in-btn2");
        const sign_up_btn2 = document.querySelector("#sign-up-btn2");

        // Get references to the forms and error message divs
        const signInForm = document.getElementById('signInForm'); // Get sign-in form by ID
        const signUpForm = document.getElementById('signUpForm'); // Get sign-up form by ID
        const signInErrorMessage = document.getElementById('signInErrorMessage'); // Get sign-in error div
        const signUpErrorMessage = document.getElementById('signUpErrorMessage'); // Get sign-up error div

         // Get references to the sign-up form specific elements for dynamic naming
        const roleSelect = document.querySelector("#role-select");
        const signUpInputs = signUpForm.querySelectorAll('input[type="text"], input[type="email"], input[type="password"], input[type="hidden"]');


        // Function to update the sign-up form action and input names based on the selected role
        function updateSignUpForm() {
            const selectedRole = roleSelect.value;
            let registrationRoute = '';
            let nameMapping = {}; 
            
            switch (selectedRole) {
                case 'pembeli':
                    registrationRoute = '{{ route("pembeli.store") }}'; // Use the named route for pembeli registration
                    nameMapping = {
                        'name': 'NAMA_PEMBELI',
                        'email': 'EMAIL_PEMBELI',
                        'password': 'PASSWORD_PEMBELI',
                        'phone': 'NO_PEMBELI', // Corrected name based on Pembeli model
                        'address': 'ALAMAT_PEMBELI',
                        // 'saldo': 'SALDO_PEMBELI' // Pembeli model doesn't have SALDO_PEMBELI
                    };
                    break;
                case 'organisasi':
                    registrationRoute = '{{ route("organisasi.store") }}'; // Use the named route for organisasi registration
                     nameMapping = {
                        'name': 'NAMA_ORGANISASI',
                        'email': 'EMAIL_ORGANISASI',
                        'phone': 'NOTELP_ORGANISASI', 
                        'address': 'ALAMAT_ORGANISASI',
                        'password': 'PASSWORD_ORGANISASI',
                    };
                    break;
                 
                default:
                    registrationRoute = '';
                    nameMapping = {}; // Clear mapping if no valid role is selected
            }

            // Update the form's action attribute
            signUpForm.action = registrationRoute;

            // Update the name attribute of each input field based on the mapping
            signUpInputs.forEach(input => {
                const genericName = input.getAttribute('data-generic-name');
                if (genericName && nameMapping[genericName]) {
                    input.name = nameMapping[genericName];
                    // Show or hide fields based on the selected role's requirements
                    // For simplicity, we'll keep all fields visible for now, but you might
                    // want to dynamically show/hide input-field divs here.
                    input.parentElement.style.display = ''; // Show the parent input-field div
                } else {
                     // If no mapping is found for a generic name for the selected role, hide the field
                     // or set its name back to generic if you need it for other roles
                     if (genericName) {
                         input.name = 'generic_' + genericName; // Reset name to generic
                         // Hide the parent input-field div if it's not needed for this role
                         // You'll need more specific logic here based on which fields are required for which role
                         // For example, if 'poin' is only for pembeli, hide it for organisasi.
                         // input.parentElement.style.display = 'none'; // Example: Hide the parent div
                     }
                }

                 // Handle default values for hidden fields if needed
                 if (input.type === 'hidden') {
                     const specificName = input.name;
                     if (specificName === 'POIN_PEMBELI' && selectedRole === 'pembeli') {
                          input.value = '0'; // Default poin to 0 for Pembeli
                     }
                      // Add other hidden field defaults here if necessary based on role
                 }
            });
             // You might need additional logic here to show/hide specific input-field divs
             // based on the selected role's required fields (e.g., hide phone/address for some roles)
        }

        // Add event listener to the role select dropdown to update the form action and input names on change
        roleSelect.addEventListener("change", updateSignUpForm);

        // Call the function initially to set the correct action and input names based on the default selected option
        updateSignUpForm();


        // Event listener for the desktop "Sign up" button
        sign_up_btn.addEventListener("click", () => {
            container.classList.add("sign-up-mode");
             // Reset sign-up form and error message when switching
            signUpForm.reset();
            signUpErrorMessage.textContent = '';
             // Ensure form names are updated for the default/currently selected role
             updateSignUpForm();
        });

        // Event listener for the desktop "Sign in" button
        sign_in_btn.addEventListener("click", () => {
            container.classList.remove("sign-up-mode");
             // Reset sign-in form and error message when switching
            signInForm.reset();
            signInErrorMessage.textContent = '';
        });

        // Event listener for the mobile "Sign up" link
        sign_up_btn2.addEventListener("click", () => {
            container.classList.add("sign-up-mode2");
             // Reset sign-up form and error message when switching
            signUpForm.reset();
            signUpErrorMessage.textContent = '';
             // Ensure form names are updated for the default/currently selected role
             updateSignUpForm();
        });

        // Event listener for the mobile "Sign in" link
        sign_in_btn2.addEventListener("click", () => {
            container.classList.remove("sign-up-mode2");
            // Reset sign-in form and error message when switching
            signInForm.reset();
            signInErrorMessage.textContent = '';
        });

        // --- API Call Logic for Sign In ---
        signInForm.addEventListener("submit", async (event) => {
            event.preventDefault(); // Prevent default form submission

            // Clear previous error messages
            signInErrorMessage.textContent = '';

            const formData = new FormData(signInForm);
            // Use the correct field names expected by your LoginController ('email', 'password')
            const data = {
                email: formData.get('email'),
                password: formData.get('password'),
                remember: formData.has('remember') ? formData.get('remember') : false // Handle optional remember me
            };

            try {
                // Use the correct route name 'login' which points to /api/login
                const response = await fetch(signInForm.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        // Include CSRF token if your login route is in web.php and uses csrf middleware
                        // If it's purely an API route in api.php, you might not need this,
                        // but it's safer to include if unsure or if your setup requires it.
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : ''
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok && result.success) { // Check for successful HTTP status and your custom success flag
                    console.log('Login successful:', result);
                    // Store the token and user info
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
                    }  else if (result.data.role === 'gudang') {
                        window.location.href = '/adminPageGudang';
                    }  else if (result.data.role === 'customer service') {
                        window.location.href = '/csDashboard';
                    }   else if (result.data.role === 'hunter') {
                        window.location.href = '/hunterDashboard';
                    }   else if (result.data.role === 'kurir') {
                        window.location.href = '/kurirDashboard';
                    }   else {
                        // Default redirect if role is unknown or not handled
                        window.location.href = '/dashboard'; // Fallback dashboard
                    }
                } else {
                    // Handle failed login
                    console.error('Login failed:', result.message);
                    signInErrorMessage.textContent = result.message || 'Login failed. Please try again.';
                }
            } catch (error) {
                console.error('Error during login:', error);
                // Handle network errors or other exceptions
                signInErrorMessage.textContent = 'An error occurred. Please try again later.';
            }
        });

         // --- API Call Logic for Sign Up ---
         // Note: This is a generic example. You need to update the URL and
         // field names to match the specific registration endpoint you are using
         // (e.g., /api/pembeli/register, /api/organisasi/register, etc.)
         // and the required fields for that user type.
         // This logic now uses the dynamically set form action and input names.
        signUpForm.addEventListener("submit", async (event) => {
            event.preventDefault(); // Prevent default form submission

            // Clear previous error messages
            signUpErrorMessage.textContent = '';

            const formData = new FormData(signUpForm);
            const data = Object.fromEntries(formData.entries());

            // Basic client-side password confirmation check - Use dynamically set name
            // Find the actual password input name
            const passwordInput = signUpForm.querySelector('input[data-generic-name="password"]');
            const passwordFieldName = passwordInput ? passwordInput.name : 'generic_password'; // Fallback to generic name

            // if (data[passwordFieldName] !== data.password_confirmation) {
            //     signUpErrorMessage.textContent = "Passwords do not match!";
            //     console.error("Passwords do not match!");
            //     return;
            // }
            // // Remove password_confirmation before sending
            // delete data.password_confirmation;

            // The registrationEndpoint is now set dynamically by updateSignUpForm()
            const registrationEndpoint = signUpForm.action;

            // Remove the 'role' field from the data sent to the registration endpoint
            // as the backend store methods don't expect it directly in the model data.
            // The role is used client-side to determine the endpoint.
            delete data.role;

            // Remove any fields that still have 'generic_' prefix, as they are not needed by the backend
            const finalData = {};
            for (const key in data) {
                 if (!key.startsWith('generic_')) {
                     finalData[key] = data[key];
                 }
            }


            // Check if a registration endpoint was successfully set
            if (!registrationEndpoint) {
                 signUpErrorMessage.textContent = 'Please select a role to register.';
                 console.error('Registration endpoint not set. Role not selected or invalid.');
                 return;
            }


            try {
                const response = await fetch(registrationEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                         // Include CSRF token if your registration route is in web.php and uses csrf middleware
                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : ''
                    },
                    body: JSON.stringify(finalData) // Send the filtered data
                });

                const result = await response.json();

                // Assuming your store method returns { status: true, message: "...", data: ... } on success
                if (response.ok && result.status === true) {
                    console.log('Registration successful:', result);
                    // Handle successful registration (e.g., show success message, redirect to login)
                    alert('Registration successful! Please sign in.'); // Simple alert
                    // Optionally redirect to the sign-in form
                    container.classList.remove("sign-up-mode"); // Switch back to sign-in view
                    container.classList.remove("sign-up-mode2"); // For mobile view
                    signInForm.reset(); // Clear sign-in form
                    signInErrorMessage.textContent = ''; // Clear sign-in error
                } else {
                    console.error('Registration failed:', result.message);
                     // Display error message to the user
                    // Handle validation errors specifically if needed (e.g., result.errors)
                    // If backend returns validation errors in 'errors' key
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
                // Handle network or other errors
                 signUpErrorMessage.textContent = 'An error occurred during registration. Please try again later.';
            }
        });


    </script>
</body>
</html>
