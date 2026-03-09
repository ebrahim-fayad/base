const axios = require("axios");
const fs = require("fs");
const path = require("path");

// Load .env from figma-sync directory (Node does not load .env automatically)
require("dotenv").config({ path: path.join(__dirname, ".env") });

const FIGMA_TOKEN = process.env.FIGMA_TOKEN;
const FILE_ID = process.env.FIGMA_FILE_ID;


if (!FIGMA_TOKEN || !FILE_ID) {
    console.error(
        "Missing FIGMA_TOKEN or FIGMA_FILE_ID in environment variables.",
    );
    process.exit(1);
}

async function fetchFigma() {
    try {
        const response = await axios.get(
            `https://api.figma.com/v1/files/${FILE_ID}`,
            {
                headers: { "X-Figma-Token": FIGMA_TOKEN },
            },
        );

        const file = response.data;

        // OPTIONAL: save full raw figma json (useful for debugging)
        const docsDir = path.resolve(__dirname, "..", "docs");
        if (!fs.existsSync(docsDir)) fs.mkdirSync(docsDir, { recursive: true });

        const outPath = path.join(docsDir, "figma-raw.json");
        fs.writeFileSync(outPath, JSON.stringify(file, null, 2), "utf-8");

        console.log("✅ Figma raw exported to:", outPath);
    } catch (err) {
        const status = err?.response?.status;
        const data = err?.response?.data;
        console.error("❌ Figma API error:", status ?? err.message);
        if (data) console.error(JSON.stringify(data, null, 2));
        process.exit(1);
    }
}

fetchFigma();
