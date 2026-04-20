import axios from 'axios';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document
    .querySelector('meta[name="csrf-token"]')
    ?.getAttribute('content');

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-auto-submit-filters] select').forEach((select) => {
        select.addEventListener('change', () => {
            select.form?.submit();
        });
    });

    document.querySelectorAll('.cart-qty-form').forEach((form) => {
        const input = form.querySelector('input[name="quantity"]');

        form.querySelectorAll('[data-qty-action]').forEach((button) => {
            button.addEventListener('click', () => {
                const current = Number(input.value || 1);
                const next = button.dataset.qtyAction === 'increase' ? current + 1 : current - 1;
                input.value = String(Math.max(1, Math.min(10, next)));
            });
        });
    });

    const dniForm = document.querySelector('[data-dni-form]');

    if (!dniForm) {
        return;
    }

    const trigger = dniForm.querySelector('[data-dni-trigger]');
    const documentType = dniForm.querySelector('[data-document-type]');
    const dniInput = dniForm.querySelector('[data-dni-input]');
    const firstNameInput = dniForm.querySelector('[data-first-name]');
    const lastNameInput = dniForm.querySelector('[data-last-name]');
    const fullNameInput = dniForm.querySelector('[data-full-name]');
    const feedback = dniForm.querySelector('[data-dni-feedback]');

    trigger?.addEventListener('click', async () => {
        if (!dniInput || !feedback || !documentType) {
            return;
        }

        if (documentType.value !== 'DNI') {
            feedback.textContent = 'La busqueda automatica aplica para DNI peruano.';
            return;
        }

        feedback.textContent = 'Consultando DNI...';

        try {
            const response = await window.axios.post(dniForm.dataset.dniUrl, {
                dni: dniInput.value,
            });

            const data = response.data;
            firstNameInput.value = data.first_name || '';
            lastNameInput.value = data.last_name || '';
            fullNameInput.value = data.full_name || `${data.first_name || ''} ${data.last_name || ''}`.trim();
            feedback.textContent = 'Datos encontrados y autocompletados.';
        } catch (error) {
            const message = error.response?.data?.message || 'No se pudo consultar el DNI.';
            feedback.textContent = message;
        }
    });
});
