<?php

namespace RPG\Prototype;

use RPG\Singleton\GameLogger;

/**
 * ============================================================
 * PADRÃO: PROTOTYPE
 * ============================================================
 * Especifica o tipo de objeto a criar usando uma instância
 * como protótipo e cria novos objetos copiando (clonando)
 * esse protótipo.
 *
 * PROBLEMA: Em um RPG, há centenas de inimigos do mesmo tipo:
 * 50 Goblins, 20 Esqueletos, 10 Dragões. Criar cada um do
 * zero (com new + configuração completa) seria muito custoso.
 * Além disso, inimigos clonados podem ter variações pequenas
 * (diferentes nomes, HP ligeiramente diferente) sem alterar
 * o protótipo original.
 *
 * SOLUÇÃO: Definimos NPCs/Inimigos como protótipos pré-
 * configurados. Para criar um novo inimigo, clonamos o
 * protótipo e ajustamos apenas o que for necessário.
 * ============================================================
 */

// ── Interface Prototype ─────────────────────────────────────
interface Cloneable
{
    public function clone(): static;
}

// ── Classe de Habilidade (objeto aninhado — testa deep copy) ─
class Skill
{
    public function __construct(
        public string $name,
        public int    $damage,
        public int    $manaCost,
        public string $description
    ) {}

    public function describe(): string
    {
        return "{$this->name} (DMG:{$this->damage}, MP:{$this->manaCost}) — {$this->description}";
    }
}

// ── Protótipo Base: NPC ─────────────────────────────────────
class NPC implements Cloneable
{
    public string $id;
    public string $name;
    public string $type;
    public string $faction;
    public int    $health;
    public int    $maxHealth;
    public int    $attack;
    public int    $defense;
    public int    $speed;
    public int    $experienceReward;
    public int    $goldReward;
    public string $behavior;       // 'aggressive', 'passive', 'patrol'
    public array  $lootTable = []; // itens possíveis ao morrer
    public array  $skills    = []; // Skill objects (objeto aninhado!)
    public string $dialogue  = '';
    public bool   $isBoss    = false;

    public function __construct(string $name)
    {
        $this->id   = uniqid('npc_');
        $this->name = $name;
    }

    /**
     * Clone superficial do PHP (__clone) + deep copy manual
     * dos objetos aninhados (array de Skill).
     *
     * ATENÇÃO DIDÁTICA:
     * - clone $obj copia valores primitivos automaticamente
     * - Objetos dentro de arrays/propriedades são REFERÊNCIAS
     *   e precisam ser copiados manualmente (deep copy)
     */
    public function clone(): static
    {
        $clone = clone $this;             // Copia primitivos
        $clone->id = uniqid('npc_');      // Novo ID único

        // Deep copy: copia cada Skill para evitar referência compartilhada
        $clone->skills = array_map(
            fn(Skill $s) => new Skill($s->name, $s->damage, $s->manaCost, $s->description),
            $this->skills
        );

        // Deep copy: copia array de loot
        $clone->lootTable = $this->lootTable;

        GameLogger::getInstance()->log(
            "🧬 Prototype clonado: [{$clone->id}] {$clone->name} (original: {$this->name})"
        );

        return $clone;
    }

    public function addSkill(Skill $skill): static
    {
        $this->skills[] = $skill;
        return $this;
    }

    public function takeDamage(int $damage): string
    {
        $actualDamage = max(0, $damage - $this->defense);
        $this->health = max(0, $this->health - $actualDamage);
        $status = $this->health <= 0 ? '💀 MORTO' : "❤️  HP: {$this->health}/{$this->maxHealth}";
        return "{$this->name} recebeu {$actualDamage} de dano. {$status}";
    }

    public function isAlive(): bool
    {
        return $this->health > 0;
    }

    public function describe(): string
    {
        $boss = $this->isBoss ? ' 👑 [CHEFE]' : '';
        $skills = array_map(fn(Skill $s) => $s->name, $this->skills);

        $lines = [
            "  [{$this->id}] {$this->name}{$boss}",
            "  Tipo: {$this->type} | Facção: {$this->faction} | Comportamento: {$this->behavior}",
            "  HP: {$this->health}/{$this->maxHealth} | ATK: {$this->attack} | DEF: {$this->defense} | VEL: {$this->speed}",
            "  Recompensas: {$this->experienceReward} XP | {$this->goldReward} Ouro",
            "  Habilidades: " . implode(', ', $skills ?: ['Ataque Básico']),
            "  Loot: " . implode(', ', $this->lootTable ?: ['Nada']),
        ];

        return implode(PHP_EOL, $lines);
    }
}
