<?php

namespace RPG\FactoryMethod;

use RPG\Singleton\GameLogger;

// ── Criador abstrato ────────────────────────────────────────
/**
 * CharacterFactory declara o "factory method" createCharacter().
 * Subclasses concretas implementam COMO criar cada personagem.
 * O método spawnCharacter() usa o factory method internamente.
 */
abstract class CharacterFactory
{
    /**
     * FACTORY METHOD — as subclasses definem o que criar
     */
    abstract public function createCharacter(string $name): Character;

    /**
     * Método template que usa o factory method.
     * O código cliente chama este método sem saber qual
     * tipo de Character será criado.
     */
    public function spawnCharacter(string $name): Character
    {
        $logger = GameLogger::getInstance();

        // Factory method cria o personagem
        $character = $this->createCharacter($name);

        $logger->log("🆕 Personagem criado: " . $character->getStatus());

        return $character;
    }
}

// ── Criadores Concretos ──────────────────────────────────────

class WarriorFactory extends CharacterFactory
{
    public function createCharacter(string $name): Character
    {
        return new Warrior($name);
    }
}

class MageFactory extends CharacterFactory
{
    public function createCharacter(string $name): Character
    {
        return new Mage($name);
    }
}

class ArcherFactory extends CharacterFactory
{
    public function createCharacter(string $name): Character
    {
        return new Archer($name);
    }
}

class PaladinFactory extends CharacterFactory
{
    public function createCharacter(string $name): Character
    {
        return new Paladin($name);
    }
}

/**
 * BÔNUS: Fábrica dinâmica que escolhe a classe concreta
 * com base em uma string — útil em jogos onde o tipo
 * vem de um arquivo de configuração ou banco de dados.
 */
class CharacterFactoryRegistry
{
    private static array $factories = [
        'warrior' => WarriorFactory::class,
        'mage'    => MageFactory::class,
        'archer'  => ArcherFactory::class,
        'paladin' => PaladinFactory::class,
    ];

    public static function getFactory(string $type): CharacterFactory
    {
        $type = strtolower($type);

        if (!isset(static::$factories[$type])) {
            throw new \InvalidArgumentException("Classe desconhecida: {$type}");
        }

        $factoryClass = static::$factories[$type];
        return new $factoryClass();
    }
}
