<?php

namespace RPG\Singleton;

/**
 * Segundo exemplo de Singleton: Configurações globais do jogo.
 * Demonstra que o padrão pode ser aplicado a qualquer recurso
 * que deve ser único e compartilhado em toda a aplicação.
 */
class GameConfig
{
    private static ?GameConfig $instance = null;

    private array $settings = [
        'game_name'       => 'Dragon\'s Quest',
        'version'         => '1.0.0',
        'max_level'       => 99,
        'starting_gold'   => 100,
        'difficulty'      => 'normal',
        'language'        => 'pt-BR',
    ];

    private function __construct() {}
    private function __clone() {}

    public static function getInstance(): static
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function get(string $key): mixed
    {
        return $this->settings[$key] ?? null;
    }

    public function set(string $key, mixed $value): void
    {
        $this->settings[$key] = $value;
        GameLogger::getInstance()->log("⚙️  Config alterada: [{$key}] = {$value}");
    }

    public function all(): array
    {
        return $this->settings;
    }
}
