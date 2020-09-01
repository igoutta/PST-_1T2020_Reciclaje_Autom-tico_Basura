float a;
String aS="";
void setup() {
  Serial.begin(115200);

}

void loop() {
  a=random(3, 22)/7.0;
  
  
    aS =String(a, 3);
  
  
  Serial.println(aS);
  delay(1000);

}
