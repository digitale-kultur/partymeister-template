<?php
namespace SceneOrg\SceneId;

interface SceneID3StorageInterface {
    public function Set( $key, $value );
    public function Get( $key );
}