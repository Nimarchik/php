<?php
session_start();
session_unset(); // Очищує всі змінні сесії
session_destroy(); // Завершує сесію

header("Location: index.php?action=home");
exit;
