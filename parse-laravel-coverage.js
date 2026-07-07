const fs = require('fs');
const path = require('path');
const xml2js = require('xml2js');

async function parseCoverage() {
    try {
        if (!fs.existsSync('coverage.xml')) {
            console.error('File coverage.xml tidak ditemukan!');
            fs.appendFileSync(
                process.env.GITHUB_STEP_SUMMARY || 'summary.md',
                '### ⚠️ Test Coverage Summary\n\nFile `coverage.xml` tidak ditemukan.'
            );
            return;
        }

        const xmlData = fs.readFileSync('coverage.xml', 'utf8');
        const parser = new xml2js.Parser();
        const result = await parser.parseStringPromise(xmlData);

        const files = [];

        function traverse(obj) {
            if (!obj) return;
            if (Array.isArray(obj)) {
                obj.forEach(traverse);
                return;
            }
            if (typeof obj === 'object') {
                if (obj.file) {
                    if (Array.isArray(obj.file)) {
                        files.push(...obj.file);
                    } else {
                        files.push(obj.file);
                    }
                }
                for (const key in obj) {
                    if (key !== 'file') {
                        traverse(obj[key]);
                    }
                }
            }
        }

        traverse(result);

        let grandTotalStatements = 0;
        let grandCoveredStatements = 0;
        let grandTotalBranches = 0;
        let grandCoveredBranches = 0;
        let grandTotalFunctions = 0;
        let grandCoveredFunctions = 0;
        let grandTotalLines = 0;
        let grandCoveredLines = 0;

        const tableRows = [];

        files.forEach(f => {
            const filePath = f.$.name || '';
            const relativePath = filePath.includes('inventory-app') 
                ? filePath.substring(filePath.indexOf('inventory-app')).replace(/\\/g, '/')
                : path.basename(filePath);

            const metrics = f.metrics && f.metrics[0] ? f.metrics[0].$ : {};

            const totalStatements = parseInt(metrics.statements || 0, 10);
            const coveredStatements = parseInt(metrics.coveredstatements || 0, 10);
            const totalBranches = parseInt(metrics.conditionals || 0, 10);
            const coveredBranches = parseInt(metrics.coveredconditionals || 0, 10);
            const totalFunctions = parseInt(metrics.methods || 0, 10);
            const coveredFunctions = parseInt(metrics.coveredmethods || 0, 10);

            // Calculate lines based on type='stmt' line tags
            let totalLines = 0;
            let coveredLines = 0;
            if (f.line) {
                f.line.forEach(l => {
                    const lineAttr = l.$;
                    if (lineAttr && lineAttr.type === 'stmt') {
                        totalLines++;
                        if (parseInt(lineAttr.count || 0, 10) > 0) {
                            coveredLines++;
                        }
                    }
                });
            }

            if (totalLines === 0) {
                totalLines = totalStatements;
                coveredLines = coveredStatements;
            }

            // Accumulate grand totals
            grandTotalStatements += totalStatements;
            grandCoveredStatements += coveredStatements;
            grandTotalBranches += totalBranches;
            grandCoveredBranches += coveredBranches;
            grandTotalFunctions += totalFunctions;
            grandCoveredFunctions += coveredFunctions;
            grandTotalLines += totalLines;
            grandCoveredLines += coveredLines;

            // Formatter helper
            const getPct = (covered, total) => {
                if (total === 0) return '100.00%';
                return ((covered / total) * 100).toFixed(2) + '%';
            };

            tableRows.push({
                file: relativePath,
                statements: getPct(coveredStatements, totalStatements),
                branches: getPct(coveredBranches, totalBranches),
                functions: getPct(coveredFunctions, totalFunctions),
                lines: getPct(coveredLines, totalLines)
            });
        });

        const getPct = (covered, total) => {
            if (total === 0) return '100.00%';
            return ((covered / total) * 100).toFixed(2) + '%';
        };

        const summaryRow = {
            file: '**All Files (Total Summary)**',
            statements: `**${getPct(grandCoveredStatements, grandTotalStatements)}**`,
            branches: `**${getPct(grandCoveredBranches, grandTotalBranches)}**`,
            functions: `**${getPct(grandCoveredFunctions, grandTotalFunctions)}**`,
            lines: `**${getPct(grandCoveredLines, grandTotalLines)}**`
        };

        let markdownTable = `### 📊 Test Coverage Summary\n\n`;
        markdownTable += `| File | Statements | Branches | Functions | Lines |\n`;
        markdownTable += `| :--- | :--- | :--- | :--- | :--- |\n`;
        markdownTable += `| ${summaryRow.file} | ${summaryRow.statements} | ${summaryRow.branches} | ${summaryRow.functions} | ${summaryRow.lines} |\n`;

        tableRows.forEach(row => {
            markdownTable += `| ${row.file} | ${row.statements} | ${row.branches} | ${row.functions} | ${row.lines} |\n`;
        });

        markdownTable += '\n';

        const summaryPath = process.env.GITHUB_STEP_SUMMARY || 'summary.md';
        fs.appendFileSync(summaryPath, markdownTable);
        console.log('Successfully generated GITHUB_STEP_SUMMARY coverage table.');
    } catch (err) {
        console.error('Error parsing coverage.xml:', err);
        const summaryPath = process.env.GITHUB_STEP_SUMMARY || 'summary.md';
        fs.appendFileSync(
            summaryPath,
            `### ⚠️ Test Coverage Summary\n\nGagal memproses laporan coverage: ${err.message}`
        );
    }
}

parseCoverage();
