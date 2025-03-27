function openModal(type, id = null) {
    const modal = document.getElementById(`${type}Modal`);
    const form = document.getElementById(`${type}Form`);
    const modalTitle = document.getElementById('modalTitle');
    const submitButton = document.getElementById(`submit${type.charAt(0).toUpperCase() + type.slice(1)}Button`);

    if (id) {
        // Edit mode: Fetch data and populate the form
        fetch(`fetch_${type}.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                for (const key in data) {
                    if (form.elements[key]) {
                        form.elements[key].value = data[key];
                    }
                }
                modalTitle.textContent = `Edit ${type.charAt(0).toUpperCase() + type.slice(1)}`;
                submitButton.textContent = `Save Changes`;
                submitButton.name = `edit_${type}`;
            });
    } else {
        // Add mode: Reset the form
        form.reset();
        modalTitle.textContent = `Add ${type.charAt(0).toUpperCase() + type.slice(1)}`;
        submitButton.textContent = `Add ${type.charAt(0).toUpperCase() + type.slice(1)}`;
        submitButton.name = `add_${type}`;
    }

    modal.style.display = 'flex';
}

function closeModal() {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => modal.style.display = 'none');
}

// Event listeners for closing modals
document.querySelectorAll('.modal .close').forEach(close => {
    close.addEventListener('click', closeModal);
});

window.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal')) {
        closeModal();
    }
});