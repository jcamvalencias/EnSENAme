<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Datos educativos sobre la comunidad sorda y la sordera
$informacion_sordos = [
    "definicion" => [
        "titulo" => "¿Qué es la sordera?",
        "descripcion" => "La sordera es la pérdida total o parcial de la capacidad auditiva. Afecta aproximadamente al 5% de la población mundial (466 millones de personas según la OMS 2021). Puede ser congénita (de nacimiento) o adquirida a lo largo de la vida. La pérdida auditiva se mide en decibelios (dB) y se clasifica según su grado y tipo.",
        "prevalencia_mundial" => [
            "total_personas" => "466 millones",
            "ninos" => "34 millones",
            "adultos" => "432 millones",
            "perdida_incapacitante" => "278 millones",
            "proyeccion_2050" => "900 millones"
        ],
        "tipos" => [
            [
                "tipo" => "Sordera conductiva",
                "descripcion" => "Problema en el oído externo o medio que impide que el sonido llegue al oído interno. Generalmente tratable médica o quirúrgicamente.",
                "causas" => ["Cerumen excesivo", "Otitis media crónica", "Perforación del tímpano", "Otosclerosis", "Malformaciones congénitas"],
                "tratamiento" => "Cirugía, medicamentos, audífonos de conducción ósea"
            ],
            [
                "tipo" => "Sordera neurosensorial",
                "descripcion" => "Daño en el oído interno (cóclea) o en el nervio auditivo. Es el tipo más común y generalmente permanente.",
                "causas" => ["Envejecimiento (presbiacusia)", "Exposición a ruido intenso", "Genética", "Infecciones virales", "Medicamentos ototóxicos"],
                "tratamiento" => "Audífonos, implantes cocleares, terapia de rehabilitación auditiva"
            ],
            [
                "tipo" => "Sordera mixta",
                "descripcion" => "Combinación de sordera conductiva y neurosensorial. Requiere enfoque de tratamiento múltiple.",
                "causas" => ["Múltiples factores", "Traumas complejos", "Patologías degenerativas", "Infecciones severas"],
                "tratamiento" => "Combinación de cirugía, audífonos e implantes según el caso"
            ],
            [
                "tipo" => "Neuropatía auditiva",
                "descripcion" => "El oído interno detecta el sonido normalmente, pero hay problemas en la transmisión al cerebro.",
                "causas" => ["Problemas genéticos", "Hiperbilirrubinemia neonatal", "Infecciones", "Trastornos neurológicos"],
                "tratamiento" => "Implantes cocleares, terapia de habla, sistemas FM"
            ]
        ]
    ],
    
    "grados_perdida" => [
        "titulo" => "Grados de pérdida auditiva",
        "descripcion" => "La pérdida auditiva se clasifica según el umbral auditivo medido en decibelios (dB HL). Esta clasificación ayuda a determinar el tipo de apoyo y tecnología más adecuados.",
        "clasificacion" => [
            [
                "grado" => "Audición normal",
                "rango_db" => "0-20 dB",
                "descripcion" => "No hay dificultades auditivas significativas",
                "impacto" => "Ninguno",
                "apoyo_requerido" => "Ninguno"
            ],
            [
                "grado" => "Pérdida leve",
                "rango_db" => "21-40 dB",
                "descripcion" => "Dificultad para escuchar sonidos suaves y conversaciones en entornos ruidosos",
                "impacto" => "Problemas en ambientes ruidosos, puede afectar el desarrollo del habla en niños",
                "apoyo_requerido" => "Audífonos, sistemas FM, estrategias de comunicación"
            ],
            [
                "grado" => "Pérdida moderada",
                "rango_db" => "41-70 dB",
                "descripcion" => "Dificultad para escuchar conversaciones normales sin amplificación",
                "impacto" => "Necesita hablar más fuerte, dificultades en conversaciones grupales",
                "apoyo_requerido" => "Audífonos obligatorios, terapia de habla, apoyo educativo especial"
            ],
            [
                "grado" => "Pérdida severa",
                "rango_db" => "71-90 dB",
                "descripcion" => "Solo escucha sonidos muy fuertes, la conversación normal es inaudible",
                "impacto" => "Dependencia visual para comunicación, retraso en desarrollo del lenguaje",
                "apoyo_requerido" => "Audífonos potentes, implantes cocleares, LSC, educación bilingüe"
            ],
            [
                "grado" => "Pérdida profunda",
                "rango_db" => "91+ dB",
                "descripcion" => "No escucha sonidos del habla, puede percibir vibraciones y sonidos muy intensos",
                "impacto" => "Comunicación principalmente visual, identidad cultural sorda",
                "apoyo_requerido" => "Implantes cocleares, LSC como lengua principal, cultura sorda"
            ]
        ]
    ],

    "causas_principales" => [
        "titulo" => "Principales causas de sordera",
        "descripcion" => "Las causas de sordera varían según la edad de aparición. Se dividen en congénitas (presentes al nacer) y adquiridas (desarrolladas después del nacimiento).",
        "congenitas" => [
            "titulo" => "Causas Congénitas (50-60% de casos)",
            "descripcion" => "Presentes desde el nacimiento, a menudo detectables en los primeros meses de vida",
            "factores" => [
                [
                    "causa" => "Genética hereditaria",
                    "porcentaje" => "50-60%",
                    "descripcion" => "Mutaciones genéticas transmitidas de padres a hijos. Más de 400 genes están relacionados con la pérdida auditiva. Puede ser sindrómica (parte de un síndrome) o no sindrómica (aislada).",
                    "tipos" => ["Síndrome de Usher (sordera + ceguera progresiva)", "Síndrome de Pendred (sordera + problemas tiroideos)", "Síndrome de Waardenburg (sordera + alteraciones pigmentarias)", "Sordera no sindrómica (70% de casos genéticos)"],
                    "herencia" => ["Autosómica recesiva (80%)", "Autosómica dominante (15%)", "Ligada al cromosoma X (2-3%)", "Mitocondrial (1%)"]
                ],
                [
                    "causa" => "Infecciones maternas durante embarazo",
                    "porcentaje" => "15-20%",
                    "descripcion" => "Infecciones virales que afectan el desarrollo auditivo del feto, especialmente durante el primer trimestre.",
                    "ejemplos" => ["Rubéola (causa más común históricamente)", "Citomegalovirus (CMV)", "Toxoplasmosis", "Herpes simple", "Sífilis", "Zika virus"],
                    "prevencion" => "Vacunación, control prenatal, evitar exposición a vectores"
                ],
                [
                    "causa" => "Complicaciones perinatales",
                    "porcentaje" => "10-15%",
                    "descripcion" => "Problemas durante el parto o primeras semanas de vida que afectan el sistema auditivo.",
                    "factores" => ["Hipoxia neonatal", "Prematuridad extrema (<32 semanas)", "Bajo peso al nacer (<1500g)", "Hiperbilirrubinemia severa", "Uso de medicamentos ototóxicos", "Meningitis bacteriana neonatal"],
                    "prevencion" => "Cuidado prenatal adecuado, control del parto, UCIN especializada"
                ]
            ]
        ],
        "adquiridas" => [
            "titulo" => "Causas Adquiridas",
            "descripcion" => "Desarrolladas después del nacimiento debido a diversos factores ambientales, médicos o traumáticos",
            "factores" => [
                [
                    "causa" => "Exposición a ruido",
                    "porcentaje" => "30-40%",
                    "descripcion" => "Daño coclear por exposición prolongada o intensa a sonidos fuertes. Tipo más prevenible de pérdida auditiva.",
                    "tipos" => ["Trauma acústico agudo (>140 dB)", "Pérdida inducida por ruido ocupacional", "Pérdida por música/auriculares", "Trauma por explosión"],
                    "niveles_peligrosos" => ["85 dB por 8 horas/día", "100 dB por 15 minutos", "110 dB por 1 minuto", "120+ dB inmediato"],
                    "prevencion" => "Protección auditiva, límites de exposición, pausas auditivas"
                ],
                [
                    "causa" => "Envejecimiento (Presbiacusia)",
                    "porcentaje" => "35-40%",
                    "descripcion" => "Deterioro gradual del sistema auditivo con la edad. Afecta especialmente frecuencias altas.",
                    "epidemiologia" => ["33% en personas >65 años", "50% en personas >75 años", "Más común en hombres", "Acelera con factores ambientales"],
                    "caracteristicas" => "Pérdida gradual, bilateral, simétrica, dificultad en ruido"
                ],
                [
                    "causa" => "Infecciones",
                    "porcentaje" => "15-20%",
                    "descripcion" => "Infecciones que dañan estructuras auditivas directa o indirectamente.",
                    "tipos" => ["Meningitis bacteriana (30% desarrolla sordera)", "Otitis media crónica", "Mastoiditis", "Laberintitis", "Neuritis vestibular", "COVID-19 (casos reportados)"],
                    "prevencion" => "Vacunación, tratamiento temprano, higiene adecuada"
                ],
                [
                    "causa" => "Medicamentos ototóxicos",
                    "porcentaje" => "10-15%",
                    "descripcion" => "Medicamentos que dañan el oído interno como efecto secundario.",
                    "categorias" => [
                        "Aminoglucósidos (gentamicina, estreptomicina)",
                        "Diuréticos de asa (furosemida)",
                        "Quimioterapia (cisplatino, carboplatino)",
                        "Antipalúdicos (cloroquina, quinina)",
                        "Salicilatos (aspirina en altas dosis)"
                    ],
                    "factores_riesgo" => "Dosis altas, uso prolongado, función renal comprometida, edad avanzada"
                ],
                [
                    "causa" => "Traumatismos",
                    "porcentaje" => "5-10%",
                    "descripcion" => "Lesiones físicas que afectan el sistema auditivo.",
                    "tipos" => ["Fractura de hueso temporal", "Perforación timpánica", "Luxación osicular", "Trauma craneoencefálico", "Barotrauma"],
                    "prevencion" => "Equipos de protección, seguridad vial, deportes seguros"
                ]
            ]
        ]
    ],
    
    "lengua_señas_colombiana" => [
        "titulo" => "Lengua de Señas Colombiana (LSC)",
        "descripcion" => "La LSC es la lengua natural de la comunidad sorda colombiana, reconocida oficialmente como lengua de las personas sordas de Colombia mediante las leyes 324 de 1996 y 982 de 2005. Es una lengua visual-espacial completa con su propia gramática, sintaxis y léxico.",
        "reconocimiento_legal" => [
            "ley_324_1996" => "Reconoce la LSC como lengua propia de la comunidad sorda",
            "ley_982_2005" => "Establece normas para equiparación de oportunidades",
            "ley_1346_2009" => "Ratifica la Convención sobre Derechos de las Personas con Discapacidad",
            "decreto_1421_2017" => "Reglamenta la educación inclusiva"
        ],
        "estadisticas" => [
            "usuarios_estimados" => "450,000-500,000 personas",
            "sordos_usuarios" => "180,000 personas sordas",
            "oyentes_usuarios" => "270,000-320,000 familiares e intérpretes",
            "interpretes_certificados" => "800+ intérpretes",
            "instituciones_educativas" => "120+ colegios con programas bilingües"
        ],
        "caracteristicas_linguisticas" => [
            "modalidad" => "Visual-espacial (no auditivo-vocal)",
            "canal" => "Gestual-visual",
            "estructura" => "Morfología, sintaxis y semántica propias",
            "iconicidad" => "Mayor que lenguas orales pero arbitraria en gran parte",
            "variacion_regional" => "Dialectos regionales (Bogotá, Medellín, Cali, Costa)"
        ],
        "componentes_señas" => [
            [
                "componente" => "Configuración de mano (Handshape)",
                "descripcion" => "Forma que adoptan los dedos y la mano al hacer una seña",
                "ejemplos" => ["Puño cerrado", "Índice extendido", "Mano abierta", "Configuración L"],
                "total_configuraciones" => "60+ configuraciones básicas en LSC"
            ],
            [
                "componente" => "Ubicación (Location)",
                "descripcion" => "Lugar del cuerpo donde se ejecuta la seña",
                "zonas" => ["Cabeza y cara", "Torso", "Brazos y manos", "Espacio neutro"],
                "precision" => "Ubicación específica afecta el significado"
            ],
            [
                "componente" => "Movimiento (Movement)",
                "descripcion" => "Tipo y dirección del movimiento de las manos",
                "tipos" => ["Rectilíneo", "Circular", "Zigzag", "Vibratorio", "Repetitivo"],
                "funciones" => "Puede indicar tiempo, aspecto, intensidad"
            ],
            [
                "componente" => "Orientación de palmas",
                "descripcion" => "Dirección hacia donde apuntan las palmas de las manos",
                "variaciones" => ["Hacia arriba", "Hacia abajo", "Hacia el cuerpo", "Hacia afuera"],
                "importancia" => "Cambios mínimos alteran completamente el significado"
            ],
            [
                "componente" => "Expresión facial y corporal",
                "descripcion" => "Elementos no manuales que aportan información gramatical",
                "funciones" => ["Preguntas (cejas arriba)", "Negación (movimiento de cabeza)", "Énfasis (inclinación corporal)", "Adjetivos (expresiones específicas)"],
                "importancia" => "Esencial para la gramática y el significado"
            ]
        ],
        "estructura_gramatical" => [
            "orden_basico" => "SOV (Sujeto-Objeto-Verbo) predominante, pero flexible",
            "clasificadores" => "Formas de mano que representan categorías de objetos",
            "uso_espacio" => "El espacio se usa gramaticalmente para referencias",
            "tiempo_verbal" => "Se marca mediante adverbios temporales y línea temporal",
            "negacion" => "Movimiento de cabeza + señas específicas de negación",
            "preguntas" => "Marcadas facialmente y con señas interrogativas"
        ],
        "variaciones_regionales" => [
            [
                "region" => "Bogotá y Cundinamarca",
                "caracteristicas" => "Considerada variedad estándar, usada en medios nacionales",
                "instituciones" => "INSOR, Instituto Pedagógico Nacional",
                "particularidades" => "Mayor influencia del español signado"
            ],
            [
                "region" => "Antioquia (Medellín)",
                "caracteristicas" => "Variaciones lexicales distintivas, ritmo diferente",
                "instituciones" => "Institución Educativa Francisco Luis Hernández Betancur",
                "particularidades" => "Señas únicas para conceptos regionales"
            ],
            [
                "region" => "Valle del Cauca (Cali)",
                "caracteristicas" => "Influencia de la cultura afrocolombiana",
                "instituciones" => "Escuela de Sordos de Cali",
                "particularidades" => "Expresiones corporales más marcadas"
            ],
            [
                "region" => "Costa Atlántica",
                "caracteristicas" => "Influencia del español costeño en algunos préstamos",
                "instituciones" => "Instituto para Sordos de Barranquilla",
                "particularidades" => "Adaptaciones culturales caribeñas"
            ]
        ]
    ],

    "cultura_sorda" => [
        "titulo" => "Cultura Sorda",
        "definicion" => "La cultura sorda es una identidad cultural única basada en la experiencia visual del mundo, la lengua de señas como lengua natural, y valores comunitarios específicos. No se define por la pérdida auditiva sino por la pertenencia cultural y lingüística.",
        "conceptos_fundamentales" => [
            [
                "concepto" => "Sordera como diferencia cultural",
                "descripcion" => "La sordera se ve como una diferencia lingüística y cultural, no como una discapacidad médica",
                "implicaciones" => "Orgullo cultural, preferencia por el término 'Sordo' con mayúscula",
                "contraste" => "Difiere del modelo médico que ve la sordera como deficiencia"
            ],
            [
                "concepto" => "Experiencia visual del mundo",
                "descripcion" => "Percepción y procesamiento principalmente visual de la información",
                "manifestaciones" => ["Comunicación visual", "Arte visual", "Arquitectura accesible", "Tecnología visual"],
                "ventajas" => "Agudeza visual superior, percepción periférica desarrollada"
            ],
            [
                "concepto" => "Comunidad y colectivismo",
                "descripcion" => "Fuerte sentido de comunidad y apoyo mutuo entre personas sordas",
                "prácticas" => ["Reuniones comunitarias", "Eventos culturales", "Apoyo intergeneracional", "Transmisión cultural"],
                "importancia" => "Red de apoyo fundamental para la identidad"
            ]
        ],
        "valores_culturales" => [
            [
                "valor" => "Información compartida",
                "descripcion" => "Tradición de compartir información extensa y detallada en la comunidad",
                "razones" => "Históricamente excluidos de información general",
                "prácticas" => "Conversaciones largas, detalles contextuales, redes informativas"
            ],
            [
                "valor" => "Franqueza y directividad",
                "descripcion" => "Comunicación directa y honesta, sin rodeos innecesarios",
                "contexto_cultural" => "La comunicación visual requiere claridad",
                "ejemplos" => "Preguntas directas sobre temas personales, feedback inmediato"
            ],
            [
                "valor" => "Respeto por los ancianos sordos",
                "descripcion" => "Veneración especial por sordos mayores como transmisores de cultura",
                "roles" => "Mentores, narradores de historia, preservadores de tradiciones",
                "importancia" => "Custodios de la LSC y tradiciones culturales"
            ],
            [
                "valor" => "Accesibilidad visual",
                "descripcion" => "Diseño de espacios y actividades pensando en la experiencia visual",
                "aplicaciones" => ["Iluminación adecuada", "Disposición circular en reuniones", "Alertas visuales", "Reducción de barreras visuales"],
                "filosofia" => "El entorno debe adaptarse a la cultura, no al revés"
            ]
        ],
        "tradiciones_y_eventos" => [
            [
                "evento" => "Semana Internacional de las Personas Sordas",
                "fecha" => "Última semana de septiembre",
                "descripcion" => "Celebración mundial de la cultura sorda y concientización",
                "actividades_colombia" => ["Festivales de LSC", "Obras de teatro", "Conferencias", "Exposiciones culturales"]
            ],
            [
                "evento" => "Festival de Arte y Cultura Sorda",
                "frecuencia" => "Anual en diferentes ciudades",
                "descripcion" => "Celebración de expresiones artísticas de la comunidad sorda",
                "disciplinas" => ["Teatro en LSC", "Poesía visual", "Narración", "Danza", "Artes plásticas"]
            ],
            [
                "evento" => "Encuentros deportivos sordos",
                "tipos" => ["Deaflympics (Olimpiadas Sordas)", "Juegos Suramericanos Sordos", "Campeonatos nacionales"],
                "importancia" => "Fortalecimiento de identidad y orgullo cultural",
                "modalidades" => "Fútbol, voleibol, atletismo, natación, ciclismo"
            ]
        ],
        "arte_y_expresiones" => [
            [
                "expresion" => "Teatro sordo",
                "caracteristicas" => "Uso de LSC, expresión corporal exagerada, elementos visuales",
                "grupos_colombia" => ["Teatro Arlequín de Sordos", "Grupo Teatral Manos que Hablan"],
                "temas" => "Experiencias sordas, historia de la comunidad, temas universales"
            ],
            [
                "expresion" => "Poesía en LSC",
                "caracteristicas" => "Juegos visuales, ritmo espacial, metáforas visuales",
                "elementos" => ["Aliteración manual", "Rimas visuales", "Simetría espacial"],
                "poetas_reconocidos" => "Varios poetas sordos colombianos emergentes"
            ],
            [
                "expresion" => "Narración visual",
                "caracteristicas" => "Historias tradicionales adaptadas a la modalidad visual",
                "géneros" => ["Cuentos folclóricos", "Historias personales", "Leyendas urbanas sordas"],
                "importancia" => "Transmisión cultural y preservación de memoria colectiva"
            ],
            [
                "expresion" => "Arte visual",
                "temas_comunes" => ["Manos y gestualidad", "Experiencias visuales", "Identidad sorda"],
                "artistas" => "Comunidad creciente de artistas sordos colombianos",
                "medios" => "Pintura, escultura, arte digital, fotografía"
            ]
        ],
        "organizaciones_colombia" => [
            [
                "organizacion" => "FENASCOL",
                "nombre_completo" => "Federación Nacional de Sordos de Colombia",
                "fundacion" => "1984",
                "mision" => "Promoción y defensa de derechos de personas sordas",
                "programas" => ["Advocacy", "Educación", "Capacitación", "Desarrollo comunitario"]
            ],
            [
                "organizacion" => "ASORGUA",
                "nombre_completo" => "Asociación de Sordos de Guaviare",
                "tipo" => "Organización regional",
                "actividades" => "Promoción de LSC y derechos locales"
            ],
            [
                "organizacion" => "INSOR",
                "nombre_completo" => "Instituto Nacional para Sordos",
                "tipo" => "Institución gubernamental",
                "funciones" => ["Investigación", "Política pública", "Educación", "Certificación de intérpretes"]
            ]
        ]
    ],
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
    ],
    
    "tecnologias_apoyo" => [
        "titulo" => "Tecnologías de Apoyo Auditivo",
        "descripcion" => "Conjunto de dispositivos y tecnologías diseñadas para mejorar la comunicación y accesibilidad de personas con pérdida auditiva",
        "audifonos" => [
            "descripcion" => "Dispositivos que amplifican y procesan el sonido para personas con pérdida auditiva leve a severa",
            "tipos" => ["Retroauriculares (BTE)", "Intraauriculares (ITE)", "Receptor en el canal (RIC)", "Completamente en el canal (CIC)"],
            "tecnologia" => "Procesamiento digital, reducción de ruido, conectividad Bluetooth",
            "costo_promedio" => "$1,000,000 - $8,000,000 COP según modelo y tecnología"
        ],
        "implantes_cocleares" => [
            "descripcion" => "Dispositivos electrónicos que estimulan directamente el nervio auditivo",
            "candidatos" => "Pérdida auditiva severa a profunda con beneficio limitado de audífonos",
            "proceso" => "Evaluación médica, cirugía, activación, rehabilitación auditiva",
            "resultados" => "Detección de sonidos ambientales, comprensión del habla, uso del teléfono",
            "cobertura" => "Incluido en el POS según criterios médicos específicos"
        ],
        "sistemas_fm" => [
            "descripcion" => "Transmisión inalámbrica de sonido directo a audífonos o implantes",
            "aplicaciones" => ["Educación", "Conferencias", "Reuniones laborales", "Uso doméstico"],
            "ventajas" => "Supera distancia y ruido de fondo, mejora comprensión del habla"
        ],
        "aplicaciones_moviles" => [
            "comunicacion" => ["Google Live Transcribe", "Ava", "SignTime"],
            "alertas" => ["Flash alarms", "Vibra alertas", "Sound notifications"],
            "educacion" => ["LSC Colombia", "Sign School", "Hearing Helper"],
            "accesibilidad" => ["Be My Eyes", "Voice Control", "Switch Control"]
        ]
    ],

    "inclusion_educativa" => [
        "titulo" => "Educación Inclusiva para Personas Sordas",
        "descripcion" => "Marco educativo que garantiza el derecho a educación de calidad respetando la diversidad lingüística",
        "modelos_educativos" => [
            [
                "modelo" => "Educación Bilingüe-Bicultural",
                "caracteristicas" => "LSC como primera lengua, español escrito como segunda lengua",
                "ventajas" => ["Desarrollo cognitivo natural", "Identidad cultural sólida", "Competencia bilingüe real"]
            ],
            [
                "modelo" => "Inclusión con Apoyos",
                "caracteristicas" => "Estudiantes sordos en aulas regulares con intérpretes y apoyos",
                "requisitos" => ["Intérpretes capacitados", "Tecnología asistiva", "Docentes preparados"]
            ],
            [
                "modelo" => "Escuelas Especializadas",
                "caracteristicas" => "Instituciones específicas para estudiantes sordos",
                "ventajas" => ["Inmersión en LSC", "Comunidad sorda", "Pedagogía especializada"]
            ]
        ],
        "marco_legal" => [
            "Constitución 1991" => "Artículos 13, 47, 68 - Igualdad y educación",
            "Ley 324/1996" => "Reconocimiento LSC y educación bilingüe",
            "Ley 982/2005" => "Equiparación de oportunidades",
            "Decreto 1421/2017" => "Reglamentación educación inclusiva"
        ],
        "estrategias_pedagogicas" => [
            "Aprendizaje visual" => "Mapas conceptuales, organizadores gráficos, videos",
            "Metodología contrastiva" => "Comparación LSC-español escrito",
            "Tecnología educativa" => "Plataformas accesibles, subtítulos, realidad aumentada",
            "Evaluación diferencial" => "Adaptaciones según modalidad lingüística"
        ],
        "retos_actuales" => [
            "Escasez de docentes bilingües LSC-español",
            "Falta de materiales educativos en LSC",
            "Limitado acceso a educación superior",
            "Necesidad de formación docente continua"
        ]
    ],

    "prevencion_salud_auditiva" => [
        "titulo" => "Prevención y Salud Auditiva",
        "descripcion" => "Medidas y estrategias para prevenir la pérdida auditiva y mantener la salud del sistema auditivo",
        "prevencion_primaria" => [
            "embarazo" => [
                "Vacunación contra rubéola, CMV, toxoplasmosis",
                "Control prenatal regular",
                "Evitar medicamentos ototóxicos",
                "Nutrición adecuada con ácido fólico"
            ],
            "infancia" => [
                "Tamizaje auditivo neonatal universal",
                "Vacunación completa (especialmente meningitis)",
                "Protección contra traumatismos",
                "Detección temprana de otitis"
            ],
            "adultos" => [
                "Protección auditiva en ambientes ruidosos",
                "Límites de exposición a música alta",
                "Uso responsable de auriculares",
                "Chequeos auditivos regulares"
            ]
        ],
        "niveles_ruido_seguro" => [
            "0-30 dB" => "Silencio - Susurro",
            "31-60 dB" => "Conversación normal - Seguro prolongado",
            "61-85 dB" => "Tráfico moderado - Límite seguro 8 horas",
            "86-110 dB" => "Tráfico intenso - Tiempo limitado con protección",
            "111+ dB" => "Conciertos, sirenas - Riesgo inmediato"
        ],
        "señales_alerta" => [
            "Dificultad para entender conversaciones",
            "Necesidad de subir volumen TV/radio",
            "Zumbido persistente en oídos (tinnitus)",
            "Sensación de oído tapado",
            "Dolor de oído frecuente",
            "Mareos o problemas de equilibrio"
        ],
        "cuidados_generales" => [
            "Limpieza externa únicamente - no usar copitos",
            "Mantener oídos secos después de nadar",
            "Tratar infecciones respiratorias oportunamente",
            "Evitar automedicación con gotas óticas",
            "Consultar especialista ante síntomas"
        ]
    ],

    "avances_investigacion" => [
        "titulo" => "Avances e Investigación en Audiología",
        "descripcion" => "Últimos desarrollos científicos y tecnológicos en el campo de la audiología y tratamiento de la sordera",
        "terapias_emergentes" => [
            [
                "terapia" => "Terapia Génica",
                "descripcion" => "Introducción de genes para regenerar células ciliadas dañadas",
                "estado" => "Ensayos clínicos fase I/II",
                "perspectivas" => "Potencial para restaurar audición en sorderas genéticas"
            ],
            [
                "terapia" => "Células Madre",
                "descripcion" => "Regeneración de estructuras auditivas usando células madre",
                "desafios" => "Complejidad del oído interno, diferenciación celular dirigida",
                "avances" => "Estudios preclínicos prometedores en modelos animales"
            ],
            [
                "terapia" => "Farmacología Regenerativa",
                "descripcion" => "Medicamentos que estimulan regeneración natural",
                "enfoques" => "Inhibidores de vías de muerte celular, factores de crecimiento",
                "timeline" => "5-10 años para aplicaciones clínicas"
            ]
        ],
        "tecnologia_avanzada" => [
            "Inteligencia Artificial" => "Procesamiento mejorado en audífonos e implantes",
            "Realidad Aumentada" => "Subtítulos en tiempo real con gafas inteligentes",
            "Internet de las Cosas" => "Dispositivos conectados para mejor accesibilidad",
            "Blockchain" => "Historiales médicos seguros y compartidos"
        ],
        "investigacion_colombia" => [
            "Universidad Nacional" => "Estudios en genética de sordera",
            "Universidad Javeriana" => "Desarrollo de tecnologías asistivas",
            "INSOR" => "Investigación en LSC y educación bilingüe",
            "Hospitales de IV nivel" => "Ensayos clínicos internacionales"
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