<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
<<<<<<< HEAD
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="//fonts.googleapis.com" />
    <link rel="preconnect" href="//fonts.gstatic.com" crossorigin />
    <link href="//fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,800&display=swap"
        rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            list-style: none;
            text-decoration: none;
            max-width: 100%;
            /* border: 1px solid red; */
        }

        .banner {
            background-color: #ff4848;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .logo {
            margin-top: 1rem;
        }

        .logo-text {
            color: white;
            margin-top: .5rem;
            margin-bottom: 1rem;
        }

        .contents {
            margin-top: .5rem;
            padding: 20px;
            max-width: 100%;
            background-color: gainsboro;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: start;
        }

        .header {
            margin-bottom: 1rem;
            align-self: center;
            font-family: Montserrat, Arial, Helvetica, sans-serif;
        }

        .contents p {
            line-height: 2.3rem;
            font-family: Poppins, Arial, Helvetica, sans-serif;
            font-weight: 400;
        }

        footer {
            margin-top: 1rem;
            max-width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
        }

        .buttons {
            display: flex;
            justify-content: center;
        }

        .buttons button {
            padding: 10px 30px;
            margin: 30px;
            text-transform: capitalize;
            border-radius: 5px;
            border: .2px solid;
            background-color: #ff4848;
            color: white;
        }

        .buttons :nth-child(2) {
            margin-left: 8px;
            background-color: black;
            color: white;
        }

        .playstore {
            display: flex;
            flex-direction: row;
            justify-content: space-evenly;
            align-items: center;
            cursor: pointer;
        }

        .appstore {
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .social-links {
            display: flex;
            padding-left: 20px;
            justify-content: space-evenly;
            align-items: center;
            margin-bottom: 1rem;
        }

        footer .loc {
            margin-top: 1rem;
            color: black;
        }

        .contact-links {
            display: flex;
            justify-content: center;
            padding: 15px;
        }

        .contact-links a {
            padding: 0px 15px;
            color: black;
            text-decoration: underline;
=======
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
>>>>>>> d9c9e64fa65359c8b436f513e49a8158be33773b
        }
    </style>
</head>

<body>
<<<<<<< HEAD
    <section class="banner">
        <div>
            <img src="https://cumrid.com.ng/Assets/Heart.png" alt="" class="logo">
        </div>
        <img src="https://cumrid.com.ng/Assets/cumrid.png" alt="" class="logo">
        <p class="logo-text">Unlock Extraordinary Moments with Curated Connections...</p>
    </section>
    <section class="contents">
        <h1 class="header" style="padding-bottom: 3px">Welcome to CUMRID - Your Journey Starts Here!</h1>
        <h3 class="greet-user">Hello {{ $user }},</h3>
        <p>Please use the below OTP code to proceed.</p>
        <h1 style="display: flex; justify-content: center;">{{ $otp }}</h1>
        
        <br> CUMRID Team
        <h3 class="header">This email not for you?</h3>
        <p>
            No worries! Your address may have been entered by mistake.
            If you ignore or delete this email, nothing further will happen.
        </p>
    </section>
    <footer>
        <center>
            <img src="Assets/bottom_logo.png" alt="">
            <p style="font-weight: bold;">Unlock Extraordinary Moments with Curated Connections...</p>
        </center>
        <div class="buttons">
            <button class="playstore">
                <svg width="24" height="26" viewBox="0 0 24 26" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="Google Play logo">
                        <path id="Subtract" fill-rule="evenodd" clip-rule="evenodd"
                            d="M16.425 7.39757L5.23422 0.907636C4.8116 0.654509 4.31836 0.508423 3.79054 0.508423C2.70133 0.508423 1.74348 1.16844 1.28428 2.09104L1.36793 2.17467L11.5085 12.3131L16.425 7.39757ZM0.998954 3.17929C0.997054 3.2202 0.996094 3.26128 0.996094 3.30251V22.6976C0.996094 22.7388 0.997053 22.7798 0.998951 22.8207L10.8216 12.9999L0.998954 3.17929ZM1.2843 23.9089C1.74357 24.8315 2.70157 25.4916 3.79054 25.4916C4.30699 25.4916 4.79188 25.352 5.2077 25.1068L5.24073 25.0875L16.4443 18.6213L11.5085 13.6866L1.36793 23.8253L1.2843 23.9089ZM17.3153 18.1186L21.8781 15.4851C22.7545 15.0119 23.3495 14.088 23.3495 13.0226C23.3495 11.9648 22.7625 11.0454 21.8948 10.5708L21.8849 10.564L17.2945 7.90181L12.1954 12.9999L17.3153 18.1186Z"
                            fill="#EBE4E4" />
                    </g>
                </svg>
                <p></p>
                Get it on Google Play
            </button>
            <button class="appstore">
                <svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 384 512">
                    <style>
                        svg {
                            fill: #ebe5e5
                        }
                    </style>
                    <path
                        d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 76.4 17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 19.8-27.8 44.3-25.6 71.9 26.1 2 49.9-11.4 69.5-34.3z" />
                </svg>
                <p></p>
                Coming soon
            </button>
        </div>
        <div class="social-links">
            <a href="https://www.facebook.com/profile.php?id=61551119541795&mibextid=D4KYlr" target="_blank">
                <img src="Assets/facebook.png" alt="">
            </a>

            <a href="https://twitter.com/officialcumrid?t=vQncJvaauS1xMOsSN9gj_g&s=09" target="_blank">
                <img src="Assets/twitter.png" alt="twitter icon" />

            </a>

            <a href="#">

                <img src="Assets/linkedin.png" alt="linkedin icon" />
            </a>
            <a href="#">

                <img src="Assets/instagram.png" alt="instagram icon" />
            </a>
        </div>
        <center style="color: #7A7474;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Eu quis enim arcu
            porttitor dignissim. Diam fermentum vel diam tellus nunc urna, in nec. Sit sed odio elit sed sed auctor eu
            dui.
            <p class="loc">Sent by CUMRID, location, P.O. Box</p>
            <div class="contact-links">
                <a href="">Help Center</a>
                <a href="">Privacy Policy</a>
                <a href="">Terms of Service</a>
            </div>
        </center>
    </footer>
=======
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
>>>>>>> d9c9e64fa65359c8b436f513e49a8158be33773b
</body>

</html>
