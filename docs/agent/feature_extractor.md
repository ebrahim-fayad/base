You are working inside my Laravel modular project.

STRICT GLOBAL RULES
====================

1) You MUST read and follow the project constitution:

   docs/agent/laravel_constitution.md

2) DO NOT implement any feature code.

Your job here is ONLY:

FEATURE PREPARATION

You will:
- analyze the FIGMA JSON
- analyze the ANALYSIS document
- split the project into FEATURES
- create a Feature Pack for each feature

No Laravel code generation is allowed in this step.


INPUT SOURCES
====================

1) FIGMA SOURCE

Path:
docs/figma-raw.json

Example:
docs/specs/figma-raw.json


2) ANALYSIS SOURCE

Path:
docs/project_analysis.pdf

Example:
docs/specs/wezna-analysis.pdf



SOURCE PRIORITY (NON-NEGOTIABLE)
================================

When extracting requirements:

1) Business rules ALWAYS come from the ANALYSIS document

2) UI fields come from FIGMA

3) If conflict exists:

   Business rules override UI

4) Each field or rule must include a SourceTag:

- BUSINESS_RULE
- UI_FIELD
- UI_ONLY
- SPEC_ONLY



IMPORTANT ADMIN PANEL RULE (NON-NEGOTIABLE)
===========================================

Admin / Dashboard / Backoffice features MUST ALSO be extracted and split into separate small features,
EVEN IF they do NOT exist in FIGMA.

This is mandatory because the admin panel may have no design file.

So:

1) Admin features must be discovered primarily from the ANALYSIS document
2) Lack of FIGMA frames MUST NOT block creating admin features
3) Admin features must be split the same way as user/mobile/web features
4) Each admin feature must have its own separate feature folder
5) For admin-only features:
   - figma_fragment.json may be empty object {} or empty array []
   - analysis_fragment.md is still mandatory
   - feature_name.md is still mandatory
6) Admin features must appear inside:
   - docs/specs/_index.md
   - docs/specs/_features_list.json
   - docs/features/{feature_folder}/
7) Admin features must be placed in the real business lifecycle order together with all other features
8) DO NOT merge all admin work into one giant feature called "admin"
9) Split admin into small isolated features such as:
   - admin_manage_users
   - admin_manage_roles
   - admin_manage_subscriptions
   - admin_manage_orders
   - admin_manage_reports
   only when supported by analysis evidence

For admin-only features, evidence may come only from ANALYSIS.
In that case, clearly mark in the index and feature pack that:
- FIGMA evidence: NONE
- Analysis evidence: REQUIRED



FEATURE EXTRACTION STRATEGY
================================

STEP A — BUILD GLOBAL INDEX

Create:

docs/specs/_index.md


This file must contain:

- Actors
- System modules
- Feature candidates

For each feature candidate include:

- feature name
- related FIGMA frames
- related analysis sections
- page numbers
- short explanation

IMPORTANT:

Every feature candidate MUST include evidence:

- figma frame name, OR "NONE" for admin-only features
- analysis section or page range

Also create a dedicated section inside docs/specs/_index.md named:

Business Execution Order

This section must list all extracted features in the real execution order of the business lifecycle.

DO NOT sort features alphabetically.

The order must reflect:
- what the user/admin must do first
- what unlocks the next step
- what logically depends on previous completion

Example:

1. Register
2. Login
3. Complete Profile
4. Home Dashboard
5. Browse Programs
6. Subscribe to Program
7. Daily Activity Tracking
8. Points & Rewards
9. Notifications
10. Settings
11. Admin Manage Users
12. Admin Manage Plans
13. Admin Reports



STEP B — BUILD FEATURE LIST JSON

Create:

docs/specs/_features_list.json


Structure:

[
  {
    "business_order": 1,
    "business_phase": "onboarding",
    "feature_slug": "",
    "feature_folder": "",
    "feature_name": "",
    "actors": [],
    "depends_on": [],
    "figma_frames": [],
    "analysis_scopes": [
      {
        "heading": "",
        "from_page": 0,
        "to_page": 0
      }
    ],
    "primary_entities_guess": [],
    "dependencies_guess": []
  }
]


Rules:

- business_order is MANDATORY
- business_order must follow the real business lifecycle, NOT alphabetical order
- business_phase is MANDATORY
- depends_on is MANDATORY and must list earlier features required before this one
- feature_slug must be snake_case
- feature_folder is MANDATORY
- feature_folder must be prefixed with the business order using zero-padded numbering:
  01_register
  02_login
  03_complete_profile
  04_home
- features must be SMALL and implementable independently
- avoid giant features
- admin features must follow the same rules
- admin features are allowed to have empty figma_frames if they are not designed in FIGMA



STEP B.1 — BUSINESS EXECUTION ORDER (MANDATORY)

You MUST order all extracted features by the real business lifecycle.

DO NOT order features alphabetically.

Order them according to:
- what the user/admin must do first
- what unlocks the next step
- what logically depends on previous completion

Examples:
- register comes before login
- login comes before complete_profile
- complete_profile comes before home
- home comes before programs browsing
- subscription comes before daily tracking
- daily tracking comes before points/rewards
- operational admin features may depend on user-created data
- admin reporting usually comes after transactional features exist

For each feature determine:

1. business_order
2. business_phase
3. depends_on

Recommended business phases:
- onboarding
- authentication
- profile_setup
- core_usage
- subscription
- activity_tracking
- nutrition_tracking
- rewards
- notifications
- settings
- admin_management
- reporting



STEP C — PRODUCE FEATURE PACKS
================================

For EACH feature in _features_list.json:

Create folder:

docs/features/{feature_folder}/

Where:
- feature_folder = zero-padded business_order + "_" + feature_slug

Examples:
- 01_register
- 02_login
- 03_complete_profile
- 04_home
- 05_programs


The folder MUST contain exactly THREE files:


1) figma_fragment.json
-----------------------

Path:

docs/features/{feature_folder}/figma_fragment.json

Extract ONLY the nodes/frames that belong to this feature.

Source:
docs/figma-raw.json

Rules:

- include only relevant frames
- keep original node ids
- keep original frame names
- keep field labels
- keep button names
- keep table columns if any
- keep statuses shown in UI if any

DO NOT modify the original structure.

This file is a fragment of the original FIGMA JSON.

For admin-only features with no FIGMA design:
- create figma_fragment.json as empty object {} or empty array []
- do NOT skip the file
- clearly note in feature_name.md that there is no FIGMA design for this feature



2) analysis_fragment.md
------------------------

Path:

docs/features/{feature_folder}/analysis_fragment.md

Extract ONLY relevant parts of the analysis document.

Source:
{ANALYSIS_FILE_PATH}

Rules:

- preserve section headings
- include page references
- include business rules
- include formulas
- include constraints
- include status transitions
- include edge cases
- include only the feature-relevant content

Example format:

### Section: User Registration (pages 12–15)

Extracted text...



3) feature_name.md (COPY + FILL)
---------------------------------

This file MUST be created by COPYING the template:

SOURCE TEMPLATE:

docs/agent/feature_name.md


Destination:

docs/features/{feature_folder}/feature_name.md


After copying the template:

You MUST FILL the placeholders using information from:

- docs/features/{feature_folder}/figma_fragment.json
- docs/features/{feature_folder}/analysis_fragment.md


Fill sections such as:

- MODULE CONFIG
- REQUIREMENTS
- Actors
- UI SOURCE
- BUSINESS SOURCE
- Business Flow
- Entities / Tables
- Enums
- API Endpoints
- Admin Screens
- Validation Rules
- Business Rules
- Edge Cases


IMPORTANT RULES:

- If a value is unknown:
  - DO NOT invent
  - write TODO
  - add it to the section:
    NOTES (MISMATCHES / QUESTIONS)

- The copied template must remain structurally intact
- Replace ambiguous placeholders with extracted values whenever evidence exists
- Keep sections that are still not fully known, but mark them clearly as TODO
- For admin-only features, fill UI SOURCE as:
  - FIGMA: NONE
  - Source basis: ANALYSIS ONLY



FIELD EXTRACTION RULES
======================

Fields can come from:

1) FIGMA UI
2) ANALYSIS document

If a field exists in FIGMA but not in analysis:

- include it
- tag it as UI_ONLY

If a rule exists in analysis but is not visible in UI:

- include it
- tag it as BUSINESS_RULE

If a field is clearly visible in UI and supported by analysis:

- tag it as UI_FIELD

If analysis requires a field not shown in UI:

- include it
- tag it as SPEC_ONLY

If the feature is admin-only and comes only from analysis:

- fields/rules may be extracted without FIGMA
- tag based on analysis evidence only



TYPE INFERENCE RULE
===================

If FIGMA does not provide field types:

Infer types using:

- label
- placeholder
- analysis hints
- common backend patterns

Examples:

- phone -> string
- price -> decimal
- date -> datetime
- image -> file/string depending on context
- is_active -> boolean
- points -> integer



FEATURE IDENTIFICATION RULE
===========================

A feature must be defined when:

1) a distinct UI frame exists
AND
2) a distinct business workflow exists

OR

1) a distinct business workflow exists in ANALYSIS
AND
2) it can be implemented independently later
AND
3) it represents a separate admin/backoffice/business capability even without FIGMA

Examples:

- Login screen -> auth feature
- Programs list -> programs feature
- Activity tracking -> activities feature
- Calories screen -> calories feature
- Admin manage subscriptions -> admin feature even if no FIGMA exists
- Admin reports -> reporting feature even if no FIGMA exists

If a flow is too large:
- split it into smaller independent features



BUSINESS ORDER RESOLUTION RULE
==============================

If two features are both valid, always place first:

1) the feature that is required to access the other
2) the feature that appears earlier in the business journey
3) the feature that unlocks data or actions needed by the next feature

Example:
- home screen may visually exist in FIGMA
- but if business flow requires login first
- then login MUST come before home in business_order

NEVER use alphabetical order as business order.



QUALITY GATES
======================

- DO NOT invent entities without evidence
- DO NOT invent business rules
- DO NOT merge unrelated flows into one feature
- Prefer multiple small features over large ones
- Keep all extracted outputs traceable to FIGMA or ANALYSIS
- Every feature must be implementable in isolation later
- Admin panel features must also be traceable to ANALYSIS even if FIGMA is missing
- Missing FIGMA is NOT a reason to skip admin features



IMPORTANT OUTPUT RULES
======================

For each feature create ONLY:

docs/features/{feature_folder}/

    figma_fragment.json
    analysis_fragment.md
    feature_name.md


DO NOT create:

- repeated_command.md

I will execute the repeated command manually and set the feature name myself.



FINAL OUTPUT CHECKLIST
======================

You MUST produce:

1) docs/specs/_index.md

2) docs/specs/_features_list.json


And for each feature:

docs/features/{feature_folder}/

    figma_fragment.json
    analysis_fragment.md
    feature_name.md


Where feature folders MUST be ordered by business lifecycle, not alphabetically.

This includes:
- user-facing features
- mobile/web features
- admin/dashboard/backoffice features, even if they do not exist in FIGMA
