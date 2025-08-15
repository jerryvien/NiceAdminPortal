(function(){
  const $ = (s)=>document.querySelector(s);
  const stage = $('#stage');
  const statusBox = $('#status');
  function logStatus(msg){ statusBox.textContent = msg; }

  if(!window.THREE){ logStatus('Local THREE not found. Check /vendor/three/ paths.'); return; }

  // Renderer
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

  // Load GLB
  function loadGLB(url){
    return new Promise((resolve, reject)=>{
      const loader = new THREE.GLTFLoader();
      const draco = new THREE.DRACOLoader();
      draco.setDecoderPath('./vendor/three/examples/js/libs/draco/gltf/');
      loader.setDRACOLoader(draco);
      loader.load(url,(gltf)=>{
        if(modelRoot){ scene.remove(modelRoot); modelRoot.traverse(o=>{ if(o.geometry) o.geometry.dispose(); if(o.material) o.material.dispose(); }); }
        modelRoot = gltf.scene; scene.add(modelRoot);
        const box = new THREE.Box3().setFromObject(modelRoot); const size=new THREE.Vector3(); box.getSize(size); const center=new THREE.Vector3(); box.getCenter(center);
        modelRoot.position.sub(center);
        const maxDim = Math.max(size.x,size.y,size.z)||1; modelRoot.scale.setScalar(3.2/maxDim);
        collectSelectable(modelRoot); setSelected(selectableMeshes[0]||null);
        controls.target.set(0,0.7,0); controls.update();
        resolve();
      }, undefined, (err)=>{ console.error(err); reject(err); });
    });
  }

  // Demo (still uses remote URL; optional)
  async function loadDemo(){
    logStatus('Trying demo motorcycle (needs internet)…');
    try{ await loadGLB('https://assets.pmnd.rs/moto.glb'); logStatus('Demo loaded.'); }
    catch(e){ logStatus('Demo blocked. Use Placeholder or drop a .glb.'); loadPlaceholder(); }
  }

  // Placeholder
  function loadPlaceholder(){
    if(modelRoot) scene.remove(modelRoot);
    const g = new THREE.Group();
    const m = new THREE.MeshStandardMaterial({color:'#888',metalness:.7,roughness:.4});
    const body = new THREE.Mesh(new THREE.BoxGeometry(2,0.7,0.6), m.clone()); body.name='body'; body.position.y=0.9; g.add(body);
    const wheelGeo = new THREE.CylinderGeometry(0.45,0.45,0.22,32); wheelGeo.rotateZ(Math.PI/2);
    const w1 = new THREE.Mesh(wheelGeo, m.clone()); w1.name='front_wheel'; w1.position.set(0.95,0.45,0); g.add(w1);
    const w2 = new THREE.Mesh(wheelGeo, m.clone()); w2.name='rear_wheel'; w2.position.set(-0.95,0.45,0); g.add(w2);
    modelRoot = g; scene.add(g);
    collectSelectable(modelRoot); setSelected(selectableMeshes[0]||null);
  }

  // Pick
  renderer.domElement.addEventListener('pointerdown', (e)=>{
    const r = renderer.domElement.getBoundingClientRect();
    mouse.x = ((e.clientX-r.left)/r.width)*2-1;
    mouse.y = -((e.clientY-r.top)/r.height)*2+1;
    raycaster.setFromCamera(mouse, camera);
    const hit = raycaster.intersectObjects(selectableMeshes, true)[0];
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
  document.getElementById('clearTextures').addEventListener('click',()=>{ for(const m of selectableMeshes){ const base=baseMaterials.get(m); if(base){ m.material.map=null; m.material.color.copy(base.color); m.material.needsUpdate=true; } }});
  let auto=false; document.getElementById('autoRotate').addEventListener('click',()=>{ auto=!auto; document.getElementById('autoRotate').textContent=`Auto Rotate: ${auto?'On':'Off'}`; });
  let wire=false; document.getElementById('wireframe').addEventListener('click',()=>{ wire=!wire; for(const m of selectableMeshes){ m.material.wireframe = wire; } document.getElementById('wireframe').textContent=`Wireframe: ${wire?'On':'Off'}`; });

  // Drag & drop GLB
  renderer.domElement.addEventListener('dragover',e=>e.preventDefault());
  renderer.domElement.addEventListener('drop',(e)=>{
    if(e.dataTransfer?.files?.[0]){
      const f=e.dataTransfer.files[0];
      if(/\.(gltf?|glb)$/i.test(f.name)){
        e.preventDefault();
        const url=URL.createObjectURL(f); loadGLB(url).then(()=>URL.revokeObjectURL(url));
      }
    }
  });

  // Export
  document.getElementById('exportPNG').addEventListener('click',()=>{
    const a=document.createElement('a'); a.download=`motorcycle-${Date.now()}.png`; a.href=renderer.domElement.toDataURL('image/png'); a.click();
  });

  // Boot
  makeSwatches(); loadPlaceholder(); logStatus('Ready. Upload local libs and drop your .glb');

  // Loop
  const clock=new THREE.Clock();
  (function animate(){
    const dt=clock.getDelta(); controls.update();
    if(auto && modelRoot) modelRoot.rotation.y += dt*0.6;
    renderer.render(scene,camera); requestAnimationFrame(animate);
  })();

  // Buttons
  document.getElementById('loadDemo').addEventListener('click', loadDemo);
  document.getElementById('loadPlaceholder').addEventListener('click', loadPlaceholder);
})();