  <main>
  <?php
    // var_dump($bets);
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
    <section class="rates container">
      <h2>Мои ставки</h2>
      <?php if (!empty($bets)): ?>
      <table class="rates__list">
        <?php foreach($bets as $bet): ?>
        <tr class="rates__item">
          <td class="rates__info">
            <div class="rates__img">
            <img src="../<?= $bet["img"]; ?>" width="54" height="40" alt="Сноуборд">
            </div>
            <h3 class="rates__title"><a href="page-lot.php?id=<?= $bet["id"]; ?>"><?= $bet["title"]; ?></a></h3>
          </td>
          <td class="rates__category">
            <?= $bet["name_category"]; ?>
          </td>
          <td class="rates__timer">
            <?php $timer = get_dt_range($bet["date_finish"]); ?>
            <div class="timer <?php if ($timer[0] < 1 && $timer[0] != 0): ?>timer--finishing <?php elseif($timer[0] == 0): ?>timer--end<?php endif; ?>">
              <?php if ($timer[0] != 0): ?>
                <?="$timer[0] : $timer[1]"?>
              <?php else: ?>
                Торги окончены
              <?php endif; ?>
            </div>
          </td>
          <td class="rates__price">
            <?= format_price($bet["price_bet"]); ?>
          </td>
          <td class="rates__time">
            <?= $bet["date_bet"]; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>
      <?php endif; ?>
    </section>
  </main>