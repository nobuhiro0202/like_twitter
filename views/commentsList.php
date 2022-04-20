<?php foreach ($comments as $comment): ?> 
<li id=<?= $comment['id']?>>
  <div class="lihead">
    <div class="fana">
      <img src="./images/person-icon.png" class='user-icon'>
      <span class='person' id='person' value=<?= $comment['cuid'] ?>><?= $comment['name'] ?></span>
    </div>
    <span><?= $comment['created_at'] ?></span>
  </div>
  <h5 class='statement'><?= $comment['comment'] ?></h5>
  <div class="lifoot">
    <?php if($login_id === $comment['cuid']):?>
    <div>
      <i class="fa-solid fa-trash-can trash" style='color: red;'></i>
    </div>
    <?php endif;?>
    <div class="like">
      <?php 
        $alreadyLike_sql = "
          select * 
          from comment_likes
          where user_id = {$login_id} and comment_id = {$comment['id']} and l_deleted <> 1
          ";
        $temp = $dbh->query($alreadyLike_sql);
        $alreadyLike = $temp->fetch();
        if (!$alreadyLike): 
      ?>
        <i class="fa-regular fa-heart heart"></i>
      <?php else: ?>
        <i class="fa-solid fa-heart heart" style="color: lightcoral;"></i>
      <?php endif; ?>
      <span id="count"><?= $comment['likes'] ?></span>
    </div>
  </div>
</li>
<?php endforeach; ?>