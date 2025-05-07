<div wire:ignore>

    <textarea wire:model="message" id="summernote-{{ $responseID }}" rows="6"
        class="form-control" required></textarea>
    {{-- <script>
        $(document).ready(function() {
            $(`#summernote-{{ $responseID }}`).summernote({
                placeholder: 'Write your email body here...',
                tabsize: 2,
                height: 200
            });
        });
    </script> --}}
</div>
