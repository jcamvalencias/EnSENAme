"""
DEPRECATION NOTICE
------------------
Esta ruta ya no usa un microservicio Flask. La IA oficial del proyecto ahora es 100% web (portable) y vive en:

  IA/lsc_service/index_portable.html

Este archivo permanece solo para evitar errores de herramientas que esperan ver `app.py`.
Si lo ejecutas con Python, simplemente imprimirá un mensaje y terminará.
"""

import sys

msg = (
    "[EnSEÑAme] La versión Flask fue descontinuada. "
    "Usa la página portable: IA/lsc_service/index_portable.html"
)
print(msg)
sys.exit(0)
