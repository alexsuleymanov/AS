<?php

interface Model_DBInterface {
	public function q(string $query);
	public function mq(string $query);
}
