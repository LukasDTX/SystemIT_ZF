<?php

namespace ZF2AuthAcl\Service;

use ZF2AuthAcl\Mapper\UserMapperInterface;

class UserService implements UserServiceInterface {

    protected $userMapper;

    public function __construct(UserMapperInterface $userMapper) {
        $this->userMapper = $userMapper;
    }

    public function findAllUsers($where, $columns) {
        return $this->userMapper->findAll($where, $columns);
    }

}
