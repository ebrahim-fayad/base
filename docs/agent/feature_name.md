========================
MODULE CONFIG (CHANGE THIS EACH TIME)
========================
DomainName: {DOMAIN_NAME} (e.g., Followers, Settlements)
FeatureSlug: {FEATURE_SLUG} (snake_case, e.g., followers, auth_otp, insurance_orders)
FeatureFolder: {FEATURE_FOLDER} (e.g., 01_register, 02_login, 07_auth_otp)
AdminDirectoryName: {ADMIN_DIRECTORY} (e.g., followers, settlements)
ModelClass: {MODEL_FQCN} (e.g., App\Models\Follower)
ServiceClass: {SERVICE_FQCN} (e.g., App\Services\Followers\FollowerService)
RepositoryContract: {REPO_CONTRACT_FQCN} (e.g., App\Repositories\Followers\Contracts\FollowerRepositoryInterface)
RepositoryEloquent: {REPO_ELOQUENT_FQCN} (e.g., App\Repositories\Followers\Eloquent\FollowerRepository)
Policy/Permissions: MANUAL (DO NOT CHANGE)

Routes:
AdminSidebarParentUri: {PARENT_URI} (e.g., 'followers-management')
AdminIndexUri: {INDEX_URI} (e.g., 'followers')
ApiPrefix: {API_PREFIX} (usually 'api')

Locales:

- SupportedLocales: {LOCALES} (e.g., ['ar','en'] or ['ar'])

Documentation Outputs (MANDATORY):

- Per-feature docs folder:
  docs/features/{FEATURE_FOLDER}/README.md
  docs/features/{FEATURE_FOLDER}/openapi.json
- Project docs (update on every feature):
  docs/README.md
  docs/openapi.json

========================
REQUIREMENTS (CHANGE THIS EACH TIME)
========================
Feature Name: {FEATURE_NAME}

Actors:

- {ACTOR_1}
- {ACTOR_2}

Business Order:

- {BUSINESS_ORDER}

Business Phase:

- {BUSINESS_PHASE}

Depends On:

- {DEPENDENCY_1}
- {DEPENDENCY_2}

========================
SOURCES (MANDATORY)
========================

SOURCE PRIORITY (NON-NEGOTIABLE):

1. Business rules & constraints -> from ANALYSIS SOURCE
2. UI fields & screen flows -> from FIGMA SOURCE
3. If conflict exists:
    - Business rules override UI
    - UI fields are used for completeness checking
4. Every important field/rule must have a SourceTag:
    - BUSINESS_RULE | UI_FIELD | UI_ONLY | SPEC_ONLY

---

## UI SOURCE (FIGMA) ✅ (API/MOBILE ONLY)

figma_source_file: {FIGMA_JSON_FILE_PATH} (e.g., docs/specs/figma-spec.json)

figma_fragment_file:

- docs/features/{FEATURE_FOLDER}/figma_fragment.json

frames_used_for_this_feature:

- {FRAME_NAME_1}
- {FRAME_NAME_2}
- (add as many as needed)

Agent instructions for FIGMA parsing:

- Extract: form inputs, required/optional hints, field labels, placeholders, buttons/actions, table columns, filters, statuses if shown, and expected response attributes needed by mobile.
- If Figma does NOT provide types -> infer types using:
  label/placeholder + typical patterns + ANALYSIS SOURCE.
- If UI shows a field not mentioned in this file -> include it and tag as UI_ONLY, and highlight in Notes.
- UI-derived response attributes MUST be reflected later inside API Resources and OpenAPI examples.
- **GEOGRAPHIC LOCATION / ADDRESS MAPPING:** If the UI or analysis mentions "موقع جغرافي" (geographic location) or "العنوان" (address), map them to exactly three attributes: **map_desc**, **lat**, and **lng**. Do NOT use city_id or country_id for this concept; use map_desc (text description), lat (latitude), lng (longitude).

---

## BUSINESS SOURCE (ANALYSIS / SPEC) ✅

analysis_source_file: {ANALYSIS_FILE_PATH} (e.g., docs/specs/analysis.pdf)

analysis_fragment_file:

- docs/features/{FEATURE_FOLDER}/analysis_fragment.md

analysis_scope_for_this_feature:

- {SECTION_OR_HEADING} (pages: {FROM}-{TO})
- (add as many as needed)

Agent instructions for ANALYSIS parsing:

- Extract: business rules, statuses, transitions, constraints, edge cases, permissions notes (but do NOT implement permissions system), and calculations/formulas.
- Convert narrative into implementable rules & validations.
- **Location/Address in spec:** If the analysis or UI refers to "موقع جغرافي" or "العنوان", use **map_desc**, **lat**, **lng** (not city_id / country_id).

========================
GEOGRAPHIC LOCATION AND ADDRESS MAPPING RULE (MANDATORY)
========================
When the UI (FIGMA) or the analysis document mentions:

- "موقع جغرافي" (geographic location)
- "العنوان" (address)

The feature MUST use exactly three attributes:

- **map_desc** (string): text description of the location/address
- **lat** (latitude): decimal
- **lng** (longitude): decimal

Do NOT map these concepts to city_id or country_id. Use map_desc, lat, and lng in migrations, requests, resources, and OpenAPI.

========================
FEATURE IDENTIFICATION RULE (IMPORTANT)
========================
This feature must be definable by:

- a distinct UI flow/frame group from FIGMA
  AND
- a distinct business workflow/ruleset from ANALYSIS

If this feature overlaps with another feature:

- Define clear boundaries (in/out of scope)
- List dependencies & referenced endpoints.

========================
ARCHITECTURE RULES FOR THIS FEATURE (MANDATORY)
========================
The implementation of this feature MUST follow this exact layering:

Controller -> FormRequest -> DTO -> Service -> Repository -> Model
Controller -> Resource -> ResponseTrait::jsonResponse()

Mandatory rules:

- Controllers must stay thin.
- Services contain business logic only.
- Repositories contain ALL data access logic.
- Controllers MUST NOT use Eloquent directly.
- Services MUST NOT use Eloquent directly.
- Resources MUST NOT trigger lazy loading.
- Required relations MUST be eager loaded inside repositories.
- DTOs are mandatory for service inputs.
- Strategy/Factory must be used when behavior differs by type/status/provider/gateway/etc.
- Multi-step writes must use DB::transaction() inside Service.

DTO CLASS STRUCTURE RULE (MANDATORY):

Every DTO that is built from a FormRequest MUST:

1. Be a **readonly** class.
2. Define **all** attributes as promoted properties in the **constructor** (public).
3. Expose a **static** method: `fromRequest(FormRequestClass $request): self` that returns `new self(...)` with every constructor argument mapped from `$request->validated()` (same order and names as the constructor).
4. Controllers MUST use `SomeDTO::fromRequest($request)` to create the DTO and pass it to the service; do not instantiate with `new SomeDTO(...)` in the controller when a FormRequest exists.

Example:

```php
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

SOLID RULES (MANDATORY):

- S: Each class must have one responsibility.
- O: Prefer extension over modification.
- L: Child implementations must respect parent/interface contracts.
- I: Keep interfaces focused and not bloated.
- D: Depend on abstractions (contracts/interfaces), not concretions.

Repository Pattern Rule:

- Repository Pattern is MANDATORY for this feature even if the feature is simple.
- No service-only shortcut is allowed.
- All reads/writes/filtering/existence checks must go through repositories.

========================
UNIFIED API RESPONSE RULE (MANDATORY)
========================
All API responses MUST use:

App\Traits\ResponseTrait::jsonResponse()

Strict rules:

- Do NOT return raw response()->json().
- Do NOT create custom response structure.
- Do NOT bypass ResponseTrait for success, fail, validation, blocked, special, or edge-case responses.
- The top-level API response shape must always follow the project contract when the backend returns that shape:

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

All endpoint examples inside OpenAPI MUST reflect this same response contract.

========================
BUSINESS FLOW (FROM FIGMA + ANALYSIS)
========================
Describe the flow steps briefly:

1. ...
2. ...
3. ...

Include:

- Entry points (screen/API)
- Exit states (success/failure)
- Any calculations (from analysis)

========================
ENTITIES / TABLES
========================
List all entities used by this feature (new or existing).

- Table: {TABLE_NAME}
  Purpose:
  Columns:
    - {column}: {type} | required/optional | sourceTag
      Indexes/Unique:
    - ...
      Relationships:
    - ...

Notes:

- If a column exists in UI but not in analysis -> tag UI_ONLY.
- If analysis requires a field not in UI -> tag SPEC_ONLY.

========================
ENUMS (IF ANY)
========================

- EnumClass: {ENUM_CLASSNAME}
  Cases: {CASE1, CASE2, ...}

Enum i18n rule (PROJECT):

- Add/Update keys in: lang/{locale}/enums.php
- Structure:
  '{EnumClassKey}' => [
  '{CASE}' => 'Label',
  ]
- {EnumClassKey} must match existing enums.php convention in this project.

========================
API ENDPOINTS
========================
For each endpoint:

- [METHOD] /api/{...}
  Auth: yes/no
  Purpose:
  Request:
    - field: type | required/optional | validation summary | sourceTag
      Response:
    - MUST use Resource + jsonResponse
    - Response attributes must be consistent with UI needs (from Figma)
    - Response top-level structure MUST match ResponseTrait contract
      Messages Keys (apis.php):
    - apis.{domain}.created
    - apis.{domain}.updated
    - apis.{domain}.deleted
    - (add only what is needed)

Notes:

- If a response field is required by UI, it MUST appear in Resource output.
- If a relation is used in Resource, it MUST be eager loaded inside Repository.

========================
OPENAPI RESPONSE FORMAT RULE (MANDATORY)
========================
All OpenAPI responses for this feature and the project master spec MUST use explicit JSON schemas.

Do NOT use description-only responses.

The response examples must follow the same structure as the unified API response contract.

Use the Login response style as the formatting reference.

Preferred practice:

- Create reusable schemas under components/schemas
- Reuse a base response shape
- Keep endpoint-specific data under data.properties

Example success response shape:

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

Validation example shape:

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

========================
ADMIN SCREENS (DERIVED / BEST PRACTICE)
========================
Admin UI is NOT provided.
Derive screens based on entities + business needs + filtering.

- Index (AJAX):
  Columns:
    - ...
      Filters:
    - ...
      Actions:
    - view/create/edit/delete/multi delete/(approve/reject if needed)
      Messages Keys (admin.php):
    - admin.{domain}.created
    - admin.{domain}.updated
    - admin.{domain}.deleted
    - admin.{domain}.bulk_deleted

- Create/Edit/Show (if any):
  Fields/Sections:
    - ...

========================
FORM REQUEST RULE (MANDATORY)
========================
Form Request MUST contain ONLY validation rules for input data.

Form Request MUST NOT:
- Perform DB queries (User::where, Model::query)
- Use prepareForValidation to fetch/merge models
- Use withValidator for business checks (is_blocked, user exists)

All such logic goes in Service via Repository.

========================
VALIDATION RULES
========================
List validation rules per request.

Validation Attributes Keys (validation.php -> attributes) (MANDATORY):

- field_name => "Human label"

Each rule must be derived from:

- UI hints (required/format)
- ANALYSIS constraints (ranges, requiredness, business rules)

========================
BUSINESS RULES
========================

- ...
  Include:
- Calculations / formulas
- status transitions
- points/rewards logic
- non-functional constraints if relevant

========================
EDGE CASES
========================

- ...

========================
FACTORY & SEEDER NEEDS
========================

- Factory for: ...
- Seeder for: ...

========================
FEATURE TESTS (MINIMUM MATRIX)
========================

- API tests:
    - index success
    - store success
    - update success
    - delete success
    - validation failure (422)
    - unauthorized / forbidden when applicable

- Admin tests:
    - index AJAX table success
    - store success
    - update success
    - delete success
    - multi delete success

========================
DOCUMENTATION OUTPUT RULE
========================
This feature MUST generate/update:

- docs/features/{FEATURE_FOLDER}/README.md
- docs/features/{FEATURE_FOLDER}/openapi.json
- docs/README.md
- docs/openapi.json

The per-feature OpenAPI and master OpenAPI MUST:

- be importable into Postman
- use explicit schemas
- preserve unified API response structure
- avoid description-only responses

========================
NOTES (MISMATCHES / QUESTIONS)
========================

- List any mismatches between UI and ANALYSIS here with SourceTags.
- Ask for confirmation ONLY when mismatch blocks implementation.
- Unknown values must be marked as TODO instead of being invented.
