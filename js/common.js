<!-- ページトップスクロール -->
$(function() {
	var showFlag = false;
	var topBtn = $('#pagetop');	
	topBtn.css('bottom', '-100px');
	var showFlag = false;
	//スクロールしたらボタン表示
	$(window).scroll(function () {
		if ($(this).scrollTop() > 1) {
			if (showFlag == false) {
				showFlag = true;
				topBtn.stop().animate({'bottom' : '50px'}, 200); 
			}
		} else {
			if (showFlag) {
				showFlag = false;
				topBtn.stop().animate({'bottom' : '-100px'}, 200); 
			}
		}
	});
	//スクロールしてトップ
    topBtn.click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 500);
		return false;
    });
});

$(function(){
   // #で始まるアンカーをクリックした場合に処理
   $('a[href^=#]').click(function() {
      // スクロールの速度
      var speed = 400; // ミリ秒
      // アンカーの値取得
      var href= $(this).attr("href");
      // 移動先を取得
      var target = $(href == "#" || href == "" ? 'html' : href);
      // 移動先を数値で取得
      var position = target.offset().top;
      // スムーススクロール
      $('body,html').animate({scrollTop:position}, speed, 'swing');
      return false;
   });
});

$(function(){
   // headerで始まるアンカーをクリックした場合に処理
   $('a[href^=header]').click(function() {
      // スクロールの速度
      var speed = 400; // ミリ秒
      // アンカーの値取得
      var href= $(this).attr("href");
      // 移動先を取得
      var target = $(href == "header" || href == "" ? 'html' : href);
      // 移動先を数値で取得
      var position = target.offset().top;
      // スムーススクロール
      $('body,html').animate({scrollTop:position}, speed, 'swing');
      return false;
   });
});

<!-- 外部読み込み -->
function writeHeader(rootDir){

	$.ajax({
		url: rootDir + "header.html", 
		cache: false,
		async: false, 
		success: function(html){

			html = html.replace(/\{\$root\}/g, rootDir);
			document.write(html);
		}
	});

}

function writeFooter(rootDir){

	$.ajax({
		url: rootDir + "footer.html", 
		cache: false,
		async: false, 
		success: function(html){

			html = html.replace(/\{\$root\}/g, rootDir);
			document.write(html);
		}
	});

}

function writeSidebar(rootDir){

	$.ajax({
		url: rootDir + "sidebar.html", 
		cache: false,
		async: false, 
		success: function(html){

			html = html.replace(/\{\$root\}/g, rootDir);
			document.write(html);
		}
	});

}

function writeResponsD(rootDir){

	$.ajax({
		url: rootDir + "respons.html", 
		cache: false,
		async: false, 
		success: function(html){

			html = html.replace(/\{\$root\}/g, rootDir);
			document.write(html);
		}
	});

}