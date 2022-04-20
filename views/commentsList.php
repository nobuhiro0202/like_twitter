<?php foreach ($comments as $comment): ?> 
<li id=<?= $comment['id']?>>
  <div class="lihead">
    <div class="fana">
      <img src="./images/person-icon.png" class='user-icon'>
      <span class='person'><?= $comment['name'] ?></span>
    </div>
    <span><?= $comment['created_at'] ?></span>
  </div>
  <h5 class='statement'><?= $comment['comment'] ?></h5>
  <div class="lifoot">
    <?php if($id === $comment['cuid']):?>
    <div>
      <i class="fa-solid fa-trash-can trash" style='color: red;'></i>
    </div>
    <?php endif;?>
    <div class="like">
      <i class="fa-regular fa-heart heart"></i>
      <span id="count"><?= $comment['likes'] ?></span>
    </div>
  </div>
</li>
<?php endforeach; ?>