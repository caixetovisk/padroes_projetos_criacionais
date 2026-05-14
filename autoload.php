<?php

/**
 * Autoloader manual (substitui o vendor/autoload.php do Composer).
 * Em produção: use "composer install" que gera um autoload otimizado.
 */

// Carrega na ordem correta (dependências primeiro)
$files = [
    // Singleton (sem dependências)
    __DIR__ . '/src/Singleton/GameLogger.php',
    __DIR__ . '/src/Singleton/GameConfig.php',
    // Factory Method (Character é base das subclasses)
    __DIR__ . '/src/FactoryMethod/Character.php',
    __DIR__ . '/src/FactoryMethod/Characters.php',
    __DIR__ . '/src/FactoryMethod/CharacterFactories.php',
    // Abstract Factory
    __DIR__ . '/src/AbstractFactory/Equipment.php',
    __DIR__ . '/src/AbstractFactory/EquipmentFactories.php',
    // Builder
    __DIR__ . '/src/Builder/Hero.php',
    __DIR__ . '/src/Builder/HeroBuilders.php',
    // Prototype
    __DIR__ . '/src/Prototype/NPC.php',
    __DIR__ . '/src/Prototype/NPCRegistry.php',
];

foreach ($files as $file) {
    require_once $file;
}
