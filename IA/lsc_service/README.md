# LSC Microservice (Flask)

A tiny Flask service to integrate LSC (Colombian Sign Language) recognition with the PHP chat.

Important: This service is a clean-room reimplementation based on public ideas. The original repo had no license, so no code is copied.

## Endpoints

- GET /health -> { ok, yolo, mediapipe }
- POST /recognize
  - Body (JSON):
    - image: "data:image/jpeg;base64,..." (one frame)
    - OR secuencias: [["H","O","L","A"],["ESPACIO"],["M","U","N","D","O"]]
  - Response: { success, texto, clases?, aviso? }

## Setup (Windows PowerShell)

1. Create venv:
   python -m venv .venv

2. Activate venv:
   .\.venv\Scripts\Activate.ps1

3. Install deps:
   pip install -r requirements.txt

4. Place model weights (optional):
   - Put lsc.pt next to app.py or set env var LSC_MODEL to its path.

5. Run service:
   $env:FLASK_APP="app.py"; python app.py
   # Service listens on http://127.0.0.1:5001

## Notes
- If ultralytics/mediapipe/cv2 are not installed or the model file is missing, the service will return stub predictions (empty classes) but still run, useful for wiring tests.
- For production, consider GPU (CUDA) with proper drivers and set LSC_DEVICE.
