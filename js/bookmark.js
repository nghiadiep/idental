var bookmarkurl='http://www.identalclinic.jp/';
var bookmarktitle='�A�C�f���^���N���j�b�N';

function setBookMark() {
  if (document.all)  {
    window.external.AddFavorite(bookmarkurl,bookmarktitle);
  }else{
    alert("������̂��C�ɓ���ւ̒ǉ��{�^����Internet Explorer�p�ł��B����ȊO�̃u���E�U�����g�p�̏ꍇ�͂��ꂼ��̃u���E�U���炨�C�ɓ���ւ̒ǉ������肢���܂��B");
  }
}

document.write('<a href="#" onclick="setBookMark();return false;"><img src="http://www.identalclinic.jp/imgs/common/btn_favorite.jpg" alt="���C�ɓ���o�^�͂�������N���b�N" style="vertical-align:top;margin-right:10px;margin:20px 6px 0 0;" /></a>');
