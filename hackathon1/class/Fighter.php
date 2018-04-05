<?php

class Fighter
{
    private $id;
    private $name;
    private $damage;
    private $intelligence;
    private $strength;
    private $speed;
    private $durability;
    private $power;
    private $combat;


    const CEST_MOI = 1; // Constante renvoyée par la méthode `frapper` si on se frappe soi-même.
    const PERSONNAGE_TUE = 2; // Constante renvoyée par la méthode `frapper` si on a tué le personnage en le frappant.
    const PERSONNAGE_FRAPPE = 3; // Constante renvoyée par la méthode `frapper` si on a bien frappé le personnage.


    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    public function punch(Fighter $perso)
    {
        if ($perso->getId() != $this->id)
        {
            // On indique au personnage qu'il doit recevoir des dégâts.
            return $perso->punchDamage();
        }
    }

    public function kick(Fighter $perso)
    {
        if ($perso->getId() != $this->id)
        {
            // On indique au personnage qu'il doit recevoir des dégâts.
            return $perso->kickDamage();
        }

    }

    public function special(Fighter $perso)
    {
        if ($perso->getId() != $this->id)
        {
            // On indique au personnage qu'il doit recevoir des dégâts.
            return $perso->specialDamage();
        }
    }


    public function punchDamage()
    {
        $this->damage = 15;

        $this->power = $this->getPower() - $this->damage;

        // Si on a 100 de dégâts ou plus, on dit que le personnage a été tué.
        if ($this->getPower() <= 0) {
            $this->power = 0;
        }
    }
    
    public function kickDamage()
    {
        $this->damage = 20;

        $this->power = $this->getPower() - $this->damage;

        // Si on a 100 de dégâts ou plus, on dit que le personnage a été tué.
        if ($this->getPower() <= 0) {
            $this->power = 0;
        }
    }
    
    public function specialDamage()
    {
        $this->damage = 50;

        $this->power = $this->getPower() - $this->damage;

        // Si on a 100 de dégâts ou plus, on dit que le personnage a été tué.
        if ($this->getPower() <= 0) {
            $this->power = 0;
        }
    }


    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {
            $method = 'set'.ucfirst($key);

            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }

    // GETTERS //


    public function getdamage()
    {
        return $this->damage;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getIntelligence()
    {
        return $this->intelligence;
    }

    /**
     * @return mixed
     */
    public function getPower()
    {
        return $this->power;
    }


    /**
     * @param mixed $power
     */
    public function setPower($power)
    {
        $this->power = $power;
    }


    public function setdamage($damage)
    {
        $damage = (int) $damage;

        if ($damage >= 0 && $damage <= 100)
        {
            $this->damage = $damage;
        }
    }

    public function setId($id)
    {
        $id = (int) $id;

        if ($id > 0)
        {
            $this->id = $id;
        }
    }

    public function setName($name)
    {
        if (is_string($name))
        {
            $this->name = $name;
        }
    }
}
