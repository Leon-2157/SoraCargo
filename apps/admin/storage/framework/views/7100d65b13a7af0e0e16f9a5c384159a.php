<style>
    /* Floating Action Button (FAB) */
    .ai-fab-btn {
        position: fixed;
        bottom: 25px;
        right: 25px;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
        color: #ffffff;
        border: none;
        box-shadow: 0 10px 25px rgba(2, 132, 199, 0.45);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 1050;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .ai-fab-btn:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 14px 30px rgba(2, 132, 199, 0.6);
        color: #ffffff;
    }
    .ai-fab-btn .online-ping {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 14px;
        height: 14px;
        background-color: #10b981;
        border: 2px solid #ffffff;
        border-radius: 50%;
        box-shadow: 0 0 8px rgba(16, 185, 129, 0.8);
    }

    /* Floating Chat Popup Window */
    .ai-chat-popup {
        position: fixed;
        bottom: 92px;
        right: 25px;
        width: 400px;
        max-width: calc(100vw - 40px);
        height: 560px;
        background: #ffffff;
        border-radius: 1rem;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.22);
        display: none;
        flex-direction: column;
        overflow: hidden;
        z-index: 1055;
        border: 1px solid rgba(226, 232, 240, 0.8);
        animation: aiPopupFadeIn 0.25s ease-out forwards;
    }
    @keyframes aiPopupFadeIn {
        from { opacity: 0; transform: translateY(20px) scale(0.96); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .ai-chat-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        padding: 14px 16px;
    }
    .ai-chat-body {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .ai-chat-body::-webkit-scrollbar {
        width: 5px;
    }
    .ai-chat-body::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .chat-bubble {
        max-width: 88%;
        padding: 10px 14px;
        border-radius: 14px;
        font-size: 0.82rem;
        line-height: 1.45;
        word-wrap: break-word;
    }
    .chat-bubble.bot {
        background: #ffffff;
        color: #1e293b;
        align-self: flex-start;
        border-bottom-left-radius: 3px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
    }
    .chat-bubble.user {
        background: #0284c7;
        color: #ffffff;
        align-self: flex-end;
        border-bottom-right-radius: 3px;
        box-shadow: 0 4px 10px rgba(2, 132, 199, 0.3);
    }
    .ai-suggestion-chip {
        display: inline-block;
        background: #ffffff;
        color: #0369a1;
        border: 1px solid #bae6fd;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 0.72rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
        margin: 2px;
    }
    .ai-suggestion-chip:hover {
        background: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
    }
    .ai-chat-footer {
        padding: 10px 14px;
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
    }
</style>

<!-- Floating Action Button (Global across all Admin Pages) -->
<button type="button" class="ai-fab-btn" id="btnToggleAiChat" title="Buka SoraBot AI Copilot">
    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'bot','size' => '1.6rem','class' => 'text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'bot','size' => '1.6rem','class' => 'text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
    <span class="online-ping" title="AI Copilot Online &amp; Database Connected"></span>
</button>

<!-- Floating AI Chat Pop-up Window -->
<div class="ai-chat-popup" id="aiChatWindow">
    <!-- Header -->
    <div class="ai-chat-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <div class="p-2 bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'bot','size' => '1.2rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'bot','size' => '1.2rem']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
            </div>
            <div>
                <div class="fw-bold fs-6 text-white leading-tight mb-0">SoraBot AI Copilot</div>
                <div class="text-white-50 small d-flex align-items-center gap-1" style="font-size: 0.72rem;">
                    <span class="d-inline-block rounded-circle bg-success" style="width: 7px; height: 7px;"></span> 
                    <span id="aiActivePageBadge">Konteks Halaman Aktif</span>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-1">
            <button type="button" class="btn btn-xs btn-outline-light border-0 py-0 px-1 text-white-50" id="btnClearAiChat" title="Bersihkan Percakapan (Reset Chat)">
                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'refresh-cw','size' => '0.85rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'refresh-cw','size' => '0.85rem']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
            </button>
            <button type="button" class="btn btn-xs btn-outline-light border-0 py-0 px-1 text-white-50" id="btnCloseAiChat" title="Tutup Jendela">
                <span class="fs-5 lh-1">&times;</span>
            </button>
        </div>
    </div>

    <!-- Messages Body Thread -->
    <div class="ai-chat-body" id="aiChatThread">
        <!-- Chat bubbles loaded dynamically from sessionStorage or default greeting -->
    </div>

    <!-- Footer Input Bar -->
    <div class="ai-chat-footer">
        <form id="aiChatForm" class="d-flex align-items-center gap-2 m-0">
            <?php echo csrf_field(); ?>
            <input type="text" id="aiChatInput" class="form-control form-control-sm rounded-pill px-3" placeholder="Tanya operasional SoraCargo..." autocomplete="off">
            <button type="submit" class="btn btn-primary btn-sm rounded-circle d-flex align-items-center justify-content-center p-0 flex-shrink-0" style="width: 34px; height: 34px;" id="btnSendAiChat">
                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-up','size' => '1rem','class' => 'text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-up','size' => '1rem','class' => 'text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
            </button>
        </form>
        <div class="text-center text-muted mt-1" style="font-size: 0.65rem;">
            Didukung Konteks Database Nyata &amp; Model AI SoraCargo
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnToggleAi = document.getElementById('btnToggleAiChat');
    const btnCloseAi = document.getElementById('btnCloseAiChat');
    const btnClearAi = document.getElementById('btnClearAiChat');
    const aiWindow = document.getElementById('aiChatWindow');
    const aiForm = document.getElementById('aiChatForm');
    const aiInput = document.getElementById('aiChatInput');
    const aiThread = document.getElementById('aiChatThread');
    const aiActivePageBadge = document.getElementById('aiActivePageBadge');

    if (!btnToggleAi || !aiWindow) return;

    // 1. Tentukan Nama & Konteks Halaman Aktif
    function getActivePageInfo() {
        const path = window.location.pathname;
        const pageTitleEl = document.querySelector('h4.text-dark') || document.querySelector('h1, h2, h3');
        let title = pageTitleEl ? pageTitleEl.innerText.trim() : document.title;
        let tab = '';

        const currentViewText = document.getElementById('currentViewText');
        if (currentViewText) {
            tab = currentViewText.innerText.trim();
        }

        return { path, title, tab };
    }

    const pageInfo = getActivePageInfo();
    if (aiActivePageBadge) {
        aiActivePageBadge.textContent = pageInfo.tab ? `${pageInfo.title} (${pageInfo.tab})` : pageInfo.title;
    }

    // 2. Kueri Cepat Adaptif Berdasarkan Halaman yang Sedang Dibuka
    function getAdaptiveChipsHtml() {
        const path = window.location.pathname.toLowerCase();
        let chips = [];

        if (path.includes('ports') || path.includes('pelabuhan')) {
            chips = [
                { label: '📊 Ringkasan Pelabuhan', query: 'apa ringkasan hari ini' },
                { label: '🚢 Pelabuhan 2 Rute', query: 'berapa total pelabuhan yang memiliki 2 rute?' },
                { label: '⚓ Kapasitas Depo Priok', query: 'bagaimana kapasitas terminal di Tanjung Priok?' },
                { label: '💰 Cek Saldo Escrow', query: 'berapa total dana terkunci di rekening escrow?' }
            ];
        } else if (path.includes('escrow') || path.includes('finance') || path.includes('invoices')) {
            chips = [
                { label: '💰 Ringkasan Keuangan', query: 'apa ringkasan hari ini' },
                { label: '🔒 Saldo Escrow', query: 'berapa total dana terkunci di rekening escrow?' },
                { label: '📈 Margin Platform', query: 'berapa total keuntungan margin platform berjalan?' },
                { label: '⚠️ Mitra Overdue', query: 'cek daftar mitra korporat yang tagihannya overdue' }
            ];
        } else if (path.includes('fleet') || path.includes('manifes') || path.includes('bookings')) {
            chips = [
                { label: '🚢 Ringkasan Armada', query: 'apa ringkasan hari ini' },
                { label: '🌊 Kapal Berlayar', query: 'kapal mana saja yang sedang berlayar saat ini?' },
                { label: '⚠️ Cuaca & BMKG', query: 'apakah ada kapal yang tertahan cuaca buruk BMKG?' },
                { label: '📋 Booking Terbaru', query: 'bagaimana status pesanan booking yang masuk hari ini?' }
            ];
        } else {
            // Default Dashboard (Domestik / Internasional)
            chips = [
                { label: '📊 Ringkasan Hari Ini', query: 'apa ringkasan hari ini' },
                { label: '🚢 Kapal Berlayar', query: 'kapal mana saja yang sedang berlayar saat ini?' },
                { label: '💰 Saldo Escrow', query: 'berapa total dana terkunci di rekening escrow?' },
                { label: '⚓ Pelabuhan 2 Rute', query: 'berapa total pelabuhan yang memiliki 2 rute?' },
                { label: '🌦️ Cuaca Selat Sunda', query: 'bagaimana kondisi cuaca di selat sunda saat ini?' }
            ];
        }

        let html = '<div class="mt-1" id="aiChipsContainer"><div class="small text-muted mb-1" style="font-size: 0.7rem;">Kueri Cepat:</div>';
        chips.forEach(c => {
            html += `<span class="ai-suggestion-chip" onclick="askCopilot('${c.query}')">${c.label}</span>`;
        });
        html += '</div>';
        return html;
    }

    // 3. Render Percakapan dari sessionStorage (Persisten Antar Halaman)
    const STORAGE_KEY = 'sorabot_chat_history_v1';

    function renderDefaultGreeting() {
        const info = getActivePageInfo();
        const displayPage = info.tab ? `${info.title} (${info.tab})` : info.title;
        aiThread.innerHTML = `
            <div class="chat-bubble bot">
                <div class="fw-bold text-primary mb-1">🤖 SoraBot AI Copilot</div>
                <div>Halo Superadmin! Saya siap membantu Anda di halaman <strong>${displayPage}</strong>. Tanyakan ringkasan status operasional, verifikasi kargo, atau telusuri data lintas modul di sistem SoraCargo.</div>
            </div>
            ${getAdaptiveChipsHtml()}
        `;
    }

    function loadChatHistory() {
        try {
            const raw = sessionStorage.getItem(STORAGE_KEY);
            if (!raw) {
                renderDefaultGreeting();
                return;
            }
            const history = JSON.parse(raw);
            if (!Array.isArray(history) || history.length === 0) {
                renderDefaultGreeting();
                return;
            }

            aiThread.innerHTML = '';
            history.forEach(item => {
                appendBubbleToDom(item.sender, item.text);
            });
            aiThread.scrollTop = aiThread.scrollHeight;
        } catch (e) {
            renderDefaultGreeting();
        }
    }

    function saveMessageToHistory(sender, text) {
        try {
            let history = [];
            const raw = sessionStorage.getItem(STORAGE_KEY);
            if (raw) {
                history = JSON.parse(raw);
            }
            history.push({ sender, text, timestamp: new Date().toISOString() });
            sessionStorage.setItem(STORAGE_KEY, JSON.stringify(history));
        } catch (e) {}
    }

    function appendBubbleToDom(sender, text) {
        const bubble = document.createElement('div');
        bubble.className = `chat-bubble ${sender}`;

        let formatted = text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/`([^`]+)`/g, '<code class="bg-light text-primary px-1 py-0 rounded" style="font-size:0.78rem;">$1</code>')
            .replace(/\n/g, '<br>');

        if (sender === 'bot') {
            bubble.innerHTML = `<div class="fw-bold text-primary mb-1" style="font-size:0.75rem;">🤖 SoraBot</div>` + formatted;
        } else {
            bubble.innerHTML = formatted;
        }

        aiThread.appendChild(bubble);
        aiThread.scrollTop = aiThread.scrollHeight;
    }

    // Load riwayat saat halaman pertama kali dibuka
    loadChatHistory();

    // Toggle Chat Window
    btnToggleAi.addEventListener('click', function () {
        if (aiWindow.style.display === 'flex') {
            aiWindow.style.display = 'none';
        } else {
            aiWindow.style.display = 'flex';
            aiInput.focus();
            aiThread.scrollTop = aiThread.scrollHeight;
        }
    });

    btnCloseAi.addEventListener('click', function () {
        aiWindow.style.display = 'none';
    });

    // Reset Chat Percakapan
    btnClearAi.addEventListener('click', function () {
        sessionStorage.removeItem(STORAGE_KEY);
        renderDefaultGreeting();
    });

    window.askCopilot = function (query) {
        if (aiWindow.style.display !== 'flex') {
            aiWindow.style.display = 'flex';
        }
        aiInput.value = query;
        aiForm.dispatchEvent(new Event('submit'));
    };

    // Submit Chat Form
    aiForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const message = aiInput.value.trim();
        if (!message) return;

        // Tampilkan bubble user & simpan
        appendBubbleToDom('user', message);
        saveMessageToHistory('user', message);
        aiInput.value = '';

        // Tampilkan indikator loading
        const loadingBubble = document.createElement('div');
        loadingBubble.className = 'chat-bubble bot';
        loadingBubble.id = 'aiLoadingBubble';
        loadingBubble.innerHTML = `<span class="spinner-border spinner-border-sm text-primary me-2" style="width: 0.8rem; height: 0.8rem;"></span> <span class="text-muted fst-italic">SoraBot sedang menganalisa data sistem...</span>`;
        aiThread.appendChild(loadingBubble);
        aiThread.scrollTop = aiThread.scrollHeight;

        const info = getActivePageInfo();

        fetch("<?php echo e(route('admin.ai-copilot.chat')); ?>", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>",
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                message: message,
                page_path: info.path,
                page_title: info.title,
                active_tab: info.tab
            })
        })
        .then(res => res.json())
        .then(data => {
            const loader = document.getElementById('aiLoadingBubble');
            if (loader) loader.remove();

            if (data.success && data.reply) {
                appendBubbleToDom('bot', data.reply);
                saveMessageToHistory('bot', data.reply);
            } else {
                const failText = data.reply || 'Maaf, terjadi kendala saat memproses kueri. Silakan coba kembali.';
                appendBubbleToDom('bot', failText);
                saveMessageToHistory('bot', failText);
            }
        })
        .catch(() => {
            const loader = document.getElementById('aiLoadingBubble');
            if (loader) loader.remove();
            const errText = 'Gagal menghubungi server AI SoraCargo.';
            appendBubbleToDom('bot', errText);
            saveMessageToHistory('bot', errText);
        });
    });
});
</script>
<?php /**PATH /home/leon/Downloads/SoraCargo/apps/admin/resources/views/partials/ai-copilot.blade.php ENDPATH**/ ?>