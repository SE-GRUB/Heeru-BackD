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
{{-- <a href="{{ route('report.create',  ['report_categories' => $report_categories]) }}" class="btn btn-primary">Add New report</a> --}}
{{-- <table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Title</th>
            <th>Time</th>
            <th>Evidence</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Loop through your users data and populate the table rows -->
        @foreach($reports as $report)
            <tr>
                <td>{{ $report->id}}</td>
                @php
                    $name = DB::table('users')->where('id', $report->user_id)->value('name')
                @endphp
                <td>{{ $name }}</td>
                <td>{{ $report->title}}</td>
                <td>{{ $report->created_at}}</td>
                <td>{{ $report->evidence }}</td>
                

                @php
                    $category_name = DB::table('report_categories')->where('id', $report->category_id)->value('category_name')
                @endphp
                
                <td>{{ $category_name }}</td>

                <td>
                    <a href="{{ route('report.edit', ['report' => $report]) }}" class="btn btn-primary">Edit</a>
                    <form method="post" action="{{ route('report.destroy', ['report' => $report]) }}" style="display: inline-block;">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this report?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table> --}}

<div class="container mt-5">
    <h3>Report #{{$report->id}}</h3>
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
                    <td></td>
                </tr>
                <tr>
                    <td>Why did the incident happened?<br>
                        <i>Mengapa peristiwa ini terjadi ?</i>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Where did the incident happened?<br>
                        <i>Dimana lokasi peristiwa itu terjadi ?</i>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>When did the incident happened?<br>
                        <i>Kapan peristiwa ini terjadi ?</i>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Who is/are involved in the incident?<br>
                        <i>Siapa yang terlibat dalam peristiwa ini ?</i>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Why did the incident happened?<br>
                        <i>Bagaimana kejadian ini terjadi ?</i>
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
  
    <div class="row mt-3">
      <div class="col-md-12">
        <a href="" class="btn btn-primary">Update Status</a>
        @if (!$report->isDone)
            <a href="" class="btn btn-primary">Done</a>
        @endif
      </div>
    </div>
  </div>
@endsection