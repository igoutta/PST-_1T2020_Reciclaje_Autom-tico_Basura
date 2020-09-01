//PROYECTO_PST
//0t?d_[PJ*OP|Fb-@
//INSERT INTO `Objeto`(`id_objeto`, `fecha`, `hora`) VALUES ([value-1],[value-2],[value-3])
//#include <ArduinoHttpClient.h>
#include <HTTPClient.h>
#include <WiFi.h>

const char* ssid = "ERAZOLOZANO";
const char* password = "guillermo2199";
const char* host = "https://reciclajeautomaticodebasura.000webhostapp.com/envioDatos.php";



void setup() {
  Serial.begin(115200);
  delay(10);
  
  //Conectar a WIFI
  
  WiFi.begin(ssid, password);
  Serial.println("Conectando...");
  while(WiFi.status() != WL_CONNECTED){
    delay(500);
    Serial.print(".");
  }
  Serial.println("Conectado a la red con éxito");
  Serial.println("Su IP es: " + WiFi.localIP());
}


void loop() {
  
  if(WiFi.status() == WL_CONNECTED){
    HTTPClient http;
    //String datos_a_enviar = "user=" + user + "&pass=" + pass;
    String datos_a_insertar = "in=INSERT INTO Objeto (id_objeto, fecha, hora, id_contenedor) VALUES (NULL, '2020-08-28', '22:09:45', 'metal')";
    String datos_a_actualizar = "up=UPDATE Contenedor Set peso = '0.5' Where tipo = 'metal'";
    //String datos_a_enviar = "in=select * from Objeto";
    http.begin(host);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    int codigoSol = http.POST("p=Solucion");
    int codigo_answer = http.POST(datos_a_insertar);
    int codigo_respuesta = http.POST(datos_a_actualizar);
    
    Serial.println("------------------------");
    Serial.println("Codigo solucion HTTP: " + String(codigoSol)); //xq el 1er Post a enviar sale con error
    Serial.println("Codigo insert HTTP: " + String(codigo_answer));
    Serial.println("Codigo update HTTP: " + String(codigo_respuesta));
    Serial.println("------------------------");
    if(codigo_respuesta > 0){
      Serial.println("Codigo HTTP: " + String(codigo_respuesta));
      if(codigo_respuesta == 200){
        String cuerpo_respuesta = http.getString();
        Serial.println("El servidor respondio..");
        Serial.println(cuerpo_respuesta);
      }
      
    }else{
      Serial.print("Error enviando POST, código: ");
      Serial.println(codigo_respuesta);
    }
    http.end();
  }else{
    Serial.println("Error en la conexión WIFI");
  }
  delay(30000);

}
