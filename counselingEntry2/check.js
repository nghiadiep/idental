function check(){
	var flag = 0;

	// �ݒ�J�n�i�K�{�ɂ��鍀�ڂ�ݒ肵�Ă��������j
	if(document.form01.OFFEROR_FAMILY_NAME.value == ""){
		flag = 1;
	}
	else if(document.form01.OFFEROR_FIRST_NAME.value == ""){
		flag = 1;
	}
	else if(document.form01.OFFEROR_FAMILY_NAME_FURIGANA.value == ""){
		flag = 1;
	}
	else if(document.form01.OFFEROR_FIRST_NAME_FURIGANA.value == ""){
		flag = 1;
	}
	else if(document.form01.TEL_NO.value == ""){
		flag = 1;
	}
	else if(document.form01.EMAIL_ADDRESS.value == ""){
		flag = 1;
	}
	else if(document.form01.REQUEST_DAY_KIND1.value == "" && document.form01.REQUEST_TIMEZONE1.value == ""){
		flag = 1;
	}
	// �ݒ�I��

	if(flag){
		window.alert('���͍��ڂ��������Ă�������'); // ���͘R�ꂪ����Όx���_�C�A���O��\��
		return false; // ���M�𒆎~
	}	else{
		document.form01.submit();
		//return true; // ���M�����s
	}
}
