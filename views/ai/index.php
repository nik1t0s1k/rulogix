<?php
use yii\helpers\Url;
?>

<div class="ai-layout">

    <!-- SIDEBAR -->
    <aside class="ai-sidebar card">

        <div class="ai-sidebar__header">
            <div>
                <h3>AI Assistant</h3>
                <p>Умные диалоги</p>
            </div>
        </div>

        <div id="chatList" class="ai-chatlist"></div>

    </aside>

    <!-- MAIN -->
    <main class="ai-main">

        <div class="ai-topbar card">
            <div>
                <h4 id="chatTitle">Новый чат</h4>
                <span id="chatStatus">online</span>
            </div>
        </div>

        <div id="chat" class="ai-chat card"></div>

        <div class="ai-input card">
            <input id="msg"
                   placeholder="Напиши сообщение..."
                   onkeydown="if(event.key==='Enter') sendMsg()">

            <button class="ai-send" onclick="sendMsg()">Отправить</button>
        </div>

    </main>
</div>

<style>
    .ai-layout{display:flex;gap:20px;height:calc(100vh - 120px);}
    .ai-sidebar{width:280px;display:flex;flex-direction:column;padding:14px;}
    .ai-sidebar__header h3{margin:0;}
    .ai-sidebar__header p{margin:0;font-size:12px;color:var(--muted);}

    .ai-chatlist{display:flex;flex-direction:column;gap:6px;overflow:auto;}

    .chat-item{
        padding:10px;
        border-radius:10px;
        cursor:pointer;
        border:1px solid transparent;
    }
    .chat-item:hover{background:#f1f5f9;}
    .chat-item.active{border:1px solid #4f46e5;background:#eef2ff;}

    .ai-main{flex:1;display:flex;flex-direction:column;gap:14px;}
    .ai-topbar{padding:12px 16px;}

    .ai-chat{
        flex:1;
        overflow:auto;
        padding:16px;
        display:flex;
        flex-direction:column;
        gap:10px;
    }

    .msg{
        max-width:70%;
        padding:10px 12px;
        border-radius:14px;
    }
    .msg.user{align-self:flex-end;background:#4f46e5;color:#fff;}
    .msg.ai{align-self:flex-start;background:#f1f5f9;}

    .ai-input{display:flex;gap:10px;padding:12px;}
    .ai-input input{flex:1;border:none;outline:none;}
    .ai-send{
        background:#4f46e5;
        border:none;
        color:#fff;
        padding:10px 16px;
        border-radius:10px;
    }
</style>

<script>

    let currentChatId = null;
    let chatsCache = [];

    /* ================= LOAD CHATS ================= */
    async function loadChats() {

        const res = await fetch("<?= Url::to(['/ai/chats']) ?>");
        if (!res.ok) return;

        chatsCache = await res.json();

        const box = document.getElementById('chatList');
        box.innerHTML = '';

        chatsCache.forEach(c => {

            const div = document.createElement('div');
            div.className = 'chat-item';

            if (c.id === currentChatId) {
                div.classList.add('active');
            }

            div.innerText = c.title;

            div.onclick = () => {
                currentChatId = c.id;
                document.getElementById('chatTitle').innerText = c.title;

                highlightActive();
                loadMessages(c.id);
            };

            box.appendChild(div);
        });
    }

    /* ================= ACTIVE STATE ================= */
    function highlightActive(){
        document.querySelectorAll('.chat-item')
            .forEach(el => el.classList.remove('active'));
    }

    /* ================= LOAD MESSAGES ================= */
    async function loadMessages(chatId){

        const res = await fetch("<?= Url::to(['/ai/messages']) ?>?chat_id=" + chatId);
        if (!res.ok) return;

        const data = await res.json();

        const chat = document.getElementById('chat');
        chat.innerHTML = '';

        data.forEach(m => {
            addMessage(m.role === 'user' ? 'user' : 'ai', m.message);
        });

        chat.scrollTop = chat.scrollHeight;
    }

    /* ================= SEND MESSAGE ================= */
    async function sendMsg(){

        const input = document.getElementById('msg');
        const text = input.value.trim();
        if (!text) return;

        input.value = '';

        addMessage('user', text);
        const aiDiv = addMessage('ai', '...');

        /* ================= AUTO CREATE CHAT ================= */
        if (!currentChatId) {

            const title = text.slice(0, 40);

            const res = await fetch("<?= Url::to(['/ai/create-chat']) ?>", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
                },
                body: 'title=' + encodeURIComponent(title)
            });

            const data = await res.json();

            if (data.success) {
                currentChatId = data.id;
                document.getElementById('chatTitle').innerText = data.title;

                await loadChats();
            }
        }

        /* ================= AI RESPONSE ================= */
        const res = await fetch("<?= Url::to(['/ai/send']) ?>", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
            },
            body:
                "message=" + encodeURIComponent(text) +
                "&chat_id=" + encodeURIComponent(currentChatId)
        });

        const data = await res.json();

        aiDiv.innerText = data.reply ?? 'error';

        await loadChats();
    }

    /* ================= UI ================= */
    function addMessage(type, text){

        const chat = document.getElementById('chat');

        const div = document.createElement('div');
        div.className = 'msg ' + type;
        div.innerText = text;

        chat.appendChild(div);
        chat.scrollTop = chat.scrollHeight;

        return div;
    }

    /* INIT */
    loadChats();

</script>