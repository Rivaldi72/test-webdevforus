@extends('partials.master')

@section('title', 'Member')

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
                                    Member
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <button class="btn btn-success" onclick="createData()">
                                            Tambah Data
                                        </button>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button class="btn btn-warning" onclick="showModalImportData()">
                                            Import Data
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive pt-2">
                                    <table class="table table-bordered table-active" id="list-datatables">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Grup</th>
                                                <th>Alamat</th>
                                                <th>No Telepon</th>
                                                <th>Email</th>
                                                <th>Foto Profil</th>
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
<div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="modalDataLabel" aria-hidden="true" data-backdrop="static">
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
                        <input type="hidden" readonly id="memberId">
                   </div>
                   <div class="form-group col-12">
                        <label for="">Alamat</label>
                        <input type="text" class="form-control" name="address" id="address">
                   </div>
                   <div class="form-group col-12">
                        <label for="">No Telepon</label>
                        <input type="text" class="form-control" name="phone" id="phone">
                   </div>
                   <div class="form-group col-12">
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="email" id="email">
                   </div>
                   <div class="form-group col-12">
                        <label for="">Foto Profil</label>
                        <input type="text" class="form-control" name="profile_pic" id="profile_pic">
                   </div>
                   <div class="form-group col-6">
                    <label for="">Group</label>
                    <select class="form-control" name="group_id" id="group_id">
                        @foreach ($groups as $group)
                            <option value="{{$group->id}}">{{$group->name}}</option>
                        @endforeach
                    </select>
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
<div class="modal fade" id="modalImportData" tabindex="-1" role="dialog" aria-labelledby="modalImportDataLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <form action="import" method="POST" enctype="multipart/form-data" id="formImport">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase " id="modalDataLabel">Import Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @csrf
                        <div class="form-group col-12">
                            <label for="file" class=" form-control-label">File input</label>
                            <input type="file" id="file" name="file" class="form-control-file"accept=".csv">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="button" class="btn btn-primary" id="importData" data-action="import" type="submit">Import</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- end modal static -->
@endsection

@section('javascript')
<script>
    $('#importData').click(function (e) { 
        $('#formImport').submit();        
    });
    const createData = () => {
        $('#submitData').attr('data-action', 'add')
        $('#modalData').modal('toggle')

        $('#memberId').val(null)
    }

    const showModalImportData = () => {
        $('#importData').attr('data-action', 'import')
        $('#modalImportData').modal('toggle')
    }

    const updateData = (e) => {
        const data  = $(e).data()

        $('#submitData').attr('data-action', 'update')
        $('#modalData').modal('toggle')

        $('#memberId').val(data.id)
        $('#name').val(data.name)
        $('#address').val(data.address)
        $('#phone').val(data.phone)
        $('#email').val(data.email)
        $('#profile_pic').val(data.profile_pic)
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
                    "{{route('member.destroy', 'memberId')}}".replace("memberId", id)
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
        const action    = $(e).attr('data-action')
        const groupId   = document.getElementById('group_id');
        const name      = document.getElementById('name');
        const address   = document.getElementById('address');
        const phone     = document.getElementById('phone');
        const email     = document.getElementById('email');
        const profile_pic  = document.getElementById('profile_pic');
        switch(action){
            case 'add':
                ajaxRequest(
                    'POST',
                    "{{route('member.store')}}",
                    {
                        group_id: groupId.value,
                        name: name.value,
                        address: address.value,
                        phone: phone.value,
                        email: email.value,
                        profile_pic: profile_pic.value,
                    }
                ).then((result) => {
                    if(result.status) {
                        toastr.success('Berhasil Menambahkan Data')
                        listData.ajax.reload()
                        $('#modalData').modal('toggle')
                        groupId.value = ''
                        name.value = ''
                        address.value = ''
                        phone.value = ''
                        email.value = ''
                    } else {
                        toastr.error('Gagal Menambahkan Data')
                    }
                }).catch((err) => {
                    toastr.error('Gagal Menambahkan Data')
                })
            break;
            case 'update': 
                const memberId = document.getElementById("memberId").value
                ajaxRequest(
                    'PUT',
                    "{{route('member.update', 'memberId')}}".replace("memberId", memberId),
                    {
                        group_id: groupId.value,
                        name: name.value,
                        address: address.value,
                        phone: phone.value,
                        email: email.value,
                        profile_pic: profile_pic.value,
                    }
                ).then((result) => {
                    if(result.status) {
                        toastr.success('Berhasil Memperbarui Data')
                        listData.ajax.reload()
                        $('#modalData').modal('toggle')
                        groupId.value = ''
                        name.value = ''
                        address.value = ''
                        phone.value = ''
                        email.value = ''
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
            {data: 'group.name', name: 'group.name'},
            {data: 'address', name: 'address'},
            {data: 'phone', name: 'phone'},
            {data: 'email', name: 'email'},
            {data: 'profile_pic', name: 'profile_pic'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action'},
        ]
    })
</script>
@endsection