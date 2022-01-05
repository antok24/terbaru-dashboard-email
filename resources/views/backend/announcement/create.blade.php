@extends('layouts.main')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/stisla/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Buat Pengumuman</h1>
    </div>

    <form method="POST" action="{{ route('announcement.store') }}" enctype="multipart/form-data">
      <div class="row">
        <div class="col-lg-8">
          <div class="card card-primary">
            <div class="card-body">
              @csrf

              <div class="row">
                <div class="form-group col-12 {{ $errors->has('alternative_id') ? ' has-error' : '' }}">
                  <label for="members">Penerima</label>
                  <select name="members" id="" class="form-control select2 @if ($errors->has('members')) is-invalid @endif" data-placeholder="Pilih Members Penerima Email">
                    <option value=""></option>
                    @foreach ($members as $item)
                      <option value="{{ $item->role }}" {{ (old('members') == $item->role) ? 'selected' : "" }}>{{ $item->role }}</option>
                    @endforeach
                  </select>
                  @if ($errors->has('members'))
                    <div class="invalid-feedback">
                      {{ $errors->first('members') }}
                    </div>
                  @endif
                </div>
              </div>

              <div class="row">
                <div class="form-group col-12 {{ $errors->has('subject') ? ' has-error' : '' }}">
                  <label for="subject">Subject</label>
                  <input id="subject" type="text" class="form-control @if ($errors->has('subject')) is-invalid @endif" name="subject" tabindex="1" value="{{ old('subject') }}">
                  @if ($errors->has('subject'))
                    <div class="invalid-feedback">
                      {{ $errors->first('subject') }}
                    </div>
                  @endif
                </div>
              </div>

              <div class="row">
                <div class="form-group col-12 {{ $errors->has('content') ? ' has-error' : '' }}">
                  <label for="content">Content</label>
                  <textarea id="content" class="summernote @if ($errors->has('content')) is-invalid @endif" name="content" tabindex="1" >{{ old('content') }}</textarea>
                  @if ($errors->has('content'))
                    <div class="invalid-feedback">
                      {{ $errors->first('content') }}
                    </div>
                  @endif
                </div>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" tabindex="4">
                  Kirim Email
                </button>
              </div>
              
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card card-primary">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold">Gambar Paket</h6>
            </div>
            <div class="card-body">
              <div class="form-group">
                <div class="text-center">
                  <img src="{{ asset('assets/stisla/img/example-image.jpg') }}" class="rounded-circle" id="image-prev" width="200" height="200" alt="image">
                </div>
              </div>
              <div class="form-group custom-file mb-3">
                <input id="file" type="file" class="custom-file-input {{ $errors->has('file') ? ' has-error' : '' }}" name="file">
                <label class="custom-file-label" for="customFile">Pilih Gambar</label>
              </div>
              @if ($errors->has('file'))
                <div class="invalid-feedback">
                  <strong>{{ $errors->first('file') }}</strong>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </form>
  </section>
@endsection

@section('script')
<script src="{{ asset('assets/stisla/modules/summernote/summernote-bs4.js') }}"></script>
  <script type="text/javascript">
    $(".summernote").summernote({
        dialogsInBody: true,
        minHeight: 250,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['fontname', ['fontname']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture']],
          ['view', ['codeview', 'help']],
        ],
    });
    
    $(document).ready(function () {
      bsCustomFileInput.init()
      $('.select2').select2();
    })

    function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#image-prev').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]); // convert to base64 string
      }
    }

    $("#image").change(function() {
      readURL(this);
    });
  </script>
@endsection