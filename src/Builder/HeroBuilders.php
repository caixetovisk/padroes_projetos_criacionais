<?php

namespace RPG\Builder;

use RPG\Singleton\GameLogger;

// ── Builder Concreto 1: Guerreiro Anão ─────────────────────
class DwarfWarriorBuilder implements HeroBuilderInterface
{
    private Hero $hero;

    public function __construct()
    {
        $this->hero = new Hero();
    }

    public function setName(string $name): static
    {
        $this->hero->name = $name;
        return $this;
    }

    public function setRace(): static
    {
        $this->hero->race = 'Anão';
        return $this;
    }

    public function setClass(): static
    {
        $this->hero->class = 'Guerreiro';
        return $this;
    }

    public function setBackground(): static
    {
        $this->hero->background = 'Ex-minerador das Montanhas de Ferro';
        return $this;
    }

    public function setPrimaryAttributes(): static
    {
        // Anões: altos em Força e Constituição, baixos em Destreza e Carisma
        $this->hero->strength     = 18;
        $this->hero->dexterity    = 8;
        $this->hero->intelligence = 9;
        $this->hero->constitution = 20;
        $this->hero->wisdom       = 12;
        $this->hero->charisma     = 7;
        return $this;
    }

    public function setDerivedAttributes(): static
    {
        // HP alto por causa da Constituição de Anão
        $this->hero->maxHp  = 200 + ($this->hero->constitution * 5);
        $this->hero->maxMp  = 30;
        $this->hero->speed  = 8; // Anões são lentos
        return $this;
    }

    public function setSkills(): static
    {
        $this->hero->skills = [
            'Golpe de Machado',
            'Fúria Anã',
            'Resistência a Veneno',
            'Fortitude de Pedra',
        ];
        return $this;
    }

    public function setStartingEquipment(): static
    {
        $this->hero->equipment = [
            'Machado de Guerra Anão',
            'Escudo de Pedra',
            'Elmo de Ferro',
            'Botas Pesadas',
        ];
        return $this;
    }

    public function setPersonalityTraits(): static
    {
        $this->hero->traits = [
            'Teimoso',
            'Leal',
            'Ama cerveja e canções',
            'Desconfia de elfos',
        ];
        return $this;
    }

    public function setStartingGold(): static
    {
        $this->hero->gold = 80; // Anões guardam seu ouro com cuidado
        return $this;
    }

    public function build(): Hero
    {
        GameLogger::getInstance()->log(
            "🔨 Builder concluiu a criação do Guerreiro Anão: {$this->hero->name}"
        );
        return $this->hero;
    }
}

// ── Builder Concreto 2: Mago Elfo ──────────────────────────
class ElfMageBuilder implements HeroBuilderInterface
{
    private Hero $hero;

    public function __construct()
    {
        $this->hero = new Hero();
    }

    public function setName(string $name): static
    {
        $this->hero->name = $name;
        return $this;
    }

    public function setRace(): static
    {
        $this->hero->race = 'Elfo';
        return $this;
    }

    public function setClass(): static
    {
        $this->hero->class = 'Mago Arcano';
        return $this;
    }

    public function setBackground(): static
    {
        $this->hero->background = 'Estudante da Academia de Artes Místicas';
        return $this;
    }

    public function setPrimaryAttributes(): static
    {
        // Elfos: altíssima Inteligência e Destreza
        $this->hero->strength     = 6;
        $this->hero->dexterity    = 16;
        $this->hero->intelligence = 22;
        $this->hero->constitution = 8;
        $this->hero->wisdom       = 18;
        $this->hero->charisma     = 14;
        return $this;
    }

    public function setDerivedAttributes(): static
    {
        $this->hero->maxHp  = 60 + ($this->hero->constitution * 3);
        $this->hero->maxMp  = 300 + ($this->hero->intelligence * 10);
        $this->hero->speed  = 13;
        return $this;
    }

    public function setSkills(): static
    {
        $this->hero->skills = [
            'Bola de Fogo',
            'Raio Arcano',
            'Escudo Mágico',
            'Teleporte',
            'Visão Élfika',
            'Encantamento',
        ];
        return $this;
    }

    public function setStartingEquipment(): static
    {
        $this->hero->equipment = [
            'Cajado de Cristal Élfiko',
            'Manto das Estrelas',
            'Grimório Ancestral',
            'Amuleto Arcano',
        ];
        $this->hero->pet = '🦉 Coruja Familiar (Sabedoria +2)';
        return $this;
    }

    public function setPersonalityTraits(): static
    {
        $this->hero->traits = [
            'Arrogante com humanos',
            'Curioso e estudioso',
            'Perfeccionista',
            'Vive centenas de anos',
        ];
        return $this;
    }

    public function setStartingGold(): static
    {
        $this->hero->gold = 200; // Elfos têm recursos da Academia
        return $this;
    }

    public function addTitle(string $title): static
    {
        $this->hero->titles[] = $title;
        return $this;
    }

    public function build(): Hero
    {
        $this->hero->titles[] = 'Aprendiz Arcano';
        GameLogger::getInstance()->log(
            "✨ Builder concluiu a criação do Mago Elfo: {$this->hero->name}"
        );
        return $this->hero;
    }
}

// ── Builder Concreto 3: Arqueiro Humano ────────────────────
class HumanArcherBuilder implements HeroBuilderInterface
{
    private Hero $hero;

    public function __construct()
    {
        $this->hero = new Hero();
    }

    public function setName(string $name): static
    {
        $this->hero->name = $name;
        return $this;
    }

    public function setRace(): static
    {
        $this->hero->race = 'Humano';
        return $this;
    }

    public function setClass(): static
    {
        $this->hero->class = 'Arqueiro Explorador';
        return $this;
    }

    public function setBackground(): static
    {
        $this->hero->background = 'Guardião das Florestas do Norte';
        return $this;
    }

    public function setPrimaryAttributes(): static
    {
        // Humanos são versáteis — bons em tudo, excelentes em nada
        $this->hero->strength     = 12;
        $this->hero->dexterity    = 18;
        $this->hero->intelligence = 12;
        $this->hero->constitution = 14;
        $this->hero->wisdom       = 14;
        $this->hero->charisma     = 12;
        return $this;
    }

    public function setDerivedAttributes(): static
    {
        $this->hero->maxHp  = 120 + ($this->hero->constitution * 4);
        $this->hero->maxMp  = 80;
        $this->hero->speed  = 15; // Arqueiros são ágeis
        return $this;
    }

    public function setSkills(): static
    {
        $this->hero->skills = [
            'Tiro Certeiro',
            'Chuva de Flechas',
            'Rastreamento',
            'Furtividade na Floresta',
            'Sobrevivência',
        ];
        return $this;
    }

    public function setStartingEquipment(): static
    {
        $this->hero->equipment = [
            'Arco Longo de Teixo',
            '30x Flechas Normais',
            '10x Flechas de Fogo',
            'Armadura de Couro',
            'Faca de Caça',
        ];
        $this->hero->pet = '🦅 Falcão de Exploração (Visão +5)';
        return $this;
    }

    public function setPersonalityTraits(): static
    {
        $this->hero->traits = [
            'Solitário mas honrado',
            'Protetor da natureza',
            'Desconfia de magia',
            'Pragmático',
        ];
        return $this;
    }

    public function setStartingGold(): static
    {
        $this->hero->gold = 120;
        return $this;
    }

    public function build(): Hero
    {
        GameLogger::getInstance()->log(
            "🏹 Builder concluiu a criação do Arqueiro Humano: {$this->hero->name}"
        );
        return $this->hero;
    }
}

// ── Director ─────────────────────────────────────────────────
/**
 * O Director conhece a ORDEM correta de chamar os passos
 * do Builder. O cliente pode usar o Director ou chamar
 * os passos manualmente para construção personalizada.
 */
class HeroDirector
{
    private HeroBuilderInterface $builder;

    public function setBuilder(HeroBuilderInterface $builder): void
    {
        $this->builder = $builder;
    }

    /**
     * Herói completo para jogadores iniciantes (com todas as etapas)
     */
    public function buildFullHero(string $name): Hero
    {
        GameLogger::getInstance()->log("🎬 Director: construindo herói completo '{$name}'...");

        return $this->builder
            ->setName($name)
            ->setRace()
            ->setClass()
            ->setBackground()
            ->setPrimaryAttributes()
            ->setDerivedAttributes()
            ->setSkills()
            ->setStartingEquipment()
            ->setPersonalityTraits()
            ->setStartingGold()
            ->build();
    }

    /**
     * Herói mínimo para demonstração (poucos passos)
     */
    public function buildMinimalHero(string $name): Hero
    {
        GameLogger::getInstance()->log("🎬 Director: construindo herói mínimo '{$name}'...");

        return $this->builder
            ->setName($name)
            ->setRace()
            ->setClass()
            ->setPrimaryAttributes()
            ->setDerivedAttributes()
            ->build();
    }
}
