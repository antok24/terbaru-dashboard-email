@extends('layouts.main')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Pengumuman</h1>
    </div>

    <div class="d-sm-flex align-items-center justify-content-start mb-4">
      <a class="btn btn-sm btn-primary mr-auto" href="{{ route('announcement.create') }}"><i class="fa fa-plus"></i> Buat Pengumuman</a>
    </div>

    <div class="row">
      <div class="col-lg-12">

        <!-- Basic Card Example -->
        <div class="card card-primary">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">List Pengumuman</h6>
          </div>
          <div class="card-body">

          <div class="table-responsive">
            <table class="table table-striped datatable">
              <thead>                                 
                <tr>
                  <th>#</th>
                  <th>Subject</th>
                  <th>Content</th>
                  <th>Pengirim</th>
                  <th>Penerima</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>

          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
@section('script')
<script>
  $(document).ready(function() {
      $('.datatable').DataTable({
          processing: true,
          serverSide: true,
          autoWidth: false,
          language: {
              url: '{{ asset('assets/stisla/modules/datatables/lang/Indonesian.json') }}'
          },
          ajax: {
            url: '{{ route('announcement.index') }}',
            data: function (d) {
              d.status = $('select[name=status]').val()
            }
          },
          columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'subject', name: 'subject'},
            {data: 'content', name: 'content'},
            {data: 'name', name: 'name'},
            {data: 'recipient_role', name: 'recipient_role'},
          ]
      });
  });

  const capitalize = (s) => {
    if (typeof s !== 'string') return ''
    return s.charAt(0).toUpperCase() + s.slice(1)
  }
</script>
@endsection
