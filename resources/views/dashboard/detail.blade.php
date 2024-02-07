@extends('backend.layout')

@section('title', 'Report Details')

@section('content')

<div>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>
<a href="javascript:history.back()" class="btn btn-primary">Back</a>
<div class="container mt-5">
    @php
        $statuss = DB::table('status')
            ->where('status.report_id', '=', $report->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $status = $statuss->first();

        $statusClass = '';

        switch ($status->status) {
            case 'sent': 
                $statusClass = 'btn btn-secondary';
                break;
            case 'on process':
                $statusClass = 'btn btn-warning';
                break;
            case 'done':
                $statusClass = 'btn btn-success';
                break;
        }
    @endphp
    <h3 style="display: inline-block; margin-right: 10px;">Report #{{$report->id}}</h3>
    <button class="{{ $statusClass }}" disabled>{{ ucwords($status->status) }}</button>
    <h5><b>I. Whistleblower details</b></h5>
    <table class="table">
    @php
        $user = DB::table('users')
            ->join('programs', 'users.program_id', '=', 'programs.id')
            ->where('users.id', $report->user_id)
            ->select('users.nip', 'users.name', 'programs.program_name', 'users.no_telp', 'users.email')
            ->first();
    @endphp
        <tbody>
            <tr>
                <td>NIP</td>
                <td>{{$user->nip}}</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>{{$user->name}}</td>
            </tr>
            <tr>
                <td>Program</td>
                <td>{{$user->program_name}}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{$user->email}}</td>
            </tr>
            <tr>
                <td>No. Telp</td>
                <td>{{$user->no_telp}}</td>
            </tr>
        </tbody>
    </table>

    <h5><b>II. Report details</b></h5>
    <table class="table">
    @php
        $user = DB::table('users')
            ->join('programs', 'users.program_id', '=', 'programs.id')
            ->where('users.id', $report->user_id)
            ->select('users.nip', 'users.name', 'programs.program_name', 'users.no_telp', 'users.email')
            ->first();

            
            $data = json_decode($report->details);
    @endphp
        <tbody>
            <tr>
                <td>Report Category</td>
                <td>{{
                    DB::table('report_categories')->where('report_categories.id', '=', $report->category_id)->value('category_name')
                    }}
                </td>
            </tr>
            <tr>
            <td>Report Title</td>
            <td>{{$report->title}}</td>
            </tr>
            <tr>
                <td>What is the incident?<br>
                    <i>Apa yang terjadi ?</i>
                </td>
                <td>{{ isset($data->w1) ? $data->w1 : '' }}</td>
            </tr>
            <tr>
                <td>Why did the incident happened?<br>
                    <i>Mengapa peristiwa ini terjadi ?</i>
                </td>
                <td>{{ isset($data->w2) ? $data->w2 : '' }}</td>
            </tr>
            <tr>
                <td>Where did the incident happened?<br>
                    <i>Dimana lokasi peristiwa itu terjadi ?</i>
                </td>
                <td>{{ isset($data->w3) ? $data->w3 : '' }}</td>
            </tr>
            <tr>
                <td>When did the incident happened?<br>
                    <i>Kapan peristiwa ini terjadi ?</i>
                </td>
                <td>{{ isset($data->w4) ? $data->w4 : '' }}</td>
            </tr>
            <tr>
                <td>Who is/are involved in the incident?<br>
                    <i>Siapa yang terlibat dalam peristiwa ini ?</i>
                </td>
                <td>{{ isset($data->w5) ? $data->w5 : '' }}</td>
            </tr>
            <tr>
                <td>How did the incident happened?<br>
                    <i>Bagaimana kejadian ini terjadi ?</i>
                </td>
                <td>{{ isset($data->h1) ? $data->h1 : '' }}</td>
            </tr>
        </tbody>
    </table>
    <h5><b>III. Evidence</b></h5>
    {{-- <div id="imageContainer">
        @php
            $evidences = json_decode($report->evidence)
        @endphp
        @foreach ($evidences as $evidence)
            <img style="width: 500px" src="http://127.0.0.1:8000/{{ $evidence }}" alt="">
        @endforeach
    </div> --}}

    <div id="evidenceContainer">
        <ul class="list-group">
            @php
                $evidences = json_decode($report->evidence);
            @endphp
            @foreach ($evidences as $evidence)
                <li class="list-group-item">
                    <a href="{{ asset($evidence) }}" target="_blank">{{ basename($evidence) }}</a>
                </li>
            @endforeach
        </ul>
    </div>
    <h5><b>IV. Report Status</b></h5>
    <table class="table">
        <thead>
            <tr>
                <th>Timestamp</th>
                <th>Status</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statuss as $status)
            <tr>
                <td>{{ $status->created_at }}</td>
                <td>{{  ucwords($status->status) }}</td>
                <td>{{ $status->note }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if (!$report->isDone)
    <div class="row mt-3">
      <div class="col-md-12">
        @if (!$report->isProcess)
            <form method="post" action="{{ route('status.store') }}" style="display: inline-block;">
                @csrf
                <input type="hidden" name="report_id" value="{{ $report->id }}">
                <input type="hidden" name="status" value="on progress">
                <input type="hidden" name="note" value="Laporan ini sedang diproses oleh PIC">
                <button type="submit" class="btn btn-info">Process</button>
            </form>
        @else
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#statusModal">
                Update Status
            </button>
            <form method="post" action="{{ route('status.store') }}" style="display: inline-block;">
                @csrf
                <input type="hidden" name="report_id" value="{{ $report->id }}">
                <input type="hidden" name="status" value="done">
                <input type="hidden" name="note" value="Laporan telah selesai">
                <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to finish this report?')">Done</button>
            </form>
        @endif
        </div>
    </div>
    @endif    
  </div>
@endsection

<!-- Update StatusModal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Update Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your form goes here -->
                <form method="post" action="{{ route('status.store') }}">
                    @csrf
                    @method('post')
                    <input type="hidden" name="report_id" value="{{$report->id}}">

                    <input type="hidden" name="status" value="on progress">

                    <div class="form-group">
                        <label for="note">Note:</label>
                        <textarea class="form-control" id="note" name="note" rows="4" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>