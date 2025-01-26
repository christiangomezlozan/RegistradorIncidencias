<?php

/**
 * Maneja el registro de logs utilizando Monolog
 * 
 * @package incidencias
 * @author Christian Gómez Lozano 
 */
    require '../../logs/vendor/autoload.php';

    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;

class LogManager
{
    private static $logger;

    /**
     * Obtiene la instancia del logger configurado.
     * Si no existe una instancia previamente creada, se crea uno nuevo y se guarda en la ruta '/logs/app.log'.
     * 
     * @return Logger La instancia del logger configurado.
     */
    public static function getLogger(): Logger
    {
        if (!self::$logger) {
            // Configurar el logger
            self::$logger = new Logger('app_logs'); // Nombre del canal
            $logFile = __DIR__ . '/../../logs/app.log'; // Ruta al archivo de logs
            self::$logger->pushHandler(new StreamHandler($logFile, Logger::DEBUG)); // Nivel DEBUG
        }

        return self::$logger;
    }
}

?>