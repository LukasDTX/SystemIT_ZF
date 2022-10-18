<?php

namespace ZF2AuthAcl\Service;

interface UserServiceInterface {

    public function findAllUsers($where, $columns);
}
