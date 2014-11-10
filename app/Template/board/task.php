<?php if (isset($not_editable)): ?>

    <div class="task-header">

    <?= Helper\a('#'.$task['id'], 'task', 'readonly', array('task_id' => $task['id'], 'token' => $project['token'])) ?>

    <?php if ($task['reference']): ?>
    <span class="task-board-reference" title="<?= t('Reference') ?>">
        (<?= $task['reference'] ?>)
    </span>
    <?php endif ?>

    &nbsp;-&nbsp;

    <span class="task-board-category-container">
        <?php if ($task['score']): ?>
            <span class="task-score"><?= Helper\escape($task['score']) ?></span>
        <?php endif ?>
        <?php if ($task['category_id']): ?>
            <span class="task-board-category">
                <?= Helper\a(
                    Helper\in_list($task['category_id'], $categories),
                    'board',
                    'changeCategory',
                    array('task_id' => $task['id']),
                    false,
                    'category-popover',
                    t('Change category')
                ) ?>
            </span>
        <?php endif ?>
	</span>

    <span class="task-board-user">
    <?php if (! empty($task['owner_id'])): ?>
        <?= t('Assigned to %s', $task['assignee_name'] ?: $task['assignee_username']) ?>
    <?php else: ?>
        <span class="task-board-nobody"><?= t('Nobody assigned') ?></span>
    <?php endif ?>
    </span>

    </div>

    <div class="task-board-title">
        <?= Helper\a(Helper\escape($task['title']), 'task', 'readonly', array('task_id' => $task['id'], 'token' => $project['token'])) ?>
    </div>

<?php else: ?>

    <div  class="task-header">

    <?= Helper\a('#'.$task['id'], 'task', 'edit', array('task_id' => $task['id']), false, 'task-edit-popover', t('Edit this task')) ?>

    <?php if ($task['reference']): ?>
    <span class="task-board-reference" title="<?= t('Reference') ?>">
        (<?= $task['reference'] ?>)
    </span>
    <?php endif ?>

    &nbsp;-&nbsp;

    <span class="task-board-category-container">
        <?php if ($task['score']): ?>
            <span class="task-score"><?= Helper\escape($task['score']) ?></span>
        <?php endif ?>
        <?php if ($task['category_id']): ?>
            <span class="task-board-category">
                <?= Helper\a(
                    Helper\in_list($task['category_id'], $categories),
                    'board',
                    'changeCategory',
                    array('task_id' => $task['id']),
                    false,
                    'category-popover',
                    t('Change category')
                ) ?>
            </span>
        <?php endif ?>
	</span>

    <span class="task-board-user">
        <?= Helper\a(
            (! empty($task['owner_id']) ? t('Assigned to %s', $task['assignee_name'] ?: $task['assignee_username']) : t('Nobody assigned')) .
            (Helper\is_current_user($task['owner_id']) ? "<i class='fa fa-star'></i>" : ""),
            'board',
            'changeAssignee',
            array('task_id' => $task['id']),
            false,
            'assignee-popover',
            t('Change assignee')
        ) ?>
    </span>

    </div>

    <div class="task-board-title">
        <?= Helper\a(Helper\escape($task['title']), 'task', 'show', array('task_id' => $task['id']), false, '', t('View this task')) ?>
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
            <span title="<?= t('Attachments') ?>" class="task-board-tooltip" href="?controller=board&amp;action=getAttachments&amp;task_id=<?= $task['id'] ?>"><i class="fa fa-paperclip"></i><?= $task['nb_files'] ?></span>
        <?php endif ?>

        <?php if (! empty($task['nb_comments'])): ?>
            <span title="<?= p($task['nb_comments'], t('%d comment', $task['nb_comments']), t('%d comments', $task['nb_comments'])) ?>" class="task-board-tooltip" href="?controller=board&amp;action=getComments&amp;task_id=<?= $task['id'] ?>"><i class="fa fa-comment-o"></i><?= $task['nb_comments'] ?></span>
        <?php endif ?>

        <?php if (! empty($task['description'])): ?>
            <span title="<?= t('Description') ?>" class="task-board-tooltip" data-content="<?= Helper\escape(Helper\markdown($task['description'])) ?>">
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
