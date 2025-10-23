const express = require("express");
const path = require("path");
const fs = require("fs");
const cors = require("cors");
const multer = require("multer");

const app = express();
const PORT = process.env.PORT || 3000;
const RESPONSES_FILE = path.join(__dirname, "responses.json");
const UPLOADS_DIR = path.join(__dirname, "uploads");

// Middleware
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname)));

// ----------- Funciones auxiliares -----------
function loadResponses() {
  try {
    const data = fs.readFileSync(RESPONSES_FILE, "utf8");
    return JSON.parse(data);
  } catch {
    return [];
  }
}

function saveResponses(responses) {
  fs.writeFileSync(RESPONSES_FILE, JSON.stringify(responses, null, 2));
}

// ----------- ChatBot lógica -----------
function generateBotResponse(message) {
  if (!message) return "No recibí ningún mensaje.";

  const lower = message.toLowerCase();
  const responses = loadResponses();

  for (const rule of responses) {
    if (rule.keywords.some(k => lower.includes(k.toLowerCase()))) {
      return rule.response;
    }
  }

  return "No entendí tu pregunta. ¿Podrías reformularla o preguntar algo sobre la LSC?";
}

// ----------- Endpoints del chatbot -----------
app.post("/api/chat", (req, res) => {
  const { message } = req.body;
  const reply = generateBotResponse(message);
  res.json({ reply });
});

// ----------- Upload de archivos -----------
// Asegurar que la carpeta de uploads exista antes de usar multer
if (!fs.existsSync(UPLOADS_DIR)) {
  fs.mkdirSync(UPLOADS_DIR, { recursive: true });
}
const upload = multer({ dest: UPLOADS_DIR });
app.post("/api/upload", upload.single("file"), (req, res) => {
  if (!req.file) return res.status(400).json({ error: "No se recibió archivo." });
  res.json({ message: `Archivo ${req.file.originalname} subido correctamente.` });
});

// ----------- API para administrar respuestas -----------
app.get("/api/responses", (req, res) => {
  res.json(loadResponses());
});

app.post("/api/responses", (req, res) => {
  const { keywords, response } = req.body;
  if (!keywords || !response) return res.status(400).json({ error: "Datos incompletos" });

  const responses = loadResponses();
  const newItem = {
    id: responses.length ? responses[responses.length - 1].id + 1 : 1,
    keywords: keywords.split(",").map(k => k.trim()),
    response,
  };
  responses.push(newItem);
  saveResponses(responses);
  res.json(newItem);
});

app.put("/api/responses/:id", (req, res) => {
  const id = parseInt(req.params.id);
  const { keywords, response } = req.body;
  const responses = loadResponses();
  const index = responses.findIndex(r => r.id === id);

  if (index === -1) return res.status(404).json({ error: "No encontrado" });
  responses[index] = {
    id,
    keywords: keywords.split(",").map(k => k.trim()),
    response,
  };
  saveResponses(responses);
  res.json(responses[index]);
});

app.delete("/api/responses/:id", (req, res) => {
  const id = parseInt(req.params.id);
  let responses = loadResponses();
  responses = responses.filter(r => r.id !== id);
  saveResponses(responses);
  res.json({ success: true });
});

// ----------- Rutas front-end -----------
app.get("/", (req, res) => res.sendFile(path.join(__dirname, "Chatbot.html")));
app.get("/admin", (req, res) => res.sendFile(path.join(__dirname, "admin.html")));

// ----------- Servidor -----------
app.listen(PORT, () => console.log(`Servidor activo en http://localhost:${PORT}`));