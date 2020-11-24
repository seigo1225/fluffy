<?php
require_once("config/config.php");
require_once("model/User.php");

?>
<div id="modal2" class="modal-wrapper" style="display: none;">
  <div class="modal-outer-wrapper">
    <div class="modal-inner-wrapper">
      <div class="modal-container">
        <div class="modal-content">
          <form role="form" id="form2" action="post.js" method="post" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-group">
                <label for="postInput">投稿を編集</label>
                <input type="textarea" class="postUpdate" name="massage" id="editUserMassage" value="" rows="4" maxlength="140">
                <input type="hidden" class="postId" name="id" value="<?=$row['id']?>" data-id="<?=$row['id'];?>">
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" id="editUserMassageBtn" name="editUserMassageBtn" value="dateupdate">変更</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
