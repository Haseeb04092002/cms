<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Online Class Room</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://meet.jit.si/external_api.js"></script>

    <style>
        body{margin:0;font-family:Arial, sans-serif;background:#f4f4f4;}
        .topbar{
            background:#111;
            color:#fff;
            padding:10px 15px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
            gap:10px;
        }
        #meet{
            width:100%;
            height:calc(100vh - 58px);
        }
        .btn{
            background:#fff;
            color:#111;
            padding:8px 14px;
            border-radius:4px;
            text-decoration:none;
            font-size:14px;
        }
    </style>
</head>
<body>

<div class="topbar">
    <div>
        <strong><?= htmlspecialchars($classRow->title) ?></strong>
        | <?= htmlspecialchars($displayName) ?>
        | <?= htmlspecialchars($mode) ?>
    </div>
    <div>
        <?php if(($this->session->userdata('user_role') ?? '') == 'Teacher' || in_array(($this->session->userdata('user_role') ?? ''), array('Admin','CEO','Principal'))): ?>
            <a href="<?= site_url('online-class/end/'.$classRow->onlineClassId) ?>" class="btn">End Class</a>
        <?php else: ?>
            <a href="<?= site_url('online-class/student') ?>" class="btn">Back</a>
        <?php endif; ?>
    </div>
</div>

<div id="meet"></div>

<script>
    const domain = "meet.jit.si";

    const options = {
        roomName: "<?= $roomName ?>",
        width: "100%",
        height: "100%",
        parentNode: document.querySelector('#meet'),
        userInfo: {
            displayName: "<?= htmlspecialchars($displayName, ENT_QUOTES) ?>"
        },
        configOverwrite: {
            prejoinPageEnabled: false
        },
        interfaceConfigOverwrite: {
            SHOW_JITSI_WATERMARK: false
        }
    };

    const api = new JitsiMeetExternalAPI(domain, options);
</script>

</body>
</html>