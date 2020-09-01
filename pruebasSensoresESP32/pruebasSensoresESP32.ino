byte sensor_proxi;
byte sensor_induc;

void setup() {
  Serial.begin(115200);

}

void loop() {
  sensor_proxi = random(0,2);
  sensor_induc = random(0,2);
  if(sensor_proxi==1){
    Serial.println("---HAY PAPEL---");
  }
  if(sensor_induc==1){
    Serial.println("---HAY METAL---");
  }
  //Serial.println(sensor_proxi);
  delay(1000);
}
