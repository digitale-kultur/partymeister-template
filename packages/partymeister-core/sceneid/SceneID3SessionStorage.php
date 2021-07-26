<?php
namespace SceneOrg\SceneId;

class SceneID3SessionStorage implements SceneID3StorageInterface
{
    public function __construct( $start = true )
    {
        if ($start)
            @session_start();
    }
    public function Reset()
    {
        $_SESSION["sceneID"] = array();
    }
    public function Set( $key, $value )
    {
        if (!@$_SESSION["sceneID"])
            $_SESSION["sceneID"] = array();

        $_SESSION["sceneID"][$key] = $value;
    }
    public function Get( $key )
    {
        if (!@$_SESSION["sceneID"])
            return null;
        return @$_SESSION["sceneID"][$key];
    }
}
