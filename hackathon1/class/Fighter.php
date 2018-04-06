<?php
require_once '../private/bd.php';

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
    private $fightId;


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
        $pdo->exec("INSERT INTO attack (attacking, move, defending, fight_id) VALUES ($this->getId(), ' a punché dans sa face ', $perso->getId(), $fightId)");
    }

    public function kick(Fighter $perso)
    {
        if ($perso->getId() != $this->id)
        {
            // On indique au personnage qu'il doit recevoir des dégâts.
            return $perso->kickDamage();
        }
        $pdo->exec("INSERT INTO attack (attacking, move, defending, fight_id) VALUES ($this->getId(), ' a donné un kick à ', $perso->getId(), $fightId)");
    }

    public function special(Fighter $perso)
    {
        if ($perso->getId() != $this->id)
        {
            // On indique au personnage qu'il doit recevoir des dégâts.
            return $perso->specialDamage();
        }
        $pdo->exec("INSERT INTO attack (attacking, move, defending, fight_id) VALUES ($this->getId(), ' a utilisé son coup spécial sur ', $perso->getId(), $fightId)");
    }

    public function punchDamage()
    {
        $this->damage = rand(10,40);

        $this->power = $this->getPower() - $this->damage;

        // Pas de negatif : min 0
        if ($this->getPower() <= 0) {
            $this->power = 0;
        }
    }
    
    public function kickDamage()
    {
        $this->damage = rand(30,60);

        $this->power = $this->getPower() - $this->damage;

        // Pas de negatif : min 0
        if ($this->getPower() <= 0) {
            $this->power = 0;
        }
    }
    
    public function specialDamage()
    {
        $this->damage = rand(40,70);

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

    public function getDamage()
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
     * @return mixed
     */
    public function getFightId()
    {
        return $this->fightId;
    }

    /**
     * @param mixed $power
     */
    public function setPower($power)
    {
        $this->power = $power;
    }


    public function setDamage($damage)
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

    /**
     * @param mixed $strength
     */
    public function setFightId($fightId)
    {
        $this->fightId = $fightId;
    }
}
