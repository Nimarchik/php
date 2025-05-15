<?php
session_start();
$isAdmin = $_SESSION['boolean'] ?? 0;
$name = $_SESSION['name'] ?? 'Користувач';
?>

<div class="container">
  <section class="login">
    <div class="login__content">
      <p class="login__content-subt">Успішно</p>
      <h1 class="login__content-title">
        Ви успішно увійшли в систему
      </h1>
      <p class="login__content-sub">Вітаємо!
        Ви успішно увійшли в систему
        <?php if ($isAdmin > 0): ?>
          як Адміністратор.
        <?php endif; ?>
        Тепер ви можете користуватися всіма функціями нашого сайту.
      </p>
      <a class="login__content-link" href="index.php?action=home">На Головну</a>
    </div>

  </section>

</div>s