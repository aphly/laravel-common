<div>
    <div>Hi {{$userAuth->id}}!</div>
    <div>Help us secure your account by verifying your email address. </div>
    <div><a href="{{$userAuth->siteUrl}}/account/mail-verify/{{$userAuth->token}}">Verify email address</a></div>
</div>
