<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Datos educativos sobre la comunidad sorda y la sordera
$informacion_sordos = [
    "definicion" => [
        "titulo" => "¿Qué es la sordera?",
        "descripcion" => "La sordera es la pérdida total o parcial de la capacidad auditiva. Puede ser congénita (de nacimiento) o adquirida a lo largo de la vida.",
        "tipos" => [
            [
                "tipo" => "Sordera conductiva",
                "descripcion" => "Problema en el oído externo o medio que impide que el sonido llegue al oído interno.",
                "causas" => ["Cerumen", "Infecciones", "Perforación del tímpano", "Malformaciones"]
            ],
            [
                "tipo" => "Sordera neurosensorial",
                "descripcion" => "Daño en el oído interno o en el nervio auditivo.",
                "causas" => ["Envejecimiento", "Exposición a ruido", "Genética", "Infecciones virales"]
            ],
            [
                "tipo" => "Sordera mixta",
                "descripcion" => "Combinación de sordera conductiva y neurosensorial.",
                "causas" => ["Múltiples factores", "Daños combinados", "Patologías complejas"]
            ]
        ]
    ],
    
    "causas_principales" => [
        "congenitas" => [
            "titulo" => "Causas Congénitas",
            "descripcion" => "Presentes desde el nacimiento",
            "factores" => [
                [
                    "causa" => "Genética hereditaria",
                    "porcentaje" => "50-60%",
                    "descripcion" => "Mutaciones genéticas transmitidas de padres a hijos. Más de 400 genes están relacionados con la pérdida auditiva.",
                    "tipos" => ["Síndrome de Usher", "Síndrome de Pendred", "Sordera no sindrómica"]
                ],
                [
                    "causa" => "Infecciones maternas durante embarazo",
                    "porcentaje" => "15-20%",
                    "descripcion" => "Infecciones virales que afectan el desarrollo auditivo del feto.",
                    "ejemplos" => ["Rubéola", "Citomegalovirus", "Toxoplasmosis", "Herpes", "Sífilis"]
                ],
                [
                    "causa" => "Complicaciones perinatales",
                    "porcentaje" => "10-15%",
                    "descripcion" => "Problemas durante el parto o primeras semanas de vida.",
                    "factores" => ["Prematuridad", "Bajo peso al nacer", "Hipoxia", "Ictericia severa"]
                ],
                [
                    "causa" => "Malformaciones anatómicas",
                    "porcentaje" => "5-10%",
                    "descripcion" => "Desarrollo anormal de estructuras del oído.",
                    "tipos" => ["Atresia del conducto auditivo", "Malformaciones del oído interno", "Microtia"]
                ]
            ]
        ],
        
        "adquiridas" => [
            "titulo" => "Causas Adquiridas",
            "descripcion" => "Desarrolladas después del nacimiento",
            "factores" => [
                [
                    "causa" => "Exposición a ruido",
                    "descripcion" => "Daño por sonidos intensos de manera prolongada o súbita.",
                    "niveles_peligrosos" => "Más de 85 decibeles por períodos prolongados",
                    "ejemplos" => ["Música alta", "Maquinaria industrial", "Explosiones", "Tráfico intenso"],
                    "prevencion" => ["Protectores auditivos", "Limitar tiempo de exposición", "Descansos auditivos"]
                ],
                [
                    "causa" => "Infecciones",
                    "descripcion" => "Bacterias, virus u hongos que dañan estructuras auditivas.",
                    "tipos" => ["Meningitis", "Otitis media crónica", "Laberintitis", "Encefalitis"],
                    "prevencion" => ["Vacunación", "Tratamiento temprano", "Higiene auditiva"]
                ],
                [
                    "causa" => "Medicamentos ototóxicos",
                    "descripcion" => "Fármacos que pueden dañar el oído interno.",
                    "ejemplos" => ["Algunos antibióticos", "Quimioterapia", "Diuréticos de asa", "Aspirina en altas dosis"],
                    "prevencion" => ["Monitoreo médico", "Audiometrías regulares", "Dosis apropiadas"]
                ],
                [
                    "causa" => "Traumatismos",
                    "descripcion" => "Lesiones físicas que afectan el sistema auditivo.",
                    "tipos" => ["Golpes en la cabeza", "Perforación timpánica", "Fracturas de cráneo"],
                    "prevencion" => ["Protección en deportes", "Seguridad vial", "Cuidado en actividades de riesgo"]
                ],
                [
                    "causa" => "Envejecimiento (Presbiacusia)",
                    "descripcion" => "Pérdida auditiva gradual relacionada con la edad.",
                    "caracteristicas" => "Afecta principalmente frecuencias altas, progresiva y bilateral",
                    "inicio" => "Generalmente después de los 65 años",
                    "manejo" => ["Audífonos", "Implantes cocleares", "Terapia auditiva"]
                ]
            ]
        ]
    ],
    
    "grados_perdida" => [
        "clasificacion" => [
            [
                "grado" => "Audición normal",
                "rango_db" => "0-20 dB",
                "descripcion" => "Sin dificultades auditivas significativas",
                "impacto" => "Ninguno"
            ],
            [
                "grado" => "Pérdida leve",
                "rango_db" => "21-40 dB",
                "descripcion" => "Dificultad para escuchar sonidos suaves y susurros",
                "impacto" => "Puede pasar desapercibida, dificultades en ambientes ruidosos"
            ],
            [
                "grado" => "Pérdida moderada",
                "rango_db" => "41-70 dB",
                "descripcion" => "Dificultad para seguir conversaciones sin amplificación",
                "impacto" => "Necesita audífonos, dificultades en comunicación oral"
            ],
            [
                "grado" => "Pérdida severa",
                "rango_db" => "71-90 dB",
                "descripcion" => "Solo escucha sonidos muy fuertes",
                "impacto" => "Requiere audífonos potentes o implante coclear, puede usar lengua de señas"
            ],
            [
                "grado" => "Pérdida profunda",
                "rango_db" => "91+ dB",
                "descripcion" => "Puede no escuchar ningún sonido o solo muy fuertes",
                "impacto" => "Candidato a implante coclear, uso frecuente de lengua de señas"
            ]
        ]
    ],
    
    "cultura_sorda" => [
        "definicion" => "La cultura sorda es una subcultura que se compone de un conjunto de creencias, comportamientos, tradiciones, valores e instituciones compartidas por personas sordas.",
        "caracteristicas" => [
            "Lengua de señas como idioma principal",
            "Identidad cultural positiva de la sordera",
            "Valores comunitarios fuertes",
            "Tradiciones y arte únicos",
            "Perspectiva visual del mundo"
        ],
        "valores" => [
            [
                "valor" => "Comunidad",
                "descripcion" => "Fuerte sentido de pertenencia y apoyo mutuo entre personas sordas."
            ],
            [
                "valor" => "Lengua de señas",
                "descripcion" => "Respeto y orgullo por las lenguas de señas como idiomas completos y naturales."
            ],
            [
                "valor" => "Identidad sorda",
                "descripcion" => "La sordera vista como una diferencia cultural, no como una discapacidad."
            ],
            [
                "valor" => "Accesibilidad visual",
                "descripcion" => "Preferencia por información y comunicación visual."
            ],
            [
                "valor" => "Educación bilingüe",
                "descripcion" => "Importancia de la educación en lengua de señas y lengua escrita."
            ]
        ]
    ],
    
    "lengua_señas_colombiana" => [
        "nombre_oficial" => "Lengua de Señas Colombiana (LSC)",
        "reconocimiento_legal" => "Reconocida oficialmente por la Ley 324 de 1996 y Ley 982 de 2005",
        "usuarios" => "Aproximadamente 450,000 personas sordas en Colombia",
        "caracteristicas" => [
            "Lengua visual-espacial completa",
            "Gramática y sintaxis propias",
            "Variaciones regionales",
            "Reconocida como idioma oficial"
        ],
        "componentes" => [
            [
                "componente" => "Configuración de mano",
                "descripcion" => "Forma que adopta la mano al realizar una seña"
            ],
            [
                "componente" => "Ubicación",
                "descripcion" => "Lugar del cuerpo donde se realiza la seña"
            ],
            [
                "componente" => "Movimiento",
                "descripcion" => "Desplazamiento de las manos durante la seña"
            ],
            [
                "componente" => "Orientación",
                "descripcion" => "Dirección hacia donde apuntan las palmas y dedos"
            ],
            [
                "componente" => "Expresión facial",
                "descripcion" => "Gestos que aportan significado gramatical y emocional"
            ]
        ],
        "importancia_educativa" => [
            "Facilita el aprendizaje académico",
            "Permite desarrollo cognitivo completo",
            "Base para aprendizaje del español escrito",
            "Herramienta de inclusión social",
            "Preserva identidad cultural sorda"
        ]
    ],
    
    "tecnologias_apoyo" => [
        "audifonos" => [
            "descripcion" => "Dispositivos que amplifican el sonido para personas con pérdida auditiva",
            "tipos" => ["Retroauriculares", "Intrauriculares", "De conducción ósea"],
            "beneficiarios" => "Personas con pérdida leve a severa"
        ],
        "implantes_cocleares" => [
            "descripcion" => "Dispositivo electrónico que estimula directamente el nervio auditivo",
            "candidatos" => "Pérdida severa a profunda que no se beneficia de audífonos",
            "componentes" => ["Procesador externo", "Implante interno", "Electrodos cocleares"]
        ],
        "sistemas_fm" => [
            "descripcion" => "Tecnología que transmite sonido directamente al audífono o implante",
            "uso" => "Ambientes educativos y profesionales",
            "ventajas" => ["Reduce ruido de fondo", "Mejora relación señal-ruido"]
        ],
        "aplicaciones_moviles" => [
            "descripcion" => "Apps que facilitan comunicación y accesibilidad",
            "ejemplos" => ["Traductores de voz a texto", "Videollamadas", "Alertas visuales"]
        ]
    ],
    
    "inclusion_educativa" => [
        "enfoques" => [
            [
                "enfoque" => "Educación bilingüe bicultural",
                "descripcion" => "LSC como primera lengua y español escrito como segunda lengua",
                "ventajas" => ["Desarrollo cognitivo completo", "Identidad cultural fuerte", "Mejor rendimiento académico"]
            ],
            [
                "enfoque" => "Inclusión con apoyo",
                "descripcion" => "Estudiantes sordos en aulas regulares con intérpretes y adaptaciones",
                "ventajas" => ["Interacción con oyentes", "Preparación para mundo laboral"]
            ],
            [
                "enfoque" => "Oralismo",
                "descripcion" => "Énfasis en desarrollo del habla y lectura labial",
                "consideraciones" => "Efectividad variable según cada persona"
            ]
        ],
        "adaptaciones_necesarias" => [
            "Intérpretes de LSC calificados",
            "Material visual y escrito",
            "Sistemas de amplificación sonora",
            "Profesores con conocimiento en LSC",
            "Evaluaciones adaptadas",
            "Apoyo psicosocial"
        ]
    ],
    
    "mitos_realidades" => [
        [
            "mito" => "Las personas sordas no pueden conducir",
            "realidad" => "Las personas sordas pueden conducir normalmente. Estudios muestran que son conductores muy seguros debido a su aguda percepción visual."
        ],
        [
            "mito" => "Todas las personas sordas leen los labios",
            "realidad" => "Solo un 30-40% del español es visible en los labios. No todas las personas sordas leen labios y es una habilidad que requiere entrenamiento."
        ],
        [
            "mito" => "La lengua de señas es universal",
            "realidad" => "Cada país tiene su propia lengua de señas. Colombia tiene la LSC, que es diferente de otras lenguas de señas."
        ],
        [
            "mito" => "Las personas sordas son menos inteligentes",
            "realidad" => "La inteligencia no está relacionada con la audición. Las personas sordas tienen las mismas capacidades cognitivas que las oyentes."
        ],
        [
            "mito" => "Los audífonos curan la sordera",
            "realidad" => "Los audífonos amplifican el sonido pero no restauran la audición natural. La efectividad varía según el tipo de pérdida auditiva."
        ]
    ],
    
    "datos_estadisticos" => [
        "mundial" => [
            "poblacion_sorda" => "Más de 70 millones de personas sordas en el mundo",
            "lenguas_señas" => "Más de 300 lenguas de señas diferentes",
            "acceso_educacion" => "Solo 1% de niños sordos tiene acceso a educación en lengua de señas"
        ],
        "colombia" => [
            "poblacion_sorda" => "Aproximadamente 450,000 personas con limitación auditiva",
            "niños_sordos" => "Cerca de 45,000 niños y adolescentes sordos en edad escolar",
            "interpretes" => "Déficit significativo de intérpretes de LSC certificados"
        ]
    ],
    
    "como_comunicarse" => [
        "consejos_basicos" => [
            "Establecer contacto visual antes de hablar",
            "Hablar de frente, nunca de espaldas",
            "Usar gestos y expresiones faciales naturales",
            "Hablar con velocidad normal, no exagerar",
            "Si no entiende, escribir o usar gestos",
            "Ser paciente y respetuoso",
            "Preguntar cuál es su método preferido de comunicación"
        ],
        "que_no_hacer" => [
            "No gritar (no ayuda)",
            "No hablar excesivamente lento",
            "No cubrir la boca al hablar",
            "No dar la espalda mientras habla",
            "No ignorar o excluir de conversaciones grupales",
            "No asumir que todos leen labios",
            "No tocar sin permiso para llamar atención"
        ]
    ]
];

// Procesar solicitudes
$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        if (isset($_GET['seccion'])) {
            $seccion = $_GET['seccion'];
            if (isset($informacion_sordos[$seccion])) {
                echo json_encode([
                    'success' => true,
                    'seccion' => $seccion,
                    'data' => $informacion_sordos[$seccion]
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([
                    'success' => false,
                    'error' => 'Sección no encontrada',
                    'secciones_disponibles' => array_keys($informacion_sordos)
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }
        } else {
            // Devolver todas las secciones disponibles
            echo json_encode([
                'success' => true,
                'message' => 'API de información sobre sordera y comunidad sorda',
                'secciones_disponibles' => array_keys($informacion_sordos),
                'uso' => 'Agregue ?seccion=nombre_seccion para obtener información específica',
                'ejemplos' => [
                    '?seccion=definicion',
                    '?seccion=causas_principales',
                    '?seccion=cultura_sorda',
                    '?seccion=lengua_señas_colombiana'
                ]
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        break;
        
    case 'POST':
        // Para futuras funcionalidades como búsqueda o filtrado
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (isset($input['buscar'])) {
            $termino = strtolower($input['buscar']);
            $resultados = [];
            
            foreach ($informacion_sordos as $seccion => $contenido) {
                $contenido_json = json_encode($contenido, JSON_UNESCAPED_UNICODE);
                if (strpos(strtolower($contenido_json), $termino) !== false) {
                    $resultados[$seccion] = $contenido;
                }
            }
            
            echo json_encode([
                'success' => true,
                'termino_busqueda' => $input['buscar'],
                'resultados_encontrados' => count($resultados),
                'data' => $resultados
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'Parámetro de búsqueda requerido',
                'formato' => '{"buscar": "término a buscar"}'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'error' => 'Método no permitido',
            'metodos_soportados' => ['GET', 'POST']
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        break;
}
?>