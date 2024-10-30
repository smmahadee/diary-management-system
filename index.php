<?php

require __DIR__ . '/inc/db-connect.inc.php';
require __DIR__. '/inc/functions.inc.php';

date_default_timezone_set('Asia/Dhaka');

$perPage = 2;
$page = (int) ($_GET['page'] ?? 1);
$offset = ($page - 1) * $perPage;


$stmt = $pdo->prepare('SELECT * FROM entries ORDER BY `date` DESC, `id` desc LIMIT :perPage offset :offset');
$stmt->bindValue('perPage', (int) $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', (int) $offset, PDO::PARAM_INT);
$stmt->execute();

$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt2 = $pdo->prepare('SELECT count(*) as  `count` from entries');
$stmt2->execute();

$totalEntries = $stmt2->fetch(PDO::FETCH_ASSOC)['count'];
$totalPage = ceil($totalEntries / $perPage);

?>

<?php require __DIR__ . '/views/header.view.php' ?>

<h1 class="main-heading">Entries</h1>
<?php foreach ($entries as $entry) : ?>
<div class="card">
    <div class="card__image-container">
        <img class="card__image" src="<?php echo $entry['image']  ?>" alt="" />
    </div>
    <div class="card__desc-container">
        <?php
            $timestamp = strtotime($entry['date']);
            $formattedDate = date('d/m/Y', $timestamp);
        ?>
        <div class="card__desc-time"><?php echo e($formattedDate); ?></div>
        <h2 class="card__heading"><?php echo e($entry['title']) ?></h2>
        <p class="card__paragraph">
            <?php echo nl2br(e($entry['message'])) ?>
        </p>
        </p>
    </div>
</div>
<?php endforeach; ?>

<?php if($totalPage > 1) : ?>
<ul class="pagination">
    <?php if($page > 1) : ?>
    <li class="pagination__li">
        <a class="pagination__link" href="?<?php echo http_build_query(['page' => $page - 1 ]) ?>">⏴ </a>
    </li>
    <?php endif;?>
    
    <?php for ($i = 1; $i <= $totalPage; $i++) :?>
        <li class="pagination__li">
            <a class="pagination__link <?php echo $i === $page? 'pagination__link--active' : ''?>" 
            href="?<?php echo http_build_query(['page' => $i])?>"><?php echo $i?></a>
        </li>
    <?php endfor;?>
  
    <?php if($page < $totalPage) : ?>
    <li class="pagination__li">
        <a class="pagination__link" 
        href="?<?php echo http_build_query(['page' => $page + 1]) ?>">⏵</a>
    </li>
    <?php endif;?>
</ul>
<?php endif;?>

<?php require __DIR__ . '/views/footer.view.php' ?>