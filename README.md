# 🎮 Dragon's Quest — Padrões de Projeto em PHP

Projeto didático que demonstra **5 padrões de projeto** (GoF) usando um sistema de **RPG** como exemplo.

---

## 🗺️ Estrutura do Projeto

```
design-patterns-rpg/
├── composer.json               # Configuração do Composer (PSR-4)
├── autoload.php                # Autoloader manual (substitui vendor/autoload.php)
├── index.php                   # Demo principal — executa todos os padrões
└── src/
    ├── Singleton/
    │   ├── GameLogger.php      # Log único do jogo
    │   └── GameConfig.php      # Configurações globais
    ├── FactoryMethod/
    │   ├── Character.php       # Produto abstrato + subclasses concretas
    │   ├── Characters.php      # Warrior, Mage, Archer, Paladin
    │   └── CharacterFactories.php  # Fábricas + Registry dinâmico
    ├── AbstractFactory/
    │   ├── Equipment.php       # Interfaces + 4 famílias de itens
    │   └── EquipmentFactories.php  # Heavy, Magic, Shadow, Holy
    ├── Builder/
    │   ├── Hero.php            # Produto Hero + interface HeroBuilder
    │   └── HeroBuilders.php    # 3 Builders concretos + Director
    └── Prototype/
        ├── NPC.php             # Protótipo base + Skill (deep copy)
        └── NPCRegistry.php     # Registro de protótipos pré-configurados
```

---

## 🚀 Como Executar

### Com Composer instalado

```bash
composer install
php index.php
```

### Sem Composer (autoloader manual incluído)

```bash
php index.php
```

---

## 🎯 Padrões Implementados

### 1. Singleton — `GameLogger` & `GameConfig`

| Aspecto | Detalhe |
|---|---|
| **Problema** | Precisamos de um único log/configuração compartilhado em todo o jogo |
| **Solução** | Construtor privado + método `getInstance()` estático |
| **Onde usar** | Logs, configs, conexões de banco, cache |

```php
// Sempre retorna a mesma instância
$logger = GameLogger::getInstance();
$logger->log("Evento importante!");

// Prova: todas as variáveis apontam para o mesmo objeto
$a = GameLogger::getInstance();
$b = GameLogger::getInstance();
var_dump($a === $b); // true
```

---

### 2. Factory Method — `CharacterFactory`

| Aspecto | Detalhe |
|---|---|
| **Problema** | Criar Guerreiro/Mago/Arqueiro sem o cliente saber qual classe instanciar |
| **Solução** | Fábrica abstrata com `createCharacter()` implementado por subclasses |
| **Onde usar** | Criação de objetos polimórficos, plugins, sistemas extensíveis |

```php
// O cliente usa a fábrica sem saber o que está sendo criado
$factory = CharacterFactoryRegistry::getFactory('mage'); // WarriorFactory, MageFactory...
$character = $factory->spawnCharacter('Gandalf');

// Polimorfismo — mesma interface, comportamentos diferentes
$character->attack();          // 🔥 Gandalf lança Bola de Fogo!
$character->useSpecialSkill(); // ❄️  Gandalf usa Raio Congelante!
```

---

### 3. Abstract Factory — `EquipmentFactory`

| Aspecto | Detalhe |
|---|---|
| **Problema** | Garantir que Arma + Armadura + Acessório sejam sempre compatíveis |
| **Solução** | Interface de fábrica com métodos para cada produto da família |
| **Onde usar** | Temas de UI (Dark/Light), drivers de BD, kits de componentes |

```php
// Escolha a família — todos os itens serão compatíveis
$factory = new MagicEquipmentFactory();  // Ou HeavyEquipmentFactory, etc.

$weapon    = $factory->createWeapon();    // Cajado do Arquimago
$armor     = $factory->createArmor();    // Manto das Estrelas
$accessory = $factory->createAccessory(); // Orbe do Poder Arcano
// Nunca mistura Espada com Manto de Mago! 🎯
```

---

### 4. Builder — `HeroBuilder`

| Aspecto | Detalhe |
|---|---|
| **Problema** | Herói tem >10 atributos — construtor com tantos parâmetros é ilegível |
| **Solução** | Builder separa cada etapa de construção; Director orquestra a ordem |
| **Onde usar** | Objetos com muitos parâmetros opcionais, SQL builders, HTML builders |

```php
// Via Director (ordem controlada)
$director = new HeroDirector();
$director->setBuilder(new ElfMageBuilder());
$hero = $director->buildFullHero('Gandalf');

// Manual (flexível — pula etapas opcionais)
$hero = (new DwarfWarriorBuilder())
    ->setName('Thorin')
    ->setRace()
    ->setPrimaryAttributes()
    ->build(); // Sem skills, sem equipamentos — herói mínimo
```

---

### 5. Prototype — `NPCRegistry`

| Aspecto | Detalhe |
|---|---|
| **Problema** | Criar 50 Goblins do zero a cada chamada é lento e verboso |
| **Solução** | Definir templates e clonar — modificações no clone não afetam o original |
| **Onde usar** | Spawn de inimigos em jogos, templates de documentos, cache de objetos |

```php
// Registra protótipos uma vez só
NPCRegistry::initialize();

// Clona quantas vezes quiser — rápido e independente
$goblin1 = NPCRegistry::spawn('goblin', 'Gruk');
$goblin2 = NPCRegistry::spawn('goblin', 'Zrak');

// Modificar o clone NÃO afeta o protótipo nem outros clones
$goblin1->health = 999; // Só afeta goblin1
$goblin2->health;       // Ainda 40 (original)
```

**Atenção — Deep Copy vs Shallow Copy:**
```php
// PHP faz shallow copy por padrão.
// Objetos aninhados (array de Skill) precisam de deep copy manual:
public function clone(): static {
    $clone = clone $this;  // Copia primitivos automaticamente
    // Deep copy dos objetos aninhados:
    $clone->skills = array_map(fn($s) => new Skill(...), $this->skills);
    return $clone;
}
```

---

## 📊 Comparativo dos Padrões

| Padrão | Categoria | Intenção |
|---|---|---|
| Singleton | Criacional | **1 instância** global |
| Factory Method | Criacional | Subclasses decidem **o que** criar |
| Abstract Factory | Criacional | Famílias de objetos **compatíveis** |
| Builder | Criacional | Construção **passo a passo** |
| Prototype | Criacional | Criar por **clonagem** |

---

## 🧪 Testando Individualmente

```bash
# Executar apenas o Singleton
php -r "require 'autoload.php'; use RPG\Singleton\GameLogger; GameLogger::getInstance()->log('Teste!');"

# Executar o projeto completo
php index.php
```

---

## 📚 Referências

- **Design Patterns** — Gang of Four (Erich Gamma et al.)
- **PHP Standards Recommendations** — PSR-4 Autoloading
- **refactoring.guru** — Exemplos visuais dos padrões
# padroes_projetos_criacionais
