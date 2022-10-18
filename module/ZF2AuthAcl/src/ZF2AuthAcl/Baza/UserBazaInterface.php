<?php

namespace ZF2AuthAcl\Baza;

interface UserBazaInterface {

    public function findAll($where, $columns);
    public function getRolePermissions();
    public function getUserRoles($where = array(), $columns = array());
    public function getAllResources();
}
