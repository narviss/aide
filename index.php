<? if(isset($_GET['edit'])): ?>
    <?
        ini_set('display_errors', '1');
    	$homepage = file_get_contents("tmpindexphp.html");

    	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $bd = new mysqli( 'localhost', 'check_pg', 'check_pg_password' , 'codic') or die("Error");
	    $result = $bd->query("select (NOW() - time_edit) as time_end from codic.log_ip where ip = '".$ip."' and NOW() - time_edit < 600");
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $error = "Вы можете изменить страницу только через ".intdiv(600 - $row['time_end'],60).' минут '.((600 -$row['time_end'])%60).' секунд!';
        } else {
			if (isset($_POST['editOurCode'])) {
				if (abs(strlen($homepage) - strlen($_POST['editOurCode'])) < 101) {
					$fp = fopen('tmpindexphp.html', 'w');
					fwrite($fp, $_POST['editOurCode']);
					fclose($fp);
					$bd->query("INSERT INTO codic.log_ip (ip) VALUES('" . $ip . "')");
					header("Location: /index.php");
				} else {
					$error = "Измененных символов больше 100!";
				}
			}
		}
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <link rel="shortcut icon" href="/favicon.ico" />
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
            .center {
                display: block;
                margin-left: auto;
                margin-right: auto;
            }
            .code-edit {
                width: 90%;
            }
            .edit-len-color {
                color: green;
            }
        </style>
        <title>Hello, world!</title>
    </head>
    <body>
    <center>
        <form action="index.php?edit=true" method="post">
            <div class="form-group" style="padding: 50px">
                <b for="editOurCode">
                    <? if(isset($error)): ?>
                    <b></b><p style="color: red">
                        <?=$error?>
                    </p></b>
                    <? endif; ?>
                    <b>Измените что-нибудь на главной странице (Доступно одно изменение с одного IP Адреса раз в 10 минут!)
                        Максимум за один раз можно изменить 100 символов!:
                    <br>
                        Допускается только HTML/JS</b>
                </label>
                <textarea rows="10" class="form-control code-edit center" name="editOurCode" id="editOurCode"><? echo $homepage; ?></textarea>
                <b><p class="edit-len-color">Количество измененных символов: <span class="edit-len">0</span></p></b>
                <br>
                <button type="submit" class="btn btn-primary mb-2">Сохранить!</button>
            </div>
        </form>
    </center>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        $("#editOurCode").on("change keyup paste", function() {
            $lens = Math.abs($("#editOurCode").val().length - <?=strlen($homepage)?>);
            if($lens > 100)
                $('.edit-len-color').attr('style', 'color: red');
            else
                $('.edit-len-color').attr('style', 'color: green');
            $('.edit-len').text($lens);
        })
    </script>
    </body>
    </html>
<? else: ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <a href="index.php?edit=true"><span class="fas fa-terminal" style="padding: 10px; font-size: xx-large"></span></a>
    <?
        include_once "tmpindexphp.html";
    ?>
<? endif; ?>
lol
