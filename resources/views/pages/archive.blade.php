<x-layoutNav body-class="body-blur">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-5" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-5" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container mt-5 w-75">
        <div class="row">
            <div class="col-12 m-4">
                <div class="gradient-rectangle p-3 rounded-4 text-white bg-danger ">
                    <small>{{ now()->format('F d, Y') }}</small>
                    <h4 class="mt-3 mb-1">Welcome back, {{ Auth::user()->name }}!</h4>
                    <p class="mb-0">Long time no sheet!</p>
                </div>
                <div class="form-group d-flex mt-2 gap-2">
                    <div class="d-flex bg-white border-1 justify-content-center align-items-center rounded-3 text-muted">
                        <span class="ms-2"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg></span>
                        <input class="form-control form-control-sm border-0 rounded-3" id="searchInput" type="text" placeholder="Search">
                    </div>

                    <div class="dropdown">
                        <button class="btn dropdown-toggle d-flex align-items-center gap-1 bg-white rounded-3 text-muted" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: .9rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                            </svg>
                            Sort by
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm" style="min-width:120px;padding:4px;border-radius:10px;font-size:.8rem;">
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route("show.archive", ["order" => "date"]) }}" style="padding:5px 8px;border-radius:7px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="currentColor" style="opacity:.55" viewBox="0 0 16 16">
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                                    </svg>
                                    Date
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route("show.archive", ["order" => "ASC"]) }}" style="padding:5px 8px;border-radius:7px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="currentColor" style="opacity:.55" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371zm1.57-.785L11 2.687h-.047l-.652 2.157z"/>
                                        <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293z"/>
                                    </svg>
                                    A → Z
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route("show.archive", ["order" => "DESC"]) }}" style="padding:5px 8px;border-radius:7px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="currentColor" style="opacity:.55" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371zm1.57-.785L11 2.687h-.047l-.652 2.157z"/>
                                        <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645zm-8.46-.5a.5.5 0 0 1-1 0V3.707L2.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.5.5 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L4.5 3.707z"/>
                                    </svg>
                                    Z → A
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card mt-2 p-4 shadow-lg">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-files" viewBox="0 0 16 16">
                                    <path d="M13 0H6a2 2 0 0 0-2 2 2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 2 2 0 0 0 2-2V2a2 2 0 0 0-2-2m0 13V4a2 2 0 0 0-2-2H5a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1M3 4a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/>
                                </svg>
                            </th>
                            <th scope="col">Title</th>
                            <th scope="col">Topic</th>
                            <th scope="col">Category</th>
                            <th scope="col">Edited</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $number = 1;
                        @endphp
                        @foreach($worksheets as $worksheet)
                            <tr class="content-row">
                                <th scope="row">{{ $number++ }}</th>
                                <td class="search-td">{{ $worksheet->title }}</td>
                                <td>{{ $worksheet->theme }}</td>
                                <td>{{ $worksheet->level }}</td>
                                <td>{{ $worksheet->updated_at }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <form class="m-0 p-0" method="POST" action="{{ route('editor.show') }}">
                                            @csrf
                                            <input type="hidden" name="wsht-id" value="{{ $worksheet->id }}">
                                            <button type="submit" class="btn m-0 me-2 p-0" title="Edit the worksheet">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                </svg>
                                            </button>
                                        </form>
                                        <form class="m-0 p-0" method="POST" action="{{ route('editor.deleteWorksheet') }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="wsht-id" value="{{ $worksheet->id }}">
                                            <button type="submit" class="btn m-1 p-0 text-danger" title="Delete the worksheet">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layoutNav>
