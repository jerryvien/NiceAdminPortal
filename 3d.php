<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Three.js Starter</title>
<style>html,body{height:100%;margin:0} canvas{display:block}</style>
</head>
<body>
<script type="module">
  import * as THREE from 'https://unpkg.com/three@0.167.0/build/three.module.js';
  import { OrbitControls } from 'https://unpkg.com/three@0.167.0/examples/jsm/controls/OrbitControls.js';

  const scene = new THREE.Scene();
  scene.background = new THREE.Color(0x202124);

  const camera = new THREE.PerspectiveCamera(60, innerWidth/innerHeight, 0.1, 100);
  camera.position.set(2, 2, 3);

  const renderer = new THREE.WebGLRenderer({ antialias: true });
  renderer.setSize(innerWidth, innerHeight);
  renderer.shadowMap.enabled = true;
  document.body.appendChild(renderer.domElement);

  const light = new THREE.DirectionalLight(0xffffff, 1);
  light.position.set(3,4,5);
  light.castShadow = true;
  scene.add(light, new THREE.AmbientLight(0xffffff, 0.3));

  const geo = new THREE.BoxGeometry(1,1,1);
  const mat = new THREE.MeshStandardMaterial({ color: 0x4aa3ff, roughness: 0.4, metalness: 0.2 });
  const cube = new THREE.Mesh(geo, mat);
  cube.castShadow = cube.receiveShadow = true;
  scene.add(cube);

  const plane = new THREE.Mesh(new THREE.PlaneGeometry(10,10), new THREE.MeshStandardMaterial({color:0x333333}));
  plane.rotation.x = -Math.PI/2;
  plane.position.y = -0.8;
  plane.receiveShadow = true;
  scene.add(plane);

  const controls = new OrbitControls(camera, renderer.domElement);

  window.addEventListener('resize', () => {
    camera.aspect = innerWidth / innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(innerWidth, innerHeight);
  });

  (function animate(){
    requestAnimationFrame(animate);
    cube.rotation.y += 0.01;
    renderer.render(scene, camera);
  })();
</script>
</body>
</html>
