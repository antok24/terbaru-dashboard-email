@extends('layouts.front')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Pengumuman</h1>
    </div>

    <div class="section-body">

        <div class="row">

            <div class="col-lg-12">
                @forelse ($announcements as $info)
                <div class="card mb-2">
                    <div class="card-body">
                        <li class="media">
                            <div class="media-body">
                                <div class="media-title">{{ $info->subject }}</div>
                                <span class="text-small text-muted">
                                    Pengirim :{{ $info->name }}
                                </span>
                                <span class="text-small text-primary">
                                    {!! $info->content !!}
                                </span>
                            </div>
                        </li>
                    </div>
                </div>
                @empty
                <div class="card mb-2">
                    <div class="card-body">
                        <li class="media">
                            <div class="media-body">
                                <div class="media-title">Tidak ada pengumuman !!!</div>
                            </div>
                        </li>
                    </div>
                </div>
                @endforelse

            </div>
        </div>

    </div>
</section>
@endsection