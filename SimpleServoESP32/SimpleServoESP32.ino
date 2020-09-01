#include <Servo_ESP32.h>

static const int servoPin = 14; //printed G14 on the board

Servo_ESP32 servo1;

int angleI =90;
int angleStep = 8;

int angleMin =0;
int angleMax = 180;

void setup() {
    Serial.begin(115200);
    servo1.attach(servoPin);
    servo1.write(angleI);
    
}

void loop() {
    delay(1000);
    //servo1.write(0);
    Serial.println("Contenedor PAPEL Abierto");
    for(int angle = 90; angle <= angleMax; angle +=angleStep) {
        servo1.write(angle);
        delay(25);
    }
    delay(1000);
    servo1.write(angleI);
    Serial.println("Contenedor Cerrado");
    delay(1000);
    
    Serial.println("Contenedor METAL Abierto");
    for(int angle = 90; angle >= angleMin; angle -=angleStep) {
        servo1.write(angle);
        delay(25);
    }
    //servo1.write(180);
    delay(1000);
    servo1.write(angleI);
    Serial.println("Contenedor Cerrado");
    
}
