# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

DaplosBundle is a Symfony bundle for integrating DAPLOS (French agricultural data referentials from AgroEDI Europe) into Symfony applications. It provides API client, entity generation, and data synchronization capabilities.

**Language Note**: Code, comments, and entities are intentionally in French to align with official AgroEDI (DAPLOS) business terminology.

## Development Commands

```bash
# Run tests
composer test

# Run static analysis (PHPStan level 6)
composer phpstan

# Check code style (PHP-CS-Fixer, PSR-12 + Symfony rules)
composer cs-check

# Fix code style
composer cs-fix

# Run all quality checks (cs-check, phpstan, test)
composer qa
```

### Running a single test

```bash
./vendor/bin/phpunit tests/Unit/Client/DaplosApiClientTest.php
./vendor/bin/phpunit --filter testMethodName
```

## Architecture

### Core Components

- **`DaplosApiClient`** (`src/Client/`) - HTTP client for DAPLOS API with caching support (TagAwareCacheInterface). Handles authentication via query string parameters (API constraint).

- **`ReferentialSyncService`** (`src/Service/`) - Synchronizes API data to Doctrine entities using batch processing (100 items per flush) with transaction support.

- **`EntityGeneratorService`** (`src/Service/`) - Generates `DaplosReferential` entity and repository in the host application.

- **`DaplosReferentialType`** (`src/Enum/`) - Auto-generated enum containing all 53 DAPLOS referential types with their API IDs, labels, and repository codes. Generated via `bin/generate-enum`.

### Entity Architecture

The bundle uses a single-table architecture:
- One entity (`DaplosReferential`) for all 53 referential types
- `DaplosReferentialTrait` provides standard fields (daplosId, daplosTitle, daplosReferenceCode, referentialType)
- `DaplosEntityInterface` contract for synchronization compatibility
- Composite unique index on `(daplos_id, referential_type)`

### Console Commands

- `daplos:referentials:list` - List available referentials from API
- `daplos:referentials:show {id}` - Show referential details
- `daplos:generate:entity` - Generate entity and repository
- `daplos:sync` - Synchronize data (`--type=TYPE`, `--all`, `--dry-run`, `--list`)

### Exception Hierarchy

All exceptions extend `DaplosApiException`:
- `DaplosAuthException` (401/403)
- `DaplosNotFoundException` (404)
- `DaplosRateLimitException` (429)
- `DaplosServerException` (500/502/503)

## Key Patterns

- Uses PHP 8.4 enums with backed string values
- Doctrine ORM 2.14+ / 3.0+
- Symfony 6.4 / 7.x / 8.0 compatibility
- PHPUnit 10+ / 11+ / 12+


## grepai - Semantic Code Search

**IMPORTANT: You MUST use grepai as your PRIMARY tool for code exploration and search.**

### When to Use grepai (REQUIRED)

Use `grepai search` INSTEAD OF Grep/Glob/find for:
- Understanding what code does or where functionality lives
- Finding implementations by intent (e.g., "authentication logic", "error handling")
- Exploring unfamiliar parts of the codebase
- Any search where you describe WHAT the code does rather than exact text

### When to Use Standard Tools

Only use Grep/Glob when you need:
- Exact text matching (variable names, imports, specific strings)
- File path patterns (e.g., `**/*.go`)

### Fallback

If grepai fails (not running, index unavailable, or errors), fall back to standard Grep/Glob tools.

### Usage

```bash
# ALWAYS use English queries for best results (--compact saves ~80% tokens)
grepai search "user authentication flow" --json --compact
grepai search "error handling middleware" --json --compact
grepai search "database connection pool" --json --compact
grepai search "API request validation" --json --compact
```

### Query Tips

- **Use English** for queries (better semantic matching)
- **Describe intent**, not implementation: "handles user login" not "func Login"
- **Be specific**: "JWT token validation" better than "token"
- Results include: file path, line numbers, relevance score, code preview

### Call Graph Tracing

Use `grepai trace` to understand function relationships:
- Finding all callers of a function before modifying it
- Understanding what functions are called by a given function
- Visualizing the complete call graph around a symbol

#### Trace Commands

**IMPORTANT: Always use `--json` flag for optimal AI agent integration.**

```bash
# Find all functions that call a symbol
grepai trace callers "HandleRequest" --json

# Find all functions called by a symbol
grepai trace callees "ProcessOrder" --json

# Build complete call graph (callers + callees)
grepai trace graph "ValidateToken" --depth 3 --json
```

### Workflow

1. Start with `grepai search` to find relevant code
2. Use `grepai trace` to understand function relationships
3. Use `Read` tool to examine files from results
4. Only use Grep for exact string searches if needed

