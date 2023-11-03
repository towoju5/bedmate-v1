<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
    <style>
        body {
            max-width: 600px;
        }

        .red-bg {
            background: #E21F4E;
            padding: 15px 20px;
            display: flex;
            justify-content: center;
        }

        .main-bg {
            background: #EEF0F2;
            padding: 20px 20px;
        }

        .text-area {
            font-family: Montserrat;
            font-size: 26px;
            font-weight: 700;
            line-height: 36px;
            letter-spacing: 0.1507692039012909px;
            text-align: center;
        }

        .not-for-you {
            font-family: Montserrat;
            font-size: 18px;
            font-weight: 700;
            line-height: 27px;
            letter-spacing: 0px;
            text-align: center;
        }

        .not-worries {
            font-family: Montserrat;
            font-size: 17px;
            line-height: 28px;
            letter-spacing: 0px;
            text-align: center;
            font-weight: 700;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .footer {
            background: #FFFFFA;
        }

        .logo-2 {
            padding: 15px 10px;
            align-item: center;
            max-width: 90%;
        }

        .middlle-bg {
            background: #EEF0F2;
        }
        .justify {
            display: flex;
            justify-content: center;
            gap: 2.5rem;
            font-weight: 600;
        }

        .social {
            gap: 64px;
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .center {
            display: block;
            justify-content: center;
        }

        a {
            color: #000;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="red-bg">
        <img src="{{ asset('logo.png') }}" alt="Logo">
    </div>
    <div class="main-bg">
        <div class="middle-bg">
            <p class="text-area">
                Welcome to CUMRID - Your Journey Starts Here!
            </p>

            <p>Dear Ayomide,</p>

            <p>We're thrilled to welcome you to CUMRID, where a world of possibilities awaits. 🎉</p>

            <p>Your journey on CUMRID begins now. Download the app, explore, and discover the magic of our community. We
                can't wait to see what you'll bring to </p>the table!

            <p>If you have any questions or need assistance, feel free to reach out to our support team at
                support@[PlatformName].com.</p>

            <p>Welcome aboard, Johnny Sins Let's embark on this adventure together.</p>
            <p>Warm regards,</p>
            <p>Ayomide Black </p>
            <p>Product Designer </p>
            <p>CUMRID Team</p>

            <div class="not-worries">
                This email not for you?
            </div>

            <p style="align-text: left">
                No worries! Your address may have been entered by mistake. If you ignore or delete this email, nothing
                further will happen.
        </div>
    </div>
    <div class="footer">
        <img src="{{ asset('logo-2.jpg') }}" alt="logo-2" class="logo-2">
        <div style="align-item: center; padding: 40px;">
            <p class="not-for-you">Unlock Extraordinary Moments with Curated Connections...</p>
            <div class="justify">
                <img src="{{ asset('apple.png') }}" alt="Apple store">
                <img src="{{ asset('playstore.png') }}" alt="Playstore">
            </div>

            <div class="social">
                <a href="https://facebook.com"><img src="{{ asset('facebook.png')}}" alt="facebook"></a>
                <a href="https://x.com"><img src="{{ asset('x.png')}}" alt="twitter"></a>
                <a href="https://linkedin.com"><img src="{{ asset('linkedin.png')}}" alt="linkedin"></a>
                <a href="https://instagram.com"><img src="{{ asset('ig.png')}}" alt="Instagram"></a>
            </div>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Eu quis enim arcu porttitor dignissim. Diam fermentum vel diam tellus nunc urna, in nec. Sit sed odio elit sed sed auctor eu dui.</p>

            <div style="display: flex; justify-content: center">
                <div style="padding-top: 15px; text-align: center" class="center">
                    <p>Sent by CUMRID, location, P.O. Box</p>
    
                    <div style="margin-top: 15px; gap: 2.5rem;">
                        <a href="https://cumrid.com.ng/help">Help Center</a>
                        <a href="https://cumrid.com.ng/privacy-policy">Privacy Policy</a>
                        <a href="https://cumrid.com.ng/terms">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
