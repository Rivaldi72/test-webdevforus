@extends('partials.master')
@section('title', 'DASHBOARD')

@section('custom_styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
        }

        img {
            margin-left: auto;
            margin-right: auto;
            display: block;
        }

        #over{
            position:absolute; 
            width:100%; 
            height:100%"
        }

        .title{
            margin: auto;
            display: block;
        }

        .description {
            margin-top: auto;
            margin-bottom: auto;
            display: block;
        }

        .buy-box{
            padding: 5px;
            border: 1px solid #8fca8e;
            width: 60px;
            text-align: center;
            background: #8fca8e;
            color: white;
        }

        .dialog-box {
            border: 1px solid #8fca8e;
            border-radius: 10px;
            margin: 0 5px;
            height: 550px;
        }
    </style>
@endsection

@section('custom_scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#title').select2({
            placeholder: "Pilih Nama Produk...",
            allowClear: true,
            ajax: {
                url: '',
                data: function(params) {
                    var query = {
                        search: params.term,
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
            }
        });
        


        const openModal = () => {
            $('#staticModal').modal({
                'show': true
            })
        }
    </script>
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row m-t-25">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="title" style="color: white">WebDevForus</h4>
                            </div>
                            <div class="card-footer text-center">
                                {{date('Y')}} @ WebDevForus
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

@endsection
