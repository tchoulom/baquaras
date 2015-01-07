<?php

namespace Baquaras\TestBundle\Services;
 
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
 
class RoleUsers implements VoterInterface
{
    // Cette méthode permet de définir pour quels rôles le voteur doit être
    // appelé, nous définissons ici que ce voteur sera appelé seulement sur
    // les rôles qui commencent par 'ROLE_ARTICLE_'
    public function supportsAttribute($attribute)
    {
        return 1 === preg_match('/^ROLE_ARTICLE_/', $attribute);
    }
 
    // Cette méthode est utilisée pour vérifier la classe de l'utilisateur,
    // ce qui ne nous concerne pas dans notre exemple
    public function supportsClass($class) 
    {
        return true;
    }
 
    // La méthode principale qui doit retourner le vote
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        // Par défaut, nous n'intervenons pas dans la décision de vote
        $vote = VoterInterface::ACCESS_ABSTAIN;
 
        // Nous vérifions tous les rôles à tester...
        foreach ($attributes as $attribute) {
            // ... et nous ignorons ceux qui ne nous concernent pas
            if (false === $this->supportsAttribute($attribute)) {
                continue;
            }
 
            // pour les rôles qui nous concernent, nous enverrons par défaut
            // un refus, à moins que l'utilisateur soit propriétaire de 
            // l'article
            $user = $token->getUser();
            $vote = VoterInterface::ACCESS_DENIED;
 
            // $object est l'objet passé en paramètre lors de l'appel de 
            // "isGranted" dans notre action, c'est donc notre article
            if ($object->getAuthor()->getId() === $user->getId()) {
                $vote = VoterInterface::ACCESS_GRANTED;
            }
        }   
 
        return $vote;
    }
}

