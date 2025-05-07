<div>
    <style>
        .zodiac-loader-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            bottom: 0;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0.6));
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .as_loader img {
            animation: spin 7s infinite linear;
        }

        /* Animation for image spinning */
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
    <div wire:loading.inline>
        <div class="zodiac-loader-container">
            <div class="as_loader">
                <img src="frontend/images/loader.png" width="120">
            </div>
        </div>
    </div>
</div>
