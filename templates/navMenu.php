<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
            <li class="nav__item">
                <a href="index.php?id=<?= htmlspecialchars($category['id']); ?>"><?= htmlspecialchars($category['categor_name']); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>