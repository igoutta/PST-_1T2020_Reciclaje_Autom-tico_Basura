//0t?d_[PJ*OP|Fb-@
//INSERT INTO `Objeto`(`id_objeto`, `fecha`, `hora`) VALUES ([value-1],[value-2],[value-3])
//#include <ArduinoHttpClient.h>
#include <HTTPClient.h>
#include <WiFi.h>

const char* ssid = "ERAZOLOZANO";
const char* password = "guillermo2199";

String user = "guillo2199@gmail.com";
String pass = "grupo8pst";

void setup() {
  delay(10);
  Serial.begin(115200);
  
  WiFi.begin(ssid, password);
  Serial.println("Conectando...");
  while(WiFi.status() != WL_CONNECTED){
    delay(500);
    Serial.print(".");
  }
  Serial.print("Conectado con éxito, mi IP es: ");
  Serial.println(WiFi.localIP());
}

void loop() {

  if(WiFi.status() == WL_CONNECTED){
    HTTPClient http;
    String datos_a_enviar = "user=" + user + "&pass=" + pass;
    http.begin("https://reciclajeautomaticodebasura.000webhostapp.com/pruebaESP32.php");
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    int codigo_respuesta = http.POST(datos_a_enviar);
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
  delay(4000);

}
