<x-layouts.app title="Maps">
   
    <div class="p-6 space-y-3">
        <h1 class="text-2xl font-semibold tracking-tight">Maps Live CCTV</h1>
        <div class="fixed top-3 right-4 z-[120]">
            <span class="last-3d">Last update: <span id="lastUpdatedTop">-</span></span>
        </div>
        <div class="glass-3d rounded-xl p-3 flex flex-wrap items-center gap-3 gap-y-2 relative z-[90]">
            <span class="text-sm">Filter:</span>
            <button data-status="online" class="filter-dot size-6 rounded-full border-2 border-black/10 ring-2 ring-white/50" style="background:#16a34a" title="Online"></button>
            <span id="count-online" class="badge-3d">0</span>
            <button data-status="offline" class="filter-dot size-6 rounded-full border-2 border-black/10 ring-2 ring-white/50" style="background:#dc2626" title="Offline"></button>
            <span id="count-offline" class="badge-3d">0</span>
            <button data-status="maintenance" class="filter-dot size-6 rounded-full border-2 border-black/10 ring-2 ring-white/50" style="background:#eab308" title="Maintenance"></button>
            <span id="count-maintenance" class="badge-3d">0</span>
            <button data-status="all" class="px-3 py-1 rounded-full bg-zinc-900 text-white text-sm">Semua</button>
            <span id="count-all" class="text-xs text-zinc-500">0</span>
            <div class="ml-auto flex items-center gap-2 w-full sm:w-auto justify-between sm:justify-end flex-wrap sm:flex-nowrap">
                <span class="text-sm">Layer:</span>
                <input type="hidden" id="layerToggle" value="osm">
                <div id="ddLayer" class="dd-3d z-[95]">
                    <button type="button" class="dd-btn">Open Street Map</button>
                    <div class="dd-menu" hidden>
                        <button class="dd-item" data-value="osm">Open Street Map</button>
                        <button class="dd-item" data-value="satellite">Satellite</button>
                    </div>
                </div>
                <div class="relative" id="searchWrap">
                    <input id="searchBox" list="buildingList" placeholder="Cari gedung..." class="input-3d w-[220px] sm:w-[260px]" />
                    <div id="searchPanel" class="search-panel-3d" hidden></div>
                </div>
                <datalist id="buildingList">
                    @foreach(\App\Models\Building::orderBy('name')->get() as $b)
                        <option value="{{ $b->name }}"></option>
                    @endforeach
                </datalist>
                <button id="searchBtn" class="btn-3d-primary text-sm flex items-center gap-2">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="white" stroke-width="2"/><path d="M20 20l-3.5-3.5" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                    <span>Pencarian</span>
                </button>
                <button id="resetBtn" class="btn-3d-neutral text-sm">Reset View</button>
            </div>
        </div>
        <div class="glass-3d rounded-xl p-3 flex flex-wrap items-center gap-2 gap-y-2 hidden">
            <span class="ml-auto text-xs text-zinc-600">Last update: <span id="lastUpdated">-</span></span>
        </div>
        <div id="map" style="height: clamp(340px, 65vh, 720px)" class="rounded-xl overflow-hidden border border-neutral-200 dark:border-neutral-700 glass-3d"></div>
    </div>

    <div id="playerModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-zinc-900 rounded-xl w-full max-w-3xl p-4">
            <div class="flex items-center justify-between mb-2">
                <h3 id="playerTitle" class="text-lg font-semibold">Live CCTV</h3>
                <button id="playerClose" class="px-3 py-1 rounded-md bg-zinc-900 text-white dark:bg-white dark:text-black">Close</button>
            </div>
            <video id="hlsPlayer" controls playsinline class="w-full rounded-lg bg-black" style="aspect-ratio:16/9"></video>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" crossorigin="" />
    <style>
        .cluster-wrapper{ filter: drop-shadow(0 8px 18px rgba(0,0,0,.25)); }
        .cluster-badge{ width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;border:2px solid rgba(255,255,255,.7); }
        .cluster-green{ background: linear-gradient(180deg,#34d399,#059669); }
        .cluster-red{ background: linear-gradient(180deg,#fb7185,#dc2626); }
        .cluster-yellow{ background: linear-gradient(180deg,#fbbf24,#d97706); }

        /* 3D glass popup */
        .leaflet-popup-content-wrapper{
            background: rgba(17,17,17,.78);
            color:#fff;
            border-radius: 14px;
            backdrop-filter: blur(10px);
            box-shadow: 0 14px 28px rgba(0,0,0,.35), inset 0 1px 0 rgba(255,255,255,.08);
        }
        .leaflet-popup-tip{ background: rgba(17,17,17,.78); }
        .leaflet-container a{ color:#60a5fa; }

        /* 3D zoom controls */
        .leaflet-control-zoom a{
            background: linear-gradient(180deg, rgba(255,255,255,.85), rgba(255,255,255,.6));
            border: 1px solid rgba(0,0,0,.08);
            box-shadow: 0 6px 16px rgba(0,0,0,.18), inset 0 1px 0 rgba(255,255,255,.8);
            border-radius: 10px!important;
        }
        .leaflet-control-zoom a:hover{ transform: translateY(-1px); box-shadow: 0 10px 20px rgba(0,0,0,.22), inset 0 1px 0 rgba(255,255,255,.9); }

        /* 3D markers */
        .mk{ display:inline-block; width:14px; height:14px; border-radius:50%; border:2px solid rgba(0,0,0,.12); box-shadow: 0 8px 16px rgba(0,0,0,.25), inset 0 1px 0 rgba(255,255,255,.6); }
        .mk-green{ background: radial-gradient(circle at 30% 30%, #86efac, #16a34a); }
        .mk-red{ background: radial-gradient(circle at 30% 30%, #fca5a5, #dc2626); }
        .mk-yellow{ background: radial-gradient(circle at 30% 30%, #fde68a, #d97706); }

        .mkb{ display:inline-block; width:16px; height:16px; border-radius:4px; border:2px solid rgba(0,0,0,.12); background: radial-gradient(circle at 30% 30%, #93c5fd, #3b82f6); box-shadow: 0 10px 20px rgba(0,0,0,.25), inset 0 1px 0 rgba(255,255,255,.7); }
        .popup-center{ text-align:center; }
        .popup-center b{ display:block; font-size:14px; margin-bottom:4px; }
        .popup-center .btn-3d-primary, .popup-center .btn-3d-success{ display:inline-block; }

        /* Online pulse */
        @keyframes pulse-ring { 0%{ box-shadow: 0 0 0 0 rgba(16,185,129,.45);} 70%{ box-shadow: 0 0 0 10px rgba(16,185,129,0);} 100%{ box-shadow: 0 0 0 0 rgba(16,185,129,0);} }
        .mk-online{ position: relative; }
        .mk-online::after{ content:""; position:absolute; inset:-4px; border-radius:9999px; animation: pulse-ring 1.8s ease-out infinite; }

        /* Floating 3D map buttons */
        .leaflet-control.map-actions { background: transparent; box-shadow:none; }
        .map-actions .wrap{ display:flex; gap:8px; padding:6px; border-radius:12px; background: rgba(17,17,17,.55); backdrop-filter: blur(8px); box-shadow: 0 12px 24px rgba(0,0,0,.35); }
        .map-btn{ display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:10px; color:#fff; font-size:14px; font-weight:700; border:1px solid rgba(255,255,255,.2); box-shadow: inset 0 1px 0 rgba(255,255,255,.2), 0 10px 20px rgba(0,0,0,.3); transition: transform .15s ease, box-shadow .15s ease; }
        .map-btn:hover{ transform: translateY(-1px); box-shadow: inset 0 1px 0 rgba(255,255,255,.3), 0 14px 28px rgba(0,0,0,.35); }
        .btn-blue{ background: linear-gradient(180deg,#60a5fa,#2563eb); }
        .btn-green{ background: linear-gradient(180deg,#34d399,#059669); }
        .btn-amber{ background: linear-gradient(180deg,#fbbf24,#d97706); }
        .btn-zinc{ background: linear-gradient(180deg,#9ca3af,#4b5563); }

        /* Back to building chip */
        .map-chip{ display:flex; align-items:center; gap:8px; padding:0; background:transparent; box-shadow:none; }
        .chip-btn{ padding:8px 14px; border-radius:8px; background:linear-gradient(180deg,#60a5fa,#2563eb); color:#fff; border:1px solid rgba(255,255,255,.2); box-shadow: inset 0 1px 0 rgba(255,255,255,.25), 0 8px 16px rgba(0,0,0,.3); cursor:pointer; font-weight:700; text-shadow:0 1px 0 rgba(0,0,0,.25); }

        /* Custom 3D dropdown */
        .dd-3d{ position:relative; display:inline-block; }
        .dd-btn{ display:flex; align-items:center; justify-content:space-between; gap:10px; min-width:180px; padding:6px 10px; border-radius:10px; font-size:14px; background: linear-gradient(180deg, rgba(255,255,255,.92), rgba(255,255,255,.78)); border:1px solid rgba(0,0,0,.08); box-shadow: inset 0 1px 0 rgba(255,255,255,.85), 0 8px 18px rgba(0,0,0,.08); }
        .dd-btn::after{ content:""; width:14px; height:14px; mask: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>') no-repeat center/contain; background:#000; opacity:.8; }
        .dark .dd-btn{ background: linear-gradient(180deg, rgba(24,24,27,.95), rgba(24,24,27,.85)); border-color: rgba(255,255,255,.08); box-shadow: inset 0 1px 0 rgba(255,255,255,.06), 0 10px 22px rgba(0,0,0,.45); color:#fff; }
        .dark .dd-btn::after{ background:#fff; }
        .dd-menu{ position:absolute; inset-inline:0; top:calc(100% + 6px); z-index:60; background:linear-gradient(180deg, rgba(255,255,255,.96), rgba(255,255,255,.88)); border:1px solid rgba(0,0,0,.08); border-radius:12px; padding:6px; box-shadow: 0 16px 32px rgba(0,0,0,.18); max-height:260px; overflow:auto; }
        .dark .dd-menu{ background: linear-gradient(180deg, rgba(24,24,27,.98), rgba(24,24,27,.9)); border-color: rgba(255,255,255,.08); box-shadow: 0 20px 38px rgba(0,0,0,.6); }
        .dd-item{ display:block; width:100%; text-align:left; padding:8px 10px; border-radius:8px; font-size:14px; }
        .dd-item:hover{ background: rgba(59,130,246,.12); }
        .dark .dd-item:hover{ background: rgba(59,130,246,.18); }

        /* 3D badges for counts */
        .badge-3d{ display:inline-block; min-width:22px; padding:2px 8px; border-radius:9999px; background:linear-gradient(180deg, rgba(255,255,255,.95), rgba(255,255,255,.8)); color:#111; font-weight:700; font-size:12px; border:1px solid rgba(0,0,0,.08); box-shadow: inset 0 1px 0 rgba(255,255,255,.9), 0 6px 14px rgba(0,0,0,.15); text-align:center; }
        .dark .badge-3d{ background:linear-gradient(180deg, rgba(24,24,27,.95), rgba(24,24,27,.85)); color:#fff; border-color:rgba(255,255,255,.08); box-shadow: inset 0 1px 0 rgba(255,255,255,.08), 0 10px 18px rgba(0,0,0,.5); }

        /* Search dropdown 3D */
        .search-panel-3d{ position:absolute; left:0; right:0; top:calc(100% + 6px); z-index:70; border-radius:12px; padding:6px; background:linear-gradient(180deg, rgba(255,255,255,.96), rgba(255,255,255,.88)); border:1px solid rgba(0,0,0,.08); box-shadow: 0 16px 32px rgba(0,0,0,.18); max-height:260px; overflow:auto; }
        .dark .search-panel-3d{ background:linear-gradient(180deg, rgba(24,24,27,.98), rgba(24,24,27,.9)); border-color:rgba(255,255,255,.08); box-shadow:0 20px 38px rgba(0,0,0,.6); }
        .search-option{ display:flex; align-items:center; gap:8px; padding:8px 10px; border-radius:10px; cursor:pointer; }
        .search-option:hover{ background:rgba(59,130,246,.12); }
        .dark .search-option:hover{ background:rgba(59,130,246,.18); }

        /* Last update chip */
        .last-3d{ display:inline-block; padding:6px 10px; border-radius:10px; background:linear-gradient(180deg, rgba(17,17,17,.85), rgba(17,17,17,.7)); color:#fff; font-size:12px; border:1px solid rgba(255,255,255,.08); box-shadow: inset 0 1px 0 rgba(255,255,255,.06), 0 8px 18px rgba(0,0,0,.35); }
    </style>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@1"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const SETTINGS_KEY = 'mapsSettingsV1';
            const defaultCenter = [-6.401, 108.369];
            const map = L.map('map', { maxZoom: 20, minZoom: 3 }).setView(defaultCenter, 15);
            const cctvCluster = L.markerClusterGroup({
                chunkedLoading: true,
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: false,
                disableClusteringAtZoom: 19,
                maxClusterRadius: 45,
                iconCreateFunction: (cluster) => {
                    const children = cluster.getAllChildMarkers();
                    let on=0, off=0, mnt=0;
                    children.forEach(m => {
                        const s = (m.options && m.options.cctvStatus) || 'maintenance';
                        if (s === 'online') on++; else if (s === 'offline') off++; else mnt++;
                    });
                    let dom = 'yellow';
                    if (on >= off && on >= mnt) dom = 'green';
                    else if (off >= on && off >= mnt) dom = 'red';
                    const html = `<div class="cluster-badge cluster-${dom}"><span>${cluster.getChildCount()}</span></div>`;
                    return L.divIcon({ html, className: 'cluster-wrapper', iconSize: L.point(40,40) });
                }
            }).addTo(map);

            const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            const satellite = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains:['mt0','mt1','mt2','mt3']
            });

            const markers = [];
            const buildingMarkers = new Map();
            let activeFilters = new Set(['online','offline','maintenance']);
            let selectedBuildingId = '';
            let lastData = [];

            const elOnline = document.getElementById('count-online');
            const elOffline = document.getElementById('count-offline');
            const elMaint = document.getElementById('count-maintenance');
            const elAll = document.getElementById('count-all');
            const elLastUpdated = document.getElementById('lastUpdatedTop');

            async function loadMarkers() {
                if (!document.getElementById('map')) { if (pollId) clearInterval(pollId); return; }
                const res = await fetch('{{ route('api.cctvs') }}');
                const data = await res.json();
                lastData = data;

                // clear CCTV markers only (keep building markers)
                try { cctvCluster.clearLayers(); } catch(_) {}
                markers.length = 0; // legacy array for counts only

                // group by building for building marker & zoom behavior
                const byBuilding = {};
                data.forEach(item => {
                    const key = item.building_id || 'other';
                    if (!byBuilding[key]) byBuilding[key] = [];
                    byBuilding[key].push(item);
                });

                // place building markers once
                Object.entries(byBuilding).forEach(([bid, items]) => {
                    const sample = items.find(i => i.lat && i.lng);
                    if (!sample) return;
                    if (!buildingMarkers.has(bid)) {
                        const icon = L.divIcon({
                            className: 'custom-marker',
                            html: `<span class="mkb"></span>`,
                            iconSize: [16,16], iconAnchor:[8,8]
                        });
                        const roomsBtn = bid !== 'other' ? `<div class="mt-2 flex justify-center"><a href="/user/locations/${bid}" class="btn-3d-primary">Rooms</a></div>` : '';
                        const bm = L.marker([sample.lat, sample.lng], { icon }).addTo(map)
                            .bindTooltip(items[0].building_name || 'Building')
                            .bindPopup(`<div class="popup-center" style="min-width:240px"><b>${items[0].building_name || 'Building'}</b>${roomsBtn}<div class="text-xs opacity-80 mt-1">Tap marker to focus this building</div></div>`);
                        bm.on('click', () => {
                            map.setView([sample.lat, sample.lng], 18);
                            // Sync building filter with clicked marker
                            selectedBuildingId = String(bid);
                            const bf = document.getElementById('buildingFilter'); if (bf) bf.value = selectedBuildingId;
                            dropCctvMarkers(items);
                            saveSettings();
                        });
                        buildingMarkers.set(bid, bm);
                    }
                });

                const filtered = selectedBuildingId ? data.filter(d => String(d.building_id||'') === String(selectedBuildingId)) : data;
                dropCctvMarkers(filtered);

                // counts
                const online = data.filter(d => d.status==='online').length;
                const offline = data.filter(d => d.status==='offline').length;
                const maintenance = data.filter(d => d.status==='maintenance').length;
                const all = data.length;
                if (elOnline) elOnline.textContent = online;
                if (elOffline) elOffline.textContent = offline;
                if (elMaint) elMaint.textContent = maintenance;
                if (elAll) elAll.textContent = all;

                if (elLastUpdated) elLastUpdated.textContent = new Date().toLocaleTimeString();
            }

            function dropCctvMarkers(list) {
                try { cctvCluster.clearLayers(); } catch(_) {}
                markers.length = 0;
                list.forEach(item => {
                    if (!item.lat || !item.lng) return;
                    if (!activeFilters.has(item.status)) return;
                    const color = item.status === 'online' ? 'green' : (item.status === 'offline' ? 'red' : 'yellow');
                    const icon = L.divIcon({
                        className: 'custom-marker',
                        html: `<span class="mk mk-${color} ${item.status==='online' ? 'mk-online' : ''}"></span>`,
                        iconSize: [14,14], iconAnchor:[7,7]
                    });
                    const marker = L.marker([item.lat, item.lng], { icon, cctvStatus: item.status })
                        .bindPopup(`
                            <div class="popup-center" style="min-width:240px">
                                <b>${item.name}</b>
                                <div>Gedung: ${item.building_name ?? '-'}</div>
                                <div>Ruangan: ${item.room_name ?? '-'}</div>
                                <div>Status: ${item.status}</div>
                                <div class="mt-2 flex flex-wrap gap-2 justify-center">
                                    <button data-id="${item.id}" data-name="${item.name}" class="open-live btn-3d-success">Live CCTV</button>
                                </div>
                            </div>
                        `);
                    marker.on('popupopen', (e) => {
                        const btn = e.popup.getElement().querySelector('.open-live');
                        if (btn) btn.addEventListener('click', () => openLive(item));
                    });
                    markers.push(marker);
                    cctvCluster.addLayer(marker);
                });

                // auto-fit to visible markers
                if (markers.length) {
                    try { map.fitBounds(cctvCluster.getBounds().pad(0.15), { animate: true }); } catch(_) {}
                }
            }

            function openLive(item) {
                const ipval = item.ip_address || item.ip || '';
                let host = ipval;
                try { host = (new URL(ipval)).hostname || ipval; } catch (_) {}
                const safe = host.replaceAll('.', '_').replaceAll(':','_').replaceAll('@','_');
                const src = `/live/${safe}.m3u8`;
                const modal = document.getElementById('playerModal');
                const title = document.getElementById('playerTitle');
                const video = document.getElementById('hlsPlayer');
                title.textContent = `Live CCTV - ${item.name}`;
                if (Hls.isSupported()) {
                    const hls = new Hls();
                    hls.loadSource(src);
                    hls.attachMedia(video);
                    hls.on(Hls.Events.MANIFEST_PARSED, function() { video.play(); });
                    video._hls = hls;
                } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                    video.src = src;
                    video.play();
                } else {
                    video.innerHTML = 'HLS not supported in this browser.';
                }
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            document.getElementById('playerClose').addEventListener('click', () => {
                const modal = document.getElementById('playerModal');
                const video = document.getElementById('hlsPlayer');
                if (video._hls) { video._hls.destroy(); }
                video.pause();
                video.removeAttribute('src');
                video.load();
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });

            loadMarkers();
            // Invalidate size on resize (debounced) for responsiveness
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => { try { map.invalidateSize(); } catch(_) {} }, 150);
            });
            let pollId = setInterval(loadMarkers, 5000);
            window.addEventListener('beforeunload', () => { if (pollId) clearInterval(pollId); });

            document.querySelectorAll('[data-status]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const s = btn.dataset.status;
                    if (s === 'all') {
                        activeFilters = new Set(['online','offline','maintenance']);
                        document.querySelectorAll('.filter-dot').forEach(d => d.classList.add('ring-2'));
                    } else {
                        if (activeFilters.has(s)) {
                            activeFilters.delete(s);
                            btn.classList.remove('ring-2');
                        } else {
                            activeFilters.add(s);
                            btn.classList.add('ring-2');
                        }
                        if (activeFilters.size === 0) {
                            activeFilters = new Set(['online','offline','maintenance']);
                            document.querySelectorAll('.filter-dot').forEach(d => d.classList.add('ring-2'));
                        }
                    }
                    loadMarkers();
                });
            });

            document.getElementById('searchBtn').addEventListener('click', async () => {
                const q = document.getElementById('searchBox').value.toLowerCase();
                const res = await fetch('{{ route('api.buildings') }}');
                const data = await res.json();
                const hit = data.find(d => (d.name || '').toLowerCase().includes(q));
                if (hit && hit.lat && hit.lng) {
                    map.setView([hit.lat, hit.lng], 17);
                    // set selected building id by name match
                    selectedBuildingId = String(hit.id || '');
                    dropCctvMarkers(selectedBuildingId ? lastData.filter(d => String(d.building_id||'') === String(selectedBuildingId)) : lastData);
                    saveSettings();
                    updateChip();
                }
            });

            // live suggest panel
            const searchInput = document.getElementById('searchBox');
            const panel = document.getElementById('searchPanel');
            let suggestTimer;
            searchInput.addEventListener('input', () => {
                clearTimeout(suggestTimer);
                const term = (searchInput.value || '').toLowerCase();
                if (!term) { panel.innerHTML = ''; panel.setAttribute('hidden',''); return; }
                suggestTimer = setTimeout(async () => {
                    const res = await fetch('{{ route('api.buildings') }}');
                    const items = await res.json();
                    const list = items.filter(b => (b.name||'').toLowerCase().includes(term)).slice(0,8);
                    if (!list.length) { panel.innerHTML = ''; panel.setAttribute('hidden',''); return; }
                    panel.innerHTML = list.map(b => `<div class="search-option" data-id="${b.id}" data-lat="${b.lat}" data-lng="${b.lng}"><span class="mkb"></span><span>${b.name}</span></div>`).join('');
                    panel.removeAttribute('hidden');
                }, 180);
            });
            document.getElementById('searchWrap').addEventListener('click', (e) => {
                const opt = e.target.closest('.search-option');
                if (!opt) return;
                const lat = parseFloat(opt.dataset.lat), lng = parseFloat(opt.dataset.lng);
                if (!isNaN(lat) && !isNaN(lng)) map.setView([lat, lng], 17);
                selectedBuildingId = String(opt.dataset.id || '');
                dropCctvMarkers(selectedBuildingId ? lastData.filter(d => String(d.building_id||'') === String(selectedBuildingId)) : lastData);
                saveSettings();
                updateChip();
                panel.setAttribute('hidden','');
            });

            // 3D dropdown wiring
            function wireDropdown(rootId, hiddenInputId, onChange) {
                const root = document.getElementById(rootId);
                const hidden = document.getElementById(hiddenInputId);
                if (!root || !hidden) return;
                const btn = root.querySelector('.dd-btn');
                const menu = root.querySelector('.dd-menu');
                btn.addEventListener('click', () => {
                    const isOpen = !menu.hasAttribute('hidden');
                    document.querySelectorAll('.dd-menu').forEach(m => m.setAttribute('hidden', ''));
                    if (!isOpen) menu.removeAttribute('hidden');
                });
                root.addEventListener('click', (e) => {
                    const item = e.target.closest('.dd-item');
                    if (!item) return;
                    const val = item.dataset.value || '';
                    hidden.value = val;
                    btn.textContent = item.textContent;
                    menu.setAttribute('hidden', '');
                    onChange?.(val);
                });
                document.addEventListener('click', (e) => { if (!root.contains(e.target)) menu.setAttribute('hidden', ''); });
            }

            wireDropdown('ddLayer', 'layerToggle', (val) => {
                if (val === 'osm') { map.addLayer(osm); map.removeLayer(satellite); }
                else { map.addLayer(satellite); map.removeLayer(osm); }
                saveSettings();
            });

            wireDropdown('ddBuilding', 'buildingFilter', (val) => {
                selectedBuildingId = val || '';
                const filtered = selectedBuildingId ? lastData.filter(d => String(d.building_id||'') === String(selectedBuildingId)) : lastData;
                dropCctvMarkers(filtered);
                saveSettings();
                updateChip();
            });

            document.getElementById('resetBtn').addEventListener('click', () => {
                map.setView(defaultCenter, 15);
                selectedBuildingId = '';
                const bf = document.getElementById('buildingFilter'); if (bf) bf.value = '';
                activeFilters = new Set(['online','offline','maintenance']);
                document.querySelectorAll('.filter-dot').forEach(d => d.classList.add('ring-2'));
                dropCctvMarkers(lastData);
                saveSettings();
            });

            // remove native change handler (replaced by custom dropdown)

            // Legend control
            const legend = L.control({position:'topright'});
            legend.onAdd = function(){
                const div = L.DomUtil.create('div');
                div.style.zIndex = 40;
                div.innerHTML = '<div style="padding:6px 8px;border-radius:10px;background:rgba(0,0,0,.35);backdrop-filter:blur(6px);color:#fff;box-shadow:0 8px 18px rgba(0,0,0,.25);font-size:12px">' +
                    '<div style="display:flex;align-items:center;gap:6px"><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:green;border:2px solid #0002"></span>Online</div>'+
                    '<div style="display:flex;align-items:center;gap:6px"><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:red;border:2px solid #0002"></span>Offline</div>'+
                    '<div style="display:flex;align-items:center;gap:6px"><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:yellow;border:2px solid #0002"></span>Maintenance</div>'+
                    '</div>';
                return div;
            };
            legend.addTo(map);

            // Floating controls (Fit, Reset, Locate, Fullscreen)
            const actions = L.control({position:'bottomright'});
            actions.onAdd = function(){
                const wrap = L.DomUtil.create('div', 'map-actions');
                wrap.innerHTML = `<div class="wrap">
                    <button title="Fit markers" class="map-btn btn-blue" data-action="fit" aria-label="Fit">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 9V4h5M15 4h5v5M20 15v5h-5M9 20H4v-5" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                    </button>
                    <button title="Reset view" class="map-btn btn-zinc" data-action="reset" aria-label="Reset">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12a9 9 0 1 0 3-6.708V8" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                    </button>
                    <button title="My location" class="map-btn btn-green" data-action="loc" aria-label="Locate">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="3" stroke="white" stroke-width="2"/><path d="M12 3v2m0 14v2m9-9h-2M5 12H3" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                    </button>
                    <button title="Fullscreen" class="map-btn btn-amber" data-action="fs" aria-label="Fullscreen">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 3H3v5M21 8V3h-5M16 21h5v-5M3 16v5h5" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                    </button>
                </div>`;
                L.DomEvent.disableClickPropagation(wrap);
                return wrap;
            };
            actions.addTo(map);

            function fitToCurrent(){ try { if (cctvCluster.getLayers().length) map.fitBounds(cctvCluster.getBounds().pad(0.15), { animate:true }); } catch(_) {} }
            document.querySelector('.map-actions')?.addEventListener('click', (e)=>{
                const btn = e.target.closest('[data-action]'); if (!btn) return;
                const a = btn.getAttribute('data-action');
                if (a==='fit') fitToCurrent();
                if (a==='reset') { selectedBuildingId=''; const bf=document.getElementById('buildingFilter'); if (bf) bf.value=''; map.setView(defaultCenter,15); dropCctvMarkers(lastData); saveSettings(); updateChip(); }
                if (a==='loc') { if (navigator.geolocation) { navigator.geolocation.getCurrentPosition(p=>{ map.setView([p.coords.latitude,p.coords.longitude], 18); }); } }
                if (a==='fs') { const el=document.getElementById('map'); if (el && !document.fullscreenElement) { el.requestFullscreen?.(); } else { document.exitFullscreen?.(); } }
            });

            // Back-to-building chip
            const chipCtl = L.control({position:'topleft'});
            chipCtl.onAdd = function(){ const d = L.DomUtil.create('div','map-chip'); d.style.display='none'; d.innerHTML = '<span id="chipLabel">Building</span><button class="chip-btn" data-chip="clear">Back</button>'; L.DomEvent.disableClickPropagation(d); return d; };
            chipCtl.addTo(map);

            function updateChip(){
                const el = document.querySelector('.map-chip'); if (!el) return;
                if (!selectedBuildingId){ el.style.display='none'; return; }
                let name = '';
                const hit = lastData.find(d => String(d.building_id||'') === String(selectedBuildingId));
                name = hit?.building_name || 'Building';
                el.querySelector('#chipLabel').textContent = 'Building: ' + name;
                el.style.display='flex';
            }
            document.querySelector('.map-chip')?.addEventListener('click', (e)=>{
                const btn = e.target.closest('[data-chip="clear"]'); if (!btn) return;
                selectedBuildingId=''; const bf=document.getElementById('buildingFilter'); if (bf) bf.value=''; dropCctvMarkers(lastData); saveSettings(); updateChip();
            });

            function getFilteredVisible() {
                const bounds = map.getBounds();
                const base = selectedBuildingId ? lastData.filter(d => String(d.building_id||'') === String(selectedBuildingId)) : lastData;
                return base.filter(d => activeFilters.has(d.status) && d.lat && d.lng && bounds.contains([d.lat, d.lng]));
            }

            // exportCSV removed for user maps as per request; available in admin only

            function saveSettings() {
                const settings = {
                    c: map.getCenter(), z: map.getZoom(),
                    layer: document.getElementById('layerToggle').value,
                    b: selectedBuildingId,
                    filters: Array.from(activeFilters),
                };
                try { localStorage.setItem(SETTINGS_KEY, JSON.stringify(settings)); } catch(_) {}
            }

            function restoreSettings() {
                try {
                    const raw = localStorage.getItem(SETTINGS_KEY); if (!raw) return;
                    const s = JSON.parse(raw);
                    if (s.c && typeof s.z === 'number') map.setView([s.c.lat, s.c.lng], s.z);
                    if (s.layer) {
                        const lt = document.getElementById('layerToggle'); if (lt) lt.value = s.layer; lt.dispatchEvent(new Event('change'));
                    }
                    if (s.b) { selectedBuildingId = String(s.b); const bf = document.getElementById('buildingFilter'); if (bf) bf.value = selectedBuildingId; }
                    if (Array.isArray(s.filters)) {
                        activeFilters = new Set(s.filters);
                        document.querySelectorAll('.filter-dot').forEach(btn => {
                            btn.classList.toggle('ring-2', activeFilters.has(btn.dataset.status));
                        });
                    }
                    dropCctvMarkers(selectedBuildingId ? lastData.filter(d => String(d.building_id||'') === String(selectedBuildingId)) : lastData);
                } catch(_) {}
            }

            map.on('moveend zoomend', saveSettings);
            document.getElementById('layerToggle').addEventListener('change', saveSettings);
            document.querySelectorAll('.filter-dot, [data-status="all"]').forEach(el => el.addEventListener('click', () => setTimeout(saveSettings, 0)));

            // Restore after first data fetch completes
            setTimeout(restoreSettings, 600);
        });
    </script>
</x-layouts.app>
