@extends('layouts.app')
@section('title', 'Task List')
@section('content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header mb-0">List Tugas</h5>
            <button type="button" class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#modalTambahTugas">
                Tambah Tugas
            </button>
        </div>
        
        <!-- Modal Tambah Tugas -->
        <div class="modal fade" id="modalTambahTugas" tabindex="-1" aria-labelledby="modalTambahTugasLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('tasks.store') }}" method="POST" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahTugasLabel">Tambah Tugas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Nama Tugas</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Belum Selesai">Belum Selesai</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center" style="max-width: 300px;">
            <form action="{{ route('tasks.index') }}" method="GET" class="w-100 align-items-center">
            <span for="status" class="me-2 mb-0">Filter by Status</span>
            <select id="status" name="status" class="form-select me-2">
                <option value="">Semua Status</option>
                <option value="Belum Selesai" {{ request('status') == 'Belum Selesai' ? 'selected' : '' }}>Belum Selesai</option>
                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            </form>
        </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Tugas</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->description }}</td>
                                <td>
                                    @if ($task->status == 'belum selesai')
                                        <span class="badge bg-label-danger me-1">{{ $task->status }}</span>
                                    @else
                                        <span class="badge bg-label-primary me-1">{{ $task->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown"><i
                                                class="icon-base bx bx-dots-vertical-rounded"></i></button>
                                        <div class="dropdown-menu">
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#modalUpdateTugas{{ $task->id }}"
                                                class="dropdown-item dropdown-item-edit">
                                                <i class="icon-base bx bx-edit-alt me-1"></i> Edit
                                            </button>
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                data-bs-target="#modalDeleteTugas{{ $task->id }}">
                                                <i class="icon-base bx bx-trash me-1"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            {{-- modal update tugas --}}
                            <div class="modal fade" id="modalUpdateTugas{{ $task->id }}" tabindex="-1"
                                aria-labelledby="modalUpdateTugasLabel{{ $task->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('tasks.update', $task->id) }}" method="POST"
                                        class="modal-content">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalUpdateTugasLabel{{ $task->id }}">Update
                                                Tugas</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="update_title{{ $task->id }}" class="form-label">Nama
                                                    Tugas</label>
                                                <input type="text" class="form-control"
                                                    id="update_title{{ $task->id }}" name="title" required
                                                    value="{{ $task->title }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="update_description{{ $task->id }}"
                                                    class="form-label">Deskripsi</label>
                                                <textarea class="form-control" id="update_description{{ $task->id }}" name="description" rows="3"
                                                    required>{{ $task->description }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="update_status{{ $task->id }}"
                                                    class="form-label">Status</label>
                                                <select class="form-select" id="update_status{{ $task->id }}"
                                                    name="status" required>
                                                    <option value="Belum Selesai"
                                                        {{ strtolower($task->status) == 'belum selesai' ? 'selected' : '' }}>
                                                        Belum Selesai</option>
                                                    <option value="Selesai"
                                                        {{ strtolower($task->status) == 'selesai' ? 'selected' : '' }}>
                                                        Selesai
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- modal delete tugas --}}
                            <div class="modal fade" id="modalDeleteTugas{{ $task->id }}" tabindex="-1"
                                aria-labelledby="modalDeleteTugasLabel{{ $task->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                        class="modal-content">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalDeleteTugasLabel{{ $task->id }}">Hapus
                                                Tugas</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Apakah Anda yakin ingin menghapus tugas
                                                <strong>{{ $task->title }}</strong>?
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.table').DataTable();
        });

        $('#status').on('change', function(e) {
            e.preventDefault();
            let status = $(this).val();
            $.ajax({
                url: "{{ route('tasks.index') }}",
                type: "GET",
                data: { status: status },
                success: function(response) {
                    // Ambil tbody baru dari response dan replace tbody lama
                    let html = $(response).find('tbody.table-border-bottom-0').html();
                    $('tbody.table-border-bottom-0').html(html);
                },
                error: function(xhr) {
                    alert('Gagal memfilter data.');
                }
            });
        });
    </script>
@endpush
