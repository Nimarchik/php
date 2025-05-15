<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
} ?>

<nav class="right__menu">
    <ul class="right__menu-list">
        <li class="right__menu-list-item">
            <a class="right__menu-list-item-link" href="index.php?action=home">Головна</a>
        </li>
        <li class="right__menu-list-item">
            <a class="right__menu-list-item-link" href="index.php?action=about">Про нас</a>
        </li>
        <li class="right__menu-list-item">
            <a class="right__menu-list-item-link" href="index.php?action=services">Послуги</a>
        </li>
        <li class="right__menu-list-item">
            <a class="right__menu-list-item-link" href="index.php?action=contact">Контакти</a>
        </li>
        <li class="right__menu-list-item">
            <a class="right__menu-list-item-link" href="index.php?action=registration">Реєстрація</a>
        </li>
        <li class="right__menu-list-item">
            <?php if (isset($_SESSION['id'])): ?>
                <a href="index.php?action=logout" class="menu__link">Вийти</a>
            <?php else: ?>
                <a href="index.php?action=registration" class="menu__link">Увійти</a>
            <?php endif; ?>

    </ul>
</nav>