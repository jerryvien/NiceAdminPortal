<?php /* Motorcycle Customizer (Hostinger Offline) */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Motorcycle Customizer</title>
  <style>
    :root{--bg:#0f1115;--panel:#161a22;--muted:#8b93a7}
    *{box-sizing:border-box} body{margin:0;background:var(--bg);color:#e8eefc;font-family:system-ui,-apple-system,Segoe UI,Roboto}
    .app{display:grid;grid-template-columns:320px 1fr;min-height:100vh}
    aside{background:#161a22;padding:16px;border-right:1px solid #232839}
    h1{font-size:18px;margin:0 0 8px}
    .sub{font-size:12px;color:var(--muted);margin:6px 0 10px}
    .btn{background:#1d2331;border:1px solid #2a3147;color:#e8eefc;padding:8px 10px;border-radius:10px;cursor:pointer}
    .row{display:flex;gap:8px;flex-wrap:wrap}
    .list{max-height:220px;overflow:auto;border:1px solid #26304a;border-radius:12px;padding:8px}
    .item{padding:8px;border-radius:8px;cursor:pointer}
    .item.active{background:#1e2433;border:1px solid #384464}
    .stage{position:relative}
    canvas{display:block;width:100%;height:100%}
    .swatch{width:26px;height:26px;border-radius:6px;border:1px solid #2a3147;cursor:grab}
    .dropzone{border:1.5px dashed #3c4664;border-radius:12px;padding:10px;text-align:center;color:#8b93a7;font-size:13px}
    .floating{position:absolute;top:12px;right:12px;display:flex;gap:8px}
    .color-input{width:100%;height:36px;border-radius:10px;border:1px solid #2a3147;background:#111827}
  </style>
</head>
<body>
  <div class="app">
    <aside>
      <h1>Motorcycle Customizer</h1>
      <div class="sub">Upload your <b>.glb/.gltf</b>. Click a part, color it, or drop a PNG/JPG decal. 360° view included.</div>

      <div class="row" style="margin:8px 0 12px">
        <button id="loadPlaceholder" class="btn">Load Placeholder Bike</button>
        <button id="clearTextures" class="btn">Clear Textures</button>
      </div>

      <div class="sub">Selected Part</div>
      <div id="selectedName" class="btn" style="width:100%;justify-content:flex-start">None</div>

      <div class="sub" style="margin-top:12px">Quick Colors (drag onto bike)</div>
      <div id="swatches" class="row"></div>
      <input id="colorPicker" class="color-input" type="color" value="#4ea1ff" style="margin-top:8px" />
      <div class="row" style="margin-top:8px"><button id="applyColor" class="btn">Apply to Selected</button></div>

      <div class="sub" style="margin-top:12px">Texture (drag & drop image)</div>
      <div id="dropzone" class="dropzone">Drop PNG/JPG here → will apply to the selected part</div>

      <div class="sub" style="margin-top:12px">Parts</div>
      <div id="partsList" class="list"></div>

      <div class="sub" style="margin-top:12px">Export</div>
      <div class="row"><button id="exportPNG" class="btn">Snapshot PNG</button></div>
    </aside>

    <div id="stage" class="stage">
      <div class="floating">
        <button id="autoRotate" class="btn">Auto Rotate: Off</button>
        <button id="wireframe" class="btn">Wireframe: Off</button>
      </div>
    </div>
  </div>

  <script type="module">
    import * as THREE from './vendor/three/build/three.module.js';
    import { OrbitControls } from './vendor/three/examples/jsm/controls/OrbitControls.js';
    import { GLTFLoader } from './vendor/three/examples/jsm/loaders/GLTFLoader.js';
    import { DRACOLoader } from './vendor/three/examples/jsm/loaders/DRACOLoader.js';

    const $ = s=>document.querySelector(s);
    const stage = $('#stage');

    // Renderer
    const renderer = new THREE.WebGLRenderer({ antialias:true, preserveDrawingBuffer:true });
    renderer.setPixelRatio(Math.min(devicePixelRatio,2));
    stage.appendChild(renderer.domElement);

    // Scene + Camera
    const scene = new THREE.Scene();
    scene.background = new THREE.Color('#0b0e14');
    const camera = new THREE.PerspectiveCamera(45, 1, 0.1, 200);
    camera.position.set(3.8, 2.2, 5.2);
    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;

    // Lights
    scene.add(new THREE.HemisphereLight(0xffffff, 0x202030, 1.1));
    const key = new THREE.DirectionalLight(0xffffff, 1.0); key.position.set(5,6,4); scene.add(key);
    const fill = new THREE.DirectionalLight(0xffffff, 0.5); fill.position.set(-6,3,-5); scene.add(fill);
    const rim  = new THREE.DirectionalLight(0xffffff, 0.6); rim.position.set(0,5,-6); scene.add(rim);

    // Ground
    const ground = new THREE.Mesh(new THREE.CircleGeometry(20,64), new THREE.MeshStandardMaterial({color:'#0c1220', metalness:.2, roughness:.9}));
    ground.rotation.x = -Math.PI/2; ground.position.y = -0.001; scene.add(ground);

    // Resize
    function fit(){ const w=stage.clientWidth, h=stage.clientHeight||window.innerHeight; renderer.setSize(w,h,false); camera.aspect=w/h; camera.updateProjectionMatrix(); }
    new ResizeObserver(fit).observe(stage); fit();

    // Picking
    const ray = new THREE.Raycaster(), mouse = new THREE.Vector2();
    let modelRoot=null, selectable=[], selected=null, baseMaterials=new Map();

    function setSelected(mesh){
      selected = mesh || null;
      $('#selectedName').textContent = selected ? (selected.userData.partName || selected.name || 'Mesh') : 'None';
      updatePartsListActive();
    }

    function collectSelectable(root){
      selectable = [];
      root.traverse(o=>{
        if(o.isMesh){
          if(Array.isArray(o.material)) o.material = o.material[0];
          o.material = o.material.clone();
          baseMaterials.set(o, o.material.clone());
          o.userData.partName = o.userData.partName || o.name || 'mesh';
          selectable.push(o);
        }
      });
      buildPartsList();
    }

    function buildPartsList(){
      const list = $('#partsList'); list.innerHTML='';
      const items = selectable.map(m=>({mesh:m,name:(m.userData.partName||'').toString().toLowerCase()})).sort((a,b)=>a.name.localeCompare(b.name));
      for(const {mesh,name} of items){
        const el = document.createElement('div'); el.className='item'; el.textContent = name || mesh.name || 'mesh';
        el.addEventListener('click',()=> setSelected(mesh));
        list.appendChild(el);
      }
      updatePartsListActive();
    }
    function updatePartsListActive(){
      const list = $('#partsList'); Array.from(list.children).forEach(el=>el.classList.remove('active'));
      if(!selected) return;
      const idx = selectable.indexOf(selected);
      if(idx>=0 && list.children[idx]) list.children[idx].classList.add('active');
    }

    // Load GLB/GLTF local
    function loadGLB(url){
      return new Promise((res,rej)=>{
        const loader = new GLTFLoader();
        const draco = new DRACOLoader();
        draco.setDecoderPath('./vendor/three/examples/jsm/libs/draco/gltf/');
        loader.setDRACOLoader(draco);
        loader.load(url,(gltf)=>{
          if(modelRoot){ scene.remove(modelRoot); modelRoot.traverse(o=>{ o.geometry&&o.geometry.dispose(); o.material&&o.material.dispose(); }); }
          modelRoot = gltf.scene; scene.add(modelRoot);
          // center & scale
          const box = new THREE.Box3().setFromObject(modelRoot), size=new THREE.Vector3(), center=new THREE.Vector3();
          box.getSize(size); box.getCenter(center); modelRoot.position.sub(center);
          const maxDim = Math.max(size.x,size.y,size.z)||1; modelRoot.scale.setScalar(3.2/maxDim);
          collectSelectable(modelRoot);
          setSelected(selectable[0]||null);
          controls.target.set(0,0.7,0); controls.update();
          res();
        }, undefined, (err)=>rej(err));
      });
    }

    // Placeholder bike (no external files)
    function loadPlaceholder(){
      if(modelRoot) scene.remove(modelRoot);
      const g = new THREE.Group();
      const m = new THREE.MeshStandardMaterial({color:'#888',metalness:.7,roughness:.4});
      const body = new THREE.Mesh(new THREE.BoxGeometry(2,0.7,0.6), m.clone()); body.name='body'; body.position.y=0.9; g.add(body);
      const wheelGeo = new THREE.CylinderGeometry(0.45,0.45,0.2,32); wheelGeo.rotateZ(Math.PI/2);
      const w1 = new THREE.Mesh(wheelGeo, m.clone()); w1.name='front_wheel'; w1.position.set(0.95,0.45,0); g.add(w1);
      const w2 = new THREE.Mesh(wheelGeo, m.clone()); w2.name='rear_wheel';  w2.position.set(-0.95,0.45,0); g.add(w2);
      modelRoot = g; scene.add(g);
      collectSelectable(modelRoot); setSelected(selectable[0]||null);
    }

    // Picking on canvas
    renderer.domElement.addEventListener('pointerdown',(e)=>{
      const r = renderer.domElement.getBoundingClientRect();
      mouse.x = ((e.clientX-r.left)/r.width)*2-1;
      mouse.y = -((e.clientY-r.top)/r.height)*2+1;
      ray.setFromCamera(mouse,camera);
      const hit = ray.intersectObjects(selectable,true)[0];
      if(hit) setSelected(hit.object);
    });

    // Drag color & images
    function makeSwatches(){
      const colors = ['#ffffff','#111111','#ff4444','#ff9900','#ffe14e','#4ea1ff','#62d9a2','#9b6bff','#c9d1e9'];
      const wrap = document.getElementById('swatches'); wrap.innerHTML='';
      colors.forEach(c=>{
        const d=document.createElement('div'); d.className='swatch'; d.style.background=c; d.draggable=true;
        d.addEventListener('dragstart',ev=>ev.dataTransfer.setData('text/color', c));
        wrap.appendChild(d);
      });
      renderer.domElement.addEventListener('dragover',e=>e.preventDefault());
      renderer.domElement.addEventListener('drop',(e)=>{
        e.preventDefault();
        const col = e.dataTransfer.getData('text/color');
        if(col) applyColor(col);
        else if(e.dataTransfer.files?.[0]) applyImage(e.dataTransfer.files[0]);
      });
    }

    function applyColor(hex){
      if(!selected||!selected.material) return;
      selected.material.color = new THREE.Color(hex);
      selected.material.needsUpdate = true;
    }
    function applyImage(file){
      if(!selected || !file || !file.type.startsWith('image/')) return;
      const url = URL.createObjectURL(file);
      const tex = new THREE.TextureLoader().load(url, ()=>URL.revokeObjectURL(url));
      tex.colorSpace = THREE.SRGBColorSpace; tex.flipY=false; tex.wrapS=tex.wrapT=THREE.RepeatWrapping;
      selected.material.map = tex; selected.material.needsUpdate = true;
    }

    // Dropzone
    const dz = document.getElementById('dropzone');
    ['dragenter','dragover'].forEach(e=>dz.addEventListener(e,(ev)=>{ ev.preventDefault(); dz.style.borderColor='#6aa3ff'; }));
    ['dragleave','drop'].forEach(e=>dz.addEventListener(e,(ev)=>{ ev.preventDefault(); dz.style.borderColor='#3c4664'; }));
    dz.addEventListener('drop',(ev)=>{ const f=ev.dataTransfer.files?.[0]; if(f) applyImage(f); });

    // Buttons
    document.getElementById('applyColor').addEventListener('click',()=>applyColor(document.getElementById('colorPicker').value));
    document.getElementById('clearTextures').addEventListener('click',()=>{ for(const m of selectable){ const base=baseMaterials.get(m); if(base){ m.material.map=null; m.material.color.copy(base.color); m.material.needsUpdate=true; } }});
    let auto=false; document.getElementById('autoRotate').addEventListener('click',()=>{ auto=!auto; document.getElementById('autoRotate').textContent=`Auto Rotate: ${auto?'On':'Off'}`; });
    let wire=false; document.getElementById('wireframe').addEventListener('click',()=>{ wire=!wire; for(const m of selectable){ m.material.wireframe = wire; } document.getElementById('wireframe').textContent=`Wireframe: ${wire?'On':'Off'}`; });

    // Drag & drop your GLB/GLTF
    renderer.domElement.addEventListener('dragover',e=>e.preventDefault());
    renderer.domElement.addEventListener('drop',(e)=>{
      e.preventDefault();
      const f=e.dataTransfer.files?.[0]; if(!f) return;
      if(!/\.(gltf?|glb)$/i.test(f.name)) return alert('Drop a .glb or .gltf file');
      const url = URL.createObjectURL(f); loadGLB(url).then(()=>URL.revokeObjectURL(url));
    });

    // Export PNG
    document.getElementById('exportPNG').addEventListener('click',()=>{
      const a=document.createElement('a'); a.download=`motorcycle-${Date.now()}.png`; a.href=renderer.domElement.toDataURL('image/png'); a.click();
    });

    // Start
    document.getElementById('loadPlaceholder').addEventListener('click', loadPlaceholder);
    makeSwatches(); loadPlaceholder();

    // Loop
    const clock=new THREE.Clock();
    (function animate(){
      const dt=clock.getDelta(); controls.update();
      if(auto && modelRoot) modelRoot.rotation.y += dt*0.6;
      renderer.render(scene,camera); requestAnimationFrame(animate);
    })();
  </script>
</body>
</html>
