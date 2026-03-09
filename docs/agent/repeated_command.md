Read and strictly follow:

- docs/agent/laravel_constitution.md

Implement the feature described in:

- docs/features/{FEATURE_FOLDER}/feature_name.md

Also read the full feature pack before implementation:

- docs/features/{FEATURE_FOLDER}/figma_fragment.json
- docs/features/{FEATURE_FOLDER}/analysis_fragment.md

Important rules:

- Do not modify permissions system
- Do not learn patterns from existing Requests or Controllers
- Follow AdminBasicController contract

SOURCE PRIORITY

1. Business rules -> from Analysis document / analysis_fragment.md
2. UI fields -> from Figma JSON / figma_fragment.json
3. If conflict exists:
    - Business rules override UI
    - UI fields are used for completeness

ARCHITECTURE RULES (MANDATORY)

- Controllers must be thin
- Use DTOs for service inputs
- Business logic belongs only in Services
- ALL data access MUST go through Repository Pattern
- Controllers must not use Eloquent directly
- Services must not use Eloquent directly
- Resources must not trigger lazy loading
- Required relations must be eager loaded inside repositories
- Multi-step writes must use DB::transaction() where needed
- Code must comply with SOLID

REPOSITORY RULE (STRICT)

Repository Pattern is mandatory for this feature even if the flow is simple.

You MUST create and use:

- repository contract
- repository implementation
- service consuming the repository
- controller consuming the service

Do NOT use service-only shortcut.

Do NOT place queries in:

- controllers
- services
- resources
- Form Requests

FORM REQUEST RULE (MANDATORY)

Form Request = validation ONLY. No DB queries, no User::where, no withValidator business checks (blocked, user exists). All such logic goes in Service via Repository.

UNIFIED RESPONSE RULE (STRICT)

All API responses MUST use:

App\Traits\ResponseTrait::jsonResponse()

Do NOT use:

- response()->json(...)
- raw arrays as API responses
- custom response shape outside the response trait

OpenAPI responses MUST follow the same unified response shape.

OPENAPI RESPONSE FORMAT RULE (MANDATORY)

When generating:

- docs/features/{FEATURE_FOLDER}/openapi.json
- docs/openapi.json

All responses must:

- use explicit schemas
- follow the same top-level structure:
  key, msg, code, response_status, data
- avoid description-only responses
- be Postman-import compatible

Use the project Login response style as the formatting reference.

DELIVERABLES MUST INCLUDE

- Feature code (API + Admin where required)
- Tests + Factory + Seeder
- Docs (MANDATORY for every feature):
    - docs/features/{FEATURE_FOLDER}/README.md
    - docs/features/{FEATURE_FOLDER}/openapi.json
    - Update docs/README.md
    - Update docs/openapi.json (project master OpenAPI — MUST be created/updated, same as per-feature README)

IMPLEMENTATION ORDER (MANDATORY)

1. migrations
2. enums (if any) + update lang/{locale}/enums.php
3. DTOs
4. repository contracts
5. repository eloquent implementations
6. services
7. factories
8. seeders
9. api requests + validation attributes
10. api resources
11. api controllers using ResponseTrait::jsonResponse()
12. api routes
13. admin routes
14. admin controllers
15. admin blades
16. translation keys
17. feature tests
18. final checklist

QUALITY GATE (MANDATORY)

Do NOT consider the feature complete if:

- repository layer is missing
- Eloquent is used directly in service/controller
- API response bypasses ResponseTrait::jsonResponse()
- OpenAPI responses are not explicit schemas
- SOLID is violated
- resource causes lazy loading
