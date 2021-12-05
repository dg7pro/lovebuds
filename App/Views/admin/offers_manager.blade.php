@extends('layouts.app')

@section('content')

    <!-- users section -->
    <section class="main">

        <h3 class="text-blue">
            Groups List
        </h3>

        <div class="row mt-3">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="{{'/'}}">JuMatrimony</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/index'}}">Admin Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Offers List</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div id="action_div">
            <button onclick="showNewOfferForm()" type="button" class="mb-1 btn btn-sm btn-primary">Add Offer +</button>
        </div>
        <div class="form-group">
            <input type="text" id="search_box" name="search_box" class="form-control"
                   placeholder="Type your search query here...">
        </div>
        <div class="table-responsive" id="dynamic_content"></div>

    </section>
    <!-- users section ends -->

    <!-- New Group Modal -->
    <div class="modal fade" id="modal-new-offer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Group Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="new-offer-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="new-offer-name">
                        </div>
                        <div class="form-group">
                            <label for="new-offer-code" class="col-form-label">Code:</label>
                            <input type="text" class="form-control" id="new-offer-code">
                        </div>


                        <div class="form-group form-row">
                            <div class="col">
                                <label for="new-offer-base-price" class="col-form-label">Base Price:</label>
                                <input type="text" class="form-control" id="new-offer-base-price">
                            </div>
                            <div class="col">
                                <label for="new-offer-rate" class="col-form-label">Rate:</label>
                                <input type="text" class="form-control" id="new-offer-rate">
                            </div>
                            <div class="col">
                                <label for="new-offer-price" class="col-form-label">Offer Price:</label>
                                <input type="text" class="form-control" id="new-offer-price">
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <div class="col">
                                <label for="new-offer-image" class="col-form-label">Image:</label>
                                <input type="text" class="form-control" id="new-offer-image">
                            </div>

                            <div class="col">
                                <label for="new-group-status" class="col-form-label">Status:</label>
                                <select class="form-control" id="new-group-status">
                                    <option value="">Select</option>
                                    <option value=0 selected>Hidden (By Default)</option>
                                    <option value=1>Published</option>
                                </select>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="createNewOffer()">Create Offer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Group Modal -->
    <div class="modal fade" id="modal-offer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Group Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="offer-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="offer-name">
                        </div>
                        <div class="form-group">
                            <label for="offer-code" class="col-form-label">Code:</label>
                            <input type="text" class="form-control" id="offer-code">
                        </div>
                        {{--<div class="form-group">

                        </div>--}}
                        <div class="form-group form-row">
                            <div class="col">
                                <label for="group-name" class="col-form-label">Price:</label>
                                <input type="text" class="form-control" id="base-price">
                            </div>
                            <div class="col">
                                <label for="group-name" class="col-form-label">Rate:</label>
                                <input type="text" class="form-control" id="offer-rate">
                            </div>
                            <div class="col">
                                <label for="group-name" class="col-form-label">Offer Price:</label>
                                <input type="text" class="form-control" id="offer-price">
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <div class="col">
                                <label for="offer-image" class="col-form-label">Image:</label>
                                <input type="text" class="form-control" id="offer-image">
                            </div>
                            <div class="col">
                                <label for="offer-status" class="col-form-label">Status:</label>
                                <select class="form-control" id="offer-status">
                                    <option value="">Select</option>
                                    <option value=0>Expired(Off)</option>
                                    <option value=1>Running(On)</option>
                                </select>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateOfferInfo()">Update Offer</button>
                    <input type="hidden" name="" id="offer-id">

                </div>
            </div>
        </div>
    </div>



@endsection

@section('js')
    <script>
        $(document).ready(function (){

            load_data(1);

        });

        function load_data(page, query=''){
            $.ajax({
                url: "/Adjax/search-offer",
                method: "POST",
                data:{
                    page:page,
                    query:query
                },
                success:function(data){
                    $('#dynamic_content').html(data);
                }
            });
        }

        $(document).on('click', '.page-link', function(){
            var page = $(this).data('page_number');
            var query = $('#search_box').val();
            load_data(page, query);
        });

        $('#search_box').keyup(function(){
            var query = $('#search_box').val();
            load_data(1, query);
        });

    </script>

    <script>
        function showNewOfferForm(){
            $('#modal-new-offer').modal("show");
        }

        function createNewOffer(){

            var name = $('#new-offer-name').val();
            var code = $('#new-offer-code').val();
            var base_price = $('#new-offer-base-price').val();
            var rate = $('#new-offer-rate').val();
            var offer_price = $('#new-offer-price').val();
            var image = $('#new-offer-image').val();
            var status = $('#new-group-status').val();

            $.post("/adjax/insertNewOfferRecord",{
                name:name,
                code:code,
                base_price:base_price,
                rate:rate,
                offer_price:offer_price,
                image:image,
                status:status

            },function (data, status) {
                console.log(data);
                $('#modal-new-offer').modal("hide");
                load_data(1);
            });
        }

    </script>

    <script>
        function getOfferInfo(id){
            console.log(id);
            $('#offer_id').val(id);
            $.post("/adjax/fetchSingleOfferRecord",{offerId:id},function (data, status) {

                console.log(data);
                var offer = JSON.parse(data);
                $('#offer-name').val(offer.offer_name);
                $('#offer-code').val(offer.offer_code);
                $('#base-price').val(offer.base_price);
                $('#offer-rate').val(offer.discount_rate);
                $('#offer-price').val(offer.discount_price);
                $('#offer-image').val(offer.image);
                $('#offer-status').val(offer.status);
                $('#offer-id').val(offer.id);

            });
            $('#modal-offer').modal("show");
        }

        function updateOfferInfo(){

            var name = $('#offer-name').val();
            var code = $('#offer-code').val();
            var b_price = $('#base-price').val();
            var rate = $('#offer-rate').val();
            var o_price = $('#offer-price').val();
            var image = $('#offer-image').val();
            var status = $('#offer-status').val();
            var id = $('#offer-id').val();
            $.post("/adjax/updateSingleOfferRecord",{
                name:name,
                code:code,
                b_price:b_price,
                rate:rate,
                o_price:o_price,
                image:image,
                status:status,
                id:id

            },function (data, status) {
                console.log(data);
                $('#modal-offer').modal("hide");
                load_data(1);
            });
        }
    </script>

@endsection
