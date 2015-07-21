<?php header("Content-Type:text/html;charset=utf-8"); ?>
<?php //error_reporting(E_ALL | E_STRICT);
###############################################################################################
##
#  PHPメールプログラム　フリー版
#　改造や改変は自己責任で行ってください。
#	
#  今のところ特に問題点はありませんが、不具合等がありましたら下記までご連絡ください。
#  MailAddress: info@php-factory.net
#  name: K.Numata
#  HP: http://www.php-factory.net/
#
#  重要！！サイトでチェックボックスを使用する場合のみですが。。。
#  チェックボックスを使用する場合はinputタグに記述するname属性の値を必ず配列の形にしてください。
#  例　name="当サイトをしったきっかけ[]"  として下さい。
#  nameの値の最後に[と]を付ける。じゃないと複数の値を取得できません！
##
###############################################################################################

// フォームページ内の「名前」と「メール」項目のname属性の値は特に理由がなければ以下が最適です。
// お名前 <input size="30" type="text" name="名前" />　メールアドレス <input size="30" type="text" name="Email" />
// メールアドレスのname属性の値が「Email」ではない場合、または変更したい場合は、以下必須設定箇所の「$Email」の値も変更下さい。


/*
★以下設定時の注意点　
・値（=の後）は数字以外の文字列はすべて（一部を除く）ダブルクオーテーション（"）、またはシングルクォーテーション（'）で囲んでいます。
・これをを外したり削除したりしないでください。後ろのセミコロン「;」も削除しないください。プログラムが動作しなくなります。
・またドルマーク（$）が付いた左側の文字列は絶対に変更しないでください。数字の1または0で設定しているものは必ず半角数字でお願いします。
*/


//---------------------------　必須設定　必ず設定してください　-----------------------

//サイトのトップページのURL　※デフォルトでは送信完了後に「トップページへ戻る」ボタンが表示されますので
$site_top = "http://mionmusic.com";

// 管理者メールアドレス ※メールを受け取るメールアドレス(複数指定する場合は「,」で区切ってください)
$to = "sato.y@cypher-point.co.jp,nweni.aidma@gmail.com";//

//フォームのメールアドレス入力箇所のname属性の値（メール形式チェックに使用。※2重アドレスチェック導入時にも使用します）
$Email = 'E-MAIL';

/*------------------------------------------------------------------------------------------------
以下スパム防止のための設定　※このファイルとフォームページが同一ドメイン内にある必要があります（XSS対策）
------------------------------------------------------------------------------------------------*/

//スパム防止のためのリファラチェック（フォームページが同一ドメインであるかどうかのチェック）(する=1, しない=0)
$Referer_check = 0;

//リファラチェックを「する」場合のドメイン ※以下例を参考に設置するサイトのドメインを指定して下さい。
$Referer_check_domain = "mionmusic.com";

//---------------------------　必須設定　ここまで　------------------------------------


//---------------------- 任意設定　以下は必要に応じて設定してください ------------------------

// このPHPファイルの名前 ※ファイル名を変更した場合は必ずここも変更してください。
$file_name ="mail.php";

// 管理者宛のメールで差出人を送信者のメールアドレスにする(する=1, しない=0)
// する場合は、メール入力欄のname属性の値を「$Email」で指定した値にしてください。
//メーラーなどで返信する場合に便利なので「する」がおすすめです。
$userMail = 1;

// Bccで送るメールアドレス(複数指定する場合は「,」で区切ってください)
$BccMail = "";

// 管理者宛に送信されるメールのタイトル（件名）
$subject = "体験レッスンのお問い合わせ(mionmusic.com)";

// 送信確認画面の表示(する=1, しない=0)
$confirmDsp = 1;

// 送信完了後に自動的に指定のページ(サンクスページなど)に移動する(する=1, しない=0)
// CV率を解析したい場合などはサンクスページを別途用意し、URLをこの下の項目で指定してください。
// 0にすると、デフォルトの送信完了画面が表示されます。
$jumpPage = 1;

// 送信完了後に表示するページURL（上記で1を設定した場合のみ）※httpから始まるURLで指定ください。
$thanksPage = "thanks.html";

// 必須入力項目を設定する(する=1, しない=0)
$esse = 1;

/* 必須入力項目(入力フォームで指定したname属性の値を指定してください。（上記で1を設定した場合のみ）
値はシングルクォーテーションで囲んで下さい。複数指定する場合は「,」で区切ってください)*/
$eles = array('名前','E-MAIL','お電話番号','ご希望の体験レッスン','経験年数','教室','第一希望ご連絡方法','第二希望ご連絡方法');


//----------------------------------------------------------------------
//  自動返信メール設定(START)
//----------------------------------------------------------------------

// 差出人に送信内容確認メール（自動返信メール）を送る(送る=1, 送らない=0)
// 送る場合は、フォーム側のメール入力欄のname属性の値が上記「$Email」で指定した値と同じである必要があります
$remail = 1;

$reto =$_POST['E-MAIL'];

//自動返信メールの送信者欄に表示される名前　※あなたの名前や会社名など（もし自動返信メールの送信者名が文字化けする場合ここは空にしてください）
$refrom_name = "ミオンミュージックスクール";

// 差出人に送信確認メールを送る場合のメールのタイトル（上記で1を設定した場合のみ）
$re_subject = "【ミオンミュージックスクール】お問い合わせ完了のお知らせ";

//フォーム側の「名前」箇所のname属性の値　※自動返信メールの「○○様」の表示で使用します。
//指定しない、または存在しない場合は、○○様と表示されないだけです。あえて無効にしてもOK
$dsp_name = '名前';

//自動返信メールの文言 ※日本語部分は変更可です
$remail_text = <<< TEXT

お問い合わせいただき、ありがとうございます。
下記の内容にて、お問い合わせをお受けいたしました。

折り返し担当者よりご連絡をさせていただきます。
もし、一両日中に返事がない場合は、お手数ですが
info@mionmusic.comまでお問い合わせ下さい。

TEXT;


//自動返信メールに署名を表示(する=1, しない=0)※管理者宛にも表示されます。
$mailFooterDsp = 0;

//上記で「1」を選択時に表示する署名（FOOTER～FOOTER;の間に記述してください）
$mailSignature = <<< FOOTER

──────────────────────
株式会社ミオンミュージック
──────────────────────

FOOTER;


//----------------------------------------------------------------------
//  自動返信メール設定(END)
//----------------------------------------------------------------------


//メールアドレスの形式チェックを行うかどうか。(する=1, しない=0)
//※デフォルトは「する」。特に理由がなければ変更しないで下さい。メール入力欄のname属性の値が上記「$Email」で指定した値である必要があります。
$mail_check = 1;

//------------------------------- 任意設定ここまで ---------------------------------------------



// 以下の変更は知識のある方のみ自己責任でお願いします。

//----------------------------------------------------------------------
//  関数定義(START)
//----------------------------------------------------------------------
function checkMail($str){
	$mailaddress_array = explode('@',$str);
	if(preg_match("/^[\.!#%&\-_0-9a-zA-Z\?\/\+]+\@[!#%&\-_0-9a-z]+(\.[!#%&\-_0-9a-z]+)+$/", "$str") && count($mailaddress_array) ==2){
		return true;
	}
	else{
		return false;
	}
}
function h($string) {
  return htmlspecialchars($string, ENT_QUOTES,'utf-8');
}
function sanitize($arr){
	if(is_array($arr)){
		return array_map('sanitize',$arr);
	}
	return str_replace("\0","",$arr);
}
if(isset($_GET)) $_GET = sanitize($_GET);//NULLバイト除去//
if(isset($_POST)) $_POST = sanitize($_POST);//NULLバイト除去//
if(isset($_COOKIE)) $_COOKIE = sanitize($_COOKIE);//NULLバイト除去//

//----------------------------------------------------------------------
//  関数定義(END)
//----------------------------------------------------------------------
$copyrights = '<a style="display:block;text-align:center;margin:15px 0;font-size:11px;color:#aaa;text-decoration:none" href="http://www.php-factory.net/" target="_blank">- PHP工房 -</a>';

if($Referer_check == 1 && !empty($Referer_check_domain)){
	if(strpos($_SERVER['HTTP_REFERER'],$Referer_check_domain) === false){
		echo '<p align="center">リファラチェックエラー。フォームページのドメインとこのファイルのドメインが一致しません</p>';exit();
	}
}
$sendmail = 0;
$empty_flag = 0;
$post_mail = '';
$errm ='';
$header ='';
foreach($_POST as $key=>$val) {
  if($val == "confirm_submit") $sendmail = 1;
	if($key == $Email && $mail_check == 1){
	  if(!checkMail($val)){
          $errm .= "<p class=\"error_messe\"><span class=\"error_field\">「".$key."」</span>はメールアドレスの形式が正しくありません。</p>\n";
          $empty_flag = 1;
	  }else{
		  $post_mail = h($val);
	  }
	}
}

// 必須設定項目のチェック
if($esse == 1) {
  $length = count($eles) - 1;
  foreach($_POST as $key=>$val) {
    
    if($val == "confirm_submit") ;
    else {
      for($i=0; $i<=$length; $i++) {
        if($key == $eles[$i] && empty($val)) {
          $errm .= "<p class=\"error_messe\"><span class=\"error_field\">「".$key."」</span>は必須入力項目です。</p>\n";
          $empty_flag = 1;
        }
      }
    }
  }
  foreach($_POST as $key=>$val) {
    
    for($i=0; $i<=$length; $i++) {
      if($key == $eles[$i]) {
        $eles[$i] = "confirm_ok";
      }
    }
  }
  for($i=0; $i<=$length; $i++) {
    if($eles[$i] != "confirm_ok") {
      //$errm .= "<p class=\"error_messe\"><span class=\"error_field\">「".$eles[$i]."」</span>が未選択です。</p>\n";
      $eles[$i] = "confirm_ok";
      //$empty_flag = 1;
    }
  }
}
// 管理者宛に届くメールの編集
$body="「".$subject."」からメールが届きました\n\n";
$body.="＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
foreach($_POST as $key=>$val) {
  
  $out = '';
  if(is_array($val)){
  foreach($val as $item){ 
  $out .= $item . ','; 
  }
  if(substr($out,strlen($out) - 1,1) == ',') { 
  $out = substr($out, 0 ,strlen($out) - 1); 
  }
 }else { $out = $val;} //チェックボックス（配列）追記ここまで
  if(get_magic_quotes_gpc()) { $out = stripslashes($out); }
  if($out == "confirm_submit" or $key == "httpReferer") ;
  else $body.="【 ".$key." 】 ".$out."\n";
}
$body.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n";
$body.="送信された日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
$body.="送信者のIPアドレス：".$_SERVER["REMOTE_ADDR"]."\n";
$body.="送信者のホスト名：".getHostByAddr(getenv('REMOTE_ADDR'))."\n";
$body.="問い合わせのページURL：".@$_POST['httpReferer']."\n";
if($mailFooterDsp == 1) $body.= $mailSignature;
//--- 管理者宛に届くメールの編集終了 --->


if($remail == 1) {
//--- 差出人への自動返信メールの編集
if(isset($_POST[$dsp_name])){ $rebody = h($_POST[$dsp_name]). " 様\n";}
$rebody.= $remail_text;
$rebody.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
foreach($_POST as $key=>$val) {
  
  $out = '';
  if(is_array($val)){
  foreach($val as $item){ 
  $out .= $item . ','; 
  }
  if(substr($out,strlen($out) - 1,1) == ',') { 
  $out = substr($out, 0 ,strlen($out) - 1); 
  }
 }else { $out = $val; }//チェックボックス（配列）追記ここまで
  if(get_magic_quotes_gpc()) { $out = stripslashes($out); }
  if($out == "confirm_submit" or $key == "httpReferer") ;
  else $rebody.="【 ".$key." 】 ".$out."\n";
}
$rebody.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
//$rebody.="送信日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
$rebody.="音楽を楽しく学ぶならミオンミュージックへ！\n\n

【東中野教室（ギター・ピアノ・ボーカル）】\n
〒164-0003\n
東京都中野区東中野1-14-24 吉井ビルB1\n
TEL＆FAX: 03-5348-0717\n
受付時間：10:00〜21:00\n\n

【東中野教室（ピアノ）】\n
〒164-0003\n
東京都中野区東中野1-45-9 宮原ビル4F\n
TEL＆FAX: 03-5937-5547\n
受付時間：10:00〜21:00\n\n

【下北沢教室（ギター・ボーカル）】\n
〒155-0031\n
東京都世田谷区北沢3-34-6 北沢グリーンビル2F\n
TEL＆FAX: 03-3467-4233\n
受付時間：10:00〜21:00\n\n

-----------------------------------------------------------------------\n
※なお、このメールはシステムより自動送信されています。\n
不明点等ありましたら、お手数ですが\n
info@mionmusic.comまでお問い合わせ下さい。\n\n";
if($mailFooterDsp == 1) $rebody.= $mailSignature;
$reto = $post_mail;
$rebody=mb_convert_encoding($rebody,"JIS","utf-8");
$re_subject="=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($re_subject,"JIS","utf-8"))."?=";

	if(!empty($refrom_name)){
	
		$default_internal_encode = mb_internal_encoding();
		if($default_internal_encode != 'utf-8'){
		  mb_internal_encoding('utf-8');
		}
		$reheader="From: ".mb_encode_mimeheader($refrom_name)." <".$to.">\nReply-To: ".$reto."\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
	
	}else{
		$reheader="From: $reto\nReply-To: ".$reto."\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
	}
}
$body=mb_convert_encoding($body,"JIS","utf-8");
$subject="=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($subject,"JIS","utf-8"))."?=";

if($userMail == 1 && !empty($post_mail)) {
  $from = $post_mail;
  $header="From: $from\n";
	  if($BccMail != '') {
		$header.="Bcc: $BccMail\n";
	  }
	$header.="Reply-To: ".$from."\n";
}else {
	  if($BccMail != '') {
		$header="Bcc: $BccMail\n";
	  }
	$header.="Reply-To: ".$to."\n";
}
	$header.="Content-Type:text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
  

if(($confirmDsp == 0 || $sendmail == 1) && $empty_flag != 1){
  mail($to,$subject,$body,$header);
  if($remail == 1) { mail($reto,$re_subject,$rebody,$reheader); }
}
else if($confirmDsp == 1){ 


/*　▼▼▼送信確認画面のレイアウト※編集可　オリジナルのデザインも適用可能▼▼▼　*/
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<title>お問い合わせ｜ミオンミュージック</title>
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
<link rel="shortcut icon" href="common/img/favicon.png" type="images/favicon.png" />
<link rel="stylesheet" type="text/css" href="common/css/import.css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="common/js/jquery.min.js"></script>
<script type="text/javascript" src="common/js/smart-crossfade.js"></script>
<script type="text/javascript" src="common/js/jquery.js"></script>
<script type="text/javascript" src="common/js/swingcircle.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script  type="text/javascript">
$(document).ready(function() {
$("#menu_rate").mouseenter(function() {
		$(".sp_menu_rate").show('slow');
}).mouseleave(function() {

$(".sp_menu_rate").hide('slow');
});
$(function() {
var fNavi = $('.ftNavWrap');
fNavi.hide();
$(window).scroll(function () {
if ($(this).scrollTop() > 200) {
fNavi.fadeIn();
} else {
fNavi.fadeOut();
}
});
});
});
</script>
</head>
<body>
<a name="top" id="top"></a>
<header>
<div class="logoImg">
<a href="http://www.mionmusic.com/"><img src="common/img/header_logo.gif" alt="mion music school" width="269"/></a>
</div>
</header>
<!--/ id mainImgWrap-->
<nav>
<div class="gNav clearfix">
<ul class="gNavIn clearfix">
<li id="nav01"><a href="http://www.mionmusic.com/reason"><img src="common/img/gnav01_off.gif" alt="ミオンが選ばれる7つの理由"/></a></li>
<li><a href="http://www.mionmusic.com/teacher"><img src="common/img/gnav02_off.gif" alt="講師のご紹介"/></a></li>
<li><a href="http://www.mionmusic.com/service"><img src="common/img/gnav03_off.gif" alt="料金・サービス"/></a></li>
<li><a href="http://www.mionmusic.com/access"><img src="common/img/gnav04_off.gif" alt="アクセス・会社概要"/></a></li>
<li id="menu_rate"><a href="http://www.mionmusic.com/#" ><img src="common/img/gnav05_off.gif" alt=""/></a>
<ul class="sp_menu_rate clearfix">
<li><a href="http://www.mionmusic.com/guitar"><img src="common/img/sub_menu01.gif" alt="ギターレッスン"></a></li>
<li><a href="http://www.mionmusic.com/piano"><img src="common/img/sub_menu02.gif" alt="ピアノレッスン"></a></li>
<li><a href="http://www.mionmusic.com/vocal"><img src="common/img/sub_menu03.gif" alt="ボーカルレッスン"></a></li>
</ul>
</li>
<li><a href="http://www.mionmusic.com/voice"><img src="common/img/gnav06_off.gif" alt="生徒さんの声"/></a></li>
<li><a href="http://www.mionmusic.com/faq"><img src="common/img/gnav07_off.gif" alt="よくあるご質問"/></a></li>
</ul>
</div>
</nav>
<div id="contentsWrap">
<div id="contents" > 
<div class="contentsInner clearfix">
 <div id="breadcumb">
<span><a href="http://www.mionmusic.com">HOME</a> &gt;</span> <span class="bold">お問い合わせ</span>
 </div>
 <div class="contact" id="trc">
	<article id="content" class="thanks">
		<div id="main_visual">
			<h1 class="mt10">体験レッスンお申し込み</h1>
			<img src="img/contact/contact_heading.png" alt="体験レッスンお申し込み">
		</div>
		
			<h4 class="contact_ttl_underline pt80">入力内容のご確認</h4>

<!-- ▲ Headerやその他コンテンツなど　※編集可 ▲-->

<!-- ▼************ 送信内容表示部　※編集は自己責任で ************ ▼-->
<?php if($empty_flag == 1){ ?>
			<p>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</p>
			<?php echo $errm; ?>
			<input type="button" value="入力画面に戻る" class="btn_back" onClick="history.back()">

<?php
		}else{
?>

			<p  class="fts20 alc mt25">記入事項をご確認のうえ、問題がなければ「送信する」をクリックしてください。</p>
			<form action="<?php echo $file_name; ?>" method="POST">
			<table>
			<?php
			foreach($_POST as $key=>$val) {
			  $out = '';
			  if(is_array($val)){
			  foreach($val as $item){ 
			  $out .= $item . ','; 
			  }
			  if(substr($out,strlen($out) - 1,1) == ',') { 
			  $out = substr($out, 0 ,strlen($out) - 1); 
			  }
			 }
			  else { $out = $val; }//チェックボックス（配列）追記ここまで
			  if(get_magic_quotes_gpc()) { $out = stripslashes($out); }
			  $out = h($out);
			  $out=nl2br($out);//※追記 改行コードを<br>タグに変換
			  $key = h($key);
			  print("<div class=\"field\"><p class=\"fsM1\"><b>".$key."</b></p><p class=\"fsM2\">".$out);
			  $out=str_replace("<br />","",$out);//※追記 メール送信時には<br>タグを削除
			?>
			<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $out; ?>">
			<?php
			  print("</p></div>\n");
			}
			?>
			</table><br>
			<div align="center"><input type="hidden" name="mail_set" value="confirm_submit">
			<input type="hidden" name="httpReferer" value="<?php echo $_SERVER['HTTP_REFERER'] ;?>">
			<input type="button" value="入力画面に戻る" class="btn_back" onClick="history.back()">
			<input type="submit" value="送信する" class="btn_send">
			</div>
			</form>
<?php } ?>
<!-- ▲ *********** 送信内容確認部　※編集は自己責任で ************ ▲-->

<!-- ▼ Footerその他コンテンツなど　※編集可 ▼-->
		</div>
	</article>
	</div>
	</div>
	</div>
	</div>
<footer>
<div id="footerWrap">
<div class="copyrightWrap" style="padding: 25px 0px 25px 0px;">
<a href="http://www.mionmusic.com/privancy">プライバシーポリシー</a>
<p class="copyright">Copyright(C)mion music All Rights Reserved.</p>
</div>
</div>
</div>
<!--/ id contentsWrap-->
<!--/ id footerWrap-->
</footer>
</div>
</body>
</html>
<?php
/* ▲▲▲送信確認画面のレイアウト　※オリジナルのデザインも適用可能▲▲▲　*/
}


if(($jumpPage == 0 && $sendmail == 1) || ($jumpPage == 0 && ($confirmDsp == 0 && $sendmail == 0))) { 

/* ▼▼▼送信完了画面のレイアウト　編集可 ※送信完了後に指定のページに移動しない場合のみ表示▼▼▼　*/
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<title>お問い合わせ｜ミオンミュージック</title>
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
<link rel="shortcut icon" href="common/img/favicon.png" type="images/favicon.png" />
<link rel="stylesheet" type="text/css" href="common/css/import.css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="common/js/jquery.min.js"></script>
<script type="text/javascript" src="common/js/smart-crossfade.js"></script>
<script type="text/javascript" src="common/js/jquery.js"></script>
<script type="text/javascript" src="common/js/swingcircle.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script  type="text/javascript">
$(document).ready(function() {
$("#menu_rate").mouseenter(function() {
		$(".sp_menu_rate").show('slow');
}).mouseleave(function() {

$(".sp_menu_rate").hide('slow');
});
$(function() {
var fNavi = $('.ftNavWrap');
fNavi.hide();
$(window).scroll(function () {
if ($(this).scrollTop() > 200) {
fNavi.fadeIn();
} else {
fNavi.fadeOut();
}
});
});
});
</script>
</head>
<body>
<a name="top" id="top"></a>
<header>
<div class="logoImg">
<a href="http://www.mionmusic.com/"><img src="common/img/header_logo.gif" alt="mion music school" width="269"/></a>
</div>
</header>
<!--/ id mainImgWrap-->
<nav>
<div class="gNav clearfix">
<ul class="gNavIn clearfix">
<li id="nav01"><a href="http://www.mionmusic.com/reason"><img src="common/img/gnav01_off.gif" alt="ミオンが選ばれる7つの理由"/></a></li>
<li><a href="http://www.mionmusic.com/teacher"><img src="common/img/gnav02_off.gif" alt="講師のご紹介"/></a></li>
<li><a href="http://www.mionmusic.com/service"><img src="common/img/gnav03_off.gif" alt="料金・サービス"/></a></li>
<li><a href="http://www.mionmusic.com/access"><img src="common/img/gnav04_off.gif" alt="アクセス・会社概要"/></a></li>
<li id="menu_rate"><a href="http://www.mionmusic.com/#" ><img src="common/img/gnav05_off.gif" alt=""/></a>
<ul class="sp_menu_rate clearfix">
<li><a href="http://www.mionmusic.com/guitar"><img src="common/img/sub_menu01.gif" alt="ギターレッスン"></a></li>
<li><a href="http://www.mionmusic.com/piano"><img src="common/img/sub_menu02.gif" alt="ピアノレッスン"></a></li>
<li><a href="http://www.mionmusic.com/vocal"><img src="common/img/sub_menu03.gif" alt="ボーカルレッスン"></a></li>
</ul>
</li>
<li><a href="http://www.mionmusic.com/voice"><img src="common/img/gnav06_off.gif" alt="生徒さんの声"/></a></li>
<li><a href="http://www.mionmusic.com/faq"><img src="common/img/gnav07_off.gif" alt="よくあるご質問"/></a></li>
</ul>
</div>
</nav>
<div id="contentsWrap">
<div id="contents" > 
<div class="contentsInner clearfix">
 <div id="breadcumb">
<span><a href="http://www.mionmusic.com">HOME</a> &gt;</span> <span class="bold">お問い合わせ</span>
 </div>
<div align="center">
<?php if($empty_flag == 1){ ?>
<h3>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h3><?php echo $errm; ?><br><br><input type="button" value=" 前画面に戻る " onClick="history.back()">
<?php
  }else{
?>
送信ありがとうございました。<br>
送信は正常に完了しました。<br><br>
<a href="<?php echo $site_top ;?>">トップページへ戻る⇒</a>
</div>
</div>
</div>
</div>
<?php if(!empty($copyrights)) echo $copyrights; ?>
<!--  CV率を計測する場合ここにAnalyticsコードを貼り付け -->
</body>
</html>
<?php 
/* ▲▲▲送信完了画面のレイアウト 編集可 ※送信完了後に指定のページに移動しない場合のみ表示▲▲▲　*/
  }
}
//完了時、指定のページに移動する設定の場合、指定ページヘリダイレクト
else if(($jumpPage == 1 && $sendmail == 1) || $confirmDsp == 0) { 
	 if($empty_flag == 1){ ?>
<div align="center"><h3>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h3><?php echo $errm; ?><br><br><input type="button" value=" 前画面に戻る " onClick="history.back()"></div>
<?php }else{ header("Location: ".$thanksPage); }
} ?>
