<?php if (isset($not_editable)): ?>

    #<?= $task['id'] ?> -

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
        <?= Helper\escape($task['title']) ?>
    </div>

<?php else: ?>

    <a class="task-edit-popover" href="?controller=task&amp;action=edit&amp;task_id=<?= $task['id'] ?>" title="<?= t('Edit this task') ?>">#<?= $task['id'] ?></a> -

    <span class="task-board-user">
    <?php if (! empty($task['owner_id'])): ?>
        <a class="assignee-popover" href="?controller=board&amp;action=assign&amp;task_id=<?= $task['id'] ?>" title="<?= t('Change assignee') ?>"><?= t('Assigned to %s', $task['assignee_name'] ?: $task['assignee_username']) ?></a>
    <?php else: ?>
        <a class="assignee-popover" href="?controller=board&amp;action=assign&amp;task_id=<?= $task['id'] ?>" title="<?= t('Change assignee') ?>" class="task-board-nobody"><?= t('Nobody assigned') ?></a>
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
        <?php if (! empty($task['nb_files'])): ?>
            <i class="fa fa-paperclip" title="<?= t('Attachments') ?>"></i><?= $task['nb_files'] ?>
        <?php endif ?>

        <?php if (! empty($task['nb_comments'])): ?>
            <i class="fa fa-comment-o" title="<?= p($task['nb_comments'], t('%d comment', $task['nb_comments']), t('%d comments', $task['nb_comments'])) ?>"></i><?= $task['nb_comments'] ?>
        <?php endif ?>

        <?php if (! empty($task['nb_subtasks'])): ?>
            <i class="task-board-tooltip fa fa-check-square-o" title="<?= t('Subtasks') ?>" href='?controller=board&amp;action=getSubtasks&amp;task_id=<?= $task['id'] ?>'></i><?= $task['completed_subtasks'] ?>/<?= $task['nb_subtasks'] ?>
        <?php endif ?>

        <?php if (! empty($task['description'])): ?>
            <a class="task-board-popover" href='?controller=task&amp;action=editDescription&amp;task_id=<?= $task['id'] ?>'><i class="task-board-tooltip fa fa-file-text-o" title="<?= t('Description') ?>" data-content="<?= Helper\escape(Helper\parse($task['description'])) ?>"></i></a>
        <?php endif ?>
    </div>
</div>
<?php endif ?>
