<?php

namespace Component\Security;

interface UserProviderInterface
{
	public function getUser($username);
	public function getPassword($username);
	public function getRoles($username);
	public function initialize($broker);
}