//https://github.com/Martinsos/arduino-lib-hc-sr04
#include <HCSR04.h>
// Disparo del PULSO, Sensor del Retorno de pulso
int TriggerPin = 5;
int EchoPin = 18;

UltraSonicDistanceSensor distanceSensor(TriggerPin, EchoPin);
void setup(){
    Serial.begin(115200);
}
void loop(){
    //dato en [cm], 
    double distance = distanceSensor.measureDistanceCm();
    Serial.println(distance);
    delay(500);
}
