<?php

namespace RPG\AbstractFactory;

use RPG\Singleton\GameLogger;

// ── Fábrica Abstrata ────────────────────────────────────────
/**
 * Define a interface para criar cada produto da família.
 * Garante que Weapon + Armor + Accessory sejam sempre
 * do mesmo "estilo" — sem misturar Espada com Manto de Mago.
 */
interface EquipmentFactory
{
    public function createWeapon(): Weapon;
    public function createArmor(): Armor;
    public function createAccessory(): Accessory;

    /**
     * Método auxiliar: cria e apresenta o conjunto completo
     */
    public function createFullSet(string $characterName): array;
}

// ── Fábricas Concretas ──────────────────────────────────────

class HeavyEquipmentFactory implements EquipmentFactory
{
    public function createWeapon(): Weapon        { return new GreatSword(); }
    public function createArmor(): Armor          { return new PlateArmor(); }
    public function createAccessory(): Accessory  { return new WarShield(); }

    public function createFullSet(string $characterName): array
    {
        $logger = GameLogger::getInstance();
        $logger->log("⚒️  Forjando conjunto PESADO para {$characterName}...");

        $set = [
            'weapon'    => $this->createWeapon(),
            'armor'     => $this->createArmor(),
            'accessory' => $this->createAccessory(),
        ];

        foreach ($set as $item) {
            $logger->log("   ✅ " . $item->describe());
        }

        return $set;
    }
}

class MagicEquipmentFactory implements EquipmentFactory
{
    public function createWeapon(): Weapon        { return new MagicStaff(); }
    public function createArmor(): Armor          { return new MageRobe(); }
    public function createAccessory(): Accessory  { return new SpellOrb(); }

    public function createFullSet(string $characterName): array
    {
        $logger = GameLogger::getInstance();
        $logger->log("✨ Encantando conjunto MÁGICO para {$characterName}...");

        $set = [
            'weapon'    => $this->createWeapon(),
            'armor'     => $this->createArmor(),
            'accessory' => $this->createAccessory(),
        ];

        foreach ($set as $item) {
            $logger->log("   ✅ " . $item->describe());
        }

        return $set;
    }
}

class ShadowEquipmentFactory implements EquipmentFactory
{
    public function createWeapon(): Weapon        { return new PoisonedDagger(); }
    public function createArmor(): Armor          { return new LeatherArmor(); }
    public function createAccessory(): Accessory  { return new ShadowHood(); }

    public function createFullSet(string $characterName): array
    {
        $logger = GameLogger::getInstance();
        $logger->log("🌑 Preparando conjunto SOMBRIO para {$characterName}...");

        $set = [
            'weapon'    => $this->createWeapon(),
            'armor'     => $this->createArmor(),
            'accessory' => $this->createAccessory(),
        ];

        foreach ($set as $item) {
            $logger->log("   ✅ " . $item->describe());
        }

        return $set;
    }
}

class HolyEquipmentFactory implements EquipmentFactory
{
    public function createWeapon(): Weapon        { return new HolyMace(); }
    public function createArmor(): Armor          { return new HolyArmor(); }
    public function createAccessory(): Accessory  { return new DivineCross(); }

    public function createFullSet(string $characterName): array
    {
        $logger = GameLogger::getInstance();
        $logger->log("🕊️  Abençoando conjunto SAGRADO para {$characterName}...");

        $set = [
            'weapon'    => $this->createWeapon(),
            'armor'     => $this->createArmor(),
            'accessory' => $this->createAccessory(),
        ];

        foreach ($set as $item) {
            $logger->log("   ✅ " . $item->describe());
        }

        return $set;
    }
}
