# Laravel Project Constitution

This document contains the non-negotiable architecture rules of this project.

The AI agent MUST strictly follow these rules when generating any code.

ROLE
You are a Senior Laravel Architect & Implementer.

GOAL
Implement a feature in a Laravel 12 project that has BOTH:

- API
- Admin Dashboard (Blade)

HARD CONSTRAINTS (DO NOT VIOLATE)

- Do NOT modify existing permission system (manual) or SideBarTrait logic.
- Do NOT “learn” rules from current Requests/Controllers (they contain incorrect patterns). Ignore them unless explicitly instructed.
- Respect existing project response format + admin routing + admin base controller patterns.

SOURCE PRIORITY

1. Business rules -> from Analysis document
2. UI fields -> from Figma JSON
3. If conflict exists:
    - Business rules override UI
    - UI fields are used for completeness

UI SOURCE RULE

UI definitions come from Figma JSON.

The agent must:

- parse frames
- identify inputs
- infer request fields
- infer table columns
- infer filters

These fields must be used to generate:

- migrations
- requests
- resources
- openapi schemas

GEOGRAPHIC LOCATION / ADDRESS FIELD MAPPING RULE (MANDATORY)

When the UI (Figma) or analysis mentions "موقع جغرافي" (geographic location) or "العنوان" (address), the agent MUST implement exactly three attributes—not city_id or country_id:

- **map_desc** (string): text description of the location/address
- **lat** (decimal): latitude
- **lng** (decimal): longitude

Use map_desc, lat, and lng in migrations, DTOs, requests, resources, and OpenAPI. Do NOT use city_id or country_id to represent geographic location or address.

PROJECT-SPECIFIC RULES (from codebase)

1. Unified API Response (STRICT)

- API responses MUST use: App\Traits\ResponseTrait::jsonResponse()
- Keep response shape exactly as-is: key, msg, code, response_status, data
- Do NOT return raw response()->json() directly for API.
- Do NOT create custom helper responses outside ResponseTrait for API.
- Do NOT bypass ResponseTrait in controllers, services, actions, handlers, or exceptions where the feature response is being returned.
- The required response helper name is exactly:
  ResponseTrait::jsonResponse()

    1.1 Response Trait Enforcement Rule (MANDATORY)

- The API layer is considered invalid if it returns:
    - response()->json(...)
    - JsonResponse::create(...)
    - custom array responses
    - any response helper other than ResponseTrait::jsonResponse()
- Success, fail, blocked, validation, special-case, and business-case responses must all be aligned with the project response trait behavior.
- OpenAPI examples MUST mirror this exact response format.

    1.2 OpenAPI Response Schema Contract (MANDATORY)

- All OpenAPI / Swagger responses MUST follow the same unified response structure used in the Login endpoint.
- Do NOT use description-only responses in OpenAPI.
- Every response must define a full JSON schema, not only a textual description.

The default API response schema must always include:

{
"key": "string",
"msg": "string",
"code": 200,
"response_status": {
"error": false,
"validation_errors": null
},
"data": {}
}

- Success, validation, fail, blocked, and special-case responses must preserve the same top-level shape whenever the backend actually returns that shape.
- When generating docs/openapi.json or docs/features/{feature_folder}/openapi.json:
    - Prefer reusable schemas under components/schemas
    - Reuse the same base response structure across all endpoints
    - Login response is the reference implementation and source of truth for OpenAPI response formatting
- Forgot password, reset password, OTP, login, profile, and similar endpoints MUST NOT use loose description-only responses.
- Postman import compatibility is mandatory, so response schemas must be explicit and complete.

    1.3 OpenAPI Response Example Formatting Rule (MANDATORY)

Every generated response example must follow the explicit schema style below:

- top-level object
- key
- msg
- code
- response_status
- data

Use endpoint-specific examples, but preserve the same structure.

Example success response:

"responses": {
"200": {
"description": "Success",
"content": {
"application/json": {
"schema": {
"type": "object",
"properties": {
"key": { "type": "string", "example": "success" },
"msg": { "type": "string", "example": "تم التنفيذ بنجاح" },
"code": { "type": "integer", "example": 200 },
"response_status": {
"type": "object",
"properties": {
"error": { "type": "boolean", "example": false },
"validation_errors": { "type": "object", "nullable": true }
}
},
"data": {
"type": "object",
"properties": {}
}
}
}
}
}
}
}

Example validation response:

"422": {
"description": "Validation error",
"content": {
"application/json": {
"schema": {
"type": "object",
"properties": {
"key": { "type": "string", "example": "fail" },
"msg": { "type": "string" },
"code": { "type": "integer", "example": 422 },
"response_status": {
"type": "object",
"properties": {
"error": { "type": "boolean", "example": true },
"validation_errors": { "type": "object" }
}
},
"data": {
"nullable": true
}
}
}
}
}
}

2. Admin Dashboard CRUD Contract

- Admin CRUD follows AdminBasicController contract:
    - index(): if AJAX -> return JSON containing rendered HTML from: admin.{directory}.table + modelCount
    - index(): non-AJAX -> render index view with filter/buttons and:
        <div class="table_content_append"></div>
    - index page uses admin.shared.filter_js to fetch table via AJAX
    - store/update return JSON { url } redirecting to index
    - destroy/destroyAll return JSON { key, msg }

3. Blade Structure (per module)

- resources/views/admin/{directory}/
    - index.blade.php, table.blade.php
    - create/edit/show (only if needed)

- index uses:
    - <x-admin.buttons ...>
    - <x-admin.filter ...>

- shared scripts:
    - admin.shared.deleteAll
    - admin.shared.deleteOne
    - admin.shared.filter_js (needs index_route)

4. Admin Routes Distribution + Sidebar metadata

- routes/web.php includes routes/Admin/\*.php
- Each admin module has:
  A) routes/Admin/{module}.php (sidebar parent metadata route)
  B) routes/Admin/{Module}/routes-links.php (actual routes)
- Route definitions are array-style and must include: 'uses', 'as', 'title'
- sidebar children routes must have: sub_link => true
- Parent sidebar route must include: type='parent', title, has_sub_route, child[] (and icon if used)

ADMIN CONTROLLERS RULE (MANDATORY)

- Admin modules must integrate with AdminBasicController contract (constructor config + directoryName + serviceName).
- Do NOT implement a custom admin CRUD flow unless explicitly required in REQUIREMENTS.

ARCHITECTURE RULES (GENERAL)

1. Controllers must be thin

- API:
  FormRequest -> DTO -> Service -> Resource -> ResponseTrait::jsonResponse()
- Admin:
  FormRequest -> DTO -> Service -> AdminBasicController contract responses

2. Business logic only in Services

3. Use DTOs for all Service inputs

- never pass Request arrays directly to services

    3.2 FORM REQUEST RULE (MANDATORY)

Form Request classes MUST contain ONLY validation rules for input data.

Form Request MUST NOT:
- Perform any DB queries (e.g. User::where, Model::query, Model::find)
- Use prepareForValidation to fetch models or merge query results
- Use withValidator to add business-condition errors (e.g. is_blocked, user exists)
- Use Rule::exists/unique with closures that query the DB for business logic

All existence checks, blocked checks, business conditions, and similar logic MUST go in the Service layer (via Repository).

Form Request MAY:
- Validate input format, required fields, ranges, types
- Use Rule::exists for foreign keys (e.g. Rule::exists('countries', 'id'))
- Use Rule::unique for uniqueness (e.g. Rule::unique('users', 'email')->ignore($id))
- Use prepareForValidation only for input normalization (e.g. fixPhone, trim, merge default values)

    3.1 DTO CLASS STRUCTURE RULE (MANDATORY)

Every DTO class MUST follow this structure:

- Declare the class as **readonly**.
- All data are **constructor parameters** as promoted properties (public).
- Provide a **static method** `fromRequest(FormRequestClass $request): self` that:
  - Accepts the corresponding FormRequest (e.g. StoreContractRequest).
  - Returns `new self(...)` with every constructor argument supplied from `$request->validated()` (or validated keys).
- Do not add other static factories unless required; keep a single, consistent `fromRequest` for request-backed DTOs.

Example (pattern to follow):

```php
<?php

namespace App\DTOs;

use App\Http\Requests\StoreContractRequest;

readonly class CreateContractDTO
{
    public function __construct(
        public int $attr1,
        public float $attr2,
        public string $attr3,
    ) {}

    public static function fromRequest(StoreContractRequest $request): self
    {
        return new self(
            attr1: $request->validated()['attr1'],
            attr2: $request->validated()['attr2'],
            attr3: $request->validated()['attr3'],
        );
    }
}
```

- Controllers MUST create DTOs via `SomeDTO::fromRequest($request)` and pass the DTO to the service (do not build DTOs manually in the controller with `new SomeDTO(...)` when a FormRequest is available).
- For DTOs that are not built from a single FormRequest (e.g. built from multiple inputs or from repository results), use the constructor only; `fromRequest` is mandatory when the DTO is the direct image of a FormRequest.

4. Use Repository Pattern for ALL data access (MANDATORY)

- Services must not contain Eloquent queries.
- Controllers must not contain Eloquent queries.
- Resources must not trigger lazy loading.
- All reads/writes/existence checks/filtering must go through repositories.

    4.1 Repository Pattern is MANDATORY for ALL features and ALL endpoints

- Repository Pattern is NOT optional.
- Even simple endpoints such as login, forgot password, reset password, profile, OTP, settings, and similar flows MUST use repositories.
- Services must never access Eloquent models directly for querying, filtering, existence checks, or persistence logic.
- All data access must go through repository interfaces and repository implementations.
- If a feature seems small, still create the repository layer.
- No “service-only” shortcut is allowed unless explicitly stated in REQUIREMENTS.

    4.2 Repository Boundary Rule (STRICT)

- Services must NEVER call:
    - Model::query()
    - Model::where()
    - Model::find()
    - Model::create()
    - Model::update()
    - Model::delete()
    - or any direct Eloquent builder inside service/controller
- If Eloquent usage is detected inside Service or Controller, the agent must refactor it into the repository layer.

    4.3 Repository Deliverables Rule (MANDATORY)

Every implemented feature that touches persistence MUST produce:

- repository contract
- repository implementation
- service consuming the contract
- controller consuming the service

A feature is incomplete if repository layer is skipped.

5. Use API Resources for API output

5.1 Resource Loading Rule

- API Resources must never trigger lazy loading.
- All relations required by resources must be eager loaded inside repositories.
- Resources must only read relations that are already loaded.
- Optional relations must be accessed using whenLoaded().

6. Use Strategy Pattern when behavior differs by type/status/provider/gateway/etc.

7. Use Factory to resolve correct Strategy/Handler by enum/type when needed.

8. Use DB::transaction() in Service when multiple writes must be atomic.

9. Use Enums for status/type when appropriate.

10. Add indexes/unique constraints (idempotency & integrity).

SOLID RULES (MANDATORY)

The generated code MUST comply with SOLID:

- Single Responsibility Principle:
  each class has one reason to change
- Open/Closed Principle:
  prefer extension over modification
- Liskov Substitution Principle:
  implementations must respect contracts
- Interface Segregation Principle:
  keep interfaces focused and cohesive
- Dependency Inversion Principle:
  depend on interfaces/contracts, not concretions

Violations such as:

- fat controllers
- fat repositories with mixed responsibilities
- services doing transport formatting
- controllers doing query work
- repositories doing UI logic
  are NOT allowed.

QUERY PERFORMANCE RULES (MANDATORY)

- Avoid N+1 queries in all API and Admin flows.
- Always eager load required relations using with(), load(), or repository-level query optimization when returning relational data.
- Never loop over models and trigger lazy-loaded relations inside Resources, Services, Controllers, or Blade views.
- Repositories must be responsible for relation loading strategy.

Pagination rules

- All list endpoints must use pagination unless explicitly specified otherwise.
- Pagination must use the project PaginationTrait.
- The paginated response data structure must follow this format:

data:

- a key named after the plural form of the model (example: users, orders, settlements)
- a key named pagination

Example:
data:

- users -> resource collection
- pagination -> result of PaginationTrait pagination function

The pagination metadata must be generated using the PaginationTrait helper method.

CODING STANDARDS

- PHP 8.2+ typed properties + return types everywhere.
- Import classes via use.
- Keep DocBlocks English-only.
- No duplicate logic between API and Admin: both call the same Service methods.
- Add proper indexes + unique constraints.

EXPECTED OUTPUT (ALWAYS PRODUCE)

A) DB:

- migrations (safe + indexes/unique)

B) Domain:

- enums (if any)
- DTOs
- repo contracts + implementations
- services
- strategy/factory (when needed)

C) API:

- requests
- resources
- controllers
- routes

D) Admin:

- routes (parent + routes-links)
- controller using AdminBasicController contract
- blades (index/table/...)

E) i18n:

- admin.php
- apis.php
- enums.php
- validation.php attributes

F) Data & Tests:

- factories
- seeders
- feature tests

IMPLEMENTATION WORKFLOW (MANDATORY)

Step 0) Summarize:

- Entities/Tables/Enums
- API endpoints
- Admin screens
- tests list
- seeders/factories list
- translation keys list

Step 1) Provide a concise implementation plan.

Step 2) Implement code in this exact order:

1. migrations
2. enums (if any) + update lang/{locale}/enums.php
3. DTOs
4. repository contracts
5. repository eloquent implementations
6. services
7. factories
8. seeders
9. api requests + add validation attributes
10. api resources (EnumRetriever for enums)
11. api controllers (ResponseTrait::jsonResponse)
12. api routes
13. admin routes (parent + routes-links)
14. admin controllers (AdminBasicController contract)
15. admin blades (index/table/...)
16. admin/apis translation keys + enums keys + validation attributes
17. feature tests (API + Admin)
18. final checklist + how to run tests/seeders

DOCUMENTATION RULES (MANDATORY)

feature_folder = current feature folder under docs/features (example: 01_register, 02_login, auth_otp if manually created)
feature_slug = snake_case feature name (example: followers, insurance_orders, settlements)

For every implemented feature, the agent MUST generate documentation artifacts under /docs as follows:

A) Per-Feature Docs (2 files)

1. Feature README (Markdown)

- Path: docs/features/{feature_folder}/README.md

Content:

- Overview (business goal)
- Actors
- Data model (tables/columns/relations)
- Flows (API + Admin if exists)
- Inputs/Outputs
- Rules/Edge cases
- Permissions note: "Permissions are manual; not handled here."
- How to test (seed + test commands)

2. Per-Feature API Spec (OpenAPI JSON OR Swagger YAML)

- Path:
    - JSON: docs/features/{feature_folder}/openapi.json
    - OR YAML: docs/features/{feature_folder}/openapi.yaml

Must include:

- All endpoints of the feature (method + path)
- Tags: feature name
- Summary + description
- Parameters + RequestBody schemas

For each field:

- description MUST mirror the FormRequest validation rules
- if the field is a foreign key (example category_id):
  description must include:
  Get from endpoint: {METHOD} {PATH} ({name})

Responses must include:

- 200
- 201
- 422
- 401
- 403
- and any real business-specific status codes returned by the endpoint

Security:

- Bearer if endpoint requires auth

All response schemas MUST follow the unified API response contract defined in this constitution.
Do NOT use description-only response definitions.
Prefer reusable OpenAPI schemas.

B) Project-Level Docs

docs/README.md
Must contain:

- list of all features
- links to feature README files

Master OpenAPI spec:
docs/openapi.json

Must be importable in:

- Postman
- Swagger
- OpenAPI tools

C) Source of truth for validation descriptions

Descriptions must come from FormRequest validation rules.

If enum:

- include allowed values
- include EnumRetriever label source

If exists rule:

- must say "must exist in table.column"

D) Output requirement
The agent MUST actually create/update these files in the repository.

QUALITY GATE (MANDATORY)

A generated feature is considered incomplete if:

- it skips repository layer
- it introduces direct Eloquent access in service/controller
- it introduces N+1 query risks
- it introduces lazy loading inside API resources
- it generates OpenAPI responses without explicit schemas
- it returns API responses without ResponseTrait::jsonResponse()
- it violates SOLID boundaries between layers
