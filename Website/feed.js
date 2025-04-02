
document.addEventListener('DOMContentLoaded', async () => {
    const memes = document.querySelectorAll('.meme');

    for (const meme of memes) {
        const memeUrl = meme.getAttribute('data-url');

        // Like Button
        const likeBtn = meme.querySelector('.like-btn');
        if (likeBtn) {
            likeBtn.addEventListener('click', async () => {
                const response = await fetch('like_meme.php', {
                    method: 'POST',
                    body: new URLSearchParams({ meme_url: memeUrl })
                });
                const result = await response.json();
                if (result.success) {
                    likeBtn.innerHTML = `❤️ ${result.likes}`;
                }
            });

            try {
                const res = await fetch(`get_likes.php?meme_url=${encodeURIComponent(memeUrl)}`);
                const data = await res.json();
                likeBtn.innerHTML = `❤️ ${data.likes}`;
            } catch {}
        }

        // Save Button
        const saveBtn = meme.querySelector('.save-btn');
        if (saveBtn) {
            saveBtn.addEventListener('click', async () => {
                const saved = saveBtn.classList.contains('saved');
                const endpoint = saved ? 'unsave_meme.php' : 'save_meme.php';
                await fetch(endpoint, {
                    method: 'POST',
                    body: new URLSearchParams({ meme_url: memeUrl })
                });
                saveBtn.classList.toggle('saved');
                saveBtn.innerHTML = saved ? '<i class="fas fa-save"></i> Save' : '<i class="fas fa-check"></i> Saved';
            });

            try {
                const res = await fetch('get_saved_memes.php');
                const savedMemes = await res.json();
                if (savedMemes.includes(memeUrl)) {
                    saveBtn.classList.add('saved');
                    saveBtn.innerHTML = '<i class="fas fa-check"></i> Saved';
                }
            } catch {}
        }

        // Commenting
        const addCommentBtn = meme.querySelector('.add-comment-btn');
        const commentInput = meme.querySelector('.comment-input');
        const commentList = meme.querySelector('.comment-list');

        if (addCommentBtn && commentInput) {
            addCommentBtn.addEventListener('click', async () => {
                const comment = commentInput.value.trim();
                if (!comment) return;

                const response = await fetch('comment_meme.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        meme_url: memeUrl,
                        comment
                    })
                });
                const result = await response.json();
                if (result.success) {
                    loadComments(memeUrl, commentList);
                    commentInput.value = '';
                }
            });

            loadComments(memeUrl, commentList);
        }
    }

    async function loadComments(url, container) {
        try {
            const res = await fetch(`get_comments.php?meme_url=${encodeURIComponent(url)}`);
            const { comments } = await res.json();
            container.innerHTML = '';
            comments.forEach(({ username, comment, created_at }) => {
                const div = document.createElement('div');
                div.classList.add('comment-card');
                div.innerHTML = `
                    <div class="meta"><strong>${username}</strong> · <span class="timestamp">${new Date(created_at).toLocaleString()}</span></div>
                    <div class="text">${comment}</div>
                `;
                container.appendChild(div);
            });
        } catch (err) {
            container.innerHTML = '<div style="color: #aaa;">Failed to load comments</div>';
        }
    }
});
