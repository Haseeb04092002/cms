<script>
    const USER_ID = <?= (int)$this->session->userdata('user_id') ?>;
    const base_url = "<?= base_url() ?>";

    let currentChatUserId = null;

    function openChat(uid, roleId, name) {

        document.getElementById('msgInput').value = "";
        document.getElementById('currentReceiverId').value = uid;
        document.getElementById('currentReceiverRoleId').value = roleId;
        document.getElementById('chatUserName').innerText = name;

        $.get(base_url + 'Chatting/open_chat/' + uid + '/' + roleId, function(res) {

            let data = JSON.parse(res);
            let box = document.getElementById('chatBox');
            box.innerHTML = '';

            data.forEach(m => {

                if (parseInt(m.senderId) === parseInt(USER_ID)) {
                    box.innerHTML += `
                <div class="d-flex justify-content-end mb-3">
                    <div class="bg-primary text-white rounded p-3" style="max-width:75%;">
                        <div>${escapeHtml(m.messageText)}</div>
                        <div class="small text-end">${m.addedOn}</div>
                    </div>
                </div>
            `;
                } else {
                    box.innerHTML += `
                <div class="d-flex mb-3">
                    <div class="me-2">
                        <i class="bi bi-person-circle fs-3 text-secondary"></i>
                    </div>
                    <div class="bg-white border rounded p-3">
                        <div>${escapeHtml(m.messageText)}</div>
                        <div class="small text-muted text-end">${m.addedOn}</div>
                    </div>
                </div>
            `;
                }
            });

            box.scrollTop = box.scrollHeight;

            let badge = document.getElementById('badge_' + uid);
            if (badge) {
                badge.style.display = 'none';
                badge.innerText = 0;
            }

            refreshChatList();
        });
    }

    function refreshChatList() {
        $.get("<?= site_url('Chatting/chats') ?>", function(res) {
            let data = JSON.parse(res);
            let html = '';

            data.forEach(u => {
                html += `
            <a href="javascript:void(0)"
                onclick="openChat(${u.profile_id}, ${u.roleId}, '${escapeHtml(u.name)}')"
                class="list-group-item list-group-item-action ${u.unread_count > 0 ? 'active' : ''}"
                id="chat_user_${u.chat_key}">

                <div class="d-flex align-items-center">
                    <i class="bi bi-person-circle fs-3 me-2"></i>

                    <div class="flex-grow-1">
                        <div class="fw-semibold">
                            ${escapeHtml(u.name)}
                            <small class="text-muted">(${u.profile_type})</small>
                        </div>

                        <div class="small text-muted" id="last_msg_${u.chat_key}">
                            ${u.last_message ? escapeHtml(u.last_message) : 'Start a new chat'}
                        </div>
                    </div>

                    <span class="badge bg-danger rounded-pill"
                        id="badge_${u.chat_key}"
                        style="${u.unread_count > 0 ? '' : 'display:none'}">
                        ${u.unread_count}
                    </span>
                </div>
            </a>`;
            });

            document.getElementById('chatList').innerHTML = html;
        });
    }

    $(document).off('submit', '#chatForm').on('submit', '#chatForm', function(e) {
        e.preventDefault();

        $.ajax({
            url: "<?= site_url('Chatting/send_message') ?>",
            type: "POST",
            data: new FormData(this),
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            success: function(response) {

                if (response.status === true) {
                    let rid = document.getElementById('currentReceiverId').value;
                    let rrole = document.getElementById('currentReceiverRoleId').value;
                    let name = document.getElementById('chatUserName').innerText;

                    openChat(parseInt(rid), parseInt(rrole), name);
                    refreshChatList();
                }
            }
        });
    });

    setInterval(() => {

        const receiverId = document.getElementById('currentReceiverId').value;
        const receiverRoleId = document.getElementById('currentReceiverRoleId').value;

        if (receiverId) {
            $.get(base_url + 'Chatting/open_chat/' + receiverId + '/' + receiverRoleId, function(res) {

                let data = JSON.parse(res);
                let box = document.getElementById('chatBox');
                let html = '';

                data.forEach(m => {
                    if (parseInt(m.senderId) === parseInt(USER_ID)) {
                        html += `
                    <div class="d-flex justify-content-end mb-3">
                        <div class="bg-primary text-white rounded p-3" style="max-width:75%;">
                            <div>${escapeHtml(m.messageText)}</div>
                            <div class="small text-end">${m.addedOn}</div>
                        </div>
                    </div>
                `;
                    } else {
                        html += `
                    <div class="d-flex mb-3">
                        <div class="me-2">
                            <i class="bi bi-person-circle fs-3 text-secondary"></i>
                        </div>
                        <div class="bg-white border rounded p-3">
                            <div>${escapeHtml(m.messageText)}</div>
                            <div class="small text-muted text-end">${m.addedOn}</div>
                        </div>
                    </div>
                `;
                    }
                });

                if (box.innerHTML !== html) {
                    box.innerHTML = html;
                    box.scrollTop = box.scrollHeight;
                }
            });
        }

        refreshChatList();

    }, 2000);

    function escapeHtml(text) {
        if (text === null || text === undefined) return '';
        return String(text)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    refreshChatList();
</script>