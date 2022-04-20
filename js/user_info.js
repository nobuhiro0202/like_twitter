'use strict';

const 
  d = document,
  makeCList = (id, user_id, cuid, comment, username, created_at, likes = 0) => {
    const li = d.createElement('li');
    li.id = id;
    li.innerHTML = `
      <div class="lihead">
        <div class="fana">
          <img src="./images/person-icon.png" class='user-icon'>
          <span class='person'>${username}</span>
        </div>
        <span>${created_at}</span>
      </div>
      <h5 class='statement'>${comment}</h5>
      <div class="lifoot">
        <div>
          <i class="fa-solid fa-trash-can trash" style='color: red;'></i>
        </div>
        <div class="like">
          <i class="fa-regular fa-heart heart"></i>
          <span id="count">${likes}</span>
        </div>
      </div>
      `;
    return li;
  };

d.addEventListener('DOMContentLoaded', () => {
  const 
    user_id = d.getElementById('user_id').value,
    c_sm = d.getElementById('comment-submit'),
    hearts = d.querySelectorAll('.heart'),
    trashs = d.querySelectorAll('.trash');

  /**コメント投稿 */
  c_sm.addEventListener('click', async e => {
    e.preventDefault();
    const 
      c = d.getElementById('comment'),
      ul = d.getElementById('comment-list');
    if (c.value === '') {
      return;
    }
    try {
      const res = await fetch('./controllers/commentsController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({user_id: user_id, comment: c.value}),
      });
      const data = await res.json();
      const { id, cuid, comment, name, created_at } = data[0];
      const dom = makeCList(id, user_id, cuid, comment, name, created_at);
      if (/^投稿/.test(ul?.childNodes[1]?.innerHTML)) {
        ul.innerHTML = '';
      }
      ul.prepend(dom);
      c.value = '';
    } catch (e) {
      console.error(e);
    }
  })


  /**コメントいいね */
  for (const heart of hearts) {
    heart.addEventListener('click', async e => {
      e.preventDefault();
      const 
        cid = heart.parentNode.parentNode.parentNode.id,
        count = heart.nextElementSibling;

      try {
        const res = await fetch('./controllers/comLike.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ user_id: user_id, comment_id: cid }),
        });
        const data = await res.json();
        if (heart.classList.contains('fa-regular')) {
          heart.classList.remove('fa-regular');
          heart.classList.add('fa-solid');
          heart.setAttribute("style", "color: lightcoral");
        } else {
          heart.classList.remove('fa-solid');
          heart.classList.add('fa-regular');
          heart.removeAttribute("style");
        }
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
        await fetch('./controllers/comTrash.php', {
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