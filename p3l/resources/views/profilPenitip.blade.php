<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile - ReUse Mart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    /* Tambahkan styling opsional untuk foto placeholder */
    .rounded {
        object-fit: cover; /* Memastikan foto tidak terdistorsi */
    }
  </style>
</head>
<body>
<div class="container my-5">
  <h2 class="mb-4 text-primary">Profil Penitip</h2>
  <div id="successAlert" class="alert alert-success d-none" role="alert">
      </div>
  <div id="errorAlert" class="alert alert-danger d-none" role="alert">
      </div>


  <table class="table table-bordered table-hover">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Foto</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Username</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody id="tableBody">
      <tr>
            <td colspan="6" class="text-center" id="loadingRow">Memuat data...</td>
         </tr>
    </tbody>
  </table>
</div>

<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Update Profil Penitip</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="userForm" enctype="multipart/form-data">
           <input type="hidden" id="PenitipIdUpdate">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="NamaUpdate" class="form-label">Nama</label>
              <input type="text" class="form-control" id="NamaUpdate" name="nama" placeholder="Masukkan nama" required> {{-- Tambah name="nama" --}}
            </div>
            <div class="col-md-6 mb-3">
              <label for="EmailUpdate" class="form-label">Email</label>
              <input type="email" class="form-control" id="EmailUpdate" name="email" placeholder="example@email.com" required> {{-- Tambah name="email" --}}
            </div>
            <div class="col-md-6 mb-3">
              <label for="UsernameUpdate" class="form-label">Username</label>
              <input type="text" class="form-control" id="UsernameUpdate" name="username" placeholder="Masukkan username" required> {{-- Tambah name="username" --}}
            </div>
            <div class="col-md-6 mb-3">
              <label for="PasswordUpdate" class="form-label">Password <span class="text-muted small">(Kosongkan jika tidak diubah)</span></label>
              <input type="password" class="form-control" id="PasswordUpdate" name="password"> {{-- Tambah name="password" --}}
            </div>
            <div class="col-md-6 mb-3">
              <label for="FotoUpdate" class="form-label">Foto</label>
              <input type="file" class="form-control" id="FotoUpdate" name="foto" accept="image/*"> {{-- Tambah name="foto" --}}
                 <div id="currentFotoPreview" class="mt-2"></div>             </div>
            {{-- Tambahkan field lain jika model Penitip punya atribut lain, pastikan ada atribut 'name' --}}
            {{-- Contoh:
            <div class="col-md-6 mb-3">
                <label for="AlamatUpdate" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="AlamatUpdate" name="alamat" placeholder="Masukkan alamat">
            </div>
             <div class="col-md-6 mb-3">
                <label for="SaldoUpdate" class="form-label">Saldo</label>
                <input type="number" class="form-control" id="SaldoUpdate" name="saldo" placeholder="Masukkan saldo">
            </div>
             <div class="col-md-6 mb-3">
                <label for="PoinUpdate" class="form-label">Poin</label>
                <input type="number" class="form-control" id="PoinUpdate" name="poin" placeholder="Masukkan poin">
            </div>
            --}}
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="saveUserButton">Simpan</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus Profil Penitip</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus data profil Anda?
        <input type="hidden" id="PenitipIdDelete">
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-danger" id="confirmDeleteButton">Hapus</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Variabel untuk menyimpan data Penitip yang sedang login
  let authenticatedPenitip = null;
  // Variabel untuk menyimpan ID Penitip saat ini (untuk edit/delete)
  let currentPenitipId = null;

  const tableBody = document.getElementById("tableBody");
  const userModal = new bootstrap.Modal(document.getElementById('userModal'));
  const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
  const userForm = document.getElementById('userForm');
  const successAlert = document.getElementById('successAlert');
  const errorAlert = document.getElementById('errorAlert');
  const saveUserButton = document.getElementById('saveUserButton');
  const confirmDeleteButton = document.getElementById('confirmDeleteButton');

  // Field form update
  const penitipIdUpdateInput = document.getElementById('PenitipIdUpdate');
  const namaUpdateInput = document.getElementById('NamaUpdate');
  const emailUpdateInput = document.getElementById('EmailUpdate');
  const usernameUpdateInput = document.getElementById('UsernameUpdate');
  const passwordUpdateInput = document.getElementById('PasswordUpdate');
  const fotoUpdateInput = document.getElementById('FotoUpdate');
  const currentFotoPreviewDiv = document.getElementById('currentFotoPreview');

  // Tambahkan reference untuk field opsional lainnya di form jika ada
  // const alamatUpdateInput = document.getElementById('AlamatUpdate'); // Contoh
  // const saldoUpdateInput = document.getElementById('SaldoUpdate'); // Contoh
  // const poinUpdateInput = document.getElementById('PoinUpdate'); // Contoh


  // Setelah halaman dimuat, ambil data user dari API
  document.addEventListener("DOMContentLoaded", function () {
    fetchAuthenticatedPenitip();

    // Tambahkan event listener untuk tombol Simpan di modal update
    saveUserButton.addEventListener('click', submitUserForm);

    // Tambahkan event listener untuk tombol Hapus di modal konfirmasi hapus
    confirmDeleteButton.addEventListener('click', confirmDelete);
  });

  // Fungsi untuk mengambil data Penitip yang terautentikasi
  function fetchAuthenticatedPenitip() {
    const token = localStorage.getItem("authToken"); // Ambil token dari localStorage

    if (!token) {
       showErrorAlert("Anda belum login. Silakan login terlebih dahulu.");
       tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">Anda belum login.</td></tr>`;
       return;
    }

    // Sembunyikan alert sebelumnya
    hideAlerts();
    tableBody.innerHTML = `<tr><td colspan="6" class="text-center" id="loadingRow">Memuat data...</td></tr>`;


    fetch("http://localhost:8000/api/user", { // Memanggil endpoint untuk data user terautentikasi
       headers: {
         Authorization: `Bearer ${token}`,
          'Accept': 'application/json' // Memberi tahu server bahwa kita mengharapkan JSON
       }
    })
    .then((res) => {
       if (!res.ok) {
            // Tangani error HTTP (misal 401 Unauthorized, 403 Forbidden)
            if (res.status === 401) {
                // Jika 401, kemungkinan token invalid atau expired, hapus token dan arahkan ke login
                localStorage.removeItem("authToken");
                 // Opsional: Arahkan ke halaman login
                 // window.location.href = '/login-regis';
                throw new Error("Sesi login Anda telah habis atau token tidak valid. Silakan login ulang.");
            }
           if (res.status === 403) {
                 throw new Error("Anda tidak memiliki izin untuk mengakses data ini.");
            }
            throw new Error(`Gagal mengambil data user: ${res.status} ${res.statusText}`);
       }
       return res.json();
    })
    .then((data) => {
        // Asumsi data dari /api/user mengembalikan struktur data user yang relevan
        // termasuk id, nama, email, username, foto, dan mungkin atribut Penitip lainnya
        authenticatedPenitip = data; // Simpan data user yang terautentikasi
        tampilkanUser(authenticatedPenitip); // Tampilkan data di tabel
    })
    .catch((err) => {
       console.error("Gagal ambil user:", err);
       showErrorAlert(err.message || "Terjadi kesalahan saat memuat data profil.");
       tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">${err.message || "Gagal memuat data."}</td></tr>`;
    });
   }


  function tampilkanUser(user) {
    // Kosongkan body tabel sebelumnya
    tableBody.innerHTML = '';

    if (!user) {
        tableBody.innerHTML = `<tr><td colspan="6" class="text-center">Tidak ada data profil.</td></tr>`;
        return;
    }

    // Jika user ditemukan, tampilkan datanya dalam satu baris
    const row = `
       <tr>
         <td>${user.id || '-'}</td> {{-- Gunakan ID dari data user, tambahkan fallback --}}
         <td>
            <img src="${user.foto ? 'http://localhost:8000/storage/' + user.foto : 'https://via.placeholder.com/50x50'}" {{-- Sesuaikan ukuran placeholder --}}
                 width="50" height="50" {{-- Tambah height agar proporsi foto konsisten --}}
                 class="rounded"
                 alt="Foto Profil">
        </td> {{-- Gunakan path foto dari data user --}}
         <td>${user.nama || '-'}</td> {{-- Tambahkan fallback --}}
         <td>${user.email || '-'}</td> {{-- Tambahkan fallback --}}
         <td>${user.username || '-'}</td> {{-- Tambahkan fallback --}}
         <td>
           <button class="btn btn-sm btn-warning" onclick="showUpdateModal(${user.id})">Edit</button>
           <button class="btn btn-sm btn-danger" onclick="showDeleteModal(${user.id})">Hapus</button>
         </td>
       </tr>
     `;
    tableBody.innerHTML = row;
   }

  // Fungsi untuk menampilkan modal update dan mengisi form
  function showUpdateModal(id) {
    // Pastikan kita punya data user yang akan diupdate
    // Karena ini halaman profil, kita hanya mengupdate user yang sedang login
    // ID yang dilewatkan harus sama dengan authenticatedPenitip.id
    if (!authenticatedPenitip || authenticatedPenitip.id !== id) {
        showErrorAlert("Data user untuk update tidak ditemukan atau tidak sesuai.");
        return;
    }

    // Simpan ID yang sedang diupdate (ini adalah ID authenticatedPenitip)
    currentPenitipId = id;
    penitipIdUpdateInput.value = id;

    // Kosongkan form dari data sebelumnya
    userForm.reset(); // Mereset semua field di form
    currentFotoPreviewDiv.innerHTML = ''; // Kosongkan preview foto

    // Isi form dengan data user yang sudah diambil (authenticatedPenitip)
    namaUpdateInput.value = authenticatedPenitip.nama || '';
    emailUpdateInput.value = authenticatedPenitip.email || '';
    usernameUpdateInput.value = authenticatedPenitip.username || '';
    passwordUpdateInput.value = ''; // Kosongkan field password saat membuka modal

    // Isi field opsional lainnya jika ada
    // if (alamatUpdateInput && authenticatedPenitip.alamat) alamatUpdateInput.value = authenticatedPenitip.alamat;
    // if (saldoUpdateInput && authenticatedPenitip.saldo) saldoUpdateInput.value = authenticatedPenitip.saldo;
    // if (poinUpdateInput && authenticatedPenitip.poin) poinUpdateInput.value = authenticatedPenitip.poin;


    // Tampilkan preview foto saat ini jika ada
    if (authenticatedPenitip.foto) {
        const img = document.createElement('img');
        img.src = `http://localhost:8000/storage/${authenticatedPenitip.foto}`;
        img.width = 50;
        img.height = 50;
        img.classList.add('rounded');
        img.alt = 'Current Foto';
        currentFotoPreviewDiv.appendChild(img);
        const text = document.createElement('span');
        text.textContent = ' Foto saat ini';
        currentFotoPreviewDiv.appendChild(text);
    }

    // Sembunyikan alerts
    hideAlerts();

    // Tampilkan modal
    userModal.show();
  }

  // Fungsi untuk menampilkan modal delete
  function showDeleteModal(id) {
    // Pastikan ID sesuai dengan user yang sedang login
     if (!authenticatedPenitip || authenticatedPenitip.id !== id) {
        showErrorAlert("Data user untuk dihapus tidak ditemukan atau tidak sesuai.");
        return;
    }
    // Simpan ID yang akan dihapus
    currentPenitipId = id;
    document.getElementById('PenitipIdDelete').value = id;

    // Sembunyikan alerts
    hideAlerts();

    // Tampilkan modal
    deleteModal.show();
   }

  // Fungsi untuk mengirim data form update ke API
  async function submitUserForm() {
    // Nonaktifkan tombol simpan sementara
    saveUserButton.disabled = true;
    saveUserButton.textContent = 'Menyimpan...';

    hideAlerts(); // Sembunyikan alert sebelum submit

    const token = localStorage.getItem("authToken");
    if (!token) {
        showErrorAlert("Anda belum login.");
        saveUserButton.disabled = false;
        saveUserButton.textContent = 'Simpan';
        return;
    }

    // Ambil ID Penitip yang akan diupdate
    const penitipId = penitipIdUpdateInput.value;
    // Double check ID sesuai user yang login
    if (!penitipId || !authenticatedPenitip || authenticatedPenitip.id !== parseInt(penitipId)) {
         showErrorAlert("ID Penitip untuk update tidak valid.");
        saveUserButton.disabled = false;
        saveUserButton.textContent = 'Simpan';
         return;
    }

    // Buat objek FormData untuk mengirim data form, termasuk file
    const formData = new FormData(userForm);

    // Penting: Laravel/PHP biasanya mengharapkan metode PUT,
    // tetapi FormData tidak mendukung metode PUT dengan file.
    // Gunakan POST dan tambahkan _method=PUT secara manual.
    formData.append('_method', 'PUT');

    // Hapus password dari FormData jika kosong
    if (passwordUpdateInput.value === '') {
        formData.delete('password');
    }

    // Hapus field foto dari FormData jika tidak ada file baru dipilih
    if (fotoUpdateInput.files.length === 0) {
        formData.delete('foto');
    }

    // URL API update
    const apiUrl = `http://localhost:8000/api/penitip/update/authenticated/${penitipId}`;

    try {
        const res = await fetch(apiUrl, {
            method: 'POST', // Gunakan POST karena workaround _method=PUT
            headers: {
                'Authorization': `Bearer ${token}`,
                // Jangan set 'Content-Type': 'multipart/form-data', browser akan set dengan boundary yang benar
                'Accept': 'application/json'
            },
            body: formData // Kirim FormData
        });

        const data = await res.json();

        if (!res.ok) {
            // Tangani error dari API (validasi, dll.)
            let errorMessage = data.message || `Gagal mengupdate data (${res.status}).`;
             if (data.errors) {
                errorMessage += '<br><ul>';
                for (const field in data.errors) {
                     // Gunakan nama field dari request (misal 'nama', 'email', 'foto')
                     const fieldName = field.charAt(0).toUpperCase() + field.slice(1); // Kapitalisasi nama field
                    data.errors[field].forEach(error => {
                        errorMessage += `<li>${fieldName}: ${error}</li>`; // Tampilkan nama field error
                    });
                }
                errorMessage += '</ul>';
            } else if (data.message === 'Anda tidak berhak mengupdate data ini.') {
                 // Tangani error otorisasi spesifik
                 errorMessage = "Anda tidak memiliki izin untuk memperbarui profil ini.";
             }

            throw new Error(errorMessage);
        }

        // Jika sukses
        showSuccessAlert(data.message || "Data berhasil diperbarui!");
        userModal.hide(); // Tutup modal

        // Refresh data yang ditampilkan di tabel dengan data terbaru dari response (jika API mengembalikan data user)
        // Atau panggil fetchAuthenticatedPenitip() lagi
        if(data.data) { // Jika API mengembalikan data user yang diperbarui
             authenticatedPenitip = data.data;
             tampilkanUser(authenticatedPenitip);
        } else {
             fetchAuthenticatedPenitip(); // Jika API hanya mengembalikan pesan sukses
        }


    } catch (err) {
        console.error("Gagal update user:", err);
        showErrorAlert(err.message || "Terjadi kesalahan saat mengirim data update.");
    } finally {
         // Aktifkan kembali tombol simpan
         saveUserButton.disabled = false;
         saveUserButton.textContent = 'Simpan';
     }
  }

  // Fungsi untuk mengkonfirmasi dan mengirim permintaan hapus ke API
  async function confirmDelete() {
    // Nonaktifkan tombol hapus sementara
    confirmDeleteButton.disabled = true;
    confirmDeleteButton.textContent = 'Menghapus...';

    hideAlerts(); // Sembunyikan alert sebelum submit

    const token = localStorage.getItem("authToken");
    if (!token) {
        showErrorAlert("Anda belum login.");
        deleteModal.hide();
        confirmDeleteButton.disabled = false;
        confirmDeleteButton.textContent = 'Hapus';
        return;
    }

    // Ambil ID Penitip yang akan dihapus
    const penitipIdToDelete = document.getElementById('PenitipIdDelete').value;
     // Double check ID sesuai user yang login
    if (!penitipIdToDelete || !authenticatedPenitip || authenticatedPenitip.id !== parseInt(penitipIdToDelete)) {
         showErrorAlert("ID Penitip untuk dihapus tidak valid.");
         deleteModal.hide();
        confirmDeleteButton.disabled = false;
        confirmDeleteButton.textContent = 'Hapus';
         return;
    }

    // URL API delete
    const apiUrl = `http://localhost:8000/api/penitip/delete/authenticated/${penitipIdToDelete}`;

    try {
        const res = await fetch(apiUrl, {
            method: 'DELETE', // Gunakan metode DELETE
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        const data = await res.json();

        if (!res.ok) {
             let errorMessage = data.message || `Gagal menghapus data (${res.status}).`;
             if (data.message === 'Anda tidak berhak menghapus data ini.') {
                 errorMessage = "Anda tidak memiliki izin untuk menghapus profil ini.";
             }
             throw new Error(errorMessage);
        }

        // Jika sukses
        showSuccessAlert(data.message || "Data berhasil dihapus!");
        deleteModal.hide(); // Tutup modal

        // Kosongkan tabel karena user sudah dihapus
        tableBody.innerHTML = `<tr><td colspan="6" class="text-center">Profil berhasil dihapus.</td></tr>`;

        // Reset variabel global
        authenticatedPenitip = null;
        currentPenitipId = null;

        // Opsional: Arahkan pengguna ke halaman login setelah menghapus profilnya
        // setTimeout(() => {
        //     window.location.href = '/login-regis';
        // }, 3000); // Arahkan setelah 3 detik

    } catch (err) {
        console.error("Gagal hapus user:", err);
        showErrorAlert(err.message || "Terjadi kesalahan saat menghapus data.");
    } finally {
         // Aktifkan kembali tombol hapus
         confirmDeleteButton.disabled = false;
         confirmDeleteButton.textContent = 'Hapus';
         deleteModal.hide(); // Pastikan modal tertutup bahkan jika ada error catch
     }
  }

  // Helper functions for alerts
  function showSuccessAlert(message) {
    successAlert.innerHTML = message;
    successAlert.classList.remove('d-none');
    errorAlert.classList.add('d-none'); // Pastikan error alert tersembunyi
     // Opsional: sembunyikan alert setelah beberapa detik
    setTimeout(() => {
        successAlert.classList.add('d-none');
    }, 5000); // Sembunyikan setelah 5 detik
  }

  function showErrorAlert(message) {
    errorAlert.innerHTML = message;
    errorAlert.classList.remove('d-none');
    successAlert.classList.add('d-none'); // Pastikan success alert tersembunyi
     // Opsional: error biasanya lebih baik tetap tampil, atau sembunyikan dengan durasi lebih lama
    // setTimeout(() => {
    //     errorAlert.classList.add('d-none');
    // }, 10000); // Contoh sembunyikan setelah 10 detik
  }

  function hideAlerts() {
    successAlert.classList.add('d-none');
    errorAlert.classList.add('d-none');
  }

</script>
</body>
</html>