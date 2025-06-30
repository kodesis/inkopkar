<script>
    // Fungsi utama ini akan dipanggil pada saat halaman dimuat
    function initializeDynamicForm() {
        const container = document.getElementById('items-container');
        // Mencegah skrip berjalan dua kali jika navigasi menggunakan AJAX (seperti Turbolinks)
        if (container && container.dataset.initialized) {
            return;
        }

        // Ambil semua elemen penting dari halaman
        const KEBUTUHAN_DATA = <?php echo json_encode($kebutuhan_list); ?>;
        const addItemBtn = document.getElementById('add-item-btn');
        const itemsContainer = document.getElementById('items-container');
        const template = document.getElementById('item-template');

        // Periksa jika elemen ada untuk mencegah error
        if (!addItemBtn || !itemsContainer || !template) {
            console.error("Satu atau lebih elemen form (tombol/kontainer/template) tidak ditemukan!");
            return;
        }

        // Tandai bahwa form sudah diinisialisasi
        itemsContainer.dataset.initialized = 'true';

        // KUNCI 1: Mulai index dari jumlah item yang sudah ada di halaman (dirender oleh PHP)
        let itemIndex = <?php echo !empty($detail_kebutuhan) ? count($detail_kebutuhan) : 0; ?>;

        // Fungsi untuk mengatur opsi dropdown agar tidak duplikat
        function updateDropdownOptions() {
            const allDropdowns = itemsContainer.querySelectorAll('.item-select');
            const selectedValues = new Set();
            allDropdowns.forEach(d => {
                if (d.value) selectedValues.add(d.value);
            });
            allDropdowns.forEach(dropdown => {
                const currentSelectedValue = dropdown.value;
                dropdown.querySelectorAll('option').forEach(option => {
                    // Jangan nonaktifkan opsi "Pilih Kebutuhan"
                    if (option.value === "") return;
                    option.disabled = (selectedValues.has(option.value) && option.value !== currentSelectedValue);
                });
            });
        }

        // Fungsi untuk menambah baris baru dari template
        function addNewRow() {
            const clone = template.content.cloneNode(true);
            const newRow = clone.querySelector('.item-row');

            // Beri nama unik ke SEMUA input yang relevan di baris baru
            newRow.querySelector('input[type=hidden]').name = `items[${itemIndex}][id]`;
            newRow.querySelector('.item-select').name = `items[${itemIndex}][name]`;
            newRow.querySelector('.item-quantity').name = `items[${itemIndex}][quantity]`;

            itemsContainer.appendChild(newRow);
            itemIndex++;
            updateDropdownOptions();
        }

        // Fungsi untuk menghandle perubahan pada dropdown
        function handleContainerChange(e) {
            if (e.target.classList.contains('item-select')) {
                const selectedValue = e.target.value;
                const row = e.target.closest('.item-row');
                const details = KEBUTUHAN_DATA[selectedValue];

                const quantityInput = row.querySelector('.item-quantity');
                const unitSpan = row.querySelector('.item-unit');
                const extraOptionsDiv = row.querySelector('.item-extra-options');

                quantityInput.value = '';
                quantityInput.disabled = false;
                unitSpan.textContent = details.unit;
                extraOptionsDiv.innerHTML = '';
                extraOptionsDiv.style.display = 'none';

                if (details.has_type && details.types) {
                    const rowIndex = Array.from(itemsContainer.children).indexOf(row);
                    let optionsHtml = '';
                    for (const [value, label] of Object.entries(details.types)) {
                        optionsHtml += `<option value="${value}">${label}</option>`;
                    }
                    const dropdownHtml = `
                    <div class="row">
                        <div class="col-md-8 offset-md-4">
                            <label class="form-label">Pilih Tipe</label>
                            <select class="form-select item-type-select" name="items[${rowIndex}][type]">
                                ${optionsHtml}
                            </select>
                        </div>
                    </div>`;
                    extraOptionsDiv.style.display = 'block';
                    extraOptionsDiv.innerHTML = dropdownHtml;
                }
                updateDropdownOptions();
            }
        }

        // Fungsi untuk menghandle klik pada tombol hapus
        function handleContainerClick(e) {
            if (e.target.classList.contains('remove-item-btn')) {
                e.target.closest('.item-row').remove();
                updateDropdownOptions();
            }
        }

        // Event Listeners
        addItemBtn.addEventListener('click', addNewRow);
        itemsContainer.addEventListener('change', handleContainerChange);
        itemsContainer.addEventListener('click', handleContainerClick);

        // KUNCI 2: Panggil fungsi ini saat halaman dimuat.
        // Ini akan menonaktifkan opsi yang sudah dipakai oleh baris-baris
        // yang dibuat oleh PHP. Kita TIDAK memanggil addNewRow() di sini.
        updateDropdownOptions();

        console.log("Form dinamis berhasil diinisialisasi dengan " + itemIndex + " item awal.");
    }


    // Panggil fungsi inisialisasi pada berbagai event untuk memastikan kompatibilitas
    // dengan template admin modern
    document.addEventListener('DOMContentLoaded', initializeDynamicForm);
    document.addEventListener('turbolinks:load', initializeDynamicForm);
</script>