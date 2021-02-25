<!doctype html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta content='width=device-width, initial-scale=1.0' name='viewport'>
    <meta content='ie=edge' http-equiv='X-UA-Compatible'>
    <meta name='description' content='lalys | Reset Password Page'>
    <link rel='apple-touch-icon' href='./lalys-logo.png'>
    <link rel='apple-touch-icon' sizes='90x90' href='./lalys-logo.png'>
    <link rel='icon' href='./lalys-logo.png' type='image/png' sizes='90x90'>
    <title>lalys | Reset Password</title>
    <style>
        body {
            background : #4680ff;
            margin     : 0;
        }

        * {
            font-family : 'Courgette', cursive;
        }

        header {
            height : 94px;
        }

        main {
            height : calc(100vh - 94px);
        }

        .form-box {
            background    : rgba(255, 255, 255, 0.5);
            border-radius : 4px;
            padding       : 100px 20px;

            /*padding       : 40px 20px;*/
            text-align    : center;
        }

        @media screen and (min-width : 576px) {
            .form-box {
                padding : 100px 40px;

            }
        }

        h1 {
            color         : #c34f58;
            font-size     : 32px;
            margin-bottom : 20px;
            margin-top    : 0;
        }

        p {
            font-size     : 18px;
            margin-bottom : 30px;
            margin-top    : 0;
        }

        input {
            background    : transparent;
            border        : 2px solid #fff;
            border-radius : 4px;
            display       : block;
            font-size     : 18px;
            max-width     : 300px;
            outline       : none;
            padding       : 10px;
            transition    : border-color 0.4s ease-in-out;
            width         : 100%;
            margin        : auto;
        }

        input:first-of-type {
            margin-bottom : 20px;
        }

        input:focus {
            border-color : #284468;
        }

        button {
            background    : transparent;
            border        : 2px solid #284468;
            border-radius : 4px;
            color         : #284468;
            cursor        : pointer;
            display       : block;
            font-size     : 22px;
            margin-top    : 30px;
            width         : 100%;
            padding       : 10px 0;
            transition    : all 0.4s ease-in-out;
        }

        button:hover {
            background : #c34f58;
            color      : #fff;
        }
    </style>
</head>
<body>
<div class='container'>
    <header>
        <img alt='Website Logo' class='logo' height='90' src='{{asset('/img/logo.png')}}' width='90'>
    </header>
    <main>
        <div class='row' style='height: 100%;'>
            <div class='col-auto m-auto'>
                <section class='form-box'>
                    <h1> Thank you ...</h1>
                    <p>Your password has been changed successfully.</p>
                </section>
            </div>
        </div>
    </main>
</div>
<script defer>
    const head = document.querySelector('head');
    const font = `<link href='https://fonts.googleapis.com/css2?family=Courgette&display=swap' rel='stylesheet'>`;
    const bootstrap = `<link crossorigin='anonymous' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap-grid.min.css' rel='stylesheet'>`;
    head.insertAdjacentHTML('afterbegin', font);
    head.insertAdjacentHTML('afterbegin', bootstrap);
</script>
</body>
</html>
