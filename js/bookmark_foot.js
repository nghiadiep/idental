var bookmarkurl='http://www.identalclinic.jp/';
var bookmarktitle='アイデンタルクリニック';

function setBookMark() {
  if (document.all)  {
    window.external.AddFavorite(bookmarkurl,bookmarktitle);
  }else{
    alert("こちらのお気に入りへの追加ボタンはInternet Explorer用です。それ以外のブラウザをご使用の場合はそれぞれのブラウザからお気に入りへの追加をお願いします。");
  }
}

document.write('<a href="#" onclick="setBookMark();return false;"><img src="http://www.identalclinic.jp/imgs/common/bn_bookmark.jpg" alt="お気に入り登録はこちらをクリック" style="vertical-align:top;margin:20px 0 10px 0;" /></a>');
