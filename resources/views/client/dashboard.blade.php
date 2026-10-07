<div class="portal-heading">
    <div>
        <div class="portal-eyebrow">Project Workspace</div>
        <h1>Your engagement, <em>at a glance</em></h1>
        <p>Project progress, delivery dates and the key information shared with your team.</p>
    </div>
    <div class="portal-badge"><span></span> Client portal</div>
</div>

<section class="portal-summary" aria-label="Task summary">
    <article class="portal-stat"><span>Total tasks</span><strong id="client-total">0</strong></article>
    <article class="portal-stat blue"><span>In progress</span><strong id="client-progress">0</strong></article>
    <article class="portal-stat purple"><span>In review</span><strong id="client-review">0</strong></article>
    <article class="portal-stat red"><span>Blocked</span><strong id="client-blocked">0</strong></article>
    <article class="portal-stat"><span>Done</span><strong id="client-done">0</strong></article>
</section>

<section class="portal-section">
    <div class="portal-section-head"><div><div class="portal-eyebrow">Delivery overview</div><h2>Project status</h2></div><button class="portal-btn" id="client-export">↓ Export CSV</button></div>
    <div class="portal-toolbar">
        <div class="portal-filters" id="client-filters">
            <button class="active" data-status="all">All</button><button data-status="In Progress">In Progress</button><button data-status="In Review">In Review</button><button data-status="Blocked">Blocked</button><button data-status="Done">Done</button>
        </div>
        <input class="portal-search" id="client-search" type="search" placeholder="Search project tasks…" aria-label="Search tasks">
    </div>
    <div class="portal-table-wrap"><table class="portal-table"><thead><tr><th>Task</th><th>onsoftarch lead</th><th>Status</th><th>Priority</th><th>Target date</th></tr></thead><tbody id="client-task-rows"></tbody></table><div class="portal-empty" id="client-empty" hidden>No matching items.</div></div>
</section>

<section class="portal-section portal-two-col">
    <div>
        <div class="portal-section-head"><div><div class="portal-eyebrow">Stay connected</div><h2>Your onsoftarch team</h2></div></div>
        <div class="portal-contact-grid">
            <article class="portal-card"><strong>Bjorn Margon</strong><span>Managing Director</span><a href="mailto:Bjorn@onsoftarch.support">Bjorn@onsoftarch.support</a></article>
            <article class="portal-card"><strong>Rick Walters</strong><span>Legacy System Specialist</span><a href="mailto:rwalters@onsoftarch.support">rwalters@onsoftarch.support</a></article>
            <article class="portal-card"><strong>Wang</strong><span>Front End Developer</span><a href="mailto:wang@onsoftarch.support">wang@onsoftarch.support</a></article>
            <article class="portal-card"><strong>Support</strong><span>Support requests</span><a href="mailto:support@onsoftarch.support">support@onsoftarch.support</a></article>
        </div>
    </div>
    <div>
        <div class="portal-section-head"><div><div class="portal-eyebrow">Plan ahead</div><h2>Recurring meetings</h2></div></div>
        <div class="portal-meetings">
            <article class="portal-card"><strong>Weekly Delivery Sync</strong><span>Tuesdays · 10:00 AST</span><small>Meeting link will be shared by your contact.</small></article>
            <article class="portal-card"><strong>Switch Health Review</strong><span>1st Thursday · 14:00 AST</span><small>Meeting link will be shared by your contact.</small></article>
        </div>
    </div>
</section>

<section class="portal-section">
    <div class="portal-section-head"><div><div class="portal-eyebrow">Shared resources</div><h2>Documents</h2></div></div>
    <div class="portal-card portal-note">Documents and links shared with your account will appear here.</div>
</section>

@push('scripts')
<script>
(() => {
    const tasks = [
        {task:'ON/2 switch capacity uplift',lead:'Bjorn Margon',status:'In Progress',priority:'High',due:'2026-10-16',latest:'Load test is scheduled.'},
        {task:'Seasonal peak readiness review',lead:'Bjorn Margon',status:'In Review',priority:'Urgent',due:'2026-10-10',latest:'Readiness report shared for review.'},
        {task:'ATM authorisation module migration',lead:'Rick Walters',status:'In Progress',priority:'High',due:'2026-10-23',latest:'Validating declined-response mapping.'},
        {task:'Real-time dashboard rollout',lead:'Bjorn Margon',status:'Blocked',priority:'Medium',due:'2026-10-19',latest:'Awaiting VPN access to reporting segment.'},
        {task:'Quarterly switch optimisation',lead:'Rick Walters',status:'Done',priority:'Low',due:'2026-10-02',latest:'Completed with latency improvements.'}
    ];
    const rows = document.getElementById('client-task-rows');
    if (!rows) return;
    let selected = 'all', query = '';
    const esc = value => String(value ?? '').replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[char]));
    function render() {
        const shown = tasks.filter(task => (selected === 'all' || task.status === selected) && (!query || Object.values(task).join(' ').toLowerCase().includes(query)));
        rows.innerHTML = shown.map(task => `<tr><td><strong>${esc(task.task)}</strong><small class="portal-latest">${esc(task.latest)}</small></td><td>${esc(task.lead)}</td><td><span class="portal-pill status-${task.status.toLowerCase().replace(' ','-')}">${esc(task.status)}</span></td><td><span class="portal-pill priority-${task.priority.toLowerCase()}">${esc(task.priority)}</span></td><td>${new Date(task.due+'T00:00:00').toLocaleDateString(undefined,{day:'2-digit',month:'short',year:'numeric'})}</td></tr>`).join('');
        document.getElementById('client-empty').hidden = shown.length > 0;
        document.getElementById('client-total').textContent = tasks.length;
        for (const [id, status] of [['client-progress','In Progress'],['client-review','In Review'],['client-blocked','Blocked'],['client-done','Done']]) document.getElementById(id).textContent = tasks.filter(task => task.status === status).length;
    }
    document.getElementById('client-filters').addEventListener('click', event => {
        const button = event.target.closest('button[data-status]'); if (!button) return;
        document.querySelectorAll('#client-filters button').forEach(item => item.classList.toggle('active', item === button));
        selected = button.dataset.status; render();
    });
    document.getElementById('client-search').addEventListener('input', event => { query = event.target.value.toLowerCase(); render(); });
    document.getElementById('client-export').addEventListener('click', () => {
        const csv = [['Task','Lead','Status','Priority','Target date'], ...tasks.map(task => [task.task,task.lead,task.status,task.priority,task.due])].map(row => row.map(value => '"'+String(value).replace(/"/g,'""')+'"').join(',')).join('\r\n');
        const link = document.createElement('a'); link.href = URL.createObjectURL(new Blob(['\ufeff'+csv],{type:'text/csv;charset=utf-8'})); link.download = 'client-project-status.csv'; link.click(); URL.revokeObjectURL(link.href);
    });
    render();
})();
</script>
@endpush