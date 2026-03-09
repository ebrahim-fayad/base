const fs = require("fs");
const path = require("path");

const rawPath = path.resolve(__dirname, "..", "docs", "figma-raw.json");
const outPath = path.resolve(__dirname, "..", "docs", "figma-spec.json");

function walk(node, cb) {
    cb(node);
    if (node && Array.isArray(node.children)) {
        node.children.forEach((c) => walk(c, cb));
    }
}

function getText(node) {
    if (node.type === "TEXT" && typeof node.characters === "string") {
        const t = node.characters.trim();
        if (t.length > 0) return t;
    }
    return null;
}

function normalizeName(name) {
    return String(name || "")
        .trim()
        .replace(/\s+/g, " ")
        .slice(0, 120);
}

function buildSpec(raw) {
    const pages = [];
    const doc = raw.document;

    // Pages in Figma are CANVAS nodes
    (doc.children || []).forEach((canvas) => {
        if (canvas.type !== "CANVAS") return;

        const page = {
            page_id: canvas.id,
            page_name: normalizeName(canvas.name),
            frames: [],
        };

        (canvas.children || []).forEach((frame) => {
            if (
                !["FRAME", "COMPONENT", "INSTANCE", "SECTION"].includes(
                    frame.type,
                )
            )
                return;

            const f = {
                node_id: frame.id,
                name: normalizeName(frame.name),
                texts: [],
                components: [],
            };

            walk(frame, (n) => {
                const t = getText(n);
                if (t) f.texts.push(t);

                // Helpful hints from node names (often designers name inputs/buttons)
                if (n.name && ["COMPONENT", "INSTANCE"].includes(n.type)) {
                    f.components.push({
                        id: n.id,
                        name: normalizeName(n.name),
                        type: n.type,
                    });
                }
            });

            // Deduplicate
            f.texts = Array.from(new Set(f.texts)).slice(0, 300);
            f.components = f.components.slice(0, 300);

            page.frames.push(f);
        });

        // Keep pages that contain frames
        if (page.frames.length > 0) pages.push(page);
    });

    return {
        meta: {
            file_name: raw.name,
            file_key: raw.fileKey || null,
            generated_at: new Date().toISOString(),
        },
        pages,
    };
}

function main() {
    if (!fs.existsSync(rawPath)) {
        console.error("Missing docs/figma-raw.json");
        process.exit(1);
    }

    const raw = JSON.parse(fs.readFileSync(rawPath, "utf-8"));
    const spec = buildSpec(raw);

    fs.writeFileSync(outPath, JSON.stringify(spec, null, 2), "utf-8");
    console.log("✅ Built spec:", outPath);
}

main();
