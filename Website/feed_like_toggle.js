
document.addEventListener('DOMContentLoaded', async () => {
    const memes = document.querySelectorAll('.meme');

    for (const meme of memes) {
        const memeUrl = meme.getAttribute('data-url');
        const likeBtn = meme.querySelector('.like-btn');

        if (likeBtn) {
            // Fetch current like state
            try {
                const res = await fetch(`get_likes.php?meme_url=${encodeURIComponent(memeUrl)}`);
                const data = await res.json();
                likeBtn.innerHTML = `❤️ ${data.likes}`;
            } catch {
                likeBtn.innerHTML = "❤️ 0";
            }

            // Toggle like/unlike on click
            likeBtn.addEventListener('click', async () => {
                const isLiked = likeBtn.classList.contains('liked');
                const endpoint = isLiked ? 'unlike_meme.php' : 'like_meme.php';

                try {
                    const response = await fetch(endpoint, {
                        method: 'POST',
                        body: new URLSearchParams({ meme_url: memeUrl })
                    });
                    const result = await response.json();
                    if (result.success) {
                        likeBtn.classList.toggle('liked', !isLiked);
                        likeBtn.innerHTML = `❤️ ${result.likes}`;
                    }
                } catch (err) {
                    console.error('Like error:', err);
                }
            });
        }
    }
});
