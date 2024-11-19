<div id="loading-screen" style="display: flex; align-items: center; justify-content: center; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; background: rgba(255, 255, 255, 0.3); z-index: 1000;">
    <div style="color: #79bbb5" class="la-ball-clip-rotate la-2x">
        <div></div>
    </div>
</div>

<style>
    /*!
    * Load Awesome v1.1.0 (http://github.danielcardoso.net/load-awesome/)
    * Copyright 2015 Daniel Cardoso <@DanielCardoso>
    * Licensed under MIT
    */
    #loading-screen {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        width: 100vw;
        position: fixed;
        top: 0;
        left: 0;
        background: rgba(255, 255, 255, 0.3); /* Fondo más transparente */
        z-index: 1000;
    }

    .la-ball-clip-rotate,
    .la-ball-clip-rotate > div {
        position: relative;
        box-sizing: border-box;
    }

    .la-ball-clip-rotate {
        display: block;
        font-size: 0;
        color: #fff;
    }

    .la-ball-clip-rotate.la-dark {
        color: #333;
    }

    .la-ball-clip-rotate > div {
        display: inline-block;
        background-color: currentColor;
        border: 0 solid currentColor;
    }

    .la-ball-clip-rotate {
        width: 32px;
        height: 32px;
    }

    .la-ball-clip-rotate > div {
        width: 32px;
        height: 32px;
        background: transparent;
        border-width: 2px;
        border-bottom-color: transparent;
        border-radius: 100%;
        animation: ball-clip-rotate .75s linear infinite;
    }

    .la-ball-clip-rotate.la-sm {
        width: 16px;
        height: 16px;
    }

    .la-ball-clip-rotate.la-sm > div {
        width: 16px;
        height: 16px;
        border-width: 1px;
    }

    .la-ball-clip-rotate.la-2x {
        width: 64px;
        height: 64px;
    }

    .la-ball-clip-rotate.la-2x > div {
        width: 64px;
        height: 64px;
        border-width: 4px;
    }

    .la-ball-clip-rotate.la-3x {
        width: 96px;
        height: 96px;
    }

    .la-ball-clip-rotate.la-3x > div {
        width: 96px;
        height: 96px;
        border-width: 6px;
    }

    /*
    * Animation
    */
    @keyframes ball-clip-rotate {
        0% {
            transform: rotate(0deg);
        }
        50% {
            transform: rotate(180deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>
