<?php

namespace Action;

use Core\Listener;
use Core\Registry;
use Core\Tool;

/**
 * Base class for automatic actions
 *
 * @package action
 * @author  Frederic Guillot
 *
 * @property \Model\Acl                $acl
 * @property \Model\Task               $task
 */
abstract class Base implements Listener
{
    /**
     * Project id
     *
     * @access private
     * @var integer
     */
    private $project_id = 0;

    /**
     * User parameters
     *
     * @access private
     * @var array
     */
    private $params = array();

    /**
     * Attached event name
     *
     * @access protected
     * @var string
     */
    protected $event_name = '';

    /**
     * Registry instance
     *
     * @access protected
     * @var \Core\Registry
     */
    protected $registry;

    /**
     * Execute the action
     *
     * @abstract
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool            True if the action was executed or false when not executed
     */
    abstract public function doAction(array $data);

    /**
     * Get the required parameter for the action (defined by the user)
     *
     * @abstract
     * @access public
     * @return array
     */
    abstract public function getActionRequiredParameters();

    /**
     * Get the required parameter for the event (check if for the event data)
     *
     * @abstract
     * @access public
     * @return array
     */
    abstract public function getEventRequiredParameters();

    /**
     * Get the compatible events
     *
     * @abstract
     * @access public
     * @return array
     */
    abstract public function getCompatibleEvents();

    /**
     * Check if the event data meet the action condition
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool
     */
    abstract public function hasRequiredCondition(array $data);

    /**
     * Constructor
     *
     * @access public
     * @param  \Core\Registry   $registry         Regsitry instance
     * @param  integer          $project_id       Project id
     * @param  string           $event_name       Attached event name
     */
    public function __construct(Registry $registry, $project_id, $event_name)
    {
        $this->registry = $registry;
        $this->project_id = $project_id;
        $this->event_name = $event_name;
    }

    /**
     * Return class information
     *
     * @access public
     * @return string
     */
    public function __toString()
    {
        return get_called_class();
    }

    /**
     * Load automatically models
     *
     * @access public
     * @param  string $name Model name
     * @return mixed
     */
    public function __get($name)
    {
        return Tool::loadModel($this->registry, $name);
    }

    /**
     * Set an user defined parameter
     *
     * @access public
     * @param  string  $name    Parameter name
     * @param  mixed   $value   Value
     */
    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
    }

    /**
     * Get an user defined parameter
     *
     * @access public
     * @param  string  $name            Parameter name
     * @param  mixed   $default_value   Default value
     * @return mixed
     */
    public function getParam($name, $default_value = null)
    {
        return isset($this->params[$name]) ? $this->params[$name] : $default_value;
    }

    /**
     * Check if an action is executable (right project and required parameters)
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool            True if the action is executable
     */
    public function isExecutable(array $data)
    {
        return $this->hasCompatibleEvent() &&
               $this->hasRequiredProject($data) &&
               $this->hasRequiredParameters($data) &&
               $this->hasRequiredCondition($data);
    }

    /**
     * Check if the event is compatible with the action
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool
     */
    public function hasCompatibleEvent()
    {
        return in_array($this->event_name, $this->getCompatibleEvents());
    }

    /**
     * Check if the event data has the required project
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool
     */
    public function hasRequiredProject(array $data)
    {
        return isset($data['project_id']) && $data['project_id'] == $this->project_id;
    }

    /**
     * Check if the event data has required parameters to execute the action
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool            True if all keys are there
     */
    public function hasRequiredParameters(array $data)
    {
        foreach ($this->getEventRequiredParameters() as $parameter) {
            if (! isset($data[$parameter])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Execute the action
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool            True if the action was executed or false when not executed
     */
    public function execute(array $data)
    {
        if ($this->isExecutable($data)) {
            return $this->doAction($data);
        }

        return false;
    }
}
