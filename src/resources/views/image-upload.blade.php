<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Zuno</title>
        <style>
            @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css");

            html {
                box-sizing: border-box;
                font: 16px/1.5 Georgia, "Times New Roman", Times, serif;
            }

            *,
            ::after,
            ::before {
                box-sizing: inherit;
            }

            * {
                margin: 0;
                padding: 0;
            }

            body {
                overflow-x: hidden;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                gap: 6em;
            }

            .site-header {
                padding-top: 1em;
                display: flex;
                flex-wrap: wrap;
                justify-content: space-around;
                align-items: center;
            }

            .site-header p {
                color: purple;
                font-size: 1.5em;
                font-weight: 700;
            }

            .site-header p::after {
                display: block;
                content: "The last Web Agency you will ever need";
                color: #000;
                font-weight: 400;
                text-transform: uppercase;
                font-size: 1rem;
                letter-spacing: -0.03rem;
            }

            .site-navigation ul {
                display: flex;
                gap: 1.5em;
            }

            .site-navigation ul li {
                display: block;
                list-style: none;
            }

            .site-navigation ul li a {
                color: #000;
                text-decoration: none;
                font-size: 1.2em;
            }

            .site-main {
                padding-bottom: 6em;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 6em;
            }

            .site-main .main-header {
                max-width: 50%;
                display: flex;
                align-items: center;
            }

            .site-main .main-header article {
                flex: 1 1 60%;
                display: flex;
                flex-direction: column;
                gap: 1em;
            }

            .site-main .main-header article h1 {
                font-size: 1.5rem;
            }

            .site-main .main-header article a {
                align-self: flex-start;
                padding: 0.5em 1em;
                color: #000;
                text-decoration: none;
                border: 0.1em solid #000;
                border-radius: 0.3em;
                transition: box-shadow 0.4s ease-in-out;
            }

            .site-main .main-header article a:hover {
                box-shadow: 0 0 1em 0 rgba(0, 0, 0, 0.5);
            }

            .site-main .main-header svg {
                flex: 1 1 20%;
                font-size: 10em;
                scale: 1;
                transition: scale 0.4s ease-in-out;
            }

            .site-main .main-header svg:hover {
                scale: 1.1;
            }

            .site-main .our-team-section,
            .site-main .testimonials-section {
                max-width: 50%;
            }
        </style>
    </head>

    <body>
        <main class="site-main" style="margin-top: 100px">
            <section class="main-header">
                <form
                    action="{{ route('image-upload') }}"
                    method="post"
                    enctype="multipart/form-data"
                >
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label"
                            >Email address</label
                        >
                        <input type="email" class="form-control" name="email" />
                        <!-- Show Specific Error Message -->
                        @if (session()->has('email'))
                        {{ session()->get('email') }}
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label"
                            >Password</label
                        >
                        <input
                            type="password"
                            class="form-control"
                            name="password"
                        />
                        <!-- Show Specific Error Message -->
                        @if (session()->has('password'))
                        {{ session()->get('password') }}
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputimage" class="form-label"
                            >Image</label
                        >
                        <input type="file" class="form-control" name="file" />
                        <!-- Show Specific Error Message -->
                        @if (session()->has('image'))
                        {{ session()->get('password') }}
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </form>
            </section>
        </main>
    </body>
</html>
