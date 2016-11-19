<?php namespace WebEd\Base\Core\Services;

class Validator
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Get errors, no array key
     * @return array
     */
    public function getOnlyMessages()
    {
        $messages = [];
        foreach ($this->errors as $key => $row) {
            foreach ($row as $keyRow => $valueRow) {
                $messages[] = $valueRow;
            }
        }

        return $messages;
    }

    /**
     * Validate entity
     * @param array $data
     * @param array $rules
     * @return bool
     */
    public function make($data, $rules)
    {
        $result = app('validator')->make($data, $rules);
        if ($result->fails()) {
            $this->errors = $result->messages()->toArray();
            return false;
        }
        $this->reset();
        return true;
    }

    /**
     * Reset validator
     * @return $this
     */
    public function reset()
    {
        $this->errors = [];

        return $this;
    }
}
