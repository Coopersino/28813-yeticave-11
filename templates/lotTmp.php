<nav class="nav">
  <ul class="nav__list container">
      <?php foreach ($categories as $category): ?>
        <li class="nav__item">
          <a href="all-lots.html"><?= htmlspecialchars($category['categor_name']) ?></a>
        </li>
      <?php endforeach; ?>
  </ul>
</nav>

<section class="lot-item container">
  <h2><?= htmlspecialchars($advertisement['adv_name']) ?></h2>
  <div class="lot-item__content">
    <div class="lot-item__left">
      <div class="lot-item__image">
        <img src="<?= htmlspecialchars($advertisement['img_url']); ?>" width="730" height="548"
             alt="<?= htmlspecialchars($advertisement['categor_name']) ?>">
      </div>
      <p class="lot-item__category">Категория: <span><?= htmlspecialchars($advertisement['categor_name']) ?></span>
      </p>
      <p class="lot-item__description"><?= htmlspecialchars($advertisement['description']) ?></p>
    </div>
    <div class="lot-item__right">
        <?php if (isset($_SESSION['user'])): ?>
            <div class="lot-item__state">
                <?php $expTime = getDateRange($advertisement['expiration_date']) ?>
                <div class="lot__timer timer <?= ($expTime['hours'] == 0) ? 'timer--finishing' : '' ?>">
                    <?= $expTime['hours'] . ':' . $expTime['minutes'] ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?= htmlspecialchars(getFinancialFormat($advertisement['cost'])) ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= htmlspecialchars(getFinancialFormat($advertisement['rate_step'])) ?></span>
                    </div>
                </div>
                <form class="lot-item__form" action="" method="post" autocomplete="off">
                    <p class="lot-item__form-item form__item <?= isset($errors['cost']) ? "form__item--invalid" : ""; ?>">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="cost" placeholder="<?= $min_rate; ?>"
                               value="<?= isset($errors['cost']) ? $_POST['cost'] : $min_rate; ?>">
                        <span class="form__error"><?= $errors['cost']; ?></span>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
        <?php endif; ?>
        <div class="history">
            <h3>История ставок (<span><?= $count_rates; ?></span>)</h3>
            <table class="history__list">
                <?php foreach ($rate_data as $item): ?>
                <tr class="history__item">
                    <td class="history__name"><?= htmlspecialchars($item['user_name']); ?></td>
                    <td class="history__price"><?= htmlspecialchars($item['rate_value']); ?> р</td>
                    <td class="history__time"><?= dateToHumanFormat($item['dt_add']); ?></td>
                    <?php endforeach; ?>
                </tr>
            </table>
        </div>
    </div>
  </div>
</section>
