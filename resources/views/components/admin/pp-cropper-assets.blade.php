@once
    @push('stylesheet')
        <link href="{{ asset('css/cropper.min.css') }}" rel="stylesheet"/>
        <style>
            #pp-cropper-modal .modal-content {
                background-color: var(--box-bg-color);
                color: var(--text-color);
            }
            #pp-cropper-modal .pp-cropper-stage {
                max-height: min(70vh, 520px);
                background: var(--body-background);
            }
            #pp-cropper-modal .pp-cropper-stage img {
                display: block;
                max-width: 100%;
            }
            #pp-cropper-modal .cropper-view-box,
            #pp-cropper-modal .cropper-face {
                border-radius: 0;
            }
        </style>
    @endpush
    @push('scripts')
        <script src="{{ asset('js/cropper.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/pp-cropper.js') }}" type="text/javascript"></script>
    @endpush
@endonce
