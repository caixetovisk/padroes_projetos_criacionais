<?php

namespace RPG\Prototype;

use RPG\Singleton\GameLogger;

/**
 * Registro de Protótipos — armazena os templates pré-configurados.
 * Funciona como uma "biblioteca de inimigos" que o jogo usa
 * para gerar instâncias rapidamente sem reconfigurar do zero.
 */
class NPCRegistry
{
    private static array $prototypes = [];
    private static bool  $initialized = false;

    /**
     * Inicializa todos os protótipos de inimigos do jogo.
     * Chamado uma única vez na inicialização do jogo.
     */
    public static function initialize(): void
    {
        if (static::$initialized) return;

        GameLogger::getInstance()->log("📚 NPCRegistry: Inicializando biblioteca de protótipos...");

        static::register('goblin',      static::createGoblinPrototype());
        static::register('orc',         static::createOrcPrototype());
        static::register('skeleton',    static::createSkeletonPrototype());
        static::register('troll',       static::createTrollPrototype());
        static::register('dragon',      static::createDragonPrototype());
        static::register('dark_knight', static::createDarkKnightPrototype());
        static::register('merchant',    static::createMerchantPrototype());

        static::$initialized = true;
        GameLogger::getInstance()->log("✅ " . count(static::$prototypes) . " protótipos registrados.");
    }

    public static function register(string $key, NPC $prototype): void
    {
        static::$prototypes[$key] = $prototype;
    }

    /**
     * Clona um protótipo registrado.
     * Este é o ponto central do padrão Prototype.
     */
    public static function spawn(string $key, ?string $customName = null): NPC
    {
        if (!isset(static::$prototypes[$key])) {
            throw new \InvalidArgumentException("Protótipo não encontrado: {$key}");
        }

        $clone = static::$prototypes[$key]->clone();

        if ($customName !== null) {
            $clone->name = $customName;
        }

        return $clone;
    }

    public static function listPrototypes(): array
    {
        return array_keys(static::$prototypes);
    }

    // ── Definição dos Protótipos ──────────────────────────

    private static function createGoblinPrototype(): NPC
    {
        $goblin = new NPC('Goblin');
        $goblin->type             = 'Humanóide';
        $goblin->faction          = 'Horda das Trevas';
        $goblin->health           = 40;
        $goblin->maxHealth        = 40;
        $goblin->attack           = 12;
        $goblin->defense          = 5;
        $goblin->speed            = 14;
        $goblin->experienceReward = 25;
        $goblin->goldReward       = random_int(1, 5);
        $goblin->behavior         = 'aggressive';
        $goblin->lootTable        = ['Faca Enferrujada', 'Poção Pequena', 'Ouro'];
        $goblin->dialogue         = 'Grrrk! Intrusos! MATAR!';
        $goblin->addSkill(new Skill('Golpe Rápido', 12, 0, 'Ataque básico veloz'));
        $goblin->addSkill(new Skill('Mordida', 8, 0, 'Morde o inimigo causando sangramento'));
        return $goblin;
    }

    private static function createOrcPrototype(): NPC
    {
        $orc = new NPC('Orc Guerreiro');
        $orc->type             = 'Humanóide';
        $orc->faction          = 'Clã Sangue de Ferro';
        $orc->health           = 120;
        $orc->maxHealth        = 120;
        $orc->attack           = 28;
        $orc->defense          = 15;
        $orc->speed            = 8;
        $orc->experienceReward = 80;
        $orc->goldReward       = random_int(5, 15);
        $orc->behavior         = 'aggressive';
        $orc->lootTable        = ['Machado de Orc', 'Elmo de Ferro', 'Poção Média'];
        $orc->dialogue         = 'RAAAAH! Você vai morrer hoje!';
        $orc->addSkill(new Skill('Golpe de Machado', 35, 0, 'Ataque pesado com machado'));
        $orc->addSkill(new Skill('Grito de Guerra', 0, 20, 'Aumenta ATK em 20% por 3 turnos'));
        return $orc;
    }

    private static function createSkeletonPrototype(): NPC
    {
        $skeleton = new NPC('Esqueleto');
        $skeleton->type             = 'Morto-Vivo';
        $skeleton->faction          = 'Legião das Trevas';
        $skeleton->health           = 60;
        $skeleton->maxHealth        = 60;
        $skeleton->attack           = 18;
        $skeleton->defense          = 10;
        $skeleton->speed            = 9;
        $skeleton->experienceReward = 40;
        $skeleton->goldReward       = random_int(0, 8);
        $skeleton->behavior         = 'patrol';
        $skeleton->lootTable        = ['Ossos', 'Espada Enferrujada', 'Escudo Quebrado'];
        $skeleton->dialogue         = '...'; // Esqueletos não falam
        $skeleton->addSkill(new Skill('Golpe de Osso', 18, 0, 'Ataque básico com arma'));
        $skeleton->addSkill(new Skill('Regenerar', 0, 30, 'Recupera 15 HP (se tiver MP)'));
        return $skeleton;
    }

    private static function createTrollPrototype(): NPC
    {
        $troll = new NPC('Troll das Cavernas');
        $troll->type             = 'Gigante';
        $troll->faction          = 'Selvagens';
        $troll->health           = 250;
        $troll->maxHealth        = 250;
        $troll->attack           = 45;
        $troll->defense          = 20;
        $troll->speed            = 5;
        $troll->experienceReward = 200;
        $troll->goldReward       = random_int(20, 50);
        $troll->behavior         = 'aggressive';
        $troll->lootTable        = ['Couro de Troll', 'Dente de Troll', 'Grande Clava'];
        $troll->dialogue         = 'UARG! TROLL ESMAGAR!';
        $troll->addSkill(new Skill('Esmagar', 55, 0, 'Ataque devastador com os punhos'));
        $troll->addSkill(new Skill('Regeneração', 0, 0, 'Regenera 20 HP por turno automaticamente'));
        $troll->addSkill(new Skill('Arremessar Rocha', 40, 0, 'Ataque à distância'));
        return $troll;
    }

    private static function createDragonPrototype(): NPC
    {
        $dragon = new NPC('Dragão Ancião');
        $dragon->type             = 'Dragão';
        $dragon->faction          = 'Dragões';
        $dragon->health           = 1000;
        $dragon->maxHealth        = 1000;
        $dragon->attack           = 120;
        $dragon->defense          = 60;
        $dragon->speed            = 12;
        $dragon->experienceReward = 5000;
        $dragon->goldReward       = random_int(500, 1000);
        $dragon->behavior         = 'aggressive';
        $dragon->isBoss           = true;
        $dragon->lootTable        = [
            'Escama de Dragão',
            'Garra de Dragão',
            'Coração de Dragão',
            'Tesouro do Dragão',
            'Orbe Lendário',
        ];
        $dragon->dialogue         = 'Mortais... ousam desafiar Ignaros, o Eterno?!';
        $dragon->addSkill(new Skill('Baforada de Fogo',    150, 50, 'Atingi todos os inimigos com chamas'));
        $dragon->addSkill(new Skill('Garras Dilaceradoras', 120,  0, 'Ataque físico devastador'));
        $dragon->addSkill(new Skill('Rugido do Terror',      0, 40, 'Causa medo — reduz ATK inimigo em 30%'));
        $dragon->addSkill(new Skill('Voo Rasante',          90,  0, 'Atinge todos inimigos fisicamente'));
        return $dragon;
    }

    private static function createDarkKnightPrototype(): NPC
    {
        $dk = new NPC('Cavaleiro das Trevas');
        $dk->type             = 'Humano Corrompido';
        $dk->faction          = 'Ordem Sombria';
        $dk->health           = 350;
        $dk->maxHealth        = 350;
        $dk->attack           = 75;
        $dk->defense          = 45;
        $dk->speed            = 10;
        $dk->experienceReward = 800;
        $dk->goldReward       = random_int(100, 200);
        $dk->behavior         = 'aggressive';
        $dk->isBoss           = true;
        $dk->lootTable        = ['Armadura Sombria', 'Espada das Trevas', 'Fragmento de Alma'];
        $dk->dialogue         = 'Sua alma pertence às Trevas!';
        $dk->addSkill(new Skill('Golpe das Trevas',   90, 30, 'Ataque carregado com energia sombria'));
        $dk->addSkill(new Skill('Drenar Vida',         50, 40, 'Rouba HP do alvo'));
        $dk->addSkill(new Skill('Aura da Morte',        0, 60, 'Todos os inimigos sofrem -20 HP/turno'));
        return $dk;
    }

    private static function createMerchantPrototype(): NPC
    {
        $merchant = new NPC('Mercador Viajante');
        $merchant->type             = 'Humano';
        $merchant->faction          = 'Neutro';
        $merchant->health           = 50;
        $merchant->maxHealth        = 50;
        $merchant->attack           = 5;
        $merchant->defense          = 5;
        $merchant->speed            = 10;
        $merchant->experienceReward = 0;
        $merchant->goldReward       = 0;
        $merchant->behavior         = 'passive';
        $merchant->lootTable        = [];
        $merchant->dialogue         = 'Bem-vindo, aventureiro! O que posso oferecer hoje?';
        return $merchant;
    }
}
