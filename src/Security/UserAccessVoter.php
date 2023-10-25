<?php
// src/Security/UserAccessVoter.php

namespace App\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserAccessVoter extends Voter
{
    protected function supports(string $attribute, mixed $subject): bool    
    {
        // Check if the voter supports the given attribute
        return in_array($attribute, ['VIEW_USER']);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user) {
            return false;
        }

        // Check if the user has ROLE_ADMIN
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }

        // Implement logic to check for ROLE_GESTIONNAIRE
        if ($attribute === 'VIEW_USER' && in_array('ROLE_GESTIONNAIRE', $user->getRoles())) {
            // Implement your logic here to filter based on the associated company
            // Return true if the user has access to view the user
            // Return false if access is denied
        }

        return false;
    }
}
