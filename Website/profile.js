
document.addEventListener('DOMContentLoaded', () => {
    const memeContainer = document.getElementById('meme-container');
    const newMemeForm = document.getElementById('new-meme-form');
    const usernameInput = document.getElementById('username');
    const displayUsername = document.getElementById('display-username');
    const saveButton = document.querySelector('.save-btn');
    const deleteAccountButton = document.getElementById('delete-account');
    const passwordInput = document.getElementById('password');

    function showAlert(message, type = 'success', duration = 3000) {
        const alertBox = document.createElement('div');
        alertBox.className = `custom-alert ${type}`;
        alertBox.textContent = message;
        document.body.appendChild(alertBox);
        setTimeout(() => alertBox.classList.add('show'), 10);
        setTimeout(() => {
            alertBox.classList.remove('show');
            setTimeout(() => alertBox.remove(), 300);
        }, duration);
    }

    async function loadProfile() {
        const res = await fetch('get_memes.php');
        const memes = await res.json();
        memeContainer.innerHTML = '';
        memes.forEach((meme) => {
            const div = document.createElement('div');
            div.className = 'meme-item';
            div.innerHTML = `<img src="\${meme.url}" alt="\${meme.title}">
                             <p>\${meme.title}</p>`;
            memeContainer.appendChild(div);
        });
    }

    if (newMemeForm) {
        newMemeForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const title = document.getElementById('meme-title').value;
            const url = document.getElementById('meme-url').value;
            const res = await fetch('add_meme.php', {
                method: 'POST',
                body: new URLSearchParams({ title, url })
            });
            const data = await res.json();
            if (data.success) {
                showAlert('✅ Meme uploaded successfully!', 'success');
                loadProfile();
                newMemeForm.reset();
            } else {
                showAlert('❌ Failed to upload meme.', 'error');
            }
        });
    }

    if (saveButton) {
        saveButton.addEventListener('click', async (e) => {
            e.preventDefault();
            const username = usernameInput.value;
            const password = passwordInput.value;
            const res = await fetch('save_profile.php', {
                method: 'POST',
                body: new URLSearchParams({ username, password })
            });
            const data = await res.json();
            if (data.success) {
                displayUsername.textContent = username;
                showAlert('✅ Profile updated!', 'success');
            } else {
                showAlert('❌ Failed to update profile.', 'error');
            }
        });
    }

    if (deleteAccountButton) {
        deleteAccountButton.addEventListener('click', async () => {
            if (confirm('Are you sure you want to delete your account?')) {
                const res = await fetch('delete_account.php', { method: 'POST' });
                const data = await res.json();
                if (data.success) {
                    showAlert('✅ Account deleted.', 'success');
                    setTimeout(() => {
                        window.location.href = 'loginpage.php';
                    }, 1500);
                } else {
                    showAlert('❌ Failed to delete account.', 'error');
                }
            }
        });
    }

    if (memeContainer) {
        loadProfile();
    }
});