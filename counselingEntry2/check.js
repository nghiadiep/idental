function check(){
	var flag = 0;

	// 設定開始（必須にする項目を設定してください）
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
	// 設定終了

	if(flag){
		window.alert('入力項目を見直してください'); // 入力漏れがあれば警告ダイアログを表示
		return false; // 送信を中止
	}	else{
		document.form01.submit();
		//return true; // 送信を実行
	}
}
