<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Added CSRF meta tag -->
    <title>Sign In / Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #000;
            --secondary-color: #fff;
            --accent-color: #333;
            --text-color: #333;
            --light-text-color: #eee;
            --error-color: #dc3545;
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
            background: var(--accent-color);
        }

        .container-custom {
            position: relative;
            width: 100vw;
            height: 100vh;
            background: var(--secondary-color);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .container-custom::before {
            content: "";
            position: absolute;
            top: 0;
            left: -50%;
            width: 100%;
            height: 100%;
            background: linear-gradient(-45deg, var(--primary-color), var(--accent-color));
            z-index: 6;
            transform: translateX(100%);
            transition: transform 1s ease-in-out;
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
            transition: opacity 0.5s ease-in-out 1s;
        }

        form.sign-up-form {
            opacity: 0;
            transition: opacity 0.5s ease-in-out 1s;
        }

        .title {
            font-size: 35px;
            color: var(--primary-color);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .input-field {
            width: 100%;
            height: 50px;
            background: var(--light-text-color);
            margin: 10px 0;
            border: 2px solid var(--accent-color);
            border-radius: 50px;
            display: flex;
            align-items: center;
            padding: 0 15px;
        }

        .input-field i {
            color: var(--text-color);
            font-size: 18px;
            margin-right: 10px;
        }

        .input-field input,
        .input-field select {
            flex: 1;
            background: none;
            border: none;
            outline: none;
            width: 100%;
            font-size: 16px;
            font-weight: 500;
            color: var(--text-color);
        }

        .input-field select {
            appearance: none;
            cursor: pointer;
            padding-right: 25px;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23333"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat right 10px center;
            background-size: 15px;
        }

        .btn-custom {
            width: 150px;
            height: 50px;
            border: none;
            border-radius: 50px;
            background: var(--primary-color);
            color: var(--secondary-color);
            font-weight: 600;
            margin: 10px 0;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.3s ease;
            position: relative;
        }

        .btn-custom:disabled {
            background: var(--accent-color);
            cursor: not-allowed;
        }

        .btn-custom:hover:not(:disabled) {
            background: var(--accent-color);
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border: 3px solid var(--secondary-color);
            border-top: 3px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        a {
            text-decoration: none;
            color: var(--primary-color);
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
            color: var(--secondary-color);
            transition: transform 1.1s ease-in-out 0.5s;
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
            max-width: 400px;
            transition: transform 1.1s ease-in-out 0.4s;
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
            color: var(--text-color);
            margin-top: 20px;
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.9em;
            margin-top: 5px;
            text-align: center;
            width: 100%;
            white-space: pre-line;
        }

        /* Animation */
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

        /* Responsive */
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
                display: block;
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
    <div class="container-custom" role="main">
        <div class="signin-signup">
            <form action="{{ route('login') }}" method="POST" class="sign-in-form" id="signInForm" aria-labelledby="signInTitle">
                @csrf
                <h2 class="title" id="signInTitle">Sign in</h2>
                <div id="signInErrorMessage" class="error-message" role="alert"></div>

                <div class="input-field">
                    <i class="fas fa-envelope" aria-hidden="true"></i>
                    <input type="email" name="email" placeholder="Email" required aria-label="Email">
                </div>
                <div class="input-field">
                    <i class="fas fa-lock" aria-hidden="true"></i>
                    <input type="password" name="password" placeholder="Password" required aria-label="Password">
                </div>

                <button type="submit" class="btn-custom" aria-label="Sign in">Login</button>
                <p class="account-text">Don't have an account? <a href="#" id="sign-up-btn2" aria-label="Switch to sign up form">Sign up</a></p>
            </form>

            <form action="" method="POST" class="sign-up-form" id="signUpForm" aria-labelledby="signUpTitle">
                @csrf
                <h2 class="title" id="signUpTitle">Sign up</h2>
                <div id="signUpErrorMessage" class="error-message" role="alert"></div>

                <div class="input-field">
                    <i class="fas fa-user" aria-hidden="true"></i>
                    <input type="text" name="generic_name" placeholder="Nama Lengkap" required data-generic-name="name" aria-label="Full Name">
                </div>
                <div class="input-field">
                    <i class="fas fa-envelope" aria-hidden="true"></i>
                    <input type="email" name="generic_email" placeholder="Email" required data-generic-name="email" aria-label="Email">
                </div>
                <div class="input-field">
                    <i class="fas fa-user-tag" aria-hidden="true"></i>
                    <select name="role" id="role-select" required aria-label="Select Role">
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="pembeli">Pembeli</option>
                        <option value="organisasi">Organisasi</option>
                    </select>
                </div>
                <div class="input-field">
                    <i class="fas fa-phone" aria-hidden="true"></i>
                    <input type="text" name="generic_phone" placeholder="Nomor Telepon" required data-generic-name="phone" aria-label="Phone Number">
                </div>
                <div class="input-field">
                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                    <input type="text" name="generic_address" placeholder="Alamat" required data-generic-name="address" aria-label="Address">
                </div>
                <div class="input-field">
                    <i class="fas fa-lock" aria-hidden="true"></i>
                    <input type="password" name="generic_password" placeholder="Password" required data-generic-name="password" aria-label="Password">
                </div>
                <div class="input-field">
                    <i class="fas fa-lock" aria-hidden="true"></i>
                    <input type="password" name="generic_password_confirmation" placeholder="Confirm Password" required data-generic-name="password_confirmation" aria-label="Confirm Password">
                </div>
                <input type="hidden" name="generic_poin" value="0" data-generic-name="poin">
                <input type="hidden" name="generic_saldo" value="0" data-generic-name="saldo">

                <button type="submit" class="btn-custom" aria-label="Sign up">Sign Up</button>
                <p class="account-text">Already have an account? <a href="#" id="sign-in-btn2" aria-label="Switch to sign in form">Sign in</a></p>
            </form>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Sudah punya akun?</h3>
                    <p>Masuk untuk melanjutkan pengalaman berbelanja Anda!</p>
                    <button class="btn-custom" id="sign-in-btn" aria-label="Switch to sign in form">Sign in</button>
                </div>
                <img src="signin.svg" alt="Sign In Illustration" class="image" aria-hidden="true">
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Belum punya akun?</h3>
                    <p>Daftar sekarang dan temukan barang-barang unik di ReUse Mart!</p>
                    <button class="btn-custom" id="sign-up-btn" aria-label="Switch to sign up form">Sign up</button>
                </div>
                <img src="signup.svg" alt="Sign Up Illustration" class="image" aria-hidden="true">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlcoJoZ/z4nGSsNqF0/mHp/rS/sQ4pQ1Q1h/oI6" crossorigin="anonymous"></script>

    <script>
        // Utility function for debouncing
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Cached DOM elements
        const elements = {
            signInBtn: document.querySelector("#sign-in-btn"),
            signUpBtn: document.querySelector("#sign-up-btn"),
            container: document.querySelector(".container-custom"),
            signInBtn2: document.querySelector("#sign-in-btn2"),
            signUpBtn2: document.querySelector("#sign-up-btn2"),
            signInForm: document.getElementById('signInForm'),
            signUpForm: document.getElementById('signUpForm'),
            signInErrorMessage: document.getElementById('signInErrorMessage'),
            signUpErrorMessage: document.getElementById('signUpErrorMessage'),
            roleSelect: document.querySelector("#role-select"),
            signUpInputFields: document.querySelectorAll('.sign-up-form .input-field')
        };

        // Update sign-up form based on selected role
        function updateSignUpForm() {
            const selectedRole = elements.roleSelect.value;
            let registrationRoute = '';
            let nameMapping = {};
            let requiredFields = [];

            switch (selectedRole) {
                case 'pembeli':
                    registrationRoute = '{{ route("pembeli.store") }}';
                    nameMapping = {
                        name: 'NAMA_PEMBELI',
                        email: 'EMAIL_PEMBELI',
                        password: 'PASSWORD_PEMBELI',
                        password_confirmation: 'PASSWORD_PEMBELI_CONFIRMATION',
                        phone: 'NO_PEMBELI',
                        address: 'ALAMAT_PEMBELI',
                        poin: 'POIN_PEMBELI'
                    };
                    requiredFields = ['name', 'email', 'password', 'password_confirmation', 'phone', 'address', 'poin'];
                    break;
                case 'organisasi':
                    registrationRoute = '{{ route("organisasi.store") }}';
                    nameMapping = {
                        name: 'NAMA_ORGANISASI',
                        email: 'EMAIL_ORGANISASI',
                        password: 'PASSWORD_ORGANISASI',
                        password_confirmation: 'PASSWORD_ORGANISASI_CONFIRMATION',
                        phone: 'NOTELP_ORGANISASI',
                        address: 'ALAMAT_ORGANISASI',
                        saldo: 'SALDO_ORGANISASI'
                    };
                    requiredFields = ['name', 'email', 'password', 'password_confirmation', 'phone', 'address', 'saldo'];
                    break;
                default:
                    registrationRoute = '';
                    nameMapping = {};
                    requiredFields = [];
            }

            elements.signUpForm.action = registrationRoute;

            elements.signUpInputFields.forEach(field => {
                const input = field.querySelector('input, select');
                if (!input) return;

                const genericName = input.getAttribute('data-generic-name') || (input.name === 'role' ? 'role' : null);

                if (genericName === 'role') {
                    field.style.display = '';
                    return;
                }

                if (genericName && nameMapping[genericName]) {
                    input.name = nameMapping[genericName];
                    field.style.display = '';
                    input.required = requiredFields.includes(genericName);
                    if (input.type === 'hidden') {
                        input.value = genericName === 'poin' || genericName === 'saldo' ? '0' : input.value;
                    }
                } else {
                    field.style.display = 'none';
                    input.required = false;
                    input.name = genericName ? `generic_${genericName}` : input.name;
                }
            });
        }

        // Debounced update for role selection
        const debouncedUpdateSignUpForm = debounce(updateSignUpForm, 300);
        elements.roleSelect.addEventListener("change", debouncedUpdateSignUpForm);
        updateSignUpForm(); // Initial call

        // Form mode toggle functions
        function switchToSignUp() {
            elements.container.classList.add("sign-up-mode");
            elements.signUpForm.reset();
            elements.signUpErrorMessage.textContent = '';
            updateSignUpForm();
        }

        function switchToSignIn() {
            elements.container.classList.remove("sign-up-mode");
            elements.container.classList.remove("sign-up-mode2");
            elements.signInForm.reset();
            elements.signInErrorMessage.textContent = '';
        }

        function switchToSignUpMobile() {
            elements.container.classList.add("sign-up-mode2");
            elements.signUpForm.reset();
            elements.signUpErrorMessage.textContent = '';
            updateSignUpForm();
        }

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
                        window.location.href = '/csDashboard';
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

            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            const finalData = {};
            for (const key in data) {
                if (!key.startsWith('generic_') && key !== 'role') {
                    finalData[key] = data[key];
                }
            }

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify(finalData)
                });

                const result = await response.json();

                if (response.ok && result.success !== false) {
                    successCallback(result);
                } else {
                    let errorMessage = result.message || 'Operation failed. Please try again.';
                    if (result.errors) {
                        errorMessage = Object.values(result.errors).flat().join('\n');
                    }
                    errorElement.textContent = errorMessage;
                    console.error('Server response:', result);
                }
            } catch (error) {
                errorElement.textContent = 'An error occurred. Please check your connection or try again later.';
                console.error('Fetch error:', error.message, error.stack);
            } finally {
                button.disabled = false;
                button.classList.remove('btn-loading');
            }
        }
        // Sign-in form submission
        elements.signInForm.addEventListener("submit", async (event) => {
            event.preventDefault();
            const button = elements.signInForm.querySelector('.btn-custom');
            submitForm(elements.signInForm, elements.signInErrorMessage, button, (result) => {
                localStorage.setItem('api_token', result.data.token);
                localStorage.setItem('user_info', JSON.stringify(result.data.user));
                localStorage.setItem('user_role', result.data.role);

                const redirects = {
                    admin: '/adminPagePegawai',
                    pembeli: '/home',
                    penitip: '/penitipDashboard',
                    organisasi: '/organisasiDashboard',
                    owner: '/adminPageOwner',
                    gudang: '/adminPageGudang',
                    'customer service': '/csDashboard',
                    hunter: '/hunterDashboard',
                    kurir: '/kurirDashboard'
                };
                window.location.href = redirects[result.data.role] || '/dashboard';
            });
        });

        // Sign-up form submission
        elements.signUpForm.addEventListener("submit", async (event) => {
            event.preventDefault();
            if (!elements.signUpForm.action) {
                elements.signUpErrorMessage.textContent = 'Please select a role to register.';
                return;
            }
            const button = elements.signUpForm.querySelector('.btn-custom');
            submitForm(elements.signUpForm, elements.signUpErrorMessage, button, (result) => {
                alert('Registration successful! Please sign in.');
                switchToSignIn();
            });
        });
    </script>
</body>
</html>
