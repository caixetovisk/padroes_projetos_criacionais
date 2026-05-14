<?php

namespace RPG\Builder;

/**
 * ============================================================
 * PADRÃO: BUILDER
 * ============================================================
 * Separa a CONSTRUÇÃO de um objeto complexo da sua
 * REPRESENTAÇÃO, permitindo que o mesmo processo crie
 * diferentes representações.
 *
 * PROBLEMA: Criar um Herói completo envolve muitos passos:
 * nome, raça, classe, atributos base, habilidades, história,
 * equipamentos, pets, títulos... Se tudo fosse feito no
 * construtor, teríamos um construtor com 15+ parâmetros.
 *
 * SOLUÇÃO: HeroBuilder define os passos de construção.
 * Cada implementação (WarriorBuilder, MageBuilder) executa
 * esses passos de forma diferente. O Director orquestra
 * a ordem dos passos.
 * ============================================================
 */

// ── Produto: Hero ───────────────────────────────────────────
class Hero
{
    // Atributos básicos
    public string $name         = '';
    public string $race         = '';
    public string $class        = '';
    public string $background   = '';

    // Atributos primários (D&D style)
    public int $strength        = 0;  // Força
    public int $dexterity       = 0;  // Destreza
    public int $intelligence    = 0;  // Inteligência
    public int $constitution    = 0;  // Constituição
    public int $wisdom          = 0;  // Sabedoria
    public int $charisma        = 0;  // Carisma

    // Atributos derivados
    public int $maxHp           = 0;
    public int $maxMp           = 0;
    public int $speed           = 0;

    // Progressão
    public int   $level         = 1;
    public int   $gold          = 0;
    public array $skills        = [];
    public array $equipment     = [];
    public array $traits        = [];   // Traços de personalidade
    public ?string $pet         = null;
    public array $titles        = [];

    public function describe(): string
    {
        $lines = [
            "",
            "╔══════════════════════════════════════════════╗",
            "║           📜 FICHA DO HERÓI                  ║",
            "╚══════════════════════════════════════════════╝",
            "  Nome:        {$this->name}",
            "  Raça:        {$this->race}",
            "  Classe:      {$this->class}",
            "  Nível:       {$this->level}",
            "  Background:  {$this->background}",
            "  Ouro:        {$this->gold} 💰",
            "",
            "  ── Atributos Primários ──────────────────────",
            "  Força:        {$this->strength}",
            "  Destreza:     {$this->dexterity}",
            "  Inteligência: {$this->intelligence}",
            "  Constituição: {$this->constitution}",
            "  Sabedoria:    {$this->wisdom}",
            "  Carisma:      {$this->charisma}",
            "",
            "  ── Atributos Derivados ──────────────────────",
            "  HP Máx:    {$this->maxHp}",
            "  MP Máx:    {$this->maxMp}",
            "  Velocidade:{$this->speed}",
            "",
            "  ── Habilidades ──────────────────────────────",
            "  " . implode(', ', $this->skills ?: ['Nenhuma']),
            "",
            "  ── Equipamentos ─────────────────────────────",
            "  " . implode(', ', $this->equipment ?: ['Nenhum']),
            "",
            "  ── Traços ───────────────────────────────────",
            "  " . implode(', ', $this->traits ?: ['Nenhum']),
        ];

        if ($this->pet) {
            $lines[] = "  Pet:         {$this->pet}";
        }

        if (!empty($this->titles)) {
            $lines[] = "  Títulos:     " . implode(', ', $this->titles);
        }

        $lines[] = "╚══════════════════════════════════════════════╝";

        return implode(PHP_EOL, $lines);
    }
}

// ── Interface do Builder ────────────────────────────────────
interface HeroBuilderInterface
{
    public function setName(string $name): static;
    public function setRace(): static;
    public function setClass(): static;
    public function setBackground(): static;
    public function setPrimaryAttributes(): static;
    public function setDerivedAttributes(): static;
    public function setSkills(): static;
    public function setStartingEquipment(): static;
    public function setPersonalityTraits(): static;
    public function setStartingGold(): static;
    public function build(): Hero;
}
