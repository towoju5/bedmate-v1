<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OTP Email</title>
</head>

<body style="overflow: auto">
    <div class="email-container">
        <div style="justify-content: center;display: flex;">
            <img style="display: flex; justify-content: center;" src="https://api.zinar.io/logo.jpg" width="100%"
                alt="ZennahPay" />
        </div>

        <div class="email-body">
            <h3 class="greet-user">Hello {{ $user }},</h3>
            <p>Please use the below OTP code to proceed.</p>
            <h1 style="display: flex; justify-content: center;">{{ $otp }}</h1>
            <p>
                This code is only valid for 5 minutes, Please do not share your code
                with anyone.
            </p>
            <p class="note">
                NOTE: If you did not initiate this request, you can ignore this email.
                If you need more help you can <span><a href="https://www.zeenah.app/contact">Contact us</a></span>
            </p>
        </div>

        <div style="border-top: blueviolet 2px solid;text-align: center;">
            <h3>Stay connected</h3>

            <div class="social">
                <a href="">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e6/Twitter-new-logo.jpg/640px-Twitter-new-logo.jpg"
                        width="30px" height="30px" alt="" />
                </a>
                <a href="">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/58/Instagram-Icon.png/640px-Instagram-Icon.png"
                        width="30px" height="30px" alt="" />
                </a>
                <a href="">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c2/Facebook_icon_192.png/640px-Facebook_icon_192.png"
                        width="30px" height="30px" alt="" />
                </a>
            </div>
            <p>
                This email was sent from a notification address only, this address
                cannot accept emails, Please do not reply.
            </p>

            <p class="right">&copy;2023 Zeenah.app, All rights reserved.</p>
        </div>
    </div>
</body>

</html>
