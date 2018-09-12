<?php
use ASweb\Auth\Auth;

if (!Auth::is_auth()) {
	Auth::authfromcookie();
}