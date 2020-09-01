/*
 * Original sourse: https://github.com/RoboticsBrno/ESP32-Arduino-Servo-Library
 * 
 * This is Arduino code to control Servo motor with ESP32 boards over Wifi
 * Watch video instruction for this code: https://youtu.be/j5Op02E9Fy0
   
 * Written/updated by Ahmad Shamshiri for Robojax Video channel www.Robojax.com
 * Date: Dec 29, 2019, in Ajax, Ontario, Canada

 * this code has been downloaded from http://robojax.com/learn/arduino/
 
 * Get this code and other Arduino codes from Robojax.com
Learn Arduino step by step in structured course with all material, wiring diagram and library
all in once place. Purchase My course on Udemy.com http://robojax.com/L/?id=62

****************************
Get early access to my videos via Patreon and have  your name mentioned at end of very 
videos I publish on YouTube here: http://robojax.com/L/?id=63 (watch until end of this video to list of my Patrons)
****************************

or make donation using PayPal http://robojax.com/L/?id=64

 *  * This code is "AS IS" without warranty or liability. Free to be used as long as you keep this note intact.* 
 * This code has been download from Robojax.com
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */
#include <Servo_ESP32.h>

static const int servo1Pin = 14; //printed G14 on the board

Servo_ESP32 servo1;

int servo1Angle =0;
int servo1Step = 5;

int servo1AngleMin =0;
int servo1AngleMax = 180;

int type =2;
int buttonPushed =0;

String titleTyp1 ={"Type 1: from "+ String(servo1AngleMin)+ " to "+String(servo1AngleMax)+ " degree"};
String titleTyp2 ={"Type 2: from "+ String(servo1AngleMax)+ " to "+String(servo1AngleMin)+ " degree"};

#include "ESP32-Servo_Wifi-push-return.h"



  
#include <WiFi.h>
#include <WiFiClient.h>
#include <WebServer.h>
#include <ESPmDNS.h>

const char *ssid = "Robojax";
const char *password = "YouTube2019_o_";

WebServer server(80);

const int led = 13;

void handleRoot() {

String HTML_page = pageHeader_1; 

 HTML_page.concat(pageHeader_2 );
 HTML_page.concat(servo1Control_p1);
  if(type ==1)
  {
      HTML_page.concat(titleTyp1); 
  }else{
      HTML_page.concat(titleTyp2);      
  } 

 HTML_page.concat(servo1Control_p2);
 HTML_page.concat("</body>\n</html>");
 server.send(200, "text/html", HTML_page);
}

void handleNotFound() {
  digitalWrite(led, 1);
  String message = "File Not Found\n\n";
  message += "URI: ";
  message += server.uri();
  message += "\nMethod: ";
  message += (server.method() == HTTP_GET) ? "GET" : "POST";
  message += "\nArguments: ";
  message += server.args();
  message += "\n";

  for (uint8_t i = 0; i < server.args(); i++) {
    message += " " + server.argName(i) + ": " + server.arg(i) + "\n";
  }

  server.send(404, "text/plain", message);
  digitalWrite(led, 0);
}


void setup() {
    Serial.begin(115200);
    servo1.attach(servo1Pin);
	

  //Servo control using ESP32 from Robojax.com

  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  Serial.println("");
  
    
  // Wait for connection
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.print("Connected to ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());


  if (MDNS.begin("robojaxESP32")) {
    Serial.print("MDNS responder started at http://");
    Serial.println("robojaxESP32");
  }

  server.on("/", handleRoot);
  server.on("/servo", HTTP_GET, handleServo);  
  server.on("/type", HTTP_GET, handleServoType);  
  server.onNotFound(handleNotFound);
  server.begin();
  Serial.println("HTTP server started"); 	
}

void loop() {
	server.handleClient();
  if( buttonPushed ){
  // change the angle for next time through the loop:
  servo1Angle +=servo1Step;
    if(type ==1){
        for (servo1Angle = servo1AngleMin; servo1Angle <= servo1AngleMax; servo1Angle += servo1Step) { 
          servo1.write(servo1Angle);
          //Serial.println(servo1Angle);
          delay(30);      
        }
        for (servo1Angle = servo1AngleMax; servo1Angle >=servo1AngleMin ; servo1Angle -= servo1Step) { 
          servo1.write(servo1Angle);
          //Serial.println(servo1Angle);
          delay(30);      
        }           
     }else{
        for (servo1Angle = servo1AngleMax; servo1Angle >=servo1AngleMin ; servo1Angle -= servo1Step) { 
          servo1.write(servo1Angle);
          //Serial.println(servo1Angle);
          delay(30);      
        }
        for (servo1Angle = servo1AngleMin; servo1Angle <= servo1AngleMax; servo1Angle += servo1Step) { 
          servo1.write(servo1Angle);
          //Serial.println(servo1Angle);
          delay(30);      
        }        
    }
  }//if pushed

   buttonPushed =0; 
}



/*
 * handleServo()
 * update the buttonPushed varialbe
 * returns nothing
 * Written by Ahmad Shamshiri on Dec 29, 2019
 * www.Robojax.com
 * http://youTube.com/robojaxTV
 */
void handleServo() {
  if(server.arg("do") == "s1move" )
  {
    buttonPushed = 1;
  }

  handleRoot();
}//handleServo() end

/*
 * handleServoType()
 * updates the variable "type" to 1 or 2 and 
 * also move the servo to min or max angle
 * returns nothing
 * Written by Ahmad Shamshiri on Dec 29, 2019
 * www.Robojax.com
 * http://youTube.com/robojaxTV
 */
void handleServoType() {
  if(server.arg("num") =="1")
  {
   type =1; 
    servo1.write(servo1AngleMin);//move the servo to minimum positon
  }else{
   type =2;
   servo1.write(servo1AngleMax);//move the servo to maximum positon
  }
 
  handleRoot();
}//handleServoType() end
