<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST['name'] ?? '';
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';


  header("Location: index.php?action=registration_successful");
  exit;
}
?>

<div class="container">
  <section class="register">
    <div class="register__content">
      <p class="register__content-subt">Реєстрація</p>
      <h1 class="register__content-title">
        Приєднуйтесь до нашого клубу
      </h1>
      <form action="" method="post" class="register__content-form">
        <label class="register__content-form-label">
          <input class="register__content-form-label-inp" type="text" placeholder="" name="name" required>
          <span class="register__content-form-label-sub">Ваше ім'я</span>
          <span class="register__content-form-error"></span>
        </label>
        <label class="register__content-form-label">
          <input class="register__content-form-label-inp" type="email" placeholder="" name="email" required>
          <span class="register__content-form-label-sub">Ваш email</span>
        </label>
        <label class="register__content-form-label">
          <input class="register__content-form-label-inp" type="password" placeholder="" required name="password">
          <span class="register__content-form-label-sub">Пароль</span>
          <span class="register__content-form-error"></span>

        </label>
        <label class="register__content-form-label">
          <input class="register__content-form-label-inp" type="password" placeholder="" required name="password-retry">
          <span class="register__content-form-label-sub">Повторіть пароль</span>
          <span class="register__content-form-error"></span>

        </label>
        <button class="register__content-form-btn" type="submit">Зареєструватися</button>
      </form>
    </div>
  </section>
</div>



<script>
  function isValidLogin(login) {
    const regex = /^[a-zA-Zа-яА-ЯёЁіІїЇєЄґҐ_-]{4,}$/u;
    return regex.test(login);
  }

  function isValidPassword(password) {
    const lengthCheck = password.length >= 7;
    const upperCheck = /[A-ZА-ЯІЇЄҐ]/.test(password);
    const lowerCheck = /[a-zа-яіїєґ]/.test(password);
    const digitCheck = /\d/.test(password);
    return lengthCheck && upperCheck && lowerCheck && digitCheck;
  }

  document.querySelector('.register__content-form').addEventListener('submit', function(e) {
    let isValid = true;

    //  Логін 
    const nameInput = this.querySelector('input[name="name"]');
    const nameError = nameInput.closest('label').querySelector('.register__content-form-error');
    const login = nameInput.value.trim();

    if (!isValidLogin(login)) {
      nameInput.classList.add('invalid');
      nameError.textContent = "Мінімум 4 літери. Тільки латиниця/кирилиця, _ або -";
      isValid = false;
    } else {
      nameInput.classList.remove('invalid');
      nameError.textContent = "";
    }

    //  Пароль 
    const passwordInput = this.querySelector('input[name="password"]');
    const passwordError = passwordInput.closest('label').querySelector('.register__content-form-error');
    const password = passwordInput.value;

    if (!isValidPassword(password)) {
      passwordInput.classList.add('invalid');
      passwordError.textContent = "Пароль має бути ≥ 7 символів і містити великі, малі літери та цифри";
      isValid = false;
    } else {
      passwordInput.classList.remove('invalid');
      passwordError.textContent = "";
    }

    // Повтор паролю 
    const retryInput = this.querySelector('input[name="password-retry"]');
    const retryError = retryInput.closest('label').querySelector('.register__content-form-error');
    const retry = retryInput.value;

    if (password !== retry) {
      retryInput.classList.add('invalid');
      retryError.textContent = "Паролі не співпадають";
      isValid = false;
    } else {
      retryInput.classList.remove('invalid');
      retryError.textContent = "";
    }

    if (!isValid) e.preventDefault();
  });
</script>