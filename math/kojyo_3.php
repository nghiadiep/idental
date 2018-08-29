<?php

#JSのコメントアウトを最後に確認

error_reporting(E_ALL);

require_once('./HTML/QuickForm2.php');
require_once('./Smarty/libs/Smarty.class.php');

#===== 変数定義

#ログファイル名
$v_logfile = '../../kojyolog/'.date('Y-m-d').'.csv';

#Smarty定義
$v_template_dir = './tmpl';
$v_compile_dir  = './tmpl_c';
$v_cache_dir    = './cache';

#===== Smarty
$smarty = new Smarty();
$smarty->template_dir = $v_template_dir;
$smarty->compile_dir  = $v_compile_dir;
$smarty->cache_dir    = $v_cache_dir;

#===== デフォルトの表示
if(!isset($_REQUEST['f_goukei']) || !isset($_REQUEST['f_syotoku']) || !isset($_REQUEST['f_hoten'])){
	$smarty -> assign("default", TRUE);
	$smarty -> display("kojyo.tmpl.html");
	exit;
}

#===== フォームから値を取得
$v_goukei  = getnumvals('f_goukei');
$v_syotoku = getnumvals('f_syotoku');
$v_hoten   = getnumvals('f_hoten');

#===== エラー確認
if($v_goukei===false || $v_goukei<0 || $v_syotoku===false || $v_goukei<0 || $v_goukei<0){
	$smarty -> assign("b_error", TRUE);
	$smarty -> assign("v_goukei"  ,$v_goukei);	#医療費合計
	$smarty -> assign("v_syotoku" ,$v_syotoku);	#所得
	$smarty -> assign("v_hoten"   ,$v_hoten);	#保険
	$smarty -> display("kojyo.tmpl.html");
	exit;
}

#===== 計算

#所得税率
if($v_syotoku<=1950000){
	$v_syotoku_percentage=0.05;
}elseif($v_syotoku>1950000&&$v_syotoku<=3300000){
	$v_syotoku_percentage=0.10;
}elseif($v_syotoku>3300000&&$v_syotoku<=6950000){
	$v_syotoku_percentage=0.20;
}elseif($v_syotoku>6950000&&$v_syotoku<=9000000){
	$v_syotoku_percentage=0.23;
}elseif($v_syotoku>9000000&&$v_syotoku<=18000000){
	$v_syotoku_percentage=0.33;
}elseif($v_syotoku>18000000){
	$v_syotoku_percentage=0.40;
}

#10万円部分の算出(足切り金額10万or所得5%のいずれか)
if($v_syotoku<2000000){
	$v_jyuman=floor($v_syotoku*0.05);
}else{
	$v_jyuman=100000;
}

#医療費控除の対象となる金額の算出
$v_taisyo = $v_goukei-$v_hoten-$v_jyuman;    		#控除対象額を算出
if($v_taisyo<2000000){
	$v_taisyo_kingaku = $v_taisyo;
}else{
	$v_taisyo_kingaku = 2000000;
}

#還付金額と住民税減額分の計算
$v_kanpu_syotoku   = floor($v_taisyo_kingaku*$v_syotoku_percentage);	#
$v_kanpu_jyuminzei = floor($v_taisyo_kingaku*0.1);

#控除総額
$v_kojyo    = $v_kanpu_syotoku+$v_kanpu_jyuminzei;	#控除額を算出
$v_chiryohi = $v_goukei-$v_kojyo;

#===== ログファイル出力
$v_log_contents = date('Y-m-d')
	.",".date('H:i:s')
	.",".$_SERVER["REMOTE_ADDR"]
	.",".$v_goukei
	.",".$v_syotoku
	.",".$v_hoten
	."\n";
file_put_contents($v_logfile, $v_log_contents, FILE_APPEND);


#===== Smarty
$smarty -> assign("v_goukei"  ,$v_goukei);	#医療費合計
$smarty -> assign("v_syotoku" ,$v_syotoku);	#所得
$smarty -> assign("v_hoten"   ,$v_hoten);	#保険
$smarty -> assign("v_kojyo"   ,$v_kojyo);	#控除額
$smarty -> assign("v_taisyo"  ,$v_taisyo_kingaku);	#控除対象額

$smarty -> assign("v_kanpu_syotoku"   ,$v_kanpu_syotoku);   #所得税還付金
$smarty -> assign("v_kanpu_jyuminzei" ,$v_kanpu_jyuminzei); #住民税還付金

$smarty -> assign("v_chiryohi"        ,$v_chiryohi);        #実際の治療費

$smarty -> display("kojyo.tmpl.html");

#数字を$_REQUESTから取得する
#戻り値：int(),FALSE
function getnumvals($v_data){

	if(is_numeric($_REQUEST[$v_data])){
		return intval($_REQUEST[$v_data]);
	}else{
		return false;
	}
}

?>