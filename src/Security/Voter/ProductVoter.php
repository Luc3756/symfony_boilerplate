<?php

namespace App\Security\Voter;

use App\Entity\Product;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ProductVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE = 'delete';
    const CREATE = 'create';
    const VIEW = 'view';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE, self::CREATE, self::VIEW]) && $subject instanceof Product;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->isAdmin($user)) {
            return true;
        }

        return false;
    }

    private function isAdmin(UserInterface $user): bool
    {
        return in_array('ROLE_ADMIN', $user->getRoles()) || 
               in_array('ROLE_MANAGER', $user->getRoles()) || 
               in_array('ROLE_USER', $user->getRoles());
    }
}
