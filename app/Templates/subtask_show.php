<div class="page-header">
    <h2><?= t('Sub-Tasks') ?></h2>
</div>

<?php

$total_spent = 0;
$total_estimated = 0;
$total_remaining = 0;

?>

<table class="subtasks-table">
    <tr>
        <th width="40%"><?= t('Title') ?></th>
        <th><?= t('Status') ?></th>
        <th><?= t('Assignee') ?></th>
        <th><?= t('Time tracking') ?></th>
        <th><?= t('Actions') ?></th>
    </tr>
    <?php foreach ($subtasks as $subtask): ?>
    <tr>
        <td><?= Helper\escape($subtask['title']) ?></td>
        <td>
            <a href="?controller=subtask&amp;action=toggleStatus&amp;task_id=<?= $task['id'] ?>&amp;subtask_id=<?= $subtask['id'] ?>">
                <?php if ($subtask['status'] == 0): ?>
                    <i class="fa fa-square-o fa-fw"></i><i class="fa">&nbsp;<?= Helper\escape($subtask['status_name']) ?></i>
                <?php elseif ($subtask['status'] == 1): ?>
                    <i class="fa fa-spinner fa-spin fa-fw"></i><i class="fa">&nbsp;<?= Helper\escape($subtask['status_name']) ?></i>
                <?php else: ?>
                    <i class="fa fa-check-square-o fa-fw"></i><i class="fa">&nbsp;<?= Helper\escape($subtask['status_name']) ?></i>
                <?php endif ?>
            </a>
        </td>
        <td>
            <?php if (! empty($subtask['username'])): ?>
                <?= Helper\escape($subtask['username']) ?>
            <?php endif ?>
        </td>
        <td>
            <?php if (! empty($subtask['time_spent'])): ?>
                <strong><?= Helper\escape($subtask['time_spent']).'h' ?></strong> <?= t('spent') ?>
            <?php endif ?>

            <?php if (! empty($subtask['time_estimated'])): ?>
                <strong><?= Helper\escape($subtask['time_estimated']).'h' ?></strong> <?= t('estimated') ?>
            <?php endif ?>
        </td>
        <td>
            <a href="?controller=subtask&amp;action=edit&amp;task_id=<?= $task['id'] ?>&amp;subtask_id=<?= $subtask['id'] ?>"><?= t('Edit') ?></a>
            <?= t('or') ?>
            <a href="?controller=subtask&amp;action=confirm&amp;task_id=<?= $task['id'] ?>&amp;subtask_id=<?= $subtask['id'] ?>"><?= t('Remove') ?></a>
        </td>
    </tr>
        <?php
            $total_estimated += $subtask['time_estimated'];
            $total_spent += $subtask['time_spent'];
            $total_remaining = $total_estimated - $total_spent;
        ?>
    <?php endforeach ?>

</table>

<form method="post" action="?controller=subtask&amp;action=save&amp;task_id=<?= $task['id'] ?>" autocomplete="off">
    <?= Helper\form_csrf() ?>
    <?= Helper\form_hidden('task_id', array('task_id'=>$task['id'])) ?>
    <?= Helper\form_text('title', $values, array(), array('required', 'placeholder="' . t('Type here to create a new sub-task') . '"')) ?>
    <input type="submit" value="<?= t('Add') ?>" class="btn btn-blue"/>
</form>

<div class="subtasks-time-tracking">
    <h4><?= t('Time tracking') ?></h4>
    <ul>
        <li><?= t('Estimate:') ?> <strong><?= Helper\escape($total_estimated) ?></strong> <?= t('hours') ?></li>
        <li><?= t('Spent:') ?> <strong><?= Helper\escape($total_spent) ?></strong> <?= t('hours') ?></li>
        <li><?= t('Remaining:') ?> <strong><?= Helper\escape($total_remaining > 0 ? $total_remaining : 0) ?></strong> <?= t('hours') ?></li>
    </ul>
</div>
