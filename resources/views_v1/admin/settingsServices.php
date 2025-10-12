<div class='settingContentSector' style='flex:1 1 auto;'>
    <div class='settingCaption'>Сервисы</div>
    <div class='button' onclick='document.location.href = "/admin/setting/telegram"'>Проверить Telegram</div>
    <div class='button' onclick='checkWhatsApp()'>Проверить WhatsApp</div>
</div>

<script>
    function checkWhatsApp()
    {        
        let data = {
            '_token': _token,
        };
        fetch('/admin/setting/checkWhatsApp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success !== 1){
                alert(data.error);
                return;
            }
            alert('Вроде работает =)');
        });
    }
</script>