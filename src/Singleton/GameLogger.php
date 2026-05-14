<?php

namespace RPG\Singleton;

/**
 * ============================================================
 * PADRÃO: SINGLETON
 * ============================================================
 * Garante que uma classe tenha APENAS UMA instância e fornece
 * um ponto de acesso global a ela.
 *
 * PROBLEMA: Em um RPG, precisamos de um único sistema de log
 * que registre eventos do jogo (batalhas, itens coletados,
 * mortes) sem criar múltiplos arquivos ou perder dados.
 *
 * SOLUÇÃO: GameLogger só pode ter uma instância. Qualquer parte
 * do código que chamar GameLogger::getInstance() receberá
 * sempre o mesmo objeto, com o mesmo histórico de logs.
 * ============================================================
 */
class GameLogger
{
    // A única instância desta classe
    private static ?GameLogger $instance = null;

    // Histórico de eventos do jogo
    private array $logs = [];

    // Contador de chamadas (demonstra que é a mesma instância)
    private int $instanceCallCount = 0;

    /**
     * Construtor PRIVADO impede criação com "new GameLogger()"
     */
    private function __construct()
    {
        $this->log("🎮 GameLogger inicializado — sistema de log do RPG ativo!");
    }

    /**
     * Impede clonagem da instância
     */
    private function __clone() {}

    /**
     * Ponto de acesso global — retorna sempre a mesma instância
     */
    public static function getInstance(): static
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Registra um evento no log
     */
    public function log(string $message, string $level = 'INFO'): void
    {
        $this->instanceCallCount++;
        $timestamp = date('H:i:s');
        $entry = "[{$timestamp}] [{$level}] {$message}";
        $this->logs[] = $entry;
        echo $entry . PHP_EOL;
    }

    public function warning(string $message): void
    {
        $this->log($message, 'WARN');
    }

    public function error(string $message): void
    {
        $this->log($message, 'ERROR');
    }

    /**
     * Exibe todo o histórico de logs
     */
    public function showHistory(): void
    {
        echo PHP_EOL . "=== 📜 HISTÓRICO DE LOGS ({$this->instanceCallCount} entradas) ===" . PHP_EOL;
        foreach ($this->logs as $entry) {
            echo $entry . PHP_EOL;
        }
    }

    public function getCallCount(): int
    {
        return $this->instanceCallCount;
    }
}
