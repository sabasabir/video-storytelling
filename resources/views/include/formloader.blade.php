@push('style')
    <style>
        .loader {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            background: transparent;
            margin: 30px auto 0 auto;
            border: solid 2px #424242;
            border-top: solid 2px #1c89ff;
            border-radius: 50%;
            opacity: 0;
        }

        .check {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transform: translate3d(-4px, 50px, 0);
            opacity: 0;
        }

        /* ✅ Converted the nested SCSS into normal CSS */
        .check span:nth-child(1) {
            display: block;
            width: 10px;
            height: 2px;
            background-color: #fff;
            transform: rotate(45deg);
        }

        .check span:nth-child(2) {
            display: block;
            width: 20px;
            height: 2px;
            background-color: #fff;
            transform: rotate(-45deg) translate3d(14px, -4px, 0);
            transform-origin: 100%;
        }

        .loader.active {
            animation: loading 2s ease-in-out;
            animation-fill-mode: forwards;
        }

        .check.active {
            opacity: 1;
            transform: translate3d(-4px, 4px, 0);
            transition: all 0.5s cubic-bezier(0.49, 1.74, 0.38, 1.74);
            transition-delay: 0.2s;
        }

        @keyframes loading {
            30% {
                opacity: 1;
            }

            85% {
                opacity: 1;
                transform: rotate(1080deg);
                border-color: #262626;
            }

            100% {
                opacity: 1;
                transform: rotate(1080deg);
                border-color: #1c89ff;
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush
<div class="loader">
<div class="check">
    <span class="check-one"></span>
    <span class="check-two"></span>
</div>
</div>
@push('scripts')
    <script>

    </script>
@endpush
