<div class="p-4">

    <!-- ================= MAIN CHAT PANEL ================= -->
    <div class="row g-3">

        <!-- ===== LEFT: CONTACT LIST ===== -->
        <div class="col-12 col-lg-4 col-xl-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <div class="fw-bold">Chats</div>
                    <input class="form-control form-control-sm mt-2" id="chatSearch" placeholder="Search user">
                </div>

                <div class="list-group list-group-flush"
                    style="height:calc(100vh - 220px); overflow-y:auto;"
                    id="chatList">
                </div>

            </div>
        </div>

        <!-- ===== RIGHT: CHAT VIEW ===== -->
        <div class="col-12 col-lg-8 col-xl-8">
            <form id="chatForm">
                <div class="card shadow-sm h-100 d-flex flex-column">

                    <input type="hidden" id="currentReceiverId" name="receiverId">
                    <input type="hidden" id="currentReceiverRoleId" name="receiverRoleId">

                    <!-- Header -->
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-circle fs-3 me-2"></i>
                                <div class="d-flex flex-row justify-content-start gap-2 align-items-center">
                                    <!-- <span class="badge bg-secondary text-light" id="chatUserId">.</span> -->
                                    <div class="fw-bold" id="chatUserName">Select a chat</div>
                                    (<div class="fw-bold" id="chatUserType">.</div>)
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div class="card-body overflow-auto"
                        style="height:calc(100vh - 220px);"
                        id="chatBox">
                        <!-- messages load here -->
                    </div>

                    <!-- Input -->
                    <div class="card-footer bg-white">
                        <div class="input-group">
                            <!-- <input type="file" id="attach" hidden>
                            <button class="btn btn-outline-secondary" onclick="document.getElementById('attach').click()">
                                <i class="bi bi-paperclip"></i>
                            </button> -->

                            <input type="text" id="msgInput" class="form-control" name="message" placeholder="Type a message..." required>

                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>


    </div>
</div>

<script>
    // document.addEventListener("DOMContentLoaded", function(event) {
        console.log("DOM fully loaded and parsed");
        const USER_ID = <?= (int)$this->session->userdata('user_id') ?>;
        const base_url = "<?= base_url() ?>";
        let chatInterval = null;

        startChatInterval();

        function startChatInterval() {
            if (chatInterval !== null) return; // already running

            chatInterval = setInterval(() => {

                const receiverId = document.getElementById('currentReceiverId').value;

                if (receiverId) {
                    const receiverRoleId = document.getElementById('currentReceiverRoleId').value;

                    $.get(base_url + 'Chatting/open_chat/' + receiverId + '/' + receiverRoleId, function(res) {

                        let data = JSON.parse(res);
                        let box = document.getElementById('chatBox');
                        let old = box.innerHTML;
                        let html = '';

                        data.forEach(m => {

                            if (parseInt(m.senderId) === parseInt(USER_ID)) {
                                html += `
                        <div class="d-flex justify-content-end mb-3">
                            <div class="bg-primary text-white rounded-3 p-3 shadow-sm"
                                style="max-width:75%; border-top-right-radius:0;">
                                <div class="mb-1">
                                    ${escapeHtml(m.messageText)}
                                </div>
                                <div class="d-flex justify-content-end">
                                    <small class="text-white-50">
                                        ${formatDateTime(m.addedOn)}
                                    </small>
                                </div>
                            </div>
                        </div>`;
                            } else {
                                html += `
                        <div class="d-flex mb-3">
                            <div class="me-2">
                                <i class="bi bi-person-circle fs-3 text-secondary"></i>
                            </div>
                            <div class="bg-white border rounded-3 p-3 shadow-sm"
                                style="max-width:75%; border-top-left-radius:0;">
                                <div class="mb-1">
                                    ${escapeHtml(m.messageText)}
                                </div>
                                <div class="d-flex justify-content-end">
                                    <small class="text-muted">
                                        ${formatDateTime(m.addedOn)}
                                    </small>
                                </div>
                            </div>
                        </div>`;
                            }

                        });

                        if (old !== html) {
                            box.innerHTML = html;
                            box.scrollTop = box.scrollHeight;
                        }
                    });
                }

                $.get(base_url + 'Chatting/poll_updates_with_head_teacher', function(res) {

                    let data = JSON.parse(res);

                    data.forEach(u => {

                        let senderId = u.senderId;
                        let total = parseInt(u.total);

                        let badge = document.getElementById('badge_' + senderId);
                        let card = document.getElementById('chat_user_' + senderId);

                        if (badge) {
                            badge.innerText = total;
                            badge.style.display = total > 0 ? 'inline-block' : 'none';
                        }

                        if (card && total > 0) {
                            NotificationSound();
                            document.getElementById('chatList').prepend(card);
                        }
                    });
                });

                refreshChatList();

            }, 2000);
        }

        function stopChatInterval() {
            if (chatInterval !== null) {
                clearInterval(chatInterval);
                chatInterval = null;
            }
        }



        document.getElementById('chatSearch').addEventListener('input', function() {

            let keyword = this.value.toLowerCase().trim();

            if (keyword.length > 0) {
                stopChatInterval(); // ⏸ pause polling
            } else {
                startChatInterval(); // ▶ resume polling
            }

            document.querySelectorAll('#chatList a.list-group-item').forEach(item => {

                let name = item.querySelector('.fw-semibold')
                    .childNodes[0].nodeValue
                    .toLowerCase();

                item.style.display = name.includes(keyword) ? '' : 'none';
            });
        });


        // let currentChatUserId = null;

        function formatDateTime(dt) {
            if (!dt) return '';

            const d = new Date(dt.replace(' ', 'T')); // handles "YYYY-MM-DD HH:MM:SS"

            const optionsDate = {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            };
            const optionsTime = {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            };

            const datePart = d.toLocaleDateString('en-GB', optionsDate); // 15 Sep 2020
            const timePart = d.toLocaleTimeString('en-US', optionsTime).toLowerCase(); // 2:15 pm

            return `${datePart} · ${timePart}`;
        }


        function openChat(uid, roleId, name, roleName) {

            document.getElementById('msgInput').value = "";

            document.getElementById('currentReceiverId').value = uid;
            document.getElementById('currentReceiverRoleId').value = roleId;

            console.log('currentReceiverId = ' + uid);
            console.log('currentReceiverRoleId = ' + roleId);
            console.log('senderid = ' + USER_ID);

            document.getElementById('chatUserName').innerText = name;
            // document.getElementById('chatUserId').innerText = uid;
            document.getElementById('chatUserType').innerText = roleName;

            $.get(base_url + 'Chatting/open_chat/' + uid + '/' + roleId, function(res) {

                let data = JSON.parse(res);
                let box = document.getElementById('chatBox');
                box.innerHTML = '';

                data.forEach(m => {

                    // outgoing
                    if (parseInt(m.senderId) === parseInt(USER_ID)) {
                        box.innerHTML += `
                    <div class="d-flex justify-content-end mb-3">
                        <div class="bg-primary text-white rounded-3 p-3 shadow-sm"
                            style="max-width:75%; border-top-right-radius:0;">
                            
                            <div class="mb-1">
                                ${escapeHtml(m.messageText)}
                            </div>

                            <div class="d-flex justify-content-end align-items-center gap-2">
                                <small class="text-white-50">
                                    ${formatDateTime(m.addedOn)}
                                </small>
                            </div>
                        </div>
                    </div>`;
                    }

                    // incoming
                    else {
                        box.innerHTML += `
                    <div class="d-flex mb-3">
                        <div class="me-2">
                            <i class="bi bi-person-circle fs-3 text-secondary"></i>
                        </div>

                        <div class="bg-white border rounded-3 p-3 shadow-sm"
                            style="max-width:75%; border-top-left-radius:0;">

                            <div class="mb-1">
                                ${escapeHtml(m.messageText)}
                            </div>

                            <div class="d-flex justify-content-end">
                                <small class="text-muted">
                                    ${formatDateTime(m.addedOn)}
                                </small>
                            </div>
                        </div>
                    </div>`;
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
            $.ajax({
                url: "<?= site_url('Chatting/chats_with_head_teacher') ?>",
                type: "GET",
                dataType: "json",
                success: function(data) {

                    console.log(data);

                    let list = data.chat_users; // 👈 FIX

                    if (!Array.isArray(list)) {
                        console.error('Chat list is not array:', data);
                        return;
                    }

                    let html = '';

                    list.forEach(u => {

                        let activeClass = u.unread_count > 0 ? 'active' : '';
                        let badgeStyle = u.unread_count > 0 ? 'display:block' : 'display:none';
                        let lastMsg = u.last_message ? escapeHtml(u.last_message) : 'Start a new chat';

                        html += `
                    
                <a href="javascript:void(0)"
                    onclick="openChat(${u.profile_id}, ${u.roleId}, '${escapeHtml(u.name)}', '${escapeHtml(u.profile_type)}')"
                    class="list-group-item list-group-item-action ${activeClass}"
                    id="chat_user_${u.chat_key}">

                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-circle fs-3 me-2"></i>

                        <div class="flex-grow-1">
                            <div class="fw-semibold">
                                ${escapeHtml(u.name)}
                                <small class="text-muted">(${u.profile_type})</small>
                            </div>

                            <div class="small text-muted" id="last_msg_${u.chat_key}">
                                ${lastMsg}
                            </div>
                        </div>

                        <span class="badge bg-danger rounded-pill"
                            id="badge_${u.chat_key}"
                            style="${badgeStyle}">
                            ${u.unread_count}
                        </span>
                    </div>
                </a>`;
                    });

                    document.getElementById('chatList').innerHTML = html;
                },
                error: function(xhr) {
                    console.error('Chat list JSON error:', xhr.responseText);
                }
            });
        }


        $(document).off('submit', '#chatForm').on('submit', '#chatForm', function(e) {
            e.preventDefault();

            let form = $(this);

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
                        NotificationSound();
                        openChat(parseInt(receiverId), document.getElementById('currentReceiverRoleId').value, document.getElementById('chatUserName').innerText);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }

                }
            });

            refreshChatList();
        });

        setInterval(() => {

            const receiverId = document.getElementById('currentReceiverId').value;

            if (receiverId) {
                const receiverRoleId = document.getElementById('currentReceiverRoleId').value;
                $.get(base_url + 'Chatting/open_chat/' + receiverId + '/' + receiverRoleId, function(res) {

                    let data = JSON.parse(res);
                    let box = document.getElementById('chatBox');
                    let old = box.innerHTML;
                    let html = '';

                    data.forEach(m => {
                        if (parseInt(m.senderId) === parseInt(USER_ID)) {
                            html += `
                        <div class="d-flex justify-content-end mb-3">
                        <div class="bg-primary text-white rounded-3 p-3 shadow-sm"
                            style="max-width:75%; border-top-right-radius:0;">
                            
                            <div class="mb-1">
                                ${escapeHtml(m.messageText)}
                            </div>

                            <div class="d-flex justify-content-end align-items-center gap-2">
                                <small class="text-white-50">
                                    ${formatDateTime(m.addedOn)}
                                </small>
                            </div>
                        </div>
                    </div>
                    `;
                        } else {
                            html += `
                        <div class="d-flex mb-3">
                        <div class="me-2">
                            <i class="bi bi-person-circle fs-3 text-secondary"></i>
                        </div>

                        <div class="bg-white border rounded-3 p-3 shadow-sm"
                            style="max-width:75%; border-top-left-radius:0;">

                            <div class="mb-1">
                                ${escapeHtml(m.messageText)}
                            </div>

                            <div class="d-flex justify-content-end">
                                <small class="text-muted">
                                    ${formatDateTime(m.addedOn)}
                                </small>
                            </div>
                        </div>
                    </div>
                    `;
                        }


                    });

                    if (old !== html) {
                        box.innerHTML = html;
                        box.scrollTop = box.scrollHeight;
                    }
                });
            }

            $.get(base_url + 'Chatting/poll_updates_with_head_teacher', function(res) {
                let data = JSON.parse(res);

                data.forEach(u => {

                    let senderId = u.senderId;
                    let total = parseInt(u.total);

                    let badge = document.getElementById('badge_' + senderId);
                    let card = document.getElementById('chat_user_' + senderId);

                    if (badge) {
                        badge.innerText = total;
                        badge.style.display = total > 0 ? 'inline-block' : 'none';
                    }

                    // move unread chats to top
                    if (card && total > 0) {
                        NotificationSound();
                        document.getElementById('chatList').prepend(card);
                    }
                });
            });

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

        // refreshChatList();

    // });
</script>