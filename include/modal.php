<?php
require_once("config/config.php");
require_once("model/User.php");

?>

<div id="modal" class="modal-wrapper" style="display: none;">
  <div class="modal-outer-wrapper">
    <div class="modal-inner-wrapper">
      <div class="modal-container">
        <div class="modal-content">
          <form role="form" id="form1" action="index.php" method="post" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-group">
                <div class="userIcon">
                  <img class="avatarEdit sq200px" src="<?=$row['icon']?>" alt="アバター画像">
                  <div class="avatarEditor">
                    <div class="guide"><div class="guide-text">プロフィール画像を変更</div></div>
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>">
                    <input class="avatarInput" name="image" type="file"><br>
                  </div>
                </div>
                <label for="userId">ユーザーID</label>
                <input type="text" name="user_id" id="edituserId" value="<?php echo $row['user_id']; ?>" placeholder="半角英数字またはアンダーバー">
                <label for="userName">ユーザー名</label>
                <input type="text" name="user_name" id="edituserName" value="<?php echo $row['user_name']; ?>">
                <label for="biography">プロフィール</label>
                <input type="textarea" name="biography" id="editBio" value="<?php echo $row['biography']; ?>" rows="4" maxlength="140" placeholder="自己紹介を追加しよう！">
                <input type="hidden" name="id" value="<?=$row['id']?>">
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" id="editBtn" name="editBtn" value="dateup">変更</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
