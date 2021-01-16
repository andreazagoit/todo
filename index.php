<?php

include 'actions.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>To Do List</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/gsap.min.js"></script>
</head>

<script>
    const login = () => {
        gsap.set(".login", {
            display: 'flex'
        });
        gsap.set(".register", {
            display: 'none'
        });
    }
    const register = () => {
        gsap.set(".register", {
            display: 'flex'
        });
        gsap.set(".login", {
            display: 'none'
        });
    }
</script>

<body>
    <?php if (!isset($_COOKIE['username'])) { ?>
        <div class="body__content">
            <div class="login__card">
                <h2 class="login">ACCEDI</h2>
                <h2 class="register">REGISTRATI</h2>
                <p class="error"><?php echo $errorMsg; ?></p>
                <form action="/index.php" method="post" class="login">
                    <label>Username</label>
                    <input type="text" placeholder="Username" name="username" />
                    <label>Password</label>
                    <input type="password" placeholder="Password" name="password" />
                    <input type="submit" value="LOGIN" />
                </form>
                <form action="/index.php" method="post" class="register">
                    <label>Username</label>
                    <input type="text" placeholder="Username" name="rusername" />
                    <label>Password</label>
                    <input type="password" placeholder="Password" name="rpassword" />
                    <input type="submit" value="REGISTRATI" />
                </form>
                <div class="login__cardButton">
                    <p class="login" onclick="register()">Vuoi registrarti?</p>
                    <p class="register" onclick="login()">Hai giá le tue credenziali?</p>
                </div>
            </div>
        </div>
    <?php } else { ?>

        <body>
            <div class="navbar">
                <div class="container">
                    <div class="navbar__title">
                        <h2>To Do List</h2>
                    </div>
                    <div class="navbar__logout">
                        <p><?php echo $username; ?></p>
                        <a href="?action=logout"><button class="icon-container"><i class="fas fa-sign-out-alt"></i></button></a>
                    </div>
                </div>
            </div>
            <div class="todo__add">
                <div class="container">
                    <div class="todo__addContainer">
                        <h2>Aggiungi nuovo elemento</h2>
                        <p>Ritrova calma e chiarezza togliendo le attività dalla tua testa e mettendole dentro la tua lista.</p>
                        <form action="/index.php" method="post">
                            <input type="text" placeholder="Type a todo..." name="todo" />
                            <button type="submit">Submit</button>
                        </form>
                    </div>
                    <lottie-player src="https://assets1.lottiefiles.com/private_files/lf30_yziydbap.json" background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay></lottie-player>
                </div>
            </div>
            <div class="container">
                <?php foreach ($todos as $todo) { ?>
                    <div class="todo__item">
                        <?php if ($todo['completed'] == 1) { ?>
                            <a href="?action=incomplete&id=<?php echo $todo['id']; ?>"><button class="icon-container"><i class="fas fa-times"></i></button></a>
                        <?php } else { ?>
                            <a href="?action=complete&id=<?php echo $todo['id']; ?>"><button class="icon-container"></button></a>
                        <?php } ?>
                        <div class="todo__itemTask"><?php echo $todo['task'] ?></div>
                        <a class="todo__itemDelete" href="?action=delete&id=<?php echo $todo['id']; ?>"><button class="icon-container alert"><i class="far fa-trash-alt"></i></button></a>
                    </div>
                <?php } ?>
            </div>
        </body>

    <?php } ?>

</html>