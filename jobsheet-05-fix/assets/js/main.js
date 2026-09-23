document.addEventListener('DOMContentLoaded', function () {
    // 1. Interaktivitas Tab Header (Info Panel)
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

    // 2. Kustomisasi/Konfirmasi Aksi Tombol Edit & Hapus pada Tabel
    const btnAksi = document.querySelectorAll('.btn-aksi');
    btnAksi.forEach(button => {
        button.addEventListener('click', function (e) {
            const actionText = this.textContent.trim();
            if (actionText === 'Hapus') {
                const confirmDelete = confirm('Apakah Anda yakin ingin menghapus data ini?');
                if (!confirmDelete) {
                    e.preventDefault();
                }
            } else if (actionText === 'Edit') {
                console.log('Modul edit dipicu untuk baris ini.');
            }
        });
    });
});