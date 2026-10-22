# ERP OOP Playground

A hands-on practice project for **PHP 8+ and object-oriented programming**, built around an ERP domain (articles, materials, services, suppliers, purchase orders, invoices) instead of the usual e-commerce examples.

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

The entry point is `src/public/index.php`, where each concept is exercised with small scripts.

## Running the Tests

```bash
docker-compose exec app vendor/bin/phpunit --bootstrap vendor/autoload.php tests
```

Run it from the `docker` folder. The project currently has 13 PHPUnit tests (see "Testing" below).

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
- PSR-4 autoloading: namespace to path mapping, one class per file

### Level 5: Design (SOLID, DI and patterns)

**SOLID, each one built and tested on an invoice pipeline**
- **S (Single Responsibility):** invoice work split into `InvoiceCalculator`, `GenerateCsv`, `SaveData` and a coordinating `InvoiceProcessor`
- **O (Open/Closed):** new mail services are new classes, not edits to the processor
- **L (Liskov Substitution):** a `FreeSample` that throws in `getValue()` breaks the price loop; fixed by keeping the parent's promise (and a `BulkDiscount` that accepts any amount)
- **I (Interface Segregation):** small `EmailNotifier` and SMS interfaces instead of one big notifier; a class implements only what it can do
- **D (Dependency Inversion):** classes depend on `EmailNotifier` and `Discount`, not on concrete classes

**Dependency injection**
- Constructor injection in `InvoiceProcessor` and `InvoiceCalculator`
- A `FakeEmailNotifier` test double that records what it was asked to send

**Design patterns**
- **Factory:** `ArticleFactory::create()` builds `Material` or `FreeSample` from runtime data, with clear exceptions for unknown types or a missing price
- **Strategy:** `Discount` with `StandardDiscount` and `BulkDiscount`, injected into `InvoiceCalculator` (discount first, then 19% VAT)
- **Repository:** `ArticleRepository` interface with an in-memory implementation that finds articles by id and returns `null` for unknown ids

### Testing (PHPUnit)
- First PHPUnit setup in Docker; reading green and red output
- Strict assertions: `assertSame` (value and type), `assertNull`, `assertInstanceOf`, `expectException`
- `setUp()` for a fresh object per test
- **Boundary tests:** `BulkDiscount` below, at and above 100
- **Factory tests:** valid types, unknown type, material without a price
- **Repository tests:** found by id, `null` for an unknown id, two articles stay separate. A mutation check (breaking `add()` on purpose) proved these tests really catch the bug
- **Test double:** `InvoiceProcessor` is tested with `FakeEmailNotifier`, so no real email is sent. The same processor gives different totals for `StandardDiscount` and `BulkDiscount`

## Domain Model

| Class | Role |
|---|---|
| `AbstractArticle` | Abstract base for all articles (shared id, name, summary logic) |
| `Material`, `Service`, `FreeSample` | Concrete articles extending `AbstractArticle` |
| `ArticleFactory` | Creates the right article from a type string plus data |
| `ArticleRepository`, `InMemoryArticleRepository` | Collection-like access to articles, hiding storage |
| `Supplier`, `Location` | Standalone entities sharing behavior through traits |
| `PurchaseOrder` | Order with status handling, magic accessors, and reflection-readable field labels |
| `OrderStatus` | Backed string enum (`Pending`, `Approved`, `Shipped`, `Cancelled`) |
| `Exportable`, `Auditable` | Interfaces implemented by `Material` |
| `Identifiable`, `Loggable` | Traits with conflict resolution |
| `VatCalculator` | Invokable class (`__invoke`) computing gross values |
| `FieldLabel` | Custom PHP 8 attribute |
| `InvoiceCalculator` | Totals with VAT; receives a `Discount` strategy |
| `Discount`, `StandardDiscount`, `BulkDiscount` | Discount strategy family |
| `GenerateCsv`, `SaveData` | Single-purpose invoice helpers |
| `InvoiceProcessor` | Coordinates the invoice steps; receives its helpers by constructor |
| `EmailNotifier` and implementations | Interchangeable mail services behind one interface |
