<?php

    require '../../logs/vendor/autoload.php';

    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;

class LogManager
{
    private static $logger;

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