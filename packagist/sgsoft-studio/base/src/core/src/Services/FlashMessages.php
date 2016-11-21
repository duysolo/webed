<?php namespace WebEd\Base\Core\Services;

class FlashMessages
{
    /**
     * @var array
     */
    protected $errorMessages = [];
    protected $infoMessages = [];
    protected $successMessages = [];
    protected $warningMessages = [];

    /**
     * Set flash message
     * @param $messages
     * @param $type
     */
    public function addMessages($messages, $type = null)
    {
        $model = 'infoMessages';
        switch ($type) {
            case 'error':
            case 'danger':
                $model = 'errorMessages';
                break;
            case 'success':
                $model = 'successMessages';
                break;
            case 'warning':
                $model = 'warningMessages';
                break;
        }
        foreach ((array)$messages as $key => $value) {
            array_push($this->$model, $value);
        }

        return $this;
    }

    /**
     * Get flash messages
     * @return array
     */
    public function getMessages()
    {
        return [
            'errorMessages' => $this->errorMessages,
            'infoMessages' => $this->infoMessages,
            'successMessages' => $this->successMessages,
            'warningMessages' => $this->warningMessages,
        ];
    }

    /**
     * Show all flash messages on session
     */
    public function showMessagesOnSession()
    {
        session()->flash('errorMessages', $this->errorMessages);
        session()->flash('infoMessages', $this->infoMessages);
        session()->flash('successMessages', $this->successMessages);
        session()->flash('warningMessages', $this->warningMessages);
    }

    /**
     * Unset flash messages
     * @param string $type
     * @return $this
     */
    public function removeMessagesByType($type = 'infoMessages')
    {
        if (property_exists($this, $type)) {
            $this->$type = [];
        }

        return $this;
    }

    /**
     * Clear all messages
     * @return $this
     */
    public function clearMessages()
    {
        $this->errorMessages = [];
        $this->infoMessages = [];
        $this->successMessages = [];
        $this->warningMessages = [];

        return $this;
    }

    public function hasMessages()
    {
        return !!$this->errorMessages || !!$this->infoMessages || !!$this->infoMessages || !!$this->successMessages || false;
    }
}
