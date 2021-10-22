<?php


namespace App\Security\Voter;


use App\Entity\Event;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class EventVoter extends Voter
{
    protected function supports(string $attribute, $subject)
    {

        if($subject && !$subject instanceof Event) {
            return false;
        }

        $policies = [
            'CAN_REMOVE',
            'CAN_EDIT',
            'CAN_LIST_EVENT',
            'CAN_LIST_ALL_EVENTS',
            'CAN_CREATE_EVENT'
        ];

        return in_array($attribute, $policies);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if (in_array('ROLE_ADMIN',  $user->getRoles())){
            return true;
        }

        if ($attribute === 'CAN_LIST_ALL_EVENTS') {
            return in_array('ROLE_MODERATOR', $user->getRoles()) || in_array('ROLE_ADMIN', $user->getRoles());
        }

        if ($attribute === 'CAN_CREATE_EVENT') {
            return !in_array('ROLE_USER', $user->getRoles());
        }

        if ($attribute === 'CAN_EDIT') {
            return $subject->user === $user;
        }

        if ($attribute === 'CAN_REMOVE') {
            return in_array('ROLE_MODERATOR', $user->getRoles()) || in_array('ROLE_ADMIN', $user->getRoles()) || $subject->user === $user;
        }

        return true;
    }
}