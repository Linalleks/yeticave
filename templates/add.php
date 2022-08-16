  <main>
    <?php
    // var_dump($lot['category']);
    ?>
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
    <form class="form form--add-lot container<?= $class_name ?>" action="page-add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
      <h2>Добавление лота</h2>
      <div class="form__container-two">
        <?php $class_name = isset($errors["title"]) ? " form__item--invalid" : ""; ?>
        <div class="form__item<?= $class_name ?>"> <!-- form__item--invalid -->
          <label for="lot-name">Наименование <sup>*</sup></label>
          <input name="title" id="lot-name" type="text" name="lot-name" value="<?=$lot['title']?>" placeholder="Введите наименование лота">
          <span class="form__error"><?= $errors["title"] ?></span>
        </div>
        <?php $class_name = isset($errors["category"]) ? " form__item--invalid" : ""; ?>
        <div class="form__item<?= $class_name ?>">
          <label for="category">Категория <sup>*</sup></label>
          <select name="category" id="category" name="category">
            <option>Выберите категорию</option>
            <?php foreach ($categories as $cat) :?>
              <option value="<?=$cat['id']?>"<?=(!is_null($lot['category']) && ($lot['category'] === $cat['id'])) ? ' selected' : ''?>><?=$cat['name_category']?></option>
            <?php endforeach; ?>
          </select>
          <span class="form__error"><?= $errors["category"] ?></span>
        </div>
      </div>
      <?php $class_name = isset($errors["description"]) ? " form__item--invalid" : ""; ?>
      <div class="form__item form__item--wide<?= $class_name ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea name="description" id="message" name="message" placeholder="Напишите описание лота"><?=$lot['description']?></textarea>
        <span class="form__error"><?= $errors["description"] ?></span>
      </div>

      <?php $class_name = isset($errors["img"]) ? " form__item--invalid" : ""; ?>
      <div class="form__item form__item--file<?= $class_name ?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
        <input class="visually-hidden" type="file" id="lot-img" value="<?=$lot['img']?>" name="img">
          <!-- <input id="lot-img" name="img" class="visually-hidden" type="file" value="<?=$lot['img']?>"> -->
          <label for="lot-img">
            Добавить
          </label>
        </div>
        <span class="form__error"><?= $errors["img"] ?></span>
      </div>

      <div class="form__container-three">
      <?php $class_name = isset($errors["start_price"]) ? " form__item--invalid" : ""; ?>
        <div class="form__item form__item--small<?= $class_name ?>">
          <label for="lot-rate">Начальная цена <sup>*</sup></label>
          <input name="start_price" id="lot-rate" type="text" value="<?=$lot['start_price']?>" placeholder="0">
          <span class="form__error"><?= $errors["start_price"] ?></span>
        </div>
        <?php $class_name = isset($errors["step"]) ? " form__item--invalid" : ""; ?>
        <div class="form__item form__item--small<?= $class_name ?>">
          <label for="lot-step">Шаг ставки <sup>*</sup></label>
          <input name="step" id="lot-step" type="text" value="<?=$lot['step']?>" placeholder="0">
          <span class="form__error"><?= $errors["step"] ?></span>
        </div>
        <?php $class_name = isset($errors["date_finish"]) ? " form__item--invalid" : ""; ?>
        <div class="form__item<?= $class_name ?>">
          <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
          <input name="date_finish" class="form__input-date" id="lot-date" type="text" value="<?=$lot['date_finish']?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
          <span class="form__error"><?= $errors["date_finish"] ?></span>
        </div>
      </div>
      <?php $class_name = isset($errors) ? " form__error--bottom" : ""; ?>
      <span class="form__error<?= $class_name ?>">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Добавить лот</button>
    </form>
  </main>
