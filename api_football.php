<?php
/**
 * api_football_pro.php – Script profesional de actualización del Mundial 2026
 * 
 * Uso: php api_football_pro.php
 * 
 * Estructura:
 * - Config:      Carga variables desde Connections/conexion_script.php
 * - Logger:      Registro de actividad en api_football.log
 * - Database:    Conexión a BD y updates optimizados en lote
 * - ApiClient:   Cliente HTTP para Football‑Data.org
 * - DataExtractor: Obtiene datos de la API (o mock) y los guarda en football_data.json
 * - DataLoader:  Lee football_data.json, procesa por fases y orquesta
 * - Orchestrator: Punto de entrada
 */

declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'error_php.log');
set_time_limit(0);

// ======================= CLASE LOGGER =======================
class Logger {
    private static ?Logger $instance = null;
    private string $logFile;
    
    private function __construct() {
        $this->logFile = __DIR__ . '/api_football.log';
    }
    
    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function log(string $level, string $message, bool $display = true): void {
        $line = date('Y-m-d H:i:s') . " - {$level} - {$message}\n";
        file_put_contents($this->logFile, $line, FILE_APPEND);
        if ($display) {
            echo $line;
        }
    }
    
    public function info(string $message, bool $display = true): void {
        $this->log('INFO', $message, $display);
    }
    
    public function warning(string $message): void {
        $this->log('WARNING', $message);
    }
    
    public function error(string $message): void {
        $this->log('ERROR', $message);
    }
}

// ======================= CLASE CONFIG =======================
class Config {
    public string $footballDataKey;
    public bool $apiMocked;
    public string $siteUrl;
    public string $scriptToken;
    public string $adminUser;
    public string $adminPass;
    public array $teamMap;
    public array $faseRango;
    public array $fasesOrden;
    
    public function __construct() {
        // Cargar credenciales privadas
        require __DIR__ . '/Connections/conexion_script.php';
        $this->footballDataKey = $FOOTBALL_DATA_KEY ?? '';
        $this->apiMocked        = $API_MOCKED ?? false;
        $this->siteUrl          = $SITE_URL ?? 'http://localhost';
        $this->scriptToken      = $SCRIPT_TOKEN ?? '';
        $this->adminUser        = $ADMIN_USER ?? 'ProfetaMundial';
        $this->adminPass        = $ADMIN_PASS ?? '';
        
        // Mapeo completo de equipos (inglés → español)
        $this->teamMap = [
            "Argentina" => "Argentina", "Brazil" => "Brasil", "England" => "Inglaterra",
            "France" => "Francia", "Germany" => "Alemania", "Netherlands" => "Países Bajos",
            "Portugal" => "Portugal", "Spain" => "España", "Uruguay" => "Uruguay",
            "Croatia" => "Croacia", "Belgium" => "Bélgica", "Switzerland" => "Suiza",
            "Sweden" => "Suecia", "Austria" => "Austria", "Turkey" => "Turquía",
            "Scotland" => "Escocia", "Norway" => "Noruega", "Bosnia-Herzegovina" => "Bosnia",
            "Canada" => "Canadá", "United States" => "USA", "Mexico" => "México",
            "Panama" => "Panamá", "Japan" => "Japón", "South Korea" => "Corea del Sur",
            "Australia" => "Australia", "Iran" => "Irán", "Saudi Arabia" => "Arabia Saudita",
            "Iraq" => "Irak", "Uzbekistan" => "Uzbekistán", "Jordan" => "Jordania",
            "Qatar" => "Catar", "Morocco" => "Marruecos", "Senegal" => "Senegal",
            "Tunisia" => "Túnez", "Algeria" => "Argelia", "Egypt" => "Egipto",
            "South Africa" => "Sudáfrica", "Ghana" => "Ghana", "Ivory Coast" => "Costa de Marfil",
            "Congo DR" => "RD Congo", "Cape Verde Islands" => "Cabo Verde",
            "Ecuador" => "Ecuador", "Colombia" => "Colombia", "Paraguay" => "Paraguay",
            "New Zealand" => "Nueva Zelanda", "Haiti" => "Haití", "Curaçao" => "Curaçao",
            "Czechia" => "Rep. Checa",
        ];
        
        // Rango de CodPar para cada fase
        $this->faseRango = [
            "GROUP_STAGE"    => [1, 72],
            "LAST_32"        => [73, 88],
            "LAST_16"        => [89, 96],
            "QUARTER_FINALS" => [97, 100],
            "SEMI_FINALS"    => [101, 102],
            "THIRD_PLACE"    => [103, 103],
            "FINAL"          => [104, 104],
        ];
        
        // Orden de procesamiento
        $this->fasesOrden = [
            "GROUP_STAGE", "LAST_32", "LAST_16", "QUARTER_FINALS",
            "SEMI_FINALS", "THIRD_PLACE", "FINAL"
        ];
    }
    
    /**
     * Traduce nombre de equipo inglés a español.
     */
    public function mapTeamName(string $englishName): string {
        return $this->teamMap[$englishName] ?? $englishName;
    }
}

// ======================= CLASE DATABASE =======================
class Database {
    private static ?Database $instance = null;
    private mysqli $connection;
    
    private function __construct() {
        require __DIR__ . '/Connections/conexion.php';
        if (!isset($conexion) || !($conexion instanceof mysqli)) {
            throw new RuntimeException("No se pudo establecer la conexión a la BD.");
        }
        $this->connection = $conexion;
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }
    
    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection(): mysqli {
        return $this->connection;
    }
    
    /**
     * Actualiza en lote los partidos de una fase.
     * Solo modifica registros con glocal=99.
     *
     * @param array $updates  [CodPar => ['glocal' => int, 'gvisitante' => int, 'resultado' => int, 'desempate' => string|null], ...]
     */
    public function batchUpdateMatches(array $updates): int {
        if (empty($updates)) return 0;
        
        $codPars = array_keys($updates);
        $params = [];
        $types = '';
        
        // Construir cláusulas CASE WHEN
        $glocalCase = "glocal = CASE CodPar ";
        $gvisitanteCase = "gvisitante = CASE CodPar ";
        $resultadoCase = "resultado = CASE CodPar ";
        $desempateCase = "desempate = CASE CodPar ";
        
        foreach ($updates as $codPar => $data) {
            $glocalCase .= "WHEN ? THEN ? ";
            $gvisitanteCase .= "WHEN ? THEN ? ";
            $resultadoCase .= "WHEN ? THEN ? ";
            $desempateCase .= "WHEN ? THEN ? ";
            
            $params[] = (int)$codPar;
            $params[] = (int)$data['glocal'];
            $params[] = (int)$codPar;
            $params[] = (int)$data['gvisitante'];
            $params[] = (int)$codPar;
            $params[] = (int)$data['resultado'];
            $params[] = (int)$codPar;
            $params[] = $data['desempate'] ?? '';  // string, puede ser vacío
            
            $types .= 'iiiiiiis';  // i=integer, s=string
        }
        
        $glocalCase .= "END, ";
        $gvisitanteCase .= "END, ";
        $resultadoCase .= "END, ";
        $desempateCase .= "END";
        
        $codParList = implode(',', array_fill(0, count($codPars), '?'));
        $params = array_merge($params, $codPars);
        $types .= str_repeat('i', count($codPars));
        
        $sql = "UPDATE partidos_mundial2026 SET {$glocalCase} {$gvisitanteCase} {$resultadoCase} {$desempateCase}
                WHERE CodUsu = 'ProfetaMundial'
                  AND CodPar IN ({$codParList})
                  AND glocal = 99";
        
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();
        
        return $affected;
    }
    
    /**
     * Actualiza el goleador (partido 106).
     */
    public function updateScorer(string $player, string $team): void {
        $stmt = $this->connection->prepare(
            "UPDATE partidos_mundial2026 SET local = ?, visitante = ?
             WHERE CodUsu = 'ProfetaMundial' AND CodPar = 106"
        );
        $stmt->bind_param('ss', $player, $team);
        $stmt->execute();
        $stmt->close();
    }
}

// ======================= CLASE APICLIENT =======================
class ApiClient {
    private string $apiKey;
    
    public function __construct(string $apiKey) {
        $this->apiKey = $apiKey;
    }
    
    /**
     * Llama a la API de Football‑Data.org y devuelve el array decodificado.
     */
    public function get(string $endpoint, array $params = []): ?array {
        $url = "https://api.football-data.org/v4/{$endpoint}";
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-Auth-Token: {$this->apiKey}"]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            Logger::getInstance()->error("API devolvió código {$httpCode}: " . substr($response, 0, 200));
            return null;
        }
        
        $data = json_decode($response, true);
        if ($data === null) {
            Logger::getInstance()->error("Respuesta de la API no es JSON válido.");
            return null;
        }
        
        return $data;
    }
}

// ======================= CLASE DATAEXTRACTOR =======================
class DataExtractor {
    private ApiClient $apiClient;
    private Config $config;
    
    public function __construct(ApiClient $apiClient, Config $config) {
        $this->apiClient = $apiClient;
        $this->config = $config;
    }
    
    /**
     * Obtiene todos los datos de la API (o mock) y los guarda en football_data.json
     */
    public function extractAndSave(): void {
        $logger = Logger::getInstance();
        
        if ($this->config->apiMocked) {
            $logger->info("Modo mock activado. No se consulta API externa.");
            $archivo = 'api_response_mocked.json';
            if (!file_exists($archivo)) {
                throw new RuntimeException("Archivo mock '{$archivo}' no encontrado.");
            }
            $data = json_decode(file_get_contents($archivo), true);
            if (!$data || !isset($data['matches'])) {
                throw new RuntimeException("Error al decodificar el archivo mock o no contiene 'matches'.");
            }
            
            // Normalizar partidos (igual que con la API real)
            $matches = [];
            foreach ($data['matches'] as $m) {
                $penalties = null;
                if (isset($m['score']['penalties'])) {
                    $penalties = [
                        'home' => $m['score']['penalties']['home'] ?? 0,
                        'away' => $m['score']['penalties']['away'] ?? 0,
                    ];
                }
                $matches[] = [
                    'stage'      => $m['stage'],
                    'status'     => ($m['status'] === 'FINISHED') ? 'Match Finished' : 'Not Started',
                    'home'       => $m['homeTeam']['name'] ?? null,
                    'away'       => $m['awayTeam']['name'] ?? null,
                    'goals_home' => $m['score']['fullTime']['home'] ?? 0,
                    'goals_away' => $m['score']['fullTime']['away'] ?? 0,
                    'penalties'  => $penalties,   // añadimos penales
                    'fecha'      => substr($m['utcDate'], 0, 10),
                    'fecha_iso'  => $m['utcDate'],
                ];
            }
            
            $payload = [
                'matches'    => $matches,
                'top_scorer' => $data['top_scorer'] ?? null,
            ];
            
            file_put_contents('football_data.json', json_encode($payload, JSON_PRETTY_PRINT));
            $logger->info("Datos mock normalizados y guardados en football_data.json (" . count($matches) . " partidos).");
            return;
        }
        
        // --- Modo real (API) ---
        $allMatches = [];
        
        foreach ($this->config->fasesOrden as $fase) {
            $logger->info("Consultando partidos de fase: {$fase}");
            $data = $this->apiClient->get('competitions/WC/matches', [
                'season' => 2026,
                'stage' => $fase
            ]);
            
            if ($data === null) {
                throw new RuntimeException("Fallo al obtener fase {$fase}.");
            }
            
            foreach ($data['matches'] as $match) {
                $penalties = null;
                if (isset($match['score']['penalties'])) {
                    $penalties = [
                        'home' => $match['score']['penalties']['home'] ?? 0,
                        'away' => $match['score']['penalties']['away'] ?? 0,
                    ];
                }
                $allMatches[] = [
                    'stage'      => $match['stage'],
                    'status'     => ($match['status'] === 'FINISHED') ? 'Match Finished' : 'Not Started',
                    'home'       => $match['homeTeam']['name'] ?? null,
                    'away'       => $match['awayTeam']['name'] ?? null,
                    'goals_home' => $match['score']['fullTime']['home'] ?? 0,
                    'goals_away' => $match['score']['fullTime']['away'] ?? 0,
                    'penalties'  => $penalties,   // añadimos penales
                    'fecha'      => substr($match['utcDate'], 0, 10),
                    'fecha_iso'  => $match['utcDate'],
                ];
            }
        }
        
        // Obtener goleadores
        $logger->info("Consultando tabla de goleadores...");
        $scorers = $this->apiClient->get('competitions/WC/scorers', [
            'season' => 2026,
            'limit' => 1
        ]);
        
        $topScorer = null;
        if ($scorers && !empty($scorers['scorers'])) {
            $top = $scorers['scorers'][0];
            $topScorer = [
                'player' => $top['player']['name'],
                'team'   => $top['team']['name'],
            ];
            $logger->info("Máximo goleador: {$topScorer['player']} ({$topScorer['team']})");
        } else {
            $logger->warning("No se encontraron goleadores.");
        }
        
        // Guardar en archivo
        $payload = [
            'matches' => $allMatches,
            'top_scorer' => $topScorer,
        ];
        
        file_put_contents('football_data.json', json_encode($payload, JSON_PRETTY_PRINT));
        $logger->info("Datos guardados en football_data.json (" . count($allMatches) . " partidos).");
    }
}

// ======================= CLASE DATALOADER =======================
class DataLoader {
    private Config $config;
    private Database $db;
    private string $sessionCookie;
    
    public function __construct(Config $config, Database $db) {
        $this->config = $config;
        $this->db = $db;
    }
    
    /**
     * Inicia sesión como administrador y devuelve la cookie de sesión.
     */
    private function loginAdmin(): string {
        $logger = Logger::getInstance();
        $url = $this->config->siteUrl . '/ingresar.php';
        $post = [
            'usuario'    => $this->config->adminUser,
            'contrasena' => $this->config->adminPass,
            'enc'        => '0'
        ];
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        $resp = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);
        
        if ($httpCode !== 302) {
            throw new RuntimeException("Login admin falló (código HTTP {$httpCode}).");
        }
        
        $headers = substr($resp, 0, $headerSize);
        if (!preg_match('/Location:\s*([^\s]+)/i', $headers, $matches)) {
            throw new RuntimeException("No se encontró cabecera Location en login.");
        }
        
        $destino = trim($matches[1]);
        if (stripos($destino, 'empezar.php') === false) {
            throw new RuntimeException("Login redirigió a destino inesperado: {$destino}");
        }
        
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $headers, $cookieMatches);
        $cookies = [];
        foreach ($cookieMatches[1] as $c) {
            if (strpos($c, 'PHPSESSID') !== false) {
                $cookies[] = trim($c);
            }
        }
        
        if (empty($cookies)) {
            throw new RuntimeException("No se recibió cookie de sesión.");
        }
        
        $this->sessionCookie = implode('; ', $cookies);
        $logger->info("Login admin exitoso. Cookie obtenida.");
        return $this->sessionCookie;
    }
    
    /**
     * Realiza una petición HTTP al sitio con la cookie de administrador.
     */
    private function httpPostWithSession(string $url, array $data): array {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'X-Requested-With: XMLHttpRequest',
            'Cookie: ' . $this->sessionCookie
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ['code' => $code, 'body' => $resp];
    }
    
    /**
     * Ejecuta el autoguardado de un grupo mediante petición HTTP.
     */
    private function autoguardarGrupo(string $grupo): void {
        $logger = Logger::getInstance();
        $letra = strtoupper($grupo);
        if (!preg_match('/^[A-L]$/', $letra)) return;
        
        $base = 1 + (ord($letra) - ord('A')) * 6;
        $codigos = range($base, $base + 5);
        $codList = implode(',', $codigos);
        
        $conn = $this->db->getConnection();
        $res = $conn->query(
            "SELECT CodPar, glocal, gvisitante FROM partidos_mundial2026
             WHERE CodUsu='ProfetaMundial' AND CodPar IN ({$codList}) ORDER BY CodPar"
        );
        
        $post = ["MM_update" => "grupo{$letra}", "grupo" => $letra];
        while ($row = $res->fetch_assoc()) {
            $cp = $row['CodPar'];
            $post["L{$cp}"] = $row['glocal'];
            $post["V{$cp}"] = $row['gvisitante'];
        }
        $res->free();
        
        $url = $this->config->siteUrl . "/G{$letra}_mundial2026.php";
        $result = $this->httpPostWithSession($url, $post);
        
        if (in_array($result['code'], [200, 302])) {
            $logger->info("Autoguardado grupo {$letra} exitoso (código {$result['code']}).");
        } else {
            $logger->error("Autoguardado grupo {$letra} falló: " . substr($result['body'], 0, 300));
        }
    }
    
    /**
     * Ejecuta el autoguardado de la fase 2 mediante petición HTTP.
     */
    private function autoguardarFase2(): void {
        $logger = Logger::getInstance();
        $conn = $this->db->getConnection();
        $res = $conn->query(
            "SELECT CodPar, local, visitante, glocal, gvisitante, desempate
             FROM partidos_mundial2026
             WHERE CodUsu='ProfetaMundial' AND CodPar BETWEEN 73 AND 106
             ORDER BY CodPar"
        );
        
        $post = ["MM_update" => "fase2"];
        while ($row = $res->fetch_assoc()) {
            $cp = $row['CodPar'];
            $post["L{$cp}"] = $row['glocal'];
            $post["V{$cp}"] = $row['gvisitante'];
            $post["local{$cp}"] = $row['local'] ?? '';
            $post["visitante{$cp}"] = $row['visitante'] ?? '';
            $post["elegir{$cp}"] = $row['desempate'] ?? '';
        }
        $res->free();
        
        $url = $this->config->siteUrl . '/fase2_mundial2026.php';
        $result = $this->httpPostWithSession($url, $post);
        
        if (in_array($result['code'], [200, 302])) {
            $logger->info("Autoguardado fase2 exitoso (código {$result['code']}).");
        } else {
            $logger->error("Autoguardado fase2 falló: " . substr($result['body'], 0, 300));
        }
    }
    
    /**
     * Ejecuta la puntuación masiva de todos los usuarios.
     */
    private function puntuarMasivamente(): void {
        $logger = Logger::getInstance();
        $url = $this->config->siteUrl . '/puntuar_mundial2026.php';
        $result = $this->httpPostWithSession($url, ["MM_update" => "puntuar2026"]);
        
        if (in_array($result['code'], [200, 302])) {
            $logger->info("Puntuación masiva ejecutada correctamente (código {$result['code']}).");
        } else {
            $logger->error("Puntuación masiva falló: " . substr($result['body'], 0, 300));
        }
    }
    
    /**
     * Procesa football_data.json y actualiza base de datos y sitio.
     */
    public function process(): void {
        $logger = Logger::getInstance();
        
        if (!file_exists('football_data.json')) {
            throw new RuntimeException("football_data.json no existe. Ejecute primero DataExtractor.");
        }
        
        $json = json_decode(file_get_contents('football_data.json'), true);
        if (!$json || !isset($json['matches'])) {
            throw new RuntimeException("football_data.json no contiene datos válidos.");
        }
        
        $fixtures = $json['matches'];
        $topScorer = $json['top_scorer'] ?? null;
        
        $this->loginAdmin();
        
        foreach ($this->config->fasesOrden as $fase) {
            $logger->info("Procesando fase: {$fase}");
            
            $rango = $this->config->faseRango[$fase] ?? null;
            if (!$rango) {
                $logger->warning("Fase '{$fase}' no tiene rango definido.");
                continue;
            }
            
            $partidosFase = array_filter($fixtures, function($m) use ($fase) {
                return ($m['stage'] === $fase && $m['status'] === 'Match Finished');
            });
            
            if (empty($partidosFase)) {
                $logger->info("No hay partidos finalizados en fase {$fase}.");
                continue;
            }
            
            $updates = [];
            foreach ($partidosFase as $match) {
                $localEsp  = $this->config->mapTeamName($match['home']);
                $visitEsp  = $this->config->mapTeamName($match['away']);
                $gh = (int)$match['goals_home'];
                $ga = (int)$match['goals_away'];
                $resultado = ($gh > $ga) ? 1 : (($gh < $ga) ? 2 : 0);
                
                // Determinar desempate si es eliminatoria y hay empate
                $desempate = '';
                if ($fase !== 'GROUP_STAGE' && $gh === $ga) {
                    if (isset($match['penalties']) && is_array($match['penalties'])) {
                        $penHome = (int)$match['penalties']['home'];
                        $penAway = (int)$match['penalties']['away'];
                        if ($penHome > $penAway) {
                            $desempate = $localEsp;
                            $logger->info("Penales: gana {$localEsp} ({$penHome}-{$penAway}) → desempate asignado.");
                        } elseif ($penAway > $penHome) {
                            $desempate = $visitEsp;
                            $logger->info("Penales: gana {$visitEsp} ({$penAway}-{$penHome}) → desempate asignado.");
                        } else {
                            $logger->warning("Empate en penales ({$penHome}-{$penAway}) para {$localEsp} vs {$visitEsp}. No se asignará desempate.");
                        }
                    } else {
                        $logger->warning("Partido empatado sin información de penales: {$localEsp} vs {$visitEsp}. Se omite desempate (posiblemente aún no definido).");
                    }
                }
                
                $conn = $this->db->getConnection();
                $stmt = $conn->prepare(
                    "SELECT CodPar FROM partidos_mundial2026
                     WHERE CodUsu='ProfetaMundial'
                       AND local = ? AND visitante = ?
                       AND CodPar BETWEEN ? AND ?
                     LIMIT 1"
                );
                $stmt->bind_param('ssii', $localEsp, $visitEsp, $rango[0], $rango[1]);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();
                $stmt->close();
                
                if (!$row) {
                    $logger->warning("No se encontró CodPar para {$localEsp} vs {$visitEsp} en rango {$rango[0]}-{$rango[1]}.");
                    continue;
                }
                
                $codPar = (int)$row['CodPar'];
                $updates[$codPar] = [
                    'glocal'    => $gh,
                    'gvisitante'=> $ga,
                    'resultado' => $resultado,
                    'desempate' => $desempate,
                ];
                
                $logger->info("Preparando actualización CodPar={$codPar} ({$localEsp} vs {$visitEsp}) con {$gh}-{$ga}" . ($desempate ? " (desempate: {$desempate})" : ""));
            }
            
            if (empty($updates)) {
                $logger->info("No hay actualizaciones pendientes en fase {$fase}.");
                continue;
            }
            
            $affected = $this->db->batchUpdateMatches($updates);
            $logger->info("{$affected} partidos actualizados en BD para fase {$fase}.");
            
            if ($affected > 0) {
                if ($fase === 'GROUP_STAGE') {
                    $grupos = [];
                    foreach ($updates as $codPar => $data) {
                        $grupoLetra = chr(65 + (int)(($codPar - 1) / 6));
                        $grupos[$grupoLetra] = true;
                    }
                    foreach (array_keys($grupos) as $letra) {
                        $this->autoguardarGrupo($letra);
                        usleep(500000);
                    }
                } else {
                    $this->autoguardarFase2();
                    usleep(500000);
                }
            }
        }
        
        if ($topScorer) {
            $teamEsp = $this->config->mapTeamName($topScorer['team']);
            $this->db->updateScorer($topScorer['player'], $teamEsp);
            $logger->info("Goleador actualizado: {$topScorer['player']} ({$teamEsp}).");
        }
        
        $logger->info("Ejecutando puntuación masiva...");
        $this->puntuarMasivamente();
        
        $logger->info("========== FIN DEL SCRIPT ==========");
    }
}

// ======================= CLASE ORCHESTRATOR =======================
class Orchestrator {
    public function run(): void {
        $logger = Logger::getInstance();
        $logger->info("========== INICIO DEL SCRIPT ==========");
        
        try {
            $config = new Config();
            $db = Database::getInstance();
            
            $apiClient = new ApiClient($config->footballDataKey);
            $extractor = new DataExtractor($apiClient, $config);
            $extractor->extractAndSave();
            
            $loader = new DataLoader($config, $db);
            $loader->process();
            
        } catch (Throwable $e) {
            $logger->error("ERROR FATAL: " . $e->getMessage());
            $logger->error("Trace: " . $e->getTraceAsString());
        }
        
        $logger->info("========== FIN DEL SCRIPT ==========");
    }
}

// ======================= EJECUCIÓN =======================
$orchestrator = new Orchestrator();
$orchestrator->run();
