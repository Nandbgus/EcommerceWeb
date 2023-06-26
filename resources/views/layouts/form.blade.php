@section('content')
<div class="card shadow p-3 mb-5 bg-white rounded">
    <div class="card-header bg-white">
        <h3>Tambahkan Product
            <a href="{{route('admin.categories.index')}}" class="button btn btn-info float-right">Back</a>
        </h3>
    </div>

    <div class="card-body ">
        <form action="{{route('admin.categories.store')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input for="text" name="name" class="form-control"></input>
            </div>
            <div class="form-group">
                <label for="Parent">Parent</label>
                <select name="category_id" class="form-control" id="">
                    <option value="">-- Default</option>
                    @foreach($categories as $id => $categoryName)
                    <option value="{{ $id }}">{{$categoryName}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="photo">Photo</label>
                <div class="needsclick dropzone" id="photoDropzone"></div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('style-alt')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

@push('script-alt')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>
    Dropzone.options.photoDropzone = {
        url: "{{ route('admin.categories.storeImage') }}",
        acceptedFiles: '.jpeg,.jpg,.png,.gif',
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function(file, response) {
            $('form').find('input[name="photo"]').remove()
            $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
        },
        removedfile: function(file) {
            file.previewElement.remove()
            if (file.status !== 'error') {
                $('form').find('input[name="photo"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
            }
        },
         init: function () {
            @if(isset($category) && $category->photo)
                var file = {!! json_encode($category->photo) !!}
                this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, "{{ $category->photo->getUrl() }}")
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
            @endif
        },
        error: function (file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends its own error messages in a string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }
            return _results
        }
    } 
</script>


@endpush