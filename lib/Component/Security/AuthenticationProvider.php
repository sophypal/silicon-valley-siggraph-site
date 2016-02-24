<?php 

namespace Component\Security;

use Component\Listener\ListenerInterface;

class UserNotFoundException extends \Exception {}
class UserAuthenticationFailed extends \Exception {}

interface AuthenticationProvider
{
	public function authenticate($username, $password);
	public function authenticated($token);
	public function deauthenticate();
	public function setUserProvider($userProvider);
	public function addListener(ListenerInterface $listener);
}

?>