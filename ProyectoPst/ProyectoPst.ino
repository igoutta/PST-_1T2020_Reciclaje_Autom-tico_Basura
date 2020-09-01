//Librerías a usar
#include <WiFi.h>
#include <HTTPClient.h>
#include <Servo_ESP32.h>
#include <HCSR04.h>
#include <NTPClient.h>
#include <WiFiUdp.h>

//Datos para obtener conexión Wifi
const char* ssid = "ERAZOLOZANO";
const char* password = "guillermo2199";

//Página a realizar conexión para el envío de datos
const char* host = "https://reciclajeautomaticodebasura.000webhostapp.com/envioDatos.php";


byte valid = 0;

//Creación de variables para simulación de sensores 
byte sensor_proxi;
byte sensor_induc;
double sensor_pesoP;
double sensor_pesoM;

//Variables para contar el peso del contenedor y de cada objeto
double pesoPapel = 0.0;
double pesoMetal = 0.0;

//Datos iniciales y generales del servoMotor
Servo_ESP32 servo1;
static const int servoPin = 14; //printed G14 on the board
int angleI = 90;
int angleStep = 8;

//Datos iniciales y generales del sensor de Ultrasonido
static const int TriggerPin = 5;
static const int EchoPin = 18;
double distanciaLlenado = 0;
UltraSonicDistanceSensor distanceSensor(TriggerPin, EchoPin);

// Definición NTP Client para obtención de fecha y hora
WiFiUDP ntpUDP;
NTPClient timeClient(ntpUDP);

// Variables para guardar la fecha y hora
String formattedDate;
String dayStamp;
String timeStamp;

//Variables para contar los objetos
int cantPapel = 0;
int cantMetal = 0;

void setup() {
  Serial.begin(115200);
  //Se posiciona el motor en 90 grados
  servo1.attach(servoPin);
  servo1.write(angleI);

  //Se inicia la conexión Wifi
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
  //Se verifica si hay conexión Wifi para continuar el trabajo 
  if(WiFi.status() == WL_CONNECTED) {
    //Simulación de sensor de proximidad y sensor inductivo
    Serial.println("-----Sensando objetos-----");
    sensor_proxi = random(0,2);
    sensor_induc = random(0,2);
    
    Serial.println("Peso actual del contenedor de Papel: " + String(pesoPapel, 3));
    Serial.println("Peso actual del contenedor de Metal: " + String(pesoMetal, 3));
    Serial.println("------------------------");

    //Obtención de Fecha y Hora actual
    while(!timeClient.update()) {
    timeClient.forceUpdate();
    }
    formattedDate = timeClient.getFormattedDate();// Formato: 2018-05-28T16:00:13Z
    // Extrae Fecha
    int splitT = formattedDate.indexOf("T");
    dayStamp = formattedDate.substring(0, splitT);
    // Extrae Hora
    timeStamp = formattedDate.substring(splitT+1, formattedDate.length()-1);

    //Inicio de conexión con la página de host 
    HTTPClient http;
    http.begin(host);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    //Como el primer Post que se realiza sale con error
    //Se envía un dato cualquiera, el cual se recepta en una variable que no realiza nada en el código php de la página
    if(valid == 0){
      int codigoSol = http.POST("p=Solucion");
      Serial.println("Codigo solucion HTTP: " + String(codigoSol)); 
      Serial.println("------------------------");
    }
    
    //Se detecta un papel
    if(sensor_proxi==1 && sensor_induc==0){
      Serial.println("------HAY PAPEL------");
      delay(2500);
      //Obtención de la distancia en centimetros con el sensor de Ultrasonido
      distanciaLlenado = distanceSensor.measureDistanceCm();
      //Simulación del peso del objeto
      sensor_pesoP = random(6, 50)/8.0;
      pesoPapel += sensor_pesoP;
      String converPeso = "";
      converPeso = String(pesoPapel, 3);
      
      //Si el contenedor de papel está lleno no se deposita el objeto, ni se envían datos con respecto a dicho objeto
      if((distanciaLlenado < 16) && (distanciaLlenado != -1)){
        Serial.println("Contenedor de Papel lleno");
        String datosInsertar = "up=UPDATE Contenedor Set lleno = '1' Where tipo = 'papel' AND num_deposito = '1'";
        
        //Se envía datos por Post acerca del contenedor (que se encuentra lleno)
        int codigoRespuestaIn = http.POST(datosInsertar);
        Serial.println("Codigo HTTP: " + String(codigoRespuestaIn));
        Serial.println("------------------------");
        pesoPapel = 0;
        cantPapel = 0;
      }else{
      //Si el contenedor no está lleno, se abre la compuerta para que caiga el objeto en el contenedor respectivo
      servo1.write(0);
      Serial.println("Contenedor PAPEL Abierto");
      delay(2000);
      //Se vuelve a cerrar la compuerta
      servo1.write(angleI);
      Serial.println("Contenedor PAPEL Cerrado");
      
      Serial.println("Nuevo Peso del contenedor de Papel = " + converPeso);  
      Serial.println("Fecha: " + dayStamp);
      Serial.println("Hora: " + timeStamp);
      cantPapel++;
      String datosInsertar = "in=INSERT INTO RegistroObjeto (id_objeto, pesoObjeto, fecha, hora, id_contenedor) VALUES (NULL, '"+String(sensor_pesoP, 3)+"','"+dayStamp+"', '"+timeStamp+"', '2')&up=UPDATE Contenedor Set peso = '"+converPeso+"', lleno = '0', cantidad = '"+cantPapel+"' Where tipo = 'papel' AND num_deposito = '1'";
      
      //Se envía el dato por Post para agregar un nuevo objeto y actualizar los datos del contenedor de papel
      int codigoRespuestaIn = http.POST(datosInsertar);
      if(codigoRespuestaIn == -1){
        cantPapel--;
        pesoPapel -= sensor_pesoP;
      }
      Serial.println("Codigo HTTP: " + String(codigoRespuestaIn));
      Serial.println("------------------------");
      
      }
    }
    //Se detecta un metal
    if(sensor_induc==1 && sensor_proxi==0){
      Serial.println("------HAY METAL------");
      delay(2500);
      //Obtención de la distancia en centimetros con el sensor de Ultrasonido
      distanciaLlenado = distanceSensor.measureDistanceCm();
      //Simulación del peso del objeto
      sensor_pesoM = random(8, 80)/8.0;
      pesoMetal += sensor_pesoM;
      String converPeso = "";
      converPeso = String(pesoMetal, 3);

      //Si el contenedor de metal está lleno no se deposita el objeto, ni se envían datos con respecto a dicho objeto
      if((distanciaLlenado < 16) && (distanciaLlenado != -1)){
        Serial.println("Contenedor de Metal lleno");
        String datosInsertar = "up=UPDATE Contenedor Set lleno = '1' Where tipo = 'metal' AND num_deposito = '1'";

        //Se envía datos por Post acerca del contenedor (que se encuentra lleno)
        int codigoRespuestaIn = http.POST(datosInsertar);
        Serial.println("Codigo HTTP: " + String(codigoRespuestaIn));
        Serial.println("------------------------");
        pesoMetal = 0;
        cantMetal = 0;
      }else{
      //Si el contenedor no está lleno, se abre la compuerta para que caiga el objeto en el contenedor respectivo
      servo1.write(180);
      Serial.println("Contenedor METAL Abierto");
      delay(2000);
      //Se vuelve a cerrar la compuerta
      servo1.write(angleI);
      Serial.println("Contenedor METAL Cerrado");
      
      Serial.println("Nuevo Peso del contenedor de Metal = " + converPeso);  
      Serial.println("Fecha: " + dayStamp);
      Serial.println("Hora: " + timeStamp);
      cantMetal++;
      String datosInsertar = "in=INSERT INTO RegistroObjeto (id_objeto, pesoObjeto, fecha, hora, id_contenedor) VALUES (NULL, '"+String(sensor_pesoM, 3)+"', '"+dayStamp+"', '"+timeStamp+"', '1')&up=UPDATE Contenedor Set peso = '"+converPeso+"', lleno = '0', cantidad = '"+cantMetal+"' Where tipo = 'metal' AND num_deposito = '1'";

      //Se envía el dato por Post para agregar un nuevo objeto y actualizar los datos del contenedor de papel
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
  delay(2000);
}
