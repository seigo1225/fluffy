//ajax投稿処理
$(function() {
  'use strict';
  $('.postInput').focus();
  //delete
  $('#posts').on('click', '.delete_post', function() {
    //idを取得
    var id = $(this).data('id');
    //ajax処理
    if(confirm('投稿を削除してよろしいですか？')) {
      $.post('ajax/ajax.php', {
        id: id,
        mode: 'delete',
      }, function($res) {
        $('#postList_' + id).fadeOut(800);
      });
      return false;
    }
  });
  //update
  $('#posts').on('click', '.edit_post', function() {
    //idを取得
    var post_id = $(this).data('id');

    $('#form2').on('click', '#editUserMassageBtn', function() {
      //編集メッセージを取得
      var massage = $('.postUpdate').val();
      //ajax処理
      $.post('ajax/ajax.php', {
        id: post_id,
        massage: massage,
        mode: 'update',
      }, function(res) {
        location.replace("/fluffy/index.php");
      });
    });
  });
  //create
  $('#new_post').on('click', '.postBtn', function() {
    //idを取得
    var user_id = $('.user_id').val();
    var user_name = $('.user_name').val();
    //投稿を取得
    var massage = $('.postInput').val();
    var mode = 'create';
    //画像ファイルを取得
    var fd = new FormData();
    var fd = new FormData($('#new_post').get(0));
    // var IMGFILE = $('input[name="image"]').prop('files')[0];

    //フォーム データセット
    fd.append('user_id', user_id);
    fd.append('user_name', user_name);
    fd.append('massage', massage);
    fd.append('mode', mode);
    // fd.append("image", IMGFILE);

    //ajax処理
    $.ajax({
      url: 'ajax/ajax.php',
      type: 'POST',
      data: fd,
      cache: false,
      contentType: false,
      processData: false,
      dataType: 'html'
    }).done(function(data) {
      console.log('ajax success');
      console.log('data:\n', data);

      var now = new Date();
      var y = now.getFullYear();
      var m = now.getMonth() + 1;
      var d = now.getDate();
      var h = now.getHours();
      var mi = now.getMinutes();
      var s = now.getSeconds();

      var $element = $('#postList_template').clone();
      $element
      .attr('id', 'postList_' + data.id)
      .find('.postText').text(massage);
      // $element
      // .find('.postImg img').attr('src', data.image );
      $element
      .find('.name').text(user_name);
      $element
      .find('.time').text(y + '-' + m + '-' + d + ' ' + h + ':' + mi + ':' + s);
      $('#posts').prepend($element.hide().fadeIn(800));
      $('.postInput').val('').focus();
    });
    return false;
  });
  //投稿画像プレビュー
  $('.postImage').on('change', function (e) {
      var reader = new FileReader();
      reader.onload = function (e) {
          $("#preview").attr('src', e.target.result);
      }
      reader.readAsDataURL(e.target.files[0]);
  });
  $('.avatarInput').on('change', function (e) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('.avatarEdit').attr('src', e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
  });

});
