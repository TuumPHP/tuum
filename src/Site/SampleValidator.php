<?php
namespace Demo\Site;

class SampleValidator
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var bool
     */
    private $isValid = true;

    /**
     * @param array $data
     * @return bool
     */
    public function validate($data)
    {
        $this->data = $data;
        $this->required('name', 'maybe your name?');
        $this->required('gender', 'pick your gender');
        $this->snsKind('facebook', 'requires facebook address @ in it');
        $this->snsKind('twitter', 'requires twitter address @ in it');
        return $this->isValid;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $name
     * @param string $message
     */
    private function snsKind($name, $message='must contain @ mark')
    {
        $sns = $this->get('sns');
        if(!isset($sns[$name]) || !$sns[$name]) {
            $this->errors['sns'][$name] = 'required value';
            $this->isValid = false;
        }
        elseif(strpos($sns[$name], '@') === false) {
            $this->errors['sns'][$name] = $message;
            $this->isValid = false;
        }
    }
    
    /**
     * @param string $name
     * @param string $message
     */
    private function required($name, $message='required')
    {
        if(!$this->get($name)) {
            $this->error($name, $message);
        }
    }

    /**
     * @param string $name
     * @param string $message
     */
    private function error($name, $message)
    {
        $this->errors[$name] = $message;
        $this->isValid = false;
    }

    /**
     * @param string $name
     * @return string|array
     */    
    private function get($name)
    {
        $found = array_key_exists($name, $this->data) ? $this->data[$name] : '';
        return is_array($found) ? $found : (string) $found; 
    }
}