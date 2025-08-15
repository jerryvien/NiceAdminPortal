<?php /* Motorcycle Customizer – Hostinger/PHP Friendly (External JS) */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Motorcycle Customizer – PHP/Hostinger Friendly</title>
  <style>
    :root{--bg:#0f1115;--panel:#161a22;--muted:#8b93a7;--accent:#4ea1ff}
    *{box-sizing:border-box} body{margin:0;background:var(--bg);color:#e8eefc;font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,"Helvetica Neue",sans-serif}
    .app{display:grid;grid-template-columns:320px 1fr;min-height:100vh}
    aside{background:var(--panel);padding:16px 14px;border-right:1px solid #232839}
    h1{font-size:18px;margin:0 0 8px 0}
    .sub{font-size:12px;color:#8b93a7;margin-bottom:12px}
    .row{display:flex;gap:8px;flex-wrap:wrap}
    .btn{background:#1d2331;border:1px solid #2a3147;color:#e8eefc;padding:8px 10px;border-radius:10px;cursor:pointer}
    .btn:disabled{opacity:.5;cursor:not-allowed}
    .btn.primary{border-color:#3b82f6;background:#1f2a44}
    .list{max-height:240px;overflow:auto;border:1px solid #26304a;border-radius:12px;padding:8px}
    .list .item{padding:8px;border-radius:8px;cursor:pointer}
    .list .item.active{background:#1e2433;border:1px solid #384464}
    .dropzone{border:1.5px dashed #3c4664;border-radius:12px;padding:10px;text-align:center;color:#8b93a7;font-size:13px}
    .swatch{width:26px;height:26px;border-radius:6px;border:1px solid #2a3147;cursor:grab}
    .swatch:active{cursor:grabbing}
    .color-input{width:100%;height:36px;border-radius:10px;border:1px solid #2a3147;background:#111827}
    .footer{font-size:11px;color:#8b93a7;margin-top:10px}
    canvas{display:block;width:100%;height:100%}
    .stage{position:relative;background:#0b0e14;min-height:100vh}
    .toast{position:absolute;left:12px;bottom:12px;background:rgba(22,26,34,.85);border:1px solid #2b3144;color:#dce6ff;padding:8px 10px;border-radius:10px;font-size:12px}
    .floating-controls{position:absolute;top:12px;right:12px;display:flex;gap:8px}
    .status{position:absolute;left:12px;top:12px;background:rgba(22,26,34,.6);border:1px solid #2b3144;padding:6px 8px;border-radius:8px;font-size:11px;color:#cbd5ff;white-space:pre-line;max-width:40ch}
  </style>
</head>
<body>
  <div class="app">
    <aside>
      <h1>Motorcycle Customizer</h1>
      <div class="sub">
        Works on Hostinger/PHP. Uses non‑module scripts (no MIME issues). Click a part, color it, or drop PNG/JPG as decal. 360° view.<br/>
        Tip: drag‑drop your <b>.glb/.gltf</b> onto the canvas.
      </div>

      <div class="row">
        <button id="loadDemo" class="btn primary">Load Demo Bike</button>
        <button id="loadPlaceholder" class="btn">Load Placeholder</button>
        <button id="clearTextures" class="btn">Clear Textures</button>
      </div>

      <div class="section" style="margin-top:12px">
        <label class="sub">Selected Part</label>
        <div id="selectedName" class="btn" style="width:100%;justify-content:flex-start">None</div>
      </div>

      <div class="section">
        <label class="sub">Quick Colors (drag onto the bike)</label>
        <div class="row" id="swatches"></div>
        <div style="height:8px"></div>
        <input id="colorPicker" class="color-input" type="color" value="#4ea1ff" />
        <div class="row" style="margin-top:8px">
          <button id="applyColor" class="btn">Apply to Selected</button>
        </div>
      </div>

      <div class="section">
        <label class="sub">Texture (drag & drop an image)</label>
        <div id="dropzone" class="dropzone">Drop PNG/JPG here → applies to selected part</div>
        <div class="footer">Use transparent PNG decals for logos/stripes.</div>
      </div>

      <div class="section">
        <label class="sub">Parts</label>
        <div id="partsList" class="list"></div>
      </div>

      <div class="section">
        <label class="sub">Export</label>
        <div class="row">
          <button id="exportPNG" class="btn">Snapshot PNG</button>
        </div>
      </div>
    </aside>

    <div id="stage" class="stage">
      <div class="floating-controls">
        <button id="autoRotate" class="btn">Auto Rotate: Off</button>
        <button id="wireframe" class="btn">Wireframe: Off</button>
      </div>
      <div class="status" id="status">Booting…</div>
      <div class="toast">Rotate: drag • Zoom: wheel • Pan: right‑drag • Drop .glb/.gltf/images</div>
    </div>
  </div>

  <!-- Libraries (non-module). Keep order. -->
  <script src="https://unpkg.com/three@0.162.0/build/three.min.js" defer></script>
  <script src="https://unpkg.com/three@0.162.0/examples/js/controls/OrbitControls.js" defer></script>
  <script src="https://unpkg.com/three@0.162.0/examples/js/loaders/GLTFLoader.js" defer></script>
  <script src="https://unpkg.com/three@0.162.0/examples/js/loaders/DRACOLoader.js" defer></script>

  <!-- App code (external to avoid inline-script blocking) -->
  <script src="./app.js" defer></script>
</body>
</html>
