<div>
    <div>Hi {{$userAuth->id}}!</div>
    <br>
    <div>Thank you for creating your Account.</div>
    <br>
    <div>Help us secure your account by verifying your email address. </div>
    <div><a href="{{$userAuth->siteUrl}}/account/email-verify/{{$userAuth->token}}">Verify email address</a></div>
    <br>
    <div>
        If you have any questions, please <a href="{{$userAuth->siteUrl}}">contact us</a> through our customer support page.
    </div>
</div>
