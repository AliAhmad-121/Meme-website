
document.addEventListener('DOMContentLoaded', () => {
    const memeContainer = document.getElementById('memeContainer');
    const loader = document.getElementById('loader');
    let isLoading = false;
    let after = null;
    let savedMemes = [];

    const fetchSavedMemes = async () => {
        try {
            const res = await fetch('get_saved_memes.php');
            savedMemes = await res.json();
        } catch (error) {
            savedMemes = [];
        }
    };

    const isMemeSaved = (url) => savedMemes.includes(url);

    const shuffleArray = (array) => {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    };

    const timeAgo = (timestamp) => {
        const now = new Date();
        const past = new Date(timestamp);
        const diff = Math.floor((now - past) / 1000);
        if (diff < 60) return `${diff}s ago`;
        if (diff < 3600) return `${Math.floor(diff / 60)}m ago`;
        if (diff < 86400) return `${Math.floor(diff / 3600)}h ago`;
        return past.toLocaleDateString();
    };

    const loadMemes = async () => {
        if (isLoading) return;
        isLoading = true;
        loader.style.display = 'block';

        try {
            let url = `https://www.reddit.com/r/memes.json?limit=10&random=${Math.random()}`;
            if (after) url += `&after=${after}`;

            const response = await fetch(url);
            const data = await response.json();
            let memes = data.data.children.map(child => child.data);
            after = data.data.after;
            shuffleArray(memes);

            memes.forEach(meme => {
                if (!meme.url.match(/\.(jpg|jpeg|png|gif)$/i)) return;
                if (!memeContainer.querySelector(`img[src="${meme.url}"]`)) {
                    const isSaved = isMemeSaved(meme.url);
                    const memeElement = document.createElement('div');
                    memeElement.classList.add('meme');
                    memeElement.innerHTML = `
                        <img src="${meme.url}" alt="${meme.title}">
                        <div class="buttons">
                            <button class="save-btn ${isSaved ? 'saved' : ''}">
                                <i class="fas ${isSaved ? 'fa-check' : 'fa-save'}"></i> ${isSaved ? 'Saved' : 'Save'}
                            </button>
                            <button class="like-btn" data-url="${meme.url}">❤️ 0</button>
                        </div>
                        <div class="comments-container">
                            <div class="comment-input-box">
                                <input class="comment-input" placeholder="Add a comment..." data-url="${meme.url}">
                                <button class="add-comment-btn">Add</button>
                            </div>
                            <div class="comment-list"></div>
                        </div>
                    `;
                    const img = memeElement.querySelector('img');
                    img.onload = () => {
                        memeContainer.appendChild(memeElement);

                        const saveButton = memeElement.querySelector('.save-btn');
                        saveButton.addEventListener('click', () => toggleSaveMeme(meme, saveButton));

                        const likeBtn = memeElement.querySelector('.like-btn');
                        updateLikeStatus(meme.url, likeBtn);
                        likeBtn.addEventListener('click', () => toggleLike(meme.url, likeBtn));

                        const input = memeElement.querySelector('.comment-input');
                        const addBtn = memeElement.querySelector('.add-comment-btn');
                        const commentList = memeElement.querySelector('.comment-list');

                        fetchComments(meme.url, commentList);

                        addBtn.addEventListener('click', () => {
                            if (input.value.trim()) {
                                postComment(meme.url, input.value, commentList);
                                input.value = '';
                            }
                        });
                    };
                }
            });
        } catch (error) {
            console.error('Fetch error:', error);
        } finally {
            isLoading = false;
            loader.style.display = 'none';
        }
    };

    const toggleSaveMeme = async (meme, button) => {
        const isSaved = button.classList.contains('saved');
        const endpoint = isSaved ? 'unsave_meme.php' : 'save_meme.php';

        try {
            const res = await fetch(endpoint, {
                method: 'POST',
                body: new URLSearchParams({ meme_url: meme.url })
            });
            const data = await res.json();
            if (data.success) {
                button.classList.toggle('saved');
                button.innerHTML = button.classList.contains('saved') ?
                    '<i class="fas fa-check"></i> Saved' :
                    '<i class="fas fa-save"></i> Save';
            }
        } catch (err) {
            console.error(err);
        }
    };

    const toggleLike = async (meme_url, button) => {
        const liked = button.classList.contains('liked');
        const endpoint = liked ? 'unlike_meme.php' : 'like_meme.php';

        try {
            const res = await fetch(endpoint, {
                method: 'POST',
                body: new URLSearchParams({ meme_url })
            });
            const data = await res.json();
            if (data.success) {
                button.classList.toggle('liked');
                updateLikeStatus(meme_url, button);
            }
        } catch (err) {
            console.error('Like error:', err);
        }
    };

    const updateLikeStatus = async (meme_url, button) => {
        try {
            const res = await fetch('get_likes.php?meme_url=' + encodeURIComponent(meme_url));
            const data = await res.json();
            button.innerHTML = `❤️ ${data.likes}`;
        } catch (err) {
            button.innerHTML = '❤️ 0';
        }
    };

    const postComment = async (meme_url, comment, commentList) => {
        try {
            const res = await fetch('comment_meme.php', {
                method: 'POST',
                body: new URLSearchParams({ meme_url, comment })
            });
            const data = await res.json();
            if (data.success) fetchComments(meme_url, commentList);
        } catch (err) {
            console.error(err);
        }
    };

    const fetchComments = async (meme_url, container) => {
        try {
            const res = await fetch('get_comments.php?meme_url=' + encodeURIComponent(meme_url));
            const { comments, current_user_id } = await res.json();
            container.innerHTML = '';
            comments.forEach(({ id, comment, username, created_at, user_id }) => {
                const card = document.createElement('div');
                card.classList.add('comment-card');
                card.innerHTML = `
                    <div class="meta">
                        <strong>${username}</strong> · <span class="timestamp">${timeAgo(created_at)}</span>
                    </div>
                    <div class="text" contenteditable="false">${comment}</div>
                    ${user_id == current_user_id ? `
                    <div class="actions">
                        <button class="edit-btn">✏️</button>
                        <button class="delete-btn">🗑️</button>
                    </div>` : ''}
                `;

                if (user_id == current_user_id) {
                    const textEl = card.querySelector('.text');
                    const editBtn = card.querySelector('.edit-btn');
                    const deleteBtn = card.querySelector('.delete-btn');

                    editBtn.onclick = () => {
                        textEl.setAttribute('contenteditable', 'true');
                        textEl.focus();
                        textEl.addEventListener('blur', async () => {
                            textEl.setAttribute('contenteditable', 'false');
                            const newComment = textEl.textContent.trim();
                            await fetch('edit_comment.php', {
                                method: 'POST',
                                body: new URLSearchParams({ id, comment: newComment })
                            });
                        }, { once: true });
                    };

                    deleteBtn.onclick = async () => {
                        await fetch('delete_comment.php', {
                            method: 'POST',
                            body: new URLSearchParams({ id })
                        });
                        card.remove();
                    };
                }

                container.appendChild(card);
            });
        } catch (err) {
            console.error(err);
        }
    };

    window.addEventListener('scroll', () => {
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
            loadMemes();
        }
    });

    (async () => {
        await fetchSavedMemes();
        loadMemes();
    })();
});
