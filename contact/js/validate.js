
//ロード対策
$(window).load(function () {


/*
* お問い合わせ内容のチェック ロード対策 必須

*/
if($("#user_name01").val()){
$("#name_icon").html('<img src="img/contact/ico_ok.png" />');
}
if( $("#email").val() ){
$("#email_icon").html('<img src="img/contact/ico_ok.png" />');
}

if( $("#tel").val()){
$("#tel_icon").html('<img src="img/contact/ico_ok.png" />');
}
if($("#otoi1:checked").val()||$("#otoi2:checked").val())
{
$("#contact_icon2").html('<img src="img/contact/ico_ok.png" />');
}
if($("#course1:checked").val()||$("#course2:checked").val()){
$("#contact_icon3").html('<img src="img/contact/ico_ok.png" />');
}


if(!$('#month1').children('option:selected').val().match('選択してください')){
$("#month_icon").html('<img src="img/contact/ico_ok.png" />');

}
if(!$('#lesson').children('option:selected').val().match('選択してください')){
$("#lesson_icon").html('<img src="img/contact/ico_ok.png" />');
}

/*
* ご関心のあるコース 任意
*/




checkALL();

});

/*
* 入力アクション時
*/
$(document).ready(function() {

$(function(){
if (!window.location.pathname.match('/thanks.html')) { // `/path` をアラートを出したくないページのパスに
$(window).on('beforeunload', function() {
return "フォーム入力中の項目があります。\n本当に離脱してよろしいですか？"; 
});
}
});

//お問い合わせ内容
/* for(var i = 1;i < 3;i ++){
$("#otoi"+i).click(function () {
$("#contact_icon2").html('<img src="img/contact/ico_ok.png" />');
checkAddress();
checkALL();
});
} */
var flag02=false;
var flag03=false;
for(var i = 1;i < 3;i ++)
{
$('#otoi1').change(function () {
//alert('test');

if ($('#otoi1').is(':checked') == false) {

flag02=true;
// alert('2'+flag2);
}
else
{
flag02=false;
//alert('2'+flag2);
}
if(flag02&&flag03){
$("#contact_err2").addClass("error_message");
$("#contact_err2").text("一つ選んでください");  
$("#contact_icon2").html('<img src="img/contact/ico_ng.png" />');


checkALL();
} 
else
{
$("#contact_err2").removeClass("error_message");
$("#contact_err2").text("");  

$("#contact_icon2").html('<img src="img/contact/ico_ok.png" />');
checkALL();
}

});
$('#otoi2').change(function () {
//alert('test');
if ($('#otoi2').is(':checked') == false) {

flag03=true;
// alert('3'+flag3);
}
else
{
flag03=false;
//alert('2'+flag3);
}
if(flag02&&flag03){$("#contact_err2").addClass("error_message");
$("#contact_err2").text("一つ選んでください");  
$("#contact_icon2").html('<img src="img/contact/ico_ng.png" />');
checkALL();
}
else
{
$("#contact_err2").removeClass("error_message");
$("#contact_err2").text("");  

$("#contact_icon2").html('<img src="img/contact/ico_ok.png" />');
}	  checkALL();
});

}

/* 	  for(var i = 1;i < 3;i ++){
$("#course"+i).click(function () {
$("#contact_icon3").html('<img src="img/contact/ico_ok.png" />');
checkALL();
});
} */
var flag2=false;
var flag3=false;
for(var i = 1;i < 3;i ++)
{
$('#course1').change(function () {
//alert('test');

if ($('#course1').is(':checked') == false) {

flag2=true;
// alert('2'+flag2);
}
else
{
flag2=false;
//alert('2'+flag2);
}
if(flag2&&flag3){
$("#contact_err").addClass("error_message");
$("#contact_err").text("一つ選んでください");  
$("#contact_icon3").html('<img src="img/contact/ico_ng.png" />');


checkALL();
} 
else
{
$("#contact_err").removeClass("error_message");
$("#contact_err").text("");  

$("#contact_icon3").html('<img src="img/contact/ico_ok.png" />');
checkALL();
}

});
$('#course2').change(function () {
//alert('test');
if ($('#course2').is(':checked') == false) {

flag3=true;
// alert('3'+flag3);
}
else
{
flag3=false;
//alert('2'+flag3);
}
if(flag2&&flag3){$("#contact_err").addClass("error_message");
$("#contact_err").text("一つ選んでください");  
$("#contact_icon3").html('<img src="img/contact/ico_ng.png" />');
checkALL();
}
else
{
$("#contact_err").removeClass("error_message");
$("#contact_err").text("");  

$("#contact_icon3").html('<img src="img/contact/ico_ok.png" />');
}	  checkALL();
});

}	
$('#month1').change(function(){ 
if($(this).children('option:selected').val().match('選択してください')){
$("#month_err").addClass("error_message");
$("#month_err").text("一つ選んでください");  
$("#month_icon").html('<img src="img/contact/ico_ng.png" />');
}
else
{
$("#month_err").removeClass("error_message");
$("#month_err").text("");  

$("#month_icon").html('<img src="img/contact/ico_ok.png" />');
}
checkALL();
})
$('#lesson').change(function(){ 

if($(this).children('option:selected').val().match('選択してください')){
$("#lesson_err").addClass("error_message");
$("#lesson_err").text("一つ選んでください");  
$("#lesson_icon").html('<img src="img/contact/ico_ng.png" />');
}
else
{
$("#lesson_err").removeClass("error_message");
$("#lesson_err").text("");  

$("#lesson_icon").html('<img src="img/contact/ico_ok.png" />');
}
checkALL();	
})
//ご関心のあるコース

//保護者の方の名前
//画面上の入力チェック
$("#user_name01").blur(function () {
var str = $(this).val();
if(str == '') {  
console.log('name error 01');
$("#name_err").addClass("error_message");
$("#name_err").text("お名前を入力してください");  
$("#name_icon").html('<img src="img/contact/ico_ng.png" />');
}
else {
$("#name_err").removeClass("error_message");
$("#name_err").text("");  
$("#user_name").css("background", "#fff"); 
$("#name_icon").html('<img src="img/contact/ico_ok.png" />');
}
checkALL();
});
//tel
$("#tel").blur(function () {
var str = $(this).val();
if(str == '') {  
$("#tel_err").addClass("error_message");
$("#tel_err").text("お電話番号を入力してください");  
$("#tel_icon").html('<img src="img/contact/ico_ng.png" width="30" />');
} else { 
//全角ハイフンをunicodeに置換して削除する
var result = escape( str );
console.log(result);
var phyhun = escape( "ー" );
//console.log(phyhun);
//var result2 = result.replace("/%u2212/g", "");
var result2 = replaceAll(result, "%u2212", ""); 
//console.log(result2);
str = unescape(result2);
var han = str.replace(/[Ａ-Ｚａ-ｚ０-９]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
$(this).val(han);
reObj = new RegExp("[^0-9\-]");       
if (han.match(reObj)) {
$("#tel_err").addClass("error_message");
$("#tel_err").text("電話番号はハイフンと数字のみで入力して下さい。"); 
$("#tel_icon").html('');
}else{
if (han.length <= 8) {
$("#tel_err").addClass("error_message");
$("#tel_err").text("電話番号の桁数が正しくありません。"); 
$("#tel_icon").html('');
}
else {
$("#tel_err").removeClass("error_message");
$("#tel_err").text(""); 
$("#tel").css("background", "#fff"); 
$("#tel_icon").html('<img src="img/contact/ico_ok.png" />');
}
}
}
checkALL();
});
//mail
$("#email").blur(function () {
var str = $(this).val();
if(str == '') {  
$("#email_err").addClass("error_message");
$("#email_err").text("メールアドレスを入力してください"); 
$("#email_icon").html('<img src="img/contact/ico_ng.png" />'); 
console.log('mail balnk error');
}
else if(!str.match( /^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/g)) {  
$("#email_err").addClass("error_message");
$("#email_err").text("正しいメールアドレスを入力してください。");  
$("#email_icon").html('<img src="img/contact/ico_ng.png" />'); 
console.log('mail balnk error2');
}  
else{
$("#email_err").removeClass("error_message");
$("#email_err").text("");  
$("#email").css("background", "#fff"); 
$("#email_icon").html('<img src="img/contact/ico_ok.png" />');

}
checkALL();
});


$('.submitalertoff').click(function(){
$(window).off('beforeunload');
});

});



function checkALL() {
//console.log($("#place_icon").html());
if($("#email_icon").html().match("ico_ok")
&& $("#tel_icon").html().match("ico_ok")
&& $("#contact_icon3").html().match("ico_ok")
&& $("#contact_icon2").html().match("ico_ok")
&& $("#name_icon").html().match("ico_ok")
&& $("#month_icon").html().match("ico_ok")
&& $("#lesson_icon").html().match("ico_ok")	

) {
console.log("ok1");
$(window).off('beforeunload');
$("#bottom").html('<input type="submit" value="確認画面へ" class="btn_contact fsP1 " />');

}
else {
$("#bottom").html('<input type="submit" disabled value="確認画面へ" class="btn_contact2 fsP1"  />');
//console.log("NG");
//$("#bottomBtn").html('<input type="image" src="image/btn_confirm_on.png" class="hover" width="522" height="102" alt="確認画面へ"/>');
}
}

function replaceAll(expression, org, dest){  
return expression.split(org).join(dest);  
　}  

function checkAddress(){
$("#address").blur(function () {
// console.log("Hello world");
var str = $(this).val();
if(str == ''||str=="ご住所") {  
$("#address_err").addClass("error_message");
$("#address_err").text("ご住所を入力してください");  
$("#address_icon").html('<img src="img/contact/ico_ng.png"/>');
}
else {
$("#address_err").removeClass("error_message");
$("#address_err").text("");  
$("#address_name").css("background", "#fff"); 
$("#address_icon").html('<img src="img/contact/ico_ng.png"/>');
}
checkALL();
});

}
