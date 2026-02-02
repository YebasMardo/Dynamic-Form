# Copilot Instructions for Dynamic Form Reservation System

## Project Overview
A Symfony 8.0 application demonstrating **dynamic forms** that conditionally show/hide fields based on user selections. The core use case is a flight/train reservation system where field visibility depends on transport type and round-trip selection.

**Key Stack**: Symfony 8.0, Twig Components, Stimulus/UX Live Component, PostgreSQL, Bootstrap 5

## Architecture

### Three-Layer Form System
1. **Model Layer** (`src/Model/Reservation.php`): Plain PHP objects with typed properties (using PHP 8.4 named constructor syntax)
2. **Form Type** (`src/Form/ReservationType.php`): Uses `DynamicFormBuilder` from `symfonycasts/dynamic-forms` library to define conditional fields
3. **Template** (`templates/components/ReservationForm.html.twig`): Twig Component with Live Component integration for real-time validation

### Enum-Based Dropdowns with i18n
All enums (`TransportType`, `FlightClass`, `SeatPreference`) implement `TranslatableInterface` with inline `trans()` methods. This enables:
- Type-safe enum usage in forms via `EnumType`
- Automatic Twig translation support
- Client-side rendering consistency

### Live Component Architecture
The form uses Symfony UX Live Component's `data-action="live#action:prevent"` to intercept form changes without full page reload. The component name `ReservationForm` maps to both the Twig template and the component rendering logic.

## Critical Developer Workflows

### Local Development
```bash
# Start database (PostgreSQL in Docker)
docker-compose up -d

# Install dependencies
composer install

# Run dev server
symfony server:start  # or bin/console server:start

# Watch asset changes (separate terminal)
symfony asset-map:compile --watch
```

### Database Operations
```bash
# Create/migrate database
bin/console doctrine:migrations:migrate

# See registered routes
bin/console debug:router

# Debug form structure
bin/console debug:form ReservationType
```

### Testing
```bash
# Run tests (configured with strict settings in phpunit.dist.xml)
bin/phpunit

# Watch mode for TDD
bin/phpunit --watch
```

## Project-Specific Patterns

### Dynamic Form Field Dependencies
Fields are added conditionally using `$builder->addDependent()`:
- **Closure receives** the field object AND the dependent field's current value
- **Example**: `returnDate` only renders when `isRoundTrip` is `true`
- **Pattern**: Each condition checks the field value and calls `$field->add()` only if needed

### Stimulus Controller Integration
JavaScript controllers in `assets/controllers/` use Stimulus framework attributes (e.g., `data-action`, `data-controller`). The Live Component's `live#action:prevent` automatically prevents form submission and sends state to backend.

### Twig Component Usage
All reusable UI is in `templates/components/` and rendered via `{{ component('ComponentName', vars) }}`. The `ReservationForm` component receives no props—it manages its own form internally.

## Key Files & Their Responsibilities

| File | Purpose |
|------|---------|
| [src/Model/Reservation.php](src/Model/Reservation.php) | Data transfer object for form binding |
| [src/Form/ReservationType.php](src/Form/ReservationType.php) | Form definition with dynamic field rules |
| [src/Enum/*.php](src/Enum/) | Type-safe dropdowns with i18n translations |
| [templates/components/ReservationForm.html.twig](templates/components/ReservationForm.html.twig) | Live Component template with form rendering |
| [src/Controller/HomeController.php](src/Controller/HomeController.php) | Routes to home page; renders ReservationForm component |
| [config/services.yaml](config/services.yaml) | Autowiring configuration; all `App\` classes auto-registered |

## External Dependencies to Know

- **symfonycasts/dynamic-forms** (`^0.2.0`): Handles conditional field building
- **symfony/ux-live-component** (`^2.32`): Real-time form validation without page reload
- **symfony/stimulus-bundle** (`^2.32`): JavaScript framework for interactive elements
- **symfony/asset-mapper** (`8.0.*`): Automatic asset versioning and import resolution

## Common Modification Points

### Adding a New Conditional Field
1. Add field to `Reservation` model as optional property
2. Use `$builder->addDependent('fieldName', 'parentField', function(...) {...})` in `ReservationType`
3. Add translation in relevant enum's `trans()` method if dropdown-based

### Changing Form Styling
- Bootstrap classes applied directly in Twig template (`card`, `card-body`, etc.)
- Edit [templates/components/ReservationForm.html.twig](templates/components/ReservationForm.html.twig)

### Adding Validation
- Use Symfony Validator attributes on `Reservation` class properties
- Validation runs on both form submission and Live Component updates

## Testing Patterns
- Tests should use Symfony's test bootstrap (`tests/bootstrap.php`)
- PHPUnit configured for strict mode (fails on deprecations, notices, warnings)
- No existing test examples—follow Symfony testing best practices with `WebTestCase` or `KernelTestCase`

## Build & Deployment Notes
- Uses `symfony/flex` for auto-configuration of bundles
- Environment variables via `.env` and `.env.local` (not in version control)
- Docker Compose includes PostgreSQL service—configure credentials in `.env`
- Asset mapping handled automatically; no webpack/build step needed for JS imports
