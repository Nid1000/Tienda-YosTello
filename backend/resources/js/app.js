import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const normalizeText = (value) =>
        String(value || '')
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .trim()
            .toUpperCase();

    const formatUbigeoLabel = (value) =>
        String(value || '')
            .toLowerCase()
            .split(' ')
            .filter(Boolean)
            .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');

    const buildSelectOptions = (select, items, placeholder, selectedValue) => {
        if (!select) return;

        const selectedKey = normalizeText(selectedValue);
        select.innerHTML = '';

        const placeholderOption = document.createElement('option');
        placeholderOption.value = '';
        placeholderOption.textContent = placeholder;
        select.appendChild(placeholderOption);

        items.forEach((item) => {
            const option = document.createElement('option');
            option.value = formatUbigeoLabel(item.name);
            option.textContent = formatUbigeoLabel(item.name);
            option.dataset.code = item.code;

            if (normalizeText(option.value) === selectedKey) {
                option.selected = true;
            }

            select.appendChild(option);
        });

        const hasSelection = Array.from(select.options).some((option) => option.selected && option.value !== '');
        select.value = hasSelection ? select.value : '';
    };

    document.querySelectorAll('[data-auto-submit-filters] select').forEach((select) => {
        select.addEventListener('change', () => {
            select.form?.submit();
        });
    });

    document.querySelectorAll('.cart-qty-form').forEach((form) => {
        const input = form.querySelector('input[name="quantity"]');
        if (!input) return;

        form.querySelectorAll('[data-qty-action]').forEach((button) => {
            button.addEventListener('click', () => {
                const current = Number(input.value || 1);
                const next = button.dataset.qtyAction === 'increase' ? current + 1 : current - 1;
                input.value = String(Math.max(1, Math.min(10, next)));
            });
        });
    });

    const dniForm = document.querySelector('[data-dni-form]');
    const ubigeoScript = document.querySelector('[data-peru-ubigeo]');

    if (dniForm && ubigeoScript) {
        const departmentSelect = dniForm.querySelector('[data-department-select]');
        const provinceSelect = dniForm.querySelector('[data-province-select]');
        const districtSelect = dniForm.querySelector('[data-district-select]');

        if (departmentSelect && provinceSelect && districtSelect) {
            const ubigeoData = JSON.parse(ubigeoScript.textContent || '[]');
            const oldDepartment = dniForm.dataset.oldDepartment || '';
            const oldProvince = dniForm.dataset.oldProvince || '';
            const oldDistrict = dniForm.dataset.oldDistrict || '';

            const syncDistricts = (districts, selectedDistrict = '') => {
                buildSelectOptions(districtSelect, districts, 'Selecciona un distrito', selectedDistrict);
                districtSelect.disabled = districts.length === 0;
            };

            const syncProvinces = (departmentName, selectedProvince = '', selectedDistrict = '') => {
                const department = ubigeoData.find(
                    (item) => normalizeText(item.name) === normalizeText(departmentName)
                );
                const provinces = department?.provinces || [];

                buildSelectOptions(provinceSelect, provinces, 'Selecciona una provincia', selectedProvince);
                provinceSelect.disabled = provinces.length === 0;

                const province = provinces.find(
                    (item) => normalizeText(item.name) === normalizeText(provinceSelect.value)
                );

                syncDistricts(province?.districts || [], selectedDistrict);
            };

            buildSelectOptions(departmentSelect, ubigeoData, 'Selecciona un departamento', oldDepartment);
            departmentSelect.disabled = ubigeoData.length === 0;
            syncProvinces(departmentSelect.value || oldDepartment, oldProvince, oldDistrict);

            departmentSelect.addEventListener('change', () => {
                syncProvinces(departmentSelect.value);
            });

            provinceSelect.addEventListener('change', () => {
                const department = ubigeoData.find(
                    (item) => normalizeText(item.name) === normalizeText(departmentSelect.value)
                );
                const province = (department?.provinces || []).find(
                    (item) => normalizeText(item.name) === normalizeText(provinceSelect.value)
                );

                syncDistricts(province?.districts || []);
            });
        }
    }

    if (!dniForm) return;

    const trigger = dniForm.querySelector('[data-dni-trigger]');
    const documentType = dniForm.querySelector('[data-document-type]');
    const dniInput = dniForm.querySelector('[data-dni-input]');
    const firstNameInput = dniForm.querySelector('[data-first-name]');
    const lastNameInput = dniForm.querySelector('[data-last-name]');
    const fullNameInput = dniForm.querySelector('[data-full-name]');
    const customerPhoneInput = dniForm.querySelector('[data-customer-phone]');
    const shippingAddressInput = dniForm.querySelector('[data-shipping-address]');
    const feedback = dniForm.querySelector('[data-dni-feedback]');
    const dniLookupEnabled = dniForm.dataset.dniEnabled === 'true';
    const disabledMessage = dniForm.dataset.dniDisabledMessage || 'La busqueda por DNI no esta disponible.';
    const departmentSelect = dniForm.querySelector('[data-department-select]');
    const provinceSelect = dniForm.querySelector('[data-province-select]');
    const districtSelect = dniForm.querySelector('[data-district-select]');

    const syncDocumentUi = () => {
        if (!documentType || !dniInput || !feedback) return;

        const selectedType = documentType.value;

        if (selectedType === 'RUC') {
            dniInput.maxLength = 11;
            dniInput.pattern = '[0-9]{11}';
            dniInput.placeholder = 'Ingresa 11 digitos';
            feedback.textContent = dniLookupEnabled
                ? 'Ingresa un RUC peruano de 11 digitos para autocompletar razon social y direccion fiscal.'
                : disabledMessage;
            return;
        }

        if (selectedType === 'DNI') {
            dniInput.maxLength = 8;
            dniInput.pattern = '[0-9]{8}';
            dniInput.placeholder = 'Ingresa 8 digitos';
            feedback.textContent = dniLookupEnabled
                ? 'Ingresa un DNI peruano de 8 digitos para autocompletar nombres.'
                : disabledMessage;
            return;
        }

        dniInput.maxLength = 20;
        dniInput.pattern = '[A-Za-z0-9-]{1,20}';
        dniInput.placeholder = 'Ingresa tu documento';
        feedback.textContent = 'La busqueda automatica aplica para DNI o RUC peruano.';
    };

    const setSelectValue = (select, value) => {
        if (!select || !value) return;

        const normalizedValue = normalizeText(value);
        const match = Array.from(select.options).find(
            (option) => normalizeText(option.value) === normalizedValue
        );

        if (match) {
            select.value = match.value;
            select.dispatchEvent(new Event('change'));
        }
    };

    if (!dniLookupEnabled && feedback) {
        feedback.textContent = disabledMessage;
    }

    syncDocumentUi();
    documentType?.addEventListener('change', syncDocumentUi);

    trigger?.addEventListener('click', async () => {
        if (!dniInput || !feedback || !documentType) return;

        if (!dniLookupEnabled) {
            feedback.textContent = disabledMessage;
            return;
        }

        if (!['DNI', 'RUC'].includes(documentType.value)) {
            feedback.textContent = 'La busqueda automatica aplica para DNI o RUC peruano.';
            return;
        }

        feedback.textContent = `Consultando ${documentType.value}...`;

        try {
            const isRuc = documentType.value === 'RUC';
            const requestUrl = isRuc ? dniForm.dataset.rucUrl : dniForm.dataset.dniUrl;
            const payload = isRuc ? { ruc: dniInput.value } : { dni: dniInput.value };
            const response = await window.axios.post(requestUrl, payload);

            const data = response.data;
            if (firstNameInput) firstNameInput.value = data.first_name || '';
            if (lastNameInput) lastNameInput.value = data.last_name || '';
            if (fullNameInput) {
                fullNameInput.value = data.full_name || `${data.first_name || ''} ${data.last_name || ''}`.trim();
            }

            if (shippingAddressInput && data.shipping_address) {
                shippingAddressInput.value = data.shipping_address;
            }

            if (departmentSelect && data.department) {
                setSelectValue(departmentSelect, data.department);
            }

            if (provinceSelect && data.province) {
                setTimeout(() => setSelectValue(provinceSelect, data.province), 0);
            }

            if (districtSelect && data.district) {
                setTimeout(() => setSelectValue(districtSelect, data.district), 0);
            }

            if (isRuc && customerPhoneInput && !customerPhoneInput.value) {
                customerPhoneInput.focus();
            }

            const providerLabel = data.provider ? ` desde ${String(data.provider).toUpperCase()}` : '';
            feedback.textContent = `Datos encontrados y autocompletados${providerLabel}.`;
        } catch (error) {
            feedback.textContent = error.response?.data?.message || `No se pudo consultar el ${documentType.value}.`;
        }
    });
});
