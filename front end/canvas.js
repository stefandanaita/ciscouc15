var canvas = null;
var context = null;
var WIDTH, HEIGHT;

// Global variables to control drawing on the canvas
var startedDrawing = false;
var oldx = 0, oldy = 0, cx = 0, cy = 0;

function init() {
  context = $('canvas')[0].getContext("2d");
  WIDTH = $('canvas').width();
  HEIGHT = $('canvas').height();
  $('#clearbutton').click(clearCanvas);
  $('canvas').mousemove(onMouseMove);
  $('canvas').mousedown(onMouseDown);
  $('canvas').mouseup(onMouseUp);
  $('canvas').css('cursor','pointer');
  clearCanvas();
}


	
// create a function to clear the canvas
function clearCanvas() {
  context.clearRect(0, 0, WIDTH, HEIGHT);
}

//get mouse coordinates
function getMouseXY(event) {
  var x = event.pageX - $('canvas').offset().left;
  var y = event.pageY - $('canvas').offset().top;
  console.log(" x " + x + "y " + y);
  return [x,y];
  }

// draw lines
function drawLine(x1,y1,x2,y2) {
  
  context.beginPath();
    context.moveTo(x1,y1);
    context.lineTo(x2,y2);
  context.closePath();  
  context.stroke();
}

function onMouseMove(event) {
  var p = getMouseXY(event);
  if (startedDrawing) {
    cx = p[0];
    cy = p[1];
    drawLine(oldx,oldy,cx,cy);
    oldx = cx;
    oldy = cy;
  }
}

//start drawing
function onMouseDown(event) {
  var p = getMouseXY(event);
  cx = p[0];
  cy = p[1];
  oldx = cx;
  oldy = cy;
  startedDrawing = true;
}

//stop drawingn 
function onMouseUp(event) {
  var p = getMouseXY(event);
  if (startedDrawing) {
    cx = p[0];
    cy = p[1];
    drawLine(oldx,oldy,cx,cy);
    oldx = cx;
    oldy = cy;
    startedDrawing = false;
  }
}


