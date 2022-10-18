<div>
    <div>Hi {{$userAuth->id}}!</div>
    <br>
    <div>We've received your request to reset your password. If you don't want to change your password or if you didn't request it, please ignore this email.</div><br>
    <div><a href="{{$userAuth->siteUrl}}/account/forget-password/{{$userAuth->token}}">Reset My Password</a></div>
    <br>
    <div>
        If you have any questions, please <a href="{{$userAuth->siteUrl}}">contact us</a> through our customer support page.
    </div>
</div>
