<?php
    
namespace Application\Form;

use \ArrayObject;

use Zend\Form\Form;
use Zend\Http\Request;
use Zend\Session\Container;

/**
* Ein Formular, das seine Daten in der Session hält.
*/
class SessionForm extends Form
{
    /**
    * Der Sessioncontainer
    * @var ArrayObject
    */
    protected $sessionData;
    
    /**
    * {@inheritdoc}
    */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        
        // Session-Container erstellen und ans Formular hängen
        $container = new Container(__CLASS__ . '__' . $this->sanitizeFormName($name));
        
        if (!isset($container->data)) {
            $container->data = $this->getDefaultData();
        }
        
        $this->sessionData = $container->data;
        
        $this->bind($this->sessionData);
    }
    
    protected function getDefaultData()
    {
        return new ArrayObject();
    }
    
    /**
    * Übernimmt die geposteten Daten in die Session.
    * 
    * @param Request $request
    * @return bool true, wenn gepostet wurde und die Daten validiert werden konnten; ansonsten false
    */
    public function handleRequest(Request $request)
    {
        // Haben wir überhaupt etwas zu handlen?
        if ($request->isPost()) {
            // Wenn ja, dann die Daten ins Formular schieben
            $this->setData($request->getPost());
        }
        
        // Daten-Check (muss auch geschehen, wenn kein Request gepostet wurde!)
        $isValid = $this->isValid();
        
        if ($isValid) {
            $this->populateValues($this->sessionData);
        }
        
        if ($isValid && $request->isPost()) {
            return true;
        }
        return false;
    }
    
    /**
    * Gibt nur die ausgefüllten Werte zurück. Werte mit Null oder '' werden ignoriert.
    * 
    * @return array
    */
    public function getFilledValues()
    {
        $data = $this->getData()->getArrayCopy();
        foreach ($data as $key => $value) {
            if ($value === null || $value === '') {
                unset ($data[$key]);
            }
        }
        return $data;
    }
    
    /**
    * Ersetzt Sonderzeichen durch '_', damit der Name als Session-Container-Identifier verwendet werden kann.
    * 
    * @param mixed $name
    * @return string
    */
    protected function sanitizeFormName($name)
    {
        return preg_replace('#[^a-zA-Z0-9\_]#', '_', $name);
    }
}