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
                if (targetPanel) targetPanel.classList.add('active-panel');
            });
        });
    }

    // 2. Jobsheet 9: konfirmasi hapus pada event submit form.
    initHapusConfirm();
});

function initHapusConfirm() {
    const formsHapus = document.querySelectorAll('.form-hapus');

    formsHapus.forEach(form => {
        form.addEventListener('submit', function (event) {
            const confirmDelete = confirm('Apakah Anda yakin ingin menghapus data ini?');

            if (!confirmDelete) {
                event.preventDefault();
            }
        });
    });
}
