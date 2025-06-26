<script>
    function initializeDynamicForm() {
        const container = document.getElementById('items-container');
        // Jika sudah diinisialisasi, jangan jalankan lagi
        if (container && container.dataset.initialized) {
            return;
        }

        const KEBUTUHAN_DATA = <?php echo json_encode($kebutuhan_list); ?>;
        const addItemBtn = document.getElementById('add-item-btn');
        const itemsContainer = document.getElementById('items-container');
        const template = document.getElementById('item-template');

        if (!addItemBtn || !itemsContainer || !template) {
            console.error("Elemen form dinamis tidak ditemukan!");
            return;
        }

        // Tandai sudah diinisialisasi
        itemsContainer.dataset.initialized = 'true';
        let itemIndex = 0;

        function updateDropdownOptions() {
            const allDropdowns = itemsContainer.querySelectorAll('.item-select');
            const selectedValues = new Set();
            allDropdowns.forEach(d => {
                if (d.value) selectedValues.add(d.value);
            });
            allDropdowns.forEach(dropdown => {
                const currentSelectedValue = dropdown.value;
                dropdown.querySelectorAll('option').forEach(option => {
                    option.disabled = (option.value && selectedValues.has(option.value) && option.value !== currentSelectedValue);
                });
            });
        }

        function addNewRow() {
            const clone = template.content.cloneNode(true);
            const newRow = clone.querySelector('.item-row');
            newRow.querySelector('.item-select').name = `items[${itemIndex}][name]`;
            newRow.querySelector('.item-quantity').name = `items[${itemIndex}][quantity]`;
            itemsContainer.appendChild(newRow);
            itemIndex++;
            updateDropdownOptions();
        }

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
                    const dropdownHtml = `<div class="row"><div class="col-md-4 offset-md-6"><label class="form-label">Pilih Tipe</label><select class="form-select item-type-select" name="items[${rowIndex}][type]">${optionsHtml}</select></div></div>`;
                    extraOptionsDiv.style.display = 'block';
                    extraOptionsDiv.innerHTML = dropdownHtml;
                }
                updateDropdownOptions();
            }
        }

        function handleContainerClick(e) {
            if (e.target.classList.contains('remove-item-btn')) {
                e.target.closest('.item-row').remove();
                updateDropdownOptions();
            }
        }

        // Hapus listener lama sebelum menambah yang baru, untuk mencegah duplikasi
        itemsContainer.removeEventListener('change', handleContainerChange);
        itemsContainer.removeEventListener('click', handleContainerClick);
        addItemBtn.removeEventListener('click', addNewRow);

        itemsContainer.addEventListener('change', handleContainerChange);
        itemsContainer.addEventListener('click', handleContainerClick);
        addItemBtn.addEventListener('click', addNewRow);

        // Reset kontainer dan tambahkan baris awal
        itemsContainer.innerHTML = '';
        addNewRow();
        console.log("Form dinamis berhasil diinisialisasi.");
    }

    // Panggil fungsi inisialisasi pada berbagai event untuk memastikan kompatibilitas
    document.addEventListener('DOMContentLoaded', initializeDynamicForm);
    document.addEventListener('turbolinks:load', initializeDynamicForm); // Kompatibilitas Turbolinks
</script>