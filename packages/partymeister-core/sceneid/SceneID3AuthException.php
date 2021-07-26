<?php
namespace SceneOrg\SceneId;

class SceneID3AuthException extends SceneID3Exception
{
    public function __construct($message, $code = 0, Exception $previous = null, $dataJSON = "")
    {
        $data = json_decode($dataJSON);
        if ($data && $data->error_description)
            $message .= ": " . $data->error_description;
        else
            $message .= ": \"" . $dataJSON . "\"";
        parent::__construct($message, $code, $previous);
    }
}