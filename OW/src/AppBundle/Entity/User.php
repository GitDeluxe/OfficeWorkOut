<?php

namespace AppBundle\Entity;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
/**
 *Class User
 *@package AppBundle/Entity
 **
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
   /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */

  
    protected $id;
    

 
    public function getId()
    {
        return $this->id;
    }


    /**
     * @ORM\Column(name="moves_id", type="string", length=255, nullable=true)
     */
    private $movesId;

    private $movesAccessToken;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $movesId
     * @return User
     */
    public function setmovesId($movesId)
    {
        $this->movesId = $movesId;

        return $this;
    }

    /**
     * @return string
     */
    public function getmovesId()
    {
        return $this->movesId;
    }

    /**
     * @param string $movesAccessToken
     * @return User
     */
    public function setmovesAccessToken($movesAccessToken)
    {
        $this->movesAccessToken = $movesAccessToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getmovesAccessToken()
    {
        return $this->movesAccessToken;
    }
}
```

}
