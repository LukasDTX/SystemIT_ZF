<?php

namespace ZF2AuthAcl\Service;

interface RoleServiceInterface {

    public function getUserRoles($where, $columns);
}