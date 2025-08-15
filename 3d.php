<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Navbright — Innovative Tech Solutions</title>
  <meta name="description" content="Navbright Technology Group Sdn Bhd — interactive portfolio site showcasing technology solutions and case studies." />
  <meta property="og:title" content="Navbright — Innovative Tech Solutions" />
  <meta property="og:description" content="Interactive portfolio showcasing outcomes-driven tech projects." />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="/og-image.jpg" />
  <meta name="theme-color" content="#0b0f14" />
  
  <!-- Favicon placeholders (replace with your own) -->
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='50' fill='%230ea5e9'/%3E%3Ctext x='50' y='58' text-anchor='middle' font-size='54' fill='white' font-family='Arial,Helvetica,sans-serif'%3EN%3C/text%3E%3C/svg%3E" />

  <style>
    :root {
      --bg: #0b0f14;        /* canvas background */
      --bg-elev: #0f151c;   /* elevated surfaces */
      --text: #e5e7eb;      /* base text */
      --muted: #9ca3af;     /* secondary text */
      --brand: #38bdf8;     /* cyan */
      --brand-2: #eab308;   /* amber accent */
      --card: rgba(15, 21, 28, 0.6);
      --glass: rgba(255,255,255,0.06);
      --border: rgba(255,255,255,0.08);
      --radius: 16px;
      --shadow: 0 10px 30px rgba(0,0,0,0.35);
      --container: 1200px;
    }

    *, *::before, *::after { box-sizing: border-box; }
    html, body { height: 100%; }
    body {
      margin: 0; color: var(--text); background: var(--bg);
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Noto Sans, Ubuntu, Cantarell, Helvetica Neue, Arial, "Apple Color Emoji", "Segoe UI Emoji";
      line-height: 1.6;
    }

    a { color: inherit; text-decoration: none; }
    img { max-width: 100%; display: block; }
    .container { width: 92%; max-width: var(--container); margin: 0 auto; }

    /* Utility */
    .btn { display: inline-flex; align-items: center; gap: .6rem; border: 1px solid var(--border); border-radius: 999px; padding: .9rem 1.2rem; background: linear-gradient(180deg, rgba(56,189,248,.2), rgba(56,189,248,.06)); backdrop-filter: blur(6px); box-shadow: var(--shadow); }
    .btn:hover { transform: translateY(-1px); }
    .btn:active { transform: translateY(0); }
    .btn--ghost { background: transparent; }

    .tag { display:inline-block; border: 1px solid var(--border); padding: .25rem .6rem; border-radius: 999px; font-size: .8rem; color: var(--muted); }
    .grid { display: grid; gap: 1.2rem; }
    .grid-3 { grid-template-columns: repeat(3, 1fr); }
    .grid-2 { grid-template-columns: repeat(2, 1fr); }
    @media (max-width: 900px){ .grid-3 { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 640px){ .grid-3, .grid-2 { grid-template-columns: 1fr; } }

    .section { padding: 5rem 0; position: relative; }
    .section__title { font-size: clamp(1.6rem, 1.2rem + 1.6vw, 2.6rem); margin: 0 0 1rem; letter-spacing: .3px; }
    .section__lead { color: var(--muted); margin-bottom: 2.2rem; max-width: 70ch; }

    .card { background: var(--glass); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.2rem; box-shadow: var(--shadow); backdrop-filter: blur(6px); }
    .card h3 { margin: .2rem 0 .6rem; font-size: 1.1rem; }
    .card p { color: var(--muted); }

    header.site { position: fixed; inset: 0 0 auto 0; height: 64px; display: flex; align-items: center; z-index: 50; background: linear-gradient(180deg, rgba(11,15,20,0.85), rgba(11,15,20,0)); border-bottom: 1px solid transparent; }
    header .brand { display:flex; align-items:center; gap:.6rem; font-weight: 700; letter-spacing:.3px; }
    header .brand .logo { width: 28px; height: 28px; border-radius: 8px; background: linear-gradient(135deg, var(--brand), #155e75); display:grid; place-items:center; box-shadow: 0 4px 16px rgba(56,189,248,.35); }
    header nav { margin-left: auto; display:flex; gap:.8rem; align-items:center; }
    header nav a { padding:.5rem .8rem; border-radius: 999px; color: var(--muted); }
    header nav a:hover, header nav a[aria-current="page"] { color: white; background: rgba(255,255,255,0.06); }

    /* HERO */
    .hero { position: relative; min-height: 100vh; display: grid; place-items: center; overflow: hidden; }
    #bg-canvas { position: absolute; inset: 0; width: 100%; height: 100%; }
    .hero__content { position: relative; z-index: 1; text-align: center; padding: 8rem 1rem 5rem; }
    .eyebrow { color: var(--brand); letter-spacing: .2em; text-transform: uppercase; font-size: .8rem; }
    .hero__title { font-size: clamp(2rem, 1.2rem + 4vw, 4rem); line-height: 1.05; margin: .6rem 0 1rem; }
    .hero__subtitle { color: var(--muted); font-size: clamp(1rem, .9rem + 1vw, 1.25rem); max-width: 70ch; margin: 0 auto 1.6rem; }
    .hero__cta { display:flex; gap:.8rem; justify-content:center; flex-wrap:wrap; }

    .kpis { display:flex; gap: 1rem; justify-content:center; margin-top: 2rem; flex-wrap: wrap; }
    .kpi { background: var(--card); border: 1px solid var(--border); border-radius: 14px; padding: .8rem 1.2rem; min-width: 150px; text-align: left; }
    .kpi strong { font-size: 1.3rem; }
    .kpi span { display:block; color: var(--muted); font-size: .85rem; }

    /* SECTIONS */
    .about { }
    .services .card svg, .contact svg { width: 24px; height: 24px; opacity: .9; }

    /* PORTFOLIO */
    .work .item { position: relative; overflow: hidden; border-radius: var(--radius); border: 1px solid var(--border); background: linear-gradient(180deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02)); }
    .work .item__media { aspect-ratio: 16 / 10; display: grid; place-items: center; font-size: .9rem; color: var(--muted); }
    .work .item__meta { padding: 1rem; display:flex; align-items:center; justify-content: space-between; gap:.6rem; }
    .work .item__meta h4 { margin: 0; font-size: 1rem; }
    .chip { font-size: .75rem; opacity: .85; border: 1px solid var(--border); padding: .25rem .5rem; border-radius: 999px; }

    /* CONTACT */
    form { display: grid; gap: .9rem; }
    label { font-size: .9rem; color: var(--muted); }
    input, textarea { width: 100%; background: rgba(255,255,255,0.04); color: white; border: 1px solid var(--border); border-radius: 12px; padding: .9rem 1rem; outline: none; }
    textarea { min-height: 140px; resize: vertical; }
    input:focus, textarea:focus { border-color: rgba(56,189,248,.5); box-shadow: 0 0 0 3px rgba(56,189,248,.15); }

    footer { color: var(--muted); padding: 3rem 0; border-top: 1px solid var(--border); background: linear-gradient(180deg, rgba(255,255,255,0.04), transparent); }

    /* Animations */
    .reveal { opacity: 0; transform: translateY(18px); transition: opacity .8s ease, transform .8s ease; }
    .reveal.in { opacity: 1; transform: translateY(0); }

    @media (prefers-reduced-motion: reduce) {
      .btn, .reveal { transition: none !important; }
    }
  /* --- Journey/Scrollytelling --- */
    .progress {position: fixed; top:64px; left:0; width:100%; height:3px; background: rgba(255,255,255,0.04); z-index: 48;}
    .progress__bar {display:block; height:100%; width:0%; background: linear-gradient(90deg, var(--brand), var(--brand-2));}
    .journey {padding: 0; scroll-margin-top: 64px;}
    .chapter {min-height: 100vh; display:grid; grid-template-columns: 1.1fr .9fr; align-items:center; gap:2rem; border-bottom:1px solid var(--border); padding: 6rem 0;}
    .chapter__eyebrow {color: var(--brand); letter-spacing:.2em; text-transform:uppercase; font-size:.8rem;}
    .chapter__title {font-size: clamp(1.8rem, 1.2rem + 2vw, 3rem); margin:.4rem 0 1rem;}
    .chapter__lead {color: var(--muted); max-width: 60ch;}
    .chapter__media {border-radius: var(--radius); background: linear-gradient(135deg, rgba(255,255,255,.06), rgba(255,255,255,.02)); border:1px solid var(--border); min-height: 320px; display:grid; place-items:center;}
    .chapter.is-active .chapter__media {box-shadow: var(--shadow);}
    @media (max-width: 900px){ .chapter{grid-template-columns:1fr; padding: 5rem 0;} .chapter__media {min-height: 200px;} }

    /* Themes by chapter */
    body[data-theme="cyan"]{ --brand:#38bdf8; --brand-2:#22d3ee; }
    body[data-theme="amber"]{ --brand:#f59e0b; --brand-2:#eab308; }
    body[data-theme="violet"]{ --brand:#a78bfa; --brand-2:#8b5cf6; }
    body[data-theme="emerald"]{ --brand:#34d399; --brand-2:#10b981; }
  </style>
</head>
<body>
  <header class="site">
    <div class="container" style="display:flex; align-items:center; gap:1rem;">
      <a class="brand" href="#top" aria-current="page">
        <span class="logo" aria-hidden="true">⚡</span>
        <span>Navbright</span>
      </a>
      <nav>
        <a href="#journey">Journey</a>
        <a href="#about">About</a>
        <a href="#services">Services</a>
        <a href="#work">Work</a>
        <a href="#contact">Contact</a>
      </nav>
    </div>
  </header>
  <div class="progress" id="progress"><span class="progress__bar" id="progressBar"></span></div>

  <main id="top">
    <!-- HERO with progressive enhancement canvas bg -->
    <section class="hero" aria-label="Hero">
      <canvas id="bg-canvas" aria-hidden="true"></canvas>
      <div class="hero__content container">
        <div class="eyebrow">Technology, Design, Outcomes</div>
        <h1 class="hero__title">Building interactive experiences that convert.</h1>
        <p class="hero__subtitle">We fuse engineering and storytelling to ship fast, premium experiences — from landing pages to data-rich dashboards — with enterprise-grade performance.</p>
        <div class="hero__cta">
          <a class="btn" href="https://wa.me/60102899611?text=Hi%20Navbright%2C%20let's%20talk%20about%20our%20website." target="_blank" rel="noopener">Start on WhatsApp</a>
          <a class="btn btn--ghost" href="#work">See our work</a>
        </div>
        <div class="kpis" aria-label="Key performance metrics">
          <div class="kpi"><strong>2.0s</strong><span>LCP on mid-range mobile</span></div>
          <div class="kpi"><strong>90+ </strong><span>Core Web Vitals</span></div>
          <div class="kpi"><strong>100%</strong><span>Static hosting ready</span></div>
        </div>
      </div>
    </section>

    <!-- JOURNEY (Scrollytelling) -->
    <section id="journey" class="section journey" aria-label="Journey">
      <div class="container">
        <article class="chapter reveal" data-theme="cyan">
          <div>
            <div class="chapter__eyebrow">Chapter 1 — The Spark</div>
            <h2 class="chapter__title">From static presence to immersive narrative</h2>
            <p class="chapter__lead">We open with the problem statement. Audiences skim; stakeholders expect clarity. The journey frames your value in 30–60 seconds, guided by motion and scannable copy.</p>
          </div>
          <div class="chapter__media">Scene 1 — Ambient intro (canvas glow)</div>
        </article>

        <article class="chapter reveal" data-theme="amber">
          <div>
            <div class="chapter__eyebrow">Chapter 2 — The Friction</div>
            <h2 class="chapter__title">What usually breaks: speed, findability, conversion</h2>
            <p class="chapter__lead">Here we quantify pain points and set success criteria: LCP &lt; 2s, SEO hygiene, and a single compelling CTA.</p>
          </div>
          <div class="chapter__media">Scene 2 — Metrics &amp; constraints</div>
        </article>

        <article class="chapter reveal" data-theme="violet">
          <div>
            <div class="chapter__eyebrow">Chapter 3 — The Breakthrough</div>
            <h2 class="chapter__title">Hybrid architecture: narrative + performance</h2>
            <p class="chapter__lead">We blend lightweight WebGL, semantic HTML, and modular content. No CDN lock-in, progressive enhancement, and analytics events by design.</p>
          </div>
          <div class="chapter__media">Scene 3 — Architecture sketch</div>
        </article>

        <article class="chapter reveal" data-theme="emerald">
          <div>
            <div class="chapter__eyebrow">Chapter 4 — Proof</div>
            <h2 class="chapter__title">Snapshots from shipped projects</h2>
            <p class="chapter__lead">Short case highlights map capabilities to outcomes. Tapping opens detailed modals (see “Work” below).</p>
          </div>
          <div class="chapter__media">Scene 4 — Case highlights</div>
        </article>

        <article class="chapter reveal" data-theme="cyan">
          <div>
            <div class="chapter__eyebrow">Finale — Call to Action</div>
            <h2 class="chapter__title">Let’s co-create your next chapter</h2>
            <p class="chapter__lead">Choose WhatsApp for rapid alignment or use the form. We’ll scope, timebox, and deliver.</p>
            <div class="hero__cta" style="justify-content:flex-start;">
              <a class="btn" href="https://wa.me/60102899611?text=Hi%20Navbright%2C%20I%20want%20a%20story-driven%20site." target="_blank" rel="noopener">Start on WhatsApp</a>
              <a class="btn btn--ghost" href="#contact">Contact form</a>
            </div>
          </div>
          <div class="chapter__media">Scene 5 — CTA</div>
        </article>
      </div>
    </section>

    <!-- ABOUT -->
    <section id="about" class="section about">
      <div class="container">
        <h2 class="section__title reveal">Outcome-first engineering</h2>
        <p class="section__lead reveal">We design for business impact. Our hybrid stack balances wow-factor with operational excellence: lightweight animation, airtight SEO, and maintainable content pipelines.</p>
        <div class="grid grid-3">
          <div class="card reveal">
            <span class="tag">Performance</span>
            <h3>Speed as a feature</h3>
            <p>We budget assets, prefetch critical routes, and lazy-load everything else. Result: fast TTFB on shared hosting and sub-2s LCP on mainstream phones.</p>
          </div>
          <div class="card reveal">
            <span class="tag">Reliability</span>
            <h3>Zero-CDN lock-in</h3>
            <p>No external JS/CDN required. We ship self-hosted assets to avoid third‑party blocking and ensure deterministic builds.</p>
          </div>
          <div class="card reveal">
            <span class="tag">Conversion</span>
            <h3>Designed to close</h3>
            <p>Clear narrative, frictionless CTAs (WhatsApp, forms), and analytics events tied to real business outcomes.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- SERVICES -->
    <section id="services" class="section services">
      <div class="container">
        <h2 class="section__title reveal">Services</h2>
        <p class="section__lead reveal">Modular deliverables you can mix and match.</p>
        <div class="grid grid-3">
          <div class="card reveal">
            <div style="display:flex; align-items:center; gap:.6rem;">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 4h18v6H3z"></path><path d="M3 14h18v6H3z"></path><path d="M7 8h10"></path><path d="M7 18h5"></path></svg>
              <h3 style="margin:0">Web Experiences</h3>
            </div>
            <p>High-impact sites, landing pages, dashboards. Built with progressive enhancement and SEO best practices.</p>
          </div>
          <div class="card reveal">
            <div style="display:flex; align-items:center; gap:.6rem;">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20V10"></path><path d="M18 20V4"></path><path d="M6 20v-6"></path></svg>
              <h3 style="margin:0">UX + Motion</h3>
            </div>
            <p>Micro-interactions, parallax, and tasteful motion to increase engagement without tanking performance.</p>
          </div>
          <div class="card reveal">
            <div style="display:flex; align-items:center; gap:.6rem;">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>
              <h3 style="margin:0">Ops Acceleration</h3>
            </div>
            <p>Analytics, A/B scaffolding, and performance budgets baked in — so marketing and sales stay aligned.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- WORK / PORTFOLIO -->
    <section id="work" class="section work">
      <div class="container">
        <h2 class="section__title reveal">Selected work</h2>
        <p class="section__lead reveal">Realistic placeholders — swap in your case studies later.</p>
        <div class="grid grid-3" id="portfolioGrid">
          <!-- Portfolio Item Template (x6) -->
          <article class="item reveal" data-title="Interactive KPI Dashboard" data-tags="Dashboard, API, PWA" data-desc="A real-time technician dashboard with SLA timers, queue logic, and offline-ready PWA. Delivered a 28% faster triage time." onclick="openCase(this)">
            <div class="item__media" style="background: radial-gradient(1200px 300px at 0% 0%, rgba(56,189,248,.15), transparent), linear-gradient(135deg, rgba(255,255,255,.06), rgba(255,255,255,.02));">
              <span>Preview</span>
            </div>
            <div class="item__meta">
              <h4>Interactive KPI Dashboard</h4>
              <span class="chip">PWA</span>
            </div>
          </article>

          <article class="item reveal" data-title="3D Landing Experience" data-tags="WebGL, Motion" data-desc="Hybrid hero with canvas particles and scroll-driven story. Sub-2s LCP on shared hosting.">
            <div class="item__media" style="background: radial-gradient(600px 200px at 100% 0%, rgba(234,179,8,.15), transparent), linear-gradient(135deg, rgba(255,255,255,.06), rgba(255,255,255,.02));">
              <span>Preview</span>
            </div>
            <div class="item__meta">
              <h4>3D Landing Experience</h4>
              <span class="chip">WebGL-lite</span>
            </div>
          </article>

          <article class="item reveal" data-title="E‑Invoice Middleware" data-tags="Integration, SQL" data-desc="Middleware that bridges retailers and accountants via API with audit logs and role-based access.">
            <div class="item__media" style="background: radial-gradient(500px 220px at 0% 100%, rgba(56,189,248,.1), transparent), linear-gradient(135deg, rgba(255,255,255,.06), rgba(255,255,255,.02));">
              <span>Preview</span>
            </div>
            <div class="item__meta">
              <h4>E‑Invoice Middleware</h4>
              <span class="chip">API</span>
            </div>
          </article>

          <article class="item reveal" data-title="Helpdesk Kiosk App" data-tags="Kiosk, QR" data-desc="Counter-facing kiosk with sound prompts, QR receipts, and passcode auth.">
            <div class="item__media" style="background: radial-gradient(650px 200px at 100% 100%, rgba(56,189,248,.12), transparent), linear-gradient(135deg, rgba(255,255,255,.06), rgba(255,255,255,.02));">
              <span>Preview</span>
            </div>
            <div class="item__meta">
              <h4>Helpdesk Kiosk App</h4>
              <span class="chip">Kiosk</span>
            </div>
          </article>

          <article class="item reveal" data-title="Affiliate Insights" data-tags="Analytics" data-desc="Impact.com API ingestion with campaign-level attribution and PowerPoint-ready exports.">
            <div class="item__media" style="background: radial-gradient(500px 200px at 0% 50%, rgba(234,179,8,.12), transparent), linear-gradient(135deg, rgba(255,255,255,.06), rgba(255,255,255,.02));">
              <span>Preview</span>
            </div>
            <div class="item__meta">
              <h4>Affiliate Insights</h4>
              <span class="chip">GA4</span>
            </div>
          </article>

          <article class="item reveal" data-title="AR Length PWA" data-tags="Web AR" data-desc="Web-based AR measurement tool, mobile-first, installable as PWA.">
            <div class="item__media" style="background: radial-gradient(600px 200px at 50% 50%, rgba(56,189,248,.12), transparent), linear-gradient(135deg, rgba(255,255,255,.06), rgba(255,255,255,.02));">
              <span>Preview</span>
            </div>
            <div class="item__meta">
              <h4>AR Length PWA</h4>
              <span class="chip">AR</span>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- CONTACT -->
    <section id="contact" class="section contact">
      <div class="container">
        <h2 class="section__title reveal">Let’s build your next experience</h2>
        <p class="section__lead reveal">Prefer WhatsApp? Use the quick-start button above. Otherwise, drop your details and we’ll align on scope and timelines.</p>

        <div class="grid grid-2">
          <form class="card reveal" method="post" action="/contact.php" onsubmit="return submitForm(event)">
            <input type="text" name="_hp" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px;opacity:0" aria-hidden="true" />
            <div>
              <label for="name">Name</label>
              <input id="name" name="name" placeholder="Your name" required />
            </div>
            <div>
              <label for="email">Email</label>
              <input id="email" type="email" name="email" placeholder="you@example.com" required />
            </div>
            <div>
              <label for="company">Company</label>
              <input id="company" name="company" placeholder="Company (optional)" />
            </div>
            <div>
              <label for="message">Project Brief</label>
              <textarea id="message" name="message" placeholder="Tell us about goals, timeline, and budget range" required></textarea>
            </div>
            <button class="btn" type="submit">Send Inquiry</button>
            <small style="color:var(--muted)">By submitting, you agree to be contacted about this request.</small>
          </form>

          <div class="card reveal" aria-label="Contact details">
            <h3 style="margin-top:0">Direct contacts</h3>
            <p><strong>Navbright Technology Group Sdn Bhd</strong><br/>Malaysia</p>
            <p>WhatsApp: <a href="https://wa.me/60102899611" target="_blank" rel="noopener">+60 10-289 9611</a></p>
            <p>Email: <a href="mailto:hello@navbright.my">hello@navbright.my</a> (placeholder)</p>
            <hr style="border-color:var(--border)" />
            <p style="color:var(--muted)">We typically respond within 1 business day.</p>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <div class="container" style="display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap;">
      <div>© <span id="year"></span> Navbright Technology Group Sdn Bhd. All rights reserved.</div>
      <div style="display:flex; gap:.6rem; align-items:center;">
        <span class="tag">Static export</span>
        <span class="tag">SEO-ready</span>
        <span class="tag">No CDN</span>
      </div>
    </div>
  </footer>

  <!-- Case study modal using <dialog> -->
  <dialog id="caseModal" style="max-width: 860px; width: 92%; border: 1px solid var(--border); border-radius: 14px; background: var(--bg-elev); color: var(--text);">
    <form method="dialog" style="margin:0">
      <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; padding:1rem 1rem; border-bottom:1px solid var(--border);">
        <strong id="caseTitle">Case Title</strong>
        <button class="btn btn--ghost" value="close" aria-label="Close">Close</button>
      </div>
    </form>
    <div style="padding:1rem;">
      <div id="caseTags" style="margin-bottom:.6rem; display:flex; gap:.4rem; flex-wrap:wrap"></div>
      <p id="caseDesc" style="color:var(--muted);"></p>
    </div>
  </dialog>

  <script>
    // --- Canvas particles (no external libs) ---
    (function(){
      const c = document.getElementById('bg-canvas');
      if(!c || !c.getContext) return;
      const ctx = c.getContext('2d');
      // brand color helper from CSS variable --brand
      function brand(a){
        const hex = getComputedStyle(document.documentElement).getPropertyValue('--brand').trim().replace('#','');
        const r = parseInt(hex.slice(0,2),16) || 56;
        const g = parseInt(hex.slice(2,4),16) || 189;
        const b = parseInt(hex.slice(4,6),16) || 248;
        return 'rgba(' + r + ',' + g + ',' + b + ',' + a + ')';
      }
      let dpr = Math.min(window.devicePixelRatio || 1, 2);
      let w, h, particles, maxDist;

      function resize(){
        w = c.clientWidth; h = c.clientHeight; maxDist = Math.min(w, h) / 10;
        c.width = Math.floor(w * dpr); c.height = Math.floor(h * dpr);
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        init();
      }

      function init(){
        const count = Math.floor((w*h) / (window.innerWidth < 768 ? 9000 : 7000)); // adaptive density
        particles = new Array(count).fill(0).map(()=>({
          x: Math.random()*w, y: Math.random()*h,
          vx: (Math.random()-.5)*0.4, vy: (Math.random()-.5)*0.4,
          r: Math.random()*1.6 + 0.4
        }));
      }

      function step(){
        ctx.clearRect(0,0,w,h);
        // glow gradient
        const g = ctx.createRadialGradient(w*0.7,h*0.3,0, w*0.7,h*0.3, Math.max(w,h)*0.8);
        g.addColorStop(0,brand(0.06));
        g.addColorStop(1,brand(0));
        ctx.fillStyle = g; ctx.fillRect(0,0,w,h);

        // particles
        ctx.fillStyle = 'rgba(255,255,255,0.8)';
        for(let p of particles){
          p.x += p.vx; p.y += p.vy;
          if(p.x < -20) p.x = w+20; if(p.x > w+20) p.x = -20;
          if(p.y < -20) p.y = h+20; if(p.y > h+20) p.y = -20;
          ctx.beginPath(); ctx.arc(p.x, p.y, p.r, 0, Math.PI*2); ctx.fill();
        }
        // lines
        ctx.lineWidth = 1; ctx.strokeStyle = brand(0.15);
        for(let i=0;i<particles.length;i++){
          for(let j=i+1;j<particles.length;j++){
            const a = particles[i], b = particles[j];
            const dx = a.x-b.x, dy = a.y-b.y; const dist = Math.hypot(dx,dy);
            if(dist < maxDist){
              ctx.globalAlpha = 1 - (dist/maxDist);
              ctx.beginPath(); ctx.moveTo(a.x,a.y); ctx.lineTo(b.x,b.y); ctx.stroke();
              ctx.globalAlpha = 1;
            }
          }
        }
        requestAnimationFrame(step);
      }

      resize(); step();
      window.addEventListener('resize', resize, {passive:true});
    })();

    // --- Reveal on scroll ---
    (function(){
      const els = document.querySelectorAll('.reveal');
      const io = new IntersectionObserver((entries)=>{
        for(const e of entries){ if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target); } }
      }, { threshold: 0.15 });
      els.forEach(el=>io.observe(el));
    })();

    // --- Portfolio modal ---
    function openCase(card){
      const title = card.getAttribute('data-title');
      const tags = (card.getAttribute('data-tags')||'').split(',').map(s=>s.trim()).filter(Boolean);
      const desc = card.getAttribute('data-desc') || '';
      const dlg = document.getElementById('caseModal');
      document.getElementById('caseTitle').textContent = title;
      const tg = document.getElementById('caseTags'); tg.innerHTML = '';
      tags.forEach(t=>{ const span = document.createElement('span'); span.className='tag'; span.textContent=t; tg.appendChild(span); });
      document.getElementById('caseDesc').textContent = desc;
      if(typeof dlg.showModal === 'function') dlg.showModal(); else dlg.setAttribute('open','');
    }

    // --- Contact form (demo only) ---
    function submitForm(e){
      e.preventDefault();
      const data = Object.fromEntries(new FormData(e.target).entries());
      if(data._hp){ return false; } // honeypot
      alert('Thanks! This demo form is static. Wire it to /contact.php or a service.');
      e.target.reset();
      return false;
    }

    // Footer year
    document.getElementById('year').textContent = new Date().getFullYear();

    // --- Journey logic ---
    (function(){
      const journey = document.getElementById('journey');
      const bar = document.getElementById('progressBar');
      const chapters = Array.from(document.querySelectorAll('#journey .chapter'));
      if(!journey || !bar || !chapters.length) return;

      function updateProgress(){
        const top = journey.offsetTop - 80; // header offset
        const end = top + journey.offsetHeight - window.innerHeight;
        const y = window.scrollY;
        const p = Math.min(Math.max((y - top) / (end - top), 0), 1);
        bar.style.width = (p*100).toFixed(2) + '%';
      }
      updateProgress();
      window.addEventListener('scroll', updateProgress, {passive:true});
      window.addEventListener('resize', updateProgress, {passive:true});

      const io = new IntersectionObserver(entries=>{
        entries.forEach(e=>{
          if(e.isIntersecting){
            chapters.forEach(ch=>ch.classList.remove('is-active'));
            e.target.classList.add('is-active');
            const theme = e.target.getAttribute('data-theme');
            if(theme) document.body.setAttribute('data-theme', theme);
          }
        });
      }, { threshold: 0.6 });
      chapters.forEach(ch=>io.observe(ch));

      // initialize theme
      const firstTheme = chapters[0] && chapters[0].getAttribute('data-theme');
      if(firstTheme) document.body.setAttribute('data-theme', firstTheme);
    })();
  </script>

  <!-- Optional: JSON-LD (update with your legal name & URL) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Navbright Technology Group Sdn Bhd",
    "url": "https://www.navbright.my",
    "logo": "https://www.navbright.my/logo.svg",
    "sameAs": [
      "https://wa.me/60102899611"
    ]
  }
  </script>

  <!-- Analytics placeholder -->
  <!-- <script>/* GA4 or Plausible goes here */</script> -->
</body>
</html>
