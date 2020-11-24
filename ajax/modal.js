$(function() {
  $('.userEdit').modaal({
  	animation_speed: '500', 	// アニメーションのスピードをミリ秒単位で指定
  	background: '#000',	// 背景の色
  	overlay_opacity: '0.8',	// 背景のオーバーレイの透明度を変更
  	background_scroll: 'true',	// 背景をスクロールさせるか否か
  	loading_content: 'Now Loading, Please Wait.'	// 読み込み時のテキスト表示
  });
});
$(function() {
  $('.edit_post').modaal({
  	animation_speed: '200', 	// アニメーションのスピードをミリ秒単位で指定
  	background: '#000',	// 背景の色
  	overlay_opacity: '0.8',	// 背景のオーバーレイの透明度を変更
  	background_scroll: 'true',	// 背景をスクロールさせるか否か
  	loading_content: 'Now Loading, Please Wait.'	// 読み込み時のテキスト表示
  });
});
