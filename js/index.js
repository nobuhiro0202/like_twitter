'use strict';

const 
  d = document,
  makeCList = (id, user_id, cuid, comment, username, created_at, likes = 0) => {
    const li = d.createElement('li');
    li.id = id;
    if (user_id === cuid) {
      li.innerHTML = `
        <h2>${comment}</h2>
        <span>投稿日: ${created_at}</span>
        <span>投稿者: ${username}</span>
        <i class="fa-solid fa-trash-can trash"></i>
        <i class="fa-regular fa-heart heart" id="like"></i>
        <span>${likes}</span>
        `;
    } else {
      li.innerHTML = `
        <h2>${comment}</h2>
        <span>投稿日: ${created_at}</span>
        <span>投稿者: ${username}</span>
        <i class="fa-regular fa-heart heart" id="like"></i>
        <span>${likes}</span>
        `;
    }
    return li;
  };

d.addEventListener('DOMContentLoaded', () => {
  const 
    c_sm = d.getElementById('comment-submit'),
    user_id = d.getElementById('user_id').value,
    trashs = d.querySelectorAll('.trash');

  let 
    hearts = d.querySelectorAll('.heart');
  
  c_sm.addEventListener('click', async e => {
    e.preventDefault();
    const 
      c = d.getElementById('comment'),
      l = d.getElementById('comment-list');
    if (c.value === '') {
      return;
    }
    try {
      const res = await fetch('../controllers/commentsController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({user_id: user_id, comment: c.value}),
      });
      const data = await res.json();
      const { id, cuid, comment, name, created_at } = data[0];
      const dom = makeCList(id, user_id, cuid, comment, name, created_at);
      l.prepend(dom);
      c.value = '';
    } catch (e) {
      console.error(e);
    }
  })
  
  /**コメントいいね */
  for (let heart of hearts) {
    heart.addEventListener('click', async e => {
      e.preventDefault();
      const 
        cid = heart.parentNode.id,
        count = heart.nextElementSibling;
      try {
        const res = await fetch('comment_like.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ user_id: user_id, comment_id: cid }),
        });
        const data = await res.json();
        heart.classList.remove('fa-regular');
        heart.classList.add('fa-solid');
        heart.setAttribute("style", "color: lightcoral");
        count.innerHTML = data[0].likes | 0;
      } catch (e) {
        console.error(e);
      }
    })
  }


  /**コメント削除 */
  for (const trash of trashs) {
    trash.addEventListener('click', async e => {
      e.preventDefault();
      const 
        cid = trash.parentNode.parentNode.parentNode.id,
        li = d.getElementById(`${cid}`);
      try {
        await fetch('../controllers/comTrash.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ user_id: user_id, comment_id: cid }),
        });
        li.remove();
      } catch (e) {
        console.error(e);
      }
    })
  }
})