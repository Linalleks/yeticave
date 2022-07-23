<main class="container">
<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php foreach ($categories as $cat) :?>
        <li class="promo__item promo__item--<?=$cat['character_code']?>">
            <a class="promo__link" href="pages/all-lots.html"><?=$cat['name_category']?></a>
        </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?php foreach ($lots as $lot) : ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=$lot['img']?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=$lot['name_category']?></span>
                    <h3 class="lot__title"><a class="text-link" href="page-lot.php?id=<?=$lot['id']?>"><?=$lot['title']?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?=format_price($lot['start_price'])?></span>
                        </div>
                        <?php $timer = get_dt_range($lot['date_finish']); ?>
                        <div class="lot__timer timer<?= $timer[0] < 1 ? ' timer--finishing' : ''; ?>">
                            <?="$timer[0] : $timer[1]"?>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
</main>
