// ========================
// alarm.js (versi final - multi alarm + persistence)
// ========================

(function(){
  if (window.__alarmScriptLoaded) return;
  window.__alarmScriptLoaded = true;

  const STORAGE_KEY = 'alarms_v1';
  let alarms = [];
  let intervalId = null;

  // helper DOM getters (may return null on pages without certain elements)
  const el = id => document.getElementById(id);

  // load dari localStorage
  function loadAlarms() {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      alarms = raw ? JSON.parse(raw) : [];
      // Ensure shape and fallback fields
      alarms = alarms.map(a => ({
        id: a.id || Date.now() + Math.random(),
        time: a.time,
        label: a.label || 'Alarm',
        enabled: (typeof a.enabled === 'boolean') ? a.enabled : true,
        lastTriggered: a.lastTriggered || null
      }));
    } catch (e) {
      alarms = [];
    }
    renderAlarms();
    updateSummary();
  }

  function saveAlarms() {
    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(alarms));
    } catch(e) {}
  }

  // open/close popup (popup DOM is in footer.php)
  window.openAlarm = function() {
    const p = el('alarmPopup');
    if (p) {
      p.style.display = 'flex';
      renderAlarms(); // render every open
    } else {
      alert('Popup alarm tidak ditemukan (cek footer).');
    }
  };

  window.closeAlarm = function() {
    const p = el('alarmPopup');
    if (p) p.style.display = 'none';
  };

  // add new alarm
  window.addAlarm = function() {
    const timeInput = el('alarmTime');
    const labelInput = el('alarmLabel');
    const time = timeInput ? timeInput.value : '';
    const label = labelInput ? labelInput.value.trim() : 'Alarm';

    if (!time) { alert('⚠️ Silakan pilih jam alarm!'); return; }

    alarms.push({
      id: Date.now() + Math.floor(Math.random()*9999),
      time,
      label: label || 'Alarm',
      enabled: true,
      lastTriggered: null
    });
    saveAlarms();
    renderAlarms();
    updateSummary();
    if (timeInput) timeInput.value = '';
    if (labelInput) labelInput.value = '';
  };

  // delete by id
  window.deleteAlarm = function(id) {
    alarms = alarms.filter(a => a.id !== id);
    saveAlarms();
    renderAlarms();
    updateSummary();
  };

  // toggle enable/disable
  window.toggleAlarm = function(id) {
    const a = alarms.find(x => x.id === id);
    if (!a) return;
    a.enabled = !a.enabled;
    saveAlarms();
    renderAlarms();
    updateSummary();
  };

  // render list inside popup
  function renderAlarms() {
  const list = el('alarmList');
  if (!list) return;
  list.innerHTML = '';
  if (!alarms || alarms.length === 0) {
    list.innerHTML = "<p style='color:#94a3b8;'>Belum ada alarm</p>";
    return;
  }

  const isAdmin = (window.userRole === 'admin');
  const sorted = alarms.slice().sort((x, y) => x.time.localeCompare(y.time));

  sorted.forEach(a => {
    const row = document.createElement('div');
    row.style.cssText = 'padding:8px; border-bottom:1px solid #475569; display:flex; align-items:center; justify-content:space-between; gap:8px;';
    const left = document.createElement('div');
    left.innerHTML = `<div style="font-weight:600; color:#facc15">${a.time}</div><div style="font-size:13px; color:#fff">${a.label}</div>`;

    const controls = document.createElement('div');
    controls.style.display = 'flex';
    controls.style.gap = '8px';

    if (isAdmin) {
      const toggleBtn = document.createElement('button');
      toggleBtn.textContent = a.enabled ? 'On' : 'Off';
      toggleBtn.style.cssText = 'background:#3b82f6;color:#fff;border:none;padding:6px 8px;border-radius:6px;cursor:pointer;';
      toggleBtn.onclick = () => toggleAlarm(a.id);

      const delBtn = document.createElement('button');
      delBtn.textContent = 'Hapus';
      delBtn.style.cssText = 'background:#ef4444;color:#fff;border:none;padding:6px 8px;border-radius:6px;cursor:pointer;';
      delBtn.onclick = () => { if (confirm('Hapus alarm ini?')) deleteAlarm(a.id); };

      controls.appendChild(toggleBtn);
      controls.appendChild(delBtn);
    }

    row.appendChild(left);
    row.appendChild(controls);
    list.appendChild(row);
  });
}

  // update small summary on home: alarm count & next alarm
  function updateSummary() {
    const countEl = el('alarmCount');
    const nextEl = el('nextAlarm');
    if (countEl) countEl.textContent = alarms.filter(a => a.enabled).length;
    if (nextEl) {
      const now = new Date();
      const currentHm = now.toTimeString().slice(0,5); // HH:MM
      // find next enabled alarm after now (today), else earliest tomorrow
      const enabled = alarms.filter(a => a.enabled).slice();
      if (enabled.length === 0) {
        nextEl.textContent = 'Belum ada jadwal';
        return;
      }
      // sort by time
      enabled.sort((x,y) => x.time.localeCompare(y.time));
      // find first > now
      const after = enabled.find(a => a.time > currentHm);
      const next = after || enabled[0];
      nextEl.textContent = `${next.time} — ${next.label}`;
    }
  }

  // alarm trigger check each second
  function checkAlarms() {
    const now = new Date();
    const hm = now.toTimeString().slice(0,5);
    const today = now.toISOString().slice(0,10); // YYYY-MM-DD

    alarms.forEach(a => {
      if (!a.enabled) return;
      if (a.time === hm) {
        if (a.lastTriggered === today) return; // already triggered today
        // trigger
        try {
          const sound = el('alarmSound');
          if (sound && typeof sound.play === 'function') {
            sound.play().catch(()=>{/*ignore autoplay block*/});
          }
        } catch(e){}
        try { alert('⏰ Alarm: ' + a.label + ' (' + a.time + ')'); } catch(e){}
        a.lastTriggered = today;
        saveAlarms();
        renderAlarms();
        updateSummary();
      }
    });
  }

  // update clock function (will update on any page that has #clock/#date)
  function updateClock() {
    const now = new Date();
    const time = now.toLocaleTimeString('id-ID', { hour12: false });
    const date = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

    const clockEl = el('clock');
    const dateEl = el('date');
    if (clockEl) clockEl.textContent = time;
    if (dateEl) dateEl.textContent = date;
  }

  // start interval safely (avoid dupes across pages/includes)
  if (!window.__alarmInterval) {
    window.__alarmInterval = setInterval(() => {
      updateClock();
      checkAlarms();
      updateSummary();
    }, 1000);
  }

  // init on load
  document.addEventListener('DOMContentLoaded', () => {
    loadAlarms();
    updateClock();
    updateSummary();
  });

  // expose some helpers for console (optional)
  window.__alarms_read = () => JSON.parse(JSON.stringify(alarms));
  window.__alarms_clear = () => { alarms = []; saveAlarms(); renderAlarms(); updateSummary(); };

})();
