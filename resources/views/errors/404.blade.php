<style>
    @use postcss-cssnext;
    /* helpers/align.css */

    .align {
        align-items: center;
        display: flex;
        flex-direction: row;
        justify-content: center;
    }

    /* helpers/animation.css */

    .animation {
        animation-duration: 0.6s;
        animation-fill-mode: both;
    }

    .animation--reverse {
        animation-direction: reverse;
    }

    /* helpers/animation-shake.css */

    @keyframes shake-vertical {

        15%,
        45%,
        75% {
            transform: translateY(-0.75rem);
        }

        30%,
        60% {
            transform: translateY(0.75rem);
        }

    }

    .animation--shake--vertical {
        animation-name: shake-vertical;
        will-change: transform;
    }

    :root {
        --grid-max-width: 40rem;
        --grid-width: 90%;
        --grid-gutter: 3%;
    }

    .grid {
        margin-left: auto;
        margin-right: auto;
        max-width: var(--grid-max-width);
        width: var(--grid-width);
    }

    .grid__row {
        display: flex;
        flex-wrap: wrap;
        margin: calc(var(--grid-gutter) / -2);
    }

    .grid__col {
        margin: calc(var(--grid-gutter) / 2);
        flex-grow: 1;
    }

    /* layout/base.css */

    :root {
        --html-font-size: 100%;

        --body-background-color: #f9f8f5;
        --body-color: #353535;
        --body-font-family: 'Roboto';
        --body-font-family-fallback: sans-serif;
        --body-font-size: 1rem;
        --body-font-weight: 400;
        --body-line-height: 1.5;
    }

    *,
    *::before,
    *::after {
        box-sizing: inherit;
    }

    html {
        box-sizing: border-box;
        font-size: var(--html-font-size);
        height: 100%;
    }

    body {
        background-color: var(--body-background-color);
        color: var(--body-color);
        font-family: var(--body-font-family), var(--body-font-family-fallback);
        font-size: var(--body-font-size);
        font-weight: var(--body-font-weight);
        line-height: var(--body-line-height);
        margin: 0;
        min-height: 100%;
    }

    /* modules/box.css */

    :root {
        --box-background-color: #fff;
        --box-padding-horizontal: 2rem;
        --box-padding-vertical: 3rem;
    }

    .box {
        background-color: var(--box-background-color);
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.3);
        font-size: 6.25rem;
        padding-bottom: var(--box-padding-vertical);
        padding-left: var(--box-padding-horizontal);
        padding-right: var(--box-padding-horizontal);
        padding-top: var(--box-padding-vertical);
        text-align: center;
    }
</style>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>404</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400" rel="stylesheet">

</head>

<body class="align">

    <div class="grid">

        <div class="grid__row">

            <div class="grid__col">
                <div class="box animation animation--shake--vertical">4</div>
            </div>

            <div class="grid__col">
                <div class="box animation animation--reverse animation--shake--vertical">0</div>
            </div>

            <div class="grid__col">
                <div class="box animation animation--shake--vertical">4</div>
            </div>

        </div>

    </div>

</body>

</html>
