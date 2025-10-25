# LSC Portable (100% navegador)

Versión de reconocimiento en el navegador usando TensorFlow.js + KNN con MobileNet. No requiere Python, ni servidor adicional, ni permisos de administrador.

## Página

- Archivo: `IA/lsc_service/index_portable.html`
- Acceso: `http://localhost/enseñame/enSENAme/EnSENAme/IA/lsc_service/index_portable.html`

## Funciones

- Iniciar/Detener cámara
- Entrenar ejemplos con etiqueta personalizada
- Predicción de una captura o en continuo
- Guardar y cargar modelo en formato `.json`
- Cargar “Modelo (Defecto)” incluido en el repo para probar al instante

## Uso rápido

1. Abre la página y concede permiso a la cámara.
2. Escribe una etiqueta (por ejemplo, "Hola") y presiona “Agregar ejemplo” varias veces con poses distintas.
3. Presiona “Predecir” o “Iniciar continuo”.
4. Guarda el modelo para reutilizarlo más tarde.

## Notas

- El rendimiento depende de la cámara y del equipo. Para mejores resultados, agrega ejemplos variados y con buena iluminación.
- Puedes reemplazar el modelo por defecto del repositorio con uno propio exportado como `.json`.

## Enlaces relacionados

- Página IA general: `IA/index.html` (incluye acceso a la versión portable).
