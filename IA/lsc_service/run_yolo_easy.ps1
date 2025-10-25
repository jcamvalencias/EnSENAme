# Easy runner for LSC YOLO service with minimal friction
# Double-click friendly. Falls back with clear instructions if Python is missing.

param(
  [int]$Port = 5001,
  [string]$Model = ''
)

$ErrorActionPreference = 'SilentlyContinue'
Set-Location -LiteralPath $PSScriptRoot

# Detect Python
$pythonCmd = 'python'
$hasPython = $false
try {
  $v = & $pythonCmd --version 2>$null
  if ($LASTEXITCODE -eq 0) { $hasPython = $true }
} catch {}

if (-not $hasPython) {
  Write-Host 'No se encontró Python en el sistema.' -ForegroundColor Yellow
  Write-Host 'Opciones:'
  Write-Host '  1) Instalar Python (usuario): https://www.python.org/downloads/windows/'
  Write-Host '  2) Usar la IA portable (sin Python): IA\lsc_service\index_portable.html'
  Write-Host 'Saliendo...'
  Start-Sleep -Seconds 6
  exit 1
}

# Create venv if not exists
if (!(Test-Path -LiteralPath '.\\.venv')) {
  Write-Host 'Creando entorno virtual ...'
  & $pythonCmd -m venv .venv
}

# Activate venv
& .\.venv\Scripts\Activate.ps1

# Ensure deps
Write-Host 'Instalando dependencias (requirements.yolo.txt) ...'
& pip install -r requirements.yolo.txt

# Model autodetect
if ($Model -eq '') {
  $candidates = @('lsc.pt','best.pt','weights.pt')
  foreach($n in $candidates){ if (Test-Path -LiteralPath $n) { $Model = $n; break } }
  if ($Model -eq '') {
    $anyPt = Get-ChildItem -LiteralPath . -Filter *.pt -File | Select-Object -First 1
    if ($anyPt) { $Model = $anyPt.FullName }
  }
}
if ($Model -ne '') { $env:LSC_MODEL = (Resolve-Path -LiteralPath $Model).Path }
$env:PORT = "$Port"

Write-Host "Iniciando servicio YOLO en http://127.0.0.1:$Port ..."
& python .\app_yolo.py
