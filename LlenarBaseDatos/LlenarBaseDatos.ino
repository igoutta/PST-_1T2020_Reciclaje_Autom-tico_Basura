//String datos_a_enviar = "in=select * from Objeto";
#include <WiFi.h>
#include <HTTPClient.h>
#include <Servo_ESP32.h>
#include <HCSR04.h>
#include <NTPClient.h>
#include <WiFiUdp.h>


const char* ssid = "ERAZOLOZANO";
const char* password = "guillermo2199";
const char* host = "https://reciclajeautomaticodebasura.000webhostapp.com/envioDatos.php";

byte valid = 0;

byte sensor_proxi;
byte sensor_induc;
double sensor_pesoP;
double sensor_pesoM;

double pesoPapel = 0.0;
double pesoMetal = 0.0;

Servo_ESP32 servo1;
static const int servoPin = 14; //printed G14 on the board

int angleI = 90;
int angleStep = 8;

int angleMin = 0;
int angleMax = 180;

static const int TriggerPin = 5;
static const int EchoPin = 18;
double distanciaLlenado = 0;
UltraSonicDistanceSensor distanceSensor(TriggerPin, EchoPin);

// Define NTP Client to get time
WiFiUDP ntpUDP;
NTPClient timeClient(ntpUDP);

// Variables to save date and time
String formattedDate;
String dayStamp;
String timeStamp;

int cantPapel = 0;
int cantMetal = 0;

int dia = 1;
int hora;
int minut;
int seg;

String diaS ="";
String horaS ="";
String minutS ="";
String segS ="";


void setup() {
  Serial.begin(115200);
  
  servo1.attach(servoPin);
  servo1.write(angleI);
  
  WiFi.begin(ssid, password);
  Serial.println("Conectando a la red...");
  while(WiFi.status() != WL_CONNECTED){
    delay(500);
    Serial.print(".");
  }
  Serial.println("------------------------");
  Serial.println("Conexión con éxito");
  Serial.print("Su IP es: ");
  Serial.println(WiFi.localIP());
  Serial.println("------------------------");

  // Initialize a NTPClient to get time
  timeClient.begin();
  timeClient.setTimeOffset(-18000); //Zona horaria de Ecuador
}


void loop() {

  if(dia > 1){
    Serial.println("Datos subidos");
  }
  while(dia<2){
    for(int i=0;i<15;i++){
      
    
  
  if(WiFi.status() == WL_CONNECTED) {
    sensor_proxi = random(0,2);
    sensor_induc = random(0,2);
    
    hora = random(5,24);
    minut = random(10,60);
    seg = random(10,60);
    
    distanciaLlenado = distanceSensor.measureDistanceCm();
    //Serial.println(distanciaLlenado);
    Serial.println("------------------------");

    
    HTTPClient http;
    http.begin(host);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    
    if(valid == 0){
      int codigoSol = http.POST("p=Solucion");//xq el 1er Post a enviar sale con error
      Serial.println("Codigo solucion HTTP: " + String(codigoSol)); 
      Serial.println("------------------------");
    }

    if(sensor_proxi==1 && sensor_induc==0){

      minutS = String(minut);
      segS = String(seg);
      if(dia < 10){
        diaS = "0" + String(dia);
      }else{
        diaS = String(dia);
      }
      if(hora < 10){
        horaS = "0" + String(hora);
      }else{
        horaS = String(hora);
      }
      
      Serial.println("------HAY PAPEL------");
      sensor_pesoP = random(3, 22)/7.0;
      pesoPapel += sensor_pesoP;
      String converPeso = "";
      converPeso = String(pesoPapel, 3);
      
      if((distanciaLlenado < 15) && (distanciaLlenado != -1)){
        String datosInsertar = "up=UPDATE Contenedor Set lleno = '1' Where tipo = 'papel' AND num_deposito = '1'";
 
        int codigoRespuestaIn = http.POST(datosInsertar);
        Serial.println("Codigo HTTP: " + String(codigoRespuestaIn));
        Serial.println("------------------------");
        pesoPapel = 0;
      }else{
       
      
      cantPapel++;
      String datosInsertar = "in=INSERT INTO RegistroObjeto (id_objeto, pesoObjeto, fecha, hora, id_contenedor) VALUES (NULL, '"+String(sensor_pesoP, 3)+"','2020-09-"+diaS+"', '"+horaS+":"+minutS+":"+segS+"', '2')&up=UPDATE Contenedor Set lleno = '0', cantidad = '"+cantPapel+"' Where tipo = 'papel' AND num_deposito = '1'";
      //Serial.println("2020-01-"+diaS+"', '"+horaS+"-"+minutS+"-"+segS);
      int codigoRespuestaIn = http.POST(datosInsertar);
      if(codigoRespuestaIn == -1){
        cantPapel--;
        pesoPapel -= sensor_pesoP;
      }
      Serial.println("Codigo HTTP: " + String(codigoRespuestaIn));
      Serial.println("------------------------");
      
      
      
      }
    }
    if(sensor_induc==1 && sensor_proxi==0){

      minutS = String(minut);
      segS = String(seg);
      if(dia < 10){
        diaS = "0" + String(dia);
      }else{
        diaS = String(dia);
      }
      if(hora < 10){
        horaS = "0" + String(hora);
      }else{
        horaS = String(hora);
      }
      
      Serial.println("------HAY METAL------");
      sensor_pesoM = random(6, 48)/7.0;
      pesoMetal += sensor_pesoM;
      String converPeso = "";
      converPeso = String(pesoMetal, 3);

      if((distanciaLlenado < 15) && (distanciaLlenado != -1)){
        String datosInsertar = "up=UPDATE Contenedor Set lleno = '1' Where tipo = 'metal' AND num_deposito = '1'";
      
        int codigoRespuestaIn = http.POST(datosInsertar);
        Serial.println("Codigo HTTP: " + String(codigoRespuestaIn));
        Serial.println("------------------------");
        pesoMetal = 0;
      }else{
      
       
      cantMetal++;
      String datosInsertar = "in=INSERT INTO RegistroObjeto (id_objeto, pesoObjeto, fecha, hora, id_contenedor) VALUES (NULL, '"+String(sensor_pesoM, 3)+"','2020-09-"+diaS+"', '"+horaS+":"+minutS+":"+segS+"', '1')&up=UPDATE Contenedor Set lleno = '0', cantidad = '"+cantMetal+"' Where tipo = 'metal' AND num_deposito = '1'";
      
      int codigoRespuestaIn = http.POST(datosInsertar);
      if(codigoRespuestaIn == -1){
        cantMetal--;
        pesoMetal -= sensor_pesoP;
      }
      Serial.println("Codigo HTTP: " + String(codigoRespuestaIn));
      Serial.println("------------------------");
      
      }
    }
  }
  valid = 1;
  delay(100);
  }
  dia++;
  Serial.print("DIA: ");
  Serial.println(dia);
  }
  
}
