document.addEventListener('DOMContentLoaded', async () => {
    const savedMemesContainer = document.getElementById('savedMemesContainer');

    try {
        // Fetch saved memes
        const res = await fetch('get_saved_memes.php');
        if (!res.ok) throw new Error('Failed to fetch saved memes');
        const savedMemes = await res.json();

        // Handle empty saved memes
        if (!Array.isArray(savedMemes) || savedMemes.length === 0) {
            savedMemesContainer.innerHTML = '<p>No saved memes found.</p>';
            return;
        }

        // Render each saved meme
        for (const url of savedMemes) {
            const memeElement = document.createElement('div');
            memeElement.classList.add('meme');
            memeElement.innerHTML = `
                <img src="${url}" alt="Saved Meme">
                <div class="buttons">
                    <button class="unsave-button" data-url="${url}">Unsave</button>
                    <span class="like-count">❤️ 0</span>
                </div>
                <div class="comments-container">
                    <div class="comment-list"></div>
                </div>
            `;
            savedMemesContainer.appendChild(memeElement);

            // Add unsave functionality
            const unsaveBtn = memeElement.querySelector('.unsave-button');
            unsaveBtn.addEventListener('click', async () => {
                try {
                    const res = await fetch('unsave_meme.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: new URLSearchParams({ meme_url: url }),
                    });
                    if (!res.ok) throw new Error('Failed to unsave meme');
                    memeElement.remove();
                } catch (err) {
                    console.error('Error unsaving meme:', err);
                    alert('Failed to unsave meme. Please try again.');
                }
            });

            // Fetch and display likes
            const likeSpan = memeElement.querySelector('.like-count');
            try {
                const res = await fetch('get_likes.php?meme_url=' + encodeURIComponent(url));
                if (!res.ok) throw new Error('Failed to fetch likes');
                const data = await res.json();
                likeSpan.textContent = `❤️ ${data.likes}`;
            } catch (err) {
                console.error('Error fetching likes:', err);
                likeSpan.textContent = '❤️ 0';
            }

            // Fetch and display comments
            const commentList = memeElement.querySelector('.comment-list');
            try {
                const res = await fetch('get_comments.php?meme_url=' + encodeURIComponent(url));
                if (!res.ok) throw new Error('Failed to fetch comments');
                const { comments } = await res.json();
                commentList.innerHTML = '';
                comments.forEach(({ username, comment, created_at }) => {
                    const card = document.createElement('div');
                    card.classList.add('comment-card');
                    card.innerHTML = `
                        <div class="meta">
                            <strong>${username}</strong> · <span class="timestamp">${new Date(created_at).toLocaleString()}</span>
                        </div>
                        <div class="text">${comment}</div>
                    `;
                    commentList.appendChild(card);
                });
            } catch (err) {
                console.error('Error fetching comments:', err);
                commentList.innerHTML = '<div style="color: #aaa;">Failed to load comments</div>';
            }
        }
    } catch (err) {
        console.error('Error loading saved memes:', err);
        savedMemesContainer.innerHTML = '<p style="color: red;">Failed to load saved memes. Please try again later.</p>';
    }
});
