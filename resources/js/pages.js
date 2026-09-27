/**
 * pages.js — JavaScript khusus halaman Blade (bukan Inertia/Vue)
 * Di-bundle oleh Vite dan di-load lewat @vite() di layouts/app.blade.php
 *
 * Berisi:
 *  1. Team member rotation — untuk hero section di halaman Beranda
 *  2. Auto-dismiss banner  — untuk <x-status-banner> jika diperlukan
 */

// ──────────────────────────────────────────────────────────
// 1. ROTATING TEAM MEMBER (Beranda / home.blade.php)
// ──────────────────────────────────────────────────────────
const teamMembers = [
    "Addien Zafriyan Al Akhsan — 5025241058",
    "Aji Zaenul Musthofa — 5025241065",
    "Anak Agung Putu Arda N — 5025241074",
    "Willy Dava Nugraha — 5025241090",
    "Abdullah Sultan Barizy — 5025241092",
    "Raden Kurniawan Agung Fitrianto — 5025241104",
];

const teamEl = document.getElementById('dynamic-team');

if (teamEl) {
    let idx = 0;
    teamEl.style.transition = 'opacity 0.15s ease-in-out';

    setInterval(() => {
        idx = (idx + 1) % teamMembers.length;
        teamEl.style.opacity = '0';
        setTimeout(() => {
            teamEl.textContent = teamMembers[idx];
            teamEl.style.opacity = '1';
        }, 150);
    }, 1000);
}

// ──────────────────────────────────────────────────────────
// 2. WORKSPACE CANVAS DIAGRAM (agent.blade.php)
//    Dijalankan hanya jika canvas ada di halaman
// ──────────────────────────────────────────────────────────
const cv = document.getElementById('workspaceCanvas');

if (cv) {
    const ctx = cv.getContext('2d');
    const rect = cv.getBoundingClientRect();
    const dpr = window.devicePixelRatio || 1;

    cv.width  = rect.width  * dpr;
    cv.height = rect.height * dpr;
    ctx.scale(dpr, dpr);

    const W = rect.width, H = rect.height;
    const cX = W / 2, cY = H / 2;

    ctx.font = '14px monospace';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';

    const drawArrow = (x1, y1, x2, y2) => {
        ctx.beginPath();
        ctx.moveTo(x1, y1);
        ctx.lineTo(x2, y2);
        ctx.strokeStyle = '#8b949e';
        ctx.lineWidth = 1.5;
        ctx.stroke();

        ctx.fillStyle = '#8b949e';
        const angle = Math.atan2(y2 - y1, x2 - x1);
        const head = (x, y, rot) => {
            ctx.save(); ctx.translate(x, y); ctx.rotate(rot);
            ctx.beginPath(); ctx.moveTo(0,0); ctx.lineTo(-10,4); ctx.lineTo(-10,-4);
            ctx.closePath(); ctx.fill(); ctx.restore();
        };
        head(x2, y2, angle);
        head(x1, y1, angle + Math.PI);
    };

    const centerW = 200, sideW = 150, vertW = 160, nodeH = 40, gap = 80;

    const nodes = {
        center:       { x: cX,                                  y: cY },
        github:       { x: cX,                                  y: cY - nodeH/2 - gap - nodeH/2 },
        backend:      { x: cX,                                  y: cY + nodeH/2 + gap + nodeH/2 },
        collaborator: { x: cX - centerW/2 - gap - sideW/2,     y: cY },
        ai:           { x: cX + centerW/2 + gap + sideW/2,     y: cY },
    };

    drawArrow(nodes.center.x, nodes.github.y + nodeH/2, nodes.center.x, nodes.center.y - nodeH/2);
    drawArrow(nodes.center.x, nodes.center.y + nodeH/2, nodes.center.x, nodes.backend.y - nodeH/2);
    drawArrow(nodes.collaborator.x + sideW/2, nodes.collaborator.y, nodes.center.x - centerW/2, nodes.center.y);
    drawArrow(nodes.center.x + centerW/2, nodes.center.y, nodes.ai.x - sideW/2, nodes.ai.y);

    [
        [nodes.github.x,       nodes.github.y,       vertW,   'GitHub',         '#ffffff', '#374151', '#1f2937'],
        [nodes.collaborator.x, nodes.collaborator.y, sideW,   'Collaborator',   '#34d399', '#064e3b', '#06251d'],
        [nodes.ai.x,           nodes.ai.y,           sideW,   'Agentic AI',     '#c084fc', '#581c87', '#170d24'],
        [nodes.backend.x,      nodes.backend.y,      vertW,   'Laravel Backend','#f87171', '#7f1d1d', '#250b0b'],
        [nodes.center.x,       nodes.center.y,       centerW, 'Web-based IDE',  '#ffffff', '#10b981', '#111827', '#10b981'],
    ].forEach(([x, y, w, text, tc, bc, bg, glow]) => {
        ctx.shadowBlur  = glow ? 15 : 0;
        ctx.shadowColor = glow || 'transparent';
        ctx.fillStyle   = bg;
        ctx.strokeStyle = bc;
        ctx.lineWidth   = glow ? 2 : 1.5;

        ctx.beginPath();
        ctx.roundRect(x - w/2, y - nodeH/2, w, nodeH, 6);
        ctx.fill();
        ctx.stroke();

        ctx.shadowBlur  = 0;
        ctx.fillStyle   = tc;
        ctx.fillText(text, x, y);
    });
}
