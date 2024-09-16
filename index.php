<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERA - Добро пожаловать</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/dark.css">
</head>
<body>
    <div id="data"></div>
</body>
</html>
<script>
    $(document).on('click','.regbut',function()
    {
        $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
        event.preventDefault()
        $.ajax(
		{
			type:'get',
			url:'register_ajax.php',
			dataType:'html',
			success:function(response)
			{
				$('#data').html(response)
			}
		})
    })
    $(document).on('click', '.reqbut', function()
    {
        event.preventDefault()
        let username = document.getElementById('username').value
        let email = document.getElementById('email').value
        let realdr = document.getElementById('realdr').value
        let realpol = document.getElementById('realpol').value
        let realname = document.getElementById('realname').value
        let realsurname = document.getElementById('realsurname').value
        let password = document.getElementById('password').value
        let repassword = document.getElementById('repassword').value
        $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
        $.ajax(
        {
            type:'post',
            url:'register_ajax.php',
            data:{username:username,realname:realname,realsurname:realsurname,realdr:realdr,realpol:realpol,email:email,password:password,repassword:repassword},
            success:function(response)
            {
                $('#data').html(response)
            }
        })
    })
    $(document).on('click','.logbut',function()
    {
        $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
        event.preventDefault()
        $.ajax(
        {
            type:'get',
            url:'login_ajax.php',
            dataType:'html',
            success:function(response)
            {
                $('#data').html(response)
            }
        })
    })
    $(document).on('click','.logfuncbut',function()
        {
            event.preventDefault()
            let username = document.getElementById('username').value
            let password = document.getElementById('password').value
            $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
            $.ajax(
                {
                    type:'post',
                    url:'login_ajax.php',
                    data:{username:username,password:password},
                    success:function(response)
                    {
                        $('#data').html(response)
                    }
                }
            )
        }
    )
    $(document).ready(function()
    {
        $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
        $.ajax(
            {
                type: 'get',
                url: 'login_ajax.php',
                dataType:'html',
                success:function(response)
                {
                    $('#data').html(response)
                }
            }
        )
    })
</script>