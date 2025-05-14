<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $action = $_POST['action'] ?? '';
  $name = $_POST['name'] ?? '';
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  $host = 'localhost';
  $user = 'root';
  $pass = '';
  $db = 'sb';

  $conn = new mysqli($host, $user, $pass, $db);
  if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
  }

  if ($action === 'register') {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      echo "<span class='register__content-form-error-email--remove'>Email вже використовується.</span>";
    } else {
      $stmt = $conn->prepare("INSERT INTO users (name, email, pass) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $name, $email, $hashedPassword);

      if ($stmt->execute()) {
        header("Location: index.php?action=registration_successful");
        exit;
      } else {
        echo "Помилка при реєстрації: " . $stmt->error;
      }
    }
    $stmt->close();
  } elseif ($action === 'login') {
    $stmt = $conn->prepare("SELECT id, name, pass FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
      $user = $result->fetch_assoc();
      if (password_verify($password, $user['pass'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        header("Location: index.php?action=login_successful");
        exit;
      } else {
        echo "<span class='error-pass'>Невірний пароль.</span>";
      }
    } else {
      echo "<span class='login-error'>Користувача з таким email не знайдено.</span>";
    }

    $stmt->close();
  }

  $conn->close();
}
?>


<div class="container">
  <section class="register">
    <div class="register__content">
      <p class="register__content-subt">Реєстрація</p>
      <h1 class="register__content-title">
        Приєднуйтесь до нашого клубу
      </h1>
      <div class="register__content-group-form">
        <form action="" method="post" class="register__content-form">
          <input type="hidden" name="action" value="register">
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
        <button class="register__content-form-btn-login">Увійти</button>

      </div>
      <div class="login__content-group-form">
        <form action="" method="post" class="login__content-form">
          <input type="hidden" name="action" value="login">

          <label class="register__content-form-label">
            <input class="register__content-form-label-inp" type="email" placeholder="" name="email" required>
            <span class="register__content-form-label-sub">Ваш email</span>
          </label>
          <label class="register__content-form-label">
            <input class="register__content-form-label-inp" type="password" placeholder="" required name="password">
            <span class="register__content-form-label-sub">Пароль</span>
          </label>

          <button class="login__content-form-btn" type="submit">Увійти</button>
        </form>
        <button class="login__content-group-form-btn-reg">Зареєструватися</button>
      </div>
    </div>
  </section>
</div>



<script>
  const loginBtn = document.querySelector('.register__content-form-btn-login');
  const loginForm = document.querySelector('.login__content-group-form');
  const registerForm = document.querySelector('.register__content-group-form');
  const registerBtn = document.querySelector('.login__content-group-form-btn-reg');


  loginBtn.addEventListener('click', () => {
    registerForm.classList.toggle('register__content-group-form-active');
    loginForm.classList.toggle('login__content-group-form-active');


  })

  registerBtn.addEventListener('click', () => {
    loginForm.classList.toggle('login__content-group-form-active');
    registerForm.classList.toggle('register__content-group-form-active');

  })

  // errorPass && setTimeout(() => {
  //   errorPass.remove();
  // }, 3000);

  const errorEmail = document.querySelector('.register__content-form-error-email--remove');
  const loginError = document.querySelector('.login-error');
  const errorPass = document.querySelector('.error-pass');

  const errors = [errorEmail, loginError, errorPass];

  setInterval(() => {
    errors.forEach(error => {
      if (error) {
        error.remove();
      }
    });

  }, 3000);

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