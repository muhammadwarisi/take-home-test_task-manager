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
                    <select id="statusFilter" name="status" class="form-select me-2">
                        <option value="">Semua Status</option>
                        <option value="Belum Selesai" {{ request('status') == 'Belum Selesai' ? 'selected' : '' }}>Belum
                            Selesai</option>
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
                            <tr id="task-row-{{ $task->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->description }}</td>
                                <td>
                                    <select class="form-select form-select-sm task-status-dropdown"
                                        data-id="{{ $task->id }}" style="width: 140px; cursor: pointer;">
                                        <option value="Belum Selesai"
                                            {{ strtolower($task->status) == 'belum selesai' ? 'selected' : '' }}>
                                            Belum Selesai
                                        </option>
                                        <option value="Selesai"
                                            {{ strtolower($task->status) == 'selesai' ? 'selected' : '' }}>
                                            Selesai
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown"><i
                                                class="icon-base bx bx-dots-vertical-rounded"></i></button>
                                        <div class="dropdown-menu">
                                            <button class="dropdown-item" data-bs-toggle="modal"
                                                data-bs-target="#updateModal" data-id="{{ $task->id }}">
                                                Edit
                                            </button>
                                            <button type="button" class="dropdown-item btn-delete-task"
                                                data-bs-toggle="modal" data-bs-target="#modalDeleteTugas"
                                                data-id="{{ $task->id }}" <i class="icon-base bx bx-trash me-1"></i>
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- modal update tugas --}}
    <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="updateForm" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="modalTitle" name="title" class="form-control mb-3"
                        placeholder="Judul tugas">
                    <textarea id="modalDesc" name="description" class="form-control mb-3" placeholder="Deskripsi"></textarea>
                    <select id="modalStatus" name="status" class="form-select">
                        <option value="Belum Selesai">Belum Selesai</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Delete Global -->
    <div class="modal fade" id="modalDeleteTugas" tabindex="-1" aria-labelledby="modalDeleteTugasLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDeleteTugasLabel">Hapus Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah kalian yakin ingin menghapus tugas <strong id="taskTitle"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="confirmDelete" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.table').DataTable();
        });

        $(document).on('click', '.dropdown-item-edit', function() {
            var taskId = $(this).data('bs-target').replace('#modalUpdateTugas', '');
            $('#modalUpdateTugas' + taskId).modal('show');
        });

        $('#statusFilter').on('change', function(e) {
            e.preventDefault();
            let status = $(this).val();
            $.ajax({
                url: "{{ route('tasks.index') }}",
                type: "GET",
                data: {
                    status: status
                },
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

        $(document).ready(function() {
            const updateModal = document.getElementById('updateModal');

            updateModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = $(button).data('id'); // Ambil ID task
                const form = $('#updateForm');

                // Reset form sebelum isi ulang
                $('#modalTitle').val('');
                $('#modalDesc').val('');
                $('#modalStatus').val('');

                // Panggil AJAX ke backend
                $.ajax({
                    url: `tasks/${id}/edit`, // endpoint Laravel kamu
                    method: 'GET',
                    success: function(response) {
                        // Asumsikan backend kirim JSON seperti:
                        // { id: 3, title: "Belajar JS", description: "..." }

                        $('#modalTitle').val(response.title);
                        $('#modalDesc').val(response.description);
                        $('#modalStatus').val(response.status);

                        // Ubah action form untuk update
                        form.attr('action', `/tasks/${id}`);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Gagal memuat data tugas');
                    }
                });
            });
        });

        $(document).ready(function() {
            let deleteId = null; // simpan id task yang akan dihapus

            // Saat tombol hapus diklik
            $('.btn-delete-task').on('click', function() {
                deleteId = $(this).data('id');
                const title = $(this).data('title');

                // isi judul di modal
                $('#taskTitle').text(title);

                // buka modal
                const modal = new bootstrap.Modal(document.getElementById('modalDeleteTugas'));
                modal.show();
            });

            // Saat tombol konfirmasi hapus ditekan
            $('#confirmDelete').on('click', function() {
                if (!deleteId) return;
                console.log(deleteId);
                let url = "{{ route('tasks.destroy', ':id') }}";
                url = url.replace(':id', deleteId);

                $.ajax({
                    url: url, // endpoint delete
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}' // penting untuk keamanan
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Tutup modal
                        const modalEl = document.getElementById('modalDeleteTugas');
                        let modal = bootstrap.Modal.getInstance(modalEl);

                        // kalau belum ada instance, buat baru
                        if (!modal) {
                            modal = new bootstrap.Modal(modalEl);
                        }

                        modal.hide();

                        // bersihkan backdrop setelah animasi
                        setTimeout(() => {
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open').css('overflow', 'auto');
                        }, 300);

                        // Hapus row dari tampilan (kalau ada tabel)
                        $(`#task-row-${deleteId}`).remove();

                        // Swal sukses
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Tugas berhasil dihapus.',
                            icon: 'success',
                            confirmButtonText: 'Oke',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menghapus tugas.',
                            icon: 'error',
                            confirmButtonText: 'Coba Lagi'
                        });

                    }
                });
            });
        });

        $(document).ready(function() {
                    $('.task-status-dropdown').on('change', function() {
                        const dropdown = $(this);
                        const id = dropdown.data('id');
                        const newStatus = dropdown.val();

                        $.ajax({
                            url: `/tasks/${id}/status`,
                            type: 'PUT',
                            data: {
                                _token: '{{ csrf_token() }}',
                                status: newStatus
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Status Diperbarui!',
                                        text: `Tugas sekarang ${response.new_status}.`,
                                        icon: 'success',
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                }
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText);
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat mengubah status.',
                                    icon: 'error',
                                    confirmButtonText: 'Tutup'
                                });
                            }
                        });
                    });
                });
    </script>
@endpush
