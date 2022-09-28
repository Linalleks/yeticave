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
    <form class="form container<?= $class_name ?>" action="page-login.php" method="post"> 
      <h2>Вход</h2>
      <?php $class_name = isset($errors["email"]) ? " form__item--invalid" : ""; ?>
      <div class="form__item<?= $class_name ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail">
        <span class="form__error"><?= $errors["email"]; ?></span>
      </div>
      <?php $class_name = isset($errors["password"]) ? " form__item--invalid" : ""; ?>
      <div class="form__item form__item--last<?= $class_name ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error"><?= $errors["password"]; ?></span>
      </div>
      <button type="submit" class="button">Войти</button>
    </form>
  </main>