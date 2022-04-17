'use strict';

const 
  d = document,
  makeCList = (id, user_id, cuid, comment, username, created_at) => {
    const li = d.createElement('li');
    li.id = id;
    if (user_id === cuid) {
      li.innerHTML = `
        <h2>${comment}</h2>
        <span>投稿日: ${created_at}</span>
        <span>投稿者: ${username}</span>
        <i class="fa-solid fa-trash-can trash"></i>
        <i class="fa-regular fa-heart heart" id="like"></i>
        <span>0</span>
        `;
    } else {
      li.innerHTML = `
        <h2>${comment}</h2>
        <span>投稿日: ${created_at}</span>
        <span>投稿者: ${username}</span>
        <i class="fa-regular fa-heart heart" id="like"></i>
        <span>0</span>
        `;
    }
    return li;
  };

d.addEventListener('DOMContentLoaded', () => {
  const 
    c_sm = d.getElementById('comment-submit'),
    user_id = d.getElementById('user_id').value;
  let 
    hearts = d.querySelectorAll('.heart'),
    trashs = d.querySelectorAll('.trash');
  
  c_sm.addEventListener('click', async e => {
    e.preventDefault();
    const 
      c = d.getElementById('comment'),
      l = d.getElementById('comment-list');
    if (c.value === '') {
      return;
    }
    try {
      const res = await fetch('comments.php', {
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

  for (let trash of trashs) {
    trash.addEventListener('click', async e => {
      e.preventDefault();
      const 
        cid = trash.parentNode.id,
        l = d.getElementById('comment-list');
      try {
        const res = await fetch('comment_trash.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ comment_id: cid }),
        });
        const datas = await res.json();
        console.log(datas);
        // l.innerHTML = '';
        // datas.map(data => {
        //   const { id, cuid, comment, name, created_at } = data;
        //   const dom = makeCList(id, user_id, cuid, comment, name, created_at);
        //   l.prepend(dom);
        // });
      } catch (e) {
        console.error(e);
      }
    })
  }
})