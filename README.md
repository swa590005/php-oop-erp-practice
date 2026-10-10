# ERP OOP Playground

A hands-on practice project for **PHP 8+ and object-oriented programming**, built around an ERP domain (articles, materials, services, suppliers, purchase orders, stock) instead of the usual e-commerce examples.

I built this while returning to PHP development after a career break. Every concept below was implemented and tested by hand, not copied from a tutorial.

## Tech Stack

- PHP 8.1+ (`declare(strict_types=1)` throughout)
- Composer with PSR-4 autoloading
- Docker (Colima on macOS) via `docker-compose`

## Getting Started

```bash
# Start the containers
docker-compose up -d

# Install dependencies
docker-compose exec app composer install

# Regenerate the autoloader after adding new classes
docker-compose exec app composer dump-autoload
```

The entry point is `public/index.php`, where each concept is exercised with small test scripts.

## Concepts Covered

### Level 1: Modern PHP 8 syntax
- `match` expressions
- Nullsafe operator `?->`
- Null coalescing `??` and `??=`
- Named arguments
- Arrow functions

### Level 2: OOP basics
- Classes, constructor property promotion, `readonly` properties
- Visibility (`public`, `protected`, `private`)
- Composition and constructor design

### Level 3: Inheritance and contracts
- Inheritance with `extends` and `parent::__construct()`
- Abstract classes and abstract methods
- Interfaces: single, multiple (`implements A, B`), and interface inheritance
- Static properties and methods, static factory methods ("named constructors")
- Backed and plain enums (PHP 8.1): `from()` vs `tryFrom()`
- Polymorphism, shown without any `instanceof` checks

### Level 4: Advanced OOP
- Traits, including constructor and property collisions, `insteadof` and `as`
- Magic methods: `__toString()`, `__get()`/`__set()`, `__invoke()`, `__call()`/`__callStatic()`
- Late static binding: `self::` vs `static::`, and `new static()` in inherited factories
- First-class callable syntax: `ClassName::method(...)` with `usort()` and `array_map()`
- PHP 8 attributes: custom attribute classes read back through the Reflection API

### Level 5: Design (in progress)
- SOLID principles
- Dependency injection
- Design patterns (Factory, Strategy, Repository) in a Symfony context

## Domain Model

| Class | Role |
|---|---|
| `AbstractArticle` | Abstract base for all articles (shared id, name, summary logic) |
| `Material`, `Service` | Concrete articles extending `AbstractArticle` |
| `Supplier`, `Location` | Standalone entities sharing behavior through traits |
| `PurchaseOrder` | Order with status handling, magic accessors, and reflection-readable field labels |
| `OrderStatus` | Backed string enum (`Pending`, `Approved`, `Shipped`, `Cancelled`) |
| `Exportable`, `Auditable` | Interfaces implemented by `Material` |
| `Identifiable`, `Loggable` | Traits with conflict resolution |
| `VatCalculator` | Invokable class (`__invoke`) computing gross values |
| `FieldLabel` | Custom PHP 8 attribute |

## Project Structure

```
app/classes/erp_oops_classes/   # Domain classes (namespace app\classes\erp_oops_classes)
public/index.php                # Test scripts for each concept
composer.json                   # PSR-4 autoload mapping
```

## Notes on Autoloading

Each class lives in its own file, named after the class and placed in the folder matching its namespace. Composer's PSR-4 autoloader resolves classes purely from that mapping, so a misplaced or missing file only fails at the moment the class is first used.

## Roadmap

- Finish Level 5 (SOLID, DI, design patterns)
- Add PHPUnit tests for the domain classes
- Migrate selected classes into a small Symfony application with Doctrine
