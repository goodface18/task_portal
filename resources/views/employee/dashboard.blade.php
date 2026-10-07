
<body class="task-management">

<header class="header">
  <div class="logo-wrap">
    <div class="logo-mark">onsoft<span>arch</span></div>
    <div class="logo-divider"></div>
    <div class="logo-title">BDC Team Hub</div>
  </div>
  <div class="header-right">
    <div class="save-state"><span class="save-dot" id="save-dot"></span><span id="save-text">Saved</span></div>
    <span class="portal-user-name">{{ auth()->user()->name }}</span><a class="portal-link" href="{{ route('profile.edit') }}">Profile</a><form method="POST" action="{{ route('logout') }}">@csrf<button class="logout-btn" type="submit">&#8617; Sign out</button></form>
  </div>
</header>

<main>
  <div class="page-head">
    <div class="page-eyebrow">Banco di Caribe · Team Hub</div>
    <h1 class="page-title">Everything the <em>BDC team</em> needs</h1>
    <p class="page-sub">The shared workspace for everyone working on the Banco di Caribe engagement: live project tasks, the delivery calendar, team contacts, meeting links, invoicing, and key resources. Click any task cell to edit. Changes save automatically.</p>
  </div>

  <!-- SUMMARY -->
  <div class="summary" id="summary">
    <div class="sum-card total"><div class="sum-num" id="sum-total">0</div><div class="sum-label">Total Tasks</div></div>
    <div class="sum-card progress"><div class="sum-num" id="sum-progress">0</div><div class="sum-label">In Progress</div></div>
    <div class="sum-card review"><div class="sum-num" id="sum-review">0</div><div class="sum-label">In Review</div></div>
    <div class="sum-card blocked"><div class="sum-num" id="sum-blocked">0</div><div class="sum-label">Blocked</div></div>
    <div class="sum-card done"><div class="sum-num" id="sum-done">0</div><div class="sum-label">Done</div></div>
  </div>

  <!-- TOOLBAR -->
  <div class="toolbar">
    <div class="filter-group" id="status-filter">
      <button class="filter-btn active" data-status="all">All</button>
      <button class="filter-btn" data-status="Backlog">Backlog</button>
      <button class="filter-btn" data-status="In Progress">In Progress</button>
      <button class="filter-btn" data-status="In Review">In Review</button>
      <button class="filter-btn" data-status="Blocked">Blocked</button>
      <button class="filter-btn" data-status="Done">Done</button>
    </div>
    <input type="text" class="search" id="search" placeholder="Search tasks, owners, stakeholders...">
    <div class="spacer"></div>
    <button class="btn" id="export-btn">↓ Export CSV</button>
    <button class="btn" id="ics-btn">📅 Add to Calendar</button>
    <button class="btn" id="reset-btn">↺ Reset demo</button>
    <button class="btn primary" id="add-btn">+ Add task</button>
  </div>

  <!-- TABLE -->
  <div class="table-wrap">
    <div class="table-scroll">
      <table>
        <thead>
          <tr>
            <th class="col-handle"></th>
            <th class="col-id sortable" data-sort="id">ID</th>
            <th class="col-task sortable" data-sort="task">Task</th>
            <th class="col-desc">Description</th>
            <th class="sortable" data-sort="owner">Owner</th>
            <th class="sortable" data-sort="stakeholder">Stakeholder</th>
            <th class="sortable" data-sort="status">Status</th>
            <th class="sortable" data-sort="priority">Priority</th>
            <th class="sortable" data-sort="due">Due</th>
            <th class="col-updates">Updates</th>
            <th class="col-docs">Documents</th>
            <th class="col-client">Client</th>
            <th class="col-actions"></th>
          </tr>
        </thead>
        <tbody id="tbody"></tbody>
      </table>
    </div>
    <div class="empty" id="empty" style="display:none;">No tasks match. Adjust your filters or add a task.</div>
    <div class="table-foot">
      <span class="foot-count" id="foot-count">0 tasks</span>
      <span class="foot-count">Drag the ⠿ handle to reorder</span>
    </div>
  </div>

  <!-- CALENDAR (below the table) -->
  <div class="cal-section-head">
    <div class="page-eyebrow" style="margin-bottom:0;">Schedule</div>
    <div class="cal-mode-toggle" id="cal-mode-toggle">
      <button class="active" data-mode="month">Month</button>
      <button data-mode="year">Year</button>
    </div>
  </div>

  <div class="cal-wrap">
    <div class="cal-top">
      <div class="cal-month" id="cal-month">Month</div>
      <div class="cal-nav">
        <button id="cal-prev">‹ Prev</button>
        <button class="today-btn" id="cal-today">Today</button>
        <button id="cal-next">Next ›</button>
      </div>
    </div>

    <!-- MONTH VIEW -->
    <div id="cal-month-view">
      <div class="cal-dow-row">
        <div class="cal-dow">Mon</div><div class="cal-dow">Tue</div><div class="cal-dow">Wed</div>
        <div class="cal-dow">Thu</div><div class="cal-dow">Fri</div><div class="cal-dow">Sat</div><div class="cal-dow">Sun</div>
      </div>
      <div class="cal-grid" id="cal-grid"></div>
    </div>

    <!-- YEAR VIEW -->
    <div id="cal-year-view" class="hidden-view">
      <div class="year-grid" id="year-grid"></div>
    </div>

    <div class="cal-legend">
      <div class="cal-leg"><span class="bar" style="background:rgba(255,255,255,0.3)"></span>Low</div>
      <div class="cal-leg"><span class="bar" style="background:var(--amber)"></span>Medium</div>
      <div class="cal-leg"><span class="bar" style="background:var(--orange)"></span>High</div>
      <div class="cal-leg"><span class="bar" style="background:var(--red)"></span>Urgent</div>
      <div class="cal-leg" style="margin-left:auto;">Click a task to open it &middot; drag to reschedule</div>
    </div>
  </div>

  <!-- ===== TEAM CONTACTS + MEETINGS ===== -->
  <div class="two-col">
    <div>
      <div class="hub-head"><div class="hub-title">Team Contacts</div><span class="hub-note">onsoftarch &amp; Banco di Caribe</span></div>
      <div class="contacts-grid" id="contacts"></div>
    </div>
    <div>
      <div class="hub-head"><div class="hub-title">Meeting Links</div></div>
      <div class="meetings-list" id="meetings"></div>
    </div>
  </div>

  <!-- ===== KEY RESOURCES ===== -->
  <div class="hub-head"><div class="hub-title">Key Resources &amp; Quick Links</div><span class="hub-note">Shared drives, docs &amp; tools</span></div>
  <div class="res-grid" id="resources"></div>

  <!-- ===== DOCUMENTS ===== -->
  <div class="hub-head"><div class="hub-title">Documents</div><span class="hub-note">Scopes of work, contracts &amp; key deliverables</span></div>
  <div class="table-wrap">
    <div class="table-scroll">
      <table class="docs-table">
        <thead><tr>
          <th>Document</th><th>Type</th><th>Owner</th><th>Updated</th><th class="doc-open-col"></th>
        </tr></thead>
        <tbody id="docs-rows"></tbody>
      </table>
    </div>
  </div>

  <div class="footer">onsoft<span>arch</span> &nbsp;·&nbsp; Banco di Caribe Team Hub &nbsp;·&nbsp; Internal &amp; Confidential</div>
</main>

<div class="toast" id="toast"></div>

<div class="ev-menu" id="ev-menu">
  <div class="em-head" id="em-head">Task</div>
  <button data-act="open"><span class="ic">▤</span> Open in board</button>
  <button data-act="gcal"><span class="ic">📅</span> Add to Google Calendar</button>
  <button data-act="ics"><span class="ic">🍎</span> Download .ics (Apple Calendar)</button>
</div>

<script>
  // ---- Configuration ----
  const STAFF = ["Rich", "Rick", "Wang", "Martin", "Bjorn", "Unassigned"];
  // Owner options for task assignment
  const TEAM = ["Rich", "Rick", "Wang", "Martin", "Bjorn", "Unassigned"];
  const STATUSES = ["Backlog", "In Progress", "In Review", "Blocked", "Done"];
  const PRIORITIES = ["Low", "Medium", "High", "Urgent"];
  const STATUS_CLASS = { "Backlog":"st-backlog", "In Progress":"st-progress", "In Review":"st-review", "Blocked":"st-blocked", "Done":"st-done" };
  const PRIORITY_CLASS = { "Low":"pr-low", "Medium":"pr-medium", "High":"pr-high", "Urgent":"pr-urgent" };

  // ---- Seed data ----
  function seed() {
    return [
      { id:1, task:"Migrate ATM auth module to ON/2", desc:"Port legacy auth handler onto the ON/2 switch; validate against test card set before cutover.", owner:"Rich", stakeholder:"Banco di Caribe", status:"In Progress", priority:"High", due:isoOffset(7), client:true, docs:[{type:"Scope of Work", label:"ATM Migration SOW v2", url:"https://drive.google.com/your-sow-link"},{type:"Specification", label:"Auth module spec", url:"https://drive.google.com/your-spec-link"}], updates:[
        { author:"Rich", text:"Auth handler ported to test environment. Running first pass against the test card set today.", time:isoOffset(-2)+"T09:14:00.000Z" },
        { author:"Rich", text:"3 edge cases failing on declined-card responses. Investigating the response code mapping.", time:isoOffset(-1)+"T15:40:00.000Z" }
      ] },
      { id:2, task:"Seasonal capacity load test", desc:"Run 4x peak-volume simulation ahead of tourist season. Document headroom and bottlenecks.", owner:"Bjorn", stakeholder:"Banco di Caribe", status:"In Review", priority:"Urgent", due:isoOffset(3), client:true, docs:[{type:"Report", label:"Peak readiness report", url:"https://drive.google.com/your-report-link"}] },
      { id:3, task:"Document legacy reconciliation batch", desc:"Reverse-engineer and write up the nightly EOD reconciliation job. Knowledge transfer for support team.", owner:"Wang", stakeholder:"Regional Bank (NDA)", status:"Backlog", priority:"Medium", due:isoOffset(21) },
      { id:4, task:"POS terminal integration spec", desc:"Define integration contract for the new custom POS fleet. Share draft with client architecture team.", owner:"Martin", stakeholder:"Restaurant Group", status:"In Progress", priority:"High", due:isoOffset(10) },
      { id:5, task:"Multi-currency payroll rules engine", desc:"Build configurable FX + disbursement rules for seafarer payroll across 6 currencies.", owner:"Wang", stakeholder:"Maritime Client", status:"Blocked", priority:"High", due:isoOffset(14), },
      { id:6, task:"Dashboard health-monitor alerts", desc:"Wire early-warning thresholds (latency, batch window, capacity) into the ops dashboard.", owner:"Bjorn", stakeholder:"Banco di Caribe", status:"Done", priority:"Medium", due:isoOffset(-4), client:true },
      { id:7, task:"Quarterly switch optimisation review", desc:"Performance tuning pass on the rescued legacy switch. Compare metrics vs last quarter.", owner:"Rich", stakeholder:"Regional Bank (NDA)", status:"Backlog", priority:"Low", due:isoOffset(30) },
    ];
  }
  function isoOffset(days){ const d=new Date(); d.setDate(d.getDate()+days); return d.toISOString().slice(0,10); }

  let tasks = [];
  let filterStatus = "all";
  let searchTerm = "";
  let sortKey = null, sortDir = 1;
  let nextId = 1;

  // =====================================================================
  //  BACKEND CONFIG  ·  paste your Google Apps Script Web App URL here.
  //  Until you do, the board runs in local-only mode (saves to this
  //  browser only). See the setup steps in the accompanying instructions.
  //  Example: "https://script.google.com/macros/s/AKfy.../exec"
  // =====================================================================
  const SHEET_API_URL = "https://script.google.com/macros/s/AKfycby2bRk3gkvUwVHQDS2M5yEfoQdrAo-OAlCVNu_-d7h6g12DILYvxLVHDV3oWuZCyqRBQw/exec";
  const SHEET_SECRET  = "2516";  // must match the SECRET in the Apps Script

  const USING_SHEET = !!SHEET_API_URL;
  const STORE_KEY = "osa_tasks_v1";
  let lastSyncedJSON = "";

  // ---- Local fallback (browser only) ----
  const LocalStore = {
    hasNative: (typeof window !== 'undefined' && window.storage && typeof window.storage.get === 'function'),
    async get(key) {
      if (this.hasNative) { try { const r = await window.storage.get(key); return r ? r.value : null; } catch(e) { return null; } }
      try { return localStorage.getItem(key); } catch(e) { return null; }
    },
    async set(key, val) {
      if (this.hasNative) { try { await window.storage.set(key, val); return; } catch(e) {} }
      try { localStorage.setItem(key, val); } catch(e) {}
    }
  };

  // ---- Google Sheet backend ----
  // Reads/writes the whole task list as JSON to a single cell via Apps Script.
  const SheetStore = {
    async getAll() {
      const url = SHEET_API_URL + "?secret=" + encodeURIComponent(SHEET_SECRET);
      const res = await fetch(url, { method: "GET" });
      if (!res.ok) throw new Error("GET failed " + res.status);
      const data = await res.json();
      return Array.isArray(data.tasks) ? data.tasks : [];
    },
    async setAll(list) {
      // text/plain avoids a CORS preflight against Apps Script
      const res = await fetch(SHEET_API_URL, {
        method: "POST",
        headers: { "Content-Type": "text/plain;charset=utf-8" },
        body: JSON.stringify({ secret: SHEET_SECRET, tasks: list })
      });
      if (!res.ok) throw new Error("POST failed " + res.status);
      return res.json().catch(()=>({}));
    }
  };

  function setSaving(state){
    // state: 'saving' | 'saved' | 'offline' | 'local'
    const d=document.getElementById('save-dot'), t=document.getElementById('save-text');
    d.classList.remove('saving','offline');
    if (state==='saving'){ d.classList.add('saving'); t.textContent = USING_SHEET ? 'Syncing' : 'Saving'; }
    else if (state==='offline'){ d.classList.add('offline'); t.textContent='Offline – retrying'; }
    else if (state==='local'){ t.textContent='Saved locally'; }
    else { t.textContent = USING_SHEET ? 'Synced' : 'Saved'; }
  }

  // ---- Load / persist ----
  async function load() {
    try {
      if (USING_SHEET) {
        const list = await SheetStore.getAll();
        if (list.length) { tasks = list; }
        else { tasks = seed(); await persist(); }
      } else {
        const val = await LocalStore.get(STORE_KEY);
        tasks = val ? JSON.parse(val) : seed();
        if (!val) await persist();
      }
    } catch(e) {
      console.error("Load failed, using local copy:", e);
      const val = await LocalStore.get(STORE_KEY);
      tasks = val ? JSON.parse(val) : seed();
      setSaving('offline');
    }
    nextId = tasks.reduce((m,t)=>Math.max(m,t.id),0) + 1;
    lastSyncedJSON = JSON.stringify(tasks);
    render();
    if (USING_SHEET) startAutoRefresh();
  }

  let saveTimer = null, savePending = false, saveInFlight = false;
  async function persist() {
    const payload = JSON.stringify(tasks);
    // Always keep a local backup copy too
    LocalStore.set(STORE_KEY, payload);
    if (!USING_SHEET) { setSaving('saving'); clearTimeout(saveTimer); saveTimer=setTimeout(()=>setSaving('local'),300); return; }
    if (saveInFlight) { savePending = true; return; }
    saveInFlight = true; setSaving('saving');
    try {
      await SheetStore.setAll(tasks);
      lastSyncedJSON = payload;
      setSaving('saved');
    } catch(e) {
      console.error("Sync failed:", e);
      setSaving('offline');
    } finally {
      saveInFlight = false;
      if (savePending) { savePending = false; persist(); }
    }
  }
  // Debounce rapid edits into one network write
  function scheduleSave(){
    clearTimeout(saveTimer);
    saveTimer = setTimeout(persist, USING_SHEET ? 600 : 0);
  }

  // ---- Auto-refresh so staff see each other's changes ----
  let refreshTimer = null;
  function startAutoRefresh(){
    if (refreshTimer) return;
    refreshTimer = setInterval(async () => {
      if (saveInFlight || savePending) return;            // don't clobber a pending write
      if (document.activeElement && document.activeElement.closest('#tbody')) return; // don't yank a cell being edited
      try {
        const list = await SheetStore.getAll();
        const incoming = JSON.stringify(list);
        if (incoming !== lastSyncedJSON) {
          tasks = list;
          nextId = tasks.reduce((m,t)=>Math.max(m,t.id),0) + 1;
          lastSyncedJSON = incoming;
          render();
          showToast("Updated with the latest changes");
        }
      } catch(e) { /* stay quiet on transient refresh errors */ }
    }, 15000); // every 15s
  }

  // ---- Rendering ----
  function visibleTasks() {
    let list = tasks.slice();
    if (filterStatus !== "all") list = list.filter(t => t.status === filterStatus);
    if (searchTerm) {
      const q = searchTerm.toLowerCase();
      list = list.filter(t => (t.task+t.desc+t.owner+t.stakeholder).toLowerCase().includes(q));
    }
    if (sortKey) {
      list.sort((a,b)=>{
        let av=a[sortKey], bv=b[sortKey];
        if (sortKey==='priority'){ const o={Low:0,Medium:1,High:2,Urgent:3}; av=o[av]; bv=o[bv]; }
        if (sortKey==='status'){ const o={Backlog:0,'In Progress':1,'In Review':2,Blocked:3,Done:4}; av=o[av]; bv=o[bv]; }
        if (av<bv) return -1*sortDir; if (av>bv) return 1*sortDir; return 0;
      });
    }
    return list;
  }

  function dueClass(due, status){
    if (!due || status==='Done') return '';
    const today=new Date(); today.setHours(0,0,0,0);
    const d=new Date(due+'T00:00:00');
    const diff=(d-today)/(1000*60*60*24);
    if (diff<0) return 'due-over';
    if (diff<=3) return 'due-soon';
    return '';
  }

  function opt(list, val){ return list.map(o=>`<option ${o===val?'selected':''}>${o}</option>`).join(''); }

  function render() {
    const tbody = document.getElementById('tbody');
    const list = visibleTasks();
    tbody.innerHTML = '';
    list.forEach(t => {
      const tr = document.createElement('tr');
      tr.dataset.id = t.id;
      tr.draggable = false;
      tr.innerHTML = `
        <td class="col-handle"><span class="drag-handle" draggable="true" title="Drag to reorder">⠿</span></td>
        <td class="col-id"><span class="row-id">#${String(t.id).padStart(2,'0')}</span></td>
        <td class="col-task"><input class="cell-input" data-field="task" value="${esc(t.task)}" placeholder="Task name">${latestPreview(t)}</td>
        <td class="col-desc"><textarea class="cell-textarea" data-field="desc" rows="1" placeholder="Description...">${esc(t.desc)}</textarea></td>
        <td><select class="cell-select owner-badge" data-field="owner">${opt(TEAM, t.owner)}</select></td>
        <td><input class="cell-input" data-field="stakeholder" value="${esc(t.stakeholder)}" placeholder="Stakeholder"></td>
        <td><div class="pill-wrap"><select class="pill-select ${STATUS_CLASS[t.status]}" data-field="status">${opt(STATUSES, t.status)}</select></div></td>
        <td><div class="pill-wrap"><select class="pill-select ${PRIORITY_CLASS[t.priority]}" data-field="priority">${opt(PRIORITIES, t.priority)}</select></div></td>
        <td><input type="date" class="cell-input cell-date ${dueClass(t.due,t.status)}" data-field="due" value="${t.due||''}"></td>
        <td class="col-updates"><button class="upd-btn ${(t.updates&&t.updates.length)?'has':''}" data-act="toggle-updates" title="Status updates">✎ ${(t.updates&&t.updates.length)?`<span class="upd-count">${t.updates.length}</span>`:'Log'}</button></td>
        <td class="col-docs"><button class="doc-btn ${(t.docs&&t.docs.length)?'has':''}" data-act="toggle-docs" title="Linked documents">🔗 ${(t.docs&&t.docs.length)?`<span class="upd-count">${t.docs.length}</span>`:'Docs'}</button></td>
        <td class="col-client"><button class="share-btn ${t.client?'on':''}" data-act="toggle-client" title="${t.client?'Visible to client, click to hide':'Hidden from client, click to share'}">${t.client?'◉ Shared':'○ Private'}</button></td>
        <td class="col-actions"><button class="del-btn" title="Delete task">✕</button></td>
      `;
      tbody.appendChild(tr);
      // auto-size textarea
      const ta = tr.querySelector('textarea'); autosize(ta);
    });
    document.getElementById('empty').style.display = list.length ? 'none' : 'block';
    document.getElementById('foot-count').textContent = `${list.length} task${list.length!==1?'s':''}` + (filterStatus!=='all'||searchTerm ? ` (of ${tasks.length})` : '');
    updateSummary();
    bindRowEvents();
    refreshCalendar();
  }

  function updateSummary() {
    document.getElementById('sum-total').textContent = tasks.length;
    document.getElementById('sum-progress').textContent = tasks.filter(t=>t.status==='In Progress').length;
    document.getElementById('sum-review').textContent = tasks.filter(t=>t.status==='In Review').length;
    document.getElementById('sum-blocked').textContent = tasks.filter(t=>t.status==='Blocked').length;
    document.getElementById('sum-done').textContent = tasks.filter(t=>t.status==='Done').length;
  }

  function esc(s){ return (s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
  function autosize(ta){ if(!ta) return; ta.style.height='auto'; ta.style.height=(ta.scrollHeight)+'px'; }

  function getTask(id){ return tasks.find(t=>t.id==id); }

  function latestPreview(t){
    const ups = t.updates || [];
    if (!ups.length) return '';
    const u = ups[ups.length-1];
    const initials = (u.author||'').split(' ').map(w=>w[0]||'').join('').slice(0,2).toUpperCase();
    return `<div class="task-latest" title="${esc(u.author)} · ${fmtUpdTime(u.time)}"><span class="tl-ini">${esc(initials)}</span><span class="tl-txt">${esc(u.text)}</span></div>`;
  }

  // ---- Task updates (status notes) ----
  const TABLE_COLS = 13; // handle,id,task,desc,owner,stakeholder,status,priority,due,updates,docs,client,actions
  function fmtUpdTime(iso){
    const d = new Date(iso);
    return d.toLocaleString(undefined, { day:'2-digit', month:'short', hour:'2-digit', minute:'2-digit' });
  }
  function toggleUpdates(id, tr, btn){
    const existing = tr.nextElementSibling;
    if (existing && existing.classList.contains('upd-row')) {
      existing.remove(); btn.classList.remove('open'); return;
    }
    // close any other open panel
    document.querySelectorAll('#tbody tr.upd-row, #tbody tr.doc-row').forEach(r=>r.remove());
    document.querySelectorAll('.doc-btn.open').forEach(b=>b.classList.remove('open'));
    document.querySelectorAll('.upd-btn.open').forEach(b=>b.classList.remove('open'));
    btn.classList.add('open');
    const t = getTask(id); if(!t) return;
    if (!t.updates) t.updates = [];
    const row = document.createElement('tr');
    row.className = 'upd-row';
    row.innerHTML = `<td colspan="${TABLE_COLS}"><div class="upd-panel" data-id="${id}"></div></td>`;
    tr.after(row);
    renderUpdPanel(id, row.querySelector('.upd-panel'));
  }
  function renderUpdPanel(id, panel){
    const t = getTask(id); if(!t) return;
    const ups = t.updates || [];
    let list = ups.map((u,i)=>`
      <div class="upd-item">
        <div class="upd-meta">
          <span class="upd-author">${esc(u.author||'-')}</span>
          <span class="upd-time">${fmtUpdTime(u.time)}</span>
          <button class="upd-del" data-i="${i}" title="Delete update">✕</button>
        </div>
        <div class="upd-text">${esc(u.text)}</div>
      </div>`).join('');
    if (!ups.length) list = `<div class="upd-empty">No updates yet. Add the first status update below.</div>`;
    panel.innerHTML = `
      <div class="upd-title">Status updates · ${esc(t.task||'Untitled task')}</div>
      <div class="upd-list">${list}</div>
      <div class="upd-compose">
        <select class="upd-author-pick" title="Who is posting">${opt(TEAM.filter(x=>x!=='Unassigned'), t.owner!=='Unassigned'?t.owner:TEAM[0])}</select>
        <textarea class="upd-input" rows="1" placeholder="Add a status update… (Ctrl/Cmd + Enter to post)"></textarea>
        <button class="upd-post">Post update</button>
      </div>`;
    // bind compose
    const ta = panel.querySelector('.upd-input');
    const post = () => {
      const text = ta.value.trim(); if(!text) return;
      const author = panel.querySelector('.upd-author-pick').value;
      if (!t.updates) t.updates = [];
      t.updates.push({ author, text, time: new Date().toISOString() });
      scheduleSave();
      renderUpdPanel(id, panel);
      // refresh the row's button count without full re-render
      const rowBtn = document.querySelector(`#tbody tr[data-id="${id}"] [data-act="toggle-updates"]`);
      if (rowBtn) { rowBtn.classList.add('has','open'); rowBtn.innerHTML = `✎ <span class="upd-count">${t.updates.length}</span>`; }
      showToast('Update posted');
    };
    panel.querySelector('.upd-post').addEventListener('click', post);
    ta.addEventListener('keydown', e => { if ((e.ctrlKey||e.metaKey) && e.key==='Enter') post(); });
    ta.addEventListener('input', ()=>autosize(ta));
    panel.querySelectorAll('.upd-del').forEach(b => b.addEventListener('click', () => {
      const i = +b.dataset.i; t.updates.splice(i,1); scheduleSave();
      renderUpdPanel(id, panel);
      const rowBtn = document.querySelector(`#tbody tr[data-id="${id}"] [data-act="toggle-updates"]`);
      if (rowBtn) { const n=t.updates.length; rowBtn.classList.toggle('has', n>0); rowBtn.innerHTML = n? `✎ <span class="upd-count">${n}</span>` : '✎ Log'; }
    }));
  }

  // ---- Task documents (links) ----
  const DOC_TYPES = ["Scope of Work","Contract","Specification","Report","Diagram","Invoice","Runbook","Other"];
  function toggleDocs(id, tr, btn){
    const existing = tr.nextElementSibling;
    if (existing && existing.classList.contains('doc-row')) { existing.remove(); btn.classList.remove('open'); return; }
    document.querySelectorAll('#tbody tr.doc-row, #tbody tr.upd-row').forEach(r=>r.remove());
    document.querySelectorAll('.doc-btn.open, .upd-btn.open').forEach(b=>b.classList.remove('open'));
    btn.classList.add('open');
    const t = getTask(id); if(!t) return;
    if (!t.docs) t.docs = [];
    const row = document.createElement('tr');
    row.className = 'doc-row';
    row.innerHTML = `<td colspan="${TABLE_COLS}"><div class="doc-panel" data-id="${id}"></div></td>`;
    tr.after(row);
    renderDocPanel(id, row.querySelector('.doc-panel'));
  }
  function normUrl(u){ u=(u||'').trim(); if(!u) return ''; if(!/^https?:\/\//i.test(u) && !/^mailto:/i.test(u)) u='https://'+u; return u; }
  function renderDocPanel(id, panel){
    const t = getTask(id); if(!t) return;
    const docs = t.docs || [];
    let list = docs.map((d,i)=>`
      <div class="doc-item">
        <span class="d-type">${esc(d.type||'Doc')}</span>
        <a class="d-name" href="${esc(normUrl(d.url))}" target="_blank" rel="noopener">${esc(d.label||d.url)}</a>
        <span class="d-open">open ↗</span>
        <button class="doc-del" data-i="${i}" title="Remove link">✕</button>
      </div>`).join('');
    if (!docs.length) list = `<div class="doc-empty">No documents linked yet. Add a scope of work, contract, spec or other link below.</div>`;
    panel.innerHTML = `
      <div class="doc-title">Documents · ${esc(t.task||'Untitled task')}</div>
      <div class="doc-list">${list}</div>
      <div class="doc-compose">
        <select class="d-typepick" title="Document type">${opt(DOC_TYPES, 'Scope of Work')}</select>
        <input class="d-label" type="text" placeholder="Document name (e.g. SOW v2)">
        <input class="d-url" type="text" placeholder="Paste link (Google Drive, SharePoint, URL)...">
        <button class="doc-add">Add link</button>
      </div>`;
    const add = () => {
      const type = panel.querySelector('.d-typepick').value;
      const label = panel.querySelector('.d-label').value.trim();
      const url = panel.querySelector('.d-url').value.trim();
      if (!url) { panel.querySelector('.d-url').focus(); return; }
      if (!t.docs) t.docs = [];
      t.docs.push({ type, label: label || url, url });
      scheduleSave();
      renderDocPanel(id, panel);
      const rowBtn = document.querySelector(`#tbody tr[data-id="${id}"] [data-act="toggle-docs"]`);
      if (rowBtn) { rowBtn.classList.add('has','open'); rowBtn.innerHTML = `🔗 <span class="upd-count">${t.docs.length}</span>`; }
      showToast('Document linked');
    };
    panel.querySelector('.doc-add').addEventListener('click', add);
    panel.querySelector('.d-url').addEventListener('keydown', e => { if(e.key==='Enter') add(); });
    panel.querySelectorAll('.doc-del').forEach(b => b.addEventListener('click', () => {
      const i = +b.dataset.i; t.docs.splice(i,1); scheduleSave();
      renderDocPanel(id, panel);
      const rowBtn = document.querySelector(`#tbody tr[data-id="${id}"] [data-act="toggle-docs"]`);
      if (rowBtn) { const n=t.docs.length; rowBtn.classList.toggle('has', n>0); rowBtn.innerHTML = n? `🔗 <span class="upd-count">${n}</span>` : '🔗 Docs'; }
    }));
  }

  function bindRowEvents() {
    document.querySelectorAll('#tbody tr:not(.upd-row):not(.doc-row)').forEach(tr => {
      const id = tr.dataset.id;
      tr.querySelectorAll('[data-field]').forEach(el => {
        el.addEventListener('change', () => {
          const t = getTask(id); if(!t) return;
          t[el.dataset.field] = el.value;
          if (el.dataset.field==='status') { el.className = 'pill-select ' + STATUS_CLASS[el.value]; updateSummary();
            const dueEl = tr.querySelector('[data-field="due"]'); if(dueEl) dueEl.className='cell-input cell-date '+dueClass(t.due,t.status); }
          if (el.dataset.field==='priority') el.className = 'pill-select ' + PRIORITY_CLASS[el.value];
          if (el.dataset.field==='due') el.className='cell-input cell-date '+dueClass(t.due,t.status);
          scheduleSave();
        });
        if (el.classList.contains('cell-textarea')) {
          el.addEventListener('input', () => autosize(el));
        }
        if (el.classList.contains('cell-input') && el.dataset.field!=='due') {
          el.addEventListener('input', () => { const t=getTask(id); if(t){ t[el.dataset.field]=el.value; scheduleSave(); } });
        }
      });
      tr.querySelector('.del-btn').addEventListener('click', () => {
        const t=getTask(id);
        tasks = tasks.filter(x=>x.id!=id);
        render(); scheduleSave();
        showToast(`Deleted "${(t&&t.task)||'task'}"`);
      });
      // updates toggle
      const updBtn = tr.querySelector('[data-act="toggle-updates"]');
      if (updBtn) updBtn.addEventListener('click', () => toggleUpdates(id, tr, updBtn));
      const docBtn = tr.querySelector('[data-act="toggle-docs"]');
      if (docBtn) docBtn.addEventListener('click', () => toggleDocs(id, tr, docBtn));
      // client share toggle
      const shareBtn = tr.querySelector('[data-act="toggle-client"]');
      if (shareBtn) shareBtn.addEventListener('click', () => {
        const t = getTask(id); if(!t) return;
        t.client = !t.client;
        shareBtn.classList.toggle('on', !!t.client);
        shareBtn.textContent = t.client ? '◉ Shared' : '○ Private';
        shareBtn.title = t.client ? 'Visible to client, click to hide' : 'Hidden from client, click to share';
        scheduleSave();
        showToast(t.client ? `"${t.task||'Task'}" is now visible to the client` : `"${t.task||'Task'}" hidden from client`);
      });
      // drag reorder
      const handle = tr.querySelector('.drag-handle');
      handle.addEventListener('dragstart', e => { tr.classList.add('dragging'); e.dataTransfer.effectAllowed='move'; e.dataTransfer.setData('text/plain', id); });
      handle.addEventListener('dragend', () => { tr.classList.remove('dragging'); document.querySelectorAll('tr.drag-over').forEach(r=>r.classList.remove('drag-over')); });
    });

    // row-level dragover/drop (only meaningful when not filtered/sorted)
    document.querySelectorAll('#tbody tr:not(.upd-row):not(.doc-row)').forEach(tr => {
      tr.addEventListener('dragover', e => { e.preventDefault(); tr.classList.add('drag-over'); });
      tr.addEventListener('dragleave', () => tr.classList.remove('drag-over'));
      tr.addEventListener('drop', e => {
        e.preventDefault(); tr.classList.remove('drag-over');
        const fromId = e.dataTransfer.getData('text/plain'); const toId = tr.dataset.id;
        if (fromId===toId) return;
        const fromIdx = tasks.findIndex(t=>t.id==fromId);
        const toIdx = tasks.findIndex(t=>t.id==toId);
        if (fromIdx<0||toIdx<0) return;
        const [moved] = tasks.splice(fromIdx,1);
        tasks.splice(toIdx,0,moved);
        render(); scheduleSave();
      });
    });
  }

  // ---- Toolbar actions ----
  document.getElementById('status-filter').addEventListener('click', e => {
    if (!e.target.classList.contains('filter-btn')) return;
    document.querySelectorAll('#status-filter .filter-btn').forEach(b=>b.classList.remove('active'));
    e.target.classList.add('active');
    filterStatus = e.target.dataset.status;
    render();
  });
  document.getElementById('search').addEventListener('input', e => { searchTerm = e.target.value; render(); });
  document.querySelectorAll('th.sortable').forEach(th => {
    th.addEventListener('click', () => {
      const k = th.dataset.sort;
      if (sortKey===k) sortDir*=-1; else { sortKey=k; sortDir=1; }
      document.querySelectorAll('th .arrow').forEach(a=>a.remove());
      const ar=document.createElement('span'); ar.className='arrow'; ar.textContent = sortDir>0?'↑':'↓'; th.appendChild(ar);
      render();
    });
  });
  document.getElementById('add-btn').addEventListener('click', () => {
    const t = { id: nextId++, task:"", desc:"", owner:"Unassigned", stakeholder:"", status:"Backlog", priority:"Medium", due:"" };
    tasks.unshift(t);
    filterStatus="all"; searchTerm=""; sortKey=null;
    document.getElementById('search').value='';
    document.querySelectorAll('#status-filter .filter-btn').forEach(b=>b.classList.remove('active'));
    document.querySelector('#status-filter .filter-btn[data-status="all"]').classList.add('active');
    render(); scheduleSave();
    const first = document.querySelector('#tbody tr .cell-input'); if(first) first.focus();
  });
  document.getElementById('reset-btn').addEventListener('click', async () => {
    if (!confirm('Reset the board to the demo tasks? This replaces all current tasks.')) return;
    tasks = seed(); nextId = tasks.reduce((m,t)=>Math.max(m,t.id),0)+1;
    render(); await persist(); showToast('Board reset to demo data');
  });

  // ---- CSV export ----
  function csvEscape(v){
    v = (v==null) ? '' : String(v);
    if (/[",\n\r]/.test(v)) return '"' + v.replace(/"/g,'""') + '"';
    return v;
  }
  function exportCSV(){
    const cols = [
      ['id','ID'], ['task','Task'], ['desc','Description'], ['owner','Owner'],
      ['stakeholder','Stakeholder'], ['status','Status'], ['priority','Priority'], ['due','Due Date']
    ];
    // Export the currently visible (filtered/sorted) set so what you see is what you get
    const rows = visibleTasks();
    const header = cols.map(c => c[1]).concat(['Shared With Client','Documents','Update Count','Latest Update','All Updates']).join(',');
    const body = rows.map(t => {
      const base = cols.map(c => csvEscape(t[c[0]]));
      const ups = t.updates || [];
      const latest = ups.length ? `[${fmtUpdTime(ups[ups.length-1].time)}] ${ups[ups.length-1].author}: ${ups[ups.length-1].text}` : '';
      const all = ups.map(u => `[${fmtUpdTime(u.time)}] ${u.author}: ${u.text}`).join('\n');
      const docs = (t.docs||[]).map(d => `${d.type}: ${d.label} (${d.url})`).join('\n');
      base.push(csvEscape(t.client?'Yes':'No'), csvEscape(docs), csvEscape(ups.length), csvEscape(latest), csvEscape(all));
      return base.join(',');
    }).join('\r\n');
    const csv = header + '\r\n' + body;
    const stamp = new Date().toISOString().slice(0,10);
    const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' }); // BOM for Excel
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url; a.download = `onsoftarch_tasks_${stamp}.csv`;
    document.body.appendChild(a); a.click(); document.body.removeChild(a);
    setTimeout(()=>URL.revokeObjectURL(url), 500);
    showToast(`Exported ${rows.length} task${rows.length!==1?'s':''} to CSV`);
  }
  document.getElementById('export-btn').addEventListener('click', exportCSV);

  // ---- Calendar (.ics) export for Google / Apple Calendar ----
  function icsEscape(s){ return (s==null?'':String(s)).replace(/\\/g,'\\\\').replace(/;/g,'\\;').replace(/,/g,'\\,').replace(/\r?\n/g,'\\n'); }
  function icsDate(d){ // all-day date value YYYYMMDD
    return d.replace(/-/g,'');
  }
  function icsDateNext(due){ // DTEND is exclusive for all-day events -> +1 day
    const d = new Date(due+'T00:00:00'); d.setDate(d.getDate()+1);
    return d.toISOString().slice(0,10).replace(/-/g,'');
  }
  function dtStamp(){ return new Date().toISOString().replace(/[-:]/g,'').slice(0,15)+'Z'; }
  function foldLine(line){ // RFC5545: fold lines >75 octets
    if (line.length <= 73) return line;
    let out = ''; let s = line;
    while (s.length > 73) { out += s.slice(0,73) + '\r\n '; s = s.slice(73); }
    return out + s;
  }
  function buildICS(list){
    const lines = [
      'BEGIN:VCALENDAR','VERSION:2.0','PRODID:-//onsoftarch//Task Board//EN',
      'CALSCALE:GREGORIAN','METHOD:PUBLISH','X-WR-CALNAME:onsoftarch Tasks','X-WR-TIMEZONE:UTC'
    ];
    list.forEach(t => {
      if (!t.due) return;
      const ups = t.updates || [];
      const latest = ups.length ? `\\n\\nLatest update (${ups[ups.length-1].author}): ${ups[ups.length-1].text}` : '';
      const desc = `${t.desc||''}\\n\\nOwner: ${t.owner||'-'}\\nStakeholder: ${t.stakeholder||'-'}\\nStatus: ${t.status}\\nPriority: ${t.priority}${latest}`;
      const prMap = { Urgent:1, High:3, Medium:5, Low:7 };
      const ev = [
        'BEGIN:VEVENT',
        'UID:osa-task-'+t.id+'@onsoftarch',
        'DTSTAMP:'+dtStamp(),
        'DTSTART;VALUE=DATE:'+icsDate(t.due),
        'DTEND;VALUE=DATE:'+icsDateNext(t.due),
        foldLine('SUMMARY:'+icsEscape((t.priority==='Urgent'?'[URGENT] ':'')+(t.task||'Untitled task'))),
        foldLine('DESCRIPTION:'+icsEscape(desc)),
        'PRIORITY:'+(prMap[t.priority]||5),
        'STATUS:'+(t.status==='Done'?'CONFIRMED':'TENTATIVE'),
        'CATEGORIES:'+icsEscape(t.stakeholder||'Task'),
        'TRANSP:TRANSPARENT',
        'BEGIN:VALARM','TRIGGER:-P1D','ACTION:DISPLAY','DESCRIPTION:'+icsEscape('Reminder: '+(t.task||'Task')),'END:VALARM',
        'END:VEVENT'
      ];
      lines.push.apply(lines, ev);
    });
    lines.push('END:VCALENDAR');
    return lines.join('\r\n');
  }
  function exportICS(){
    const list = visibleTasks().filter(t => t.due);
    if (!list.length) { showToast('No tasks with due dates to add'); return; }
    const ics = buildICS(list);
    const stamp = new Date().toISOString().slice(0,10);
    const blob = new Blob([ics], { type: 'text/calendar;charset=utf-8' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url; a.download = `onsoftarch_tasks_${stamp}.ics`;
    document.body.appendChild(a); a.click(); document.body.removeChild(a);
    setTimeout(()=>URL.revokeObjectURL(url), 500);
    showToast(`Calendar file ready (${list.length} task${list.length!==1?'s':''}) · open it in Apple or Google Calendar`);
  }
  document.getElementById('ics-btn').addEventListener('click', exportICS);

  // Single-task "add to Google Calendar" URL (used from the calendar event menu)
  function googleCalUrl(t){
    if (!t.due) return null;
    const start = icsDate(t.due), end = icsDateNext(t.due);
    const ups = t.updates || [];
    const latest = ups.length ? `\n\nLatest update (${ups[ups.length-1].author}): ${ups[ups.length-1].text}` : '';
    const details = `${t.desc||''}\n\nOwner: ${t.owner||'-'}\nStakeholder: ${t.stakeholder||'-'}\nStatus: ${t.status}\nPriority: ${t.priority}${latest}`;
    const p = new URLSearchParams({ action:'TEMPLATE', text:(t.task||'Task'), dates:`${start}/${end}`, details });
    return 'https://calendar.google.com/calendar/render?' + p.toString();
  }

  function showToast(msg){ const t=document.getElementById('toast'); t.textContent=msg; t.classList.add('show'); setTimeout(()=>t.classList.remove('show'),2200); }

  // ---- Calendar ----
  let calMode = 'month';          // 'month' | 'year'
  let calRef = new Date(); calRef.setDate(1);
  const PR_EV = { Low:'ev-low', Medium:'ev-medium', High:'ev-high', Urgent:'ev-urgent' };
  const PR_DOT = { Low:'dot-low', Medium:'dot-medium', High:'dot-high', Urgent:'dot-urgent' };
  const MONTHS = ["January","February","March","April","May","June","July","August","September","October","November","December"];
  const MONTHS_SHORT = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

  function ymd(d){ return d.toISOString().slice(0,10); }

  function tasksByDate() {
    const byDate = {};
    visibleTasks().forEach(t => { if (t.due) { (byDate[t.due] = byDate[t.due] || []).push(t); } });
    return byDate;
  }

  function refreshCalendar() {
    if (calMode === 'month') renderCalendar(); else renderYear();
  }

  function renderCalendar() {
    const grid = document.getElementById('cal-grid');
    if (!grid) return;
    const year = calRef.getFullYear(), month = calRef.getMonth();
    document.getElementById('cal-month').innerHTML = `${MONTHS[month]} <span>${year}</span>`;

    // first cell = Monday on/before the 1st
    const first = new Date(year, month, 1);
    let startOffset = (first.getDay() + 6) % 7; // Mon=0
    const start = new Date(year, month, 1 - startOffset);
    const todayStr = ymd(new Date());

    // group visible tasks by due date
    const byDate = {};
    visibleTasks().forEach(t => { if (t.due) { (byDate[t.due] = byDate[t.due] || []).push(t); } });

    grid.innerHTML = '';
    for (let i = 0; i < 42; i++) {
      const d = new Date(start); d.setDate(start.getDate() + i);
      const ds = ymd(d);
      const inMonth = d.getMonth() === month;
      const cell = document.createElement('div');
      cell.className = 'cal-cell' + (inMonth ? '' : ' other') + (ds === todayStr ? ' today' : '');
      cell.dataset.date = ds;

      const head = document.createElement('div');
      head.className = 'cal-daynum';
      head.innerHTML = `<span>${d.getDate()}</span><button class="add-on-day" title="Add task on this day">+</button>`;
      cell.appendChild(head);

      const items = (byDate[ds] || []);
      const shown = items.slice(0, 3);
      shown.forEach(t => {
        const ev = document.createElement('button');
        ev.className = 'cal-event ' + (PR_EV[t.priority]||'ev-low') + (t.status==='Done' ? ' ev-done' : '');
        ev.draggable = true;
        ev.dataset.id = t.id;
        ev.title = `${t.task||'Untitled'} · ${t.owner} · ${t.stakeholder||''} · ${t.status}`;
        const ini = (t.owner&&t.owner!=='Unassigned') ? t.owner.split(' ').map(w=>w[0]||'').join('').slice(0,2).toUpperCase() : '';
        ev.innerHTML = `${ini?`<span class="ev-ini">${esc(ini)}</span>`:''}${esc(t.task || 'Untitled task')}`;
        cell.appendChild(ev);
      });
      if (items.length > 3) {
        const more = document.createElement('div');
        more.className = 'cal-more';
        more.textContent = `+${items.length - 3} more`;
        more.addEventListener('click', () => { document.querySelector('.table-wrap').scrollIntoView({behavior:'smooth', block:'start'}); });
        cell.appendChild(more);
      }
      grid.appendChild(cell);
    }
    bindCalendarEvents();
  }

  function scrollToTask(id) {
    // clear filters so the task is visible in the table, then highlight it
    filterStatus='all'; searchTerm=''; sortKey=null;
    document.getElementById('search').value='';
    document.querySelectorAll('#status-filter .filter-btn').forEach(b=>b.classList.remove('active'));
    document.querySelector('#status-filter .filter-btn[data-status="all"]').classList.add('active');
    render();
    const row = document.querySelector(`#tbody tr[data-id="${id}"]`);
    if (row) {
      row.scrollIntoView({behavior:'smooth', block:'center'});
      row.style.transition='background 0.3s'; row.style.background='rgba(92,200,32,0.12)';
      setTimeout(()=>row.style.background='',1400);
      const inp=row.querySelector('.cell-input'); if(inp) setTimeout(()=>inp.focus(),450);
    }
  }

  // ---- Calendar event popover menu (per-task calendar actions) ----
  let evMenuTaskId = null;
  function openEvMenu(id, x, y) {
    const t = getTask(id); if (!t) return;
    evMenuTaskId = id;
    const menu = document.getElementById('ev-menu');
    document.getElementById('em-head').textContent = t.task || 'Untitled task';
    menu.classList.add('show');
    // position, keeping it on-screen
    const mw = menu.offsetWidth || 220, mh = menu.offsetHeight || 140;
    let px = Math.min(x, window.innerWidth - mw - 10);
    let py = Math.min(y, window.innerHeight - mh - 10);
    menu.style.left = Math.max(8, px) + 'px';
    menu.style.top = Math.max(8, py) + 'px';
  }
  function closeEvMenu(){ document.getElementById('ev-menu').classList.remove('show'); evMenuTaskId = null; }
  document.addEventListener('click', (e) => { if (!e.target.closest('#ev-menu')) closeEvMenu(); });
  document.getElementById('ev-menu').addEventListener('click', (e) => {
    const btn = e.target.closest('button'); if (!btn || !evMenuTaskId) return;
    const t = getTask(evMenuTaskId); const act = btn.dataset.act;
    if (act === 'open') { scrollToTask(evMenuTaskId); }
    else if (act === 'gcal') { const u = googleCalUrl(t); if (u) window.open(u, '_blank'); else showToast('Task has no due date'); }
    else if (act === 'ics') { if (t.due) { downloadSingleICS(t); } else showToast('Task has no due date'); }
    closeEvMenu();
  });
  function downloadSingleICS(t){
    const ics = buildICS([t]);
    const blob = new Blob([ics], { type:'text/calendar;charset=utf-8' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url; a.download = `${(t.task||'task').replace(/[^a-z0-9]+/gi,'_').slice(0,40)}.ics`;
    document.body.appendChild(a); a.click(); document.body.removeChild(a);
    setTimeout(()=>URL.revokeObjectURL(url), 500);
    showToast('Calendar file ready · open it in Apple Calendar');
  }

  function bindCalendarEvents() {
    document.querySelectorAll('#cal-grid .cal-event').forEach(ev => {
      ev.addEventListener('click', (e) => { e.stopPropagation(); openEvMenu(ev.dataset.id, e.clientX, e.clientY); });
      ev.addEventListener('dragstart', e => { e.dataTransfer.effectAllowed='move'; e.dataTransfer.setData('text/plain', ev.dataset.id); });
    });
    document.querySelectorAll('#cal-grid .cal-cell').forEach(cell => {
      cell.addEventListener('dragover', e => { e.preventDefault(); cell.classList.add('drag-over'); });
      cell.addEventListener('dragleave', () => cell.classList.remove('drag-over'));
      cell.addEventListener('drop', e => {
        e.preventDefault(); cell.classList.remove('drag-over');
        const id = e.dataTransfer.getData('text/plain');
        const t = getTask(id); if (!t) return;
        t.due = cell.dataset.date;
        render(); scheduleSave();
        showToast(`"${t.task||'Task'}" moved to ${t.due}`);
      });
      const addBtn = cell.querySelector('.add-on-day');
      if (addBtn) addBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        const t = { id: nextId++, task:"", desc:"", owner:"Unassigned", stakeholder:"", status:"Backlog", priority:"Medium", due: cell.dataset.date };
        tasks.unshift(t);
        render(); scheduleSave();
        scrollToTask(t.id);
        showToast(`New task added on ${cell.dataset.date}`);
      });
    });
  }

  // ---- Year view ----
  function renderYear() {
    const wrap = document.getElementById('year-grid');
    if (!wrap) return;
    const year = calRef.getFullYear();
    document.getElementById('cal-month').innerHTML = `<span>${year}</span>`;
    const byDate = tasksByDate();
    const todayStr = ymd(new Date());
    wrap.innerHTML = '';

    for (let m = 0; m < 12; m++) {
      const monthTasks = Object.keys(byDate).filter(d => { const dd=new Date(d+'T00:00:00'); return dd.getFullYear()===year && dd.getMonth()===m; })
        .reduce((n,d)=>n+byDate[d].length, 0);
      const hasToday = (new Date().getFullYear()===year && new Date().getMonth()===m);

      const card = document.createElement('div');
      card.className = 'year-month' + (hasToday ? ' has-today' : '');
      let html = `<div class="ym-name" data-month="${m}"><span>${MONTHS_SHORT[m]}</span><span class="ym-count ${monthTasks?'':'zero'}">${monthTasks}</span></div>`;
      html += `<div class="ym-mini">`;
      ['M','T','W','T','F','S','S'].forEach(d => html += `<div class="ym-dow">${d}</div>`);

      const first = new Date(year, m, 1);
      const offset = (first.getDay() + 6) % 7;
      const start = new Date(year, m, 1 - offset);
      for (let i=0;i<42;i++){
        const d = new Date(start); d.setDate(start.getDate()+i);
        const ds = ymd(d);
        const inMonth = d.getMonth()===m;
        if (i>=35 && inMonth===false) continue; // trim trailing empty week
        const items = byDate[ds] || [];
        let cls = 'ym-day' + (inMonth?'':' other') + (ds===todayStr?' today':'') + (items.length&&inMonth?' has-task':'');
        let dots = '';
        if (items.length && inMonth) {
          const top = items.slice(0,3).map(t => `<span class="ym-dot ${PR_DOT[t.priority]||'dot-low'}"></span>`).join('');
          dots = `<span class="ym-dots">${top}</span>`;
        }
        html += `<div class="${cls}" data-date="${ds}" ${items.length&&inMonth?`title="${items.length} task(s) due"`:''}>${d.getDate()}${dots}</div>`;
      }
      html += `</div>`;
      card.innerHTML = html;
      wrap.appendChild(card);
    }

    // jump to a month by clicking its name
    wrap.querySelectorAll('.ym-name').forEach(n => {
      n.addEventListener('click', () => { calRef = new Date(year, parseInt(n.dataset.month), 1); setMode('month'); });
    });
    // click a day with tasks -> open month there
    wrap.querySelectorAll('.ym-day.has-task').forEach(d => {
      d.addEventListener('click', () => { const dd=new Date(d.dataset.date+'T00:00:00'); calRef=new Date(dd.getFullYear(), dd.getMonth(), 1); setMode('month'); });
    });
  }

  // ---- Mode toggle + nav ----
  function setMode(mode) {
    calMode = mode;
    document.querySelectorAll('#cal-mode-toggle button').forEach(b => b.classList.toggle('active', b.dataset.mode===mode));
    document.getElementById('cal-month-view').classList.toggle('hidden-view', mode!=='month');
    document.getElementById('cal-year-view').classList.toggle('hidden-view', mode!=='year');
    refreshCalendar();
  }
  document.getElementById('cal-mode-toggle').addEventListener('click', e => {
    const btn = e.target.closest('button'); if (!btn) return; setMode(btn.dataset.mode);
  });
  document.getElementById('cal-prev').addEventListener('click', () => {
    if (calMode==='month') calRef.setMonth(calRef.getMonth()-1); else calRef.setFullYear(calRef.getFullYear()-1);
    refreshCalendar();
  });
  document.getElementById('cal-next').addEventListener('click', () => {
    if (calMode==='month') calRef.setMonth(calRef.getMonth()+1); else calRef.setFullYear(calRef.getFullYear()+1);
    refreshCalendar();
  });
  document.getElementById('cal-today').addEventListener('click', () => { calRef = new Date(); calRef.setDate(1); refreshCalendar(); });

  // ===== TEAM HUB: contacts, meetings, resources, invoicing =====
  const HUB_CONTACTS = [
    { name:"Bjorn Margon", role:"Managing Director · onsoftarch", email:"Bjorn@onsoftarch.support", phone:"+61 497 997 128", tag:"onsoftarch", langs:"English" },
    { name:"Rich Sathoff", role:"Legacy System Specialist · onsoftarch", email:"rsathoff@onsoftarch.support", phone:"", tag:"onsoftarch", langs:"English", socials:["telegram","whatsapp","slack"] },
    { name:"Rick Walters", role:"Legacy System Specialist · onsoftarch", email:"rwalters@onsoftarch.support", phone:"+1 214 403 8641", tag:"onsoftarch", langs:"English", socials:["telegram","whatsapp","slack"] },
    { name:"Wang", role:"Front End Developer · onsoftarch", email:"wang@onsoftarch.support", phone:"", tag:"onsoftarch", langs:"English, Mandarin", socials:["telegram","slack"] },
    { name:"Martin M.", role:"Payment Development Specialist · onsoftarch", email:"mmuguiro@onsoftarch.support", phone:"", tag:"onsoftarch", langs:"English, Spanish", socials:["slack"] },
    { name:"Accounts", role:"Bookkeeper · Invoices & Payment Queries", email:"accounts@onsoftarch.support", phone:"", tag:"onsoftarch", langs:"English" },
    { name:"Milton", role:"BDC IT Manager", email:"Milton.Djojokasiran@bancodicaribe.com", phone:"", tag:"bdc", langs:"English, Dutch, Papiamentu" },
    { name:"Nimrod", role:"BDC Switch Manager", email:"Nimrod.Thielman@bancodicaribe.com", phone:"", tag:"bdc", langs:"English, Dutch, Papiamentu" },
    { name:"Charlston", role:"BDC Switch and Frontend", email:"charlston.paula@bancodicaribe.com", phone:"", tag:"bdc", langs:"English, Dutch, Papiamentu" }
  ];
  const HUB_MEETINGS = [
    { name:"Weekly Delivery Sync", cadence:"Weekly", when:"Tuesdays · 10:00 AST", url:"https://meet.google.com/your-weekly-link" },
    { name:"Switch Health Review", cadence:"Monthly", when:"1st Thursday · 14:00 AST", url:"https://meet.google.com/your-monthly-link" },
    { name:"Peak Season War Room", cadence:"Seasonal", when:"On-call · Dec–Jan", url:"https://meet.google.com/your-warroom-link" },
    { name:"Internal Standup (onsoftarch)", cadence:"Daily", when:"Weekdays · 09:00", url:"https://meet.google.com/your-standup-link" }
  ];
  const HUB_RESOURCES = [
    { ic:"📁", name:"BDC Shared Drive", desc:"Specs, diagrams, deliverables", host:"Google Drive", url:"#" },
    { ic:"📄", name:"Document Templates", desc:"Invoices, reports, SOWs, letterheads", host:"Google Drive", url:"https://drive.google.com/drive/folders/your-templates-folder" },
    { ic:"📓", name:"Runbooks & Docs", desc:"ON/2 ops, recovery procedures", host:"Drive / Wiki", url:"#" },
    { ic:"🗂", name:"Project Sheet", desc:"This board's backing data", host:"Google Sheets", url:"#" },
    { ic:"🔐", name:"Credentials Vault", desc:"Shared secrets (restricted)", host:"Password Mgr", url:"#" },
    { ic:"📊", name:"Live Dashboards", desc:"BDC Stratus operations view", host:"onsoftarch", url:"onsoftarch_dashboard_desktop_secure.html" },
    { ic:"🌐", name:"Client Portal", desc:"What BDC sees", host:"onsoftarch", url:"onsoftarch_client_portal.html" },
    { ic:"🎫", name:"Support Inbox", desc:"Client tickets & requests", host:"Email", url:"mailto:support@onsoftarch.support" },
    { ic:"📅", name:"Team Calendar", desc:"Shared availability", host:"Google Calendar", url:"#" }
  ];

  const SOCIAL_SVG = {
    telegram: '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M21.94 4.6 18.9 19.2c-.23 1.02-.84 1.27-1.7.79l-4.7-3.46-2.27 2.18c-.25.25-.46.46-.94.46l.33-4.78L18.3 6.4c.38-.34-.08-.53-.59-.19L6.95 13.2l-4.66-1.46c-1.01-.32-1.03-1.01.21-1.5L20.64 3.1c.84-.31 1.58.2 1.3 1.5z"/></svg>',
    whatsapp: '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91C21.96 6.45 17.5 2 12.04 2zm5.8 14.16c-.24.68-1.42 1.31-1.95 1.36-.5.05-1.13.07-1.83-.11-.42-.13-.96-.31-1.66-.61-2.92-1.26-4.83-4.2-4.97-4.39-.15-.2-1.19-1.58-1.19-3.02s.76-2.14 1.03-2.44c.27-.29.59-.37.79-.37l.57.01c.18.01.43-.07.67.51.24.59.83 2.03.9 2.18.07.15.12.32.02.51-.09.2-.14.32-.28.49l-.42.49c-.14.14-.28.29-.12.57.16.27.72 1.18 1.55 1.92 1.06.95 1.96 1.24 2.24 1.38.27.15.43.12.59-.07.16-.2.68-.79.86-1.06.18-.27.36-.22.61-.13.24.09 1.55.73 1.81.86.27.13.45.2.51.31.07.11.07.63-.17 1.31z"/></svg>',
    slack: '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M5.04 15.12a2.52 2.52 0 0 1-2.52 2.52A2.52 2.52 0 0 1 0 15.12a2.52 2.52 0 0 1 2.52-2.52h2.52v2.52zm1.26 0a2.52 2.52 0 0 1 2.52-2.52 2.52 2.52 0 0 1 2.52 2.52v6.3A2.52 2.52 0 0 1 8.82 24a2.52 2.52 0 0 1-2.52-2.52v-6.3zM8.82 5.04A2.52 2.52 0 0 1 6.3 2.52 2.52 2.52 0 0 1 8.82 0a2.52 2.52 0 0 1 2.52 2.52v2.52H8.82zm0 1.26a2.52 2.52 0 0 1 2.52 2.52 2.52 2.52 0 0 1-2.52 2.52h-6.3A2.52 2.52 0 0 1 0 8.82 2.52 2.52 0 0 1 2.52 6.3h6.3zM18.96 8.82a2.52 2.52 0 0 1 2.52-2.52A2.52 2.52 0 0 1 24 8.82a2.52 2.52 0 0 1-2.52 2.52h-2.52V8.82zm-1.26 0a2.52 2.52 0 0 1-2.52 2.52 2.52 2.52 0 0 1-2.52-2.52v-6.3A2.52 2.52 0 0 1 15.18 0a2.52 2.52 0 0 1 2.52 2.52v6.3zM15.18 18.96a2.52 2.52 0 0 1 2.52 2.52A2.52 2.52 0 0 1 15.18 24a2.52 2.52 0 0 1-2.52-2.52v-2.52h2.52zm0-1.26a2.52 2.52 0 0 1-2.52-2.52 2.52 2.52 0 0 1 2.52-2.52h6.3A2.52 2.52 0 0 1 24 15.18a2.52 2.52 0 0 1-2.52 2.52h-6.3z"/></svg>'
  };
  const SOCIAL_LABEL = { telegram:"Telegram", whatsapp:"WhatsApp", slack:"Slack" };

  (function renderContacts(){
    const el = document.getElementById('contacts'); if(!el) return;
    el.innerHTML = HUB_CONTACTS.map(p => {
      const ini = (p.name||'').split(' ').map(w=>w[0]||'').join('').slice(0,2).toUpperCase();
      const tagClass = p.tag==='bdc' ? 'contact-tag bdc' : 'contact-tag';
      const tagLabel = p.tag==='bdc' ? 'BDC' : 'onsoftarch';
      const socials = (p.socials||[]).filter(s=>SOCIAL_SVG[s]).map(s => {
        const url = (p.socialLinks && p.socialLinks[s]) ? p.socialLinks[s] : '#';
        const ext = url.startsWith('http') ? 'target="_blank" rel="noopener"' : '';
        return `<a class="social-ic s-${s}" href="${esc(url)}" ${ext} title="${SOCIAL_LABEL[s]}" aria-label="${SOCIAL_LABEL[s]}">${SOCIAL_SVG[s]}</a>`;
      }).join('');
      const socialRow = socials ? `<div class="contact-socials">${socials}</div>` : '';
      return `<div class="contact-card">
        <div class="contact-top">
          <div class="contact-avatar">${esc(ini)}</div>
          <div style="flex:1;"><div class="contact-name">${esc(p.name)}</div><div class="contact-role">${esc(p.role)}</div></div>
          <span class="${tagClass}">${tagLabel}</span>
        </div>
        <div class="contact-rows">
          ${p.email ? `<div class="contact-row"><span class="ic">&#9993;</span><a href="mailto:${esc(p.email)}">${esc(p.email)}</a></div>` : ''}
          ${p.phone ? `<div class="contact-row"><span class="ic">&#9742;</span><a href="tel:${esc(p.phone.replace(/\s/g,''))}">${esc(p.phone)}</a></div>` : ''}
          ${p.langs ? `<div class="contact-row"><span class="ic">&#127760;</span><span class="contact-langs">${esc(p.langs)}</span></div>` : ''}
        </div>
        ${socialRow}
      </div>`;
    }).join('');
  })();

  (function renderMeetings(){
    const el = document.getElementById('meetings'); if(!el) return;
    el.innerHTML = HUB_MEETINGS.map(m => `<div class="meeting-card">
      <div class="meeting-top"><div class="meeting-name">${esc(m.name)}</div><span class="meeting-cadence">${esc(m.cadence)}</span></div>
      <div class="meeting-when">${esc(m.when)}</div>
      <a class="meeting-join" href="${esc(m.url)}" target="_blank" rel="noopener">&#9654; Join meeting</a>
    </div>`).join('');
  })();

  (function renderResources(){
    const el = document.getElementById('resources'); if(!el) return;
    el.innerHTML = HUB_RESOURCES.map(r => `<a class="res-card" href="${esc(r.url)}" ${r.url.startsWith('http')||r.url.startsWith('mailto')?'target="_blank" rel="noopener"':''}>
      <span class="res-ic">${r.ic}</span>
      <span class="res-name">${esc(r.name)}</span>
      <span class="res-desc">${esc(r.desc)}</span>
      <span class="res-host">${esc(r.host)}</span>
    </a>`).join('');
  })();

  // ===== DOCUMENTS (scopes of work, contracts, deliverables) =====
  const HUB_DOCS = [
    { name:"Master Services Agreement", type:"Contract", owner:"Bjorn", updated:"2026-01-15", url:"#" },
    { name:"Scope of Work: ON/2 Switch Operation & Support", type:"SOW", owner:"Bjorn", updated:"2026-02-03", url:"#" },
    { name:"Scope of Work: Seasonal Capacity Uplift", type:"SOW", owner:"Bjorn", updated:"2026-05-20", url:"#" },
    { name:"Scope of Work: ATM & POS Integration", type:"SOW", owner:"Rich", updated:"2026-04-11", url:"#" },
    { name:"Peak Season Readiness Report", type:"Report", owner:"Bjorn", updated:"2026-06-12", url:"#" },
    { name:"ON/2 Architecture & Integration Spec", type:"Spec", owner:"Rich", updated:"2026-03-28", url:"#" },
    { name:"Data Processing & Security Addendum", type:"Contract", owner:"Bjorn", updated:"2026-01-22", url:"#" }
  ];
  const DOC_TYPE_CLASS = { "SOW":"dt-sow", "Contract":"dt-contract", "Report":"dt-report", "Spec":"dt-spec" };
  const DOC_TYPE_IC = { "SOW":"📋", "Contract":"📜", "Report":"📊", "Spec":"📐" };

  (function renderDocs(){
    const el = document.getElementById('docs-rows'); if(!el) return;
    el.innerHTML = HUB_DOCS.map(d => {
      const cls = DOC_TYPE_CLASS[d.type] || 'dt-other';
      const ic = DOC_TYPE_IC[d.type] || '📄';
      let updated = d.updated;
      try { updated = new Date(d.updated+'T00:00:00').toLocaleDateString(undefined,{day:'2-digit',month:'short',year:'numeric'}); } catch(e){}
      const ext = d.url.startsWith('http') ? 'target="_blank" rel="noopener"' : '';
      return `<tr>
        <td><div class="doc-name"><span class="doc-ic">${ic}</span><span class="doc-title">${esc(d.name)}</span></div></td>
        <td><span class="doc-type ${cls}">${esc(d.type)}</span></td>
        <td><span class="doc-owner">${esc(d.owner)}</span></td>
        <td><span class="doc-updated">${esc(updated)}</span></td>
        <td class="doc-open-col"><a class="doc-open" href="${esc(d.url)}" ${ext}>Open ↗</a></td>
      </tr>`;
    }).join('');
  })();

  // ---- Boot ----
  load();
</script>
</body>

