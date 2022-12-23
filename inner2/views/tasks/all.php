<div class="task-list">
    <h2>הנה רשימת המשימות</h2>
    <?php foreach($this->data['task_list'] as $task): ?>
        <div class="task">
            <a href="<?= inner_url('tasks/view/') ?>?row_id=<?= $task['id'] ?>"><?= $task['title'] ?></a>
        </div>
    <?php endforeach; ?>
</div>