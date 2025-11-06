<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>404 — Page not found</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;600;800&display=swap" rel="stylesheet">
  <style>
    :root{
      --bg:#0f1724;
      --card:#0b1220;
      --accent:#7dd3fc;
      --muted:#9ca3af;
      --glass: rgba(255,255,255,0.03);
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0;
      font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background:
        radial-gradient(1200px 600px at 10% 10%, rgba(125,211,252,0.06), transparent 8%),
        radial-gradient(800px 500px at 90% 90%, rgba(99,102,241,0.04), transparent 8%),
        var(--bg);
      color:#e6eef8;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:32px;
    }

    .card{
      width:100%;
      max-width:980px;
      background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
      border-radius:18px;
      padding:36px;
      box-shadow: 0 8px 30px rgba(2,6,23,0.6);
      display:grid;
      grid-template-columns: 1fr 420px;
      gap:28px;
      align-items:center;
      backdrop-filter: blur(6px);
      border: 1px solid rgba(255,255,255,0.03);
    }

    /* Responsive: stack */
    @media (max-width:880px){
      .card{ grid-template-columns: 1fr; padding:28px; gap:18px; }
      .scene{ order: -1; }
    }

    .content h1{
      margin:0 0 10px 0;
      font-size:48px;
      line-height:1;
      letter-spacing:-1px;
      font-weight:800;
      color: #fff;
    }
    .content p{
      margin:0 0 20px 0;
      color:var(--muted);
      font-size:16px;
    }
    .actions{
      display:flex;
      gap:12px;
      align-items:center;
      flex-wrap:wrap;
    }
    .btn{
      display:inline-flex;
      align-items:center;
      gap:10px;
      padding:12px 16px;
      border-radius:10px;
      text-decoration:none;
      font-weight:600;
      cursor:pointer;
      border: none;
      transition: transform .12s ease, box-shadow .12s ease;
    }
    .btn:active{ transform: translateY(1px); }
    .btn-primary{
      background: linear-gradient(90deg,var(--accent),#60a5fa);
      color:#062031;
      box-shadow: 0 6px 18px rgba(125,211,252,0.12);
    }
    .btn-ghost{
      background: transparent;
      border:1px solid rgba(255,255,255,0.04);
      color:var(--muted);
    }

    .meta{
      margin-top:10px;
      font-size:13px;
      color:var(--muted);
    }

    /* Illustration / Scene */
    .scene{
      display:flex;
      align-items:center;
      justify-content:center;
      padding:18px;
    }
    .illustration{
      width:100%;
      max-width:380px;
      aspect-ratio:1/1;
      display:grid;
      place-items:center;
      position:relative;
    }

    .big404{
      font-size:120px;
      font-weight:800;
      line-height:1;
      color: rgba(255,255,255,0.06);
      position:absolute;
      transform: translateY(-6px);
      user-select:none;
    }

    .robot {
      width:220px;
      height:220px;
      border-radius:18px;
      background: linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.01));
      display:flex;
      align-items:center;
      justify-content:center;
      position:relative;
      border: 1px solid rgba(255,255,255,0.04);
      box-shadow: 0 10px 25px rgba(2,6,23,0.6);
      transform-origin:center;
      animation: float 4s ease-in-out infinite;
    }

    @keyframes float{
      0%{ transform: translateY(0) }
      50%{ transform: translateY(-10px) }
      100%{ transform: translateY(0) }
    }

    .robot .face{
      width:160px;
      height:110px;
      border-radius:10px;
      background: linear-gradient(180deg,#061e2b,#09232f);
      display:flex;
      align-items:center;
      justify-content:center;
      flex-direction:column;
      gap:8px;
      padding:12px;
      box-shadow: inset 0 -6px 12px rgba(0,0,0,0.4);
    }
    .eye-row{ display:flex; gap:14px; align-items:center; }
    .eye{
      width:18px; height:18px; border-radius:50%;
      background: linear-gradient(180deg,#9be7ff,#5ec0f7);
      box-shadow: 0 4px 12px rgba(94,192,247,0.18), 0 0 16px rgba(94,192,247,0.08);
      animation: blink 3s infinite;
    }
    @keyframes blink{
      0%,96%,100%{ transform: scaleY(1) }
      97%,99%{ transform: scaleY(0.1) }
    }
    .mouth{
      width:70px; height:8px; border-radius:8px; background: rgba(255,255,255,0.06);
      box-shadow: 0 2px 6px rgba(0,0,0,0.5) inset;
    }

    /* small floating dots */
    .dot{
      position:absolute;
      width:8px; height:8px; border-radius:50%;
      background: rgba(125,211,252,0.08);
    }
    .dot.a{ top:6%; left:10%; transform:translate(-50%,-50%);}
    .dot.b{ bottom:12%; right:6%; transform:translate(50%,50%); width:10px; height:10px; }
    .dot.c{ top:18%; right:28%; width:6px; height:6px; }

    footer.foot{
      margin-top:18px;
      color:var(--muted);
      font-size:13px;
    }

    /* small accessibility focus */
    a:focus, button:focus{ outline: 3px solid rgba(125,211,252,0.14); outline-offset:3px; border-radius:8px; }
  </style>
</head>
<body>
  <main class="card" role="main" aria-labelledby="title">
    <section class="content">
      <h1 id="title">Oops — page not found</h1>
      <p>We couldn't find the page you're looking for. It may have been moved or deleted. Try the options below or go back to the homepage.</p>

      <div class="actions" role="navigation" aria-label="404 actions">
        <a class="btn btn-primary" href="<?=base_url()?>" title="Go to homepage">🏠 Go to Home</a>
        <button class="btn btn-ghost" id="backBtn" title="Go back in history">↩️ Go back</button>
      </div>

      <div class="meta" aria-hidden="false">
        Error code: <strong>404</strong> • If you think this is a mistake, contact the site admin.
      </div>

      <footer class="foot" aria-hidden="true">
        &copy; <span id="year"></span> Your Company — All rights reserved
      </footer>
    </section>

    <aside class="scene" aria-hidden="true">
      <div class="illustration" role="img" aria-label="Decorative 404 illustration">
        <div class="big404">404</div>

        <div class="robot" aria-hidden="true">
          <div class="face">
            <div class="eye-row">
              <div class="eye" style="animation-delay:0s"></div>
              <div class="eye" style="animation-delay:0.5s"></div>
            </div>
            <div class="mouth"></div>
          </div>
        </div>

        <div class="dot a"></div>
        <div class="dot b"></div>
        <div class="dot c"></div>
      </div>
    </aside>
  </main>

  <script>
    // Back button and year
    document.getElementById('year').textContent = new Date().getFullYear();
    document.getElementById('backBtn').addEventListener('click', function(){
      if (history.length > 1) history.back();
      else window.location.href = '/';
    });

    // Optional: send 404 status when serving server-side (example for frameworks)
    // If you integrate in server templates, ensure the HTTP status is set to 404.
  </script>
</body>
</html>
