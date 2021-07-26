<?php

namespace Partymeister\Core\Http\Controllers\Api;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Motor\Backend\Http\Controllers\Controller;
use Partymeister\Core\Events\VisitorRegistered;
use Partymeister\Core\Models\Visitor;
use Partymeister\Core\Services\Component\VisitorLoginService;
use Partymeister\Core\Services\Component\VisitorRegistrationService;
use SceneOrg\SceneId\SceneID3;

/**
 * Class SceneIdController
 * @package Partymeister\Core\Http\Controllers\Api
 */
class SceneIdController extends Controller
{

    public function redirect(Request $request)
    {
        $error = $request->get('error', false);
        $code = $request->get('code', false);
        $state = $request->get('state', false);
        $sceneId = new SceneID3([
            "clientID" => config('partymeister-core-visitor-registration.sceneid.clientID'),
            "clientSecret" => config('partymeister-core-visitor-registration.sceneid.clientSecret'),
            "redirectURI" => config('partymeister-core-visitor-registration.sceneid.redirectURI')
        ]);
        if ($error) {
            print "Nix is";
            die();
        } else if ($code) {
            if ($sceneId->ProcessAuthResponse($code, $state)) {
                $result = $sceneId->Me();

                $visitor = Visitor::whereEmail($result['user']['id'] . '@id.scene.org')->first();
                if($visitor) {
                    $visitor->name = $result['user']['display_name'];
                    $visitor->save();
                }else{
                    $visitor = Visitor::create([
                        'email'              => $result['user']['id'] . '@id.scene.org',
                        'name'               => $result['user']['display_name'],
                        'group'              => "",
                        'country_iso_3166_1' => "",
                        'api_token'          => Str::random(60),
                    ]);
                }
                $request->session()->regenerate();
                event(new Registered($visitor));
                Auth::guard('visitor')->login($visitor);
                return redirect(url('/start'));
            }
        } else {
            return redirect($sceneId->GetAuthURL());
        }
    }

}
