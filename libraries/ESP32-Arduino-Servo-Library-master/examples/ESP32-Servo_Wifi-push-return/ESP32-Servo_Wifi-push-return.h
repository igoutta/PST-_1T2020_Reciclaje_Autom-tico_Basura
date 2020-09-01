const char pageHeader_1[]  PROGMEM = R"header1(
<!DOCTYPE html>
<html>
<head>
<title>Robojax ESP32 Servo Motor Push-Return</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
html, body {
  width:  100%;
  height: 100%;
  margin: 0;
}
* {box-sizing: border-box}
.table{
    width:100%;
    display:table;
}
.row{
    display:table-row;
}


.fixedCell {
    width:15%;
    display:table-cell;
    padding: 10px 10px 10px 10px;
}
.fixedCellEmpty {
    width:5%;
    display:table-cell;
    padding: 10px 10px 10px 10px;
}

.cell{
    display: table-cell;
    background: green;
}

.progress_bar {
  font-size: 20px;  
  text-align: right;
  padding-top: 10px;
  padding-bottom: 10px;
  padding-right:10px;
  color: white;
  float:left;
  background-color:#34c0eb;  
}

.buttonsDiv {
  display: flex;
  justify-content: center;
  float:auto;
}
.startStop{
     font-size: 20px;
   background-color: #f44336;
    color: #ffffff;
    border-color: #f44336;  
    border: none;
    display: inline-block;
    padding: 7px 10px;
    vertical-align: middle;    
}

)header1";



const char pageHeader_2[] PROGMEM = R"robojaxSpeed2( 
.nextprev a.rj-right, .nextprev a.rj-left {
    background-color: #f44336;
    color: #ffffff;
    border-color: #f44336;
}
.angleButton a {
    font-size: 40px;
    border: 1px solid #cccccc;
    display: table-caption;
    padding: 7px 10px;    
  
}


.nextprev a {
    font-size: 20px;

}
.rj-right {
    float: right!important;
}
.rj-left {
    float: left!important;
}
.rj-btn, .rj-button {
    border: none;
    display: inline-block;
    padding: 7px 10px;
    vertical-align: middle;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    background-color: inherit;
    text-align: center;
    cursor: pointer;
    white-space: nowrap;
}
</style>
</head>
<body>

<h1>Robojax ESP32 Servo Motor Push-Return</h1>)robojaxSpeed2";


////////////////for motor 1 part 1///////////////
const char servo1Control_p1[] PROGMEM = R"robojaxSpeed3(
<h2>Servo 1 Control</h2>
<div class="table">
    <div class="row"><h2>)robojaxSpeed3";



////////////////for servo1 1 part 2///////////////
const char servo1Control_p2[] PROGMEM = R"robojaxSpeed4( </h2> 
    </div><!--row -->
</div><!--table -->   
<div class="table">
    <div class="row"> 


        <div class="fixedCell angleButton colspan" style="background-color: lightgreen;">       
          <a class="rj-btn "  href="/servo?do=s1move">Start</a>
         </div>
         
         <div class="fixedCellEmpty angleButton colspan" style="background-color: white;">       
         </div>  
               
        <div class="fixedCell  angleButton" style="background-color: lightblue;">         
          <a class="rj-btn" href="/type?num=1">Type 1</a>
         </div>

         <div class="fixedCellEmpty angleButton colspan" style="background-color: white;">       
         </div>  
                  
        <div class="fixedCell angleButton colspan" style="background-color: lightblue;">         
          <a class="rj-btn" href="/type?num=2">Type 2</a>
         </div>
   
                                                              
    </div><!--row -->
</div><!--table -->  
)robojaxSpeed4";
