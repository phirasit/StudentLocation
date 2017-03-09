
var radius = 5;

function clearCanvas(canvas_id) {

	var canvas = document.getElementById(canvas_id);
	var ctx = canvas.getContext("2d");

	ctx.clearRect(0, 0, canvas.width, canvas.height);
}

function drawArea(canvas_id, points, color) {

	if (points.length == 0) {
		return;
	}

	var canvas = document.getElementById(canvas_id);
	const w = canvas.width, h = canvas.height;

	var ctx = canvas.getContext("2d");
	var last = points[points.length-1];

	ctx.globalAlpha = 1.0;

	ctx.beginPath();
	ctx.strokeStyle = color;
	ctx.moveTo(last[0] * w, last[1] * h);
	for (var i = 0 ; i < points.length ; ++i) {
		var point = points[i];
		ctx.lineTo(point[0] * w, point[1] * h);
		ctx.stroke();
	}

	ctx.globalAlpha = 0.3;

	ctx.fillStyle = color;
	ctx.closePath();
	ctx.fill();
}

function drawCircle(canvas_id, pos, color) {

	var canvas = document.getElementById(canvas_id);
	const w = canvas.width, h = canvas.height;
	var ctx = canvas.getContext("2d");
	
	ctx.strokeStyle = color;

	pos[0] /= widthDistance;
	pos[1] /= heightDistance;
	
	ctx.globalAlpha = 1.0;
	ctx.beginPath();
	ctx.arc(pos[0] * w, pos[1] * h, radius, 0, 2*Math.PI);
	ctx.stroke();


	ctx.globalAlpha = 0.5;
 	ctx.fillStyle = color;
	ctx.closePath();
	ctx.fill();


}