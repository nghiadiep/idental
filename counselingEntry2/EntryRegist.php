<?php
require_once("Preconn.php");
require_once("functions.inc.php");

/**
 * Web�J�E���Z�����O�\������ �T�[�o�T�C�h����.
 * <p>Web�J�E���Z�����O�\�����݃t�H�[���A����ѐ\�����ݏ��������e�i���X����Ǘ��@�\�̃T�[�o�T�C�h����</p>
 *
 * @author 2011 I DENTAL CLINIC. Allright Reserved.
 */

$filter_type = "text";


/**
 * ���[���A�h���X�Ó����`�F�b�N�֐�.
 * <p>���[���A�h���X�̑Ó����`�F�b�N�֐�</p>
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
 * �d�b�ԍ��Ó����`�F�b�N�֐�.
 * <p>�d�b�ԍ��̑Ó����`�F�b�N�֐�</p>
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
 * �S�p�J�i�Ó����`�F�b�N�֐�.
 * <p>�d�b�ԍ��̑Ó����`�F�b�N�֐�</p>
 *
 */	
function is_kana($text) {
	if (mb_ereg_match('/^[�@-���[]+$/', $text)) {  
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * �X�֔ԍ��Ó����`�F�b�N�֐�.
 * <p>�d�b�ԍ��̑Ó����`�F�b�N�֐�</p>
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
 * HTTP�p�����[�^�m�F�֐�.
 * <p>Web�J�E���Z�����O�\�����݃t�H�[���̃��N�G�X�g�m�F�֐�</p>
 *
 */
function showParameter() {
		echo "�����i���j�@�@�@�@�@�@�F";
		echo $_REQUEST["OFFEROR_FAMILY_NAME"],"<br />";
		echo "�����i���j�@�@�@�@�@�@�F";
		echo $_REQUEST["OFFEROR_FIRST_NAME"],"<br />";
		echo "�����J�i�i���j�@�@�@�@�F";
		echo $_REQUEST["OFFEROR_FAMILY_NAME_FURIGANA"],"<br />";
		echo "�����J�i�i���j�@�@�@�@�F";
		echo $_REQUEST["OFFEROR_FIRST_NAME_FURIGANA"],"<br />";
		echo "���ʁ@�@�@�@�@�@�@�@�@�F";
		echo $_REQUEST["OFFEROR_SEX"],"<br />";
		echo "�N��@�@�@�@�@�@�@�@�@�F";
		echo $_REQUEST["OFFEROR_AGE"],"<br />";
		echo "�E�Ɓ@�@�@�@�@�@�@�@�@�F";
		echo $_REQUEST["JOB"],"<br />";
		echo "�X�֔ԍ��@�@�@�@�@�@�@�F";
		echo $_REQUEST["ZIP_CODE"],"<br />";
		echo "�Z���P�i�s���{���j�@�@�F";
		echo $_REQUEST["ADDRESS_1"],"<br />";
		echo "�Z���Q�@�@�@�@�@�@�@�@�F";
		echo $_REQUEST["ADDRESS_2"],"<br />";
		echo "�Z���R�@�@�@�@�@�@�@�@�F";
		echo $_REQUEST["ADDRESS_3"],"<br />";
		echo "�d�b�ԍ��@�@�@�@�@�@�@�F";
		echo $_REQUEST["TEL_NO"],"<br />";
		echo "���[���A�h���X�@�@�@�@�F";
		echo $_REQUEST["EMAIL_ADDRESS"],"<br />";
		echo "�₢���킹�����@�@�@�@�F";
		echo $_REQUEST["INQUIRY"],"<br />";
		echo "�J�E���Z�����O���_�@�@�F";
		echo $_REQUEST["COUNSELING_PLACE"],"<br />";
		echo "�\������i�P�j�@�@�@�@�F";
		echo $_REQUEST["REQUEST_DATETIME_1"],"<br />";
		echo "�\������i�Q�j�@�@�@�@�F";
		echo $_REQUEST["REQUEST_DATETIME_2"],"<br />";
		echo "�\������i�R�j�@�@�@�@�F";
		echo $_REQUEST["REQUEST_DATETIME_3"],"<br />";
		echo "����]�E�j���@�@�@�@�F";
		echo $_REQUEST["REQUEST_DAY_KIND1"],"<br />";
		echo "����]�E���ԑс@�@�@�F";
		echo $_REQUEST["REQUEST_TIMEZONE1"],"<br />";
		echo "����]�E�j���@�@�@�@�F";
		echo $_REQUEST["REQUEST_DAY_KIND2"],"<br />";
		echo "����]�E���ԑс@�@�@�F";
		echo $_REQUEST["REQUEST_TIMEZONE2"],"<br />";
		echo "��O��]�E�j���@�@�@�@�F";
		echo $_REQUEST["REQUEST_DAY_KIND3"],"<br />";
		echo "��O��]�E���ԑс@�@�@�F";
		echo $_REQUEST["REQUEST_TIMEZONE3"],"<br />";
		echo "�ȑO�Ƀ��[������t���O�F";
		echo $_REQUEST["CONSUL_MAIL_USED"],"<br />";
		echo "�m��X�e�[�^�X�@�@�@�@�F";
		echo $_REQUEST["RESERV_FIX_STATUS"],"<br />";
		echo "�m��\������@�@�@�@�@�F";
		echo $_REQUEST["RESERV_FIX_DATETIME"],"<br />";
		echo "�m��Ή��X�^�b�t�@�@�@�F";
		echo $_REQUEST["RESERV_FIX_STAFF"],"<br />";
		echo "�A�N�Z�XIP�A�h���X�@�@�F";
		echo @gethostbyaddr($_SERVER["REMOTE_ADDR"]),"<br />";
		echo "�A�N�Z�XUSER AGENT�@�@�F";
		echo $_SERVER["HTTP_USER_AGENT"],"<br />";
		echo "�폜�t���O�@�@�@�@�@�@�F";
		echo $_REQUEST["IS_DELETE"],"<br />";
	
		return 1;
}


/**
 * ���N�G�X�g�ϐ��̑Ó����`�F�b�N�֐�.
 * <p>Web�J�E���Z�����O�\�����݃t�H�[���̃��N�G�X�g�ϐ��̓��e��o�^�O�Ƀ`�F�b�N����֐�</p>
 *
 */
function RequestCheck() {

		//���[���A�h���X�`�F�b�N
		if (!is_mail($_REQUEST["EMAIL_ADDRESS"])) {
			return '���[���A�h���X�̓��͓��e������������܂���B';
		}
		
		//�J�i�`�F�b�N
//		if (!is_kana($_REQUEST["OFFEROR_FAMILY_NAME_FURIGANA"])) {
//			return '�����J�i�͑S�p�J�^�J�i�œ��͂��Ă��������B';
//		}
//		if (!is_kana($_REQUEST["OFFEROR_FIRST_NAME_FURIGANA"])) {
//			return '�����J�i�͑S�p�J�^�J�i�œ��͂��Ă��������B';
//		}

		//�d�b�ԍ��`�F�b�N
		if (!is_tel($_REQUEST["TEL_NO"])) {
			return '�d�b�ԍ��̓��͌`��������������܂���B';
		}
		return "TRUE";
}


/**
 * �\���f�[�^�f�[�^�x�[�X�o�^�֐�.
 * <p>Web�J�E���Z�����O�\�����݃f�[�^���f�[�^�x�[�X�̃e�[�u���ɓo�^����֐�</p>
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
				"NULL", # // STAFF_MEMO(�X�^�b�t�����J�����Ȃ̂ŁA��ɋ󕶎����Z�b�g)
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
 * �\���m�F���[�����M�֐�.
 * <p>�t�H�[������̓o�^���e��\�����ݎ҈��Ƀ��[�����M����B</p>
 *
 */
function mailToOfferor() 
{
	global $conn;

	// �ݒ�
	$mail_to = $_REQUEST['EMAIL_ADDRESS']; // �t�H�[���f�[�^���󂯎�郁�[���A�h���X
	$mail_subject = '�J�E���Z�����O�\�����݁@���肪�Ƃ��������܂�'; 
	$mail_bcc = 'soudan@identalclinic.jp,unyou@kwm.co.jp'; // BCC�Ŏ󂯎�肪�K�v�ȏꍇ�͐ݒ�
	$internal_enc = 'SJIS'; // �����G���R�[�h
//	$internal_enc = 'UTF-8'; // �����G���R�[�h

	mb_language('ja');
	mb_internal_encoding($internal_enc);
	$x_mailer = 'PreReserv SendMailer ver 1.0';
	$mode = $_POST['mode'];

	// ���[���w�b�_
	$mail_from = 'PreReservSendmailer@identalclinic.jp';		//����
	$mail_header  = "From: {$mail_from}\n";
	if ($mail_bcc) $mail_header .= "Bcc: {$mail_bcc}\n";
	$mail_header .= "X-Mailer: {$x_mailer}";

	// ���[���{���̕ҏW
	// ����
	$offeror = $_REQUEST['OFFEROR_FAMILY_NAME']." ".$_REQUEST['OFFEROR_FIRST_NAME'];

	// �����t���K�i
	$offeror_furigana = $_REQUEST['OFFEROR_FAMILY_NAME_FURIGANA']." ".$_REQUEST['OFFEROR_FIRST_NAME_FURIGANA'];

	// �J�E���Z�����O��]�n
	$councelingPlace = $_REQUEST['COUNSELING_PLACE'];
	
	// �����E�j���E���ԑ�
	$requestDate1 = "";
	$requestDate2 = "";
	$requestDate3 = "";

	if(strlen($_REQUEST["REQUEST_DAY_KIND1"])>0) 
	{
		$requestDate1 .= $_REQUEST["REQUEST_DAY_KIND1"] . " �� ";
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
		$requestDate2 .= $_REQUEST["REQUEST_DAY_KIND2"] . " �� ";
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
		$requestDate3 .= $_REQUEST["REQUEST_DAY_KIND3"] . " �� ";
	}
	if(strlen($_REQUEST["REQUEST_TIMEZONE3"])>0) 
	{
		$requestDate3 .= $_REQUEST["REQUEST_TIMEZONE3"];
	}
	else 
	{
		$requestDate3 = substr($requestDate3, 0, strlen($requestDate3)-4);
	}

	
	// �����k���e
	$inquiry = stripslashes($_REQUEST['INQUIRY']);

	// �ߋ��ɖ������k���[���𗘗p�������Ƃ����邩�ǂ���
	$mailUsed			= "";
	if($_REQUEST["CONSUL_MAIL_USED"]=="1") 
	{
		$mailUsed		= "�L";
	}
	else 
	{
		$mailUsed		= "��";
	}

	$address			= $_REQUEST["ADDRESS_1"];

	// ���[�����M
	require ('./template.php');
	$mail_message = html_entity_decode($mail_message, ENT_QUOTES, $internal_enc);
	$mail_message = str_replace("<br />", "", $mail_message);
	$mail_message = str_replace("\t", "\n", $mail_message);
	$mail_message = mb_convert_encoding($mail_message, $internal_enc, 'AUTO');
	mb_send_mail($mail_to, $mail_subject, $mail_message, $mail_header);
}


/**
 * ���[�����M�G���[��DB�X�V�֐�.
 *
 */
function error_update() {

	return 0;
}

/**
 * �\���m�F��ʕ\���֐�.
 * <p>�t�H�[������̓o�^���e�m�F��ʂ�\������B</p>
 *
 */

function showInputCheckDisp() {

	    readfile('./template_head02.html');

		echo '<!-- pan -->';
		echo '<div id="pan">';
		echo '<p><a href="http://www.identalclinic.jp/">�C���v�����g�Ȃ�A�C�f���^���N���j�b�N�@�g�b�v�y�[�W</a> > �J�E���Z�����O�\��t�H�[��</p>';
		echo '</div>';
		echo '<!-- /pan -->';

		echo '	<!-- mailform -->';
		echo '<div id="mailform">';
		echo '<h2><img src="../imgs/entry/ti_1.gif" alt="���񂵂񑊒k ���@�O�̖������[�����k �������k���[���t�H�[��" /></h2>';

		echo '	<!-- inner -->';
		echo '<div class="inner">';

		echo '	<h3>���ӏ������悭�ǂ�ł��瓊�e���������B</h3>';
		echo '<p>'.$_REQUEST["OFFEROR_FAMILY_NAME"].' '.$_REQUEST[OFFEROR_FIRST_NAME].' �l<br />';
		echo '������̓��e�ŃJ�E���Z�����O�̓��������������Ă��������܂��B</p>';

		echo '	<form method="post" action="./EntryRegist.php" name="form01">';
		echo '<table cellspacing="0" cellpadding="0">';
		echo '	<tr>';
		echo '		<tr><th>�J�E���Z�����O��]</th><td>'.$_REQUEST[COUNSELING_PLACE].'</td></tr>';

		if(strlen($_REQUEST["REQUEST_DAY_KIND1"])>0) { 
			echo '		<tr><th>��]����j���E���ԑ�1�F</th><td>'.$_REQUEST[REQUEST_DAY_KIND1];

			if(strlen($_REQUEST["REQUEST_TIMEZONE1"])>0) {
				echo ' �� '.$_REQUEST[REQUEST_TIMEZONE1].'</td></tr>';
			}
		} else {
			echo '		<tr><th>��]����j���E���ԑ�1�F';
		}

		if(strlen($_REQUEST["REQUEST_DAY_KIND2"])>0) {
			echo '		<tr><th>��]����j���E���ԑ�2�F</th><td>'.$_REQUEST[REQUEST_DAY_KIND2] ;

			if(strlen($_REQUEST["REQUEST_TIMEZONE2"])>0) {
				echo '�� '.$_REQUEST[REQUEST_TIMEZONE2].'</td></tr>';
			}
		} else {
			echo '		<tr><th>��]����j���E���ԑ�2�F';
		}

		if(strlen($_REQUEST["REQUEST_DAY_KIND3"])>0) {
			echo '		<tr><th>��]����j���E���ԑ�3�F</th><td>'.$_REQUEST[REQUEST_DAY_KIND3];

			if(strlen($_REQUEST["REQUEST_TIMEZONE3"])>0) {
				echo ' �� '.$_REQUEST[REQUEST_TIMEZONE3].'</td></tr>';
			}

		} else {
			echo '		<tr><th>��]����j���E���ԑ�3�F';
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
		echo '	<p>�����\���<span style="color:#09c">�����炩��܂�Ԃ����d�b�����������Ă�������</span>�m�F�������Ă��������ď��߂Ċ����ƂȂ�܂��B';
		echo '	���M�������������ł�<span style="color:#09c">�\��͊������Ă���܂���̂�</span>���̓_�����������������܂��悤��낵�����肢�������܂��B<br />';
		echo '	���\�����e�ɂ��Ă͂��w��̃��[���A�h���X�i'.$_REQUEST[EMAIL_ADDRESS].'�j�ɑ��M�����Ă��������܂��B<br />';
		echo '	���J�E���Z�����O�̓��������ɂ��Ă͂��w��̓d�b�ԍ��i'.$_REQUEST[TEL_NO].'�j�ɓ��@�X�^�b�t���A���������܂��B</p><br />';
		echo '	<div class="bg"><input value="���ǂ�" onclick="history.back();" type="button"> <input type="submit" value="���̓��e�Ő\�����݂܂�" /></div>';
		echo '</form>';

		echo '	</div>';
		echo '<!-- /inner -->';

		echo '	</div>';
		echo '<!-- /mailform -->';

	    readfile('./template_footer.html');

	return 0;
}


/**
 * ���̓G���[��ʕ\���֐�.
 * <p>���N�G�X�g�ϐ��`�F�b�N���̃G���[���e��\��������</p>
 *
 */
function showInputErrorDisp($text) {
    readfile('./template_head02.html');


		echo '<!-- pan -->';
		echo '<div id="pan">';
		echo '<p><a href="http://www.identalclinic.jp/">�C���v�����g�Ȃ�A�C�f���^���N���j�b�N�@�g�b�v�y�[�W</a> > �J�E���Z�����O�\��t�H�[�����̓G���[</p>';
		echo '</div>';
		echo '<!-- /pan -->';

		echo '	<!-- mailform -->';
		echo '<div id="mailform">';
		echo '<h2><img src="../imgs/mailform/ttl02.gif" alt="���񂵂񑊒k ���@�O�̖������[�����k �������k���[���t�H�[��" /></h2><br />';

		echo '	<!-- inner -->';
		echo '<div class="inner">';

		echo '	<h3>���͓��e���m�F���������B</h3>';
		echo '<p>'.$text.'</p>';

		echo '	<form method="post" action="" name="form01">';
		echo '	<div class="bg"><input value="���ǂ�" onclick="history.back();" type="button"></div>';
		echo '  </form>';

		echo '	</div>';
		echo '<!-- /inner -->';

		echo '	</div>';
		echo '<!-- /mailform -->';
	

    readfile('./template_footer.html');

	return 0;
}

/**
 * �f�[�^�x�[�X�����G���[��ʕ\���֐�.
 * <p>���N�G�X�g�ϐ��`�F�b�N���̃G���[���e��\��������</p>
 *
 */
function showProcErrorDisp() {
    readfile('./template_head02.html');
	

		echo '<!-- pan -->';
		echo '<div id="pan">';
		echo '<p><a href="http://www.identalclinic.jp/">�C���v�����g�Ȃ�A�C�f���^���N���j�b�N�@�g�b�v�y�[�W</a> > �J�E���Z�����O�\��t�H�[�����̓G���[</p>';
		echo '</div>';
		echo '<!-- /pan -->';

		echo '	<!-- mailform -->';
		echo '<div id="mailform">';
		echo '<h2 class="ti_1"><img src="../imgs/entry/ti_1.gif" alt="���񂵂񑊒k ���@�O�̖������[�����k �������k���[���t�H�[��"></h2>';

		echo '	<!-- inner -->';
		echo '<div class="inner">';

		echo '�\�����ݏ����ɂăG���[���������܂����B';

		echo '	<form method="post" action="" name="form01">';
		echo '	<div class="bg"><input value="���ǂ�" onclick="history.back();" type="button"></div>';
		echo '  </form>';

		echo '	</div>';
		echo '<!-- /inner -->';

		echo '	</div>';
		echo '<!-- /mailform -->';
	
    readfile('./template_footer.html');
	return 0;

}


/**
 * �o�^������ʕ\���֐�.
 * <p>�\���o�^������ʂ�\������ւ���B</p>
 *
 */
function showThanksDisp() {
    readfile('./template_head02.html');
	readfile('./template_thanks.html');
    readfile('./template_footer.html');
	return 0;
}

/**
 * �ȉ��A���C������
 *
 */

//�\���m�F��ʂ̕\��
if ($_REQUEST["METHOD"]=="") {
	//�`�F�b�N�֐�
	//showParameter();
	$ret = RequestCheck();
	if ($ret == "TRUE") {
		//�m�F��ʕ\��
		$ret = showInputCheckDisp();
	} else {
		//���̓G���[��ʕ\��	
		showInputErrorDisp($ret) ;
	}
	die();
}

//�f�[�^�x�[�X�ڑ�����
if ($conn === false) {
	//�����G���[��ʕ\��
	$ret = showProcErrorDisp();
	die();	
}else{
	//�f�[�^�x�[�X�I��
	mysql_select_db($database_conn, $conn);
}

//�\�����e�f�[�^�x�[�X�o�^����
$ret = insert();
$ret = 0;
if ($ret == 1 ){
	//�����G���[��ʕ\��
	$ret = showProcErrorDisp();
	die();
}

//�m�F���[�����t����
$ret = mailToOfferor();
$ret = 0;
if ($ret == 1 ){
	//�����G���[DB��������
	$ret = error_update();
	//�����G���[��ʕ\��
	$ret = showProcErrorDisp();
	die();
}

//�\��������ʕ\��
$ret = showThanksDisp();

die();
?>
