<footer style=" 
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #f9fafb;
    border-top: 1px solid #e5e7eb;
    padding: 22px 24px;
    font-size: 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #374151;
    z-index: 100;
">
    <div>
        <strong>&copy; <?= date("Y"); ?></strong>. All rights reserved.
    </div>
    <div>
        <strong>PT. Oilverse Indonesia</strong> System 4.0 - Project 337
    </div>


    <!-- Modal Alarm -->
    <div id="alarmPopup" style="
    display:none; position:fixed; top:0; left:0; 
    width:100%; height:100%; background:rgba(0,0,0,0.6); 
    justify-content:center; align-items:center; z-index:200;">
        <div style="
        background:#1e293b; padding:20px; border-radius:12px; 
        width:340px; text-align:center; color:#fff; 
        box-shadow:0 4px 12px rgba(0,0,0,0.5);">
            <h3 style="margin-bottom:12px; font-size:18px; color:#facc15;">Kelola Alarm</h3>

            <input type="time" id="alarmTime"
                style="padding:8px; border:none; border-radius:6px; margin-bottom:8px; width:90%; text-align:center; font-size:15px;">

            <input type="text" id="alarmLabel" placeholder="Label alarm (opsional)"
                style="padding:8px; border:none; border-radius:6px; margin-bottom:10px; width:90%; text-align:center; font-size:15px;">

            <br>
            <button onclick="addAlarm()" style="
            background:#3b82f6; color:#fff; border:none; padding:8px 12px; 
            border-radius:8px; margin-right:6px; cursor:pointer; font-size:14px;">
                Tambah Alarm
            </button>
            <button onclick="closeAlarm()" style="
            background:#ef4444; color:#fff; border:none; padding:8px 12px; 
            border-radius:8px; cursor:pointer; font-size:14px;">
                Tutup
            </button>

            <hr style="margin:14px 0; border-color:#475569;">
            <div id="alarmList" style="max-height:200px; overflow-y:auto; text-align:left; font-size:14px;"></div>
        </div>
    </div>

    <!-- Nada dering -->
    <audio id="alarmSound" src="../assets/bersandar.mp3" preload="auto"></audio>

    <script>
        window.userRole = "<?= $_SESSION['role'] ?? 'user' ?>";
    </script>

    <!-- Script alarm -->
    <script src="../js/alarm.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const role = window.userRole || "user";
            if (role !== "admin") {
                const addBtn = document.querySelector('button[onclick="addAlarm()"]');
                const timeInput = document.getElementById('alarmTime');
                const labelInput = document.getElementById('alarmLabel');
                if (addBtn) addBtn.style.display = 'none';
                if (timeInput) timeInput.disabled = true;
                if (labelInput) labelInput.disabled = true;
            }
        });
    </script>


</footer>