@extends('partials.master')

@section('title', 'Group')

@section('custom_styles')

@endsection

@section('custom_scripts')
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-uppercase">
                                    Group
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-success" onclick="createData()">
                                            Tambah Data
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive pt-2">
                                    <table class="table table-bordered table-active" id="list-datatables">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Group</th>
                                                <th>Kota</th>
                                                <th>Dibuat Pada</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

@section('modal')
<!-- modal static -->
<div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="modalDataLabel" aria-hidden="true"
data-backdrop="static">
   <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title text-uppercase " id="modalDataLabel">Tambah Data</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
               <div class="row">
                   <div class="form-group col-12">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" name="name" id="name">
                        <input type="hidden" readonly id="groupId">
                   </div>
                   <div class="form-group col-12">
                        <label for="">City</label>
                        <input type="text" class="form-control" name="city" id="city">
                   </div>
               </div>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
               <button type="button" class="btn btn-primary" id="submitData" data-action="add" onclick="submitData(this)">Simpan</button>
           </div>
       </div>
   </div>
</div>
<!-- end modal static -->
@endsection

@section('javascript')
<script>
    const createData = () => {
        $('#submitData').attr('data-action', 'add')
        $('#modalData').modal('toggle')

        $('#groupId').val(null)
    }

    const updateData = (e) => {
        const data  = $(e).data()
        console.table(data)

        $('#submitData').attr('data-action', 'update')
        $('#modalData').modal('toggle')

        $('#groupId').val(data.id)
        $('#name').val(data.name)
        $('#city').val(data.city)
    }

    const deleteData = (e) => {
        const id = $(e).data('id')
        Swal.fire({
            title: 'Apakah anda yakin akan menghapus data ini?',
            text: "Data yang telah dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Ya, Hapus Data!'
        }).then((result) => {
            if (result.isConfirmed) {
                ajaxRequest(
                    'DELETE',
                    "{{route('group.destroy', 'groupId')}}".replace("groupId", id)
                ).then((result) => {
                    toastr.success('Berhasil Menghapus Data')
                    listData.ajax.reload()
                }).catch((err) => {
                    toastr.error('Gagal Menghapus Data')
                })
            }
        })
    }

    const submitData = (e) => {
        const action = $(e).attr('data-action')
        const name  = document.getElementById('name');
        const city  = document.getElementById('city');
        switch(action){
            case 'add':
                ajaxRequest(
                    'POST',
                    "{{route('group.store')}}",
                    {
                        name: name.value,
                        city: city.value,
                    }
                ).then((result) => {
                    if(result.status) {
                        toastr.success('Berhasil Menambahkan Data')
                        listData.ajax.reload()
                        $('#modalData').modal('toggle')
                        name.value = ''
                        city.value = ''
                    } else {
                        toastr.error('Gagal Menambahkan Data')
                    }
                }).catch((err) => {
                    toastr.error('Gagal Menambahkan Data')
                })
            break;
            case 'update': 
                const groupId = document.getElementById("groupId").value
                ajaxRequest(
                    'PUT',
                    "{{route('group.update', 'groupId')}}".replace("groupId", groupId),
                    {
                        name: name.value,
                        city: city.value,
                    }
                ).then((result) => {
                    if(result.status) {
                        toastr.success('Berhasil Memperbarui Data')
                        listData.ajax.reload()
                        $('#modalData').modal('toggle')
                        name.value = ''
                        city.value = ''
                    } else {
                        toastr.error('Gagal Memperbarui Data')
                    }
                }).catch((err) => {
                    toastr.error('Gagal Memperbarui Data')
                })
            break;
        }
    }

    const listData = $('#list-datatables').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        fixedColumns:   {
            heightMatch: 'none'
        },
        ajax: {
            url: '',
            data: (req) => {
               
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'city', name: 'city'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action'},
        ]
    })
</script>
@endsection