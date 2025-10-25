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

---

## Opción avanzada: usar el modelo Python (.pt) con YOLO

Si ya tienes un modelo entrenado en esta carpeta (por ejemplo `best.pt` o `lsc.pt`), puedes correr un microservicio local para usarlo desde el navegador.

1) Requisitos
- Python 3.10+ instalado (modo usuario).

2) Iniciar el servicio
- Abre PowerShell en `IA/lsc_service` y ejecuta:
	```powershell
	# por defecto autodetecta el .pt de la carpeta y usa el puerto 5001
	.\run_yolo_easy.ps1
	# o especifica puerto/modelo
	.\run_yolo_easy.ps1 -Port 5050 -Model .\best.pt
	```

3) Probar en navegador
- Abre la UI de servicio:  `IA/lsc_service/index_service.html`
- URL directa (puerto por defecto):
	`http://localhost/enseñame/enSENAme/EnSENAme/IA/lsc_service/index_service.html?api=http://127.0.0.1:5001`

Notas
- Archivos relevantes: `app_yolo.py`, `run_yolo.ps1`, `requirements.yolo.txt`.
- Para uso sin consola, puedes ejecutar con doble clic `run_yolo_easy.ps1`.
- La versión portable sigue funcionando en paralelo y no requiere Python.
