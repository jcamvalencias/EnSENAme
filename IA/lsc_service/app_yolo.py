import base64
import io
import os
from dataclasses import dataclass
from typing import Optional, Tuple

from flask import Flask, request, jsonify
from flask_cors import CORS

# Optional heavy deps; load lazily if available
try:
    import cv2  # type: ignore
except Exception:
    cv2 = None

try:
    from ultralytics import YOLO  # type: ignore
except Exception:
    YOLO = None

try:
    import mediapipe as mp  # type: ignore
except Exception:
    mp = None
try:
    import numpy as np  # type: ignore
except Exception:
    np = None


def _autodetect_model_path() -> Optional[str]:
    # First, env var
    env_path = os.environ.get("LSC_MODEL")
    if env_path and os.path.exists(env_path):
        return env_path
    # Common names in current folder
    for name in ("lsc.pt", "best.pt", "weights.pt"):
        p = os.path.join(os.getcwd(), name)
        if os.path.exists(p):
            return p
    # Any .pt in folder
    for f in os.listdir(os.getcwd()):
        if f.lower().endswith(".pt"):
            return os.path.join(os.getcwd(), f)
    return None


@dataclass
class PredictConfig:
    model_path: Optional[str] = _autodetect_model_path()
    conf: float = float(os.environ.get("LSC_CONF", "0.55"))
    device: Optional[str] = os.environ.get("LSC_DEVICE")  # e.g., "cpu" or "cuda"


class LSCRecognizer:
    def __init__(self, cfg: PredictConfig):
        self.cfg = cfg
        self.model = None
        self.hands = None
        self.hand_utils = None
        self._load_optional_models()

    def _load_optional_models(self):
        # Load YOLO model if available
        if YOLO is not None and self.cfg.model_path and os.path.exists(self.cfg.model_path):
            try:
                self.model = YOLO(self.cfg.model_path)
            except Exception:
                self.model = None
        # Setup MediaPipe Hands if available
        if mp is not None:
            try:
                self.hands = mp.solutions.hands.Hands(
                    static_image_mode=False,
                    max_num_hands=2,
                    model_complexity=1,
                    min_detection_confidence=0.5,
                    min_tracking_confidence=0.5,
                )
                self.hand_utils = mp.solutions.drawing_utils
            except Exception:
                self.hands = None
                self.hand_utils = None

    def decode_image(self, b64_image: str):
        if not cv2 or np is None:
            return None, "Dependencias faltantes (cv2/numpy)"
        try:
            header_sep = ","
            if header_sep in b64_image:
                b64_image = b64_image.split(header_sep, 1)[1]
            img_bytes = base64.b64decode(b64_image)
            data = np.frombuffer(img_bytes, dtype=np.uint8)  # type: ignore
            frame = cv2.imdecode(data, cv2.IMREAD_COLOR)
            return frame, None
        except Exception as e:
            return None, f"Error decodificando imagen: {e}"

    def detect_hand_roi(self, frame):
        # If mediapipe is unavailable, return whole frame as ROI
        if not mp or not self.hands:
            return frame
        img_rgb = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        results = self.hands.process(img_rgb)
        if not results.multi_hand_landmarks:
            return frame
        # Take first hand bbox
        h, w, _ = frame.shape
        x_list, y_list = [], []
        for lm in results.multi_hand_landmarks[0].landmark:
            x_list.append(int(lm.x * w))
            y_list.append(int(lm.y * h))
        xmin, xmax = max(min(x_list) - 60, 0), min(max(x_list) + 55, w)
        ymin, ymax = max(min(y_list) - 50, 0), min(max(y_list) + 70, h)
        return frame[ymin:ymax, xmin:xmax]

    def predict_classes(self, frame) -> Tuple[list, Optional[str]]:
        if not self.model:
            return [], "Modelo YOLO no cargado (coloca el .pt en esta carpeta o define LSC_MODEL)"
        try:
            results = self.model.predict(frame, conf=self.cfg.conf, device=self.cfg.device)
            clases = []
            for res in results:
                try:
                    # If boxes exist, map cls ids to names
                    if hasattr(res, "boxes") and hasattr(res, "names") and res.boxes is not None:
                        for b in res.boxes:
                            try:
                                idx = int(b.cls.item())
                                name = res.names.get(idx, str(idx)) if isinstance(res.names, dict) else str(idx)
                                if name not in clases:
                                    clases.append(name)
                            except Exception:
                                pass
                    elif hasattr(res, "names"):
                        if isinstance(res.names, dict):
                            for _, name in res.names.items():
                                if name not in clases:
                                    clases.append(name)
                        elif isinstance(res.names, list):
                            for name in res.names:
                                if name not in clases:
                                    clases.append(name)
                except Exception:
                    pass
            return clases, None
        except Exception as e:
            return [], f"Fallo de predicción YOLO: {e}"

    @staticmethod
    def join_letters(secuencias: list) -> str:
        palabras = []
        for senales in secuencias:
            palabra_actual = ""
            for s in senales:
                if s == "ESPACIO":
                    palabra_actual += " "
                else:
                    palabra_actual += s
            palabras.append(palabra_actual)
        return "".join(palabras)


# Flask app
app = Flask(__name__)
CORS(app)
rec = LSCRecognizer(PredictConfig())


@app.get("/health")
def health():
    return jsonify({
        "ok": True,
        "yolo": bool(rec.model),
        "mediapipe": bool(rec.hands),
        "model_path": rec.cfg.model_path,
    })


@app.post("/recognize")
def recognize():
    data = request.get_json(silent=True) or {}
    if "secuencias" in data:
        texto = rec.join_letters(data.get("secuencias") or [])
        return jsonify({"success": True, "texto": texto, "modo": "join-only"})

    b64_image = data.get("image")
    if not b64_image:
        return jsonify({"success": False, "error": "Falta 'image' o 'secuencias'"}), 400

    frame, err = rec.decode_image(b64_image)
    if err:
        return jsonify({"success": False, "error": err}), 400

    roi = rec.detect_hand_roi(frame)
    clases, perr = rec.predict_classes(roi)
    texto = rec.join_letters([clases]) if clases else ""

    return jsonify({
        "success": True,
        "texto": texto,
        "clases": clases,
        "aviso": perr,
    })


if __name__ == "__main__":
    port = int(os.environ.get("PORT", "5001"))
    app.run(host="127.0.0.1", port=port)
