
var color = "#000000";

var canvas = document.getElementById("draw");
var ctx = canvas.getContext("2d");

var outCanvas = document.getElementById("out");
var outCtx = outCanvas.getContext("2d");

var canvas = document.getElementById("draw");
var ctx = canvas.getContext("2d");

var canvas2 = document.getElementById("image");
var ctx2 = canvas2.getContext("2d");

if (uploadDoneFunction == null)
    var uploadDoneFunction = function(resp){};

var erase = false;





canvas.addEventListener("mousemove", draw);
canvas.addEventListener("mousedown", function(e) {
    setPosition(e);
    draw(e);
});
canvas.addEventListener("mouseenter", setPosition);

var pos = {
    x: 0,
    y: 0
};

function setPosition(e) {
    pos.x = e.layerX;
    pos.y = e.layerY;
}

function draw(e) {
    if (e.buttons !== 1) 
        return;

    ctx.beginPath();
    ctx.lineWidth = $("#penSize").val(); 
    ctx.lineCap = "round"; 
    ctx.strokeStyle = color;
    ctx.moveTo(pos.x, pos.y);
    setPosition(e);
    ctx.lineTo(pos.x, pos.y);

    ctx.stroke();

}

$(".colorSelection").click(function() {
    color = $(this).attr("data-color");
});

$("#erasor").click(function() {
    if (ctx.globalCompositeOperation == "destination-out")
        ctx.globalCompositeOperation="source-over";
    else
        ctx.globalCompositeOperation="destination-out";
});


