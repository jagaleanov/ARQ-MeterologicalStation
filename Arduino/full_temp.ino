
// Incluimos librería
#include <DHT.h>
#include <SFE_BMP180.h>
#include <Wire.h>
 
// Definimos el pin digital donde se conecta el sensor
#define DHTPIN 2
// Dependiendo del tipo de sensor
#define DHTTYPE DHT11

SFE_BMP180 bmp180;
 
// Inicializamos el sensor DHT11
DHT dht(DHTPIN, DHTTYPE);


void setup() {
  // Inicializamos comunicación serie
  Serial.begin(9600);
 
  // Comenzamos el sensor DHT
  dht.begin();
  bmp180.begin();
}

void loop() {
      // Esperamos 5 segundos entre medidas
      delay(5000);
      
      // Leemos la humedad relativa
      double h = dht.readHumidity();
      // Leemos la temperatura en grados centígrados (por defecto)
      double t = dht.readTemperature();
      // Leemos la temperatura en grados Fahrenheit
      double f = dht.readTemperature(true);
      char status;
      double T,P;
      
      // Comprobamos si ha habido algún error en la lectura
      
      if (isnan(h) || isnan(t) || isnan(f)) {
      Serial.println("Error obteniendo los datos del sensor DHT11");
      return;
      }
      
      // Calcular el índice de calor en Fahrenheit
      float hif = dht.computeHeatIndex(f, h);
      // Calcular el índice de calor en grados centígrados
      float hic = dht.computeHeatIndex(t, h, false);
      
      Serial.print("(DHT11) Humedad: ");
      Serial.print(h);
      Serial.println(" %\t");
      Serial.println("(DHT11) Temperatura: ");
      Serial.print(t);
      Serial.println(" °C");
      Serial.print(f);
      Serial.println(" °F");
      Serial.println("(DHT11) Índice de calor:");
      Serial.print(hic);
      Serial.println(" °C");
      Serial.print(hif);
      Serial.println(" °F");

      status = bmp180.startTemperature();//Inicio de lectura de temperatura
      if (status != 0){
        delay(status); //Pausa para que finalice la lectura
        status = bmp180.getTemperature(T); //Obtener la temperatura
        status = bmp180.startPressure(3); //Inicio lectura de presión
        delay(status);//Pausa para que finalice la lectura
        status = bmp180.getPressure(P,T); //Obtenemos la presión
          
        Serial.println("(BMP180) Temperatura: ");
        Serial.print(T,2);
        Serial.println(" °C");
        Serial.println("(BMP180)Presion: ");
        Serial.print(P,2);
        Serial.println(" mb");
        Serial.println("");
        }
 }
