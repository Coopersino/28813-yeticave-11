<main>
    <?= $navMenu; ?>
    <form class="form form--add-lot container <?=isset($errors) ? "form--invalid" : ""; ?>" action="../add.php" method="post" enctype="multipart/form-data">
    <h2>Добавление лота</h2>
    <div class="form__container-two">
      <div class="form__item form__item--invalid">
        <label for="lot-name">Наименование <sup>*</sup></label>
        <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота">
        <span class="form__error">Введите наименование лота</span>
      </div>
      <div class="form__item <?=isset($errors['category']) ? "form__item--invalid" : ""; ?>">
        <label for="category">Категория <sup>*</sup></label>
        <select id="category" name="category">
          <?php foreach ($categories as $category):?>
          <option value="<?=htmlspecialchars($category['id']); ?>"><?=htmlspecialchars($category['categor_name']);?></option>
          <?php endforeach; ?>
        </select>
        <span class="form__error"><?=$errors['category']; ?></span>
      </div>
    </div>
    <div class="form__item form__item--wide <?=isset($errors['message']) ? "form__item--invalid" : ""; ?>">
      <label for="message">Описание <sup>*</sup></label>
      <textarea id="message" name="message" placeholder="Напишите описание лота" value=<?=$_POST['message'] ?? ''?>></textarea>
      <span class="form__error"><?=$errors['message']; ?></span>
    </div>
    <div class="form__item form__item--file <?=isset($errors['jpg_img']) ? "form__item--invalid" : ""; ?>">
      <label>Изображение <sup>*</sup></label>
      <div class="form__input-file">
        <input class="visually-hidden" type="file" id="lot-img" name="jpg_img" value="">
        <label for="lot-img">
          Добавить
        </label>
        <span class="form__error"><?=$errors['jpg_img']; ?></span>
      </div>
    </div>
    <div class="form__container-three">
      <div class="form__item form__item--small <?=isset($errors['lot-rate']) ? "form__item--invalid" : ""; ?>">
        <label for="lot-rate">Начальная цена <sup>*</sup></label>
        <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value=<?=$_POST['lot-rate'] ?? ''?>>
        <span class="form__error"><?=$errors['lot-rate']; ?></span>
      </div>
      <div class="form__item form__item--small <?=isset($errors['lot-step']) ? "form__item--invalid" : ""; ?>">
        <label for="lot-step">Шаг ставки <sup>*</sup></label>
        <input id="lot-step" type="text" name="lot-step" placeholder="0" value=<?=$_POST['lot-step'] ?? ''?>>
        <span class="form__error"><?=$errors['lot-step']; ?></span>
      </div>
      <div class="form__item <?=isset($errors['lot-date']) ? "form__item--invalid" : ""; ?>">
        <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
        <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?= $data['lot-date']['value']; ?>">
        <span class="form__error"><?=$errors['lot-date']; ?></span>
      </div>
    </div>
    <?php if (isset($errors)): ?>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <?php endif; ?>
    <button type="submit" class="button">Добавить лот</button>
  </form>
</main>