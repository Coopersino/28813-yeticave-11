<?php if ($pagesCount > 1): ?>
    <ul class="pagination-list">
        <?php if (isset($search)): ?>
            <li class="pagination-item pagination-item-prev"><?php if ($currentPage > 1): ?><a
                        href="/<?= $filename; ?>?search=<?= $search; ?>&page=<?= ($currentPage - 1); ?>"><?php endif; ?>
                    Назад</a></li>
            <?php foreach ($pages as $page): ?>
                <li class="pagination-item <?php if ($page == $currentPage) : ?>pagination-item-active<?php endif; ?>">
                    <a href="/<?= $filename; ?>?search=<?= $search; ?>&page=<?= $page; ?>"><?= $page; ?></a></li>
            <?php endforeach; ?>
            <li class="pagination-item pagination-item-next"><?php if ($currentPage < $pagesCount): ?><a
                        href="/<?= $filename; ?>?search=<?= $search; ?>&page=<?= ($currentPage + 1); ?>"><?php endif; ?>
                    Вперед</a></li>

        <?php elseif (isset($category_id)): ?>
            <li class="pagination-item pagination-item-prev"><?php if ($currentPage > 1): ?><a
                        href="/<?= $filename; ?>?id=<?= $category_id; ?>&page=<?= ($currentPage - 1); ?>"><?php endif; ?>
                    Назад</a></li>
            <?php foreach ($pages as $page): ?>
                <li class="pagination-item <?php if ($page == $currentPage) : ?>pagination-item-active<?php endif; ?>">
                    <a href="/<?= $filename; ?>?id=<?= $category_id; ?>&page=<?= $page; ?>"><?= $page; ?></a></li>
            <?php endforeach; ?>
            <li class="pagination-item pagination-item-next"><?php if ($currentPage < $pagesCount): ?><a
                        href="/<?= $filename; ?>?id=<?= $category_id; ?>&page=<?= ($currentPage + 1); ?>"><?php endif; ?>
                    Вперед</a></li>

        <?php else: ?>
            <li class="pagination-item pagination-item-prev"><?php if ($currentPage > 1): ?><a
                        href="/?page=<?= ($currentPage - 1); ?>"><?php endif; ?>Назад</a></li>
            <?php foreach ($pages as $page): ?>
                <li class="pagination-item <?php if ($page == $currentPage) : ?>pagination-item-active<?php endif; ?>">
                    <a
                            href="/?page=<?= $page; ?>"><?= $page; ?></a></li>
            <?php endforeach; ?>
            <li class="pagination-item pagination-item-next"><?php if ($currentPage < $pagesCount): ?><a
                        href="/?page=<?= ($currentPage + 1); ?>"><?php endif; ?>Вперед</a></li>
        <?php endif; ?>
    </ul>
<?php endif; ?>