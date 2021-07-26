@if (!isset($visitor) || is_null($visitor))
<h3>Login</h3>
<div class="grid-x">
    <div class="cell small-6">
        <a href="{{ url('/sceneid') }}"
                class="success button expanded" style="    background-image: url(/images/frontend/SceneID_Icon_400x64.png); background-color: black !important; background-repeat: no-repeat; background-size: contain; background-position: left; height: 100%;">&nbsp;</a>
    </div>
</div>
@endif
@if (isset($visitor) && !is_null($visitor))
    <h4>Hello {{$visitor->name}}</h4>
    @if (!is_null($component->entries_page))
        @if ($visitor->new_comments > 0)
        <div class="callout warning">
            <a href="{{route('frontend.pages.index', ['slug' => $component->entries_page->full_slug])}}">
                You have {{$visitor->new_comments}} new
                @if ($visitor->new_comments > 1)
                messages
                @else
                message
                @endif
                for your entries!
            </a>
        </div>
        @endif
    @endif

<form id="logout" method="POST" class="form-inline">
    {{ csrf_field() }}
    <input type="hidden" name="logout" value="1">
    <ul class="vertical menu">
        @if (!is_null($component->entries_page))
        <li>
            <a href="{{route('frontend.pages.index', ['slug' => $component->entries_page->full_slug])}}">
                <i class="fa fa-cloud-upload-alt"></i>
                <span>My entries</span>
            </a>
        </li>
        @endif
        @if (config('partymeister-competitions-voting.party_has_voting') && !is_null($component->voting_page))
        <li>
            <a href="{{route('frontend.pages.index', ['slug' => $component->voting_page->full_slug])}}">
                <i class="fa fa-trophy"></i>
                <span>Vote for the compos</span>
            </a>
        </li>
        @endif
        @if (!is_null($component->comments_page))
        <li class="nav-item">
            <a href="{{route('frontend.pages.index', ['slug' => $component->comments_page->full_slug])}}">
                <i class="fa fa-comment"></i>
                <span>Write a message</span>
            </a>
        </li>
        @endif
        <li>
            <a class="logout" href="#">
                <i class="fa fa-lock"></i>
                <span>{{ trans('motor-backend::backend/login.sign_out') }}</span>
            </a>
        </li>
    </ul>
</form>
<div class="cables" style="margin-top: 20px;">
  <script type="text/javascript" src="{{ url('/cables/js/patch.js') }}" async></script>
  <script>
    document.addEventListener('CABLES.jsLoaded', function(event) {
      CABLES.patch = new CABLES.Patch({
        patch: CABLES.exportedPatch,
        prefixAssetPath: "{{ url('/cables') }}/",
        glCanvasId: 'glcanvas',
        glCanvasResizeToWindow: false,
        variables: {
          "handle":"{{$visitor->name}}"
        }
      });
      document.getElementById("glcanvas").addEventListener("click", function() {
        console.log("hepp");
        CABLES.patch.restart();
      });
    });
  </script>
  <div class="cablestext">
    Download your custom avatar by<br/>
    clicking on the image.<br/><br/>
    Use it everywhere!
  </div>
  <div class="cablespatch">
    <canvas id="glcanvas" style="cursor:pointer; width: 100%;"></canvas>
  </div>
</div>
@endif

@section('view-scripts')
<script>
    $(document).ready(function () {
        $('.logout').on('click', function () {
            $('form#logout').submit();
        })
    });
</script>
@append