<?php

namespace RPG\AbstractFactory;

/**
 * ============================================================
 * PADRÃO: ABSTRACT FACTORY
 * ============================================================
 * Fornece uma interface para criar FAMÍLIAS de objetos
 * relacionados sem especificar suas classes concretas.
 *
 * PROBLEMA: Um RPG tem conjuntos de equipamentos temáticos:
 * um Guerreiro usa Espada + Armadura Pesada + Escudo.
 * Um Mago usa Cajado + Manto Mágico + Orbe.
 * Um Ladrão usa Adaga + Armadura Leve + Capuz.
 * Precisamos garantir que os itens de um conjunto sejam
 * sempre compatíveis entre si (não misturar estilos).
 *
 * SOLUÇÃO: EquipmentFactory é a fábrica abstrata.
 * Cada fábrica concreta cria uma família coesa de itens.
 * ============================================================
 */

// ── Produtos Abstratos ──────────────────────────────────────

interface Weapon
{
    public function getName(): string;
    public function getDamage(): int;
    public function getType(): string;
    public function describe(): string;
}

interface Armor
{
    public function getName(): string;
    public function getDefense(): int;
    public function getWeight(): string;
    public function describe(): string;
}

interface Accessory
{
    public function getName(): string;
    public function getBonus(): string;
    public function describe(): string;
}

// ── Família 1: Equipamento Pesado (Guerreiro) ───────────────

class GreatSword implements Weapon
{
    public function getName(): string    { return 'Espadão do Cruzado'; }
    public function getDamage(): int     { return 75; }
    public function getType(): string    { return 'Corpo a Corpo'; }
    public function describe(): string
    {
        return "🗡️  {$this->getName()} | Dano: {$this->getDamage()} | Tipo: {$this->getType()}";
    }
}

class PlateArmor implements Armor
{
    public function getName(): string    { return 'Armadura de Aço Completa'; }
    public function getDefense(): int    { return 80; }
    public function getWeight(): string  { return 'Muito Pesada'; }
    public function describe(): string
    {
        return "🛡️  {$this->getName()} | Defesa: {$this->getDefense()} | Peso: {$this->getWeight()}";
    }
}

class WarShield implements Accessory
{
    public function getName(): string  { return 'Escudo de Guerra'; }
    public function getBonus(): string { return '+20 Defesa, +10% Block'; }
    public function describe(): string
    {
        return "🔰 {$this->getName()} | Bônus: {$this->getBonus()}";
    }
}

// ── Família 2: Equipamento Mágico (Mago) ───────────────────

class MagicStaff implements Weapon
{
    public function getName(): string    { return 'Cajado do Arquimago'; }
    public function getDamage(): int     { return 120; }
    public function getType(): string    { return 'Mágico'; }
    public function describe(): string
    {
        return "🪄 {$this->getName()} | Dano: {$this->getDamage()} | Tipo: {$this->getType()}";
    }
}

class MageRobe implements Armor
{
    public function getName(): string    { return 'Manto das Estrelas'; }
    public function getDefense(): int    { return 20; }
    public function getWeight(): string  { return 'Leve'; }
    public function describe(): string
    {
        return "🌟 {$this->getName()} | Defesa: {$this->getDefense()} | Peso: {$this->getWeight()}";
    }
}

class SpellOrb implements Accessory
{
    public function getName(): string  { return 'Orbe do Poder Arcano'; }
    public function getBonus(): string { return '+50 Mana, +25% Dano Mágico'; }
    public function describe(): string
    {
        return "🔮 {$this->getName()} | Bônus: {$this->getBonus()}";
    }
}

// ── Família 3: Equipamento Furtivo (Ladrão/Assassino) ───────

class PoisonedDagger implements Weapon
{
    public function getName(): string    { return 'Adaga Envenenada'; }
    public function getDamage(): int     { return 55; }
    public function getType(): string    { return 'Furtivo + Veneno'; }
    public function describe(): string
    {
        return "🗡️  {$this->getName()} | Dano: {$this->getDamage()} + 5/turno | Tipo: {$this->getType()}";
    }
}

class LeatherArmor implements Armor
{
    public function getName(): string    { return 'Couro de Sombras'; }
    public function getDefense(): int    { return 35; }
    public function getWeight(): string  { return 'Leve'; }
    public function describe(): string
    {
        return "🥷 {$this->getName()} | Defesa: {$this->getDefense()} | Peso: {$this->getWeight()}";
    }
}

class ShadowHood implements Accessory
{
    public function getName(): string  { return 'Capuz das Sombras'; }
    public function getBonus(): string { return '+30% Crítico, +20% Evasão'; }
    public function describe(): string
    {
        return "🎭 {$this->getName()} | Bônus: {$this->getBonus()}";
    }
}

// ── Família 4: Equipamento Sagrado (Paladino) ───────────────

class HolyMace implements Weapon
{
    public function getName(): string    { return 'Maça Sagrada de Lux'; }
    public function getDamage(): int     { return 60; }
    public function getType(): string    { return 'Sagrado'; }
    public function describe(): string
    {
        return "✨ {$this->getName()} | Dano: {$this->getDamage()} | Tipo: {$this->getType()}";
    }
}

class HolyArmor implements Armor
{
    public function getName(): string    { return 'Armadura Abençoada'; }
    public function getDefense(): int    { return 65; }
    public function getWeight(): string  { return 'Pesada'; }
    public function describe(): string
    {
        return "🏅 {$this->getName()} | Defesa: {$this->getDefense()} | Peso: {$this->getWeight()}";
    }
}

class DivineCross implements Accessory
{
    public function getName(): string  { return 'Cruz Divina'; }
    public function getBonus(): string { return '+40 HP Regen/turno, Imune a Maldições'; }
    public function describe(): string
    {
        return "✝️  {$this->getName()} | Bônus: {$this->getBonus()}";
    }
}
