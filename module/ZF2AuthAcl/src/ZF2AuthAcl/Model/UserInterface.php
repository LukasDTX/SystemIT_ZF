<?php

namespace ZF2AuthAcl\Model;

interface UserInterface {

    public function getId();

    public function getEmail();

    public function getPassword();
}
