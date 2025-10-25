# Runner for LSC Flask YOLO service (Windows PowerShell)
# Usage examples:
#   .\run_yolo.ps1                 # default port 5001, autodetect model in folder
#   .\run_yolo.ps1 -Port 5050      # custom port
#   .\run_yolo.ps1 -Model .\best.pt # explicit model path

param(
  [int]$Port = 5001,
  [string]$Model = ''
)

$ErrorActionPreference = 'Stop'
Set-Location -LiteralPath $PSScriptRoot

if (!(Test-Path -LiteralPath '.\.venv')) {
  Write-Host 'Creating virtual environment .venv ...'
  python -m venv .venv
}

& .\.venv\Scripts\Activate.ps1

Write-Host 'Installing Python requirements for YOLO service ...'
pip install -r requirements.yolo.txt

if ($Model -ne '') { $env:LSC_MODEL = (Resolve-Path -LiteralPath $Model).Path }
$env:PORT = "$Port"

Write-Host "Starting YOLO service on http://127.0.0.1:$Port ..."
python .\app_yolo.py
