<nav>
    <?php if(!isset($_SESSION['user'])):?>
        <a href="/user/log-in/">Log In</a>
        <a href="/user/sign-up/">Sign Up</a>
    <?php else:?>        
        <a href="/user/options/"><?= ucfirst(strtolower($_SESSION['user']->nick))?></a>
        <a href="/user/log-out/">X </a>
    <?php endif;?>
</nav>