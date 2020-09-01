#include <DateTime.h>
void setup() {
  Serial.begin(115200);

}

void loop() {
  Serial.println(dimeFecha());

}

/*
FUNCION PARA OBTENER LA FECHA EN MODO TEXTO
Devuelve: DD-MM-AAAA HH:MM:SS
*/
String dimeFecha()
  {
  char fecha[20];
  DateTime now = RTC.now(); //Obtener fecha y hora actual.
        
  int dia = now.day();
  int mes = now.month();
  int anio = now.year();
  int hora = now.hour();
  int minuto = now.minute();
  int segundo = now.second();
        
  sprintf( fecha, "%.2d.%.2d.%.4d %.2d:%.2d:%.2d", dia, mes, anio, hora, minuto, segundo);
  return String( fecha );
  }
