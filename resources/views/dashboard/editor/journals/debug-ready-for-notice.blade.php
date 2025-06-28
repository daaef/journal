<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug - Ready for Notice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/phosphor-icons@1.4.2/src/css/icons.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h2>Debug - Ready for Notice</h2>
                <p><strong>Journals Count:</strong> {{ $journals->count() }}</p>
                
                @if($journals->count() > 0)
                    <div class="alert alert-success">
                        Found {{ $journals->count() }} manuscript(s) ready for notice
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th>UUID</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($journals as $journal)
                                    <tr>
                                        <td>{{ $journal->title }}</td>
                                        <td>{{ $journal->author }}</td>
                                        <td>{{ $journal->status }}</td>
                                        <td>{{ $journal->uuid }}</td>
                                        <td>
                                            <a href="{{ route('editor.journals.preview', [$journal->uuid, $journal->slug]) }}" 
                                               class="btn btn-sm btn-primary">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning">
                        No manuscripts found ready for notice
                    </div>
                @endif
                
                <hr>
                <h3>Debug Information</h3>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Route Information</h5>
                        <ul>
                            <li><strong>Current Route:</strong> {{ Route::currentRouteName() }}</li>
                            <li><strong>Preview Route:</strong> {{ route('editor.journals.preview', ['uuid' => 'test', 'slug' => 'test']) }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5>User Information</h5>
                        <ul>
                            <li><strong>User ID:</strong> {{ auth()->id() }}</li>
                            <li><strong>User Email:</strong> {{ auth()->user()->email ?? 'Not logged in' }}</li>
                            @if(auth()->user())
                                <li><strong>User Roles:</strong> {{ auth()->user()->roles->pluck('name')->join(', ') }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
