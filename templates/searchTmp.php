<?= $nav_menu; ?>
<main class="container">
    <section class="lots">
        <?php if (empty($advertisements)): ?>
            <h2>Ничего не найдено по вашему запросу</h2>
        <?php else: ?>
        <h2>Результаты поиска по запросу «<span><?= $search; ?></span>»</h2>
        <ul class="lots__list">
            <?php foreach ($advertisements as $advertisement): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= htmlspecialchars($advertisement['img_url']); ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= htmlspecialchars($advertisement['adv_name']); ?></span>
                        <h3 class="lot__title"><a class="text-link"
                                                  href="lot.php?id=<?= htmlspecialchars($advertisement['id']); ?>"><?= htmlspecialchars($advertisement['adv_name']); ?></a>
                        </h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= htmlspecialchars(getFinancialFormat($advertisement['cost'])); ?></span>
                            </div>
                            <?php $expTime = getDateRange($advertisement['expiration_date']); ?>
                            <div class="lot__timer timer <?= ($expTime['hours'] == 0) ? 'timer--finishing' : '' ?>">
                                <?= $expTime['hours'] . ':' . $expTime['minutes'] ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </section>
</main>