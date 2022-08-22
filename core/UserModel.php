<?php

    namespace amohd12\phpmvc;
    use amohd12\phpmvc\db\DbModel;

    abstract class UserModel extends DbModel {

        abstract public function getDisplayName(): string;

    }