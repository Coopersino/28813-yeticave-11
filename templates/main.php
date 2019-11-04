<section class="promo">
  <h2 class="promo__title">Нужен стафф для катки?</h2>
  <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное
    снаряжение.</p>
  <ul class="promo__list">
    <!--заполните этот список из массива категорий-->
      <?php foreach ($categories as $category): ?>
        <li class="promo__item promo__item--boards">
          <a class="promo__link" href="pages/all-lots.html"><?= htmlspecialchars($category) ?></a>
        </li>
      <?php endforeach; ?>
  </ul>
</section>
<section class="lots">
  <div class="lots__header">
    <h2>Открытые лоты</h2>
  </div>
  <ul class="lots__list">
    <!--заполните этот список из массива с товарами-->
      <?php foreach ($advertisements as $advertisement): ?>
        <li class="lots__item lot">
          <div class="lot__image">
            <img src="<?= htmlspecialchars($advertisement['img_url']) ?>" width="350" height="260" alt="">
          </div>
          <div class="lot__info">
            <span class="lot__category"><?= htmlspecialchars($advertisement['category']) ?></span>
            <h3 class="lot__title"><a class="text-link"
                                      href="pages/lot.html"><?= htmlspecialchars($advertisement['name']) ?></a></h3>
            <div class="lot__state">
              <div class="lot__rate">
                <span class="lot__amount">Стартовая цена</span>
                <span class="lot__cost"><?= htmlspecialchars(getFinancialFormat($advertisement['cost'])) ?></span>
              </div>
                <?php $expTime = getDateRange($advertisement['expiration_date']); ?>
              <div class="lot__timer timer <?= ($expTime['hours'] == 0) ? 'timer--finishing' : '' ?>">
                  <?= $expTime['hours'] . ':' . $expTime['minutes'] ?>
              </div>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
  </ul>
</section>