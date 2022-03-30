<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=$base?>/assets/css/all.min.css"/>
    <link rel="stylesheet" href="<?=$base?>/assets/css/signIn.css"/>
    <title>Loja | Login</title>
</head>
<body>
    
    <header>
        <div class="container">
            <h1>Login</h1>
        </div>
    </header>

    <section class="form-area">
        <div class="container">
            <div class="form-item">
                <div class="header-form-item">
                    <h3>Adminstração do sistema</h2>
                    <h1>Faça seu login</h1>
                    <p>Ainda não tem conta? <a href="">Crie uma agora</a></p>
                </div>
                <form action="<?=$base?>/admin/submitSigninAdmin" method="POST">
                    <div class="form-input-item">
                        <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="Digite seu email..."
                        />
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="form-input-item">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Digite sua senha..."
                        />
                        <i class="fa fa-key"></i>
                    </div>
                    <input class="btn" type="submit" value="Entrar"/>
                </form>
                
                <?php if(!empty($flash)):?>
                    <div class="flash-message">
                        <?=$flash;?>
                    </div>
                <?php endif; ?>
                
            </div>
        </div>
    </section>

</body>
</html>