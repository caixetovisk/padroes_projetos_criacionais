<?php

namespace RPG\FactoryMethod;

// ── Produto Concreto 1: Guerreiro ───────────────────────────
class Warrior extends Character
{
    protected function initialize(): void
    {
        $this->health  = 200;
        $this->mana    = 50;
        $this->attack  = 35;
        $this->defense = 30;
        $this->skills  = ['Golpe Poderoso', 'Escudo Protetor', 'Fúria Berserk'];
    }

    public function attack(): string
    {
        return "🗡️  {$this->name} ataca com a espada causando {$this->attack} de dano!";
    }

    public function useSpecialSkill(): string
    {
        return "💥 {$this->name} entra em FÚRIA BERSERK! Dano dobrado por 3 turnos!";
    }
}

// ── Produto Concreto 2: Mago ────────────────────────────────
class Mage extends Character
{
    protected function initialize(): void
    {
        $this->health  = 80;
        $this->mana    = 250;
        $this->attack  = 60;
        $this->defense = 10;
        $this->skills  = ['Bola de Fogo', 'Raio Congelante', 'Teletransporte'];
    }

    public function attack(): string
    {
        $this->mana -= 15;
        return "🔥 {$this->name} lança uma Bola de Fogo causando {$this->attack} de dano mágico!";
    }

    public function useSpecialSkill(): string
    {
        $this->mana -= 50;
        return "❄️  {$this->name} usa RAIO CONGELANTE! Inimigo paralisado por 2 turnos!";
    }
}

// ── Produto Concreto 3: Arqueiro ────────────────────────────
class Archer extends Character
{
    protected function initialize(): void
    {
        $this->health  = 120;
        $this->mana    = 100;
        $this->attack  = 45;
        $this->defense = 15;
        $this->skills  = ['Tiro Certeiro', 'Chuva de Flechas', 'Furtividade'];
    }

    public function attack(): string
    {
        return "🏹 {$this->name} dispara uma flecha causando {$this->attack} de dano!";
    }

    public function useSpecialSkill(): string
    {
        return "🌧️  {$this->name} usa CHUVA DE FLECHAS! Atinge todos os inimigos!";
    }
}

// ── Produto Concreto 4: Paladino ────────────────────────────
class Paladin extends Character
{
    protected function initialize(): void
    {
        $this->health  = 170;
        $this->mana    = 150;
        $this->attack  = 28;
        $this->defense = 25;
        $this->skills  = ['Golpe Sagrado', 'Cura Divina', 'Aura Protetora'];
    }

    public function attack(): string
    {
        return "✨ {$this->name} usa GOLPE SAGRADO causando {$this->attack} de dano sagrado!";
    }

    public function useSpecialSkill(): string
    {
        $heal = 50;
        $this->health += $heal;
        return "💚 {$this->name} usa CURA DIVINA! Recuperou {$heal} pontos de vida!";
    }
}
