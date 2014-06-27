<section>
<?php
function subTaskText($subtask) {
    $text = Helper\escape($subtask['title']);
    if (isset($subtask['username']))
        $text .= " [" . $subtask['username'] . "]";
    return $text;
}
?>
    <?php foreach ($subtasks as $subtask): ?>
        <a href="?controller=board&amp;action=toggleSubtask&amp;task_id=<?= $task['id'] ?>&amp;subtask_id=<?= $subtask['id'] ?>">
            <?php if ($subtask['status'] == 0): ?>
                <i class="fa fa-square-o fa-fw" title="<?= Helper\escape($subtask['status_name']) ?>"></i><i class="fa">&nbsp;<?= subTaskText($subtask) ?></i>
            <?php elseif ($subtask['status'] == 1): ?>
                <i class="fa fa-spinner fa-spin fa-fw" title="<?= Helper\escape($subtask['status_name']) ?>"></i><i class="fa">&nbsp;<?= subTaskText($subtask) ?></i>
            <?php else: ?>
                <i class="fa fa-check-square-o fa-fw" title="<?= Helper\escape($subtask['status_name']) ?>"></i><i class="fa">&nbsp;<?= subTaskText($subtask) ?></i>
            <?php endif ?>
        </a>
<br>
    <?php endforeach ?>
</section>
