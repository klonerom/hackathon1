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

        // Pas de negatif : min 0
        if ($this->getPower() <= 0) {
            $this->power = 0;
        }
    }
    
    public function kickDamage()
    {
        $this->damage = 20;

        $this->power = $this->getPower() - $this->damage;

        // Pas de negatif : min 0
        if ($this->getPower() <= 0) {
            $this->power = 0;
        }
    }
    
    public function specialDamage()
    {
        $this->damage = 50;

        $this->power = $this->getPower() - $this->damage;

        // Pas de negatif : min 0
        if ($this->getPower() <= 0) {
            $this->power = 0;
        }
    }

    /*
     * Init fighter
     *
     */
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
     * @return mixed
     */
    public function getCombat()
    {
        return $this->combat;
    }

    /**
     * @return mixed
     */
    public function getDurability()
    {
        return $this->durability;
    }

    /**
     * @return mixed
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @return mixed
     */
    public function getStrength()
    {
        return $this->strength;
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

    /**
     * @param mixed $combat
     */
    public function setCombat($combat)
    {
        $this->combat = $combat;
    }

    /**
     * @param mixed $durability
     */
    public function setDurability($durability)
    {
        $this->durability = $durability;
    }

    /**
     * @param mixed $intelligence
     */
    public function setIntelligence($intelligence)
    {
        $this->intelligence = $intelligence;
    }

    /**
     * @param mixed $speed
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;
    }

    /**
     * @param mixed $strength
     */
    public function setStrength($strength)
    {
        $this->strength = $strength;
    }
}
