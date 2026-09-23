document.addEventListener('DOMContentLoaded', function () {
    // 1. Interaktivitas Tab Header
    const tabButtons = document.querySelectorAll('.tab-btn');
    const infoPanels = document.querySelectorAll('.info-panel');

    if (tabButtons.length > 0 && infoPanels.length > 0) {
        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetPanelId = this.getAttribute('data-target');

                tabButtons.forEach(btn => btn.classList.remove('active'));
                infoPanels.forEach(panel => panel.classList.remove('active-panel'));

                this.classList.add('active');
                const targetPanel = document.getElementById(targetPanelId);
                if (targetPanel) {
                    targetPanel.classList.add('active-panel');
                }
            });
        });
    }

    // 2. Cek elemen tabel di halaman yang sedang aktif
    if (document.getElementById("kamera-table-body")) {
        loadKameraData();
    }
    
    if (document.getElementById("pelanggan-table-body")) {
        loadPelangganData();
    }
});

// Fetch Data Kamera
function loadKameraData() {
    fetch('../data/kamera.json')
        .then(response => {
            if (!response.ok) throw new Error("Gagal mengambil data kamera.json");
            return response.json();
        })
        .then(data => {
            const tableBody = document.getElementById("kamera-table-body");
            const counter = document.getElementById("kamera-counter");
            
            tableBody.innerHTML = "";

            data.forEach(item => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${item.nama_alat}</td>
                    <td>${item.merek}</td>
                    <td>${item.tahun_beli}</td>
                    <td>${item.stok}</td>
                    <td>
                        <button class="btn-aksi btn-edit">Edit</button>
                        <button class="btn-aksi btn-hapus">Hapus</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });

            if (counter) {
                counter.innerText = `Total Jenis Alat: ${data.length}`;
            }

            attachButtonEvents();
        })
        .catch(error => {
            console.error("Error Detail:", error);
            document.getElementById("kamera-table-body").innerHTML = 
                `<tr><td colspan="5" style="text-align:center; color:red;">Gagal memuat data kamera! Buka via Live Server.</td></tr>`;
        });
}

// Fetch Data Pelanggan
function loadPelangganData() {
    fetch('../data/pelanggan.json')
        .then(response => {
            if (!response.ok) throw new Error("Gagal mengambil data pelanggan.json");
            return response.json();
        })
        .then(data => {
            const tableBody = document.getElementById("pelanggan-table-body");
            const counter = document.getElementById("pelanggan-counter");
            
            tableBody.innerHTML = "";

            data.forEach(item => {
                const row = document.createElement("tr");

                // Badge Kapsul versi Mungil & Tipis (Sama Persis Gambar 1)
                const isVerified = item.status === "Terverifikasi";
                const bgBadge = isVerified ? "#efe5e5" : "#fce4e4";
                const colorBadge = isVerified ? "#4a121a" : "#5c1d24";

                const statusBadge = `
                    <span style="
                        background-color: ${bgBadge}; 
                        color: ${colorBadge}; 
                        border-radius: 12px; 
                        padding: 5px 10px; 
                        font-size: 0.75rem;
                        display: inline-block;
                        line-height: 1.2;
                    ">${item.status}</span>
                `;

                row.innerHTML = `
                    <td>${item.id_reg}</td>
                    <td>${item.nama_lengkap}</td>
                    <td>${item.no_ktp}</td>
                    <td>${item.no_hp}</td>
                    <td>${statusBadge}</td>
                    <td>
                        <button class="btn-aksi btn-edit">Edit</button>
                        <button class="btn-aksi btn-hapus">Hapus</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });

            if (counter) {
                counter.innerText = `Menampilkan ${data.length} dari 156 Total Pelanggan`;
            }

            attachButtonEvents();
        })
        .catch(error => {
            console.error("Error Detail:", error);
            document.getElementById("pelanggan-table-body").innerHTML = 
                `<tr><td colspan="6" style="text-align:center; color:red;">Gagal memuat data pelanggan! Buka via Live Server.</td></tr>`;
        });
}
// Event Listener Tombol Aksi
function attachButtonEvents() {
    const btnAksi = document.querySelectorAll('.btn-aksi');
    btnAksi.forEach(button => {
        button.addEventListener('click', function (e) {
            const actionText = this.textContent.trim();
            if (actionText === 'Hapus') {
                const confirmDelete = confirm('Apakah Anda yakin ingin menghapus data ini?');
                if (confirmDelete) {
                    this.closest('tr').remove();
                }
            } else if (actionText === 'Edit') {
                console.log('Modul edit dipicu.');
            }
        });
    });
}