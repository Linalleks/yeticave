  <main>
    <nav class="nav">
      <ul class="nav__list container">
        <?php foreach ($categories as $cat) :?>
          <li class="nav__item">
            <a href="pages/all-lots.html"><?=$cat['name_category']?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <?php $class_name = isset($errors) ? " form--invalid" : ""; ?>
    <form class="form container<?= $class_name ?>" action="page-signup.php" method="post" autocomplete="off">
      <h2>Регистрация нового аккаунта</h2>
      <?php $class_name = isset($errors["email"]) ? " form__item--invalid" : ""; ?>
      <div class="form__item<?= $class_name ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" value="<?=$user['email']?>" placeholder="Введите e-mail">
        <span class="form__error"><?= $errors["email"] ?></span>
      </div>
      <?php $class_name = isset($errors["password"]) ? " form__item--invalid" : ""; ?>
      <div class="form__item<?= $class_name ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" value="<?=$user['password']?>" placeholder="Введите пароль">
        <span class="form__error"><?= $errors["password"] ?></span>
      </div>
      <?php $class_name = isset($errors["name"]) ? " form__item--invalid" : ""; ?>
      <div class="form__item<?= $class_name ?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" value="<?=$user['name']?>" placeholder="Введите имя">
        <span class="form__error"><?= $errors["name"] ?></span>
      </div>
      <?php $class_name = isset($errors["contacts"]) ? " form__item--invalid" : ""; ?>
      <div class="form__item<?= $class_name ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="contacts" placeholder="Напишите как с вами связаться"><?=$user['contacts']?></textarea>
        <span class="form__error"><?= $errors["contacts"] ?></span>
      </div>
      <?php $class_name = isset($errors) ? " form__error--bottom" : ""; ?>
      <span class="form__error<?= $class_name ?>">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Зарегистрироваться</button>
      <a class="text-link" href="login.php">Уже есть аккаунт</a>
    </form>
  </main>
