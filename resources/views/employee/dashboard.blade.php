<div class="portal-heading">
    <div>
        <div class="portal-eyebrow">Banco di Caribe · Team Hub</div>
        <h1>Everything the <em>team</em> needs</h1>
        <p>Manage delivery tasks, deadlines and progress updates across the engagement.</p>
    </div>
    <div class="portal-badge"><span></span><span id="employee-save-state">Saved locally</span></div>
</div>

<section class="portal-summary" aria-label="Task summary">
    <article class="portal-stat"><span>Total tasks</span><strong id="employee-total">0</strong></article>
    <article class="portal-stat blue"><span>In progress</span><strong id="employee-progress">0</strong></article>
    <article class="portal-stat purple"><span>In review</span><strong id="employee-review">0</strong></article>
    <article class="portal-stat red"><span>Blocked</span><strong id="employee-blocked">0</strong></article>
    <article class="portal-stat"><span>Done</span><strong id="employee-done">0</strong></article>
</section>

<section class="portal-section">
    <div class="portal-section-head"><div><div class="portal-eyebrow">Work management</div><h2>Team tasks</h2></div><div class="portal-actions"><button class="portal-btn" id="employee-export">↓ Export CSV</button><button class="portal-btn primary" id="employee-add">＋ Add task</button></div></div>
    <p class="portal-callout">Browser demo board: changes are saved in this browser only and are not yet shared with other accounts.</p>
    <div class="portal-toolbar">
        <div class="portal-filters" id="employee-filters"><button class="active" data-status="all">All</button><button data-status="Backlog">Backlog</button><button data-status="In Progress">In Progress</button><button data-status="In Review">In Review</button><button data-status="Blocked">Blocked</button><button data-status="Done">Done</button></div>
        <input class="portal-search" id="employee-search" type="search" placeholder="Search tasks, owners, stakeholders…" aria-label="Search tasks">
    </div>
    <div class="portal-table-wrap"><table class="portal-table employee-table"><thead><tr><th>Task</th><th>Description</th><th>Owner</th><th>Stakeholder</th><th>Status</th><th>Priority</th><th>Due</th><th></th></tr></thead><tbody id="employee-task-rows"></tbody></table><div class="portal-empty" id="employee-empty" hidden>No tasks match. Adjust your filters or add a task.</div></div>
</section>

<section class="portal-section portal-two-col">
    <div>
        <div class="portal-section-head"><div><div class="portal-eyebrow">Team</div><h2>Team contacts</h2></div></div>
        <div class="portal-contact-grid"><article class="portal-card"><strong>Bjorn Margon</strong><span>Managing Director</span><a href="mailto:Bjorn@onsoftarch.support">Bjorn@onsoftarch.support</a></article><article class="portal-card"><strong>Rich Sathoff</strong><span>Legacy System Specialist</span><a href="mailto:rsathoff@onsoftarch.support">rsathoff@onsoftarch.support</a></article><article class="portal-card"><strong>Rick Walters</strong><span>Legacy System Specialist</span><a href="mailto:rwalters@onsoftarch.support">rwalters@onsoftarch.support</a></article><article class="portal-card"><strong>Wang</strong><span>Front End Developer</span><a href="mailto:wang@onsoftarch.support">wang@onsoftarch.support</a></article></div>
    </div>
    <div>
        <div class="portal-section-head"><div><div class="portal-eyebrow">Schedule</div><h2>Team meetings</h2></div></div>
        <div class="portal-meetings"><article class="portal-card"><strong>Internal Standup</strong><span>Weekdays · 09:00</span></article><article class="portal-card"><strong>Weekly Delivery Sync</strong><span>Tuesdays · 10:00 AST</span></article><article class="portal-card"><strong>Switch Health Review</strong><span>1st Thursday · 14:00 AST</span></article></div>
    </div>
</section>

@push('scripts')
<script>
(() => {
    const key = 'onsoftarch.employee-board.v1';
    const seed = [
        {id:1,task:'Migrate ATM auth module to ON/2',desc:'Port the legacy auth handler and validate against the test card set.',owner:'Rich',stakeholder:'Banco di Caribe',status:'In Progress',priority:'High',due:'2026-10-14'},
        {id:2,task:'Seasonal capacity load test',desc:'Run peak-volume simulation and document headroom and bottlenecks.',owner:'Bjorn',stakeholder:'Banco di Caribe',status:'In Review',priority:'Urgent',due:'2026-10-10'},
        {id:3,task:'Document legacy reconciliation batch',desc:'Document the nightly EOD reconciliation job for knowledge transfer.',owner:'Wang',stakeholder:'Regional Bank',status:'Backlog',priority:'Medium',due:'2026-10-28'},
        {id:4,task:'Dashboard health-monitor alerts',desc:'Configure early-warning thresholds for latency, batch windows and capacity.',owner:'Bjorn',stakeholder:'Banco di Caribe',status:'Done',priority:'Medium',due:'2026-10-03'}
    ];
    let tasks;
    try { tasks = JSON.parse(localStorage.getItem(key)) || seed; } catch { tasks = seed; }
    let status = 'all', query = '';
    const rows = document.getElementById('employee-task-rows');
    const esc = value => String(value ?? '').replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[char]));
    const statuses = ['Backlog','In Progress','In Review','Blocked','Done'];
    const priorities = ['Low','Medium','High','Urgent'];
    function persist() {
        localStorage.setItem(key, JSON.stringify(tasks));
        const indicator = document.getElementById('employee-save-state');
        indicator.textContent = 'Saved locally';
    }
    function select(options, value, field, id) {
        return `<select aria-label="${field}" data-field="${field}" data-id="${id}">${options.map(option => `<option ${option === value ? 'selected' : ''}>${option}</option>`).join('')}</select>`;
    }
    function render() {
        const shown = tasks.filter(task => (status === 'all' || task.status === status) && (!query || Object.values(task).join(' ').toLowerCase().includes(query)));
        rows.innerHTML = shown.map(task => `<tr data-id="${task.id}"><td><input data-field="task" value="${esc(task.task)}" aria-label="Task name"></td><td><textarea data-field="desc" aria-label="Description">${esc(task.desc)}</textarea></td><td><input data-field="owner" value="${esc(task.owner)}" aria-label="Owner"></td><td><input data-field="stakeholder" value="${esc(task.stakeholder)}" aria-label="Stakeholder"></td><td>${select(statuses,task.status,'status',task.id)}</td><td>${select(priorities,task.priority,'priority',task.id)}</td><td><input type="date" data-field="due" value="${esc(task.due)}" aria-label="Due date"></td><td><button class="portal-delete" data-delete="${task.id}" aria-label="Delete task">×</button></td></tr>`).join('');
        document.getElementById('employee-empty').hidden = shown.length > 0;
        document.getElementById('employee-total').textContent = tasks.length;
        for (const [id, value] of [['employee-progress','In Progress'],['employee-review','In Review'],['employee-blocked','Blocked'],['employee-done','Done']]) document.getElementById(id).textContent = tasks.filter(task => task.status === value).length;
    }
    rows.addEventListener('change', event => {
        const input = event.target.closest('[data-field]'); if (!input) return;
        const task = tasks.find(item => item.id === Number(input.closest('tr').dataset.id)); if (!task) return;
        task[input.dataset.field] = input.value; persist(); render();
    });
    rows.addEventListener('click', event => {
        const button = event.target.closest('[data-delete]'); if (!button) return;
        tasks = tasks.filter(task => task.id !== Number(button.dataset.delete)); persist(); render();
    });
    document.getElementById('employee-filters').addEventListener('click', event => {
        const button = event.target.closest('button[data-status]'); if (!button) return;
        document.querySelectorAll('#employee-filters button').forEach(item => item.classList.toggle('active', item === button));
        status = button.dataset.status; render();
    });
    document.getElementById('employee-search').addEventListener('input', event => { query = event.target.value.toLowerCase(); render(); });
    document.getElementById('employee-add').addEventListener('click', () => {
        tasks.unshift({id:Date.now(),task:'',desc:'',owner:'Unassigned',stakeholder:'',status:'Backlog',priority:'Medium',due:''});
        status = 'all'; query = ''; document.getElementById('employee-search').value = '';
        document.querySelectorAll('#employee-filters button').forEach(item => item.classList.toggle('active', item.dataset.status === 'all'));
        persist(); render(); rows.querySelector('input[data-field="task"]')?.focus();
    });
    document.getElementById('employee-export').addEventListener('click', () => {
        const columns = ['task','desc','owner','stakeholder','status','priority','due'];
        const csv = [columns, ...tasks.map(task => columns.map(column => task[column]))].map(row => row.map(value => '"'+String(value ?? '').replace(/"/g,'""')+'"').join(',')).join('\r\n');
        const link = document.createElement('a'); link.href = URL.createObjectURL(new Blob(['\ufeff'+csv],{type:'text/csv;charset=utf-8'})); link.download = 'onsoftarch-tasks.csv'; link.click(); URL.revokeObjectURL(link.href);
    });
    render();
})();
</script>
@endpush