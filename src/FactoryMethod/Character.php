<?php

namespace RPG\FactoryMethod;

/**
 * ============================================================
 * PADRÃO: FACTORY METHOD
 * ============================================================
 * Define uma interface para criar objetos, mas deixa as
 * subclasses decidirem QUAL classe instanciar.
 *
 * PROBLEMA: Quando o jogador escolhe uma classe (Guerreiro,
 * Mago, Arqueiro), cada personagem precisa ser criado com
 * atributos, habilidades e equipamentos específicos.
 * O código cliente não deve saber como cada um é construído.
 *
 * SOLUÇÃO: CharacterFactory define o método createCharacter()
 * (o "factory method"). Cada subclasse de fábrica sabe criar
 * apenas o seu tipo de personagem.
 * ============================================================
 */

// ── Produto abstrato ────────────────────────────────────────
abstract class Character
{
    protected string $name;
    protected int    $health;
    protected int    $mana;
    protected int    $attack;
    protected int    $defense;
    protected array  $skills = [];

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->initialize();
    }

    /**
     * Cada personagem define seus atributos iniciais
     */
    abstract protected function initialize(): void;

    /**
     * Comportamento de ataque polimórfico
     */
    abstract public function attack(): string;

    /**
     * Habilidade especial
     */
    abstract public function useSpecialSkill(): string;

    public function getStatus(): string
    {
        return sprintf(
            "⚔️  %s | HP: %d | MP: %d | ATK: %d | DEF: %d | Skills: %s",
            $this->name,
            $this->health,
            $this->mana,
            $this->attack,
            $this->defense,
            implode(', ', $this->skills)
        );
    }

    public function getName(): string { return $this->name; }
    public function getHealth(): int  { return $this->health; }
}
