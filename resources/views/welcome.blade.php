<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>KILANG PERTAMINA INTERNASIONAL REFINERY UNIT VI BALONGAN</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <style>
            :root {
                --bg: #FDFDFC;
                --fg: #1b1b18;
                --muted: #706f6c;
                --card: #ffffff;
                --ring: rgba(0,0,0,.08);
                --accent: #111114;
                --accent-2: #FF4433;
                --border: rgba(25,20,0,.21);
            }
            @media (prefers-color-scheme: dark) {
                :root {
                    --bg: #0a0a0a;
                    --fg: #EDEDEC;
                    --muted: #A1A09A;
                    --card: #161615;
                    --ring: rgba(255,255,255,.12);
                    --accent: #ffffff;
                    --accent-2: #FF750F;
                    --border: #3E3E3A;
                }
            }
            * { box-sizing: border-box; }
            html { scroll-behavior: smooth; }
            html, body { margin: 0; padding: 0; }
            body {
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, 'Helvetica Neue', Arial, 'Apple Color Emoji', 'Segoe UI Emoji';
                color: var(--fg);
                background: var(--bg);
            }
            .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
            .btn { appearance:none; border:0; cursor:pointer; font-weight:600; border-radius:10px; padding:10px 16px; }
            .btn-primary { background: var(--accent); color:#fff; }
            .btn-outline { background: transparent; color:#fff; box-shadow:0 0 0 1px rgba(255,255,255,.35) inset; }
            .btn-outline:hover { background: rgba(255,255,255,.08); }
            .btn-primary:hover { filter: brightness(1.06); }

            /* Header */
            .header { position:absolute; inset:0 auto auto 0; top:0; width:100%; z-index:20; }
            .nav { display:flex; align-items:center; justify-content:space-between; padding:18px 0; }
            .nav-center { position:absolute; left:50%; transform:translateX(-50%); display:none; gap:28px; color:#fff; font-size:14px; opacity:.95; }
            .nav-center a { color:inherit; text-decoration:none; }
            @media (min-width: 960px) { .nav-center { display:flex; } }

            /* Hero */
            .hero { position:relative; height:82vh; min-height:560px; background:url('/images/Kilang.png') center/cover no-repeat; }
            .hero::after { content:''; position:absolute; inset:0; background: linear-gradient(180deg, rgba(0,0,0,.55), rgba(0,0,0,.62)); }
            .hero-inner { position:relative; z-index:10; display:flex; align-items:center; justify-content:center; height:100%; text-align:center; color:#fff; padding:0 16px; }
            .kicker { letter-spacing:.35em; font-size:12px; opacity:.85; }
            .headline { margin-top:16px; font-weight:700; letter-spacing:.18em; font-size:44px; }
            @media (min-width: 960px) { .headline { font-size:64px; } }
            .sub { margin-top:12px; font-size:14px; opacity:.85; }
            .cta { margin-top:24px; display:flex; justify-content:center; gap:12px; }

            /* Cards */
            .section { padding:56px 0; }
            .grid { display:grid; gap:20px; }
            @media (min-width: 960px) { .grid-3 { grid-template-columns: repeat(3, minmax(0,1fr)); } }
            .card { background: var(--card); border-radius:16px; padding:24px; box-shadow:0 0 0 1px var(--ring); transition: all .2s ease; text-decoration:none; color:inherit; display:block; }
            .card:hover { box-shadow:0 0 0 1px var(--ring), 0 8px 26px rgba(0,0,0,.08); transform: translateY(-2px); }
            .card h4 { margin:8px 0 6px; font-weight:600; }
            .muted { color: var(--muted); font-size:14px; }

            /* Stats */
            .stats { display:grid; gap:20px; grid-template-columns: repeat(2, minmax(0,1fr)); }
            @media (min-width: 960px) { .stats { grid-template-columns: repeat(4, minmax(0,1fr)); } }
            .stat { background: var(--card); border-radius:14px; padding:22px; box-shadow:0 0 0 1px var(--ring); text-align:center; }
            .stat .num { font-size:28px; font-weight:700; }

            /* About */
            .about { display:grid; gap:24px; }
            @media (min-width: 960px) { .about { grid-template-columns: 1.1fr .9fr; align-items:center; } }
            .img-box { border-radius:16px; overflow:hidden; box-shadow:0 0 0 1px var(--ring); }
            .img-box img { width:100%; height:100%; object-fit:cover; }

            /* Footer CTA */
            .cta-band { background: var(--card); box-shadow: 0 0 0 1px var(--ring); border-radius:16px; padding:24px; display:flex; gap:16px; align-items:center; justify-content:space-between; flex-wrap:wrap; }
            
            /* Footer */
            body { padding-bottom: 56px; }
            .site-footer { position: fixed; left: 0; right: 0; bottom: 0; z-index: 40; background: var(--card); color: var(--muted); text-align: center; padding: 12px 0; box-shadow: 0 -1px 0 var(--ring); }
        </style>
    </head>
    <body>
        <header class="header">
            <div class="container nav">
                <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:12px;">
                    <img src="/images/logo-pertamina.png" alt="Pertamina" style="height:36px;filter: drop-shadow(0 1px 0 rgba(0,0,0,.25));">
                </a>
                <nav class="nav-center">
                    <a href="#home">Home</a>
                    <a href="#features">Features</a>
                    <a href="#about">About</a>
                </nav>
            @if (Route::has('login'))
                    <nav style="display:flex;gap:10px;">
                    @auth
                    @else
                            <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
                        @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                        @endif
                    @endauth
                </nav>
            @endif
            </div>
        </header>

        <section id="home" class="hero">
            <div class="hero-inner container">
                <div>
                    <div class="kicker">SELAMAT DATANG</div>
                    <a href="{{ auth()->check() ? url('/dashboard') : route('login') }}" class="headline" style="color:inherit; text-decoration:none;">CCTV MONITORING SYSTEM</a>
                    <div class="sub">PT KILANG PERTAMINA INTERNASIONAL REFINERY UNIT VI BALONGAN</div>
                    <div class="cta">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-primary">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline">Daftar</a>
                            @endif
                        @else
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary">Buka Dashboard</a>
                        @endguest
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="section" style="background:var(--card)">
            <div class="container">
                <div class="grid grid-3">
                    <a href="{{ auth()->check() ? route('user.locations') : route('login') }}" class="card">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor" style="color:var(--accent-2)"><path d="M4 5h16v10H4z" opacity=".2"/><path d="M2 3h20v14H2zm2 2v10h16V5zM4 19h16v2H4z"/></svg>
                        <h4>RTSP → HLS Otomatis</h4>
                        <p class="muted">FFmpeg mengonversi RTSP ke HLS, diputar langsung di browser.</p>
                    </a>
                    <a href="{{ auth()->check() ? route('user.maps') : route('login') }}" class="card">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor" style="color:var(--accent-2)"><path d="M3 11l6-6 6 6-6 6z" opacity=".2"/><path d="M21 10.59 12 1.59l-9 9L5.41 13 12 6.41 18.59 13zM3 21h18v2H3z"/></svg>
                        <h4>Peta Interaktif</h4>
                        <p class="muted">Leaflet + OSM/Satellite, filter status, cari gedung, buka live dari marker.</p>
                    </a>
                    <a href="{{ auth()->check() ? route('user.messages') : route('login') }}" class="card">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor" style="color:var(--accent-2)"><path d="M12 12a5 5 0 100-10 5 5 0 000 10z" opacity=".2"/><path d="M12 14c-4.418 0-8 2.239-8 5v1h16v-1c0-2.761-3.582-5-8-5z"/></svg>
                        <h4>Notifikasi & Pesan</h4>
                        <p class="muted">Login & pesan realtime sederhana Admin ↔ User untuk koordinasi cepat.</p>
                    </a>
                </div>

                <div class="section" style="padding-top:28px;">
                    @php($buildings = \App\Models\Building::count())
                    @php($rooms = \App\Models\Room::count())
                    @php($cctvs = \App\Models\Cctv::count())
                    @php($contacts = \App\Models\Contact::count())
                    <div class="stats">
                        <div class="stat"><div class="muted">BUILDINGS</div><div class="num" data-count="{{ $buildings }}">0</div></div>
                        <div class="stat"><div class="muted">ROOMS</div><div class="num" data-count="{{ $rooms }}">0</div></div>
                        <div class="stat"><div class="muted">CCTVS</div><div class="num" data-count="{{ $cctvs }}">0</div></div>
                        <div class="stat"><div class="muted">CONTACTS</div><div class="num" data-count="{{ $contacts }}">0</div></div>
                    </div>
                </div>
            </div>
        </section>

        <section id="about" class="section" style="background:var(--bg)">
            <div class="container about">
                <div>
                    <h3 style="margin:0 0 10px; font-weight:700;">Tentang Sistem</h3>
                    <p class="muted">Platform pemantauan CCTV untuk KILANG PERTAMINA INTERNASIONAL REFINERY UNIT VI BALONGAN dengan branding korporat, kontrol akses berbasis peran, ekspor data, dan UI modern.</p>
                    <ul style="margin:16px 0 0; padding-left:18px; line-height:1.8;">
                        <li>Streaming HLS otomatis (FFmpeg)</li>
                        <li>Peta Leaflet (OSM + Satellite)</li>
                        <li>Notifikasi & pesan realtime</li>
                        <li>Ekspor data ke XLSX</li>
                    </ul>
                </div>
                <a href="{{ auth()->check() ? route('user.maps') : route('login') }}" class="img-box" style="display:block;">
                    <img src="/images/kilang1.jpg" alt="Refinery Unit VI Balongan">
                </a>
        </div>
        </section>

        <footer class="site-footer">
            &copy; 2025 Kilang Pertamina Internasional Refinery Unit VI Balongan
        </footer>

        <script>
            // simple counter animation
            document.querySelectorAll('.num[data-count]').forEach(el => {
                const target = parseInt(el.getAttribute('data-count') || '0', 10);
                const duration = 900;
                const start = performance.now();
                function tick(ts){
                    const p = Math.min(1, (ts - start)/duration);
                    el.textContent = Math.floor(target * (0.2 + 0.8*p)).toLocaleString();
                    if (p < 1) requestAnimationFrame(tick);
                }
                requestAnimationFrame(tick);
            });
        </script>
    </body>
    
</html>


