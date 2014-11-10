<?php

namespace Action;

use Model\Task;

/**
 * Move a task to another project
 *
 * @package action
 * @author  Frederic Guillot
 */
class TaskMoveAnotherProject extends Base
{
    /**
     * Get the list of compatible events
     *
     * @access public
     * @return array
     */
    public function getCompatibleEvents()
    {
        return array(
            Task::EVENT_MOVE_COLUMN,
            Task::EVENT_CLOSE,
        );
    }

    /**
     * Get the required parameter for the action (defined by the user)
     *
     * @access public
     * @return array
     */
    public function getActionRequiredParameters()
    {
        return array(
            'column_id' => t('Column'),
            'project_id' => t('Project'),
        );
    }

    /**
     * Get the required parameter for the event
     *
     * @access public
     * @return string[]
     */
    public function getEventRequiredParameters()
    {
        return array(
            'task_id',
            'column_id',
            'project_id',
        );
    }

    /**
     * Execute the action (move the task to another project)
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool            True if the action was executed or false when not executed
     */
    public function doAction(array $data)
    {
        $task = $this->taskFinder->getById($data['task_id']);
        $this->task->moveToAnotherProject($this->getParam('project_id'), $task);
        return true;
    }

    /**
     * Check if the event data meet the action condition
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool
     */
    public function hasRequiredCondition(array $data)
    {
        return $data['column_id'] == $this->getParam('column_id') && $data['project_id'] != $this->getParam('project_id');
    }
}
