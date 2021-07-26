<?php

/**
 * Wrapper library for authenticating and using SceneID 3.0
 * @author Gargaj / Conspiracy <gargaj@scene.org>
 */
namespace SceneOrg\SceneId;

class SceneID3 extends SceneID3OAuth
{
    function User( $userID )
    {
        $data = $this->ResourceRequestRefresh( static::ENDPOINT_RESOURCE . "/user/?id=" . (int)$userID );
        return $this->UnpackFormat( $data );
    }
    function Me()
    {
        $data = $this->ResourceRequestRefresh( static::ENDPOINT_RESOURCE . "/me/" );
        return $this->UnpackFormat( $data );
    }
}