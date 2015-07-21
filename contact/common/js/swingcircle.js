// forked from atama_switch's "canvasで揺れる円の描画" http://jsdo.it/atama_switch/29Om
// --------------------------------------------------------------------------- //
// requestAnimationFrame
var contentsID=4;
var imgarr= new Array()
 
$(function() {

	setback()
	init()
	
})

$(window).resize(function () {
	setback()
}); 

var imgarr = new Array();
var zindex=20;

$(document).ready(function() {
	 $('.back').hover(
			function(){
				$("img",this).stop().animate({'margin-left' : '-10px'},200,'easeOutElastic');
			},
			function () {
				$("img",this).stop().animate({'margin-left' : '-30px'},200,'easeOutElastic');
			});	
			
});

 function setback() { 
  var st=$(window).height()/2-21;
	$('.back').css("top",st);
  }
 
 
 function init() { 
//var imgarr=["1.jpg","2.jpg","2.jpg","2.jpg","2.jpg","2.jpg","2.jpg","2.jpg","2.jpg","2.jpg","2.jpg","2.jpg","2.jpg","1.jpg","2.jpg","2.jpg","2.jpg","2.jpg","2.jpg","2.jpg","2.jpg","2.jpg","2.jpg"]


$('.circle').each(function(i) {

imgarr.push($('.canimg').eq(i).attr('src'))  

var canvas = $('canvas')[i].getContext('2d');  
window.requestAnimationFrame = (function(){
                                    return window.requestAnimationFrame ||
                                    window.mozRequestAnimationFrame ||
                                    window.webkitRequestAnimationFrame ||
                                    window.oRequestAnimationFrame ||
                                    window.msRequestAnimationFrame ||
                                    function( callback ) {
                                        //window.setTimeout(callback, 1000 / 60);
                                    };
                                })();




var img = new Image();
img.src = imgarr[i];
var imgW = 256

var num = 8;
var radius = 140;//半径
var radian = 0;//角度
var center = {x : imgW/2, y : imgW/2};//中心
var points = [];
var swingpoints = [];
var rangeMin = 4;
var rangeMax = 8;

canvas.fillStyle = '#FF0000';
// 座標計算

for (var i = 0; i < num; i++){
    radian = Math.PI * 2 / num * i;
    var ptX = center.x + radius * Math.cos(radian);
    var ptY = center.y + radius * Math.sin(radian);
    
    points.push({ x : ptX, y : ptY });
    swingpoints.push({ x : ptX, y : ptY, radian : radian, range : random(rangeMin, rangeMax), phase : (random(8, 16) - 8) * 0.01 });
}

// --------------------------------------------------------------------------- //
// swingCircle 揺れる円
function swingCircle() {
    canvas.clearRect(0, 0, 400, 400);
    canvas.save();
    
    for (var i = 0; i < swingpoints.length; i++){
        swingpoints[i].phase += random(1, 8) * -0.01;
        var r = radius + (swingpoints[i].range * Math.sin(swingpoints[i].phase)) - rangeMax;
        var ptX = center.x + r * Math.cos(swingpoints[i].radian);
        var ptY = center.y + r * Math.sin(swingpoints[i].radian);
        swingpoints[i] = { x : ptX, y : ptY, radian : swingpoints[i].radian, range : swingpoints[i].range, phase : swingpoints[i].phase };
    }
    
   drawCurve({ pts: swingpoints, strokeStyle : "rgba(0, 0, 0, 0.05)" });
    
   canvas.clip();
    canvas.drawImage(img, center.x - img.width * 0.5, center.y - img.width * 0.5);
   
  canvas.restore();
    requestAnimationFrame(swingCircle);
}
		
	// --------------------------------------------------------------------------- //
// drawCurve 曲線を描く
function drawCurve(obj) {
    var pts = (obj.pts === undefined) ? {} : obj.pts ;
    var strokeStyle = (obj.strokeStyle === undefined) ? "rgba(0, 0, 0, 0.6)" : obj.strokeStyle ;
    canvas.strokeStyle = strokeStyle;
    canvas.fillStyle = '#00FF00';
    canvas.beginPath();
    canvas.moveTo(
        (pts[cycle(0 - 1, num)].x + pts[0].x) / 2,
        (pts[cycle(0 - 1, num)].y + pts[0].y) / 2);
    for (var i = 0; i < pts.length; i++){
        canvas.quadraticCurveTo(
            pts[i].x,
            pts[i].y,
            (pts[i].x + pts[cycle(i + 1, num)].x) / 2,
            (pts[i].y + pts[cycle(i + 1, num)].y) / 2);
        //canvas.stroke();
    }
}

// --------------------------------------------------------------------------- //
// cycle
function cycle( num1, num2 ) {
    return ( num1 % num2 + num2 ) % num2;
}

// --------------------------------------------------------------------------- //
// random
function random (num1, num2) {
    var max = Math.max(num1, num2);
    var min = Math.min(num1, num2);
    // minからmaxまでのランダムな整数を返す
    return Math.floor(Math.random() * (max - min + 1)) + min;
}	




requestAnimationFrame(swingCircle);
  });


 }


