<?php
require_once("Preconn.php");
require_once("functions.inc.php");

/**
 * Webカウンセリング申し込み サーバサイド処理.
 * <p>Webカウンセリング申し込みフォーム、および申し込み情報をメンテナンスする管理機能のサーバサイド処理</p>
 *
 * @author 2011 I DENTAL CLINIC. Allright Reserved.
 */

$filter_type = "text";


/**
 * メールアドレス妥当性チェック関数.
 * <p>メールアドレスの妥当性チェック関数</p>
 *
 */
function is_mail($text) {
if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $text)) {
        return TRUE;
    } else {
        return FALSE;
    }
}


/**
 * 電話番号妥当性チェック関数.
 * <p>電話番号の妥当性チェック関数</p>
 *
 */
function is_tel($text) {
if (preg_match("/^[0-9]{2,5}-[0-9]{1,4}-[0-9]{4,6}$/", $text)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * 全角カナ妥当性チェック関数.
 * <p>電話番号の妥当性チェック関数</p>
 *
 */	
function is_kana($text) {
	if (mb_ereg_match('/^[ァ-ヶー]+$/', $text)) {  
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * 郵便番号妥当性チェック関数.
 * <p>電話番号の妥当性チェック関数</p>
 *
 */
function is_zip($text) {
if (preg_match("/^\d{3}\-\d{4}$/", $text)) {
        return TRUE;
    } else {
        return FALSE;
    }
}


/**
 * HTTPパラメータ確認関数.
 * <p>Webカウンセリング申し込みフォームのリクエスト確認関数</p>
 *
 */
function showParameter() {
		echo "氏名（姓）　　　　　　：";
		echo $_REQUEST["OFFEROR_FAMILY_NAME"],"<br />";
		echo "氏名（名）　　　　　　：";
		echo $_REQUEST["OFFEROR_FIRST_NAME"],"<br />";
		echo "氏名カナ（姓）　　　　：";
		echo $_REQUEST["OFFEROR_FAMILY_NAME_FURIGANA"],"<br />";
		echo "氏名カナ（名）　　　　：";
		echo $_REQUEST["OFFEROR_FIRST_NAME_FURIGANA"],"<br />";
		echo "性別　　　　　　　　　：";
		echo $_REQUEST["OFFEROR_SEX"],"<br />";
		echo "年齢　　　　　　　　　：";
		echo $_REQUEST["OFFEROR_AGE"],"<br />";
		echo "職業　　　　　　　　　：";
		echo $_REQUEST["JOB"],"<br />";
		echo "郵便番号　　　　　　　：";
		echo $_REQUEST["ZIP_CODE"],"<br />";
		echo "住所１（都道府県）　　：";
		echo $_REQUEST["ADDRESS_1"],"<br />";
		echo "住所２　　　　　　　　：";
		echo $_REQUEST["ADDRESS_2"],"<br />";
		echo "住所３　　　　　　　　：";
		echo $_REQUEST["ADDRESS_3"],"<br />";
		echo "電話番号　　　　　　　：";
		echo $_REQUEST["TEL_NO"],"<br />";
		echo "メールアドレス　　　　：";
		echo $_REQUEST["EMAIL_ADDRESS"],"<br />";
		echo "問い合わせメモ　　　　：";
		echo $_REQUEST["INQUIRY"],"<br />";
		echo "カウンセリング拠点　　：";
		echo $_REQUEST["COUNSELING_PLACE"],"<br />";
		echo "予約日時（１）　　　　：";
		echo $_REQUEST["REQUEST_DATETIME_1"],"<br />";
		echo "予約日時（２）　　　　：";
		echo $_REQUEST["REQUEST_DATETIME_2"],"<br />";
		echo "予約日時（３）　　　　：";
		echo $_REQUEST["REQUEST_DATETIME_3"],"<br />";
		echo "第一希望・曜日　　　　：";
		echo $_REQUEST["REQUEST_DAY_KIND1"],"<br />";
		echo "第一希望・時間帯　　　：";
		echo $_REQUEST["REQUEST_TIMEZONE1"],"<br />";
		echo "第二希望・曜日　　　　：";
		echo $_REQUEST["REQUEST_DAY_KIND2"],"<br />";
		echo "第二希望・時間帯　　　：";
		echo $_REQUEST["REQUEST_TIMEZONE2"],"<br />";
		echo "第三希望・曜日　　　　：";
		echo $_REQUEST["REQUEST_DAY_KIND3"],"<br />";
		echo "第三希望・時間帯　　　：";
		echo $_REQUEST["REQUEST_TIMEZONE3"],"<br />";
		echo "以前にメールありフラグ：";
		echo $_REQUEST["CONSUL_MAIL_USED"],"<br />";
		echo "確定ステータス　　　　：";
		echo $_REQUEST["RESERV_FIX_STATUS"],"<br />";
		echo "確定予約日時　　　　　：";
		echo $_REQUEST["RESERV_FIX_DATETIME"],"<br />";
		echo "確定対応スタッフ　　　：";
		echo $_REQUEST["RESERV_FIX_STAFF"],"<br />";
		echo "アクセスIPアドレス　　：";
		echo @gethostbyaddr($_SERVER["REMOTE_ADDR"]),"<br />";
		echo "アクセスUSER AGENT　　：";
		echo $_SERVER["HTTP_USER_AGENT"],"<br />";
		echo "削除フラグ　　　　　　：";
		echo $_REQUEST["IS_DELETE"],"<br />";
	
		return 1;
}


/**
 * リクエスト変数の妥当性チェック関数.
 * <p>Webカウンセリング申し込みフォームのリクエスト変数の内容を登録前にチェックする関数</p>
 *
 */
function RequestCheck() {

		//メールアドレスチェック
		if (!is_mail($_REQUEST["EMAIL_ADDRESS"])) {
			return 'メールアドレスの入力内容が正しくありません。';
		}
		
		//カナチェック
//		if (!is_kana($_REQUEST["OFFEROR_FAMILY_NAME_FURIGANA"])) {
//			return '氏名カナは全角カタカナで入力してください。';
//		}
//		if (!is_kana($_REQUEST["OFFEROR_FIRST_NAME_FURIGANA"])) {
//			return '氏名カナは全角カタカナで入力してください。';
//		}

		//電話番号チェック
		if (!is_tel($_REQUEST["TEL_NO"])) {
			return '電話番号の入力形式が正しくありません。';
		}
		return "TRUE";
}


/**
 * 申込データデータベース登録関数.
 * <p>Webカウンセリング申し込みデータをデータベースのテーブルに登録する関数</p>
 *
 */
function insert() {

	global $conn;

	if ($_REQUEST["CONSUL_MAIL_USED"] == "on") {
		$CONSUL_MAIL_USED = "1";
	} else {
		$CONSUL_MAIL_USED = "0";
	}

//			INSERT INTO `PRERESERV` 

	$query_insert = sprintf("
			INSERT INTO `PRERESERV` 
			(
				OFFEROR_FAMILY_NAME,
				OFFEROR_FIRST_NAME,
				OFFEROR_FAMILY_NAME_FURIGANA,
				OFFEROR_FIRST_NAME_FURIGANA,
				OFFEROR_SEX,
				OFFEROR_AGE,
				JOB,
				ZIP_CODE,
				ADDRESS_1,
				ADDRESS_2,
				ADDRESS_3,
				TEL_NO,
				EMAIL_ADDRESS,
				INQUIRY,
				COUNSELING_PLACE,
				REQUEST_DATETIME_1,
				REQUEST_DATETIME_2,
				REQUEST_DATETIME_3,
				REQUEST_DAY_KIND1,
				REQUEST_TIMEZONE1,
				REQUEST_DAY_KIND2,
				REQUEST_TIMEZONE2,
				REQUEST_DAY_KIND3,
				REQUEST_TIMEZONE3,
				CONSUL_MAIL_USED,
				RESERV_FIX_STATUS,
				RESERV_FIX_DATETIME,
				RESERV_FIX_STAFF,
				STAFF_MEMO,
				CREATED_ON,
				UPDATED_ON,
				REMOTE_ADDR,
				HTTP_USER_AGENT,
				IS_DELETE
				) 
				VALUES 
				(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)" ,	
				GetSQLValueString(mb_convert_encoding($_REQUEST["OFFEROR_FAMILY_NAME"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["OFFEROR_FIRST_NAME"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["OFFEROR_FAMILY_NAME_FURIGANA"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["OFFEROR_FIRST_NAME_FURIGANA"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["OFFEROR_SEX"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["OFFEROR_AGE"], 'UTF-8','SJIS-win'), "int"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["JOB"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["ZIP_CODE"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["ADDRESS_1"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["ADDRESS_2"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["ADDRESS_3"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["TEL_NO"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["EMAIL_ADDRESS"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["INQUIRY"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["COUNSELING_PLACE"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["REQUEST_DATETIME_1"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["REQUEST_DATETIME_2"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["REQUEST_DATETIME_3"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["REQUEST_DAY_KIND1"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["REQUEST_TIMEZONE1"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["REQUEST_DAY_KIND2"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["REQUEST_TIMEZONE2"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["REQUEST_DAY_KIND3"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["REQUEST_TIMEZONE3"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($CONSUL_MAIL_USED, 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["RESERV_FIX_STATUS"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["RESERV_FIX_DATETIME"], 'UTF-8','SJIS-win'), "text"), # 
				GetSQLValueString(mb_convert_encoding($_REQUEST["RESERV_FIX_STAFF"], 'UTF-8','SJIS-win'), "text"), # 
				"NULL", # // STAFF_MEMO(スタッフ向けカラムなので、常に空文字をセット)
				GetSQLValueString(date("Y-m-d H:i:s", time()), "date"), # 
				GetSQLValueString(date("Y-m-d H:i:s", time()), "date"), # 
				GetSQLValueString(@gethostbyaddr($_SERVER["REMOTE_ADDR"]), "text"), # //added by m.aoyama date:2009/05/07
				GetSQLValueString($_SERVER["HTTP_USER_AGENT"], "text"), # //added by m.aoyama date:2009/05/07
				GetSQLValueString($_REQUEST["IS_DELETE"], "text")# 
	);

	$ok = mysql_query($query_insert);

	if ($ok) {
		return 0;
	} else {
		return 1;
	}
}


/**
 * 申込確認メール送信関数.
 * <p>フォームからの登録内容を申し込み者宛にメール送信する。</p>
 *
 */
function mailToOfferor() 
{
	global $conn;

	// 設定
	$mail_to = $_REQUEST['EMAIL_ADDRESS']; // フォームデータを受け取るメールアドレス
	$mail_subject = 'カウンセリング申し込み　ありがとうございます'; 
	$mail_bcc = 'soudan@identalclinic.jp,unyou@kwm.co.jp'; // BCCで受け取りが必要な場合は設定
	$internal_enc = 'SJIS'; // 文字エンコード
//	$internal_enc = 'UTF-8'; // 文字エンコード

	mb_language('ja');
	mb_internal_encoding($internal_enc);
	$x_mailer = 'PreReserv SendMailer ver 1.0';
	$mode = $_POST['mode'];

	// メールヘッダ
	$mail_from = 'PreReservSendmailer@identalclinic.jp';		//注意
	$mail_header  = "From: {$mail_from}\n";
	if ($mail_bcc) $mail_header .= "Bcc: {$mail_bcc}\n";
	$mail_header .= "X-Mailer: {$x_mailer}";

	// メール本文の編集
	// 氏名
	$offeror = $_REQUEST['OFFEROR_FAMILY_NAME']." ".$_REQUEST['OFFEROR_FIRST_NAME'];

	// 氏名フリガナ
	$offeror_furigana = $_REQUEST['OFFEROR_FAMILY_NAME_FURIGANA']." ".$_REQUEST['OFFEROR_FIRST_NAME_FURIGANA'];

	// カウンセリング希望地
	$councelingPlace = $_REQUEST['COUNSELING_PLACE'];
	
	// 候補日・曜日・時間帯
	$requestDate1 = "";
	$requestDate2 = "";
	$requestDate3 = "";

	if(strlen($_REQUEST["REQUEST_DAY_KIND1"])>0) 
	{
		$requestDate1 .= $_REQUEST["REQUEST_DAY_KIND1"] . " の ";
	}
	if(strlen($_REQUEST["REQUEST_TIMEZONE1"])>0) 
	{
		$requestDate1 .= $_REQUEST["REQUEST_TIMEZONE1"];
	}
	else 
	{
		$requestDate1 = substr($requestDate1, 0, strlen($requestDate1)-4);
	}

	if(strlen($_REQUEST["REQUEST_DAY_KIND2"])>0) 
	{
		$requestDate2 .= $_REQUEST["REQUEST_DAY_KIND2"] . " の ";
	}
	if(strlen($_REQUEST["REQUEST_TIMEZONE2"])>0) 
	{
		$requestDate2 .= $_REQUEST["REQUEST_TIMEZONE2"];
	}
	else 
	{
		$requestDate2 = substr($requestDate2, 0, strlen($requestDate2)-4);
	}
	
	if(strlen($_REQUEST["REQUEST_DAY_KIND3"])>0) 
	{
		$requestDate3 .= $_REQUEST["REQUEST_DAY_KIND3"] . " の ";
	}
	if(strlen($_REQUEST["REQUEST_TIMEZONE3"])>0) 
	{
		$requestDate3 .= $_REQUEST["REQUEST_TIMEZONE3"];
	}
	else 
	{
		$requestDate3 = substr($requestDate3, 0, strlen($requestDate3)-4);
	}

	
	// ご相談内容
	$inquiry = stripslashes($_REQUEST['INQUIRY']);

	// 過去に無料相談メールを利用したことがあるかどうか
	$mailUsed			= "";
	if($_REQUEST["CONSUL_MAIL_USED"]=="1") 
	{
		$mailUsed		= "有";
	}
	else 
	{
		$mailUsed		= "無";
	}

	$address			= $_REQUEST["ADDRESS_1"];

	// メール送信
	require ('./template.php');
	$mail_message = html_entity_decode($mail_message, ENT_QUOTES, $internal_enc);
	$mail_message = str_replace("<br />", "", $mail_message);
	$mail_message = str_replace("\t", "\n", $mail_message);
	$mail_message = mb_convert_encoding($mail_message, $internal_enc, 'AUTO');
	mb_send_mail($mail_to, $mail_subject, $mail_message, $mail_header);
}


/**
 * メール送信エラー時DB更新関数.
 *
 */
function error_update() {

	return 0;
}

/**
 * 申込確認画面表示関数.
 * <p>フォームからの登録内容確認画面を表示する。</p>
 *
 */

function showInputCheckDisp() {

	    readfile('./template_head02.html');

		echo '<!-- pan -->';
		echo '<div id="pan">';
		echo '<p><a href="http://www.identalclinic.jp/">インプラントならアイデンタルクリニック　トップページ</a> > カウンセリング予約フォーム</p>';
		echo '</div>';
		echo '<!-- /pan -->';

		echo '	<!-- mailform -->';
		echo '<div id="mailform">';
		echo '<h2><img src="../imgs/entry/ti_1.gif" alt="あんしん相談 来院前の無料メール相談 無料相談メールフォーム" /></h2>';

		echo '	<!-- inner -->';
		echo '<div class="inner">';

		echo '	<h3>注意書きをよく読んでから投稿ください。</h3>';
		echo '<p>'.$_REQUEST["OFFEROR_FAMILY_NAME"].' '.$_REQUEST[OFFEROR_FIRST_NAME].' 様<br />';
		echo 'こちらの内容でカウンセリングの日時を検討させていただきます。</p>';

		echo '	<form method="post" action="./EntryRegist.php" name="form01">';
		echo '<table cellspacing="0" cellpadding="0">';
		echo '	<tr>';
		echo '		<tr><th>カウンセリング希望</th><td>'.$_REQUEST[COUNSELING_PLACE].'</td></tr>';

		if(strlen($_REQUEST["REQUEST_DAY_KIND1"])>0) { 
			echo '		<tr><th>希望する曜日・時間帯1：</th><td>'.$_REQUEST[REQUEST_DAY_KIND1];

			if(strlen($_REQUEST["REQUEST_TIMEZONE1"])>0) {
				echo ' の '.$_REQUEST[REQUEST_TIMEZONE1].'</td></tr>';
			}
		} else {
			echo '		<tr><th>希望する曜日・時間帯1：';
		}

		if(strlen($_REQUEST["REQUEST_DAY_KIND2"])>0) {
			echo '		<tr><th>希望する曜日・時間帯2：</th><td>'.$_REQUEST[REQUEST_DAY_KIND2] ;

			if(strlen($_REQUEST["REQUEST_TIMEZONE2"])>0) {
				echo 'の '.$_REQUEST[REQUEST_TIMEZONE2].'</td></tr>';
			}
		} else {
			echo '		<tr><th>希望する曜日・時間帯2：';
		}

		if(strlen($_REQUEST["REQUEST_DAY_KIND3"])>0) {
			echo '		<tr><th>希望する曜日・時間帯3：</th><td>'.$_REQUEST[REQUEST_DAY_KIND3];

			if(strlen($_REQUEST["REQUEST_TIMEZONE3"])>0) {
				echo ' の '.$_REQUEST[REQUEST_TIMEZONE3].'</td></tr>';
			}

		} else {
			echo '		<tr><th>希望する曜日・時間帯3：';
		}

 		echo '<input type="hidden" name="OFFEROR_FAMILY_NAME" 			value="'.stripslashes($_REQUEST[OFFEROR_FAMILY_NAME]).'">';
 		echo '<input type="hidden" name="OFFEROR_FIRST_NAME" 			value="'.stripslashes($_REQUEST[OFFEROR_FIRST_NAME]).'">';
 		echo '<input type="hidden" name="OFFEROR_FAMILY_NAME_FURIGANA" 	value="'.$_REQUEST[OFFEROR_FAMILY_NAME_FURIGANA].'">';
 		echo '<input type="hidden" name="OFFEROR_FIRST_NAME_FURIGANA" 	value="'.$_REQUEST[OFFEROR_FIRST_NAME_FURIGANA].'">';
 		echo '<input type="hidden" name="OFFEROR_SEX" 					value="'.$_REQUEST[OFFEROR_SEX].'">';
 		echo '<input type="hidden" name="OFFEROR_AGE" 					value="'.$_REQUEST[OFFEROR_AGE].'">';
 		echo '<input type="hidden" name="JOB" 							value="'.$_REQUEST[JOB].'">';
 		echo '<input type="hidden" name="ZIP_CODE" 						value="'.$_REQUEST[ZIP_CODE].'">';
 		echo '<input type="hidden" name="ADDRESS_1" 					value="'.stripslashes($_REQUEST[ADDRESS_1]).'">';
 		echo '<input type="hidden" name="ADDRESS_2" 					value="'.stripslashes($_REQUEST[ADDRESS_2]).'">';
 		echo '<input type="hidden" name="ADDRESS_3" 					value="'.stripslashes($_REQUEST[ADDRESS_3]).'">';
 		echo '<input type="hidden" name="TEL_NO" 						value="'.$_REQUEST[TEL_NO].'">';
 		echo '<input type="hidden" name="EMAIL_ADDRESS" 				value="'.$_REQUEST[EMAIL_ADDRESS].'">';
 		echo '<input type="hidden" name="INQUIRY" 						value="'.stripslashes($_REQUEST[INQUIRY]).'">';
 		echo '<input type="hidden" name="COUNSELING_PLACE" 				value="'.stripslashes($_REQUEST[COUNSELING_PLACE]).'">';
 		echo '<input type="hidden" name="REQUEST_DATETIME_1" 			value="'.$_REQUEST[REQUEST_DATETIME_1].'">';
 		echo '<input type="hidden" name="REQUEST_DATETIME_2" 			value="'.$_REQUEST[REQUEST_DATETIME_2].'">';
 		echo '<input type="hidden" name="REQUEST_DATETIME_3" 			value="'.$_REQUEST[REQUEST_DATETIME_3].'">';
 		echo '<input type="hidden" name="REQUEST_DAY_KIND1" 			value="'.stripslashes($_REQUEST[REQUEST_DAY_KIND1]).'">';
 		echo '<input type="hidden" name="REQUEST_TIMEZONE1" 			value="'.stripslashes($_REQUEST[REQUEST_TIMEZONE1]).'">';
 		echo '<input type="hidden" name="REQUEST_DAY_KIND2" 			value="'.stripslashes($_REQUEST[REQUEST_DAY_KIND2]).'">';
 		echo '<input type="hidden" name="REQUEST_TIMEZONE2"				value="'.stripslashes($_REQUEST[REQUEST_TIMEZONE2]).'">';
 		echo '<input type="hidden" name="REQUEST_DAY_KIND3" 			value="'.stripslashes($_REQUEST[REQUEST_DAY_KIND3]).'">';
 		echo '<input type="hidden" name="REQUEST_TIMEZONE3" 			value="'.stripslashes($_REQUEST[REQUEST_TIMEZONE3]).'">';
 		echo '<input type="hidden" name="CONSUL_MAIL_USED" 				value="'.$_REQUEST[CONSUL_MAIL_USED].'">';
 		echo '<input type="hidden" name="METHOD" 						value="CONF">';
		

		echo '	</table>';
		echo '	<p>※ご予約は<span style="color:#09c">こちらから折り返しお電話をかけさせていただき</span>確認をさせていただいて初めて完了となります。';
		echo '	送信いただくだけでは<span style="color:#09c">予約は完了しておりませんので</span>その点ご理解いただき得ますようよろしくお願いいたします。<br />';
		echo '	※申込内容についてはご指定のメールアドレス（'.$_REQUEST[EMAIL_ADDRESS].'）に送信させていただきます。<br />';
		echo '	※カウンセリングの日程調整についてはご指定の電話番号（'.$_REQUEST[TEL_NO].'）に当院スタッフが連絡いたします。</p><br />';
		echo '	<div class="bg"><input value="もどる" onclick="history.back();" type="button"> <input type="submit" value="この内容で申し込みます" /></div>';
		echo '</form>';

		echo '	</div>';
		echo '<!-- /inner -->';

		echo '	</div>';
		echo '<!-- /mailform -->';

	    readfile('./template_footer.html');

	return 0;
}


/**
 * 入力エラー画面表示関数.
 * <p>リクエスト変数チェック時のエラー内容を表示する画面</p>
 *
 */
function showInputErrorDisp($text) {
    readfile('./template_head02.html');


		echo '<!-- pan -->';
		echo '<div id="pan">';
		echo '<p><a href="http://www.identalclinic.jp/">インプラントならアイデンタルクリニック　トップページ</a> > カウンセリング予約フォーム入力エラー</p>';
		echo '</div>';
		echo '<!-- /pan -->';

		echo '	<!-- mailform -->';
		echo '<div id="mailform">';
		echo '<h2><img src="../imgs/mailform/ttl02.gif" alt="あんしん相談 来院前の無料メール相談 無料相談メールフォーム" /></h2><br />';

		echo '	<!-- inner -->';
		echo '<div class="inner">';

		echo '	<h3>入力内容を確認ください。</h3>';
		echo '<p>'.$text.'</p>';

		echo '	<form method="post" action="" name="form01">';
		echo '	<div class="bg"><input value="もどる" onclick="history.back();" type="button"></div>';
		echo '  </form>';

		echo '	</div>';
		echo '<!-- /inner -->';

		echo '	</div>';
		echo '<!-- /mailform -->';
	

    readfile('./template_footer.html');

	return 0;
}

/**
 * データベース処理エラー画面表示関数.
 * <p>リクエスト変数チェック時のエラー内容を表示する画面</p>
 *
 */
function showProcErrorDisp() {
    readfile('./template_head02.html');
	

		echo '<!-- pan -->';
		echo '<div id="pan">';
		echo '<p><a href="http://www.identalclinic.jp/">インプラントならアイデンタルクリニック　トップページ</a> > カウンセリング予約フォーム入力エラー</p>';
		echo '</div>';
		echo '<!-- /pan -->';

		echo '	<!-- mailform -->';
		echo '<div id="mailform">';
		echo '<h2 class="ti_1"><img src="../imgs/entry/ti_1.gif" alt="あんしん相談 来院前の無料メール相談 無料相談メールフォーム"></h2>';

		echo '	<!-- inner -->';
		echo '<div class="inner">';

		echo '申し込み処理にてエラーが発生しました。';

		echo '	<form method="post" action="" name="form01">';
		echo '	<div class="bg"><input value="もどる" onclick="history.back();" type="button"></div>';
		echo '  </form>';

		echo '	</div>';
		echo '<!-- /inner -->';

		echo '	</div>';
		echo '<!-- /mailform -->';
	
    readfile('./template_footer.html');
	return 0;

}


/**
 * 登録完了画面表示関数.
 * <p>申込登録完了画面を表示する関する。</p>
 *
 */
function showThanksDisp() {
    readfile('./template_head02.html');
	readfile('./template_thanks.html');
    readfile('./template_footer.html');
	return 0;
}

/**
 * 以下、メイン処理
 *
 */

//申込確認画面の表示
if ($_REQUEST["METHOD"]=="") {
	//チェック関数
	//showParameter();
	$ret = RequestCheck();
	if ($ret == "TRUE") {
		//確認画面表示
		$ret = showInputCheckDisp();
	} else {
		//入力エラー画面表示	
		showInputErrorDisp($ret) ;
	}
	die();
}

//データベース接続処理
if ($conn === false) {
	//処理エラー画面表示
	$ret = showProcErrorDisp();
	die();	
}else{
	//データベース選択
	mysql_select_db($database_conn, $conn);
}

//申込内容データベース登録処理
$ret = insert();
$ret = 0;
if ($ret == 1 ){
	//処理エラー画面表示
	$ret = showProcErrorDisp();
	die();
}

//確認メール送付処理
$ret = mailToOfferor();
$ret = 0;
if ($ret == 1 ){
	//処理エラーDB書き込み
	$ret = error_update();
	//処理エラー画面表示
	$ret = showProcErrorDisp();
	die();
}

//申込完了画面表示
$ret = showThanksDisp();

die();
?>
