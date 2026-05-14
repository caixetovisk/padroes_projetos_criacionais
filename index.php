<?php

/**
 * ================================================================
 *   🎮 DRAGON'S QUEST — Demonstração de Padrões de Projeto
 * ================================================================
 * Padrões implementados com tema RPG:
 *
 *   1. SINGLETON       → GameLogger & GameConfig
 *   2. FACTORY METHOD  → CharacterFactory (Warrior, Mage, Archer, Paladin)
 *   3. ABSTRACT FACTORY→ EquipmentFactory (Heavy, Magic, Shadow, Holy)
 *   4. BUILDER         → HeroBuilder (DwarfWarrior, ElfMage, HumanArcher)
 *   5. PROTOTYPE       → NPCRegistry (Goblin, Orc, Skeleton, Troll, Dragon...)
 * ================================================================
 */

declare(strict_types=1);

require_once __DIR__ . '/autoload.php';

use RPG\Singleton\{GameLogger, GameConfig};
use RPG\FactoryMethod\{CharacterFactoryRegistry};
use RPG\AbstractFactory\{HeavyEquipmentFactory, MagicEquipmentFactory, ShadowEquipmentFactory, HolyEquipmentFactory};
use RPG\Builder\{DwarfWarriorBuilder, ElfMageBuilder, HumanArcherBuilder, HeroDirector};
use RPG\Prototype\{NPCRegistry};

// ════════════════════════════════════════════════════════════════
// Helpers de exibição
// ════════════════════════════════════════════════════════════════

function patternHeader(string $title, string $pattern): void
{
    echo PHP_EOL;
    echo "╔═══════════════════════════════════════════════════════════════╗" . PHP_EOL;
    echo "║  🎯 PADRÃO: {$pattern}" . str_repeat(' ', 48 - strlen($pattern)) . "\t║" . PHP_EOL;
    echo "║     {$title}" . str_repeat(' ', 55 - strlen($title)) . "\t║" . PHP_EOL;
    echo "╚═══════════════════════════════════════════════════════════════╝" . PHP_EOL;
}

function section(string $title): void
{
    echo PHP_EOL . "  ── {$title} " . str_repeat('─', max(0, 50 - strlen($title))) . PHP_EOL;
}

// ════════════════════════════════════════════════════════════════
// 1. SINGLETON — GameLogger e GameConfig
// ════════════════════════════════════════════════════════════════
patternHeader('GameLogger & GameConfig', 'SINGLETON');

$logger = GameLogger::getInstance();
$logger->log("🎮 Bem-vindo a Dragon's Quest!");

$config = GameConfig::getInstance();
$logger->log("📖 Jogo: " . $config->get('game_name') . " v" . $config->get('version'));

section("Prova de instância única");
$logger1 = GameLogger::getInstance();
$logger2 = GameLogger::getInstance();
$logger3 = GameLogger::getInstance();

echo "  Logger 1 === Logger 2? " . ($logger1 === $logger2 ? '✅ SIM (mesma instância)' : '❌ NÃO') . PHP_EOL;
echo "  Logger 1 === Logger 3? " . ($logger1 === $logger3 ? '✅ SIM (mesma instância)' : '❌ NÃO') . PHP_EOL;
echo "  Todas as 3 variáveis apontam para O MESMO objeto na memória!" . PHP_EOL;

section("GameConfig — ajustando dificuldade");
echo "  Dificuldade atual: " . $config->get('difficulty') . PHP_EOL;
$config->set('difficulty', 'hard');
echo "  Nova dificuldade:  " . $config->get('difficulty') . PHP_EOL;

// ════════════════════════════════════════════════════════════════
// 2. FACTORY METHOD — Criação de Personagens
// ════════════════════════════════════════════════════════════════
patternHeader('Criação de Personagens de Jogo', 'FACTORY METHOD');
echo PHP_EOL;
echo "  O código cliente usa CharacterFactory sem saber QUAL" . PHP_EOL;
echo "  classe concreta (Warrior, Mage, Archer) será criada." . PHP_EOL;

section("Criando personagens via fábricas específicas");

$warriorFactory = CharacterFactoryRegistry::getFactory('warrior');
$warrior = $warriorFactory->spawnCharacter('Thorin');

$mageFactory = CharacterFactoryRegistry::getFactory('mage');
$mage = $mageFactory->spawnCharacter('Gandalf');

$archerFactory = CharacterFactoryRegistry::getFactory('archer');
$archer = $archerFactory->spawnCharacter('Legolas');

$paladinFactory = CharacterFactoryRegistry::getFactory('paladin');
$paladin = $paladinFactory->spawnCharacter('Arthur');

section("Usando polimorfismo — mesma interface, comportamentos diferentes");
$characters = [$warrior, $mage, $archer, $paladin];
foreach ($characters as $character) {
    echo "  " . $character->attack() . PHP_EOL;
    echo "  " . $character->useSpecialSkill() . PHP_EOL;
    echo PHP_EOL;
}

// ════════════════════════════════════════════════════════════════
// 3. ABSTRACT FACTORY — Conjuntos de Equipamentos
// ════════════════════════════════════════════════════════════════
patternHeader('Conjuntos de Equipamentos Temáticos', 'ABSTRACT FACTORY');
echo PHP_EOL;
echo "  A Abstract Factory garante que Weapon + Armor + Accessory" . PHP_EOL;
echo "  sejam sempre da mesma família (sem misturar estilos)." . PHP_EOL;

section("Conjunto Pesado para Thorin (Guerreiro)");
$heavyFactory = new HeavyEquipmentFactory();
$heavySet = $heavyFactory->createFullSet('Thorin');

section("Conjunto Mágico para Gandalf (Mago)");
$magicFactory = new MagicEquipmentFactory();
$magicSet = $magicFactory->createFullSet('Gandalf');

section("Conjunto Sombrio para Sombra (Ladrão)");
$shadowFactory = new ShadowEquipmentFactory();
$shadowSet = $shadowFactory->createFullSet('Sombra');

section("Conjunto Sagrado para Arthur (Paladino)");
$holyFactory = new HolyEquipmentFactory();
$holySet = $holyFactory->createFullSet('Arthur');

section("Prova de compatibilidade — itens sempre coerentes");
echo "  Guerreiro usa: {$heavySet['weapon']->getName()} + {$heavySet['armor']->getName()}" . PHP_EOL;
echo "  Mago usa:      {$magicSet['weapon']->getName()} + {$magicSet['armor']->getName()}" . PHP_EOL;
echo "  Ladrão usa:    {$shadowSet['weapon']->getName()} + {$shadowSet['armor']->getName()}" . PHP_EOL;

// ════════════════════════════════════════════════════════════════
// 4. BUILDER — Construção de Heróis Complexos
// ════════════════════════════════════════════════════════════════
patternHeader('Construção de Heróis Complexos', 'BUILDER');
echo PHP_EOL;
echo "  Builder separa a CONSTRUÇÃO de um Hero complexo (com" . PHP_EOL;
echo "  raça, classe, atributos, skills, equipamentos, traços...)" . PHP_EOL;
echo "  da sua REPRESENTAÇÃO final." . PHP_EOL;

$director = new HeroDirector();

section("Hero 1: Guerreiro Anão (via Director)");
$director->setBuilder(new DwarfWarriorBuilder());
$dwarfHero = $director->buildFullHero('Durin Forgemartin');
echo $dwarfHero->describe() . PHP_EOL;

section("Hero 2: Mago Elfo (via Director)");
$director->setBuilder(new ElfMageBuilder());
$elfHero = $director->buildFullHero('Aelindra Starweave');
echo $elfHero->describe() . PHP_EOL;

section("Hero 3: Arqueiro Humano (via Director — herói mínimo)");
$director->setBuilder(new HumanArcherBuilder());
$humanHero = $director->buildMinimalHero('Robin Ashwood');
echo $humanHero->describe() . PHP_EOL;

section("Hero 4: Construção MANUAL (sem Director)");
// O cliente pode usar o Builder diretamente, passo a passo
$customBuilder = new ElfMageBuilder();
$customHero = $customBuilder
    ->setName('Merlin o Cinzento')
    ->setRace()
    ->setClass()
    ->setBackground()
    ->setPrimaryAttributes()
    ->setDerivedAttributes()
    ->setSkills()
    ->setStartingEquipment()
    ->setStartingGold()
    // Sem setPersonalityTraits() — construção parcial é possível!
    ->build();

echo "  Herói customizado (sem traços de personalidade):" . PHP_EOL;
echo $customHero->describe() . PHP_EOL;

// ════════════════════════════════════════════════════════════════
// 5. PROTOTYPE — Clonagem de NPCs e Inimigos
// ════════════════════════════════════════════════════════════════
patternHeader('Clonagem de NPCs e Inimigos', 'PROTOTYPE');
echo PHP_EOL;
echo "  Em vez de criar cada inimigo do zero, clonamos templates" . PHP_EOL;
echo "  pré-configurados. Rápido, eficiente e permite variações." . PHP_EOL;

NPCRegistry::initialize();

section("Prova do Prototype — mesma classe, instâncias independentes");
$goblin1 = NPCRegistry::spawn('goblin', 'Gruk');
$goblin2 = NPCRegistry::spawn('goblin', 'Zrak');
$goblin3 = NPCRegistry::spawn('goblin', 'Morg');

echo PHP_EOL;
echo "  Os 3 goblins têm IDs diferentes mas mesma configuração base:" . PHP_EOL;
echo $goblin1->describe() . PHP_EOL;
echo $goblin2->describe() . PHP_EOL;
echo $goblin3->describe() . PHP_EOL;

section("Simulação de combate com goblins clonados");
$targets = [$goblin1, $goblin2, $goblin3];
foreach ($targets as $g) {
    echo "  " . $g->takeDamage(25) . PHP_EOL;
}

section("Modificar um clone NÃO afeta o protótipo original");
echo "  Spawning goblin especial com habilidade modificada..." . PHP_EOL;
$specialGoblin = NPCRegistry::spawn('goblin', 'Goblin Rei');
$specialGoblin->health    = 150;    // Boss version
$specialGoblin->attack    = 30;
$specialGoblin->isBoss    = true;
$specialGoblin->goldReward = 500;
// Modifica skill do clone (deep copy garante independência)
$specialGoblin->skills[0]->damage = 50;

echo "  Clone modificado:" . PHP_EOL;
echo $specialGoblin->describe() . PHP_EOL;

// Spawna um goblin normal — NÃO foi afetado pela modificação acima
$normalGoblin = NPCRegistry::spawn('goblin', 'Goblin Normal');
echo "  Goblin original (protótipo intacto):" . PHP_EOL;
echo $normalGoblin->describe() . PHP_EOL;

section("Boss final: Dragão Ancião (Chefe de Masmorra)");
$dragon = NPCRegistry::spawn('dragon', 'Ignaros, o Eterno');
echo $dragon->describe() . PHP_EOL;

section("Spawn em massa — eficiência do Prototype");
$startTime = microtime(true);
$wave = [];
for ($i = 1; $i <= 50; $i++) {
    $wave[] = NPCRegistry::spawn('skeleton', "Esqueleto #{$i}");
}
$endTime = microtime(true);

echo "  ✅ 50 Esqueletos clonados em " . round(($endTime - $startTime) * 1000, 3) . " ms!" . PHP_EOL;
echo "  Cada um tem um ID único e estado de HP independente." . PHP_EOL;

// Prova que são instâncias independentes
$wave[0]->takeDamage(999); // Mata o primeiro
echo "  " . $wave[0]->name . ": " . ($wave[0]->isAlive() ? 'Vivo' : '💀 Morto') . PHP_EOL;
echo "  " . $wave[1]->name . ": " . ($wave[1]->isAlive() ? '✅ Ainda vivo (independente!)' : 'Morto') . PHP_EOL;

// ════════════════════════════════════════════════════════════════
// RESUMO FINAL
// ════════════════════════════════════════════════════════════════
echo PHP_EOL;
echo "╔══════════════════════════════════════════════════════════╗" . PHP_EOL;
echo "║              📚 RESUMO DOS PADRÕES                       ║" . PHP_EOL;
echo "╠══════════════════════════════════════════════════════════╣" . PHP_EOL;
echo "║  SINGLETON       Garante 1 instância global (Logger)     ║" . PHP_EOL;
echo "║  FACTORY METHOD  Delega criação para subclasses          ║" . PHP_EOL;
echo "║  ABSTRACT FACTORY Famílias de objetos compatíveis        ║" . PHP_EOL;
echo "║  BUILDER         Constrói objetos complexos por etapas   ║" . PHP_EOL;
echo "║  PROTOTYPE       Clona objetos em vez de criar do zero   ║" . PHP_EOL;
echo "╚══════════════════════════════════════════════════════════╝" . PHP_EOL;

$logger->log("🏁 Demonstração concluída! Total de logs: " . $logger->getCallCount());
