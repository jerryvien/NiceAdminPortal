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
    .sub{font-size:12px;color:var(--muted);margin-bottom:12px}
    .row{display:flex;gap:8px;flex-wrap:wrap}
    .btn{background:#1d2331;border:1px solid #2a3147;color:#e8eefc;padding:8px 10px;border-radius:10px;cursor:pointer}
    .btn:disabled{opacity:.5;cursor:not-allowed}
    .btn.primary{border-color:#3b82f6;background:#1f2a44}
    .list{max-height:240px;overflow:auto;border:1px solid #26304a;border-radius:12px;padding:8px}
    .list .item{padding:8px;border-radius:8px;cursor:pointer}
    .list .item.active{background:#1e2433;border:1px solid #384464}
    .dropzone{border:1.5px dashed #3c4664;border-radius:12px;padding:10px;text-align:center;color:var(--muted);font-size:13px}
    .swatch{width:26px;height:26px;border-radius:6px;border:1px solid #2a3147;cursor:grab}
    .swatch:active{cursor:grabbing}
    .color-input{width:100%;height:36px;border-radius:10px;border:1px solid #2a3147;background:#111827}
    .footer{font-size:11px;color:var(--muted);margin-top:10px}
    canvas{display:block;width:100%;height:100%}
    .stage{position:relative;background:#0b0e14}
    .toast{position:absolute;left:12px;bottom:12px;background:rgba(22,26,34,.85);border:1px solid #2b3144;color:#dce6ff;padding:8px 10px;border-radius:10px;font-size:12px}
    .floating-controls{position:absolute;top:12px;right:12px;display:flex;gap:8px}
    .status{position:absolute;left:12px;top:12px;background:rgba(22,26,34,.6);border:1px solid #2b3144;padding:6px 8px;border-radius:8px;font-size:11px;color:#cbd5ff;white-space:pre-line;max-width:40ch}
  </style>
</head>
<body>
  <div class="app">
    <aside>
      <h1>Motorcycle Customizer</h1>
      <div class="sub">Works on Hostinger/PHP. Uses non‑module scripts (no MIME issues). Click a part, color it, or drop PNG/JPG as decal. 360° view.
      <br/>Tip: drag‑drop your <b>.glb/.gltf</b> onto the canvas.</div>

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

  <!-- === Non‑module builds (CDN). Works on most shared hosts === -->
  <script src="https://unpkg.com/three@0.162.0/build/three.min.js"></script>
  <script src="https://unpkg.com/three@0.162.0/examples/js/controls/OrbitControls.js"></script>
  <script src="https://unpkg.com/three@0.162.0/examples/js/loaders/GLTFLoader.js"></script>
  <script src="https://unpkg.com/three@0.162.0/examples/js/loaders/DRACOLoader.js"></script>

  <script>
  (function(){
    const $ = (s)=>document.querySelector(s);
    const statusBox = $('#status');
    function logStatus(msg){ statusBox.textContent = msg; }

    // Basic sanity check for THREE
    if(!window.THREE){ logStatus('THREE failed to load.
If you use a firewall/CDN, allow unpkg.com.'); return; }

    // Renderer
    const stage = $('#stage');
    const renderer = new THREE.WebGLRenderer({antialias:true, preserveDrawingBuffer:true});
    renderer.setPixelRatio(Math.min(window.devicePixelRatio||1, 2));
    stage.appendChild(renderer.domElement);

    // Scene & Camera & Controls
    const scene = new THREE.Scene(); scene.background = new THREE.Color('#0b0e14');
    const camera = new THREE.PerspectiveCamera(45, 1, 0.1, 200); camera.position.set(3.8, 2.2, 5.2);
    const controls = new THREE.OrbitControls(camera, renderer.domElement); controls.enableDamping = true;

    // Lights
    scene.add(new THREE.HemisphereLight(0xffffff, 0x202030, 1.1));
    const key = new THREE.DirectionalLight(0xffffff, 1.0); key.position.set(5,6,4); scene.add(key);
    const fill = new THREE.DirectionalLight(0xffffff, 0.5); fill.position.set(-6,3,-5); scene.add(fill);
    const rim  = new THREE.DirectionalLight(0xffffff, 0.6); rim.position.set(0,5,-6); scene.add(rim);

    // Ground
    const ground = new THREE.Mesh(new THREE.CircleGeometry(20,64), new THREE.MeshStandardMaterial({color:'#0c1220', metalness:0.2, roughness:0.9}));
    ground.rotation.x = -Math.PI/2; ground.position.y = -0.001; ground.receiveShadow = true; scene.add(ground);

    // Resize
    function onResize(){ const w=stage.clientWidth, h=stage.clientHeight||window.innerHeight; renderer.setSize(w,h,false); camera.aspect=w/h; camera.updateProjectionMatrix(); }
    new ResizeObserver(onResize).observe(stage); onResize();

    // Picking
    const raycaster = new THREE.Raycaster(); const mouse = new THREE.Vector2();
    let modelRoot = null; let selectableMeshes = []; let selected = null; let baseMaterials = new Map();

    function setSelected(mesh){
      selected = mesh || null;
      $('#selectedName').textContent = selected ? (selected.userData.partName || selected.name || 'Mesh') : 'None';
      updatePartsListActive();
    }

    function collectSelectable(root){
      selectableMeshes = [];
      root.traverse((o)=>{
        if(o.isMesh){
          if(Array.isArray(o.material)) o.material = o.material[0];
          o.material = o.material.clone();
          baseMaterials.set(o, o.material.clone());
          const n = (o.name||'mesh');
          o.userData.partName = o.userData.partName || n;
          selectableMeshes.push(o);
        }
      });
      buildPartsList();
    }

    function buildPartsList(){
      const list = $('#partsList'); list.innerHTML='';
      const items = selectableMeshes.map(m=>({mesh:m, name:(m.userData.partName||'').toString().toLowerCase()})).sort((a,b)=> a.name.localeCompare(b.name));
      for(const {mesh,name} of items){
        const el = document.createElement('div'); el.className='item'; el.textContent = name || mesh.name || 'mesh';
        el.addEventListener('click',()=> setSelected(mesh));
        list.appendChild(el);
      }
      updatePartsListActive();
    }
    function updatePartsListActive(){
      const list = $('#partsList'); for(const el of list.children){ el.classList.remove('active'); }
      if(!selected) return; const idx = selectableMeshes.indexOf(selected); if(idx>=0 && list.children[idx]) list.children[idx].classList.add('active');
    }

    // Load GLB (from drop or URL)
    function loadGLB(url){
      return new Promise((resolve, reject)=>{
        const loader = new THREE.GLTFLoader();
        const draco = new THREE.DRACOLoader();
        draco.setDecoderPath('https://unpkg.com/three@0.162.0/examples/js/libs/draco/');
        loader.setDRACOLoader(draco);
        loader.load(url,(gltf)=>{
          if(modelRoot){ scene.remove(modelRoot); modelRoot.traverse(o=>{ if(o.geometry) o.geometry.dispose(); if(o.material) o.material.dispose(); }); }
          modelRoot = gltf.scene; scene.add(modelRoot);
          // Fit & center
          const box = new THREE.Box3().setFromObject(modelRoot); const size=new THREE.Vector3(); box.getSize(size); const center=new THREE.Vector3(); box.getCenter(center);
          modelRoot.position.sub(center);
          const maxDim = Math.max(size.x,size.y,size.z)||1; modelRoot.scale.setScalar(3.2/maxDim);
          collectSelectable(modelRoot); setSelected(selectableMeshes[0]||null);
          controls.target.set(0,0.7,0); controls.update();
          resolve();
        }, undefined, (err)=>{ console.error(err); reject(err); });
      });
    }

    // Demo model (remote). Fallback to placeholder if blocked
    async function loadDemo(){
      logStatus('Loading demo motorcycle…');
      try{
        await loadGLB('https://assets.pmnd.rs/moto.glb');
        logStatus('Demo loaded. Click parts to color.');
      }catch(e){
        console.warn('Demo model failed, using placeholder', e);
        logStatus('Demo blocked. Showing placeholder bike.');
        loadPlaceholder();
      }
    }

    // Placeholder geometry (always works)
    function loadPlaceholder(){
      if(modelRoot) scene.remove(modelRoot);
      const group = new THREE.Group();
      const m = new THREE.MeshStandardMaterial({color:'#888',metalness:.7,roughness:.4});
      const body = new THREE.Mesh(new THREE.BoxGeometry(2,0.7,0.6), m.clone()); body.name='body'; body.position.y=0.9; group.add(body);
      const wheelGeo = new THREE.CylinderGeometry(0.45,0.45,0.22,32); wheelGeo.rotateZ(Math.PI/2);
      const w1 = new THREE.Mesh(wheelGeo, m.clone()); w1.name='front_wheel'; w1.position.set(0.95,0.45,0); group.add(w1);
      const w2 = new THREE.Mesh(wheelGeo, m.clone()); w2.name='rear_wheel';  w2.position.set(-0.95,0.45,0); group.add(w2);
      modelRoot = group; scene.add(group);
      collectSelectable(modelRoot); setSelected(selectableMeshes[0]||null);
    }

    // Mouse picking
    renderer.domElement.addEventListener('pointerdown', (event)=>{
      const rect = renderer.domElement.getBoundingClientRect();
      mouse.x = ((event.clientX - rect.left)/rect.width)*2 - 1;
      mouse.y = -((event.clientY - rect.top)/rect.height)*2 + 1;
      raycaster.setFromCamera(mouse, camera);
      const hits = raycaster.intersectObjects(selectableMeshes, true);
      if(hits.length){ setSelected(hits[0].object); }
    });

    // Drag color swatch / image
    function makeSwatches(){
      const colors = ['#ffffff','#111111','#ff4444','#ff9900','#ffe14e','#4ea1ff','#62d9a2','#9b6bff','#c9d1e9'];
      const wrap = $('#swatches'); wrap.innerHTML = '';
      for(const c of colors){
        const d = document.createElement('div'); d.className='swatch'; d.style.background=c; d.draggable=true;
        d.addEventListener('dragstart', (ev)=>{ ev.dataTransfer.setData('text/color', c); });
        wrap.appendChild(d);
      }
      renderer.domElement.addEventListener('dragover', (e)=>{ e.preventDefault(); });
      renderer.domElement.addEventListener('drop', (e)=>{
        e.preventDefault();
        const col = e.dataTransfer.getData('text/color');
        if(col) applyColorToSelected(col);
        else if(e.dataTransfer.files && e.dataTransfer.files[0]) handleImageFile(e.dataTransfer.files[0]);
      });
    }

    function applyColorToSelected(hex){
      if(!selected) return; const mat = selected.material; if(!mat) return;
      mat.color = new THREE.Color(hex); mat.needsUpdate = true;
    }

    function handleImageFile(file){
      if(!selected || !file || !file.type.startsWith('image/')) return;
      const url = URL.createObjectURL(file);
      const tex = new THREE.TextureLoader().load(url, ()=>{ URL.revokeObjectURL(url); });
      tex.colorSpace = THREE.SRGBColorSpace; tex.flipY = false; tex.wrapS = tex.wrapT = THREE.RepeatWrapping;
      selected.material.map = tex; selected.material.needsUpdate = true;
    }

    // Dropzone (left panel)
    const dropzone = $('#dropzone');
    ;['dragenter','dragover'].forEach(evt=> dropzone.addEventListener(evt,(e)=>{ e.preventDefault(); dropzone.style.borderColor = '#6aa3ff'; }));
    ;['dragleave','drop'].forEach(evt=> dropzone.addEventListener(evt,(e)=>{ e.preventDefault(); dropzone.style.borderColor = '#3c4664'; }));
    dropzone.addEventListener('drop',(e)=>{ const f = e.dataTransfer.files?.[0]; if(f) handleImageFile(f); });

    // Buttons
    $('#applyColor').addEventListener('click',()=> applyColorToSelected($('#colorPicker').value));
    $('#clearTextures').addEventListener('click',()=>{
      for(const m of selectableMeshes){ const base = baseMaterials.get(m); if(base){ m.material.map = null; m.material.color.copy(base.color); m.material.needsUpdate = true; } }
    });

    let isAuto = false; $('#autoRotate').addEventListener('click',()=>{ isAuto = !isAuto; $('#autoRotate').textContent = `Auto Rotate: ${isAuto? 'On':'Off'}`; });
    let isWire = false; $('#wireframe').addEventListener('click',()=>{ isWire = !isWire; for(const m of selectableMeshes){ m.material.wireframe = isWire; } $('#wireframe').textContent = `Wireframe: ${isWire? 'On':'Off'}`; });

    // Drag & drop GLB/GLTF
    renderer.domElement.addEventListener('dragover', (e)=>{ e.preventDefault(); });
    renderer.domElement.addEventListener('drop', (e)=>{
      // If it's a color/image drop handled earlier, ignore here
      if(e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files[0]){
        const f = e.dataTransfer.files[0];
        if(/\.(gltf?|glb)$/i.test(f.name)){
          e.preventDefault();
          const url = URL.createObjectURL(f); loadGLB(url).then(()=> URL.revokeObjectURL(url));
        }
      }
    });

    // Export snapshot
    $('#exportPNG').addEventListener('click',()=>{
      const link = document.createElement('a'); link.download = `motorcycle-${Date.now()}.png`; link.href = renderer.domElement.toDataURL('image/png'); link.click();
    });

    // Swatches + boot
    makeSwatches(); loadPlaceholder(); logStatus('Ready. Try "Load Demo Bike" or drop your .glb');

    // Render loop
    const clock = new THREE.Clock();
    function tick(){ const dt = clock.getDelta(); controls.update(); if(isAuto && modelRoot) modelRoot.rotation.y += dt*0.6; renderer.render(scene,camera); requestAnimationFrame(tick); }
    tick();

    // Buttons wired
    $('#loadDemo').addEventListener('click', loadDemo);
    $('#loadPlaceholder').addEventListener('click', loadPlaceholder);
  })();
  </script>
</body>
</html>
