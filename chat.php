<style>
	#messages
	{
		width:300px;
		height:150px;
		overflow:auto;
		border:1px solid silver;
	}
</style>
<script type="text/javascript">
    function send()
    {
        var mess=$("#mess_to_send").val();
        var login=$("#login").val();
        $.ajax({
            type: "POST",
            url: "add_mess.php",
            data:"login="+login+"&mess="+mess,
            success: function(html)
            {
                load_messes();
                $("#mess_to_send").val('');
            }
        });
    }
    function load_messes()
    {
        $.ajax({
            type: "POST",
            url:  "load_messes.php",
            data: "req=ok",
            success: function(html)
            {
                $("#messages").empty();
                $("#messages").append(html);
                $("#messages").scrollTop(90000);
            }
        });
    }
</script>

<table style="float: right;margin: 20px">
	<tr>
		<td>
			<div class="form-group" id="messages">
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="form-group">
				<input placeholder="Ваш логин" class="form-control" type="text" id="login">
			</div>
			<div class="form-group">
				<input type="text" id="mess_to_send" class="form-control" placeholder="Введите сообщение">
			</div>
			<div class="form-group">
				<input class="btn btn-primary mb-2" type="button" value="Отправить" onclick="send();">
			</div>
		</td>
	</tr>
</table>
<script>
    load_messes();
    setInterval(load_messes,3000);
</script>