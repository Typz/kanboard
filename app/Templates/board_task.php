<?php if (isset($not_editable)): ?>

    <a href="?controller=task&amp;action=readonly&amp;task_id=<?= $task['id'] ?>&amp;token=<?= $project['token'] ?>">#<?= $task['id'] ?></a> -

    <span class="task-board-user">
    <?php if (! empty($task['owner_id'])): ?>
        <?= t('Assigned to %s', $task['assignee_name'] ?: $task['assignee_username']) ?>
    <?php else: ?>
        <span class="task-board-nobody"><?= t('Nobody assigned') ?></span>
    <?php endif ?>
    </span>

    <div class="task-board-category-container">
        <?php if ($task['score']): ?>
            <span class="task-score"><?= Helper\escape($task['score']) ?></span>
        <?php endif ?>
        <?php if ($task['category_id']): ?>
            <span class="task-board-category"><?= Helper\in_list($task['category_id'], $categories) ?></span>
        <?php endif ?>
    </div>

    <div class="task-board-title">
        <a href="?controller=task&amp;action=readonly&amp;task_id=<?= $task['id'] ?>&amp;token=<?= $project['token'] ?>">
            <?= Helper\escape($task['title']) ?>
        </a>
    </div>

<?php else: ?>

    <a class="task-edit-popover" href="?controller=task&amp;action=edit&amp;task_id=<?= $task['id'] ?>" title="<?= t('Edit this task') ?>">#<?= $task['id'] ?></a> -

    <span class="task-board-user">
        <a class="assignee-popover" href="?controller=board&amp;action=changeAssignee&amp;task_id=<?= $task['id'] ?>" title="<?= t('Change assignee') ?>">
        <?php if (! empty($task['owner_id'])): ?>
            <?= t('Assigned to %s', $task['assignee_name'] ?: $task['assignee_username']) ?></a>
        <?php else: ?>
            <?= t('Nobody assigned') ?>
        <?php endif ?>
        </a>
    </span>

    <div class="task-board-category-container">
        <?php if ($task['score']): ?>
            <span class="task-score"><?= Helper\escape($task['score']) ?></span>
        <?php endif ?>
        <?php if ($task['category_id']): ?>
            <span class="task-board-category">
                <a class="category-popover" href="?controller=board&amp;action=changeCategory&amp;task_id=<?= $task['id'] ?>" title="<?= t('Change category') ?>">
                    <?= Helper\in_list($task['category_id'], $categories) ?>
                </a>
            </span>
        <?php endif ?>
    </div>

    <div class="task-board-title">
        <a href="?controller=task&amp;action=show&amp;task_id=<?= $task['id'] ?>" title="<?= t('View this task') ?>"><?= Helper\escape($task['title']) ?></a>
    </div>

<?php endif ?>

<?php if (! empty($task['date_due']) || ! empty($task['nb_files']) || ! empty($task['nb_comments']) || ! empty($task['description']) || ! empty($task['nb_subtasks'])): ?>
<div class="task-board-footer">

    <?php if (! empty($task['date_due'])): ?>
    <div class="task-board-date <?= time() > $task['date_due'] ? 'task-board-date-overdue' : '' ?>">
        <i class="fa fa-calendar"></i> <?= dt('%b %e, %G', $task['date_due']) ?>
    </div>
    <?php endif ?>

    <div class="task-board-icons">

        <?php if (! empty($task['nb_subtasks'])): ?>
            <span class='task-board-tooltip' title="<?= t('Sub-Tasks') ?>" href='?controller=board&amp;action=getSubtasks&amp;task_id=<?= $task['id'] ?>'><i class="fa fa-bars"><?= $task['nb_completed_subtasks'].'/'.$task['nb_subtasks'] ?></i></span>
        <?php endif ?>

        <?php if (! empty($task['nb_files'])): ?>
            <span title="<?= t('Attachments') ?>"><i class="fa fa-paperclip"></i><?= $task['nb_files'] ?></span>
        <?php endif ?>

        <?php if (! empty($task['nb_comments'])): ?>
            <span title="<?= p($task['nb_comments'], t('%d comment', $task['nb_comments']), t('%d comments', $task['nb_comments'])) ?>"><i class="fa fa-comment-o"></i><?= $task['nb_comments'] ?></span>
        <?php endif ?>

        <?php if (! empty($task['description'])): ?>
            <span title="<?= t('Description') ?>" class="task-board-tooltip" data-content="<?= Helper\escape(Helper\parse($task['description'])) ?>">
            <?php if (! isset($not_editable)): ?>
                <a class="task-description-popover" href="?controller=task&amp;action=description&amp;task_id=<?= $task['id'] ?>"><i class="fa fa-file-text-o" data-href="?controller=task&amp;action=description&amp;task_id=<?= $task['id'] ?>"></i></a>
            <?php else: ?>
                <i class="fa fa-file-text-o"></i>
            <?php endif ?>
            </span>
        <?php endif ?>
    </div>
</div>
<?php endif ?>
