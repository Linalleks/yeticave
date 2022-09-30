  <main>
    <?php
    // var_dump($history);
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
    <section class="lot-item container">
      <h2><?=$lot['title']?></h2>
      <div class="lot-item__content">
        <div class="lot-item__left">
          <div class="lot-item__image">
            <img src="<?=$lot['img']?>" width="730" height="548" alt="">
          </div>
          <p class="lot-item__category">Категория: <span><?=$lot['name_category']?></span></p>
          <p class="lot-item__description"><?=$lot['description']?></p>
        </div>
        <div class="lot-item__right">
          <div class="lot-item__state">
            <?php $timer = get_dt_range($lot['date_finish']); ?>
            <div class="lot-item__timer timer<?= $timer[0] < 1 ? ' timer--finishing' : ''; ?>">
                <?="$timer[0]:$timer[1]"?>
            </div>
            <div class="lot-item__cost-state">
              <div class="lot-item__rate">
                <span class="lot-item__amount">Текущая цена</span>
                <span class="lot-item__cost"><?=format_price($lot['start_price'])?></span>
              </div>
              <div class="lot-item__min-cost">
                Мин. ставка <span><?=format_price($lot['start_price'])?></span>
              </div>
            </div>
            <?php if ($is_auth): ?>
            <form class="lot-item__form" action="page-lot.php?id=<?= $id ?>" method="post" autocomplete="off">
              <p class="lot-item__form-item form__item<?php if ($error): ?> form__item--invalid<?php endif; ?>">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="text" name="cost" placeholder="<?= $min_bet ?>">
                <span class="form__error"><?= $error ?></span>
              </p>
              <button type="submit" class="button">Сделать ставку</button>
            </form>
            <?php endif; ?>
          </div>
          <?php if (!empty($history)): ?>
          <div class="history">
            <h3>История ставок (<span>10</span>)</h3>
            <table class="history__list">
              <?php foreach($history as $bet): ?>
              <tr class="history__item">
                <td class="history__name"><?= $bet["user_name"]; ?></td>
                <td class="history__price"><?= format_price($bet["price_bet"]); ?></td>
                <td class="history__time"><?= $bet["date_bet"]; ?></td>
              </tr>
              <?php endforeach; ?>
            </table>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
  </main>
