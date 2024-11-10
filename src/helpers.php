<?php


namespace Kathore\LaraFormik;

class helpers
{
    // Example package property
    protected $greetingMessage;

    // Constructor to initialize properties
    public function __construct($greetingMessage = "Welcome to Your Package!")
    {
        $this->greetingMessage = $greetingMessage;
    }

    /**
     * Get the greeting message.
     *
     * @return string
     */
    public function getGreetingMessage()
    {
        return $this->greetingMessage;
    }

    /**
     * Display a simple greeting.
     *
     * @return string
     */
    public function greet()
    {
        return $this->getGreetingMessage();
    }

    /**
     * Perform an action on some data.
     *
     * @param array $data
     * @return array
     */
    public function processData(array $data)
    {
        // Example data processing logic
        return array_map(function ($item) {
            return strtoupper($item);
        }, $data);
    }

    /**
     * Example helper function.
     *
     * @param string $name
     * @return string
     */
    public static function sayHello($name)
    {
        return "Hello, " . ucfirst($name) . "!";
    }
}
