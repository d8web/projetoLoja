<header class="top-nav">
    <nav>
        <ul>
            <li>
                <a href="">
                    <span class="material-icons-sharp">
                        account_circle
                    </span>
                    <?= $loggedAdmin->name ?>
                </a>
            </li>
            <li>
                <a href="<?=$base?>/admin/logout">
                    Sair
                    <span class="material-icons-sharp">
                        logout
                    </span>
                </a>
            </li>
        </ul>
    </nav>
</header>