var bookmarkurl='http://www.identalclinic.jp/';
var bookmarktitle='アイデンタルクリニック';

function setBookMark() {
  if (document.all)  {
    window.external.AddFavorite(bookmarkurl,bookmarktitle);
  }else{
    alert("こちらのお気に入りへの追加ボタンはInternet Explorer用です。それ以外のブラウザをご使用の場合はそれぞれのブラウザからお気に入りへの追加をお願いします。");
  }
}

document.write('<a href="#" onclick="setBookMark();return false;"><img src="http://www.identalclinic.jp/imgs/common/btn_favorite.jpg" alt="お気に入り登録はこちらをクリック" style="vertical-align:top;margin-right:10px;margin:20px 6px 0 0;" /></a>');
